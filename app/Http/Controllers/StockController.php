<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockMovementController extends Controller
{
    /**
     * Liste les mouvements pour une destination.
     */
    public function index(Destination $destination)
    {
        $movements = $destination->stockMovements()->paginate(10);
        return view('stock_movements.index', compact('destination', 'movements'));
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create(Destination $destination)
    {
        return view('stock_movements.create', compact('destination'));
    }

    /**
     * Enregistre un nouveau mouvement de stock.
     */
    public function store(Request $request, Destination $destination)
    {
        $validated = $request->validate([
            'type'     => 'required|in:in,out',
            'quantity' => 'required|numeric|min:0.01',
            'notes'    => 'nullable|string',
        ]);

        DB::transaction(function () use ($destination, $validated) {
            $lastRemaining = $destination->stockMovements()->latest()->value('remaining') ?? 0;

            $newRemaining = $validated['type'] === 'in'
                ? $lastRemaining + $validated['quantity']
                : $lastRemaining - $validated['quantity'];

            if ($newRemaining < 0) {
                abort(400, 'Stock insuffisant pour un mouvement sortant.');
            }

            StockMovement::create([
                'destination_id' => $destination->id,
                'type'           => $validated['type'],
                'quantity'       => $validated['quantity'],
                'remaining'      => $newRemaining,
                'notes'          => $validated['notes'] ?? null,
            ]);
        });

        return redirect()->route('destinations.stock.index', $destination)->with('success', 'Mouvement enregistré avec succès.');
    }

    /**
     * Supprime un mouvement de stock.
     */
    public function destroy(StockMovement $stockMovement)
    {
        $stockMovement->delete();

        return back()->with('success', 'Mouvement supprimé.');
    }
}

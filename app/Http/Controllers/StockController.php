<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    /**
     * Liste les mouvements pour une destination.
     */
    public function index(Destination $destination)
    {
        if ($destination->user_id !== Auth::id()) {
            abort(403); // ou redirect avec erreur
        }
        
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
                return back()->withErrors('Suppression invalide : cela entraînerait un stock négatif.');
            }
            $validated['user_id'] = Auth::id(); // Ajout de l'utilisateur courant
            StockMovement::create([
                'destination_id' => $destination->id,
                'user_id'        => $validated['user_id'],
                'type'           => $validated['type'],
                'quantity'       => $validated['quantity'],
                'remaining'      => $newRemaining,
                'notes'          => $validated['notes'] ?? null,
            ]);
        });

        return redirect()->route('destinations.stock.index', $destination)->with('success', 'Mouvement enregistré avec succès.');
    }
    /**
 * Met à jour un mouvement de stock existant.
 */
public function update(Request $request, StockMovement $stockMovement)
{
    // Vérifie que l'utilisateur est bien propriétaire
    if ($stockMovement->destination->user_id !== auth()->id()) {
        abort(403);
    }

    $validated = $request->validate([
        'type'     => 'required|in:in,out',
        'quantity' => 'required|numeric|min:0.01',
        'notes'    => 'nullable|string',
    ]);

    DB::transaction(function () use ($stockMovement, $validated) {
        $destination = $stockMovement->destination;

        // Met à jour les valeurs du mouvement
        $stockMovement->update([
            'type'     => $validated['type'],
            'quantity' => $validated['quantity'],
            'notes'    => $validated['notes'] ?? null,
        ]);

        // Recalculer les remaining pour tous les mouvements de la destination
        $remaining = 0;

        $allMovements = $destination->stockMovements()->orderBy('id')->get();

        foreach ($allMovements as $movement) {
            if ($movement->type === 'in') {
                $remaining += $movement->quantity;
            } else {
                $remaining -= $movement->quantity;
            }

            // Si le stock devient négatif, rollback
            if ($remaining < 0) {
                throw new \Exception('Modification invalide : cela entraînerait un stock négatif.');
            }

            $movement->update(['remaining' => $remaining]);
        }
    });

    return back()->with('success', 'Mouvement mis à jour avec succès.');
}


    /**
     * Supprime un mouvement de stock.
     */
    public function destroy(StockMovement $stockMovement)
    {
        // Vérifie que l'utilisateur est bien propriétaire
        if ($stockMovement->destination->user_id !== auth()->id()) {
            abort(403);
        }
    
        $destination = $stockMovement->destination;
    
        DB::transaction(function () use ($stockMovement, $destination) {
            // Supprime le mouvement
            $stockMovement->delete();
    
            // Récupère tous les mouvements après le mouvement supprimé, y compris celui juste avant
            $allMovements = $destination->stockMovements()->orderBy('id')->get();
    
            $remaining = 0;
    
            foreach ($allMovements as $movement) {
                if ($movement->type === 'in') {
                    $remaining += $movement->quantity;
                } else {
                    $remaining -= $movement->quantity;
                }
    
                // Si le stock devient négatif, on bloque
                if ($remaining < 0) {
                    abort(400, 'Suppression invalide : cela entraînerait un stock négatif.');
                }
    
                // Met à jour le champ `remaining`
                $movement->update(['remaining' => $remaining]);
            }
        });
    
        return back()->with('success', 'Mouvement supprimé et stock ajusté.');
    }
    
}

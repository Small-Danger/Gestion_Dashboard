<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Destination;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class CompanyController extends Controller
{
    /**
     * Affiche la liste des compagnies.
     */
    public function index()
    {
        $companies = Company::latest()->paginate(10);
        return view('companies.index', compact('companies'));
    }

    /**
     * Affiche le formulaire de création d'une compagnie.
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Enregistre une nouvelle compagnie.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:companies,name',
            'logo'        => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'stock'    => 'nullable|numeric|min:0',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Company::create($validated);

        return redirect()->route('companies.index')->with('success', 'Compagnie ajoutée avec succès.');
    }

    /**
     * Affiche le formulaire d'édition.
     */
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    /**
     * Met à jour une compagnie existante.
     */
    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:companies,name,' . $company->id,
            'logo'        => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'stock'    => 'nullable|numeric|min:0',
        ]);

        if ($request->hasFile('logo')) {
            // Supprimer l'ancien logo si présent
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $company->update($validated);

        return redirect()->route('companies.index')->with('success', 'Compagnie mise à jour avec succès.');
    }

    /**
     * Supprime une compagnie.
     */
    public function destroy(Company $company)
    {
        // Supprimer le logo si présent
        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
        }

        $company->delete();

        return back()->with('success', 'Compagnie supprimée avec succès.');
    }
    public function stockIndex()
    {
        $companies = Company::withCount('destinations')
            ->with('destinations')
            ->paginate(10);
        
        $totalStock = Destination::sumCurrentStock();
        
        return view('companies.stock', compact('companies', 'totalStock'));
    }


    // Dans CompanyController.php
public function stockDestinations(Company $company)
{
    $destinations = $company->destinations()
        ->withCount('stockMovements')
        ->with(['stockMovements' => function($query) {
            $query->latest()->limit(1);
        }])
        ->paginate(10);

    // Récupérer tous les mouvements avec filtre optionnel
    $movementsQuery = StockMovement::whereIn('destination_id', $company->destinations->pluck('id'))
        ->with('destination')
        ->latest();

    if(request('destination_id')) {
        $movementsQuery->where('destination_id', request('destination_id'));
    }

    $movements = $movementsQuery->paginate(10);

    return view('companies.stock', compact('company', 'destinations', 'movements'));
}

public function storeStock(Request $request, Company $company)
{
    $validated = $request->validate([
        'destination_id' => 'required|exists:destinations,id,company_id,'.$company->id,
        'type' => 'required|in:in,out',
        'quantity' => 'required|numeric|min:0.01',
        'notes' => 'nullable|string',
    ]);

    DB::transaction(function () use ($validated) {
        $destination = Destination::find($validated['destination_id']);
        $lastRemaining = $destination->stockMovements()->latest()->value('remaining') ?? 0;

        $newRemaining = $validated['type'] === 'in'
            ? $lastRemaining + $validated['quantity']
            : $lastRemaining - $validated['quantity'];

        if ($newRemaining < 0) {
            return back()->withErrors(['quantity' => 'Stock insuffisant pour ce mouvement sortant.'])->withInput();
        }

        StockMovement::create([
            'destination_id' => $validated['destination_id'],
            'type' => $validated['type'],
            'quantity' => $validated['quantity'],
            'remaining' => $newRemaining,
            'notes' => $validated['notes'] ?? null,
        ]);
    });

    return redirect()->route('companies.stock.destinations', $company)->with('success', 'Mouvement enregistré avec succès.');
}
}

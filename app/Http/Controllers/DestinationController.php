<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Company;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    /**
     * Liste toutes les destinations (optionnellement par compagnie).
     */
    public function index(Request $request)
    {
        $companyId = $request->get('company_id');

        $destinations = Destination::when($companyId, function ($query, $companyId) {
                return $query->where('company_id', $companyId);
            })
            ->with('company')
            ->latest()
            ->paginate(10);

        $companies = Company::all();

        return view('destinations.index', compact('destinations', 'companies', 'companyId'));
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create()
    {
        $companies = Company::all();
        return view('destinations.create', compact('companies'));
    }

    /**
     * Enregistre une nouvelle destination.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'country'    => 'required|string|max:255',
            'city'       => 'nullable|string|max:255',
        ]);

        // Vérifie l'unicité de (company_id, country)
        $exists = Destination::where('company_id', $validated['company_id'])
            ->where('country', $validated['country'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['country' => 'Cette destination existe déjà pour cette compagnie.'])->withInput();
        }

        Destination::create($validated);

        return redirect()->route('destinations.index')->with('success', 'Destination ajoutée avec succès.');
    }

    /**
     * Affiche le formulaire d'édition.
     */
    public function edit(Destination $destination)
    {
        $companies = Company::all();
        return view('destinations.edit', compact('destination', 'companies'));
    }

    /**
     * Met à jour une destination.
     */
    public function update(Request $request, Destination $destination)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'country'    => 'required|string|max:255',
            'city'       => 'nullable|string|max:255',
        ]);

        // Vérifie l'unicité (hors destination actuelle)
        $exists = Destination::where('company_id', $validated['company_id'])
            ->where('country', $validated['country'])
            ->where('id', '!=', $destination->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['country' => 'Cette destination existe déjà pour cette compagnie.'])->withInput();
        }

        $destination->update($validated);

        return redirect()->route('destinations.index')->with('success', 'Destination mise à jour avec succès.');
    }

    /**
     * Supprime une destination.
     */
    public function destroy(Destination $destination)
    {
        $destination->delete();

        return back()->with('success', 'Destination supprimée avec succès.');
    }
}


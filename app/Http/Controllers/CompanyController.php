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
    public function index()
    {
        $companies = Company::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:companies,name',
            'logo'        => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'stock'       => 'nullable|numeric|min:0',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $validated['user_id'] = auth()->id();

        Company::create($validated);

        return redirect()->route('companies.index')->with('success', 'Compagnie ajoutée avec succès.');
    }

    public function edit(Company $company)
    {
        $this->authorizeCompany($company);
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $this->authorizeCompany($company);

        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:companies,name,' . $company->id,
            'logo'        => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'stock'       => 'nullable|numeric|min:0',
        ]);

        if ($request->hasFile('logo')) {
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $company->update($validated);

        return redirect()->route('companies.index')->with('success', 'Compagnie mise à jour avec succès.');
    }

    public function destroy(Company $company)
    {
        $this->authorizeCompany($company);

        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
        }
        // Vérifier si la compagnie a des destinations associées
        if ($company->destinations()->exists()) {
            return back()->withErrors(['company' => 'Impossible de supprimer la compagnie car elle a des destinations associées.']);
        }
        // Vérifier si la compagnie a des mouvements de stock associés
        if ($company->destinations()->with('stockMovements')->exists()) {
            return back()->withErrors(['company' => 'Impossible de supprimer la compagnie car elle a des mouvements de stock associés.']);
        }

// Supprimer d'abord les destinations liées
$company->destinations()->delete();

// Ensuite supprimer la compagnie
$company->delete();


        $company->delete();

        return back()->with('success', 'Compagnie supprimée avec succès.');
    }

    public function stockIndex()
    {
        $companies = Company::where('user_id', auth()->id())
            ->withCount('destinations')
            ->with('destinations')
            ->paginate(10);

        $totalStock = Destination::where('user_id', auth()->id())->sumCurrentStock();

        return view('companies.stock', compact('companies', 'totalStock'));
    }

    public function stockDestinations(Company $company)
    {
        $this->authorizeCompany($company);

        $destinations = $company->destinations()
            ->where('user_id', auth()->id())
            ->withCount('stockMovements')
            ->with(['stockMovements' => function($query) {
                $query->latest()->limit(1);
            }])
            ->paginate(10);

        $movementsQuery = StockMovement::whereIn(
                'destination_id',
                $company->destinations()->where('user_id', auth()->id())->pluck('id')
            )
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
        $this->authorizeCompany($company);

        $validated = $request->validate([
            'destination_id' => 'required|exists:destinations,id,company_id,' . $company->id,
            'type'           => 'required|in:in,out',
            'quantity'       => 'required|numeric|min:0.01',
            'notes'          => 'nullable|string',
        ]);

        $destination = Destination::where('id', $validated['destination_id'])
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $lastRemaining = $destination->stockMovements()->latest()->value('remaining') ?? 0;

        $newRemaining = $validated['type'] === 'in'
            ? $lastRemaining + $validated['quantity']
            : $lastRemaining - $validated['quantity'];

        if ($newRemaining < 0) {
            return back()->withErrors(['quantity' => 'Stock insuffisant pour ce mouvement sortant.'])->withInput();
        }

        DB::transaction(function () use ($validated, $newRemaining) {
            $validated['user_id'] = auth()->id(); // Ajout de l'utilisateur courant
            StockMovement::create([
                'destination_id' => $validated['destination_id'],
                'user_id'        => $validated['user_id'],
                'type'           => $validated['type'],
                'quantity'       => $validated['quantity'],
                'remaining'      => $newRemaining,
                'notes'          => $validated['notes'] ?? null,
            ]);
        });

        return redirect()->route('companies.stock.destinations', $company)->with('success', 'Mouvement enregistré avec succès.');
    }

    /**
     * Vérifie que la compagnie appartient à l'utilisateur connecté.
     */
    private function authorizeCompany(Company $company)
    {
        if ($company->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $companyId = $request->get('company_id');

        $destinations = Destination::whereHas('company', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->when($companyId, fn($query) => $query->where('company_id', $companyId))
            ->with('company')
            ->latest()
            ->paginate(10);

        $companies = Company::where('user_id', Auth::id())->get();

        return view('destinations.index', compact('destinations', 'companies', 'companyId'));
    }

    public function create()
    {
        $companies = Company::where('user_id', Auth::id())->get();
        return view('destinations.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'country'    => 'required|string|max:255',
            'city'       => 'nullable|string|max:255',
        ]);

        $company = Company::findOrFail($validated['company_id']);
        if ($company->user_id !== Auth::id()) {
            abort(403);
        }

        $exists = Destination::where('company_id', $validated['company_id'])
            ->where('country', $validated['country'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['country' => 'Cette destination existe déjà pour cette compagnie.'])->withInput();
        }
        $validated['user_id'] = Auth::id(); // Ajout de l'utilisateur courant
        Destination::create($validated);

        return redirect()->route('destinations.index')->with('success', 'Destination ajoutée avec succès.');
    }

    public function edit(Destination $destination)
    {
        $this->authorizeDestination($destination);
        $companies = Company::where('user_id', Auth::id())->get();
        return view('destinations.edit', compact('destination', 'companies'));
    }

    public function update(Request $request, Destination $destination)
    {
        $this->authorizeDestination($destination);

        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'country'    => 'required|string|max:255',
            'city'       => 'nullable|string|max:255',
        ]);

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

    public function destroy(Destination $destination)
    {
        $this->authorizeDestination($destination);
        $destination->delete();

        return back()->with('success', 'Destination supprimée avec succès.');
    }

    private function authorizeDestination(Destination $destination)
    {
        if ($destination->company->user_id !== Auth::id()) {
            abort(403);
        }
    }
}

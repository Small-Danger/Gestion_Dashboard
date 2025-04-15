<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    /**
     * Affiche la liste des clients.
     */
    public function index()
    {
        $clients = Client::orderBy('created_at', 'desc')->paginate(10);
        return view('clients.index', compact('clients'));
    }

    /**
     * Enregistre un nouveau client.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'phone'      => 'required|string|max:20|unique:clients,phone',
            'address'    => 'nullable|string',
            'balance'    => 'nullable|numeric|min:0',
        ]);

        Client::create($validated);

        return redirect()->back()->with('success', 'Client ajouté avec succès.');
    }

    /**
     * Met à jour un client existant.
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'phone'      => ['required', 'string', 'max:20', Rule::unique('clients')->ignore($client->id)],
            'address'    => 'nullable|string',
            'balance'    => 'nullable|numeric|min:0',
        ]);

        $client->update($validated);

        return redirect()->back()->with('success', 'Client mis à jour avec succès.');
    }

    /**
     * Supprime (soft delete) un client.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->back()->with('success', 'Client supprimé avec succès.');
    }
}

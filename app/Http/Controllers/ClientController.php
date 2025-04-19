<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    /**
     * Affiche la liste des clients de l'utilisateur connecté.
     */
    public function index()
    {
        $clients = Client::where('user_id', Auth::id())
                         ->orderBy('created_at', 'desc')
                         ->paginate(10);

        return view('clients.index', compact('clients'));
    }

    /**
     * Enregistre un nouveau client pour l'utilisateur connecté.
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

        $validated['user_id'] = Auth::id(); // Ajout de l'utilisateur courant

        Client::create($validated);

        return redirect()->back()->with('success', 'Client ajouté avec succès.');
    }

    /**
     * Met à jour un client existant (vérifie qu'il appartient à l'utilisateur connecté).
     */
    public function update(Request $request, Client $client)
    {
        $this->authorizeClient($client); // sécurité : le client doit appartenir à l'utilisateur

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
     * Supprime un client (soft delete) si c'est le sien.
     */
    public function destroy(Client $client)
    {
        $this->authorizeClient($client);

        $client->delete();

        return redirect()->back()->with('success', 'Client supprimé avec succès.');
    }

    /**
     * Vérifie que le client appartient à l'utilisateur connecté.
     */
    protected function authorizeClient(Client $client)
    {
        if ($client->user_id !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Affiche les transactions d’un client.
     */


    public function index(Client $client)
    {
        $transactions = $client->transactions()->latest()->paginate(10);

        $client->load('transactions');
        
        // Convertir transaction_date en objet Carbon si nécessaire
        foreach ($client->transactions as $transaction) {
            $transaction->transaction_date = Carbon::parse($transaction->transaction_date);
        }

        return view('clients.transactions.index', compact('client', 'transactions'));
    }
    
    

    /**
     * Enregistre une nouvelle transaction.
     */
    public function store(Request $request, $client_id)
    {
        $client = Client::findOrFail($request->input('client_id'));

        $validated = $request->validate([
            'type'   => ['required', Rule::in(['deposit', 'withdrawal'])],
            'amount' => 'required|numeric|min:0.01',
            'notes'  => 'nullable|string',
        ]);

        // Empêche un doublon exact (client, type, montant, date)
        $existing = Transaction::where('client_id', $client->id)
            ->where('type', $validated['type'])
            ->where('amount', $validated['amount'])
            ->whereDate('transaction_date', now()->toDateString())
            ->first();

        if ($existing) {
            return back()->withErrors(['duplicate' => 'Une transaction identique existe déjà aujourd’hui.']);
        }

        DB::transaction(function () use ($validated, $client) {
            $balanceBefore = $client->balance;
            $amount = $validated['amount'];
            $type = $validated['type'];

            $balanceAfter = $type === 'deposit'
                ? $balanceBefore + $amount
                : $balanceBefore - $amount;

            if ($type === 'withdrawal' && $balanceAfter < 0) {
                abort(400, 'Solde insuffisant pour effectuer ce retrait.');
            }
            
            // Enregistrement de la transaction
            Transaction::create([
                'client_id'      => $client->id,
                'type'           => $type,
                'amount'         => $amount,
                'balance_before' => $balanceBefore,
                'balance_after'  => $balanceAfter,
                'notes'          => $validated['notes'] ?? null,
                'transaction_date' => now(),
            ]);

            // Mise à jour du solde du client
            $client->update(['balance' => $balanceAfter]);
        });

        return back()->with('success', 'Transaction enregistrée avec succès.');
    }

    /**
     * Supprime une transaction et ajuste le solde.
     */
    public function destroy($client_id, $transaction_id)
    {
        $client = Client::findOrFail($client_id);
        $transaction = Transaction::where('client_id', $client->id)->findOrFail($transaction_id);

        DB::transaction(function () use ($transaction, $client) {
            if ($transaction->type === 'deposit') {
                $client->balance -= $transaction->amount;
            } elseif ($transaction->type === 'withdrawal') {
                $client->balance += $transaction->amount;
            }

            $client->save();
            $transaction->delete();
        });

        return back()->with('success', 'Transaction supprimée et solde ajusté.');
    }

    /**
     * Affiche le formulaire d’édition d'une transaction.
     */
    public function edit($client_id, $transaction_id)
    {
        $client = Client::findOrFail($client_id);
        $transaction = Transaction::where('client_id', $client_id)->findOrFail($transaction_id);

        return view('clients.transactions.edit', compact('client', 'transaction'));
    }

    /**
     * Met à jour une transaction existante et ajuste le solde du client.
     */
    public function update(Request $request, $client_id, $transaction_id)
    {
        $client = Client::findOrFail($client_id);
        $transaction = Transaction::where('client_id', $client_id)->findOrFail($transaction_id);

        $validated = $request->validate([
            'type'   => ['required', Rule::in(['deposit', 'withdrawal'])],
            'amount' => 'required|numeric|min:0.01',
            'notes'  => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $transaction, $client) {
            // Annuler effet de l’ancienne transaction
            if ($transaction->type === 'deposit') {
                $client->balance -= $transaction->amount;
            } else {
                $client->balance += $transaction->amount;
            }

            $amount = $validated['amount'];
            $type = $validated['type'];

            $balanceBefore = $client->balance;
            $balanceAfter = $type === 'deposit'
                ? $balanceBefore + $amount
                : $balanceBefore - $amount;

            if ($type === 'withdrawal' && $balanceAfter < 0) {
                abort(400, 'Solde insuffisant après modification.');
            }

            $transaction->update([
                'type'           => $type,
                'amount'         => $amount,
                'balance_before' => $balanceBefore,
                'balance_after'  => $balanceAfter,
                'notes'          => $validated['notes'] ?? null,
            ]);

            $client->update(['balance' => $balanceAfter]);
        });

        return redirect()->route('clients.transactions.index', $client_id)->with('success', 'Transaction mise à jour.');
    }
}

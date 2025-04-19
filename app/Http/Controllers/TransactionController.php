<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Affiche les transactions d’un client appartenant à l’utilisateur connecté.
     */
    public function index(Client $client)
    {
        if ($client->user_id !== auth()->id()) {
            abort(403, 'Accès interdit');
        }

        $transactions = $client->transactions()->latest()->paginate(10);
        $client->load('transactions');

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
        $client = Client::where('id', $client_id)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();

        $validated = $request->validate([
            'type'   => ['required', Rule::in(['deposit', 'withdrawal'])],
            'amount' => 'required|numeric|min:0.01',
            'notes'  => 'nullable|string',
        ]);

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


            $validated['user_id'] = Auth::id();
            Transaction::create([
                'client_id'        => $client->id,
                'user_id'          => $validated['user_id'],
                'type'             => $type,
                'amount'           => $amount,
                'balance_before'   => $balanceBefore,
                'balance_after'    => $balanceAfter,
                'notes'            => $validated['notes'] ?? null,
                'transaction_date' => now(),
            ]);

            $client->update(['balance' => $balanceAfter]);
        });

        return back()->with('success', 'Transaction enregistrée avec succès.');
    }

    /**
     * Supprime une transaction appartenant à l’utilisateur.
     */
    public function destroy($client_id, $transaction_id)
    {
        $client = Client::where('id', $client_id)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();

        $transaction = Transaction::where('client_id', $client->id)
                                  ->findOrFail($transaction_id);

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
     * Formulaire de modification.
     */
    public function edit($client_id, $transaction_id)
    {
        $client = Client::where('id', $client_id)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();

        $transaction = Transaction::where('client_id', $client_id)
                                  ->findOrFail($transaction_id);

        return view('clients.transactions.edit', compact('client', 'transaction'));
    }

    /**
     * Met à jour une transaction.
     */
    public function update(Request $request, $client_id, $transaction_id)
    {
        $client = Client::where('id', $client_id)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();

        $transaction = Transaction::where('client_id', $client_id)
                                  ->findOrFail($transaction_id);

        $validated = $request->validate([
            'type'   => ['required', Rule::in(['deposit', 'withdrawal'])],
            'amount' => 'required|numeric|min:0.01',
            'notes'  => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $transaction, $client) {
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

        return redirect()->route('clients.transactions.index', $client_id)
                         ->with('success', 'Transaction mise à jour.');
    }
}

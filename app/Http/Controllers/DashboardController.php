<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Company;
use App\Models\Transaction;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // ID de l'utilisateur connecté

        // Statistiques principales
        $stats = [
            'active_clients' => Client::where('user_id', $userId)->count(),
            'total_balance' => Client::where('user_id', $userId)->sum('balance'),
            'companies_count' => Company::where('user_id', $userId)->count(),
            'total_stock' => StockMovement::where('user_id', $userId)->sum('remaining') ?? 0,
        ];

        // Dernières transactions de l'utilisateur connecté
        $recent_transactions = Transaction::with('client')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        // Derniers mouvements de stock enregistrés
        $recent_stock_movements = StockMovement::with(['destination.company'])
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recent_transactions', 'recent_stock_movements'));
    }
}

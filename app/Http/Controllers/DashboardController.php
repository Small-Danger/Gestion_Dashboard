<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Company;
use App\Models\Transaction;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques principales
        $stats = [
            'active_clients' => Client::count(),
            'total_balance' => Client::sum('balance'),
            'companies_count' => Company::count(),
            'total_stock' => StockMovement::sum('remaining') ?? 0,
        ];

        // Dernières transactions
        $recent_transactions = Transaction::with('client')
            ->latest()
            ->take(5)
            ->get();

        // Alertes de stock (moins de 10% du stock initial)
        $stock_alerts = StockMovement::with(['destination.company'])
            ->selectRaw('destination_id, SUM(remaining) as current_stock')
            ->groupBy('destination_id')
            ->havingRaw('SUM(remaining) < (SELECT SUM(quantity) FROM stock_movements WHERE type = "in" AND destination_id = stock_movements.destination_id) * 0.1')
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recent_transactions', 'stock_alerts'));
    }
}
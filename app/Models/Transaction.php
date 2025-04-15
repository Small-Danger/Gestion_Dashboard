<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'type', 'amount', 'balance_before','balance_after','notes','transaction_date'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

}
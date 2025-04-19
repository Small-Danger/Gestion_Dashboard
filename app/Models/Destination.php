<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = ['company_id','user_id', 'country', 'city'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
    
    // Dans app/Models/Destination.php
    public function currentStock()
    {
        return $this->stockMovements()->latest()->value('remaining') ?? 0;
    }
    public function lastMovement()
    {
        return $this->stockMovements()->latest()->first();
    }

}


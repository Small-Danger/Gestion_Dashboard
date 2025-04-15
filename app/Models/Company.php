<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo', 'description','stock'];


        public function destinations()
        {
            return $this->hasMany(Destination::class);
        }

        public function stockMovements()
        {
            return $this->hasManyThrough(StockMovement::class, Destination::class);
        }
        public function currentStock()
        {
            return $this->destinations->sum(function($destination) {
                return $destination->currentStock();
            });
        }

        public function lastMovement()
        {
            return StockMovement::whereIn('destination_id', $this->destinations->pluck('id'))
                ->latest()
                ->first();
        }
        public function calculateCurrentBalance()
        {
            return $this->stockMovements()->sum('quantity');
        }

}

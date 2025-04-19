<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = ['destination_id','user_id', 'type', 'quantity', 'remaining','notes'];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}

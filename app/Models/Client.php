<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','first_name', 'last_name', 'phone', 'address','balance'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->latest();
    }
}

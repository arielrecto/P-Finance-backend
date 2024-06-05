<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalBudget extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'budget_id'
    ];


    public function budget(){
        return $this->belongsTo(Budget::class);
    }
}

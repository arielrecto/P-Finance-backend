<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'quantity',
        'total',
        'category',
        'budget_id',
    ];



    public function budget(){
        return $this->belongsTo(Budget::class);
    }

}

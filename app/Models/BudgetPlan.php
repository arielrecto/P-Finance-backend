<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetPlan extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'category',
        'deduct_percent',
        'user_id',
    ];


    public function funds(){
        return $this->hasMany(BudgetFund::class);
    }
}

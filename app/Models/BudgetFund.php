<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetFund extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'budget_plan_id',
        'budget_id'
    ];


    public function budgetPlan(){
        return $this->belongsTo(BudgetPlan::class);
    }

    public function budget(){
        return $this->belongsTo(Budget::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'month',
        'amount',
        'user_id',
        'budget_plan_id'
    ];



    public function user(){
        return $this->belongsTo(User::class);
    }


    public function expenses(){
        return $this->hasMany(Expense::class);
    }
    public function budgetPlan(){
        return $this->belongsTo(BudgetPlan::class);
    }
}

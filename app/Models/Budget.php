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
        'init_amount',
        'user_id',
    ];



    public function user(){
        return $this->belongsTo(User::class);
    }


    public function expenses(){
        return $this->hasMany(Expense::class);
    }
    public function funds(){
        return $this->hasMany(BudgetFund::class);
    }
    public function additionalBudget(){
        return $this->hasMany(AdditionalBudget::class);
    }
    public function deductionBudget(){
        return $this->hasMany(DeductionBudget::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetPlan extends Model
{
    use HasFactory;


    protected $fillable = [
        'monthly_salary',
        'annual_salary',
        'percent_saving',
        'expected_saving',
        'expected_monthly_saving',
        'year'
    ];


    public function budgets(){
        return $this->hasMany(Budget::class);
    }
}

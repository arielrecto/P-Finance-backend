<?php

namespace App\Http\Controllers\User;

use App\Models\Budget;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdditionalBudget;
use App\Models\BudgetPlan;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {

        $user = Auth::user();

        $budget = Budget::where('user_id', $user->id)->first();

        $totalIncome = AdditionalBudget::where(function($q) use($user){
            $q->whereHas('budget', function($q) use($user){
                $q->where('user_id', $user->id);
            });
        })->sum('amount');
        $expenses = Expense::where('budget_id', $budget->id)->sum('price');


        return response([
            'budget' => $budget,
            'total_income' => $totalIncome,
            'expenses' => $expenses,
        ], 200);
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Models\Budget;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BudgetPlan;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {

        $user = Auth::user();

        $budget = Budget::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)
            ->where('month', now()->format('F'));
        })->latest()->first();

        $categories = Category::get();

        $expenses = Expense::where('budget_id', $budget->id ?? null)->latest()->get();

        $budgetPlan = BudgetPlan::where('user_id', $user->id)->with(['funds'])->withSum('funds', 'amount')->latest()->get();


        return response([
            'budget' => $budget,
            'expenses' => $expenses,
            'budget_plan' => $budgetPlan,
            'categories' => $categories
        ], 200);
    }
}

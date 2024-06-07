<?php

namespace App\Http\Controllers\User;

use App\Models\BudgetPlan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\BudgetFund;
use App\Models\BudgetPlanCategory;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BudgetPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::user();

        $categories = BudgetPlanCategory::get();

        $budgetPlans = BudgetPlan::where('user_id', $user->id)->get();


        return response([
            'categories' => $categories,
            'budgetPlans' => $budgetPlans
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category' => 'required',
            'deductPercent' => 'required',
        ]);

        $user = Auth::user();

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }


        $budgetPlan = BudgetPlan::create([
            'name' => $request->name,
            'category' => $request->category,
            'deduct_percent' => $request->deductPercent,
            'user_id' => $user->id,
        ]);


        return response([
            'budget_plan' => $budgetPlan
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

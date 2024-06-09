<?php

namespace App\Http\Controllers\User;

use App\Models\Budget;
use App\Models\BudgetPlan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BudgetFund;

class BudgetFundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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


        $budget = Budget::find($request->budgetId);

        $budget_plan  = BudgetPlan::find($request->budgetPlanId);



        $budget_fund = BudgetFund::create([
            'amount' => $request->amount,
            'budget_id' => $budget->id,
            'budget_plan_id' => $budget_plan->id
        ]);


        $addBudget = $budget->additionalBudget()->latest()->first();

        $addBudget->update([
            'amount' => $addBudget->amount - $budget_fund->amount
        ]);


        $budget->update([
            'amount' => $request->balance
        ]);



        return back()->with([
            'message' => 'Savings Add'
        ]);
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

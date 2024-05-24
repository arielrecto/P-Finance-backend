<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\BudgetFund;
use App\Models\BudgetPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BudgetController extends Controller
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

        $validator = Validator::make($request->all(), [
            'amount' => 'required'
        ]);



        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }



        $budgetPlans = BudgetPlan::get();



        $user = Auth::user();

        $budget = Budget::create([
            'amount' => $request->amount,
            'user_id' => $user->id,
            'month' => now()->format('F'),
        ]);

        collect($budgetPlans)->map(function($plan) use($budget) {
            $fund = BudgetFund::create([
                'amount' => $budget->amount * ($plan->deduct_percent / 100),
                'budget_plan_id' => $plan->id,
                'budget_id' => $budget->id
            ]);

            $budget->update([
                'amount' => $budget->amount - $fund->amount
            ]);
        });


        return response([
            'budget' => $budget
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

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BudgetPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BudgetPlanController extends Controller
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
            'monthly_salary' => 'required',
            'annual_salary' => 'required',
            'saving_percent' => 'required',
            'expected_saving' => 'required',
            'ex_monthly_saving' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }


        $budgetPlan = BudgetPlan::create([
            'monthly_salary' => $request->monthly_salary,
            'annual_salary' => $request->annual_salary,
            'percent_saving' => $request->saving_percent,
            'expected_saving' => $request->expected_saving,
            'expected_monthly_saving' => $request->ex_monthly_saving,
            'year' => now()->format('Y')
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

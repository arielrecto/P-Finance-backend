<?php

namespace App\Http\Controllers\User;

use App\Models\Budget;
use Illuminate\Http\Request;
use App\Models\AdditionalBudget;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdditionalBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $year = now()->format("Y");
        $monthly_add_budgets = AdditionalBudget::getMonthlyTotals($year, $user->id);


        $addBudgets = AdditionalBudget::where(function($q) use($user) {
            $q->whereHas('budget', function($q) use($user){
                $q->where('user_id', $user->id);
            });
        })->latest()->get();



        return response([
            'monthly_add_budgets' => $monthly_add_budgets,
            'addBudgets' => $addBudgets
        ]);
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
            'amount' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $budget = Budget::find($request->budgetId);

        $addBudget = AdditionalBudget::create([
            'name' => $request->name,
            'amount' => $request->amount,
            'budget_id' => $budget->id
        ]);


        $budget->update([
            'amount' => $budget->amount + $addBudget->amount
        ]);



        return response([
            'message' => 'added success'
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

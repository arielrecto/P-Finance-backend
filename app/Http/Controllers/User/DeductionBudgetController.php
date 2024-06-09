<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\DeductionBudget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeductionBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $year = now()->format("Y");
        $monthly_deduction = DeductionBudget::getMonthlyTotals($year, $user->id);

        $deductionBudget = DeductionBudget::where(function ($q) use ($user) {
            $q->whereHas('budget', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        })->latest()->get();

        return response([
            'monthly_money_out' => $monthly_deduction,
            'deduction_budgets' => $deductionBudget
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

        $user = Auth::user();

        $budget = Budget::where('user_id', $user->id)->first();


        DeductionBudget::create([
           'name' => $request->name,
            'date' => $request->date,
            'time' => $request->time,
            'amount' => $request->amount,
            'budget_id' => $budget->id
        ]);



        $budget->update([
            'amount' => $budget->amount - $request->amount
        ]);


        return back()->with(['message' => 'Money Out Success']);
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

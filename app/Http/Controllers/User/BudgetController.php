<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdditionalBudget;
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


        // $validator = Validator::make($request->all(), [
        //     'amoun' => 'required|array',
        //     'moneyIn.amount' => 'required',
        // ]);

        // // Check if validation fails
        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 400);
        // }


        $user = Auth::user();

        $budget = Budget::where('user_id', $user->id)->first();

        if (!$budget) {
            $budget = Budget::create([
                'amount' => $request->amount,
                'user_id' => $user->id,
                'init_amount' => $request->amount,
                'month' => now()->format('F'),
            ]);


            AdditionalBudget::create([
                'name' => $request->name,
                'date' => $request->date,
                'time' => $request->time,
                'amount' => $request->amount,
                'budget_id' => $budget->id
            ]);

            return response(['message' => 'budget added'], 200);
        }




       $addBudget = AdditionalBudget::create([
            'name' => $request->name,
            'date' => $request->date,
            'time' => $request->time,
            'amount' => $request->amount,
            'budget_id' => $budget->id
        ]);


        $budget->update([
            'amount' => $budget->amount + $addBudget->amount,
            'init_amount' => $budget->init_amount + $addBudget->amount,
        ]);

        return response(['budget' => $addBudget], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Budget::whereId($id)->with(['expenses', 'funds.budgetPlan', 'additionalBudget'])
            ->withSum('additionalBudget', 'amount')
            ->withSum('expenses', 'price')
            ->withSum('funds', 'amount')
            ->first();
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

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
            'moneyIn' => 'required|array',
            'moneyIn.amount' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }


        $data = json_decode($request->getContent(), true);

        $user = Auth::user();



        $amount = $data['moneyIn']['amount'];
        $breakDown = $data['breakDown'];



        $user = Auth::user();

        $budget = Budget::create([
            'amount' => $amount,
            'user_id' => $user->id,
            'init_amount' => $amount,
            'month' => now()->format('F'),
        ]);

        collect($breakDown['listItems'])->map(function($breakDown) use($budget) {
            BudgetFund::create([
                'amount' => $breakDown['deduction'],
                'budget_plan_id' => $breakDown['id'],
                'budget_id' => $budget->id
            ]);
        });


        $budget->update([
            'amount' => $breakDown['remaining']
        ]);


        $budgetPlans = BudgetPlan::where('user_id', $user->id)->with(['funds'])->withSum('funds', 'amount')->get();


        return response([
            'budget' => $budget,
            'budget_plan' => $budgetPlans
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

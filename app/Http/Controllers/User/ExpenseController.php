<?php

namespace App\Http\Controllers\User;

use App\Models\Budget;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
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
            'name' => 'required',
            'quantity' => 'required',
            'total' => 'required',
            'category' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = Auth::user();

        $budget = Budget::where('user_id', $user->id)->latest()->first();


        $expense = Expense::create([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'total' => $request->total,
            'category' => $request->category,
            'budget_id' => $budget->id
        ]);


        $budget->update([
            'amount' => $budget->amount - $expense->total
        ]);


        return response([
            'expense' => $expense,
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

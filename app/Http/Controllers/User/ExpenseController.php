<?php

namespace App\Http\Controllers\User;

use App\Models\Budget;
use App\Models\Expense;
use App\Models\Category;
use App\Enums\CategoryEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::user();
        $year = now()->format("Y");
        $monthly_expenses = Expense::getMonthlyTotals($year, $user->id);

        $expenses = Expense::where(function ($q) use ($user) {
            $q->whereHas('budget', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        })->latest()->get();


        return response([
            'monthly_expenses' => $monthly_expenses,
            'expenses' => $expenses
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
            'name' => 'required',
            // 'quantity' => 'required',
            // 'total' => 'required',
            'category' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = Auth::user();

        $budget = Budget::where('user_id', $user->id)->latest()->first();


        $expense = Expense::create([
            'name' => $request->name,
            // 'quantity' => $request->quantity,
            'price' => $request->price,
            // 'total' => $request->total,
            'category' => $request->category === CategoryEnum::OTHER->value ? $request->otherCategory  : $request->category,
            'budget_id' => $budget->id
        ]);


        if ($request->otherCategory) {
            Category::create([
                'name' => $request->otherCategory
            ]);
        }


        if ($request->image) {
            $expenseImage = $request->image;  // your base64 encoded
            $expenseImage = str_replace('data:image/png;base64,', '', $expenseImage);
            $expenseImage = str_replace(' ', '+', $expenseImage);
            $expenseImageName =  'RCV-' . uniqid() . '.' . 'png';
            $expenseFilename = preg_replace('~[\\\\\s+/:*?"<>|+-]~', '-', $expenseImageName);

            $expenseImageDecoded = base64_decode($expenseImage);

            Storage::disk('public')->put('expense/' . $expenseFilename, $expenseImageDecoded);


            $expense->update([
                'image' => asset('/storage/expense/' . $expenseImageName),
            ]);
        }


        $budget->update([
            'amount' => $budget->amount - $expense->price
        ]);


        $addBudget = $budget->additionalBudget()->latest()->first();

        $addBudget->update([
            'amount' => $addBudget->amount - $expense->price
        ]);

        $category = Category::get();
        return response([
            'expense' => $expense,
            'budget' => $budget,
            'categories' => $category
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Expense::find($id);
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

    public function getMonthlyExpenses()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Fetch all expenses for the current month
        $expenses = Expense::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->get();

        // Group by category and week
        $groupedExpenses = $expenses->groupBy('category')->map(function ($categoryExpenses) {
            return $categoryExpenses->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->weekOfMonth;
            });
        });

        return response()->json($groupedExpenses);
    }
}

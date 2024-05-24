<?php

use App\Models\Budget;
use App\Models\BudgetPlan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('budget_funds', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->foreignIdFor(BudgetPlan::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_funds');
    }
};

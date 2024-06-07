<?php

use App\Models\Budget;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('additional_budgets', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->string('name');
            $table->string('date');
            $table->string('time');
            $table->foreignIdFor(Budget::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_budgets');
    }
};

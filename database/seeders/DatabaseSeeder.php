<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Enums\CategoryEnum;
use App\Models\BudgetPlanCategory;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);



        $roles = [
            'admin',
            'user'
        ];


        collect($roles)->map(function ($role) {
            Role::create(['name' => $role]);
        });

        $budgetPlanCategories = [
            'Vacation/Travel',
            'Future of Kids',
            'Special Events(Wedding, Birthdays, Christmas etc.)',
            'Emergency Funds(Healthcare)',
            'Education funds',
            'Debt Repayment',
            'Retirement',
            'Investment/Business',
            'Charity giving',
            'Legal Expenses',
            'Moving Expenses',
            'Pet Care',
            'Technology Upgrades/Gadgets',
            'Career Development',
            'Vehicle Maintenance/Replacement'
        ];


        collect($budgetPlanCategories)->map(function ($category) {
            BudgetPlanCategory::create([
                'name' => $category
            ]);
        });


        $categories = CategoryEnum::cases();

        collect($categories)->map(function ($category) {
            Category::create([
                'name' => $category->value
            ]);
        });
    }
}

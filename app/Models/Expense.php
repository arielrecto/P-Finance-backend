<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        // 'quantity',
        // 'total',
        'image',
        'category',
        'budget_id',
    ];



    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    public static function getMonthlyTotals($year, $userId)
    {
        $monthlyTotals = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlyTotals[$month] = self::whereHas('budget', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->sum('price');
        }
        return $monthlyTotals;
    }
}

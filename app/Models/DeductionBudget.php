<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeductionBudget extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'date',
        'time',
        'budget_id'
    ];


    public function budget(){
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
                ->sum('amount');
        }
        return $monthlyTotals;
    }

}

<?php

namespace App\Enums;

enum CategoryEnum :string {
    case HOUSING = 'House/Rent';
    case TRANSPORTATION = 'Transportation(Car Payment, Fuel, Public Transit';
    case FOOD  = 'Groceries/Food';
    case ENTERTAINMENT = 'Entertainment/Leisure';
    case PAYMENT = 'Debt Payment (Credit Card, Loans)';
    case EDUCATION = 'Education (Tuition Fee)';
    case TITHES = 'Tithes';
    case ELECTRIC = 'Electric bill';
    case WATER = "Water bill";
    case LPG = 'LPG';
    case OTHER = 'other';
}

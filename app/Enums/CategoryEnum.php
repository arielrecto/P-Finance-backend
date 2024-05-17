<?php

namespace App\Enums;

enum CategoryEnum :string {
    case HOUSING = 'House/Rent';
    case UTILITIES = 'Utilities';
    case TRANSPORTATION = 'Transportation(Car Payment, Fuel, Public Transit';
    case FOOD  = 'Groceries/Food';
    case HEALTH = 'Healthcare/Insurance';
    case ENTERTAINMENT = 'Entertainment/Leisure';
    case PAYMENT = 'Debt Payment (Credit Card, Loans)';
    case EDUCATION = 'Education (Tuition Fee)';
    case SAVING = 'Saving/Investment';
    case TITHES = 'Tithes';
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * (Optional but good practice)
     */
    protected $table = 'budgets';

    /**
     * Allow mass assignment for budget tiers
     */
    protected $fillable = [
        'range',
        'recommended_event',
        'details',
    ];
}

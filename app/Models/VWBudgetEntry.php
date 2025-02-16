<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VWBudgetEntry extends Model
{
    use HasFactory;

    protected $table = 'vw_budget_entries';

    protected $primaryKey = 'id';
}

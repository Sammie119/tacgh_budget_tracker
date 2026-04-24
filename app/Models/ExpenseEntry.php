<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseEntry extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function budgetEntry()
    {
        return $this->belongsTo(BudgetEntry::class, 'budget_entry_id');
    }

    public function budgetHeader()
    {
        return $this->belongsTo(BudgetHeader::class, 'header_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VWBudgetEntry extends Model
{
    use HasFactory;

    protected $table = 'vw_budget_entries';

    protected $primaryKey = 'id';

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function budgetHeader()
    {
        return $this->belongsTo(BudgetHeader::class, 'header_id');
    }
}

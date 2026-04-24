<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BudgetEntry extends Model
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

    public function budgetHeader()
    {
        return $this->belongsTo(BudgetHeader::class, 'header_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

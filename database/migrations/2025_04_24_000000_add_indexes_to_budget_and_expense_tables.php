<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Adds indexes on all foreign-key columns in budget_entries and expense_entries.
     * These columns are used heavily in WHERE clauses, JOIN conditions, and report
     * queries, so indexing them reduces full-table scans and speeds up every page
     * that loads those tables.
     */
    public function up(): void
    {
        Schema::table('budget_entries', function (Blueprint $table) {
            $table->index('department_id', 'idx_budget_entries_department_id');
            $table->index('category_id',   'idx_budget_entries_category_id');
            $table->index('header_id',     'idx_budget_entries_header_id');
            $table->index('status',        'idx_budget_entries_status');
            // Composite index for the most common report filter
            $table->index(['header_id', 'category_id', 'status'], 'idx_budget_entries_report');
        });

        Schema::table('expense_entries', function (Blueprint $table) {
            $table->index('budget_entry_id', 'idx_expense_entries_budget_entry_id');
            $table->index('department_id',   'idx_expense_entries_department_id');
            $table->index('category_id',     'idx_expense_entries_category_id');
            $table->index('header_id',       'idx_expense_entries_header_id');
            $table->index('status',          'idx_expense_entries_status');
            // Composite index covering the indexExpense query
            $table->index(['status', 'created_at'], 'idx_expense_entries_status_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('budget_entries', function (Blueprint $table) {
            $table->dropIndex('idx_budget_entries_department_id');
            $table->dropIndex('idx_budget_entries_category_id');
            $table->dropIndex('idx_budget_entries_header_id');
            $table->dropIndex('idx_budget_entries_status');
            $table->dropIndex('idx_budget_entries_report');
        });

        Schema::table('expense_entries', function (Blueprint $table) {
            $table->dropIndex('idx_expense_entries_budget_entry_id');
            $table->dropIndex('idx_expense_entries_department_id');
            $table->dropIndex('idx_expense_entries_category_id');
            $table->dropIndex('idx_expense_entries_header_id');
            $table->dropIndex('idx_expense_entries_status');
            $table->dropIndex('idx_expense_entries_status_created');
        });
    }
};

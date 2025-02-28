<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expense_entries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->bigInteger('budget_entry_id');
            $table->bigInteger('category_id');
            $table->bigInteger('department_id');
            $table->bigInteger('header_id');
            $table->decimal('amount_budgeted', 12, 2);
            $table->decimal('amount_used', 12, 2);
            $table->decimal('amount_requested', 12, 2);
            $table->decimal('amount_spent', 12, 2)->default(0.00);
            $table->tinyInteger('status')->default(0)->comment('0 - Inactive, 1 - Active');
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_entries');
    }
};

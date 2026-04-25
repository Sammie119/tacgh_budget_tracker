<?php

namespace App\Imports;

use App\Models\ExpenseEntry;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ExpenseAmountImport implements ToCollection, WithHeadingRow, WithValidation
{
    public int $updatedCount  = 0;
    public int $skippedCount  = 0;
    public array $errors      = [];

    /**
     * Process each row after headers are stripped.
     * Expected columns: id, amount_spent
     */
    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $id          = $row['id']           ?? null;
            $amountSpent = $row['amount_spent']  ?? null;

            if (empty($id) || !is_numeric($amountSpent)) {
                $this->skippedCount++;
                continue;
            }

            $expense = ExpenseEntry::where('id', (int) $id)
                ->where('status', '>=', 1)
                ->first();

            if (!$expense) {
                $this->skippedCount++;
                $this->errors[] = "Row ID {$id}: expense entry not found or not active.";
                continue;
            }

            $expense->update([
                'amount_spent' => (float) $amountSpent,
                'status'       => 2,
                'updated_by'   => Auth::id(),
            ]);

            $this->updatedCount++;
        }
    }

    public function rules(): array
    {
        return [];
    }
}

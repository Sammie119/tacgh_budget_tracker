<style>
    span {
        font-weight: bolder;
    }
</style>
<form method="POST" action="{{ route('expense_entries.update') }}">
    @csrf
    @isset($entry)
        @method('put')
        <input type="hidden" name="id" value="{{ $entry->id }}">
    @endisset

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Name</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="name" value="@isset($entry) {{ $entry->name }} @endisset" readonly>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Memo Ref Number</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="description" value="@isset($entry) {{ $entry->description }} @endisset" readonly>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Budget Entry</label>
        <div class="col-sm-9">
            <input name="budget_entry_id" class="form-control" id="budgetEntry" value="@isset($entry) {{ \App\Models\BudgetEntry::find($entry->budget_entry_id)->name }} @endisset" readonly>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Budget Allocation</label>
        <div class="col-sm-9">
            <input class="form-control" id="budgetEntry" value="@isset($entry) {{ \App\Models\BudgetEntry::find($entry->budget_entry_id)->amount }} @endisset" readonly>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Requested Amount</label>
        <div class="col-sm-9">
            <input type="number" step="0.01" min="0.01" class="form-control" name="amount" value="{{(isset($entry)) ? $entry->amount_requested : "" }}" placeholder="0.00" readonly>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Amount Spent</label>
        <div class="col-sm-9">
            <input type="number" step="0.01" min="0.01" class="form-control" name="amount_spent" value="{{(isset($entry)) ? $entry->amount_spent : "" }}" placeholder="0.00" required>
        </div>
    </div>

    {{-- Buttons --}}
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

<form method="POST" action="{{ route('expense_entries.destroy') }}">
    @csrf

    <input type="hidden" name="id" value="{{ $expense_entries }}">

    <label>Deleting this record is an irreversible action. Do you want to continue...?</label>

    {{-- Buttons --}}
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <button type="submit" class="btn btn-danger">Yes</button>
    </div>
</form>

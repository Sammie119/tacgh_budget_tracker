<style>
    span {
        font-weight: bolder;
    }
</style>
<form method="POST" action="{{ route('expense_entries.store') }}">
    @csrf
    @isset($entry)
        @method('put')
        <input type="hidden" name="id" value="{{ $entry->id }}">
    @endisset

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Name</label>
        <div class="col-sm-9">
            <input type="text" class="form-control cusInput" name="name" value="@isset($entry) {{ $entry->name }} @endisset" required>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Description</label>
        <div class="col-sm-9">
            <input type="text" class="form-control cusInput" name="description" value="@isset($entry) {{ $entry->description }} @endisset" required>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Budget Entry</label>
        <div class="col-sm-9">
            <input list="options" name="budget_entry_id" class="form-control cusInput" id="budgetEntry" value="@isset($entry) {{ \App\Models\BudgetEntry::find($entry->budget_entry_id)->name }} @endisset" required>
            <div id="showBudget" style="display: none"><span>Allocation: </span> <label id="allocation">00000000</label> <span style="margin-left: 20px">Remaining: </span><label id="remaining">00000000</label></div>
            <datalist id="options">
                @foreach ($budget_entries as $option)
                    <option value="{{ $option->name }}">
                @endforeach
            </datalist>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Budgeted Amount</label>
        <div class="col-sm-9">
            <input type="number" step="0.01" min="0.01" class="form-control cusInput" name="amount" value="{{(isset($entry)) ? $entry->amount_requested : "" }}" placeholder="0.00" required>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Status</label>
        <div class="col-sm-9">
            <x-input-select
                :options="['Inactive', 'Active']"
                :selected="isset($entry) ? $entry->status : 3"
                :values="[0, 1]"
                name="status"
                :type="1"
                required
            />
        </div>
    </div>

    {{-- Buttons --}}
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

<script>
    $("#budgetEntry").change(function(){
        let budget_entry = $("#budgetEntry").val();
        // alert(budget_entry)
        $.ajax({
            type:'GET',
            url:'get_budget_entry',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                budget_entry
            },
            success:function(data) {
                if (budget_entry === ""){
                    alert('No Budget Entry Selected');
                    $("#showBudget").css("display","none");
                }
                else if(data.budget_entry === 0){
                    $('#budgetEntry').val('');
                    alert('Budget Entry Selected Not Found');
                    $("#showBudget").css("display","none");
                }
                else {
                    const nFormat = new Intl.NumberFormat(undefined, {minimumFractionDigits: 2});

                    $("#showBudget").css("display","block");
                    // alert(data.budget_entry.amount)
                    $("#allocation").html(nFormat.format(data.budget_entry.amount));
                    $("#remaining").html(nFormat.format(data.budget_entry.remaining));

                }
            }

        });
    });
</script>


<style>
    span {
        font-weight: bolder;
    }
</style>
<form method="POST" action="{{ route('request_entries.store') }}">
    @csrf
    @isset($entry)
        @method('put')
        <input type="hidden" name="id" value="{{ $entry->id }}">
    @endisset

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Memo Reference Number</label>
        <div class="col-sm-9">
            <input type="text" id="memo" class="form-control" name="description" value="@isset($entry) {{ $entry->description }} @endisset" required>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Name</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="name" name="name" value="@isset($entry) {{ $entry->name }} @endisset" required>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Budget Entry</label>
        <div class="col-sm-9">
            <input list="options" class="form-control" id="budgetEntry" value="@isset($entry) {{ \App\Models\BudgetEntry::find($entry->budget_entry_id)->name }} - {{ \App\Models\Department::find($entry->department_id)->name }}@endisset" required>
            <div id="showBudget" style="display: none"><span>Allocation: </span> <label id="allocation">00000000</label> <span style="margin-left: 20px">Remaining: </span><label id="remaining">00000000</label></div>
            <datalist id="options">
                @foreach ($budget_entries as $option)
                    <option data-value="{{ $option->id }}">{{ $option->name }} - {{ \App\Models\Department::find($option->department_id)->name }}</option>
                @endforeach
            </datalist>
            <input type="hidden" name="budget_entry_id" value="@isset($entry) {{ $entry->budget_entry_id }} @endisset" id="budgetEntry-hidden">
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Request Amount</label>
        <div class="col-sm-9">
            <input type="number" step="0.01" min="0.01" id="amount" class="form-control" name="amount" value="{{(isset($entry)) ? $entry->amount_requested : "" }}" placeholder="0.00" required>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Balance</label>
        <div class="col-sm-9">
            <input type="text" id="b_amount1" step="0.01" min="0.01" class="form-control b_amount1" value="{{(isset($entry)) ? $entry->amount_requested : "" }}" placeholder="0.00" style="color: black; display: block" readonly>
            <input type="text" id="b_amount2" step="0.01" min="0.01" class="form-control b_amount2" value="{{(isset($entry)) ? $entry->amount_requested : "" }}" placeholder="0.00" style="color: red; display: none" readonly>
        </div>
{{--        <div class="col-sm-9">--}}
{{--            <x-input-select--}}
{{--                :options="['Inactive', 'Active']"--}}
{{--                :selected="isset($entry) ? $entry->status : 3"--}}
{{--                :values="[0, 1]"--}}
{{--                name="status"--}}
{{--                :type="1"--}}
{{--                required--}}
{{--            />--}}
{{--        </div>--}}
    </div>

    {{-- Buttons --}}
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

<script>
    document.querySelector('input[list]').addEventListener('input', function(e) {
        var input = e.target,
            list = input.getAttribute('list'),
            options = document.querySelectorAll('#' + list + ' option'),
            hiddenInput = document.getElementById(input.getAttribute('id') + '-hidden'),
            inputValue = input.value;

        hiddenInput.value = inputValue;

        for(var i = 0; i < options.length; i++) {
            var option = options[i];

            if(option.innerText === inputValue) {
                hiddenInput.value = option.getAttribute('data-value');
                break;
            }
        }
    });


    $("#budgetEntry").change(function(){
        let budget_entry = $("#budgetEntry-hidden").val();
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

                    let amount = parseFloat(data.budget_entry.remaining) - parseFloat($("#amount").val());

                    if(amount > 0){
                        $(".b_amount1").css("display","block");
                        $(".b_amount2").css("display","none");
                        $("#b_amount1").val(nFormat.format(amount));
                    } else {
                        $(".b_amount2").css("display","block");
                        $(".b_amount1").css("display","none");
                        $("#b_amount2").val(nFormat.format(amount));
                    }
                }
            }

        });
    });

    $("#memo").change(function(){
        let memo = $("#memo").val();
        // alert(memo)
        $.ajax({
            // type:'GET',
            // url:'https://randomuser.me/api/',
            url: 'https://ememoapi.tacms.net/api/v1/memo/memo_details',
            method: 'post',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                memo
            },
            success: function(data) {
                if(data.status === 404){
                    alert("Wrong Memo Ref Number");
                    $("#memo").focus();
                    return false;
                } else {
                    $("#name").val(data.data.subject);
                    $("#amount").val(parseFloat(data.data.total_amount * data.data.exchange_rate).toFixed(2));
                    // console.log(data.data);
                }

            }
        });
    });
</script>


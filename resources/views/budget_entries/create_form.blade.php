<form method="POST" action="{{ route('budget_entries.store') }}">
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
        <label for="" class="col-sm-3 col-form-label">Category</label>
        <div class="col-sm-9">
            <x-input-select :options="$categories" :selected="isset($entry) ? $entry->category_id : 0" name="category_id" id="select" required/>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Department</label>
        <div class="col-sm-9">
            <x-input-select :options="$departments" :selected="isset($entry) ? $entry->department_id : 0" name="department_id" id="select" required/>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Budget Header</label>
        <div class="col-sm-9">
            <x-input-select :options="$budget_headers" :selected="isset($entry) ? $entry->header_id : 0" name="header_id" id="select" required/>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Budgeted Amount</label>
        <div class="col-sm-9">
            <input type="number" step="0.01" min="0.01" class="form-control cusInput" name="amount" value="{{(isset($entry)) ? $entry->amount : "" }}" placeholder="0.00" required>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Status</label>
        <div class="col-sm-9">
            <x-input-select
                :options="['Inactive', 'Active', 'Completed']"
                :selected="isset($entry) ? $entry->status : 3"
                :values="[0, 1, 2]"
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


<form method="POST" action="{{ route('budget_headers.store') }}">
    @csrf
    @isset($budget_header)
        @method('put')
        <input type="hidden" name="id" value="{{ $budget_header->id }}">
    @endisset

    <div class="mb-3 row">
        <label for="" class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control cusInput" name="name" value="@isset($budget_header) {{ $budget_header->name }} @endisset" required>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="" class="col-sm-2 col-form-label">Description</label>
        <div class="col-sm-10">
            <input type="text" class="form-control cusInput" name="description" value="@isset($budget_header) {{ $budget_header->description }} @endisset" required>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="" class="col-2 col-form-label">Start Date</label>
        <div class="col-10">
            <input type="date" class="form-control" value="{{ (isset($budget_header) ? $budget_header->start_date : date('Y-m-d')) }}" name="start_date" required>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="" class="col-2 col-form-label">End Date</label>
        <div class="col-10">
            <input type="date" class="form-control" style="width: 100%;" value="{{ (isset($budget_header) ? $budget_header->start_date : date('Y-m-d')) }}" name="end_date" required>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="" class="col-sm-2 col-form-label">Status</label>
        <div class="col-sm-10">
            <x-input-select
                :options="['Inactive', 'Active', 'Completed']"
                :selected="isset($budget_header) ? $budget_header->status : 3"
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


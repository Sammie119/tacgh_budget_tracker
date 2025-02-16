<form method="POST" action="{{ route('departments.store') }}">
    @csrf
    @isset($department)
        @method('put')
        <input type="hidden" name="id" value="{{ $department->id }}">
    @endisset

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Name</label>
        <div class="col-sm-9">
            <input type="text" class="form-control cusInput" name="name" value="@isset($department) {{ $department->name }} @endisset" required>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Description</label>
        <div class="col-sm-9">
            <input type="text" class="form-control cusInput" name="description" value="@isset($department) {{ $department->description }} @endisset" required>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Parent Department</label>
        <div class="col-sm-9">
            <x-input-select :options="$parent_department" :selected="isset($department) ? $department->parent_id : 0" name="parent_id" id="select" required/>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Status</label>
        <div class="col-sm-9">
            <x-input-select
                :options="['Inactive', 'Active']"
                :selected="isset($department) ? $department->status : 3"
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


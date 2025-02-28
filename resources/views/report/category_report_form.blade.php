<form method="POST" action="{{ route('generate.reports') }}">
    @csrf
    <input type="hidden" name="report_type" value="categoryReport">

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Category</label>
        <div class="col-sm-9">
            <x-input-select :options="$categories" :selected="isset($entry) ? $entry->category_id : 0" name="category_id" required/>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Budget Header</label>
        <div class="col-sm-9">
            <x-input-select :options="$headers" :selected="isset($entry) ? $entry->header_id : 0" name="header_id" required/>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Directorate/Unit</label>
        <div class="col-sm-9">
            <x-input-select :options="$departments" :selected="isset($entry) ? $entry->department_id : 0" name="department_id" />
        </div>
    </div>

    {{-- Buttons --}}
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>



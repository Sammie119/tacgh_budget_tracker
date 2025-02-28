<form method="POST" action="{{ route('categories.store') }}">
    @csrf
    @isset($category)
        @method('put')
        <input type="hidden" name="id" value="{{ $category->id }}">
    @endisset

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Code</label>
        <div class="col-sm-9">
            <input type="text" class="form-control cusInput" name="code" value="@isset($category) {{ $category->code }} @endisset" required>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Name</label>
        <div class="col-sm-9">
            <input type="text" class="form-control cusInput" name="name" value="@isset($category) {{ $category->name }} @endisset" required>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Description</label>
        <div class="col-sm-9">
            <input type="text" class="form-control cusInput" name="description" value="@isset($category) {{ $category->description }} @endisset" required>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Status</label>
        <div class="col-sm-9">
            <x-input-select
                :options="['Inactive', 'Active']"
                :selected="isset($category) ? $category->status : 3"
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


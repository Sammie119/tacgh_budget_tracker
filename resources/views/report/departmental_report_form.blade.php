{{--<form method="POST" action="{{ route('generate.reports') }}">--}}
{{--    @csrf--}}


{{--    <div class="mb-3 row">--}}
{{--        <label for="" class="col-sm-3 col-form-label">Directorate/Unit</label>--}}
{{--        <div class="col-sm-9">--}}
{{--            <x-input-select :options="$departments" :selected="isset($entry) ? $entry->department_id : 0" name="department_id" />--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="mb-3 row">--}}
{{--        <label for="" class="col-sm-3 col-form-label">Budget Header</label>--}}
{{--        <div class="col-sm-9">--}}
{{--            <x-input-select :options="$headers" :selected="isset($entry) ? $entry->header_id : 0" name="header_id" required/>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    --}}{{-- Buttons --}}
{{--    <div class="modal-footer">--}}
{{--        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>--}}
{{--        <button type="submit" class="btn btn-primary">Submit</button>--}}
{{--    </div>--}}
{{--</form>--}}


<form action="{{ route('generate.reports') }}" method="POST">
    @csrf
    <input type="hidden" name="report_type" value="departmentalReport">

    <div class="modal-body">
        <div class="mb-3">
            <label for="header_id" class="form-label fw-semibold">Budget Period <span class="text-danger">*</span></label>
            <select name="header_id" id="header_id" class="form-select" required>
                <option value="" selected disabled>— Select Period —</option>
                @foreach($headers as $h)
                    <option value="{{ $h->id }}">{{ $h->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-1">
            <label for="department_id" class="form-label fw-semibold">Directorate / Unit <span class="text-danger">*</span></label>
            <select name="department_id" id="department_id" class="form-select" required>
                <option value="" selected disabled>— Select Directorates —</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa-chart-bar me-1"></i> Generate Report
        </button>
    </div>
</form>






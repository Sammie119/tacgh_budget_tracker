<form action="{{ route('generate.reports') }}" method="POST">
    @csrf
    <input type="hidden" name="report_type" value="utilisationReport">

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

        <div class="mb-3">
            <label for="department_id" class="form-label fw-semibold">Directorate / Unit <small class="text-muted fw-normal">(optional)</small></label>
            <select name="department_id" id="department_id" class="form-select">
                <option value="">— All Directorates —</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-1">
            <label for="threshold" class="form-label fw-semibold">Show only lines at or above utilisation <small class="text-muted fw-normal">(optional)</small></label>
            <div class="input-group">
                <input type="number" name="threshold" id="threshold" class="form-control"
                       min="0" max="200" placeholder="e.g. 80">
                <span class="input-group-text">%</span>
            </div>
            <div class="form-text">Leave blank to show all budget lines.</div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa-chart-bar me-1"></i> Generate Report
        </button>
    </div>
</form>

<form method="POST" action="{{ route('users.store') }}">
    @csrf
    @isset($user)
        @method('put')
        <input type="hidden" name="id" value="{{ $user->id }}">
    @endisset

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Name</label>
        <div class="col-sm-9">
            <input type="text" class="form-control cusInput" name="name" value="@isset($user) {{ $user->name }} @endisset" required>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Email</label>
        <div class="col-sm-9">
            <input type="email" class="form-control cusInput" name="email" value="@isset($user) {{ $user->email }} @endisset" required>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">User Level</label>
        <div class="col-sm-9">
            <x-input-select
                :options="['Admin', 'Management', 'Audit Staff', 'Finance Staff']"
                :selected="isset($user) ? $user->is_admin : 5"
                :values="[0, 2, 3, 4]"
                name="is_admin"
                :type="1"
                required
            />
        </div>
    </div>

    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Password</label>
        <div class="col-sm-9">
            <input type="password" class="form-control" name="password" required>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="" class="col-sm-3 col-form-label">Confirm Password</label>
        <div class="col-sm-9">
            <input type="password" class="form-control" name="password_confirmation" required>
        </div>
    </div>

    {{-- Buttons --}}
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>


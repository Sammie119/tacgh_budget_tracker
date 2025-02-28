<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function index()
    {
        $data['users'] = User::where('id', '!=', 1)->get();
//        dd($data['users']);
        return view('users.index', $data);
    }
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'is_admin' => ['required'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'is_admin' => $request->is_admin,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect(route('users', absolute: false))->with('success', 'User Created Successfully!!!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'is_admin' => ['required'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$request->id],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::find($request->id)->update([
            'name' => $request->name,
            'is_admin' => $request->is_admin,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect(route('users', absolute: false))->with('success', 'User Updated Successfully!!!');
    }

    public function destroy(Request $request)
    {
        User::find($request->id)->delete();

        return redirect(route('users', absolute: false))->with('success', 'User Deleted Successfully!!!');
    }
}

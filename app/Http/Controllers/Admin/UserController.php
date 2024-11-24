<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function __construct() {
        /* in gate =>
        // if in Route binding you are using    Route::resource()   to use middleware in route add it in construct else you can add as  ->middleware('can') in Route::binding
        $this->middleware('can:edit-user,user')->only(['edit']);
        */

        // in policy =>
        // $this->middleware('can:edit,user')->only(['edit']);

        $this->middleware('can:show-users')->only(['index']);
        $this->middleware('can:create-user')->only(['create', 'store']);
        $this->middleware('can:edit-user')->only(['edit', 'update']);
        $this->middleware('can:delete-user')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // search method
        $users = User::query();
        if ($keyword = request('search')) {
            $users->where('email', 'LIKE', "%{$keyword}%")->orWhere('name', 'LIKE', "%{$keyword}%")->orWhere('id', "%{$keyword}%");
        }

        // if (Gate::allows('show-staff-users')) {
        //     $users->where('is_superuser', 0)->orWhere('is_staff', 0);
        // } else {
        //     $users->where('is_superuser', 1)->orWhere('is_staff', 1);
        // }

        // add filters like     asc or desc     or      sort by name id email and ...
        $users = $users->paginate(20);

        return view('admin.users.all-users', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);
        $user = User::create([
            'name' => $validateData['name'],
            'email' => $validateData['email'],
            // 'password' => Hash::make($validateData['password']),         or
            'password' => $validateData['password'],

        ]);


        if ($request->has('verify')) {
            $user->markEmailAsVerified();
        }
        if ($request->has('is_admin')) {
            $user->makeSuperuser();
        }
        if ($request->has('is_staff')) {
            $user->makeStaff();
        }

        Alert::success('User created!', 'User Successfully Created!');

        return redirect(route('admin.users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user
        ]);



        /*
        // Policy codes
        if (Gate::allows('edit', $user)) {
            return view('admin.users.edit', [
                'user' => $user
            ]);
        }

        abort(403);
        */

        // or even codes from below


        // Gate code
        /*
        if (Gate::allows('edit-user', $user)) {
            return view('admin.users.edit', [
                'user' => $user
            ]);
        }

        abort(403);
        */
        /*      method 1)
        $this->authorize('edit-user', $user);
        return view('admin.users.edit', [
                'user' => $user
            ]);

        */

        /*      method 2)

        if (Gate::denies('edit-user', $user)) {
            abort(403);
        }

        return view('admin.users.edit', [
            'user' => $user
            ]);
        */

        /*      method 3)

        if (auth()->user()->can('edit-user', $user)) {
            return view('admin.users.edit', [
                'user' => $user
            ]);
        }
        abort(403);
        */

        /*      method 5)
            add $this->middleware('can'); to __contruct of UserController
        */
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validated_data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        if (! is_null($request->password)) {
        $request->validate([
                'password' => ['required', 'string', 'min:4', 'confirmed'],
            ]);

            // $validated_data['password'] = Hash::make($new_password['password']);     or
            $validated_data['password'] = $request->password;
        }
        // verify email
        $request->has('verify') && $user->markEmailAsVerified();
        // toggle is admin
        switch ($request->is_superuser) {
            case 'on':
                $user->is_superuser = true;
                break;
            default:
                $user->is_superuser = false;
                break;
        }
        // toggle is staff
        switch ($request->is_staff) {
            case 'on':
                $user->is_staff = true;
                break;
            default:
                $user->is_staff = false;
                break;
        }

        $user->update($validated_data);

        Alert::success('User Updated!', 'User Successfully Updated!');

        return redirect(route('admin.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        Alert::success('User Deleted!', 'User Successfully Deleted!');
        return back();
    }
}

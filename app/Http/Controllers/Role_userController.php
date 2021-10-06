<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class Role_userController extends Controller
{
    public function index()
    {

        return view('admin.index', [
            'page' => 'Панель управления жанрами',
            'users' => User::all()
        ]);
    }

    public function ajaxGetRoles(Request $request) {

        $roles = User::where('email', $request->email)->first()->roles()->get();
        return Response::json([
            'roles' => $roles
        ]);
    }

    public function ajaxGetRolesForActionDeleteOneRole(Request $request) {

        $roles = Role::whereHas('users', function (Builder $query) use($request) {
            $query->where('email', $request->email);
        })->get();

        return Response::json([
            'roles' => $roles
        ]);
    }

    public function ajaxGetRolesForActionAddOneRole(Request $request) {

        $roles = Role::whereDoesntHave('users', function (Builder $query) use($request) {
            $query->where('email', $request->email);
        })->get();

        return Response::json([
            'roles' => $roles
        ]);
    }
    public function ajaxDetachOneRole(Request $request) {

        $user = User::where('email', $request->email)->first();
        $role = Role::where('role', $request->role)->first();
        $user->roles()->detach($role->id);

        return back()->withInput();
    }

    public function ajaxAttachOneRole(Request $request) {

        $user = User::where('email', $request->email)->first();
        $role = Role::where('role', $request->role)->first();
        $user->roles()->attach($role->id);

        return back()->withInput();
    }
}

<?php

namespace app\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Models\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class companysController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user->authorizeRoles('admin');

        $companies = Company::all();
        return view('admin.company.index')->with('company', $companies);
    }
    public function show(Company $company)
    {
        $user = Auth::user();
        $user->authorizeRoles('admin');
        return view('admin.company.show')->with('company', $company)->with('user', $user);
    }



    public function create()
    {
        $user = Auth::user();
        $user->authorizeRoles('admin');

        $users = User::all();
        return view('admin.company.create')->with('users', $users);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $user->authorizeRoles('admin');

        $request->validate([
            'name' => 'required|max:50',
            'text' => 'required|max:200',
        ]);

        $comp = Company::create([
            'name' => $request->name,
            'address' => $request->text,
        ]);

        $manager = User::find($request->company_lead);
        $manager->update([
            'company_id' => $comp->id,
        ]);


        if (!$manager->hasRole('companyLead')) {
            $role = Role::where('name', 'companyLead')->first();
            $manager->roles()->attach($role);
        };
        return to_route('admin.company.index')->with('message', "Company Uploaded Successfully");
    }

    public function edit(Company $company)
    {
        $user = Auth::user();
        $users = User::all();

        $user->authorizeRoles('admin');
        return view('admin.company.edit')->with('company', $company)->with('users', $users);
    }

    public function update(Company $company, Request $request)
    {
        $user = Auth::user();
        $user->authorizeRoles('admin');
        $request->validate([
            'name' => 'required|max:50',
            'text' => 'required|max:200',
        ]);


        $company->update([
            'title' => $request->title,
            'text' => $request->text,
        ]);

        $manager = User::find($request->company_lead);
        $manager->update([
            'company_id' => $company->id,
        ]);

        return to_route('admin.company.show', $company)->with('success', 'Successfully edited company');
    }

    public function destroy(Company $company)
    {
        $user = Auth::user();
        $user->authorizeRoles('admin');

        $company->delete();
        return to_route('admin.projects.index');
    }
}

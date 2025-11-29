<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Requests\CompanyCreateRequest;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Company::latest();
        if ($request->input('archived') == 'true') {
            $query->onlyTrashed();
        }
        $companies = $query->paginate(2)->onEachSide(1);
        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries = [
            'Technology',
            'Healthcare',
            'Education',
            'Manufacturing',
            'Retail',
            'Banking',
            'Insurance',
            'Telecom',
            'Energy',
            'Transportation',
            'Other',
        ];
        return view('company.create', compact('industries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCreateRequest $request)
    {
        $validated = $request->validated();
        $owner = User::create([
            'name' => $validated['owner_name'],
            'email' => $validated['owner_email'],
            'password' => Hash::make($validated['owner_password']),
            'role' => 'company-owner',
        ]);
        //return error if owner is not created
        if (!$owner) {
            return redirect()->route('companies.create')->with('error', 'Failed to create owner');
        }

        Company::create(
            [
                'name' => $validated['name'],
                'address' => $validated['address'],
                'industry' => $validated['industry'],
                'website' => $validated['website'],
                'ownerId' => $owner->id,
            ]
        );
        return redirect()->route('companies.index')->with('success', 'Company created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id = null)
    {
        $company = $this->getCompany($id);

        return view('company.show', compact('company'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id = null)
    {
        $company = $this->getCompany($id);
        $industries = [
            'Technology',
            'Healthcare',
            'Education',
            'Manufacturing',
            'Retail',
            'Banking',
            'Insurance',
            'Telecom',
            'Energy',
            'Transportation',
            'Other',
        ];
        return view('company.edit', compact('company', 'industries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, string $id = null)
    {
        $validated = $request->validated();
        $company = $this->getCompany($id);
        $company->update($validated);
        if (auth()->user()->role == 'company-owner') {
            return redirect()->route('my-company.show')->with('success', 'Company updated successfully');
        }
        return redirect()->route('companies.index')->with('success', 'Company updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->route('companies.index')->with('success', 'Company Archived successfully');
    }

    public function restore(string $id)
    {
        $company = Company::withTrashed()->findOrFail($id);
        $company->restore();
        return redirect()->route('companies.index', ['archived' => 'true'])->with('success', 'Company Restored successfully');
    }


    private function getCompany(string $id = null)
    {
        if ($id) {
            $company = Company::findOrFail($id);
        } else {
            $company = Company::where('ownerId', Auth::id())->first();
        }
        return $company;
    }
}

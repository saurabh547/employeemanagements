<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:employees',
            'country_code' => 'required|string',
            'mobile_number' => 'required|numeric',
            'address' => 'required',
            'gender' => 'required',
            'hobbies' => 'array',
            'photo' => 'image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validatedData['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $validatedData['hobbies'] = implode(', ', $request->hobbies ?? []);
        Employee::create($validatedData);

        return redirect()->route('employees.index')->with('success', 'Employee added successfully!');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:employees,email,' . $id,
            'country_code' => 'required|string',
            'mobile_number' => 'required|numeric',
            'address' => 'required',
            'gender' => 'required',
            'hobbies' => 'array',
            'photo' => 'image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo); 
            }
            $validatedData['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $validatedData['hobbies'] = implode(', ', $request->hobbies ?? []);
        $employee->update($validatedData);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully!');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo); 
        }

        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully!');
    }
}

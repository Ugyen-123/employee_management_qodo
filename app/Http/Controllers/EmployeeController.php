<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::orderBy('id', 'desc')->paginate(10);
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => ['required','regex:/^\d{12}$/','unique:employees,employee_id'],
            'name'        => ['required','string','max:255'],
            'email'       => ['required','email','unique:employees,email'],
            'position'    => ['nullable','string','max:255'],
            'salary'      => ['nullable','numeric','min:0'],
            'password'    => ['required','string','min:8','confirmed','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/'],
        ], [
            'employee_id.regex' => 'Employee ID must be exactly 12 digits.',
            'password.regex' => 'Password must be at least 8 characters and include upper, lower, digit, and special character.'
        ]);

        $data['password'] = Hash::make($data['password']);
        Employee::create($data);

        return redirect()->route('admin.employees.index')->with('success', 'Employee created.');
    }

    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'employee_id' => ['required','regex:/^\d{12}$/','unique:employees,employee_id,' . $employee->id],
            'name'        => ['required','string','max:255'],
            'email'       => ['required','email','unique:employees,email,' . $employee->id],
            'position'    => ['nullable','string','max:255'],
            'salary'      => ['nullable','numeric','min:0'],
            'password'    => ['nullable','string','min:8','confirmed','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/'],
        ], [
            'employee_id.regex' => 'Employee ID must be exactly 12 digits.',
            'password.regex' => 'Password must be at least 8 characters and include upper, lower, digit, and special character.'
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $employee->update($data);
        return redirect()->route('admin.employees.index')->with('success', 'Employee updated.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('admin.employees.index')->with('success', 'Employee deleted.');
    }

    public function profile()
    {
        $employee = Auth::guard('employees')->user();
        return view('employees.profile', compact('employee'));
    }

    public function profileUpdate(Request $request)
    {
        $employee = Auth::guard('employees')->user();

        $data = $request->validate([
            'name'     => ['required','string','max:255'],
            'email'    => ['required','email','unique:employees,email,' . $employee->id],
            'position' => ['nullable','string','max:255'],
            'password' => ['nullable','string','min:8','confirmed','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/'],
            'profile_photo' => ['nullable','image','mimes:jpeg,png,jpg,gif,webp','max:2048'],
        ], [
            'password.regex' => 'Password must be at least 8 characters and include upper, lower, digit, and special character.'
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profiles', 'public');
            $data['profile_photo'] = $path;
        }

        $employee->update($data);
        return redirect()->route('dashboard')->with('success', 'Profile updated.');
    }
}

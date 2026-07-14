<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payroll;
use App\Models\Employee;

class PayrollController extends Controller
{
    public function index()
    {
        if (session('role') == 'HR') {
            $payrolls = Payroll::all();
        } else {
            $payrolls = Payroll::where('employee_id', session('employee_id'))->get();
        }
        // Logic to retrieve and display payroll records
        return view('payrolls.index', compact('payrolls'));
    }

    public function create()
    {
        $employees = Employee::all();
        // Logic to show the form for creating a new payroll record
        return view('payrolls.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'salary' => 'required|numeric',
            'bonuses' => 'required|numeric',
            'deductions' => 'required|numeric',
            'pay_date' => 'required|date',
        ]);

        $netsalary = $request->salary + $request->bonuses - $request->deductions;
        $request->merge(['net_salary' => $netsalary]);

        Payroll::create($request->all());

        return redirect()->route('payrolls.index')->with('success', 'Payroll record created successfully.');
    }

    public function edit(Payroll $payroll)
    {
        $employees = Employee::all();
        // Logic to show the form for editing a payroll record
        return view('payrolls.edit', compact('payroll', 'employees'));
    }

    public function update(Request $request, Payroll $payroll)
    {
        $request->validate([
            'employee_id' => 'required',
            'salary' => 'required|numeric',
            'bonuses' => 'required|numeric',
            'deductions' => 'required|numeric',
            'pay_date' => 'required|date',
        ]);

        $netsalary = $request->salary + $request->bonuses - $request->deductions;
        $request->merge(['net_salary' => $netsalary]);

        $payroll->update($request->all());

        return redirect()->route('payrolls.index')->with('success', 'Payroll record updated successfully.');
    }

    public function show(Payroll $payroll)
    {
        // Logic to display a specific payroll record
        return view('payrolls.show', compact('payroll'));
    }

    public function destroy(Payroll $payroll)
    {
        $payroll->delete();
        return redirect()->route('payrolls.index')->with('success', 'Payroll record deleted successfully.');
    }
}

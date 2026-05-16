<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\SalaryAdvance;
use App\Models\Salary;
use App\Models\Expense;
use Illuminate\Support\Carbon;

class HRManagementController extends Controller
{
    // ── Employee Management ──
    public function employees()
    {
        $employees = Employee::where('vendor_id', auth()->id())->get();
        return view('admin.hr.employees.index', compact('employees'));
    }

    public function createEmployee() { return view('admin.hr.employees.create'); }

    public function storeEmployee(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'starting_salary' => 'required|numeric',
            'joining_date' => 'required|date',
            'photo' => 'nullable|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'nid_photo' => 'nullable|mimes:jpeg,png,jpg,gif,webp,svg,pdf|max:10240',
        ]);


        $data = $request->except(['photo', 'nid_photo']);
        $data['vendor_id'] = auth()->id();
        $data['current_salary'] = $request->starting_salary;
        $data['status'] = true;

        // Handle Photo Upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_photo.' . $photo->getClientOriginalExtension();
            if (!file_exists(base_path('uploads/hrm'))) mkdir(base_path('uploads/hrm'), 0777, true);
            $photo->move(base_path('uploads/hrm'), $photoName);
            $data['photo'] = 'uploads/hrm/' . $photoName;
        }

        // Handle NID Photo Upload
        if ($request->hasFile('nid_photo')) {
            $nidPhoto = $request->file('nid_photo');
            $nidPhotoName = time() . '_nid.' . $nidPhoto->getClientOriginalExtension();
            if (!file_exists(base_path('uploads/hrm'))) mkdir(base_path('uploads/hrm'), 0777, true);
            $nidPhoto->move(base_path('uploads/hrm'), $nidPhotoName);
            $data['nid_photo'] = 'uploads/hrm/' . $nidPhotoName;
        }

        Employee::create($data);

        return redirect()->route('manager.hr.employees')->with('success', 'Employee added successfully');
    }

    public function showEmployee($id)
    {
        $employee = Employee::with(['attendances', 'advances'])->findOrFail($id);
        return view('admin.hr.employees.show', compact('employee'));
    }

    public function editEmployee($id)
    {
        $employee = Employee::findOrFail($id);
        return view('admin.hr.employees.edit', compact('employee'));
    }

    public function updateEmployee(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'photo' => 'nullable|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'nid_photo' => 'nullable|mimes:jpeg,png,jpg,gif,webp,svg,pdf|max:10240',
        ]);


        $data = $request->except(['photo', 'nid_photo']);
        
        if ($request->hasFile('photo')) {
            if ($employee->photo && file_exists(base_path($employee->photo))) @unlink(base_path($employee->photo));
            $photo = $request->file('photo');
            $photoName = time() . '_photo.' . $photo->getClientOriginalExtension();
            $photo->move(base_path('uploads/hrm'), $photoName);
            $data['photo'] = 'uploads/hrm/' . $photoName;
        }

        if ($request->hasFile('nid_photo')) {
            if ($employee->nid_photo && file_exists(base_path($employee->nid_photo))) @unlink(base_path($employee->nid_photo));
            $nidPhoto = $request->file('nid_photo');
            $nidPhotoName = time() . '_nid.' . $nidPhoto->getClientOriginalExtension();
            $nidPhoto->move(base_path('uploads/hrm'), $nidPhotoName);
            $data['nid_photo'] = 'uploads/hrm/' . $nidPhotoName;
        }

        $employee->update($data);
        return redirect()->route('manager.hr.employees')->with('success', 'Employee updated successfully');
    }

    public function deleteEmployee($id)
    {
        $employee = Employee::findOrFail($id);
        if ($employee->photo && file_exists(base_path($employee->photo))) @unlink(base_path($employee->photo));
        if ($employee->nid_photo && file_exists(base_path($employee->nid_photo))) @unlink(base_path($employee->nid_photo));
        $employee->delete();
        return back()->with('success', 'Employee deleted successfully');
    }



    // ── Attendance ──
    public function attendance(Request $request)
    {
        $month = $request->month ?? date('Y-m');
        $employees = Employee::where('vendor_id', auth()->id())->where('status', true)->get();
        
        // Get all attendances for this month
        $attendances = Attendance::whereIn('employee_id', $employees->pluck('id'))
            ->where('date', 'like', $month . '%')
            ->get();

        $groupedAttendances = $attendances->groupBy('employee_id');

        // Calculate days in month
        $daysInMonth = Carbon::parse($month)->daysInMonth;

        return view('admin.hr.attendance.index', compact('employees', 'groupedAttendances', 'month', 'daysInMonth', 'attendances'));
    }


    public function storeAttendance(Request $request)
    {
        $month = $request->month;
        $attendanceData = $request->attendance ?? []; // [employee_id => [day => status]]

        foreach($attendanceData as $employee_id => $days) {
            foreach($days as $day => $status) {
                $date = $month . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                Attendance::updateOrCreate(
                    ['employee_id' => $employee_id, 'date' => $date],
                    ['status' => $status]
                );
            }
        }
        return back()->with('success', 'Monthly Attendance updated');
    }


    // ── Salary & Advances ──
    public function salary(Request $request)
    {
        $month = $request->month ?? date('Y-m');
        $employees = Employee::with(['advances' => function($q) use ($month) {
            $q->where('month', $month);
        }, 'attendances' => function($q) use ($month) {
            $q->where('date', 'like', $month.'%');
        }])->where('vendor_id', auth()->id())->get();

        $totalExpenses = Expense::where('vendor_id', auth()->id())
            ->where('date', 'like', $month.'%')
            ->sum('amount');

        // History Data
        $allAdvances = SalaryAdvance::with('employee')
            ->whereHas('employee', function($q) { $q->where('vendor_id', auth()->id()); })
            ->latest()
            ->paginate(15, ['*'], 'advance_page');

        $paidSalaries = Salary::with('employee')
            ->whereHas('employee', function($q) { $q->where('vendor_id', auth()->id()); })
            ->where('is_paid', true)
            ->latest()
            ->paginate(15, ['*'], 'payment_page');

        return view('admin.hr.salary.index', compact('employees', 'month', 'totalExpenses', 'allAdvances', 'paidSalaries'));
    }



    public function paySalary(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'month' => 'required',
            'base_salary' => 'required|numeric',
            'net_payable' => 'required|numeric',
        ]);

        Salary::updateOrCreate(
            ['employee_id' => $request->employee_id, 'month' => $request->month],
            [
                'base_salary' => $request->base_salary,
                'present_days' => $request->present_days ?? 0,
                'absent_days' => $request->absent_days ?? 0,
                'advances' => $request->advances ?? 0,
                'net_payable' => $request->net_payable,
                'is_paid' => true,
                'payment_date' => date('Y-m-d'),
            ]
        );

        return back()->with('success', 'Salary payment recorded successfully');
    }

    public function storeAdvance(Request $request)
    {
        SalaryAdvance::create([
            'employee_id' => $request->employee_id,
            'amount' => $request->amount,
            'date' => $request->date ?? date('Y-m-d'),
            'month' => date('Y-m', strtotime($request->date ?? date('Y-m-d'))),
            'note' => $request->note,
        ]);
        return back()->with('success', 'Advance added');
    }


    // ── Expenses ──
    public function expenses()
    {
        $expenses = Expense::where('vendor_id', auth()->id())->orderBy('date', 'desc')->get();
        return view('admin.hr.expenses.index', compact('expenses'));
    }

    public function storeExpense(Request $request)
    {
        Expense::create([
            'vendor_id' => auth()->id(),
            'category' => $request->category,
            'amount' => $request->amount,
            'date' => $request->date ?? date('Y-m-d'),
            'description' => $request->description,
        ]);
        return back()->with('success', 'Expense added');
    }
}

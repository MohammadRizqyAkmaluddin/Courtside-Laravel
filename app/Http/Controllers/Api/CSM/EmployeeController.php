<?php

namespace App\Http\Controllers\Api\CSM;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function indexEmployee(Request $request)
    {
        $data = Employee::where('venue_id', Auth::id());

        if ($request->filled('search')) {
            $data->where('name', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->filled('position')) {
            $data->where('position', $request->position);
        }
        if ($request->filled('salary')) {
            if ($request->salary == 'highest') {
                $data->orderBy('salary', 'DESC');
            } elseif ($request->salary == 'lowest') {
                $data->orderBy('salary', 'ASC');
            }
        }

        return response()->json([
            'success' => true,
            'data' => $data->get()
        ]);
    }


    public function getPositions()
    {
        $positions = Employee::where('venue_id', Auth::id())
            ->select('position')
            ->distinct()
            ->pluck('position');

        return response()->json($positions);
    }

    public function employeeSummary()
    {
        $employee = Employee::where('venue_id', Auth::id());

        $total_salary = $employee->sum('salary');
        $total_employee = $employee->count('id');

        return response()->json([
            'success' => true,
            'data' => [
                'total_salary' => $total_salary,
                'total_employee' => $total_employee,
            ]
        ]);
    }

    public function addEmployee(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone_number' => 'required|string',
            'gender' => 'required|string',
            'bod' => 'required|date',
            'religion' => 'required|string',
            'position' => 'required|string',
            'salary' => 'required|integer'
        ]);

        Employee::create([
            'venue_id' => Auth::id(),
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'bod' => $request->bod,
            'religion' => $request->religion,
            'position' => $request->position,
            'salary' => $request->salary,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully added employee'
        ]);
    }

    public function removeEmployee(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id'
        ]);

        $data = Employee::where('id', $request->employee_id)->delete();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function editSalary(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'salary' => 'required|integer'
        ]);

        $data = Employee::where('id', $request->employee_id)
                ->update(['salary' => $request->salary])
                ->first();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function editPosition(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'position' => 'required|string'
        ]);

        $data = Employee::where('id', $request->employee_id)
                ->update(['position' => $request->position])
                ->first();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{

    public function table()
    {
        $pageConfigs = ['has_table' => true];
        // $student = Student::get();
        // Studentt::get();
        return view('content.students', compact('pageConfigs'));
    }

    public function list(Request $request)
    {

        if ($request->ajax()) {
            $data = Student::limit($request->get('length'));
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="custom-control custom-control-primary custom-switch">
                    <input value="' . $row->id . '"  type="checkbox" checked="" class="custom-control-input status-switch" id="switch-' . $row->id . '">
                    <label class="custom-control-label" for="switch-' . $row->id . '"></label>
                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}

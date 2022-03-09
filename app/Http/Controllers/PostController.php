<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    public function table()
    {
        $pageConfigs = ['has_table' => true];

        return view('content.posts', compact('pageConfigs'));
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Post::limit($request->get('length'));
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('id', 'ID-{{$id}}')
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button class="btn btn-icon btn-danger btn-sm" type="button" data-toggle="tooltip" data-original-title="Delete">Delete</button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}

<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Mail\PostStatusChangedMail;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class AdminPostController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Post::orderBy('created_at', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex', function ($row) {
                    return $row->id;
                })


                ->addColumn('image', function ($row) {
                    $url = asset('storage/' . $row->thumbnail);
                    return '<img src="' . $url . '" alt="Image" height="50" width="50"/>';
                })


                ->addColumn('status', function ($row) {
                    $style = '';
                    if ($row->status === 'approved') {
                        $style = 'background-color: #d4edda; color: #155724; font-weight: 600;';
                    } elseif ($row->status === 'rejected') {
                        $style = 'background-color: #f8d7da; color: #721c24; font-weight: 600;';
                    } else {
                        $style = 'background-color: #fff3cd; color: #856404; font-weight: 600;';
                    }

                    return '<select data-id="' . $row->id . '" class="form-select status-select" style="' . $style . '">
                <option value="pending"' . ($row->status == 'pending' ? ' selected' : '') . '>Pending</option>
                <option value="approved"' . ($row->status == 'approved' ? ' selected' : '') . '>Approved</option>
                <option value="rejected"' . ($row->status == 'rejected' ? ' selected' : '') . '>Rejected</option>
            </select>';
                })


                ->addColumn('action', function ($row) {})


                ->rawColumns(['action', 'image', 'status'])
                ->make(true);
        }




        return view('backend.content.index');
    }

    public function changeStatus(Request $request, Post $post)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending'
        ]);

        $post->status = $request->status;
        $post->save();



        // Queue the email
        Mail::to($post->user->email)->queue(new PostStatusChangedMail($post));

        return response()->json([
            'status' => 'success',
            'message' => 'Post status updated to ' . ucfirst($request->status)
        ]);
    }
}

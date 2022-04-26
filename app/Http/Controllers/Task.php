<?php

namespace App\Http\Controllers;


use App\Models\TaskModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Task extends Controller
{
    public function insert(Request $request)
    {
        $data = $request->all();
        TaskModel::create($data);
        return response()->json(['success' => 'Post saved successfully.']);
    }

    public function show()
    {
        $data = TaskModel::all();

        return response()->json(['success' => 'Post saved successfully.', 'data' => $data]);
    }

    public function active()
    {
        $data = TaskModel::where('status', 'active')->get();

        return response()->json(['success' => 'Post saved successfully.', 'data' => $data]);
    }

    public function completed()
    {
        $data = TaskModel::where('status', 'completed')->get();

        return response()->json(['success' => 'Post saved successfully.', 'data' => $data]);
    }

    public function completedall()
    {
        DB::table('task')->update(['status' => 'completed']);
        return response()->json(['success' => 'Post saved successfully.']);
    }

    public function deleteall()
    {
        $data =  DB::table('task')->where('status', 'completed')->get();
        $message = '';
        if (!$data->isEmpty()) {
            DB::table('task')->where('status', 'completed')->delete();
            $message .= 'Success';
        } else {
            $message .= 'Failed';
        }
        return response()->json(['success' => $message]);
    }

    public function update($id)
    {
        $task = TaskModel::where('id', $id)->first();

        if ($task->status == 'active') {
            $status = 'completed';
        } else {
            $status = 'active';
        }
        $task->update(['status' => $status]);
        return response()->json(['success' => 'Post saved successfully.']);
    }
}

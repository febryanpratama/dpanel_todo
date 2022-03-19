<?php

namespace App\Http\Controllers;

use App\Models\todo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    //
    public function getTODO()
    {
        // Get Data
        $data = todo::get();
        
        // Return JSON
        return response()->json(['code' => 200, 'status'=>true, 'data' => $data]);
    }

    public function createTODO(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'todo' => 'required',
        ]);

        if ($validator->fails()) {
            # code...
            return response()->json(['code'=>404, 'status'=>false, 'data'=>$validator->errors()]);
        }

        // Use Method Controller for MVC
        $status = methodController::createTODO($request);

        if ($status == true) {
            // Return JSON
            return response()->json(['code' => 200, 'status'=>true, 'data' => 'Your Data has been post']);
        }else{
            // Return JSON
            return response()->json(['code'=>404, 'status'=>false, 'data'=> 'Cannot Post your data']);

        }

    }

    public function updateTODO(Request $request)
    {

        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'todo' => 'required',
        ]);

        if ($validator->fails()) {
            # code...
            return response()->json(['code'=>404, 'status'=>false, 'data'=>$validator->errors()]);
        }

        $status = methodController::updateTODO($request);

        if ($status == true) {
            // Return JSON
            return response()->json(['code' => 200, 'status'=>true, 'data' => 'Your Data has been updated']);
        }else{
            // Return JSON
            return response()->json(['code'=>404, 'status'=>false, 'data'=> 'Cannot Update your TODO']);

        }

        
    }
    
    public function deleteTODO(Request $request)
    {
        $status = methodController::deleteTODO($request);

        if ($status == true) {
            // Return JSON
            return response()->json(['code' => 200, 'status'=>true, 'data' => 'Your Data has been Deleted']);
        }else{
            // Return JSON
            return response()->json(['code'=>404, 'status'=>false, 'data'=> 'Cannot Delete your TODO']);

        }
        
    }
    
    public function doneTODO(Request $request)
    {
        $status = methodController::doneTODO($request);
        if ($status == true) {
            // Return JSON
            return response()->json(['code' => 200, 'status'=>true, 'data' => 'Your Status TODO has been Updated']);
        }else{
            // Return JSON
            return response()->json(['code'=>404, 'status'=>false, 'data'=> 'Cannot Update your TODO']);
        }
    }
}

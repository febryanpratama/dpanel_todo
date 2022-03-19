<?php
namespace App\Http\Controllers;

use App\Models\todo;
use Carbon\Carbon;

class methodController {
    public static function createTODO($request){
        $data = todo::create([
            'todo' => $request->todo,
            'is_done' => 'false',
        ]);

        if ($data) {
            return true;
        }else{
            return false;
        }
    }

    public static function updateTODO($request){
        $todo = todo::findOrfail($request->id);

        $data = $todo->update([
            'todo' => $request->todo,
            'updated_at' => Carbon::now()
        ]);

        if ($data) {
            return true;
        }else{
            return false;
        }
    }

    public static function deleteTODO($request){
        $todo = todo::findOrfail($request->id);
        $data = $todo->delete();

        if ($data) {
            return true;
        }else{
            return false;
        }
    }
    public static function doneTODO($request){
        $todo = todo::findOrfail($request->id);
        $data = $todo->update([
            'is_done'=>'true'
        ]);

        if ($data) {
            return true;
        }else{
            return false;
        }
    }
}

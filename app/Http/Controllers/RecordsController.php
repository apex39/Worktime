<?php

namespace App\Http\Controllers;
use App\Record;
use Auth;
use Illuminate\Http\Request;

class RecordsController extends Controller
{

    private function getLoggedWorkers(){

    }

    public function addStartRecord(Request $request){
        if (Auth::user()->checkRole("worker")) {
            $record = new Record();
            $record->action_id = ActionType::where('action_name', $request->type)->action_id; //request->type: WORK or BREAK
            $record->user_id = Auth::user()->id;
            $record->save();
            return response()
                ->json([
                'created' => 'true'
            ]);
        } else
            return response()
                ->json([
                    'created' => 'true'
                ], 403);
    }
}

<?php

namespace App\Http\Controllers;

use App\ActionType;
use App\Record;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Log;

class RecordsController extends Controller
{

    public function showLoggedWorkers()
    {
        if (Auth::user()->checkRole("admin") || Auth::user()->checkRole("manager")) {
            $logged_workers = User::whereHas('records', function ($q) {
                $q->where('finished', '=', false);
            })->with(['records' => function ($q) {
                $q->where('finished', '=', false);
            }, 'shops'])->get();

            if ($logged_workers->isEmpty()) {
                $logged_workers = null;
            } elseif (Auth::user()->checkRole("manager")) {
                $shops = Auth::user()->shops;

                foreach ($logged_workers as $worker_id => $worker) {
                    if ($worker->shops == null) {
                        Log::warning("Worker " . $worker->id . " has no shop assigned. Omitting.");
                        $logged_workers->forget($worker_id);
                    } elseif (!$shops->contains($worker->shops->first()))
                        $logged_workers->forget($worker_id);
                }
            }
            if ($logged_workers != null) {
                foreach ($logged_workers as $worker_id => $worker) {
                    $records = $worker->records;
                    foreach ($records as $record) {
                        $records_dates[] = $record->created_at;
                    }
                }
            }
            return view('home', compact('logged_workers', 'records_dates'));
        } else
            return abort(403, 'Unauthorized action.');
    }

    public function addStartRecord(Request $request)
    {
        Log::info("Trying to add a record for user id: " . Auth::user()->id);
        $action_id = ActionType::where('action_name', $request->type)->first()->action_id; //request->type: WORK or BREAK
        Log::info("Action type requested: " . $request->type . " id:" . $action_id);

        if (Auth::user()->checkRole("worker")) {
            if (Record::where(['user_id' => Auth::user()->id, 'finished' => false, 'action_id' => $action_id])->count() == 0) {
                $record = new Record;
                $record->action_id = $action_id;
                $record->user_id = Auth::user()->id;
                $record->finished = false;
                if ($record->save()) Log::info("Record successfully saved, id: " . $record->id);
                return response()
                    ->json([
                        'status' => true,
                        'record_id' => $record->id
                    ]);
            } else {
                Log::error("Cannot save a new record - time counting already been started");
                return response()
                    ->json([
                        'status' => false,
                        'message' => 'Timer has already been started for the user!'
                    ], 405);
            }
        } else
            Log::error("Authenticated user is not of a worker type");
        return response()
            ->json([
                'status' => false
            ], 403);
    }

    public function finishRecord(Request $request)
    {
        Log::info("Trying to finish a record for user id: " . Auth::user()->id);
        if (Auth::user()->checkRole("worker")) {
            if ($record = Record::where('id', $request->input('record_id'))->first()) {
                Log::info("Found record with id: " . $record->id);
                $record->finished = true;

                /*Minutes spent is deprecated*/
//                $created_at = strtotime($record->created_at);
//                $now = strtotime(time());
//                $interval  = abs($now - $created_at);
//                $minutes   = round($interval / 60);
//                $record->minutes_spent = $minutes;
//                Log::info("Minutes spent on the activity: " . $record->minutes_spent);

                if ($record->save()) {
                    Log::info("Record successfully finished.");
                    return response()->json([
                        'status' => true
                    ]);
                } else {
                    Log::error("Cannot finish record: " . $record->id);
                }
            } else {
                Log::error("Record with id: " . $request->input('record_id') . " not found");
            }
        } else {
            Log::error("Authenticated user is not of a worker type");
            return response()
                ->json([
                    'status' => false
                ], 403);
        }
    }

    public function openWorkerDetailsView(User $user)
    {
        $records = $user->records()->where('finished', true)->get();

        return view('user.worker.details', ['records' => $records, 'user' => $user]);
    }
}

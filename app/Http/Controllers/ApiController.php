<?php

namespace App\Http\Controllers;

use App\Shop;
use Auth;
use Illuminate\Http\Request;
use Log;

class ApiController extends Controller
{
    public function loginUser(Request $request)
    {
        Log::debug("Login try: " . $request);
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'active' => true])) {
            if (Auth::user()->checkRole("admin")) {
                return response()->json(['role' => 'admin', 'status' => true]);

            } elseif (Auth::user()->checkRole("manager")) {
                return response()->json(['role' => 'manager', 'status' => true]);

            } elseif (Auth::user()->checkRole("worker")) {
                if(Auth::user()->shops()->where('address', $request->shop)->first()){
                    return response()->json(['role' => 'worker', 'status' => true]);
                } else {
                    return response()->json(['role' => 'null', 'status' => false], 200); //null is sent as string as GSON doesn't serialize nulls
                }
            } else
                return response()->json(null, 403);
        } elseif (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            if (Auth::user()->checkRole("worker") && Auth::user()->active == false) {
                return response()->json(['role' => 'worker', 'status' => "not_activated"]);
            }
        } else
            return response()->json(['role' => 'null', 'status' => false], 200); //null is sent as string as GSON doesn't serialize nulls
    }

    public function activateUser(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'active' => false])) {
            if (Auth::user()->checkRole("worker")) {
                $user = Auth::user();
                $user->password = bcrypt($request->new_password);
                $user->active = true;
                if($user->save()) {
                    return response()->json(['role' => 'activation', 'status' => true]);
                }
                else {
                    return response()->json(['role' => 'activation', 'status' => false]);
                }
            } else
                return response()->json(null, 403);
        }
        return response()->json(null, 403);
    }

    public function sendAllShops(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'active' => true])) {
            if (Auth::user()->checkRole("admin")) {
                $shops = Shop::all();
                return response()->json($shops);
            }
        }
        return response()->json(null, 403);
    }

    public function sendManagerShops(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'active' => true])) {

            if (Auth::user()->checkRole("manager")) {
                $user_shops = Auth::user()->shops()->get();
                return response()->json($user_shops);
            }
        }
        return response()->json(null, 403);
    }

    public function sendUserRecords(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'active' => true])) {

            if (Auth::user()->checkRole("worker")) {
                $records = Auth::user()->records;
                return response()->json($records);
            }
        }
        return response()->json(null, 403);
    }

    public function sendUserDetails(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'active' => true])) {
            $user = Auth::user();
            $records = $user->records()->where('finished', true)->get();
            return view('user.worker.apiDetails', ['records' => $records, 'user' => $user]);
        }
        return response()->json(null, 403);
    }

    public function addRecordWrapper(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'active' => true])) {
            $recordsController= \App::make(RecordsController::class);
            return $recordsController->addStartRecord($request);

        }
        return response()->json(null, 403);
    }
    public function finishRecordWrapper(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'active' => true])) {
            $recordsController= \App::make(RecordsController::class);
            return $recordsController->finishRecord($request);

        }
        return response()->json(null, 403);
    }
}

<?php

namespace App\Http\Controllers;

use App\Role;
use App\Shop;
use App\User;
use Auth;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /* Manager functions */
    public function managers()
    {
    	if(Auth::user()->checkRole("admin")) {
    		$users = User::whereHas('roles', function ($query) {
    			$query->where('role_name', '=', 'manager');
			})->get();


    		return view('user.list', compact('users'));
    	}
    	return abort(403, 'Unauthorized action.');
    }

    public function openAddManagerView()
    {
    	if(Auth::user()->checkRole("admin")) {
			$shops = Shop::all(); // Manager's assigned to some shops
    		return view('user.add', compact('shops'));
    	}
    	return abort(403, 'Unauthorized action.');

    }
    public function openEditManagerView(User $user)
    {
        if(Auth::user()->checkRole("admin")) {
            $shops = Shop::all();
            $user_shops = $user->shops()->get();

            return view('user.edit', compact('shops', 'user', 'user_shops'));
        }
        return abort(403, 'Unauthorized action.');

    }
    public function addManager(Request $request)
    {
        if(Auth::user()->checkRole("admin")) {
        	$manager = new User;
        	$manager->username = strtolower($request->name.".".$request->surname);
        	$manager->name = $request->name;
        	$manager->surname = $request->surname;
        	$manager->email = $request->email;
        	$manager->password = bcrypt("abcd1234");
        	$manager->active = false;
            $manager->save(); //Must be saved before role and shop, to have its id to pivot table

            $role = Role::where('role_name', 'manager')->first();
            $manager->roles()->save($role);


            foreach ($request->shops as $shop_id) {
                $shop = Shop::find($shop_id);
                $manager->shops()->save($shop);
            }
            flash($manager->username.' added successfully!', 'success');
            return redirect('managers');
        }
        return abort(403, 'Unauthorized action.');
    }


    public function updateManager(User $user, Request $request)
    {
         if(Auth::user()->checkRole("admin")) {
            $user->update($request->all());
            $user->shops()->sync($request->shops);
            flash($user->username.' modified successfully!', 'success');
            return redirect('managers');
        }
        return abort(403, 'Unauthorized action.');
    }


    public function deleteManager(User $user)
    {
        if(Auth::user()->checkRole("admin")) {
            $user->roles()->detach();
            $user->shops()->detach();
            $user->delete();
            flash($user->username.' deleted successfully!', 'success');
            return redirect('managers');
        }
        return abort(403, 'Unauthorized action.');
    }

    /* Worker functions */
    public function workers()
    {
        if(Auth::user()->checkRole("admin")) {
            $shops = Shop::with('users.roles')->get();
            $isAdmin = true;
            return view('user.worker.list', compact('shops', 'isAdmin'));

        } elseif(Auth::user()->checkRole("manager")) {
            $shops = Auth::user()->shops->load('users.roles');
            $isAdmin = false;
            return view('user.worker.list', compact('shops', 'isAdmin'));
    }
        return abort(403, 'Unauthorized action.');
    }

    public function openAddWorkerView()
    {
        if(Auth::user()->checkRole("admin") || Auth::user()->checkRole("manager")) {
            $digits = 4;

            // Randomize worker id until it's not found in database
            do {
                $worker_id = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
            }
            while (User::where('username', '=', $worker_id)->exists());

            if (Auth::user()->checkRole("admin")){
                $shops = Shop::all(); // worker's assigned to a shop
            } elseif (Auth::user()->checkRole("manager")) {
                $shops = Auth::user()->shops;
            }
            return view('user.worker.add', compact('shops', 'worker_id'));
        }
        return abort(403, 'Unauthorized action.');

    }
    public function openEditWorkerView(User $user)
    {
        if(!$user->checkRole("worker")) return abort(403, 'Unauthorized action.');

        if(Auth::user()->checkRole("admin")) {
            $shops = Shop::all();
            $user_shops = $user->shops()->get();
            return view('user.worker.edit', compact('shops', 'user', 'user_shops'));

        } elseif(Auth::user()->checkRole("manager")) {
            $shops = Auth::user()->shops;
            $user_shops = $user->shops()->get();
            return view('user.worker.edit', compact('shops', 'user', 'user_shops'));
        } else
            return abort(403, 'Unauthorized action.');
    }

    public function addWorker(Request $request, String $worker_id)
    {
        if(Auth::user()->checkRole("admin") || Auth::user()->checkRole("manager")) {
            $worker = new User;
            $worker->username = $worker_id;
            $worker->name = $request->name;
            $worker->surname = $request->surname;
            $worker->email = $request->email;
            $worker->working_hours = $request->working_hours;
            $worker->password = bcrypt("1234");
            $worker->active = false;
            $worker->save(); //Must be saved before role and shop, to have its id to pivot table

            $role = Role::where('role_name', 'worker')->first();
            $worker->roles()->save($role);


            foreach ($request->shops as $shop_id) {
                $shop = Shop::find($shop_id);
                $worker->shops()->save($shop);
            }
            flash($worker->name.' '.$worker->surname.' with '.$worker_id.' ID added successfully!', 'success');
            return redirect('workers');
        }
        return abort(403, 'Unauthorized action.');
    }


    public function updateWorker(User $user, Request $request)
    {
        if(Auth::user()->checkRole("admin") || Auth::user()->checkRole("manager")) {
            $this->validate($request, [
                'username' => 'digits:4',
                'working_hours' => 'integer',
            ]);
            $user->update($request->all());
            $user->shops()->sync($request->shops);
            flash($user->username.' modified successfully!', 'success');
            return redirect('workers');
        }
        return abort(403, 'Unauthorized action.');
    }

    public function resetPassword(User $user)
    {
        if(Auth::user()->checkRole("admin") || Auth::user()->checkRole("manager")) {
            $user->update(['password' => bcrypt("1234"), 'active' => false]);

            flash($user->username.' password resetted successfully!', 'success');
            return redirect('workers');
        }
        return abort(403, 'Unauthorized action.');
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
        ]);
        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->active = true;
        $user->save();
        flash('New password was successfully set!', 'success');
        return redirect('home');
    }

    public function deleteWorker(User $user)
    {
        if(Auth::user()->checkRole("admin") || Auth::user()->checkRole("manager")) {
            $user->roles()->detach();
            $user->shops()->detach();
            $user->delete();
            flash($user->username.' deleted successfully!', 'success');
            return redirect('workers');
        }
        return abort(403, 'Unauthorized action.');
    }
}

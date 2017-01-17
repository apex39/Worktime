<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\User;
use App\Shop;
use App\Role;

//TODO: Delete passing page names to views - code it in each view to make it simpler
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
    		$pageName = "Managers";
    		$users = User::whereHas('roles', function ($query) {
    			$query->where('role_name', '=', 'manager');
			})->get();


    		return view('user.list', compact('pageName', 'users'));
    	}
    	return abort(403, 'Unauthorized action.');
    }

    public function openAddManagerView()
    {
    	if(Auth::user()->checkRole("admin")) {
    		$pageName = "Add manager";

			$shops = Shop::all(); // Manager's assigned to some shops
    		return view('user.add', compact('pageName', 'shops'));
    	}
    	return abort(403, 'Unauthorized action.');

    }
    public function openEditManagerView(User $user)
    {
        if(Auth::user()->checkRole("admin")) {
            $pageName = "Edit manager";

            $shops = Shop::all();
            $user_shops = $user->shops()->get();

            return view('user.edit', compact('pageName', 'shops', 'user', 'user_shops'));
        } 
        return abort(403, 'Unauthorized action.');

    }
    public function addManager(Request $request)
    {
        if(Auth::user()->checkRole("admin")) {
        	$manager = new User;
        	$manager->username = $request->name.".".$request->surname;
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
        if(Auth::user()->checkRole("admin") || Auth::user()->checkRole("manager")) {
            $pageName = "Workers";
            $shops = Shop::with('users.roles')->get();

            return view('user.worker.list', compact('pageName', 'shops'));
        }
        return abort(403, 'Unauthorized action.');
    }

    public function openAddWorkerView()
    {
        if(Auth::user()->checkRole("admin") || Auth::user()->checkRole("manager")) {
            $pageName = "Add worker";
            $digits = 4;

            // Randomize worker id until it's not found in database
            do {
                $worker_id = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
            }
            while (User::where('worker_id', '=', $worker_id)->exists());

            $shops = Shop::all(); // worker's assigned to a shop
            return view('user.worker.add', compact('pageName', 'shops', 'worker_id'));
        }
        return abort(403, 'Unauthorized action.');

    }
    public function openEditWorkerView(User $user)
    {
        if(Auth::user()->checkRole("admin") || Auth::user()->checkRole("manager")) {
            $pageName = "Edit worker";

            $shops = Shop::all();
            $user_shops = $user->shops()->get();

            return view('user.edit', compact('pageName', 'shops', 'user', 'user_shops'));
        }
        return abort(403, 'Unauthorized action.');

    }
    public function addWorker(Request $request, String $worker_id)
    {
        if(Auth::user()->checkRole("admin") || Auth::user()->checkRole("manager")) {
            $worker = new User;
            $worker->username = $request->name.".".$request->surname;
            $worker->name = $request->name;
            $worker->surname = $request->surname;
            $worker->email = $request->email;
            $worker->worker_id= $worker_id;
            $worker->password = bcrypt("abcd1234");
            $worker->active = false;
            $worker->save(); //Must be saved before role and shop, to have its id to pivot table

            $role = Role::where('role_name', 'worker')->first();
            $worker->roles()->save($role);


            foreach ($request->shops as $shop_id) {
                $shop = Shop::find($shop_id);
                $worker->shops()->save($shop);
            }
            flash($worker->username.' with '.$worker_id.' ID added successfully!', 'success');
            return redirect('workers');
        }
        return abort(403, 'Unauthorized action.');
    }


    public function updateworker(User $user, Request $request)
    {
        if(Auth::user()->checkRole("admin") || Auth::user()->checkRole("manager")) {
            $user->update($request->all());
            $user->shops()->sync($request->shops);
            flash($user->username.' modified successfully!', 'success');
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

    public function deleteworker(User $user)
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
    private function isLoggedAsAdmin() //TODO
    {
        
    }


}

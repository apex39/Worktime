<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\User;
use App\Shop;
use App\Role;

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

    public function managers()
    {
    	if(Auth::user()->checkRole("admin")) {
    		$pageName = "Managers";
    		$users = User::whereHas('roles', function ($query) {
    			$query->where('role_name', '=', 'manager');
			})->get();


    		return view('list_elements', compact('pageName', 'users'));
    	}
    	return abort(403, 'Unauthorized action.');
    }

    public function openAddManagerView()
    {
    	if(Auth::user()->checkRole("admin")) {
    		$pageName = "Add manager";

			$shops = Shop::all();
    		return view('add_user', compact('pageName', 'shops'));
    	}
    	return abort(403, 'Unauthorized action.');

    }
    public function openEditManagerView(User $user)
    {
        if(Auth::user()->checkRole("admin")) {
            $pageName = "Edit manager";

            $shops = Shop::all();
            $user_shops = $user->shops()->get();

            return view('edit_user', compact('pageName', 'shops', 'user', 'user_shops'));
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
            return back();
        }
        return abort(403, 'Unauthorized action.');
    }


    public function updateManager(User $user, Request $request)
    {
         if(Auth::user()->checkRole("admin")) {
            $user->update($request->all());
            $user->shops()->sync($request->shops);
            flash($user->username.' modified successfully!', 'success');
            return back();
        }
        return abort(403, 'Unauthorized action.');
    }


    public function deleteManager(User $user)
    {
        if(Auth::user()->checkRole("admin")) {
            $user->delete();
            flash($user->username.' deleted successfully!', 'success');
            return ur();
        }
        return abort(403, 'Unauthorized action.');
    }

    private function isLoggedAsAdmin() //TODO
    {
        
    }
}

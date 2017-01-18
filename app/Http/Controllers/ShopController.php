<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Auth;

use App\Shop;
use App\User;

class ShopController extends Controller
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

    public function getShops()
    {
        if(Auth::user()->checkRole("admin")) {
            $shops= Shop::all();
            $isAdmin = true;
            return view('shop.list', compact('shops', 'isAdmin'));

        } elseif(Auth::user()->checkRole("manager")) {
            $shops= Auth::user()->shops;
            $isAdmin = false;
            return view('shop.list', compact('shops', 'isAdmin'));
        } else
            return abort(403, 'Unauthorized action.');
    }

    public function openAddShopView()
    {
        if(Auth::user()->checkRole("admin")) {
            return view('shop.add');
        }
        return abort(403, 'Unauthorized action.');

    }
    public function addShop(Request $request)
    {
        if(Auth::user()->checkRole("admin")) {
            $shop = new Shop;
            $shop->address = $request->address;
            $shop->phone = $request->phone;
            $shop->opening_time = $request->opening_time.":00:00"; //convert to hh:mm:ss, for TIME column in db
            $shop->closing_time = $request->closing_time.":00:00";
            $shop->break_time = $request->break_time;
            $shop->save();

            flash($shop->address.' shop added successfully!', 'success');
            return redirect('shops');
        }
        return abort(403, 'Unauthorized action.');
    }
    public function openEditShopView(Shop $shop)
    {
        if(Auth::user()->checkRole("admin") || Auth::user()->checkRole("manager")) {
            $opening_date = DateTime::createFromFormat("H:i:s", $shop->opening_time);
            $closing_date = DateTime::createFromFormat("H:i:s", $shop->closing_time);

            $shop->opening_hour = $opening_date->format('H');
            $shop->closing_hour = $closing_date->format('H');

            $isAdmin = Auth::user()->checkRole("admin");
            return view('shop.edit', compact('shop', 'isAdmin'));
        }
        return abort(403, 'Unauthorized action.');
    }


    public function updateShop(Shop $shop, Request $request)
    {
        if(Auth::user()->checkRole("admin") || Auth::user()->checkRole("manager")) {
            $input = $request->all();
            $input['opening_time'] = $input['opening_time'].":00:00"; //convert int to hh:mm:ss, for TIME column in db
            $input['closing_time'] = $input['closing_time'].":00:00";

            $shop->update($input);
            flash($shop->address.' shop modified successfully!', 'success');
            return redirect('shops');
        }
        return abort(403, 'Unauthorized action.');
    }


    public function deleteShop(Shop $shop)
    {
        if(Auth::user()->checkRole("admin")) {
            $shop->delete();
            flash($shop->address.' shop deleted successfully!', 'success');
            return redirect('shops');
        }
        return abort(403, 'Unauthorized action.');
    }
}

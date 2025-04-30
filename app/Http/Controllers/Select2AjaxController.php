<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\Wallet;
use Illuminate\Http\Request;

class Select2AjaxController extends Controller
{
    public function wallet(Request $request)
    {
        $wallets = Wallet::with(['user']) // using eagerloading
            ->when($request->search, function($q1) use ($request){
            $q1->whereHas('user', function($q2) use ($request){ // wherehas => user is serached as keyword or name
                $q2->where('name', 'LIKE', "%$request->search%");
            });
        })
            ->paginate(5);
        return $wallets;
    }


    public function station(Request $request)
    {
        
        $stations = Station::select('id','title') // using eagerloading
            ->when($request->search, function($q1) use ($request){
                $q1->whereHas('title', 'LIKE', "%$request->search%");
        })->paginate(5);
                
        return $stations;
    }
}

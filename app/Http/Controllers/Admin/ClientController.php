<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
   
    public function index(Request $request)
    {
        $search_name = $request->get('search_name');
        $search_phone = $request->get('search_phone');
        $users = User::where('is_client', true)
            ->when($search_name, function ($q) use ($search_name) {
                $q->where('name', 'like', '%'.$search_name.'%');
            })
            ->when($search_phone, function ($q) use ($search_phone) {
                $q->where('phone', 'like', '%'.$search_phone.'%');
            })
            ->paginate(20);

        return view('admin.clients.index', compact('users'));
    }    
}

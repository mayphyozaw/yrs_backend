<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    
    protected $userRespository;

    public function __construct(UserRepository $userRespository)
    {
        $this->userRespository = $userRespository;
    }
    
    
    
    public function index()
    {
        return view('user.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->userRespository->datatable($request);
        }
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(UserStoreRequest $request)
    {
        try {
            $this->userRespository->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            
            return Redirect::route('user.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = $this->userRespository->find($id);
        return view('user.edit', compact('user'));
    }

    public function update($id, UserUpdateRequest $request)
    {
        try {
            $this->userRespository->update($id,[
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request) : $this->userRespository->find($id)->password,
            ]);
            
            return Redirect::route('user.index')->with('success', 'Successfully updated');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->userRespository->delete($id);
            
            
            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}

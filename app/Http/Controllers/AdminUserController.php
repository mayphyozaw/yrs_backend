<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminUserStoreRequest;
use App\Http\Requests\AdminUserUpdateRequest;
use App\Models\AdminUser;
use App\Repositories\AdminUserRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AdminUserController extends Controller
{
    
    protected $adminUserRespository;

    public function __construct(AdminUserRepository $adminUserRespository)
    {
        $this->adminUserRespository = $adminUserRespository;
    }
    
    
    
    public function index()
    {
        return view('admin-user.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->adminUserRespository->datatable($request);
        }
    }

    public function create()
    {
        return view('admin-user.create');
    }

    public function store(AdminUserStoreRequest $request)
    {
        try {
            $this->adminUserRespository->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            
            return Redirect::route('admin-user.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $admin_user = $this->adminUserRespository->find($id);
        return view('admin-user.edit', compact('admin_user'));
    }

    public function update($id, AdminUserUpdateRequest $request)
    {
        try {
            $this->adminUserRespository->update($id,[
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request) : $this->adminUserRespository->find($id)->password,
            ]);
            
            return Redirect::route('admin-user.index')->with('success', 'Successfully updated');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->adminUserRespository->delete($id);
            
            
            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}

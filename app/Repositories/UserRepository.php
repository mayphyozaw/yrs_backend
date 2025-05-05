<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class UserRepository implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = User::class;
    }

    public function find($id)
    {
        $record = $this->model::find($id);
        return $record;
    }

    public function findByEmail($email)
    {
        $record = $this->model::where('email', $email)->first();
        return $record;
    }

    public function create(array $data)
    {
        $record = $this->model::create($data);
        return $record;
    }

    public function update($id, array $data)
    {
        $record = $this->model::find($id);
        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->model::find($id);
        $record->delete();
    }


    public function datatable(Request $request)
    {
        $model = $this->model::query();

        return DataTables::eloquent($model)
            ->editColumn('email_verified_at', function ($user) {
                return $user -> email_verified_at ? Carbon::parse($user->email_verified_at)->format("Y-m-d H:i:s") : '';
            })
            ->editColumn('created_at', function ($user) {
                return Carbon::parse($user->created_at)->format("Y-m-d H:i:s");
            })
            ->editColumn('updated_at', function ($user) {
                return Carbon::parse($user->updated_at)->format("Y-m-d H:i:s");
            })
            ->addColumn('action', function ($user) {
                return view('user._action', compact('user'));
            })
            ->addColumn('responsive-icon', function ($data) {
                return null;
            })
            ->toJson();
    }
}

<?php

namespace App\Repositories;

use App\Models\Route;
use App\Models\Station;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class RouteRepository implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = Route::class;
    }

    public function find($id)
    {
        $record = $this->model::find($id);
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
            ->editColumn('description', function ($route) {
                return Str::limit($route->description,50);
            })
            ->editColumn('direction', function ($route) {
                return '<span style="color: #' . $route->acsrDirection['color'] . '">' . $route->acsrDirection['text'] . '</span>';
            })
            ->editColumn('created_at', function ($route) {
                return Carbon::parse($route->created_at)->format("Y-m-d H:i:s");
            })
            ->editColumn('updated_at', function ($route) {
                return Carbon::parse($route->updated_at)->format("Y-m-d H:i:s");
            })
            ->addColumn('action', function ($route) {
                return view('route._action', compact('route'));
            })
            ->addColumn('responsive-icon', function ($route) {
                return null;
            })
            ->rawColumns(['direction','action'])
            ->toJson();
    }
}

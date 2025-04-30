<?php

namespace App\Repositories;

use App\Models\RouteStation;
use App\Repositories\Contracts\BaseRepository;


class RouteStationRepository implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = RouteStation::class;
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


    public function deleteByRouteId($route_id)
    {
        $this->model::where('route_id',$route_id)->delete();
    }

    
}

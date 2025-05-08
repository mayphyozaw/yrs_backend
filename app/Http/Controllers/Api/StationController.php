<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StationDetailResource;
use App\Http\Resources\StationResource;
use App\Repositories\StationRepository;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class StationController extends Controller
{
    protected $stationRepository;

    public function __construct(StationRepository $stationRepository)
    {
        $this->stationRepository = $stationRepository;
    }
    
    public function index(Request $request)
    {
        $stations = $this->stationRepository->query()
            ->when($request->search, function ($q1) use ($request) {
                $q1->where('tile', 'LIKE', "%$request->search%")
                    ->orWhere('description', 'LIKE', "%$request->search%");
                   
            })
            ->paginate(10);
        return StationResource::collection($stations)->additional(['message' => 'success']);
    }


    public function show($slug)
    {
        
        $station = $this->stationRepository->queryBySlug($slug)
            ->with(['routes'])    
            ->firstOrFail();

        return ResponseService::success(new StationDetailResource($station));
    }


    public function byRegion(Request $request)
    {
        $stations = $this->stationRepository->query()
            ->whereBetween('latitude',[$request->south_west_latitude, $request->noth_east_latitude])
            ->whereBetween('latitude',[$request->south_west_latitude, $request->noth_east_latitude])
            ->take(20)
            ->get();

            return StationResource::collection($stations)->additional(['message' => 'success']);

    }
}



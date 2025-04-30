<?php

namespace App\Http\Controllers;

use App\Http\Requests\RouteStoreRequest;
use App\Http\Requests\RouteUpdateRequest;
use App\Models\Route;
use App\Models\RouteStation;
use App\Models\Station;
use App\Repositories\RouteRepository;
use App\Repositories\RouteStationRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;



class RouteController extends Controller
{
    protected $routeRespository;
    protected $routeStationRespository;

    public function __construct(RouteRepository $routeRespository, RouteStationRepository $routeStationRepository)
    {
        $this->routeRespository = $routeRespository;
        $this->routeStationRespository = $routeStationRepository;
    }



    public function index()
    {
        // return Route::with('stations')->find(1);
        return view('route.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->routeRespository->datatable($request);
        }
    }

    public function create()
    {
        $selected_stations = Station::whereIn('id',collect(old('schedule'))->pluck('station_id')->toArray())->get(['id','title']);
       
        $schedule = collect(old('schedule'))->map(function($item) use ($selected_stations){
            return [
                'station_id' => $item['station_id'],
                'station_title' => collect($selected_stations)->where('id',$item['station_id'])->first()->title ?? '',
                'time' => $item['time']
            ];
        });
        return view('route.create',compact('schedule'));
    }



    public function store(RouteStoreRequest $request)
    {
        
        DB::beginTransaction();
        
        try {
            $route = $this->routeRespository->create([
                'slug' => Str::slug($request->title) . '-' . Str::random(6),
                'title' => $request->title,
                'description' => $request->description,
                'direction' => $request->direction,
               
            ]);

            $schedule = collect($request->schedule)->mapWithKeys(function ($item) {
                return [
                    $item['station_id'] => [
                        'time' => $item['time'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                ];
            });

            $route->stations()->sync($schedule);
              
            // foreach ($request->schedule as $item) {
            //    $this->routeStationRespository->create([
            //     'route_id' => $route->id,
            //     'station_id' => $item['station_id'],
            //     'time' => $item['time']
            //    ]);
            // }
            
            DB::commit();
            return Redirect::route('route.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $route = $this->routeRespository->find($id);
        $route_stations = RouteStation::where('route_id',$route->id)->get(['station_id','time']);
        $selected_stations = Station::whereIn('id',collect(old('schedule',$route_stations))->pluck('station_id')->toArray())->get(['id','title']);
       
        $schedule = collect(old('schedule',$route_stations))->map(function($item) use ($selected_stations){
            return [
                'station_id' => $item['station_id'],
                'station_title' => collect($selected_stations)->where('id',$item['station_id'])->first()->title ?? '',
                'time' => $item['time']
            ];
        });
        return view('route.edit', compact('route','schedule'));
    }

    public function update($id, RouteUpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            $route = $this->routeRespository->create([
                'slug' => Str::slug($request->title) . '-' . Str::random(6),
                'title' => $request->title,
                'description' => $request->description,
                'direction' => $request->direction,
               
            ]);

            $schedule = collect($request->schedule)->mapWithKeys(function ($item) {
                return [
                    $item['station_id'] => [
                        'time' => $item['time'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                ];
            });
            $route->stations()->sync($schedule);

            DB::commit();
            return Redirect::route('route.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $route = $this->routeRespository->find($id);
        return view('route.show', compact('route'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->routeRespository->delete($id);
            $this->routeStationRespository->deleteByRouteId($id);

            DB::commit();
            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            DB::rollback();
            return ResponseService::fail($e->getMessage());
        }
    }
}

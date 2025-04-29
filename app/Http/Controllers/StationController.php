<?php

namespace App\Http\Controllers;

use App\Http\Requests\StationStoreRequest;
use App\Http\Requests\StationUpdateRequest;
use App\Repositories\StationRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class StationController extends Controller
{

    protected $stationRespository;

    public function __construct(StationRepository $stationRespository)
    {
        $this->stationRespository = $stationRespository;
    }



    public function index()
    {
        return view('station.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->stationRespository->datatable($request);
        }
    }

    public function create()
    {
        return view('station.create');
    }



    public function store(StationStoreRequest $request)
    {
        try {
            $location = explode(',', $request->location);

            $this->stationRespository->create([
                'slug' => Str::slug($request->title) . '-' . Str::random(6),
                'title' => $request->title,
                'description' => $request->description,
                'latitude'=> $location[0],
                'longitude' => $location[1],
               
            ]);
            

            return Redirect::route('station.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $station = $this->stationRespository->find($id);
        return view('station.edit', compact('station'));
    }

    public function update($id, StationUpdateRequest $request)
    {
        try {
            $location = explode(',', $request->location);

            $this->stationRespository->update($id, [
                'slug' => Str::slug($request->title) . '-' . Str::random(6),
                'title' => $request->title,
                'description' => $request->description,
                'latitude'=> $location[0],
                'longitude' => $location[1],
                
            ]);

            return Redirect::route('station.index')->with('success', 'Successfully updated');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $station = $this->stationRespository->find($id);
        return view('station.show', compact('station'));
    }

    public function destroy($id)
    {
        try {
            $this->stationRespository->delete($id);


            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}


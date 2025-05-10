<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RouteDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $origin_station = $request->origin_station_slug ? $this->stations->where('slug',$request->origin_station_slug)->first() : $this->stations->first();
        $destination_station = $request->destination_station_slug ? $this->stations->where('slug',$request->destination_station_slug)->first() : $this->stations->last();
        $staions = collect($this->stations)->where('pivot.time', '>=', $origin_station->pivot->time)->where('pivot.time', '<=', $destination_station->pivot->time);
        $total_staiions = $staions->count();
        $traveling_minutes = Carbon::parse($origin_station->pivot->time)->diffInMinutes($destination_station->pivot->time);
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
            'direction' => $this->acsrDirection,
            'origin_station_title' => $origin_station->title,
            'origin_station_time' => Carbon::parse($origin_station->pivot->time)->format('h:i  A'),
            'destination_station_title' => $destination_station->title,
            'destination_station_time' => Carbon::parse($destination_station->pivot->time)->format('h:i A'),
            'total_stations' => $total_staiions,
            'traveling_minutes' => $traveling_minutes,
            'station_schedules' => StationScheduleOfRouteResource::collection($staions),

        ];
    }
}


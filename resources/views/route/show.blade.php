@extends('layouts.app')
@section('title', 'Route Detail')
@section('route-page-active', 'active')

@section('header')
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-train tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Route Detail</h5>
        </div>


    </div>
@endsection

@section('content')
    <x-card class="tw-pb-5">
        <table class="tw-w-full">
            <tbody class="tw-text-sm">
                <tr>
                    <td class="text-left" style="width:45%"> Title </td>
                    <td class="text-center" style="width:10%"> ... </td>
                    <td class="text-right" style="width:45%"> {{ $route->title }} </td>
                </tr>

                <tr>
                    <td class="text-left" style="width:45%"> Description </td>
                    <td class="text-center" style="width:10%"> ... </td>
                    <td class="text-right" style="width:45%"> {{ $route->description }} </td>

                </tr>

                <tr>
                    <td class="text-left" style="width:45%"> Direction </td>
                    <td class="text-center" style="width:10%"> ... </td>
                    <td class="text-right" style="width:45%">
                        <span style="color:#{{ $route->acsrDirection['color'] }}"> {{ $route->acsrDirection['text'] }}
                        </span>

                    </td>

                </tr>

                <tr>
                    <td class="text-left" style="width:45%"> Create at </td>
                    <td class="text-center" style="width:10%"> ... </td>
                    <td class="text-right" style="width:45%"> {{ $route->created_at }} </td>
                </tr>

                <tr>
                    <td class="text-left" style="width:45%"> Updated at </td>
                    <td class="text-center" style="width:10%"> ... </td>
                    <td class="text-right" style="width:45%"> {{ $route->updated_at }} </td>
                </tr>


            </tbody>
        </table>

        <div id="map" class="tw-h-96 tw-my-3"></div>
    </x-card>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            var stations = @json($route->stations);
            var map = L.map('map').setView([16.78106, 96.16194], 15);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // L.tileLayer('https://api.maptiler.com/maps/streets-v2/{z}/{x}/{y}.png?key=IwRNyovMKfErhzgK8z93').addTo(map);

            var myIcon = L.icon({
                iconUrl: "{{asset('image/station-marker.png')}}",
                iconSize: [32, 32],
                iconAnchor: [16, 32],
                popupAnchor: [0, -32],
            });

            stations.forEach(function(station) {
                L.marker([station['latitude'], station['longitude']],{icon:myIcon}).addTo(map)
                    .bindPopup(`${station['title']} - ${station['pivot']['time']}`)
                    .openPopup();
            });


        });
    </script>
@endpush

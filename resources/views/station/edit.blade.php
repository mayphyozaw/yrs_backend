@extends('layouts.app')
@section('title', 'Edit Station')
@section('station-page-active', 'active')

@section('header')
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-train tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Edit Station</h5>
        </div>
        <div></div>
    </div>
@endsection

@section('content')
    <x-card>
        
        <form method="post" action="{{ route('station.update', $station->id) }}" class="tw-mt-6 tw-space-y-6" id="submit-form">
            @csrf
           @method('PUT')
    

            <div class="form-group">
                <x-input-label for="" value="Title" />
                <x-text-input name="title" type="text" class="tw-mt-1 tw-block tw-w-full"
                    :value="old('title', $station->title)" />
            </div>
            
            <div class="form-group">
                <x-input-label for="" value="Description" />
                 <textarea name="description" class="form-control" >{{old('description', $station->description)}}</textarea>
                
            </div>
    

            <div class="form-group">
                <x-input-label for="" value="Location" />
                <x-text-input name="location" type="text" class="tw-mt-1 tw-block tw-w-full location"
                    :value="old('location', $station->latitude .',' .$station->longitude)" />
                <div class="map-container border tw-my-3"></div>
            </div>
    
            <div class="tw-flex tw-items-center tw-justify-center tw-items-center ">
                <x-cancel-button class="tw-mr-2" href="{{ route('station.index') }}">Cancel</x-cancel-button>
                <x-confirm-button>Confirm</x-confirm-button>
            </div>
        </form>
    </x-card>
@endsection

@push('scripts')
{!! JsValidator::formRequest('App\Http\Requests\StationUpdateRequest','#submit-form') !!}

<script>
    $(document).ready(function() {
        $('.location').leafletLocationPicker({
            mapContainer: '.map-container',
            height: 400,
            alwaysOpen: true,
            // layer: 'mapTiler',
            map: {
                center: [16.78125, 96.16191],
                zoom : 15,
            }
        });
    });
</script>
@endpush
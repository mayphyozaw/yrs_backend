@extends('layouts.app')
@section('title', 'Edit Route')
@section('route-page-active', 'active')
@section('style')
    <style>
        .calendar-table {
            display: none !important;
        }

        .daterangepicker .drp-calendar.left {
            padding: 8px !important;
        }
    </style>
@endsection
@section('header')
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-train tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Edit Route</h5>
        </div>
        <div></div>
    </div>
@endsection

@section('content')
    <x-card>

        <form method="post" action="{{ route('route.update', $route->id) }}" class="tw-mt-6 tw-space-y-6 repeater" id="submit-form">
            @csrf
            @method('PUT')


            <div class="form-group">
                <x-input-label for="" value="Title" />
                <x-text-input name="title" type="text" class="tw-mt-1 tw-block tw-w-full" :value="old('title', $route->title)" />
            </div>

            <div class="form-group">
                <x-input-label for="" value="Description" />
                <textarea name="description" class="form-control">{{ old('description', $route->description) }}</textarea>

            </div>



            <div class="form-group">
                <x-input-label for="" value="Direction" />
                <select name="direction" class="custom-select">
                    <option value="clockwise" @if (old('direction', $route->direction) == 'clockwise') selected @endif>
                        Clockwise
                    </option>
                    <option value="anticlockwise" @if (old('direction', $route->direction) == 'anticlockwise') selected @endif>Anticlockwise</option>
                </select>
            </div>

            <div class="tw-mb-3">
                <x-input-label for="" value="Schedule" />
                <div data-repeater-list="schedule">
                    @forelse ($schedule as $item)
                    <div data-repeater-item class="tw-relative tw-mb-3 tw-p-3 tw-border tw-border-gray-300 tw-rounded-lg">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <x-input-label for="" value="Station" />
                                    <select name="station_id" class="custom-select station_id">
                                        <option value="{{$item['station_id']}}" selected>{{$item['station_title']}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <x-input-label for="" value="Time" />
                                    <x-text-input name="time" type="text"
                                        class="tw-mt-1 tw-block tw-w-full timepicker"  value="{{$item['time']}}" />

                                </div>
                            </div>
                        </div>

                        <button data-repeater-delete type="button"
                            class="tw-absolute tw-top-0 tw-right-0 tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-bg-red-800 tw-border tw-border-transparent tw-rounded-md tw-font-semibold tw-text-xs tw-text-white tw-uppercase tw-tracking-widest hover:tw-bg-red-700 focus:tw-bg-red-700 active:tw-bg-red-900 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150">
                            <i class="fas fa-times-circle tw-mr-1"></i>
                        </button>
                    </div>
                    @empty
                        <div data-repeater-item class="tw-relative tw-mb-3 tw-p-3 tw-border tw-border-gray-300 tw-rounded-lg">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <x-input-label for="" value="Station" />
                                        <select name="station_id" class="custom-select station_id">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <x-input-label for="" value="Time" />
                                        <x-text-input name="time" type="text"
                                            class="tw-mt-1 tw-block tw-w-full timepicker" />

                                    </div>
                                </div>
                            </div>

                            <button data-repeater-delete type="button"
                                class="tw-absolute tw-top-0 tw-right-0 tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-bg-red-800 tw-border tw-border-transparent tw-rounded-md tw-font-semibold tw-text-xs tw-text-white tw-uppercase tw-tracking-widest hover:tw-bg-red-700 focus:tw-bg-red-700 active:tw-bg-red-900 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150">
                                <i class="fas fa-times-circle tw-mr-1"></i>
                            </button>
                        </div>
                    @endforelse
                </div>

                <button data-repeater-create type="button"
                    class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-bg-gray-800 tw-border tw-border-transparent tw-rounded-md tw-font-semibold tw-text-xs tw-text-white tw-uppercase tw-tracking-widest hover:tw-bg-gray-700 focus:tw-bg-gray-700 active:tw-bg-gray-900 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150">
                    <i class="fas fa-plus-circle tw-mr-1"></i> Add Schedule
                </button>

            </div>

            <div class="tw-flex tw-items-center tw-justify-center tw-items-center ">
                <x-cancel-button class="tw-mr-2" href="{{ route('route.index') }}">Cancel</x-cancel-button>
                <x-confirm-button>Confirm</x-confirm-button>
            </div>
        </form>
    </x-card>
@endsection

@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\RouteUpdateRequest', '#submit-form') !!}

    <script>
        $(document).ready(function() {
            $('.repeater').repeater({
                show: function() {
                    $(this).slideDown();
                    initStationSelect2();
                    initTimePicker();
                },
                hide: function(deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },

                ready: function(setIndexes) {
                    initStationSelect2();
                    initTimePicker();

                },
                isFirstItemUndeletable: false
            });

            function initStationSelect2() {
                $(document).ready(function() {
                    $('.station_id').select2({
                        placeholder: '--- Please Choose ---',
                        ajax: {
                            url: "{{ route('select2-ajax.station') }}",
                            data: function(params) {
                                var query = {
                                    search: params.term,
                                    page: params.page || 1
                                }

                                // Query parameters will be ?search=[term]&page=[page]
                                return query;
                            },
                            processResults: function(response) {
                                console.log(response);
                                return {
                                    results: $.map(response.data, function(
                                        item) { // using javascript map function
                                        return {
                                            id: item.id,
                                            text: item.title
                                        }
                                    }),
                                    pagination: {
                                        more: response.next_page_url != null ? true : false,
                                    }
                                };
                            },
                            cache: true
                        }
                    });
                });
            }

            function initTimePicker() {
                $('.timepicker').daterangepicker({
                    "singleDatePicker": true,
                    "timePicker": true,
                    "timePicker24Hour": true,
                    "timePickerSeconds": true,
                    "autoApply": true,
                    "locale": {
                        "format": "HH:mm:ss",

                    },
                });

            }
        });
    </script>
@endpush

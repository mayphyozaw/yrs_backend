@extends('layouts.app')
@section('title', 'Create Ticket Pricing')
@section('ticket-pricing-page-active', 'active')

@section('header')
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-tag tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Create Ticket Pricing</h5>
        </div>
        <div></div>
    </div>
@endsection

@section('content')
    <x-card>
        
        <form method="post" action="{{ route('ticket-pricing.store') }}" class="tw-mt-6 tw-space-y-6 tw-text-sm" id="submit-form">
            @csrf
           
    
            <div class="form-group">
                <x-input-label for="" value="Type" />
                <select name="type" class="custom-select type">
                    <option value="one_time_ticket" @if (old('type') == 'one_time_ticket')selected  @endif>One Time Ticket</option>
                    <option value="one_month_ticket" @if (old('type') == 'one_month_ticket')selected  @endif>One Month Ticket</option>

                </select>
            </div>

            <div class="form-group direction-component">
                <x-input-label for="" value="Direction" />
                <select name="direction" class="custom-select">
                    <option value="clockwise" @if (old('direction') == 'clockwise')selected  @endif>Clockwise</option>
                    <option value="anticlockwise" @if (old('direction') == 'anticlockwise')selected  @endif>Anticlockwise</option>
                    <option value="both" @if (old('direction') == 'both')selected  @endif>Both </option>

                </select>
            </div>
            
            <div class="form-group">
                <x-input-label for="" value="Price" />
                <x-text-input name="price" type="number" class="tw-mt-1 tw-block tw-w-full"
                    :value="old('price')" />
            </div>
    
            <div class="form-group">
                <x-input-label for="" value="Offer Quantity" />
                <x-text-input name="offer_quantity" type="number" class="tw-mt-1 tw-block tw-w-full"
                    :value="old('offer_quantity')" />
            </div>
            
            <div class="form-group">
                <x-input-label for="" value="Period" />
                <x-text-input name="period" type="text"
                    class="tw-mt-1 tw-block tw-w-full datetimepicker"  :value="old('period')" />

            </div>
    
            <div class="tw-flex tw-items-center tw-justify-center tw-items-center ">
                <x-cancel-button class="tw-mr-2" href="{{ route('ticket-pricing.index') }}">Cancel</x-cancel-button>
                <x-confirm-button>Confirm</x-confirm-button>
            </div>

        </form>
    </x-card>
@endsection

@push('scripts')
{!! JsValidator::formRequest('App\Http\Requests\TicketPricingStoreRequest','#submit-form') !!}

    <script>
        $(document).ready(function() {
            $(document).on('change','.type', function(){
                changeType();
            });

            $('.datetimepicker').daterangepicker({
                    "drops" : "up",
                    "timePicker": true,
                    "timePicker24Hour": true,
                    "timePickerSeconds": true,
                    "autoApply": true,
                    "locale": {
                        "format": "YYYY-MM-DD HH:mm:ss",

                    },
            });

            changeType();
            function changeType(){
                let type = $('.type').val();
                if(type == 'one_time_ticket')
                {
                    $('.direction-component').show();
                }else if(type == 'one_month_ticket')
                {
                    $('.direction-component').hide();

                }
            }
        });
    </script>
@endpush
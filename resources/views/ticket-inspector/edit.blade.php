@extends('layouts.app')
@section('title', 'Edit Ticket Inspector')
@section('ticket-inspector-page-active', 'active')

@section('header')
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-user tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Edit Ticket Inspector</h5>
        </div>
        <div></div>
    </div>
@endsection

@section('content')
    <x-card>
        
        <form method="post" action="{{ route('ticket-inspector.update', $ticket_inspector->id) }}" class="tw-mt-6 tw-space-y-6" id="submit-form">
            @csrf
           @method('PUT')
    
            <div class="form-group">
                <x-input-label for="name" value="Name" />
                <x-text-input id="name" name="name" type="text" class="tw-mt-1 tw-block tw-w-full"
                    :value="old('name',$ticket_inspector->name)" />
            </div>
            
            <div class="form-group">
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" name="email" type="email" class="tw-mt-1 tw-block tw-w-full"
                    :value="old('email',$ticket_inspector->email)"   />
            </div>
    

            <div class="form-group">
                <x-input-label for="password" value="Password" />
                <x-text-input id="password" name="password" type="password" class="tw-mt-1 tw-block tw-w-full" />
            </div>
    
            <div class="tw-flex tw-items-center tw-justify-center tw-items-center ">
                <x-cancel-button class="tw-mr-2" href="{{ route('ticket-inspector.index') }}">Cancel</x-cancel-button>
                <x-confirm-button>Confirm</x-confirm-button>
            </div>
        </form>
    </x-card>
@endsection

@push('scripts')
{!! JsValidator::formRequest('App\Http\Requests\TicketInspectorUpdateRequest','#submit-form') !!}
@endpush
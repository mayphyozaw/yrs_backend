@extends('layouts.app')
@section('title', 'Edit Admin User')
@section('admin-user-page-active', 'active')

@section('header')
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-user tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Edit Admin User</h5>
        </div>
        <div></div>
    </div>
@endsection

@section('content')
    <x-card>
        
        <form method="post" action="{{ route('admin-user.update', $admin_user->id) }}" class="tw-mt-6 tw-space-y-6" id="submit-form">
            @csrf
           @method('PUT')
    
            <div class="form-group">
                <x-input-label for="name" value="Name" />
                <x-text-input id="name" name="name" type="text" class="tw-mt-1 tw-block tw-w-full"
                    :value="old('name',$admin_user->name)" />
                {{-- <x-input-error class="tw-mt-2" :messages="$errors->get('name')" /> --}}
            </div>
            
            <div class="form-group">
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" name="email" type="email" class="tw-mt-1 tw-block tw-w-full"
                    :value="old('email',$admin_user->email)"   />
                {{-- <x-input-error class="tw-mt-2" :messages="$errors->get('email')" /> --}}
    
                
            </div>
    

            <div class="form-group">
                <x-input-label for="password" value="Password" />
                <x-text-input id="password" name="password" type="password" class="tw-mt-1 tw-block tw-w-full" />
                {{-- <x-input-error class="tw-mt-2" :messages="$errors->get('name')" /> --}}
            </div>
    
            <div class="tw-flex tw-items-center tw-justify-center tw-items-center ">
                <x-cancel-button class="tw-mr-2" href="{{ route('admin-user.index') }}">Cancel</x-cancel-button>
                <x-confirm-button>Confirm</x-confirm-button>
            </div>
        </form>
    </x-card>
@endsection

@push('scripts')
{!! JsValidator::formRequest('App\Http\Requests\AdminUserUpdateRequest','#submit-form') !!}
@endpush
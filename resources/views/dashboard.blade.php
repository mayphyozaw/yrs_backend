@extends('layouts.app')
@section('title', 'Dashboard')
@section('dashboard-page-active', 'active')

@section('header')
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-th tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Dashboard</h5>
        </div>
        <div></div>
    </div>
@endsection

@section('content')
    <x-card>
        <div class="tw-flex tw-justify-center tw-items-center tw-bg-theme">
            {{-- from storyset website --}}
            <img src="{{ asset('image/dashboard.png') }}" alt="" class="tw-w-4/12">
        </div>
        <p class="text-center tw-text-gray-600">Welcome to Yangon Railway Service</p>
    </x-card>
@endsection

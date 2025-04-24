@extends('layouts.app')
@section('title', 'Wallet Transaction')
@section('wallet-transaction-page-active', 'active')

@section('header')
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-wallet tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Wallet Transaction</h5>
        </div>
        
        
    </div>
@endsection

@section('content')
    <x-card class="tw-pb-5">
        <table class="table table-bordered Datatable-tb">
            <thead>
                <th class="text-center"></th>
                <th class="text-center">Trx ID</th>
                <th class="text-center">User</th>
                <th class="text-center">Type</th>
                <th class="text-center">Method</th>
                <th class="text-center">Amount</th>
                <th class="text-center">Created at</th>
                <th class="text-center">Updated at </th>
                <th class="text-center no-sort no-search">Action </th>
            </thead>
        </table>
    </x-card>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            var table = new DataTable('.Datatable-tb', {
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('wallet-transaction-datable') }}",
                    data: function(d) {

                    }
                },

                columns: [{
                        data: 'responsive-icon',
                        class: 'text-center'
                    },
                    {
                        data: 'trx_id',
                        class: 'text-center'
                    },
                    
                    {
                        data: 'user_name',
                        class: 'text-center'
                    },
                    {
                        data: 'type',
                        class: 'text-center'
                    },
                    {
                        data: 'method',
                        class: 'text-center'
                    },
                    {
                        data: 'amount',
                        class: 'text-center'
                    },
                    
                    {
                        data: 'created_at',
                        class: 'text-center '
                    },
                    {
                        data: 'updated_at',
                        class: 'text-center'
                    },
                    {
                        data: 'action',
                        class: 'text-center'
                    },


                ],
                order: [
                    [7, 'desc'],
                ],
                responsive: {
                    details: {
                        type: 'column',
                        target: 0
                    }
                },

                columnDefs: [{
                        targets: 'no-sort',
                        orderable: false
                    },
                    {
                        targets: 'no-search',
                        searchable: false
                    },
                    {
                        targets: 0,
                        orderable: false,
                        searchable: false,
                        className: 'control'
                    },
                ],

            });

        });
    </script>
@endpush

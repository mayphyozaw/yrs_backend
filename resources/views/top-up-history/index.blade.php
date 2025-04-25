@extends('layouts.app')
@section('title', 'TopUp History')
@section('top-up-history-page-active', 'active')

@section('header')
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-image tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Top Up History</h5>
        </div>
        
        
    </div>
@endsection

@section('content')
    <x-card class="tw-pb-5">
        <table class="table table-bordered Datatable-tb" id="images">
            <thead>
                <th class="text-center"></th>
                <th class="text-center">Trx ID</th>
                <th class="text-center">User</th>
                <th class="text-center">Amount</th>
                <th class="text-center">Image</th>
                <th class="text-center">Status</th>
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
            var images = new Viewer(document.getElementById('images'));

            var table = new DataTable('.Datatable-tb', {
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('top-up-history-datable') }}",
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
                        data: 'amount',
                        class: 'text-center'
                    },
                    {
                        data: 'image',
                        class: 'text-center'
                    },
                    {
                        data: 'status',
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
                drawCallback: function(){
                    images.destroy();
                    images = new Viewer(document.getElementById('images'));
                }
            });

            $(document).on('click', '.approve-button', function(event) {
                event.preventDefault();

                var url = $(this).data('url');
                confirmDialog.fire({
                    title: "Are you sure you want to approve?",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: 'POST',
                            success: function(response){
                                table.ajax.reload();
                                toastr.success(response.message);
                            }
                        });
                    } 
                    
                });;

            });

            $(document).on('click', '.reject-button', function(event) {
                event.preventDefault();

                var url = $(this).data('url');
                confirmDialog.fire({
                    title: "Are you sure you want to confirm?",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: 'POST',
                            success: function(response){
                                table.ajax.reload();
                                toastr.success(response.message);
                            }
                        });
                    } 
                    
                });;

            });

        });
    </script>
@endpush

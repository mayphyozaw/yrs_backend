@extends('layouts.app')
@section('title', 'Route')
@section('route-page-active', 'active')

@section('header')
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-route tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Route</h5>
        </div>
        <div>
            <x-create-button href="{{ route('route.create') }}">
                <i class="fas fa-plus-circle tw-mr-1"></i>
                Create
            </x-create-button>
        </div>
    </div>
@endsection

@section('content')
    <x-card class="tw-pb-5">
        <table class="table table-bordered Datatable-tb">
            <thead>
                <th class="text-center"></th>
                <th class="text-center">Title</th>
                <th class="text-center">Description</th>
                <th class="text-center">Direction</th>
                <th class="text-center">Created at</th>
                <th class="text-center">Updated at </th>
                <th class="text-center no-sort no-search">Action</th>
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
                    url: "{{ route('route-datable') }}",
                    data: function(d) {

                    }
                },

                columns: [{
                        data: 'responsive-icon',
                        class: 'text-center'
                    },
                    {
                        data: 'title',
                        class: 'text-center'
                    },
                    {
                        data: 'description',
                        class: 'text-center'
                    },
                    {
                        data: 'direction',
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
                        class: 'text-center '
                    },

                ],
                order: [
                    [5, 'desc'],
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

            $(document).on('click', '.delete-button', function(event) {
                event.preventDefault();

                var url = $(this).data('url');
                confirmDialog.fire({
                    title:"Are you sure you want to delete?",
                }).then((result) => {
                    
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: 'DELETE',
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

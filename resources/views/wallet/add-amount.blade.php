@extends('layouts.app')
@section('title', 'Add Amount Wallet')
@section('wallet-page-active', 'active')

@section('header')
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-wallet tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Add Amount Wallet</h5>
        </div>

    </div>
@endsection

@section('content')
    <x-card>

        <form method="post" action="{{ route('wallet-add-amount.store') }}" class="tw-mt-6 tw-space-y-6 tw-text-sm" id="submit-form">
            @csrf


            <div class="form-group">
                <x-input-label for="wallet_id" value="Wallet" />
                <select name="wallet_id" id="wallet_id" class="custome-select tw-w-full tw-text-sm">
                    @if($selected_wallet)
                    <option value="{{$selected_wallet->id}}">{{$selected_wallet->user->name ?? '-'}}</option>
                    @endif
                </select>
            </div>

            <div class="form-group">
                <x-input-label for="amount" value="Amount" />
                <x-text-input id="amount" name="amount" type="number" class="tw-mt-1 tw-block tw-w-full"
                    :value="old('amount')" />

            </div>


            <div class="form-group">
                <x-input-label for="description" value="Description" />
                <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="tw-flex tw-items-center tw-justify-center tw-items-center ">
                <x-cancel-button class="tw-mr-2" href="{{ route('wallet.index') }}">Cancel</x-cancel-button>
                <x-confirm-button>Confirm</x-confirm-button>
            </div>
        </form>
    </x-card>
@endsection

@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\WalletAddAmountStoreRequest', '#submit-form') !!}


    <script>
        $(document).ready(function() {
            $('#wallet_id').select2({
                placeholder: '--- Please Choose ---',
                ajax: {
                    url: "{{route('select2-ajax.wallet')}}",
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
                            results: $.map(response.data, function(item){
                                return {
                                    id: item.id,
                                    text: item.user.name
                                }
                            }),
                            pagination: {
                                more: response.next_page_url != null ? true : false,
                            }
                        };
                    },
                    cache : true
                }
            });
        });
    </script>
@endpush

@extends('layouts.admin.master')
@section('title')
Sliders
@endsection
@section('admin-additional-css')
@endsection
@section('content')
<style>
    .wallet-cell {
        position: relative;
    }

    .wallet-button {
        position: absolute;
        bottom: 0;
        left: 67%;
        transform: translateX(-50%);
        margin-top: 5px;
    }
    svg{
        display: none
    }
</style>
<div class="content">
    @include('layouts.admin.include.alert')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary d-flex justify-content-between align-items-center">
                        <h4 class="card-title ">{{ __('wallet-ts.wallet_manage') }}</h4>
                        <a href="{{url('/export-excel/wallets-manage')}}"><button class="btn btn-success btn-sm"
                                data-target="trip">Export<div class="ripple-container"></div></button></a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin-sliders.trip-no') }}</th>
                                        <th>{{ __('wallet-ts.title') }}</th>
                                        {{-- <th>Title Urdu</th> --}}
                                        <th>{{ __('Partner Price') }}</th>
                                        <th style="max-width: 100px;">{{ __('User Name') }}</th>
                                        <th>{{ __('Partner Name') }}</th>
                                        <th>{{ __('admin-sliders.b-name') }}</th>
                                        <th>{{ __('User Wallet') }}</th>
                                        <th>{{ __('Partner Wallet') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($trip_details as $key => $value)
                                    <tr>
                    
                                        <td>{{$value->id}}</td>
                                        <td>{{$value->price}}</td>
                                        {{-- <td>{{ $item->title_urdu }}</td> --}}
                                        <td>{{ $value->partner_price }}</td>
                                        <td>{{ $value->username }}</td>
                                        <td>{{ $value->partnername }}</td>
                                        <td>{{ $value->brand_name }}</td>
                                        <td class="wallet-cell" style="height: 65px">
                                            <span>{{ $value->wallet_balance }}</span>
                                            <button style="margin-bottom: 12px" href="#" class="btn btn-success btn-sm wallet-button" data-toggle="modal" data-userwallet="{{ $value->wallet_balance }}" data-userid="{{ $value->user_id }}" data-tripid="{{ $value->id }}" data-target="#userWalletModal">User Wallet</button>
                                        </td>
                                        <td class="wallet-cell" style="height: 65px">
                                            <span>{{ $value->partner_wallet_balance }}</span>
                                            <button style="margin-bottom: 12px" href="#" class="btn btn-success btn-sm wallet-button" data-toggle="modal" data-partnerwallet="{{ $value->partner_wallet_balance }}" data-partnerid="{{ $value->partner_id }}" data-tripid="{{ $value->id }}" data-target="#partnerWalletModal">Partner Wallet</button>
                                        </td>
                                        <!-- <td>
                                            <a href="{{ url('revert/'.$value->id) }}" title="{{ __('admin-sliders.edit_slider') }}" class="btn btn-info btn-sm">Revert</a>
                                        </td> -->
                                        <td>
                                            @if($value->revert == 1)
                                            <a title="Revert">
                                                completed
                                            </a>
                                            @else
                                                <a href="{{ url('revert/'.$value->id) }}" title="{{ __('admin-sliders.edit_slider') }}" class="btn btn-info btn-sm">Revert</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $trip_details->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="userWalletModal" tabindex="-1" role="dialog" aria-labelledby="userWalletModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userWalletModalLabel">User Wallet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="userWalletForm" action="{{ route('wallets_update') }}" method="post">
                @csrf
                    <div class="form-group">
                        <label for="userWalletInput">User Wallet Amount</label>
                        <input type="text" class="form-control" id="userWalletInput" name="userWalletInput">
                        <input type="hidden" id="userid" name="userid" value="">
                        <input type="hidden" id="tripid" name="tripid" value="">
                        <input type="hidden" name="type" value="user">
                    </div>
                    <button type="submit" class="btn btn-primary" id="submitUserWallet">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="partnerWalletModal" tabindex="-1" role="dialog" aria-labelledby="partnerWalletModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="partnerWalletModalLabel">Partner Wallet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="userWalletForm" action="{{ route('wallets_update') }}" method="post">
                @csrf
                    <div class="form-group">
                        <label for="partnerWalletInput">partner Wallet Amount</label>
                        <input type="text" class="form-control" id="partnerWalletInput" name="userWalletInput">
                        <input type="hidden" id="partnerid" name="userid" value="">
                        <input type="hidden" id="partnertripid" name="tripid" value="">
                        <input type="hidden" name="type" value="partner">
                    </div>
                    <button type="submit" class="btn btn-primary" id="submitPartnerWallet">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('admin-additional-js')
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#userWalletModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var userWallet = button.data('userwallet');
            var userid = button.data('userid');
            var tripid = button.data('tripid');
            
            $('#userWalletInput').val(userWallet);
            $('#userid').val(userid);
            $('#tripid').val(tripid);
        });

        $('#partnerWalletModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var partnerWallet = button.data('partnerwallet');
            var partnerid = button.data('partnerid');
            var tripid = button.data('tripid');

            $('#partnerWalletInput').val(partnerWallet);
            $('#partnerid').val(partnerid);
            $('#partnertripid').val(tripid);
        });
    });
</script>

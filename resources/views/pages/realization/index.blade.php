@extends('layouts.app')
@section('title')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-2">
            @if( auth()->user()->getUserGroup->GroupCode == config('GroupCodeApplication.USER_RMFEE') )
                <a href="{{ route('realization.create') }}" class="btn btn-primary pull-right"
                    style="border-radius: 100px; font-size: 18px;">
                    <i class="feather icon-file-plus text-white"></i>
                    <span class="text-white">Add Realization</span>
                </a>
            @endif
        </div>
    </div>

    @foreach ($errors->all() as $error)
        <div class="alert alert-danger text-center">
            *{!! $error !!}
        </div>
    @endforeach

    @if( session()->has('noticication') )
    <div class="alert alert-success text-center">
        {!! session()->get('noticication') !!}
    </div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <table class="table table-responsive table-realization dataTable" style="overflow-x: auto; overflow-y: none; height: 650px;">
                <thead>
                    <tr class="default">
                        <th>Key</th>
                        <th>Action</th>
                        <th>Last Update</th>
                        <th>Type of Payment</th>
                        <th>Invoice No</th>
                        <th>Type</th>
                        <th>Invoice Date</th>
                        <th>Payment To</th>
                        <th>Broker</th>
                        <th>Currency</th>
                        <th>Status Realization</th>
                        <th id="approval_bu" style="display: none;">Approval BU</th>
                        <th id="approval_finance" style="display: none;">Approval Finance</th>
                    </tr>
                </thead>
                <tbody>
                    @if( $RealizationData != null )
                        @foreach ($RealizationData as $key => $val)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                        <div class="btn-group" role="group">
                                            <a href="#" id="BtnActionGroup" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="">
                                                <i class="feather icon-plus-circle" style="font-size: 32px;"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="BtnActionGroup">
                                                {!! $Action[$key] !!}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $val->Date }}</td>
                                <td>{{ $val->type_Of_Payment }}</td>
                                <td>{{ $val->Invoice_No }}</td>
                                <td>{{ $val->Type_Of_Invoice }}</td>
                                <td>{{ date('d M Y', strtotime($val->Invoice_Date)) }}</td>
                                <td>{{ $val->Payment_To_Name }}</td>
                                <td>{{ $val->Broker_Name }}</td>
                                <td>{{ $val->Currency }}</td>
                                <td>{{ $val->Status_Realization }}</td>
                                <td style="display: none;">{{ $val->Approval_BU }}</td>
                                <td style="display: none;">{{ $val->approval_Finance }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="10">
                                <b>
                                    <i>Empty Data</i>
                                </b>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
@endsection

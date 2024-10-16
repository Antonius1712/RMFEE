@extends('layouts.app')
@section('title')
    
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-2">
            @if( $RealizationData->Status_Realization == config('RealizationStatus.DRAFT') )
            
            {{-- TODO Add Propose button --}}
            {{-- <a href="{{ route('realization.edit', $invoice_no) }}" class="btn btn-primary pull-right" style="border-radius: 100px; font-size: 18px;">
                <i class="feather icon-file-plus text-white"></i>
                <span class="text-white">propose</span>
            </a> --}}
            
            <a href="{{ route('realization.detail-realization.create', $invoice_no) }}" class="btn btn-primary pull-right" style="border-radius: 100px; font-size: 18px;">
                <i class="feather icon-file-plus text-white"></i>
                <span class="text-white">Add Detail Realization</span>
            </a>
            <a href="{{ route('realization.propose', $invoice_no) }}" class="btn btn-primary pull-right radius-100 mr-2" style="font-size: 18px;">
                <i class="feather icon-check text-white"></i>
                <span class="text-white">Propose</span>
            </a>
            @endif

            @php
            $AuthUserGroup = Auth()->user()->getUserGroup->GroupCode;
            @endphp
            @if( $AuthUserGroup == config('GroupCodeApplication.HEAD_FINANCE_RMFEE') )
            <a href="{{ route('realization.approve', $invoice_no) }}" class="btn btn-primary pull-right radius-100 mr-2" style="font-size: 18px;">
                <span class="text-white">Approve</span>
            </a>

            <a href="{{ route('realization.reject', $invoice_no) }}" class="btn btn-primary pull-right radius-100 mr-2" style="font-size: 18px;">
                <span class="text-white">Reject</span>
            </a>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-compact table-bordered table-striped" style="border-radius: 100px; position: relative;">
                <thead>
                    <tr class="bg-primary text-white w-auto">
                        <th class="pl-4 pr-4 text-center" style="vertical-align: middle">Action</th>
                        <th class="pl-4 pr-4 text-center" style="vertical-align: middle">Class</th>
                        <th class="pl-4 pr-4 text-center" style="vertical-align: middle">SOB</th>
                        <th class="pl-4 pr-4 text-center" style="vertical-align: middle">Broker Name</th>
                        <th class="pl-4 pr-4 text-center" style="vertical-align: middle">Type</th>
                        <th class="pl-4 pr-4 text-center" style="vertical-align: middle">Branch</th>
                        <th class="pl-4 pr-4 text-center" style="vertical-align: middle">Policy No</th>
                        <th class="pl-4 pr-4 text-center" style="vertical-align: middle">Policy Period</th>
                        <th class="pl-4 pr-4 text-center" style="vertical-align: middle">Status Budget</th>
                        <th class="pl-4 pr-4 text-center" style="vertical-align: middle">Status Realization</th>
                        <th class="pl-4 pr-4 text-center" style="vertical-align: middle">Gross Premi</th>
                        <th class="pl-4 pr-4 text-center" style="vertical-align: middle">Percentage</th>
                        <th class="pl-4 pr-4 text-center" style="vertical-align: middle">Budget in Amount</th>
                        <th class="pl-4 pr-4 text-center" style="vertical-align: middle">Amount Realization</th>
                        <th class="pl-4 pr-4 text-center" style="vertical-align: middle">Currency Realization</th>
                        <th class="pl-4 pr-4 text-center" style="vertical-align: middle">Exchange Rate Realization</th>
                        <th class="pl-4 pr-4 text-center" style="vertical-align: middle">Total Amount Realization</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($DetailRealization as $val)
                        <tr>
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <div class="btn-group" role="group">
                                        <a href="#" id="BtnActionGroup" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="">
                                            <i class="feather icon-plus-circle" style="font-size: 32px;"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="BtnActionGroup">
                                            @if( $RealizationData->Status_Realization == config('RealizationStatus.DRAFT') 
                                                    || $RealizationData->Status_Realization == config('RealizationStatus.REJECTED') )
                                                <a class="dropdown-item success" href="{{ route('realization.detail-realization.edit', [$invoice_no, $val->id]) }}">
                                                    <i class="feather icon-edit-2"></i>
                                                    Edit
                                                </a>
                                                <div class='dropdown-divider'></div>
                                                <a class="dropdown-item danger" href="{{ route('realization.detail-realization.destroy', $val->id) }}">
                                                    <i class="feather icon-trash-2"></i>
                                                    Delete
                                                </a>
                                            @else
                                            <a class="dropdown-item success" href="{{ route('realization.detail-realization.show', [$invoice_no, $val->id]) }}">
                                                <i class="feather icon-eye"></i>
                                                View 
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $val->CLASS }}</td>
                            <td>{{ $val->BROKERNAME != null ? explode('-', $val->BROKERNAME, 2)[0] : '' }}</td>
                            <td>{{ $val->BROKERNAME != null ? explode('-', $val->BROKERNAME, 2)[1] : '' }}</td>
                            <td>{{ $val->TYPE }}</td>
                            <td>{{ $val->BRANCH }}</td>
                            <td>{{ $val->POLICYNO }}</td>
                            <td>{{ date('d M Y', strtotime($val->Start_Date)) }} - {{ date('d M Y', strtotime($val->End_Date)) }}</td>
                            <td>{{ $val->STATUS_BUDGET }}</td>
                            <td>{{ $val->STATUS_REALIZATION }}</td>
                            <td class="text-right">{{ number_format($val->PREMIUM) }}</td>
                            <td class="text-right">{{ number_format($val->Persentage, 2) }}</td>
                            <td class="text-right">{{ number_format($val->Budget) }}</td>
                            <td class="text-right">{{ number_format($val->amount_realization) }}</td>
                            <td>{{ $val->currency_realization }}</td>
                            <td class="text-right">{{ number_format($val->exchange_rate_realization) }}</td>
                            <td class="text-right">{{ number_format($val->total_amount_realization) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-primary text-white w-full" style="position: fixed; bottom: 0; right: 0;">
                    <tr>
                        <td colspan="15" class="text-right">
                            Total Amount Realization :
                        </td>
                        <td class="text-right border-bottom-black border-top-black">
                            <b class="font-medium-1">
                                {{ number_format($SumTotalAmountRealizaton, 2) }}
                            </b>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@section('script')
    
@endsection
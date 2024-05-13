@extends('layouts.app')
@section('title')
    
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-2">
            @if( $RealizationData->Status_Realization == config('RealizationStatus.DRAFT') )
            <a href="{{ route('realization.detail-realization.create', $invoice_no) }}" class="btn btn-primary pull-right" style="border-radius: 100px; font-size: 18px;">
                <i class="feather icon-file-plus text-white"></i>
                <span class="text-white">Add Detail Realization</span>
            </a>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-compact" style="border-radius: 100px;">
                <thead>
                    <tr class="default">
                        <th>Action</th>
                        <th>Class</th>
                        <th>SOB</th>
                        <th>Broker Name</th>
                        <th>Type</th>
                        <th>Branch</th>
                        <th>Policy No</th>
                        <th>Status Budget</th>
                        <th>Status Realization</th>
                        <th>Gross Premi</th>
                        <th>Percentage</th>
                        <th>Budget in Amount</th>
                        <th>Amount Realization</th>
                        <th>Currency Realization</th>
                        <th>Exchange Rate Realization</th>
                        <th>Total Amount Realization</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($DetailRealization as $val)
                    {{-- {{ dd($val) }} --}}
                        <tr>
                            <td>
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
                            <td>{{ $val->STATUS_BUDGET }}</td>
                            <td>{{ $val->STATUS_REALIZATION }}</td>
                            <td>{{ number_format($val->PREMIUM) }}</td>
                            <td>{{ $val->Persentage }}</td>
                            <td>{{ number_format($val->Budget) }}</td>
                            <td>{{ number_format($val->amount_realization) }}</td>
                            <td>{{ $val->currency_realization }}</td>
                            <td>{{ number_format($val->exchange_rate_realization) }}</td>
                            <td>{{ number_format($val->total_amount_realization) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    
@endsection
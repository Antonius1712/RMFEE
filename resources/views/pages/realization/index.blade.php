@extends('layouts.app')
@section('title')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-2 pull-right">
            <a class="btn btn-primary pull-right" style="border-radius: 100px; font-size: 18px;" aria-expanded="false"
                data-toggle="collapse" data-target="#FilterCollapse">
                <i class="feather icon-filter text-white"></i>
                <span class="text-white">Filter</span>
            </a>
        </div>
    </div>

    <div class="card collapse" id="FilterCollapse">
        <form action="{{ route('realization.index') }}" method="get">
            <div class="card-body row" id="card-filter">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="status_realization">Status Realization</label>
                        <select name="status_realization" id="status_realization" class="form-control radius">
                            <option value="">All</option>
                            @foreach ($RealizationStatus as $key => $val)
                                <option {{ $FilterStatusRealization == $key ? 'selected' : '' }} value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="broker_name">Broker Name</label>
                        <input type="text" name="broker_name" id="broker_name" class="form-control radius"
                            value="{{ $FilterBrokerName }}" placeholder="Type Here..">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="last_update">Last Update</label>
                        <input type="text" name="last_update" id="last_update" class="form-control radius"
                            value="{{ $FilterLastUpdate }}" placeholder="Type Here..">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="invoice_no">Invoice No</label>
                        <input type="text" name="invoice_no" id="invoice_no" class="form-control radius"
                            value="{{ $FilterInvoiceNo }}" placeholder="Type Here..">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="cob">COB</label>
                        <select name="cob" id="cob" class="form-control radius">
                            <option value="">All</option>
                            @foreach ($COB as $key => $val)
                                <option {{ $FilterCOB == $key ? 'selected' : '' }} value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="type_of_payment">Type of Payment</label>
                        <select name="type_of_payment" id="type_of_payment" class="form-control radius">
                            <option value="">All</option>
                            @foreach ($TypeOfPayment as $key => $val)
                                <option {{ $FilterTypeOfPayment == $val ? 'selected' : '' }} value="{{ $val }}">{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-6">
                    <button id="btn_reset_filter" class="btn btn-outline-primary waves-effect waves-light radius-100"
                        style="width: 100%;">
                        Reset Filter
                    </button>
                </div>
                <div class="col-lg-6">
                    <button id="btn_apply_filter" class="btn btn-primary waves-effect waves-light radius-100"
                        style="width: 100%;">
                        Apply Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-2">
            @if (auth()->user()->getUserGroup->GroupCode == config('GroupCodeApplication.USER_RMFEE'))
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

    @if (session()->has('noticication'))
        <div class="alert alert-success text-center">
            {!! session()->get('noticication') !!}
        </div>
    @endif

    @if( auth()->user()->getUserGroup->GroupCode != 'USER_RMFEE' )
    <div class="row">
        <div class="col-lg-12 mb-2">
            <form id="multiple_approve_realization_form" action="{{ route('realization.multiple_approve') }}" method="GET"
                style="display:none;">
                {{ csrf_field() }}
                <div id="appendFormForMultipleApprove">

                </div>
                <input type="hidden" name="invoiceNo" id="invoiceNoInput">
            </form>

            <button id="btn_approve_selected_invoice_no" class="btn btn-success pull-right"
                style="border-radius: 100px; font-size: 18px;">
                Approve
            </button>
        </div>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-responsive table-realization dataTable"
                style="overflow-x: auto; overflow-y: none; height: 650px;">
                <thead>
                    <tr class="default">
                        @if( auth()->user()->getUserGroup->GroupCode != 'USER_RMFEE' )
                        <th id="th_check">
                            <input type="checkbox" id="select_all" /> All
                        </th>
                        @endif
                        <th>Action</th>
                        <th>Last Update</th>
                        <th>Class</th>
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
                    @if ($RealizationData != null)
                        @foreach ($RealizationData as $key => $val) 
                            <tr>
                                @if( auth()->user()->getUserGroup->GroupCode != 'USER_RMFEE' )
                                <td class="clickable-td">
                                    @if(
                                        $val->Status_Realization == \App\Enums\RealizationStatus::WAITING_APPROVAL_BU
                                            || $val->Status_Realization == \App\Enums\RealizationStatus::WAITING_APPROVAL_FINANCE
                                    )
                                        <input type="checkbox" name="check_realization[]" id="" class="check_realization"
                                        value="" data-invoice_no="{{ $val->Invoice_No }}">
                                    @endif
                                </td>
                                @endif
                                <td>
                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                        <div class="btn-group" role="group">
                                            <a href="#" id="BtnActionGroup" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false" style="">
                                                <i class="feather icon-plus-circle" style="font-size: 32px;"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="BtnActionGroup">
                                                {{-- {!! $Action[$key] !!} --}}
                                                {!! $val->Action !!}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $val->Date }}</td>
                                <td>{{ $val->Class }}</td>
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
            <div class="mt-4 pull-right">
                {{ $RealizationData->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <style>
        .td_comment,
        .td_occupation,
        .clickable-td,
        #th_check 
        {
            cursor: pointer;
        }
    </style>
@endsection

@section('script')
<script>
    var RequestQuery = `{{ count(request()->query()) }}`;
    $(document).ready(function(){
        $('#last_update').datepicker({
            dateFormat: 'dd-M-yy',
            // format: 'd-M-Y',
            autoclose: true,
            todayHighlight: true,
        });

        if( RequestQuery > 0 ){
            $('#FilterCollapse').addClass('show');
        }else{
            $('#FilterCollapse').removeClass('show');
        }
    });

    $('body').on('click', '#btn_reset_filter', function(e){
        e.preventDefault();
        let url = `{{ route('realization.index') }}`;
        window.location.replace(url);
    });

    $('#btn_approve_selected_invoice_no').on('click', function() {
        var selectedInvoiceNo = [];

        $('.check_realization:checked').each(function() {
            selectedInvoiceNo.push($(this).data('invoice_no'));
        });

        $('#invoiceNoInput').val(JSON.stringify(selectedInvoiceNo));
        $('#multiple_approve_realization_form').submit();
    });

    $('.clickable-td').click(function(event) {
        if (event.target.tagName !== 'INPUT') {
            const checkbox = $(this).find('input[type="checkbox"]');
            checkbox.prop('checked', !checkbox.prop('checked'));
        }

        let Filters = `{{ http_build_query(request()->query()) }}`;
        let AddHiddenInputForFilters = '';
        let ArrayFilter = @json(request()->query());

        
        $.each(ArrayFilter, function(x, y){
            if( y != null && y != 'null' ){
                AddHiddenInputForFilters += `
                <input type="hidden" name="${x}" value="${y}" />
                `;
            }
        });

        console.log(Filters, AddHiddenInputForFilters, ArrayFilter);

        $('#appendFormForMultipleApprove').html(AddHiddenInputForFilters);
    });

    $('#th_check').click(function(event) {
        if (event.target.tagName !== 'INPUT') {
            const checkbox = $(this).find('#select_all');
            checkbox.prop('checked', !checkbox.prop('checked'));

            var isChecked = checkbox.is(':checked');
            $('.check_realization').prop('checked', isChecked);
        }
    })

    $('#select_all').on('click', function() {
        // Check or uncheck all checkboxes based on the state of the Select All checkbox
        var isChecked = $(this).is(':checked');
        $('.check_realization').prop('checked', isChecked);

        let Filters = `{{ http_build_query(request()->query()) }}`;
        let AddHiddenInputForFilters = '';
        let ArrayFilter = @json(request()->query());

        
        $.each(ArrayFilter, function(x, y){
            if( y != null && y != 'null' ){
                AddHiddenInputForFilters += `
                <input type="hidden" name="${x}" value="${y}" />
                `;
            }
        });

        console.log(Filters, AddHiddenInputForFilters, ArrayFilter);

        $('#appendFormForMultipleApprove').html(AddHiddenInputForFilters);
        
        // $('body').find('#append').html(AddHiddenInputForFilters);
    });
</script>
@endsection

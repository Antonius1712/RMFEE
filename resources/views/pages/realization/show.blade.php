@extends('layouts.app')
@section('title')
    
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('realization.update', $RealizationData->Invoice_No) }}" method="post">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header default">
                            <h3>Realization Group</h3>
                        </div>
                        <hr />
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="invoice_no" class="col-lg-3 col-form-label-lg">Invoice No</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="invoice_no" id="invoice_no" class="form-control col-lg-8" placeholder="Invoice No" value="{{ $RealizationData->Invoice_No }}" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="type_of_invoice" class="col-lg-3 col-form-label-lg">Type of Invoice</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <select name="type_of_invoice" id="type_of_invoice" class="form-control col-lg-8" readonly>
                                    <option value="">Select Type of Invoice</option>
                                    @foreach ($TypeOfInvoice as $val)
                                        <option {{ $val == $RealizationData->Type_Of_Invoice ? 'selected' : '' }} value="{{ $val }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="currency" class="col-lg-3 col-form-label-lg">Currency</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <select name="currency" id="currency" class="form-control col-lg-8" readonly>
                                    <option value="">Select Currency</option>
                                    @foreach ($Currencies as $Currency)
                                        <option {{ $Currency->Currency == $RealizationData->Currency ? 'selected' : '' }} value="{{ $Currency->Currency }}">{{ $Currency->Description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="invoice_date" class="col-lg-3 col-form-label-lg">Invoice Date</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="invoice_date" id="invoice_date" class="form-control col-lg-8" placeholder="Invoice Date" value="{{ $RealizationData->Invoice_Date }}" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="broker_id" class="col-lg-3 col-form-label-lg">Broker ID</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="broker_id" id="broker_id" class="form-control col-lg-8" placeholder="Broker ID" value="{{ isset($BrokerData) && $BrokerData != '' ? $BrokerData->ID : '' }}" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="broker" class="col-lg-3 col-form-label-lg">Broker</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="broker" id="broker" class="form-control col-lg-8" placeholder="Broker" readonly value="{{ isset($BrokerData) && $BrokerData != "" ? $BrokerData->Name : "" }}" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="total_amount_invoice" class="col-lg-3 col-form-label-lg">Total Amount Invoice</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="total_amount_invoice" id="total_amount_invoice" class="form-control col-lg-8" placeholder="Total Amount Invoice" value="{{ number_format($TotalAmountRealization) }}" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="type_of_payment" class="col-lg-3 col-form-label-lg">Type of Payment </label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="type_of_payment" id="type_of_payment" class="form-control col-lg-8" value="{{ $TypeOfPayment }}" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="payment_to" class="col-lg-3 col-form-label-lg">Payment To</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="payment_to" id="payment_to" class="form-control col-lg-8" placeholder="Payment To" value="{{ isset($PaymentToData) && $PaymentToData != '' ? $PaymentToData->ID : ''}}" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="account_name" class="col-lg-3 col-form-label-lg">Account Name</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="account_name" id="account_name" class="form-control col-lg-8" placeholder="Account Name" readonly value="{{ isset($PaymentToData) && $PaymentToData != '' ? $PaymentToData->BankAccount : ''}}">
                            </div>
                            <div class="form-group row">
                                <label for="account_no" class="col-lg-3 col-form-label-lg">Account No</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="account_no" id="account_no" class="form-control col-lg-8" placeholder="Account No" readonly value="{{ isset($PaymentToData) && $PaymentToData != '' ? $PaymentToData->AccountNo : ''}}">
                            </div>
                            <div class="form-group row">
                                <label for="bank_name" class="col-lg-3 col-form-label-lg">Bank Name</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="bank_name" id="bank_name" class="form-control col-lg-8" placeholder="Bank Name" readonly value="{{ isset($PaymentToData) && $PaymentToData != '' ? $PaymentToData->BankName : ''}}">
                            </div>
                            <div class="form-group row">
                                <label for="vat" class="col-lg-3 col-form-label-lg">VAT</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="vat" id="vat" class="form-control col-lg-8" placeholder="VAT" readonly value="{{ isset($PaymentToData) && $PaymentToData != '' ? $PaymentToData->VAT : ''}}">
                            </div>
                            <div class="form-group row">
                                <label for="vat_subsidies" class="col-lg-3 col-form-label-lg">VAT Subsidies</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="vat_subsidies" id="vat_subsidies" class="form-control col-lg-8" placeholder="VAT Subsidies" readonly value="{{ isset($PaymentToData) && $PaymentToData != '' ? $PaymentToData->VATSubsidies : ''}}">
                            </div>
                            <div class="form-group row">
                                <label for="tax" class="col-lg-3 col-form-label-lg">Tax</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="tax" id="tax" class="form-control col-lg-8" placeholder="Tax" readonly value="{{ isset($PaymentToData) && $PaymentToData != '' ? $PaymentToData->TAX : ''}}">
                            </div>
                            <div class="form-group row">
                                <label for="total_realization" class="col-lg-3 col-form-label-lg">Total Realization</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="total_realization" id="total_realization" class="form-control col-lg-8" placeholder="Total Realization" value="{{ number_format($RealizationData->Type_Of_Invoice == 'RMF' ? $TotalRealizationRMF : $TotalRealizationSponsorship) }}" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="upload_invoice" class="col-lg-3 col-form-label-lg">Upload Invoice</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="file" name="upload_invoice" id="upload_invoice" class="form-control {{ $RealizationData->Upload_Invoice_Path ? 'col-lg-6' : 'col-lg-8' }}" placeholder="Upload Invoice" value="">
                                {{-- <a href="javascript:;" data-path="{{ $RealizationData->Upload_Invoice_Path }}" class="primary ViewDocumentRealizationModal col-lg-2">
                                    <i class="feather icon-eye"></i>
                                    Show
                                </a> --}}
                                @if( $RealizationData->Upload_Invoice_Path != '' )
                                <a href="{{ $RealizationData->Upload_Invoice_Path ? asset($RealizationData->Upload_Invoice_Path) : 'javascript:;' }}" class="primary col-lg-2" target="_Blank" download="">
                                    {{-- Download --}}
                                    <i class='feather icon-download' style="font-size: 24px;"></i>
                                </a>
                                @endif
                            </div>
                            <div class="form-group row">
                                <label for="upload_survey_report" class="col-lg-3 col-form-label-lg">Upload Survey Report</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="file" name="upload_survey_report" id="upload_survey_report" class="form-control {{ $RealizationData->Upload_Survey_Report_Path ? 'col-lg-6' : 'col-lg-8' }}" placeholder="Upload Survey Report" value="">
                                {{-- <a href="javascript:;" data-path="{{ $RealizationData->Upload_Survey_Report_Path }}" class="primary ViewDocumentRealizationModal col-lg-2">
                                    <i class="feather icon-eye"></i>
                                    Show
                                </a> --}}
                                @if( $RealizationData->Upload_Survey_Report_Path != '' )
                                <a href="{{ $RealizationData->Upload_Survey_Report_Path ? asset($RealizationData->Upload_Survey_Report_Path) : 'javascript:;' }}" class="primary col-lg-2" target="_Blank" download="">
                                    {{-- Download --}}
                                    <i class='feather icon-download' style="font-size: 24px;"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header default">
                            <h3>APPROVAL</h3>
                        </div>
                        <hr />
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="approval_bu" class="col-lg-3 col-form-label-lg">Approval BU</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="approval_bu" id="approval_bu" class="form-control col-lg-8" placeholder="Approval BU" value="{{ $ApprovalBU }}" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="approval_finance" class="col-lg-3 col-form-label-lg">Approval Finance</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="approval_finance" id="approval_finance" class="form-control col-lg-8" placeholder="Approval Finance" value="{{ $ApprovalFinance }}" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="epo_checker" class="col-lg-3 col-form-label-lg">EPO Checker</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="epo_checker" id="epo_checker" class="form-control col-lg-8" placeholder="EPO Checker" value="{{ $EpoChecker }}" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="epo_approval" class="col-lg-3 col-form-label-lg">EPO Approval</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="epo_approval" id="epo_approval" class="form-control col-lg-8" placeholder="EPO Approval" value="{{ $EpoApproval }}" readonly>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mb-2">
                                    <a href="{{ route('realization.detail-realization.index', $RealizationData->Invoice_No) }}" style="width: 100%; height: 60px;" class="btn btn-outline-primary radius-100">
                                        <b style="font-size: 18px;">View Detail</b>
                                    </a>
                                    <a href="{{ route('realization.index') }}" style="width: 100%; height: 60px;" class="btn btn-primary radius-100 mt-2">
                                        <b style="font-size: 18px;">Back</b>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="from" value="edit"/>
        </form>
    </div>
</div>
@include('add-on.modal-view-file-realization')
@endsection

@section('script')
    <script>
        $(Document).ready(function(){
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        }); 
        
        // ! Datepicker Invoice Date
        $('#invoice_date').datepicker({
            dateFormat: 'dd M yy',
            autoclose: true,
            todayHighlight: true,
        });


        // ! Autocomplete Broker_id Search Profile by BrokerID to put default data to Broker Name.
        $('#broker_id').autocomplete({
            source: function(req, res){
                $('#error_currency').addClass('hidden');
                let currency = $('#currency option:selected').val();
                if( currency == '' ){
                    swal(
                        'Whoops!',
                        `Please Input Currency First.`,
                        'warning'
                    );
                    $('#error_currency').removeClass('hidden');
                    return false;
                }
                $.ajax({
                    url: serach_profile_url,
                    data: {
                        keywords: req.term,
                        currency: currency
                    },
                    success: function( data ) {
                        res($.map(data, function (item) {
                            return {
                                label: `${item.ID} - ${item.Name}`,
                                value: item.ID
                            };
                        }));
                    },
                });
            },
            minLength: 3,
            select: function( event, ui ) {
                let broker_name = ui.item.label.split(' - ')[1];
                $('#broker').val(broker_name);
            },
        });


        // ! Autocomplete Payment_to Search Profile by BrokerID to put default data.
        $('#payment_to').autocomplete({
            source: function(req, res){
                $('#error_currency').addClass('hidden');
                let currency = $('#currency option:selected').val();
                if( currency == '' ){
                    swal(
                        'Whoops!',
                        `Please Input Currency First.`,
                        'warning'
                    );
                    $('#error_currency').removeClass('hidden');
                    return false;
                }
                $.ajax({
                    url: serach_profile_url,
                    data: {
                        keywords: req.term,
                        currency: currency
                    },
                    success: function( data ) {
                        res($.map(data, function (item) {
                            return {
                                label: `${item.ID} - ${item.Name}`,
                                value: item.ID,
                                data: item
                            };
                        }));
                    },
                });
            },
            minLength: 3,
            select: function( event, ui ) {
                let data = ui.item.data;
                $('#account_name').val(data.BankAccount);
                $('#account_no').val(data.AccountNo);
                $('#bank_name').val(data.BankName);
                $('#vat').val(data.VAT);
                $('#vat_subsidies').val(data.VATSubsidies);
                $('#tax').val(data.TAX);
            },
        });

        $('body').on('click', '.ViewDocumentRealizationModal', function(e){
            e.preventDefault();

            // Path of Document file.
            let path = `${url}/${$(this).data('path')}`;

            // Append Path to <img src="" />
            if( $(this).data('path') == '' ){
                $('#RealizationModalBodyEmpty').html('<b class="text-center">Empty Data.</b>');
                $('#RealizationModalBodyEmpty').show();

                $('#RealizationModalBodyImg').hide();
            } else {
                $('#RealizationModalBodyEmpty').hide();
                
                $('#imgDocumentRealization').attr('src', path);
                $('#RealizationModalBodyImg').show();
            }

            // Show Bootstrap Modal
            $('#ViewDocumentRealizationModal').modal('show');
        });
    </script>
@endsection
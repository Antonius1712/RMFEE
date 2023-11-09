@extends('layouts.app')
@section('title')
    
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        {{-- <form action="{{ route('realization.store') }}" method="post"> --}}
        <form action="javscript:;" method="post">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header default">
                            <h3>DETAIL REALIZATION</h3>
                            <span class="pull-left">*Please Check the Data Carefully.</span>
                        </div>
                        <hr />
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="invoice_no" class="col-lg-3 col-form-label-lg">Invoice No</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="invoice_no" id="invoice_no" class="form-control col-lg-8" placeholder="Invoice No">
                            </div>
                            <div class="form-group row">
                                <label for="type_of_invoice" class="col-lg-3 col-form-label-lg">Type of Invoice</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="type_of_invoice" id="type_of_invoice" class="form-control col-lg-8" placeholder="Type of Invoice">
                            </div>
                            <div class="form-group row">
                                <label for="currency" class="col-lg-3 col-form-label-lg">Currency</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="currency" id="currency" class="form-control col-lg-8" placeholder="Currency">
                            </div>
                            <div class="form-group row">
                                <label for="invoice_date" class="col-lg-3 col-form-label-lg">Invoice Date</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="invoice_date" id="invoice_date" class="form-control col-lg-8" placeholder="Invoice Date">
                            </div>
                            <div class="form-group row">
                                <label for="broker_id" class="col-lg-3 col-form-label-lg">Broker ID</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="broker_id" id="broker_id" class="form-control col-lg-8" placeholder="Broker ID">
                            </div>
                            <div class="form-group row">
                                <label for="broker" class="col-lg-3 col-form-label-lg">Broker</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="broker" id="broker" class="form-control col-lg-8" placeholder="Broker" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="total_amount_invoice" class="col-lg-3 col-form-label-lg">Total Amount Invoice</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="total_amount_invoice" id="total_amount_invoice" class="form-control col-lg-8" placeholder="Total Amount Invoice" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="type_of_payment" class="col-lg-3 col-form-label-lg">Type of Payment </label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="type_of_payment" id="type_of_payment" class="form-control col-lg-8" placeholder="Type of Payment">
                            </div>
                            <div class="form-group row">
                                <label for="payment_to" class="col-lg-3 col-form-label-lg">Payment To</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="payment_to" id="payment_to" class="form-control col-lg-8" placeholder="Payment To">
                            </div>
                            <div class="form-group row">
                                <label for="account_name" class="col-lg-3 col-form-label-lg">Account Name</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="account_name" id="account_name" class="form-control col-lg-8" placeholder="Account Name" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="account_no" class="col-lg-3 col-form-label-lg">Account No</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="account_no" id="account_no" class="form-control col-lg-8" placeholder="Account No" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="bank_name" class="col-lg-3 col-form-label-lg">Bank Name</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="bank_name" id="bank_name" class="form-control col-lg-8" placeholder="Bank Name" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="vat" class="col-lg-3 col-form-label-lg">VAT</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="vat" id="vat" class="form-control col-lg-8" placeholder="VAT" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="vat_subsidies" class="col-lg-3 col-form-label-lg">VAT Subsidies</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="vat_subsidies" id="vat_subsidies" class="form-control col-lg-8" placeholder="VAT Subsidies" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="tax" class="col-lg-3 col-form-label-lg">Tax</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="tax" id="tax" class="form-control col-lg-8" placeholder="Tax" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="total_realization" class="col-lg-3 col-form-label-lg">Total Realization</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="total_realization" id="total_realization" class="form-control col-lg-8" placeholder="Total Realization" readonly>
                            </div>
                            <div class="form-group row">
                                <label for="upload_invoice" class="col-lg-3 col-form-label-lg">Upload Invoice</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="file" name="upload_invoice" id="upload_invoice" class="form-control col-lg-8" placeholder="Upload Invoice">
                            </div>
                            <div class="form-group row">
                                <label for="upload_survey_report" class="col-lg-3 col-form-label-lg">Upload Survey Report</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="file" name="upload_survey_report" id="upload_survey_report" class="form-control col-lg-8" placeholder="Upload Survey Report">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header default">
                            <input type="text" name="search_policy" id="search_policy" class="form-control radius" placeholder="Seach Policy">
                        </div>
                        <hr />
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="approval_bu" class="col-lg-3 col-form-label-lg">Approval BU</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="approval_bu" id="approval_bu" class="form-control col-lg-8" placeholder="Approval BU">
                            </div>
                            <div class="form-group row">
                                <label for="approval_finance" class="col-lg-3 col-form-label-lg">Approval Finance</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="approval_finance" id="approval_finance" class="form-control col-lg-8" placeholder="Approval Finance">
                            </div>
                            <div class="form-group row">
                                <label for="epo_checker" class="col-lg-3 col-form-label-lg">EPO Checker</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="epo_checker" id="epo_checker" class="form-control col-lg-8" placeholder="EPO Checker">
                            </div>
                            <div class="form-group row">
                                <label for="epo_approval" class="col-lg-3 col-form-label-lg">EPO Approval</label>
                                <label class="col-lg-1 col-form-label-lg">:</label>
                                <input type="text" name="epo_approval" id="epo_approval" class="form-control col-lg-8" placeholder="EPO Approval">
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mb-2">
                                    <button type="submit" style="width: 100%; height: 60px;" class="btn btn-primary radius-100">
                                        <b style="font-size: 18px;">Save</b>
                                    </button>
                                </div>
                                <div class="col-lg-12 mb-2">
                                    <a href="{{ route('realization.detail-realization') }}" style="width: 100%; height: 60px;" class="btn btn-outline-primary radius-100">
                                        <i class="feather icon-plus-square"></i>
                                        <b style="font-size: 18px;">Add Detail</b>
                                    </a>
                                </div>

                                <div class="col-lg-12 mb-2">
                                    <div class="divider">OR</div>
                                </div>

                                <div class="col-lg-12 mb-2">
                                    <button type="submit" style="width: 100%; height: 60px;" class="btn btn-primary radius-100">
                                        <i class="feather icon-upload"></i>
                                        <b style="font-size: 18px;">Propose</b>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
    
@endsection
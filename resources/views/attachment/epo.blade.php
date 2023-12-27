@extends('layouts.attachment.app')
@section('content')
<div class="ds-form-container">
    <div class="row ds-cs-nomargin">
        <div class="col-lg-12 ds-cs-nopadding">
            <center><a href="{{ url('/') }}"></a></center>
        </div>
    </div>

    <div class="ds-stepwizard-step col-xs-12 col-lg-12 maxWidth885px">
        <div class="setup-content">
            <!-- panel -->
            <div class="panel-body">
                <div class="ds-container">
                    <div class="row ds-cs-nomargin">
                        <div class="col-xs-12 col-s-12 col-md-12 col-lg-12">
                            <div style="border: 1px solid black; text-align: center;">
                                <h3>
                                    <strong>Purchase Order</strong>
                                </h3>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        
                        {{-- PO LEFT --}}
                        <div class="col-xs-8 col-s-8 col-md-8 col-lg-8" style="margin-top: 2%;">
                            <div class="form-group">
                                <div class="col-xs-3 col-s-3 col-md-3 col-lg-3">
                                    <strong>To</strong>
                                </div>
                                <div class="col-xs-1 col-s-1 col-md-1 col-lg-1">
                                    <strong>:</strong>
                                </div>
                                <div class="col-xs-8 col-s-8 col-md-8 col-lg-8">
                                    <strong>To</strong>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 2%;">
                                <div class="col-xs-3 col-s-3 col-md-3 col-lg-3">
                                    <strong>Address</strong>
                                </div>
                                <div class="col-xs-1 col-s-1 col-md-1 col-lg-1">
                                    <strong>:</strong>
                                </div>
                                <div class="col-xs-8 col-s-8 col-md-8 col-lg-8">
                                    <strong>To</strong>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 2%;">
                                <div class="col-xs-3 col-s-3 col-md-3 col-lg-3">
                                    <strong>Phone/Fax</strong>
                                </div>
                                <div class="col-xs-1 col-s-1 col-md-1 col-lg-1">
                                    <strong>:</strong>
                                </div>
                                <div class="col-xs-8 col-s-8 col-md-8 col-lg-8">
                                    <strong>To</strong>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 2%;">
                                <div class="col-xs-3 col-s-3 col-md-3 col-lg-3">
                                    <strong>Att</strong>
                                </div>
                                <div class="col-xs-1 col-s-1 col-md-1 col-lg-1">
                                    <strong>:</strong>
                                </div>
                                <div class="col-xs-8 col-s-8 col-md-8 col-lg-8">
                                    <strong>To</strong>
                                </div>
                            </div>
                        </div>

                        {{-- PO RIGHT --}}
                        <div class="col-xs-4 col-s-4 col-md-4 col-lg-4" style="margin-top: 2%;">
                            <div class="form-group" style="margin-top: 2%;">
                                <div class="col-xs-4 col-s-4 col-md-4 col-lg-4">
                                    <strong>No</strong>
                                </div>
                                <div class="col-xs-1 col-s-1 col-md-1 col-lg-1">
                                    <strong>:</strong>
                                </div>
                                <div class="col-xs-6 col-s-6 col-md-6 col-lg-6">
                                    <strong>{{ $PDF_Epo->PID_Header }}</strong>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 2%;">
                                <div class="col-xs-4 col-s-4 col-md-4 col-lg-4">
                                    <strong>Date</strong>
                                </div>
                                <div class="col-xs-1 col-s-1 col-md-1 col-lg-1">
                                    <strong>:</strong>
                                </div>
                                <div class="col-xs-6 col-s-6 col-md-6 col-lg-6">
                                    <strong>{{ date('d-M-Y', strtotime($PDF_Epo->PODate)) }}</strong>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 2%;">
                                <div class="col-xs-4 col-s-4 col-md-4 col-lg-4">
                                    <strong>Status</strong>
                                </div>
                                <div class="col-xs-1 col-s-1 col-md-1 col-lg-1">
                                    <strong>:</strong>
                                </div>
                                <div class="col-xs-6 col-s-6 col-md-6 col-lg-6">
                                    <strong>{{ $PDF_Epo->POStatus }}</strong>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 2%;">
                                <div class="col-xs-4 col-s-4 col-md-4 col-lg-4">
                                    <strong>Branch</strong>
                                </div>
                                <div class="col-xs-1 col-s-1 col-md-1 col-lg-1">
                                    <strong>:</strong>
                                </div>
                                <div class="col-xs-6 col-s-6 col-md-6 col-lg-6">
                                    <strong>{{ $PDF_Epo->BranchID }}</strong>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 2%;">
                                <div class="col-xs-4 col-s-4 col-md-4 col-lg-4">
                                    <strong>Dept</strong>
                                </div>
                                <div class="col-xs-1 col-s-1 col-md-1 col-lg-1">
                                    <strong>:</strong>
                                </div>
                                <div class="col-xs-6 col-s-6 col-md-6 col-lg-6">
                                    <strong>{{ $PDF_Epo->DeptIDName }}</strong>
                                </div>
                            </div>
                        </div>

                        {{-- TABLE --}}
                        <div class="col-xs-12 col-s-12 col-md-12 col-lg-12" style="margin-top: 2%;">
                            <table class="table table-borderless" style="border-top: 1px solid #ccc; border-bottom: 1px solid #ccc;">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Description</th>
                                        <th>Qty</th>
                                        <th>Unit Qty</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $PDF_Epo->SeqNo }}</td>
                                        <td>{{ $PDF_Epo->Description }}</td>
                                        <td>{{ $PDF_Epo->Qty }}</td>
                                        <td>{{ $PDF_Epo->UnitID }}</td>
                                        <td>{{ number_format($PDF_Epo->UnitPrice) }}</td>
                                        <td>{{ number_format($PDF_Epo->Total) }}</td>
                                        <td>{{ $PDF_Epo->Remarks_Detail }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" style="text-align: right;">
                                            Total :
                                        </td>
                                        <td>
                                            {{ number_format($PDF_Epo->Total) }}
                                        </td>
                                        <td>
                                            {{ $PDF_Epo->Ccy }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        {{-- ADDITIONAL INFO BOTTOM LEFT --}}
                        <div class="col-xs-6 col-s-6 col-md-6 col-lg-6" style="margin-top: 2%;">
                            <table class="table table-bordered">
                                <tr>
                                    <td colspan="3">
                                        <h5 style="text-align: center;">
                                            <strong>Additional Information</strong>
                                        </h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: white; background-color: grey;">Payment Type</td>
                                    <td>:</td>
                                    <td style="text-align: center;">{{ $PDF_Epo->PaymentType }}</td>
                                </tr>
                                <tr>
                                    <td style="color: white; background-color: grey;">Payment Method</td>
                                    <td>:</td>
                                    <td style="text-align: center;">{{ $PDF_Epo->PaymentMethod }}</td>
                                </tr>
                                <tr>
                                    <td style="color: white; background-color: grey;">Delivery Plan</td>
                                    <td>:</td>
                                    <td style="text-align: center;">{{ date('d-M-Y', strtotime($PDF_Epo->DeliveryDate)) }}</td>
                                </tr>
                                <tr>
                                    <td style="color: white; background-color: grey;">Reference No.</td>
                                    <td>:</td>
                                    <td style="text-align: center;">{{ $PDF_Epo->RefNo }}</td>
                                </tr>
                                <tr>
                                    <td style="color: white; background-color: grey;">Requester</td>
                                    <td>:</td>
                                    <td style="text-align: center;">{{ $PDF_Epo->Requester }}</td>
                                </tr>
                                <tr>
                                    <td style="color: white; background-color: grey;">Check By</td>
                                    <td>:</td>
                                    <td style="text-align: center;">{{ $PDF_Epo->CheckerBy }}</td>
                                </tr>
                                <tr>
                                    <td style="color: white; background-color: grey;">Check Asset By</td>
                                    <td>:</td>
                                    <td style="text-align: center;">{{ $PDF_Epo->CheckerAssetBy }}</td>
                                </tr>
                                <tr>
                                    <td style="color: white; background-color: grey;">Approved By</td>
                                    <td>:</td>
                                    <td style="text-align: center;">{{ $PDF_Epo->ApprovedBy }}</td>
                                </tr>
                                <tr>
                                    <td style="color: white; background-color: grey;">Category</td>
                                    <td>:</td>
                                    <td style="text-align: center;">{{ $PDF_Epo->Category }}</td>
                                </tr>
                                <tr>
                                    <td style="color: white; background-color: grey;">Sub Category</td>
                                    <td>:</td>
                                    <td style="text-align: center;">{{ $PDF_Epo->SubCategory }}</td>
                                </tr>
                            </table>
                        </div>

                        {{-- APPROVE BY BOTTOM RIGHT --}}
                        <div class="col-xs-6 col-s-6 col-md-6 col-lg-6" style="margin-top: 2%;">
                            <div style="margin: 25%; 50%; text-align: center;">
                                <b>Approve By : </b>
                                <br/> <br/> <br/>
                                Sign Here.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
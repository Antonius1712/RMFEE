@extends('layouts.app')
@section('title')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            {{-- <form action="{{ route('realization.store') }}" method="post"> --}}
            <form action="{{ route('budget.update', $VoucherId) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="class_of_bussiness" class="col-lg-3 col-form-label-lg">Class</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="class_of_bussiness" id="class_of_bussiness"
                                        class="form-control col-lg-8" placeholder="Class" value="{{ $Budget->CLASS }}" readonly>
                                </div>
                                <div class="form-group row">
                                    <label for="source_of_business" class="col-lg-3 col-form-label-lg">SOB</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="source_of_business" id="source_of_business"
                                        class="form-control col-lg-8" placeholder="SOB" value="{{ $BrokerId }}" readonly>
                                </div>
                                <div class="form-group row">
                                    <label for="broker_name" class="col-lg-3 col-form-label-lg">Broker Name</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="broker_name" id="broker_name" class="form-control col-lg-8"
                                        placeholder="Broker Name" value="{{ $BrokerName }}" readonly>
                                </div>
                                <div class="form-group row">
                                    <label for="policy_no" class="col-lg-3 col-form-label-lg">Policy Number</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="policy_no" id="policy_no" class="form-control col-lg-8"
                                        placeholder="No Policy" value="{{ $Budget->POLICYNO }}" readonly>
                                </div>
                                <div class="form-group row">
                                    <label for="start_date" class="col-lg-3 col-form-label-lg">Start Date</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="start_date" id="start_date" class="form-control col-lg-8"
                                        placeholder="Start Date" value="{{ date('d M Y', strtotime($Budget->Start_Date)) }}" readonly>
                                </div>
                                <div class="form-group row">
                                    <label for="end_date" class="col-lg-3 col-form-label-lg">End Date</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="end_date" id="end_date" class="form-control col-lg-8"
                                        placeholder="End Date" value="{{ date('d M Y', strtotime($Budget->End_Date)) }}" readonly>
                                </div>
                                <div class="form-group row">
                                    <label for="occupation_code" class="col-lg-3 col-form-label-lg">Occupation
                                        Code</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="occupation_code" id="occupation_code"
                                        class="form-control col-lg-8" placeholder="Occupation Code" value="{{ $Budget->OCCUPATION != '' ? ($Budget->CLASS == '01-PROPERTY' && $Budget->OCCUPATION != 'Fleet' ? explode(' - ', $Budget->OCCUPATION)[0] : $Budget->OCCUPATION) : '' }}" readonly>
                                </div>
                                <div class="form-group row">
                                    <label for="occupation_description" class="col-lg-3 col-form-label-lg">Occupation
                                        Description</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="occupation_description" id="occupation_description"
                                        class="form-control col-lg-8" placeholder="Occupation Description" value="{{ $Budget->OCCUPATION != '' ? ($Budget->CLASS == '01-PROPERTY' && $Budget->OCCUPATION != 'Fleet' ? explode(' - ', $Budget->OCCUPATION)[1] : $Budget->OCCUPATION) : '' }}" readonly>
                                </div>
                                <div class="form-group row">
                                    <label for="currency" class="col-lg-3 col-form-label-lg">Currency</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="currency" id="currency" class="form-control col-lg-8"
                                        placeholder="Currency" value="{{ $Budget->CURRENCY }}" readonly>
                                </div>
                                <div class="form-group row">
                                    <label for="gross_premi" class="col-lg-3 col-form-label-lg">Gross Premi</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="gross_premi" id="gross_premi"
                                        class="form-control col-lg-8" placeholder="Gross Premi" value="{{ number_format($Budget->LGI_PREMIUM) }}" readonly>
                                </div>
                                <div class="form-group row">
                                    <label for="status_premi" class="col-lg-3 col-form-label-lg">Status
                                        Premi</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="status_premi" id="status_premi"
                                        class="form-control col-lg-8" placeholder="Status Premi" value="{{ $Budget->Status_Premium }}" readonly>
                                </div>
                                <div class="form-group row">
                                    <label for="os_premi" class="col-lg-3 col-form-label-lg">OS Premi</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="os_premi" id="os_premi" class="form-control col-lg-8"
                                        placeholder="OS Premi" value="{{ number_format($Budget->OS) }}" readonly>
                                </div>
                                <div class="form-group row">
                                    <label for="date_of_premium_paid" class="col-lg-3 col-form-label-lg">Date of Premium
                                        Paid</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="date_of_premium_paid" id="date_of_premium_paid"
                                        class="form-control col-lg-8" placeholder="Date of Premium Paid" value="{{ date('d M Y', strtotime($Budget->PAYMENT_DATE)) }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="budget" class="col-lg-3 col-form-label-lg">Budget(%)</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="budget" id="budget" class="form-control col-lg-8"
                                        placeholder="Budget(%)" value="{{ $Budget->Persentage }}">
                                </div>
                                <div class="form-group row">
                                    <label for="budget_in_amount" class="col-lg-3 col-form-label-lg">Budget in
                                        Amount</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="budget_in_amount" id="budget_in_amount"
                                        class="form-control col-lg-8" placeholder="Budget in Amount" value="{{ number_format($Budget->Budget) }}">
                                </div>
                                <div class="form-group row">
                                    <label for="document" class="col-lg-3 col-form-label-lg">Document</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="file" name="document" id="document" class="form-control {{ $Budget->Document_Path != '' ? 'col-lg-6' : 'col-lg-8' }}"
                                        placeholder="Document" value="">
                                    @if( $Budget->Document_Path != '' )
                                    <a href="{{ $Budget->Document_Path != '' ? asset($Budget->Document_Path) : 'javascript:;' }}" class="col-lg-2" target="_blank" download="">
                                        {{-- Download --}}
                                        {{-- UNTUK NAMA FILE di explode('images/Realization/Invoice/', $Budget->Document_Path)[1] aja. --}}
                                        <i class='feather icon-download' style="font-size: 24px;"></i>
                                    </a>
                                    @endif
                                </div>
                                {{-- {{ dd( Auth()->user()->getUserSetting ) }} --}}
                                <div class="form-group row">
                                    <label for="proposed_to_display" class="col-lg-3 col-form-label-lg">Proposed to</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="proposed_to_display" id="proposed_to_display"
                                        class="form-control col-lg-8" placeholder="Proposed to" value="{{ Auth()->user()->getUserSetting->Approval_BU_UserID }} - {{ Auth()->user()->getUserSetting->getApprovalBUName() }}" readonly>
                                        {{-- 2021044216 --}}
                                    <input type="hidden" name="proposed_to" id="proposed_to" value="{{ Auth()->user()->getUserSetting->Approval_BU_UserID }}">
                                </div>

                                {{-- !Buttons --}}
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <button name="action" value="save" id="btn_save_budget" type="submit" style="width: 100%; height: 60px;"
                                            class="btn btn-outline-primary radius-100">
                                            <b style="font-size: 18px;">Save</b>
                                        </button>
                                    </div>
                                    {{-- <div class="col-lg-12 mb-2">
                                        <a href="{{ route('realization.detail-realization') }}"
                                            style="width: 100%; height: 60px;" class="btn btn-outline-primary radius-100">
                                            <i class="feather icon-plus-square"></i>
                                            <b style="font-size: 18px;">Add Detail</b>
                                        </a>
                                    </div>

                                    <div class="col-lg-12 mb-2">
                                        <div class="divider">OR</div>
                                    </div> --}}

                                    <div class="col-lg-12 mb-2">
                                        <button name="action" value="propose" id="btn_propose_budget" type="submit" style="width: 100%; height: 60px;"
                                            class="btn btn-primary radius-100">
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

            <div class="card-body default text-center">Log Activity</div>
            <table class="table table-bordered">
                <thead>
                    <tr class="default">
                        <th>Name</th>
                        <th>Status</th>
                        <th>Desc</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @if( isset($Logs) )
                        @foreach ($Logs as $Log)
                        <tr class="text-center">
                            <td>{{ $Log->NIK.' - '.$Log->getUser->Name }}</td>
                            <td>{{ $Log->Status }}</td>
                            <td>{{ $Log->Description }}</td>
                            <td>{{ date('Y-m-d', strtotime($Log->Date)) }}</td>
                            <td>{{ $Log->Time }}</td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Budget Percentage to calculate Budget in Amount.
            $('#budget').on('keyup', function(){
                // Validation Percentage.
                    if( $(this).val() > 100 || $(this).val() < 0 ){
                        alert('Errors');
                        $(this).val(0);
                        return false;
                    }

                // Define Variable
                    let budgetPercent = ($(this).val() / 100);
                    let lgiPremi = $('#gross_premi').val();
                    let budgetInAmount = 0;

                // Calculate Budget in Amount.
                    budgetInAmount = budgetPercent * clear_number_format(lgiPremi);

                // Show Calculation Result of Budget in Amount
                    $('#budget_in_amount').val(number_format(budgetInAmount));
            });

        // Budget in Amount to calculate Budget Percentage.
            $('#budget_in_amount').on('keyup', function(){
                // Define Variable
                    let budgetInAmount = $(this).val();
                    let lgiPremi = $('#gross_premi').val();
                    let budgetPercent = 0;

                // Calculate Budget Percentage.
                    budgetPercent = (clear_number_format(budgetInAmount) / clear_number_format(lgiPremi)) * 100;

                // Show Calculation Budget Percentage.
                    $('#budget').val(parseFloat(budgetPercent).toFixed(4));

                // Formating to Thousand Separator on Budget in Amount.
                    $(this).val(number_format($(this).val()));
            });
    </script>
@endsection

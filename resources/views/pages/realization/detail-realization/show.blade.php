@extends('layouts.app')
@section('title')
    
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger text-center">
                    <strong>*{{ $error }}</strong>
                </div>
                @endforeach
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header default">
                        <h3>DETAIL REALIZATION</h3>
                        <span class="pull-left">*Please Check the Data Carefully.</span>
                    </div>
                    <hr />
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="branch" class="col-lg-3 col-form-label-lg">Branch</label>
                            <label class="col-lg-1 col-form-label-lg">:</label>
                            <input type="text" name="branch" id="branch" class="form-control col-lg-8" placeholder="Branch" value="{{ $DetailRealization->BRANCH }}" readonly>
                        </div>
                        <div class="form-group row">
                            <label for="policy_no" class="col-lg-3 col-form-label-lg">Policy No</label>
                            <label class="col-lg-1 col-form-label-lg">:</label>
                            <input type="text" name="policy_no" id="policy_no" class="form-control col-lg-8" placeholder="Policy No" value="{{ $DetailRealization->POLICYNO }}" readonly>
                        </div>
                        <div class="form-group row">
                            <label for="policy_holder" class="col-lg-3 col-form-label-lg">Policy Holder</label>
                            <label class="col-lg-1 col-form-label-lg">:</label>
                            <input type="text" name="policy_holder" id="policy_holder" class="form-control col-lg-8" placeholder="Policy Holder" value="{{ $DetailRealization->Holder_Name }}" readonly>
                        </div>
                        <div class="form-group row">
                            <label for="start_date" class="col-lg-3 col-form-label-lg">Start Date</label>
                            <label class="col-lg-1 col-form-label-lg">:</label>
                            <input type="text" name="start_date" id="start_date" class="form-control col-lg-8" placeholder="Start Date" value="{{ date('d M Y', strtotime($DetailRealization->Start_Date)) }}" readonly>
                        </div>
                        <div class="form-group row">
                            <label for="end_date" class="col-lg-3 col-form-label-lg">End Date</label>
                            <label class="col-lg-1 col-form-label-lg">:</label>
                            <input type="text" name="end_date" id="end_date" class="form-control col-lg-8" placeholder="End Date" value="{{ date('d M Y', strtotime($DetailRealization->End_Date)) }}" readonly>
                        </div>
                        <div class="form-group row">
                            <label for="occupation_code" class="col-lg-3 col-form-label-lg">Occupation Code</label>
                            <label class="col-lg-1 col-form-label-lg">:</label>
                            <input type="text" name="occupation_code" id="occupation_code" class="form-control col-lg-8" placeholder="Occupation Code" value="{{ $DetailRealization->OCCUPATION != null ? ( $DetailRealization->OCCUPATION != 'Fleet' ? explode('-', $DetailRealization->OCCUPATION)[0] : 'Fleet'): '' }}" readonly>
                        </div>
                        <div class="form-group row">
                            <label for="occupation_description" class="col-lg-3 col-form-label-lg">Occupation Description</label>
                            <label class="col-lg-1 col-form-label-lg">:</label>
                            <input type="text" name="occupation_description" id="occupation_description" class="form-control col-lg-8" placeholder="Occupation Description" value="{{ $DetailRealization->OCCUPATION != null ? ( $DetailRealization->OCCUPATION != 'Fleet' ? explode('-', $DetailRealization->OCCUPATION)[1] : 'Fleet'): '' }}" readonly>
                        </div>
                        <div class="form-group row">
                            <label for="real_currency" class="col-lg-3 col-form-label-lg">Currency</label>
                            <label class="col-lg-1 col-form-label-lg">:</label>
                            <input type="text" name="real_currency" id="real_currency" class="form-control col-lg-8" placeholder="Currency" value="{{ $DetailRealization->CURRENCY }}" readonly>
                        </div>  
                        <div class="form-group row">
                            <label for="gross_premi" class="col-lg-3 col-form-label-lg">Gross Premi</label>
                            <label class="col-lg-1 col-form-label-lg">:</label>
                            <input type="text" name="gross_premi" id="gross_premi" class="form-control col-lg-8" placeholder="Gross Premi" value="{{ number_format($DetailRealization->LGI_PREMIUM) }}" readonly>
                        </div>
                        <div class="form-group row">
                            <label for="status_premi" class="col-lg-3 col-form-label-lg">Status Premi</label>
                            <label class="col-lg-1 col-form-label-lg">:</label>
                            <input type="text" name="status_premi" id="status_premi" class="form-control col-lg-8" placeholder="Status Premi" value="{{ $DetailRealization->Status_Premium }}" readonly>
                        </div>
                        <div class="form-group row">
                            <label for="os_premi" class="col-lg-3 col-form-label-lg">OS Premi</label>
                            <label class="col-lg-1 col-form-label-lg">:</label>
                            <input type="text" name="os_premi" id="os_premi" class="form-control col-lg-8" placeholder="OS Premi" value="{{ number_format($DetailRealization->OS) }}" readonly>
                        </div>
                        <div class="form-group row">
                            <label for="date_of_premium_paid" class="col-lg-3 col-form-label-lg">Date of Premium Paid</label>
                            <label class="col-lg-1 col-form-label-lg">:</label>
                            <input type="text" name="date_of_premium_paid" id="date_of_premium_paid" class="form-control col-lg-8" placeholder="Date of Premium Paid" value="{{ date('d M Y', strtotime($DetailRealization->PAYMENT_DATE)) }}" readonly>
                        </div>
                        {{-- <div class="form-group row">
                            <label for="premium_note" class="col-lg-3 col-form-label-lg">Premium Note</label>
                            <label class="col-lg-1 col-form-label-lg">:</label>
                            <input type="text" name="premium_note" id="premium_note" class="form-control col-lg-8" placeholder="Premium Note" value="{{ $DetailRealization->COMMENT }}" readonly>
                        </div> --}}

                        <input id="voucher" type="hidden" name="voucher" value="{{ $DetailRealization->budget_voucher }}"/>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header default">
                        <input type="text" name="search_policy" id="search_policy" class="form-control radius" placeholder="Seach Policy" value="{{ $DetailRealization->POLICYNO }}" readonly>
                    </div>
                    <hr />
                    <div id="ClearForm" class="card-body">
                        <div class="form-group row">
                            <label for="budget" class="col-lg-3 col-form-label-lg">Budget</label>
                            <label class="col-lg-1 col-form-label-lg">:</label>
                            <input type="text" name="budget" id="budget" class="form-control col-lg-8" placeholder="Budget" readonly value="{{ $DetailRealization->Persentage }}">
                        </div>
                        <div class="form-group row">
                            <label for="budget_in_amount" class="col-lg-3 col-form-label-lg">Budget in Amount</label>
                            <label class="col-lg-1 col-form-label-lg">:</label>
                            <input type="text" name="budget_in_amount" id="budget_in_amount" class="form-control col-lg-8" placeholder="Budget in Amount" readonly value="{{ number_format($DetailRealization->Budget) }}">
                        </div>
                        <div class="form-group row">
                            <label for="remain_budget" class="col-lg-3 col-form-label-lg">Remain Budget</label>
                            <label class="col-lg-1 col-form-label-lg">:</label>
                            <input type="text" name="remain_budget" id="remain_budget" class="form-control col-lg-8" placeholder="Remain Budget" readonly value="{{ $DetailRealization->CURRENCY == 'IDR' ? number_format($DetailRealization->REMAIN_BUDGET, 2) : number_format($DetailRealization->REMAIN_BUDGET, 4) }}">
                        </div>
                        <div class="form-group row">
                            <label for="ending_balance" class="col-lg-3 col-form-label-lg">Ending Balance</label>
                            <label class="col-lg-1 col-form-label-lg">:</label>
                            <input type="text" name="ending_balance" id="ending_balance" class="form-control col-lg-8" placeholder="Ending Balance" readonly>
                        </div>
                        <div class="form-group row">
                            <label for="amount_realization" class="col-lg-3 col-form-label-lg">Amount Realization</label>
                            <label class="col-lg-1 col-form-label-lg">:</label>
                            <input type="text" name="amount_realization" id="amount_realization" class="form-control col-lg-8" placeholder="Amount Realization" readonly value="{{ number_format($DetailRealization->amount_realization) }}">
                        </div>
                        <div class="form-group row">
                            <label for="currency_realization" class="col-lg-3 col-form-label-lg">Currency Realization</label>
                            <label class="col-lg-1 col-form-label-lg">:</label>
                            <select name="currency_realization" id="currency_realization" class="form-control col-lg-8" readonly>
                                <option value="">Select Currency</option>
                                @foreach ($Currencies as $Currency)
                                    <option {{ $Currency->Currency == $DetailRealization->currency_realization ? 'selected' : '' }} value="{{ $Currency->Currency }}">{{ $Currency->Description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="exchange_rate" class="col-lg-3 col-form-label-lg">Exchange Rate</label>
                            <label class="col-lg-1 col-form-label-lg">:</label>
                            <input type="text" name="exchange_rate" id="exchange_rate" class="form-control col-lg-8" placeholder="Exchange Rate" value="{{ number_format($DetailRealization->exchange_rate_realization) }}" readonly>
                        </div>
                        <div class="form-group row">
                            <label for="total_amount_realization" class="col-lg-3 col-form-label-lg">Total Amount Realization</label>
                            <label class="col-lg-1 col-form-label-lg">:</label>
                            <input type="text" name="total_amount_realization" id="total_amount_realization" class="form-control col-lg-8" placeholder="Total Amount Realization" value="{{ number_format($DetailRealization->total_amount_realization) }}" readonly>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mb-2">
                                <a href="{{ route('realization.detail-realization.index', $invoice_no) }}" style="width: 100%; height: 60px;" class="btn btn-primary radius-100">
                                    <b style="font-size: 18px;">Back</b>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    var search_budget_url = '{{ route("utils.search_budget_by_policy_no_and_broker_name") }}';
    var broker_name = '{{ $BrokerName }}';

    $(document).ready(function(){
        $('#start_date, #end_date, #date_of_premium_paid').datepicker({
            format: 'dd M yy',
            autoclose: true,
            todayHighlight: true,
        });
    });

    $('#search_policy').autocomplete({
        source: function(req, res){
            $.ajax({
                url: search_budget_url,
                data: {
                    keywords: req.term,
                    broker_name: broker_name
                },
                success: function( data ) {
                    res($.map(data, function (item) {
                        return {
                            label: `${item.POLICYNO}`,
                            value: item.POLICYNO,
                            data: item
                        };
                    }));
                },
            });
        },
        minLength: 4,
        select: function( event, ui ) {
            let data = ui.item.data;
            $('#branch').val(data.BRANCH);
            $('#policy_no').val(data.POLICYNO);
            $('#policy_holder').val(data.Holder_Name);
            $('#start_date').val(data.Start_Date);
            $('#end_date').val(data.End_Date);
            $('#occupation_code').val(data.OCCUPATION.split(' - ')[0]);
            $('#occupation_description').val(data.OCCUPATION.split(' - ')[1]);
            $('#real_currency').val(data.CURRENCY);
            $('#gross_premi').val(data.PREMIUM);
            $('#status_premi').val(data.Status_Premium);
            $('#os_premi').val(data.OS);
            $('#date_of_premium_paid').val(data.PAYMENT_DATE);
            $('#premium_note').val(data.COMMENT);
            $('#budget').val(data.Persentage);
            $('#budget_in_amount').val(number_format(data.Budget));
            if( data.CURRENCY == 'IDR' ){
                $('#remain_budget').val(number_format(data.REMAIN_BUDGET, 2));
                console.log(number_format(data.REMAIN_BUDGET, 2));
            }else{
                $('#remain_budget').val(number_format(data.REMAIN_BUDGET, 4));
                console.log(number_format(data.REMAIN_BUDGET, 4));
            }
            $('#voucher').val(data.VOUCHER);

            $('#amount_realization').attr('readonly', false);
            $('#exchange_rate').attr('readonly', false);
        },
    });

    $('#amount_realization, #exchange_rate').change(function(){
        let amount_realization = $('#amount_realization').val();
        let exchange_rate = $('#exchange_rate').val();
        let gross_premi = $('#gross_premi').val();
        let remain_budget = $('#remain_budget').val();
        let budget_in_amount = $('#budget_in_amount').val();
        let total_amount_realization = 0;

        remain_budget = clear_number_format(remain_budget);
        amount_realization = clear_number_format(amount_realization);
        exchange_rate = clear_number_format(exchange_rate);

        total_amount_realization = amount_realization * exchange_rate;

        // if( total_amount_realization > remain_budget ) {
        //     swal(
        //         'Whoops!',
        //         `Total Amount Realization Exceeding Remain Budget.`,
        //         'warning'
        //     );
        //     amount_realization = 0;
        //     exchange_rate = 0;
        //     total_amount_realization = 0;
        // }

        amount_realization = number_format(amount_realization);
        exchange_rate = number_format(exchange_rate);
        total_amount_realization = number_format(total_amount_realization);

        $('#amount_realization').val(amount_realization);
        $('#exchange_rate').val(exchange_rate);
        $('#total_amount_realization').val(total_amount_realization);
    });
</script>
@endsection
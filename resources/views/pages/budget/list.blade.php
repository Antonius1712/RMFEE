@extends('layouts.app')
@section('title')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 mb-2">
            <label>
                {{-- <input type="checkbox" name="to_do_list" id="to_do_list" class="to-do-list"
                    style="width: 30px; height: 30px; vertical-align: middle;" value=""
                    {{ request()->get('to_do_list_filter') == 'Yes' ? 'checked' : '' }}> --}}
                <input type="checkbox" name="to_do_list" id="to_do_list" class="to-do-list"
                    style="width: 30px; height: 30px; vertical-align: middle;" {{ request()->get('to_do_list_filter') == 'true' ? 'checked' : '' }} />
                <b style="font-size: 20px; vertical-align: middle;" class="ml-1">To do List</b>
            </label>
        </div>

        <div class="col-lg-6 mb-2">
            <a class="btn btn-primary pull-right" style="border-radius: 100px; font-size: 18px;" aria-expanded="false"
                data-toggle="collapse" data-target="#FilterCollapse">
                <i class="feather icon-filter text-white"></i>
                <span class="text-white">Filter</span>
            </a>
        </div>
    </div>

    <div class="card collapse" id="FilterCollapse">
        <form action="{{ route('budget.list') }}" method="get">
            <input type="hidden" id="to_do_list_filter" name="to_do_list_filter" value="{{ request()->get('to_do_list_filter') == 'true' ? 'checked' : 'false' }}" />
            <div class="card-body row" id="card-filter">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="broker_name">Broker Name</label>
                        <input type="text" name="broker_name" id="broker_name" class="form-control radius"
                            value="{{ request()->get('broker_name') }}" placeholder="Type Here..">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="branch">Branch</label>
                        <select name="branch" id="branch" class="form-control radius">
                            <option value="">All</option>
                            @if (count($branchList) > 0)
                                @foreach ($branchList as $val)
                                    <option {{ request()->get('branch') == $val->Branch ? 'selected' : '' }}
                                        value="{{ $val->Branch }}">{{ $val->Branch }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="status_pembayaran_premi">Status Pembayaran Premi</label>
                        {{-- <input type="text" name="status_pembayaran_premi" id="status_pembayaran_premi"
                        class="form-control radius" placeholder="Type Here.."> --}}
                        <select name="status_pembayaran_premi" id="status_pembayaran_premi" class="form-control radius">
                            <option value="">All</option>
                            @foreach ($statusPremi as $val)
                                <option {{ request()->get('status_pembayaran_premi') == $val ? 'selected' : '' }}
                                    value="{{ $val }}">{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="text" name="start_date" id="start_date" class="form-control radius"
                            value="{{ request()->get('start_date') }}" placeholder="Type Here..">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="no_policy">No Policy</label>
                        <input type="text" name="no_policy" id="no_policy" class="form-control radius"
                            value="{{ request()->get('no_policy') }}" placeholder="Type Here..">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="aging_rmf">Aging RMF</label>
                        <input type="text" name="aging_rmf" id="aging_rmf" class="form-control radius"
                            value="{{ request()->get('aging_rmf') }}" placeholder="Type Here..">
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="booking_date_from">Booking Date From</label>
                        <input type="text" name="booking_date_from" class="form-control" id="booking_date_from"
                            value="{{ request()->get('booking_date_from') }}">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="nb_rn">NB/RN</label>
                        <select name="nb_rn" id="nb_rn" class="form-control radius">
                            <option value="">All</option>
                            @foreach ($NBRN as $val)
                                <option {{ request()->get('nb_rn') == $val ? 'selected' : '' }}
                                    value="{{ $val }}">{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="holder_name">Holder Name</label>
                        <input type="text" name="holder_name" id="holder_name" class="form-control radius"
                            value="{{ request()->get('holder_name') }}" placeholder="Type Here..">
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="booking_date_to">Booking Date To</label>
                        <input type="text" name="booking_date_to" id="booking_date_to" class="form-control"
                            value="{{ request()->get('booking_date_to') }}">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="ClassBusiness">Class</label>
                        <select name="ClassBusiness" id="ClassBusiness" class="form-control radius">
                            <option value="">All</option>
                            <option {{ request()->get('ClassBusiness') == '02-MOTOR VEHICLE' ? 'selected' : '' }}
                                value="02-MOTOR VEHICLE">02-MOTOR VEHICLE</option>
                            <option {{ request()->get('ClassBusiness') == '01-PROPERTY' ? 'selected' : '' }}
                                value="01-PROPERTY">01-PROPERTY</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="status_realisasi">Status Realisasi</label>
                        <select name="status_realisasi" id="status_realisasi" class="form-control radius">
                            <option value="">All</option>
                            @foreach ($statusRealisasi as $val)
                                <option {{ request()->get('status_realisasi') == $val ? 'selected' : '' }}
                                    value="{{ $val }}">{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-4"></div>
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="status_budget">Status Budget</label>
                        <select name="status_budget" id="status_budget" class="form-control radius">
                            <option value="">All</option>
                            @foreach ($statusBudget as $val)
                                <option {{ request()->get('status_budget') == $val ? 'selected' : '' }}
                                    value="{{ $val }}">{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-6">
                    <button id="btn_reset_filter" name="btn_reset_filter" value="btn_reset_filter" class="btn btn-outline-primary waves-effect waves-light radius-100"
                        style="width: 100%;">
                        Reset Filter
                    </button>
                </div>
                <div class="col-lg-6">
                    <button type="submit" id="btn_apply_filter"
                        class="btn btn-primary waves-effect waves-light radius-100" style="width: 100%;">
                        Apply Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if (session()->has('notification'))
        <div class="alert alert-success text-center">
            {!! session()->get('notification') !!}
        </div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-budget dataTable" style="overflow-x: auto; overflow-y: none; height:">
                <thead>
                    <tr class="default tr-budget">
                        <th>Action</th>
                        <th id="th_class">CLASS</th>
                        <th id="th_broker_name">BROKER NAME</th>
                        <th id="th_type">TYPE</th>
                        <th id="th_branch">BRANCH</th>
                        <th id="th_policy_number">POLICY NUMBER</th>
                        <th id="th_holder_name">HOLDER NAME</th>
                        <th id="th_booking_date">BOOKING DATE</th>
                        <th id="th_start_date">START DATE</th>
                        <th id="th_end_date">END DATE</th>
                        <th id="th_currency">CURRENCY</th>
                        <th id="th_lgi_premium">LGI PREMIUM</th>
                        <th id="th_premium">PREMIUM</th>
                        <th id="th_admin">ADMIN</th>
                        <th id="th_discount">DISCOUNT</th>
                        <th id="th_other_income">OTHERINCOME</th>
                        <th id="th_payment">PAYMENT</th>
                        <th id="th_payment_date">PAYMENT DATE</th>
                        <th id="th_os">OS</th>
                        <th id="th_status_premium">STATUS PREMIUM</th>
                        <th id="th_voucher">VOUCHER</th>
                        <th id="th_occupation">OCCUPATION</th>
                        <th id="th_comment">COMMENT</th>
                        <th id="th_caep">CAEP</th>
                        <th id="th_percentage">PERCENTAGE</th>
                        <th id="th_aging_realization">AGING REALIZATION</th>
                        <th id="th_budget">BUDGET</th>
                        <th id="th_realization_rmf">REALIZATION RMF</th>
                        <th id="th_realization_sponsorship">REALIZATION SPONSORSHIP</th>
                        <th id="th_remain_budget">REMAIN BUDGET</th>
                        <th id="th_status_budget">STATUS BUDGET</th>
                        <th id="th_status_realisasi">STATUS REALIZATION</th>
                        <th id="th_proposed_to" style="display:none;">PROPOSED TO</th>
                        <th id="th_last_edited_by" style="display:none;">LAST EDITED BY</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Budgets as $Budget)
                        {{-- {{ dd($Budget) }} --}}
                        <tr>
                            <td>
                                {!! $Budget->Action !!}
                            </td>
                            <td>{{ $Budget->CLASS }}</td>
                            <td>{{ $Budget->BROKERNAME }}</td>
                            <td>{{ $Budget->TYPE }}</td>
                            <td>{{ $Budget->BRANCH }}</td>
                            <td>{{ $Budget->POLICYNO }}</td>
                            <td>{{ $Budget->Holder_Name }}</td>
                            <td>{{ $Budget->ADATE }}</td>
                            <td>{{ $Budget->Start_Date }}</td>
                            <td>{{ $Budget->End_Date }}</td>
                            <td>{{ $Budget->CURRENCY }}</td>
                            <td>{{ $Budget->LGI_PREMIUM }}</td>
                            <td>{{ $Budget->PREMIUM }}</td>
                            <td>{{ $Budget->ADMIN }}</td>
                            <td>{{ $Budget->DISCOUNT }}</td>
                            <td>{{ $Budget->OTHERINCOME }}</td>
                            <td>{{ $Budget->PAYMENT }}</td>
                            <td>{{ $Budget->PAYMENT_DATE }}</td>
                            <td>{{ $Budget->OS }}</td>
                            <td>{{ $Budget->Status_Premium }}</td>
                            <td>{{ $Budget->VOUCHER }}</td>
                            <td class="td_occupation" data-occupation="{{ $Budget->OCCUPATION }}">
                                {{-- {{ $Budget->OCCUPATION }} --}}
                                @php
                                    $arrayOfWord = explode(' ', $Budget->OCCUPATION);
                                    $displayTextOccupation = '';

                                    if (count($arrayOfWord) >= 15) {
                                        foreach ($arrayOfWord as $key => $val) {
                                            if ($key <= 10) {
                                                $displayTextOccupation .= $val . ' ';
                                            }
                                        }
                                        $displayTextOccupation = rtrim($displayTextOccupation, ' ');
                                        $displayTextOccupation .= '...';
                                    } else {
                                        $displayTextOccupation = $Budget->OCCUPATION;
                                    }
                                @endphp
                                {{ $displayTextOccupation }}
                            </td>
                            <td class="td_comment" data-comment="{{ $Budget->COMMENT }}">
                                @php
                                    $arrayOfWord = explode(' ', $Budget->COMMENT);
                                    $displayTextComment = '';

                                    if (count($arrayOfWord) >= 15) {
                                        foreach ($arrayOfWord as $key => $val) {
                                            if ($key <= 10) {
                                                $displayTextComment .= $val . ' ';
                                            }
                                        }
                                        $displayTextComment = rtrim($displayTextComment, ' ');
                                        $displayTextComment .= '...';
                                    } else {
                                        $displayTextComment = $Budget->COMMENT;
                                    }
                                @endphp
                                {{ $displayTextComment }}
                            </td>
                            <td>{{ $Budget->CAEP }}</td>
                            <td>{{ $Budget->Persentage }}</td>
                            <td>{{ $Budget->AGING_REALIZATION }}</td>
                            <td>{{ $Budget->Budget }}</td>
                            <td>{{ $Budget->REALIZATION_RMF }}</td>
                            <td>{{ $Budget->REALIZATION_SPONSORSHIP }}</td>
                            <td>{{ $Budget->REMAIN_BUDGET }}</td>
                            <td>{!! $Budget->STATUS_BUDGET !!}</td>
                            <td>{{ $Budget->STATUS_REALIZATION }}</td>
                            <td style="display:none;">{{ $Budget->ProposedTo }}</td>
                            <td style="display:none;">{{ $Budget->LAST_EDITED_BY }}</td>
                        </tr>
                    @endforeach
                    <input type="hidden" name="filter_broker_name" id="filter_broker_name">
                    <input type="hidden" name="filter_branch" id="filter_branch">
                    <input type="hidden" name="filter_status_pembayaran_premi" id="filter_status_pembayaran_premi">
                    <input type="hidden" name="filter_start_date" id="filter_start_date">
                    <input type="hidden" name="filter_no_polis" id="filter_no_polis">
                    <input type="hidden" name="filter_aging_rmf" id="filter_aging_rmf">
                    <input type="hidden" name="filter_nb_rn" id="filter_nb_rn">
                    <input type="hidden" name="filter_holder_name" id="filter_holder_name">
                    <input type="hidden" name="filter_status_realisasi" id="filter_status_realisasi">
                    <input type="hidden" name="filter_class" id="filter_class">
                    <input type="hidden" name="filter_status_budget" id="filter_status_budget">
                    <input type="hidden" name="filter_booking_date_from" id="filter_booking_date_from">
                    <input type="hidden" name="filter_booking_date_to" id="filter_booking_date_to">
                </tbody>
            </table>
        </div>
        <div class="mt-2 p-2">
            {{ $Budgets->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>

    <style>
        .td_comment, .td_occupation {
            cursor: pointer;
        }
    </style>

    <!-- Modal Reject-->
    @include('add-on.modal-reject')
    @include('add-on.modal-view-document-budget')

    @php
        // $toDoListVal =
        //     request()->has('to_do_list') && request()->get('to_do_list') != '' ? request()->get('to_do_list') : 'No';
        // dd($toDoListVal);
    @endphp
@endsection

@section('script')
    <script>
        var data_table_budget = '';
        $('body').on('click', '#RejectModal', function(e) {
            e.preventDefault();
            alert('ok');
            let Voucher = $(this).data('voucher');
            let Action = `${url}/budget/reject/${Voucher}`;
            let Filters = `{{ http_build_query(request()->query()) }}`;
            let AddHiddenInputForFilters = '';

            let FullUrl = `${Action}?${Filters}`;

            $('#form-reject-budget').attr('action', FullUrl);
            $('#ModalReject').modal('toggle');
        });

        $('body').on('click', '.td_comment', function() {
            let thisClass = $(this);
            let comment = thisClass.data('comment');
            swal({
                title: 'Full Comment',
                html: `<p style="font-size: 20px; word-spacing: 10px; padding: 15px; line-height: 1.6"><strong>${comment}</strong></p>`,
                icon: 'info',
                width: '800px'
            });
        });

        $('body').on('click', '.td_occupation', function() {
            let thisClass = $(this);
            let occupation = thisClass.data('occupation');
            swal({
                title: 'Full Occupation',
                html: `<p style="font-size: 20px; word-spacing: 10px; padding: 15px; line-height: 1.6"><strong>${occupation}</strong></p>`,
                icon: 'info',
                width: '800px'
            });
        });

        $('body').on('click', '#to_do_list', function() {
            if( $(this).is(':checked') ){
                $('#to_do_list_filter').val(true);
            }else{
                $('#to_do_list_filter').val(false);
            }

            console.log( $('#to_do_list_filter').val() );
        });

        $('body').on('click', '#btn_reset_filter', function(e) {
            e.preventDefault();
            $('#broker_name').val('');
            $('#start_date').val('');
            $('#booking_date_from').val('');
            $('#booking_date_to').val('');
            $('#no_policy').val('');
            $('#aging_rmf').val('');
            $('#holder_name').val('');
            $('#branch').val('').trigger('change');
            $('#nb_rn').val('').trigger('change');
            $('#class').val('').trigger('change');
            $('#status_pembayaran_premi').val('').trigger('change');
            $('#status_realisasi').val('').trigger('change');
            $('#status_budget').val('').trigger('change');

            $('#btn_apply_filter').trigger('click');
        });

        $(document).ready(function() {
            // Datepicker Start Date
            $('#start_date, #booking_date_from, #booking_date_to').datepicker({
                dateFormat: 'dd-M-yy',
                autoclose: true,
                todayHighlight: true,
                changeMonth: true,
                changeYear: true
            });
        });
    </script>
@endsection

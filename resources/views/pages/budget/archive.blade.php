@extends('layouts.app')
@section('title')
@endsection

@section('content')
    @if( session()->has('noticication') )
        <div class="alert alert-success text-center">
            {!! session()->get('noticication') !!}
        </div>
    @endif
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table  table-budget dataTable" style="overflow-x: auto;">
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
                            <td>{{ $Budget->OCCUPATION }}</td>
                            <td class="td_comment" data-comment="{{ $Budget->COMMENT }}">
                                @php
                                    $arrayOfWord = explode(' ', $Budget->COMMENT);
                                    $displayText = '';

                                    if (count($arrayOfWord) >= 15) {
                                        foreach ($arrayOfWord as $key => $val) {
                                            if ($key <= 10) {
                                                $displayText .= $val . ' ';
                                            }
                                        }
                                        $displayText = rtrim($displayText, ' ');
                                        $displayText .= '...';
                                    } else {
                                        $displayText = $Budget->COMMENT;
                                    }
                                @endphp
                                {{ $displayText }}
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
    </div>
    @include('add-on.modal-reject')
    @include('add-on.modal-view-document-budget')
@endsection

@section('script')
    <script>
        // Button View Document to show Document on Modal Bootstrap.
        $('body').on('click', '.btnViewDocumentBudget', function(e){
            e.preventDefault();

            // Path of Document file.
                let path = `${url}/${$(this).data('path')}`;

            // Append Path to <img src="" />
                $('#imgDocumentBudget').attr('src', path);

            // Show Bootstrap Modal
                $('#ViewDocumentBudgetModal').modal('show');
        });
    </script>
@endsection

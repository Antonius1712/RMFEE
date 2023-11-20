@extends('layouts.app')
@section('title')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 mb-2">
            {{-- <a class="btn btn-primary pull-left" style="border-radius: 100px; font-size: 18px;" aria-expanded="false" data-toggle="collapse" data-target="#FilterCollapse">
                <i class="feather icon-filter text-white"></i>
                <span class="text-white">Filter</span>
            </a> --}}

            <label>
                <input type="checkbox" name="to_do_list" id="to_do_list" class="to-do-list"
                    style="width: 30px; height: 30px; vertical-align: middle;">
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
        <div class="card-body row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="broker_name">Broker Name</label>
                    <input type="text" name="broker_name" id="broker_name" class="form-control radius"
                        placeholder="Type Here..">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="branch">Branch</label>
                    <select name="branch" id="branch" class="form-control radius">
                        <option value="">All</option>
                        @foreach ($branch as $val)
                            <option value="{{ $val->Branch }}">{{ $val->Branch }}</option>
                        @endforeach
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
                            <option value="{{ $val }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="col-lg-4">
                <div class="form-group">
                    <label for="start_date">Start Date</label>
                    <input type="text" name="start_date" id="start_date" class="form-control radius"
                        placeholder="Type Here..">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="no_policy">No Policy</label>
                    <input type="text" name="no_policy" id="no_policy" class="form-control radius"
                        placeholder="Type Here..">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="aging_rmf">Aging RMF</label>
                    <input type="text" name="aging_rmf" id="aging_rmf" class="form-control radius"
                        placeholder="Type Here..">
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="nb_rn">NB/RN</label>
                    <select name="nb_rn" id="nb_rn" class="form-control radius">
                        <option value="">All</option>
                        @foreach ($NBRN as $val)
                            <option value="{{ $val }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="holder_name">Holder Name</label>
                    <input type="text" name="holder_name" id="holder_name" class="form-control radius"
                        placeholder="Type Here..">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="status_realisasi">Status Realisasi</label>
                    {{-- <input type="text" name="status_realisasi" id="status_realisasi" class="form-control radius"
                        placeholder="Type Here.."> --}}
                    <select name="status_realisasi" id="status_realisasi" class="form-control radius">
                        <option value="">All</option>
                        @foreach ($statusRealisasi as $val)
                            <option value="{{ $val }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-lg-6">
                <button id="btn_reset_filter" class="btn btn-outline-primary waves-effect waves-light radius-100" style="width: 100%;">
                    Reset Filter
                </button>
            </div>
            <div class="col-lg-6">
                <button id="btn_apply_filter" class="btn btn-primary waves-effect waves-light radius-100" style="width: 100%;">
                    Apply Filter
                </button>
            </div>
        </div>
    </div>

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
                    
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Reject-->
    @include('add-on.modal-reject')
@endsection

@section('script')
    <script>
        var DataTableBudget = '';
        var ImageLoading = `<img style="width: 100%; height: auto; z-index: 1; position: relative; max-width: 100%; max-height: 100vh; margin: auto;" src="{{ asset('images/loader.gif') }}"/>`;
        $(document).ready(function() {
            $('#start_date').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
            });

            DataTableBudget = $('.dataTable').DataTable({
                processing: true, /* GIVE PROCESSING LOADING LABEL WHEN LOAD DATA. */
                language: {
                    processing: ImageLoading /* CHANGE TEXT PROCESSING.. TO IMAGE LOADING.. */
                },
                /* SERVERSIDE = TRUE => TO LOAD DATA PER CHUNK. ONLY ON FIRST LOAD AND PAGE CLICK. */
                /* IF THIS TRUE, COLUMN.SEARCH() WITH REGEX DOESN'T WORK. SET TO FALSE IF HAVE SEARCH WITH REGEX. */
                serverSide: false, 
                responsive: true,
                scrollX: true, /* PAGINATION STAY ON THE BOTTOM RIGHT. */
                search: {
                    caseInsensitive: true,
                    regex: true,
                },
                // searching : false, /* IF THIS Searching: false active, search by individual column below will not working. */
                lengthMenu: [
                    [ 10, 25, 50, -1 ],
                    [ '10 rows', '25 rows', '50 rows', 'Show All' ]
                ],
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'csvHtml5',
                        text: 'Export to CSV',
                        className: 'btn-primary btn-spacing',
                        exportOptions: {
                            modifier: {
                                search: 'none'
                            }
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Export to Excel',
                        className: 'btn-primary btn-spacing',
                        exportOptions: {
                            modifier: {
                                search: 'none'
                            }
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'Export to PDF',
                        className: 'btn-primary',
                        exportOptions: {
                            modifier: {
                                search: 'none'
                            }
                        }
                    }
                ],
                ajax: '{!! Route('budget.data-table') !!}',
                columns: [
                    { data: 'ACTION' },
                    { data: 'CLASS' },
                    { data: 'BROKERNAME' },
                    { data: 'TYPE' },
                    { data: 'BRANCH' },
                    { data: 'POLICYNO' },
                    { data: 'Holder_Name' },
                    { data: 'Start_Date' },
                    { data: 'End_Date' },
                    { data: 'CURRENCY' },
                    { data: 'LGI_PREMIUM' },
                    { data: 'PREMIUM' },
                    { data: 'ADMIN' },
                    { data: 'DISCOUNT' },
                    { data: 'OTHERINCOME' },
                    { data: 'PAYMENT' },
                    { data: 'PAYMENT_DATE' },
                    { data: 'OS' },
                    { data: 'Status_Premium' },
                    { data: 'VOUCHER' },
                    { data: 'OCCUPATION' },
                    { data: 'COMMENT' },
                    { data: 'CAEP' },
                    { data: 'Persentage' },
                    { data: 'AGING_REALIZATION' },
                    { data: 'Budget' },
                    { data: 'REALIZATION_RMF' },
                    { data: 'REALIZATION_SPONSORSHIP' },
                    { data: 'REMAIN_BUDGET' },
                    { data: 'STATUS_BUDGET' },
                    { data: 'STATUS_REALIZATION' },
                ]
            });

            setTimeout(() => {
                $('.buttons-csv').removeClass('btn-secondary');
                $('.buttons-excel').removeClass('btn-secondary');
                $('.buttons-pdf').removeClass('btn-secondary');
                $('#DataTables_Table_0_filter').children().remove(); /* Removing Search Input on Datatable */
                // $('#DataTables_Table_0_length').append('<label> <strong style="color: red; margin-left: 25px;"> *Please Show All if you want to export all data.</strong> </label>'); /* Uncomment this if serverSide = true. */
                $('#DataTables_Table_0_length').children().eq(0).css("font-size", "16px");
                $('#DataTables_Table_0_length').children().eq(0).children().css("font-size", "16px");
                $('#DataTables_Table_0_length').children().eq(1).css("font-size", "16px");
            }, 5);
        });

        $('#btn_apply_filter').click(function(){
            // Aging RMF = Aging Realization 24
            // Status Pembayaran Premi = Status Premium col 18

            SearchDataTable();
        });

        $('#btn_reset_filter').click(function(){
            $('#broker_name').val('');
            $('#branch').val('');
            $('#nb_rn').val('');
            $('#start_date').val('');
            $('#start_date').val('');
            $('#no_policy').val('');
            $('#holder_name').val('');
            $('#status_pembayaran_premi').val('');
            $('#aging_rmf').val('');
            $('#status_realisasi').val('');
            
            SearchDataTable();
        })

        function SearchDataTable(){
            let broker_name = $('#broker_name').val();
            let branch = $('#branch').val();
            let nb_rn = $('#nb_rn').val();
            // let start_date = moment($('#start_date').val()).format('YYYY-MM-DD HH:mm:ss');
            let start_date = moment($('#start_date').val()).format('YYYY-MM-DD');
            let no_policy = $('#no_policy').val();
            let holder_name = $('#holder_name').val();
            let status_pembayaran_premi = $('#status_pembayaran_premi').val();
            let aging_rmf = $('#aging_rmf').val();
            let status_realisasi = $('#status_realisasi').val();

            if( start_date == 'Invalid date' ){
                start_date = '';
            }

            DataTableBudget.column('#th_branch').search(branch).draw();
            DataTableBudget.column('#th_broker_name').search(broker_name).draw();
            DataTableBudget.column('#th_type').search(nb_rn).draw();
            DataTableBudget.column('#th_no_policy').search(no_policy).draw();
            DataTableBudget.column('#th_holder_name').search(holder_name).draw();
            DataTableBudget.column('#th_start_date').search(start_date).draw();
            DataTableBudget.column('#th_aging_realization').search(aging_rmf).draw();


            /* IF DATATABLE SERVER SIDE ABOVE = TRUE, THIS SEARCH WITH REGEX DOESN'T WORK.  */
            /* WITH REGEX */
            DataTableBudget.column('#th_status_premium').search(status_pembayaran_premi ? '^'+status_pembayaran_premi+'$' : '', true, false, false).draw();
            DataTableBudget.column('#th_status_realisasi').search(status_realisasi ? '^'+status_realisasi+'$' : '', true, false, false).draw();


            /* WITHOUT REGEX */
            // DataTableBudget.column('#th_status_premium').search(status_pembayaran_premi).draw();
            // DataTableBudget.column('#th_status_realisasi').search(status_realisasi).draw();
        }
    </script>
@endsection
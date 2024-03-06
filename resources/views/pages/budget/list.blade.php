@extends('layouts.app')
@section('title')
@endsection

@section('content')
{{-- {{ dd(session()->all()) }} --}}
    <div class="row">
        <div class="col-lg-6 mb-2">
            {{-- <a class="btn btn-primary pull-left" style="border-radius: 100px; font-size: 18px;" aria-expanded="false" data-toggle="collapse" data-target="#FilterCollapse">
                <i class="feather icon-filter text-white"></i>
                <span class="text-white">Filter</span>
            </a> --}}

            <label>
                <input type="checkbox" name="to_do_list" id="to_do_list" class="to-do-list"
                    style="width: 30px; height: 30px; vertical-align: middle;" value="" checked>
                <b style="font-size: 20px; vertical-align: middle;" class="ml-1">To do List</b>
                <input type="hidden" id="to_do_list_check_proposed_to" name="to_do_list_check_proposed_to" value=""/>
                <input type="hidden" id="to_do_list_check_last_edited_by" name="to_do_list_check_last_edited_by" value=""/>
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
                    <input type="text" name="broker_name" id="broker_name" class="form-control radius" value="{{ session()->get('broker_name') }}"
                        placeholder="Type Here..">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="branch">Branch</label>
                    <select name="branch" id="branch" class="form-control radius">
                        <option value="">All</option>
                        @foreach ($branch as $val)
                            <option {{ session()->get('branch') == $val->Branch ? 'selected' : '' }} value="{{ $val->Branch }}">{{ $val->Branch }}</option>
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
                            <option {{ session()->get('status_pembayaran_premi') == $val ? 'selected' : '' }} value="{{ $val }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="col-lg-4">
                <div class="form-group">
                    <label for="start_date">Start Date</label>
                    <input type="text" name="start_date" id="start_date" class="form-control radius" value="{{ session()->get('start_date') }}"
                        placeholder="Type Here..">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="no_policy">No Policy</label>
                    <input type="text" name="no_policy" id="no_policy" class="form-control radius" value="{{ session()->get('no_policy') }}"
                        placeholder="Type Here..">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="aging_rmf">Aging RMF</label>
                    <input type="text" name="aging_rmf" id="aging_rmf" class="form-control radius" value="{{ session()->get('aging_rmf') }}"
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
                            <option {{ session()->get('nb_rn') == $val ? 'selected' : '' }} value="{{ $val }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="holder_name">Holder Name</label>
                    <input type="text" name="holder_name" id="holder_name" class="form-control radius" value="{{ session()->get('holder_name') }}"
                        placeholder="Type Here..">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="status_realisasi">Status Realisasi</label>
                    <select name="status_realisasi" id="status_realisasi" class="form-control radius">
                        <option value="">All</option>
                        @foreach ($statusRealisasi as $val)
                            <option {{ session()->get('status_realisasi') == $val ? 'selected' : '' }} value="{{ $val }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="ClassBusiness">Class</label>
                    <select name="ClassBusiness" id="ClassBusiness" class="form-control radius">
                        <option value="">All</option>
                        <option {{ session()->get('ClassBusiness') == '02-MOTOR VEHICLE' ? 'selected' : '' }} value="02-MOTOR VEHICLE">02-MOTOR VEHICLE</option>
                        <option {{ session()->get('ClassBusiness') == '01-PROPERTY' ? 'selected' : '' }} value="01-PROPERTY">01-PROPERTY</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="status_budget">Status Budget</label>
                    <select name="status_budget" id="status_budget" class="form-control radius">
                        <option value="">All</option>
                        @foreach ($statusBudget as $val)
                            <option {{ session()->get('status_budget') == $val ? 'selected' : '' }} value="{{ $val }}">{{ $val }}</option>
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

    @if( session()->has('noticication') )
    <div class="alert alert-success text-center">
        {!! session()->get('noticication') !!}
    </div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table  table-budget dataTable" style="overflow-x: auto; overflow-y: none; height:">
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
                        <th id="th_proposed_to" style="display:none;">PROPOSED TO</th>
                        <th id="th_last_edited_by" style="display:none;">LAST EDITED BY</th>
                    </tr>
                </thead>
                <tbody>
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
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Reject-->
    @include('add-on.modal-reject')
    @include('add-on.modal-view-document-budget')
@endsection

@section('script')
    <script>
        $('body').on('click', '#RejectModal', function(e){
            e.preventDefault();
            let Voucher = $(this).data('voucher');
            let Action = `${url}/budget/reject/${Voucher}`;
            let Filters = AssignValueFilter(true);
            let AddHiddenInputForFilters = '';

            $.each(Filters, function(key, val){
                AddHiddenInputForFilters += `
                    <input type="hidden" name="${key}" value="${val}" />
                `;
            });

            $('#form-reject-budget').attr('action', Action);
            $('#append').html(AddHiddenInputForFilters);
            $('#ModalReject').modal('toggle');
        });
        // Define Variable of Auth User NIK, Group Code, Datatable of Budget.
            var DataTableBudget = '';

        // Document Ready
        $(document).ready(function() {
            // Datepicker Start Date
            $('#start_date').datepicker({
                dateFormat: 'dd-M-yy',
                // format: 'd-M-Y',
                autoclose: true,
                todayHighlight: true,
            });

            // Datatable Budget
            DataTableBudget = $('.dataTable').DataTable({
                processing: true, /* GIVE PROCESSING LOADING LABEL WHEN LOAD DATA. */
                language: { /* TO MODIFY PROCESSING WHEN LOAD DATA. */
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
                statesave: true,
                stateLoadParams: function(settings, data){
                    console.log('stateLoadParams : ',data);
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
                    }
                    // {
                    //     extend: 'excelHtml5',
                    //     text: 'Export to Excel',
                    //     className: 'btn-primary btn-spacing',
                    //     exportOptions: {
                    //         modifier: {
                    //             search: 'none'
                    //         }
                    //     }
                    // },
                    // {
                    //     extend: 'pdfHtml5',
                    //     text: 'Export to PDF',
                    //     className: 'btn-primary',
                    //     exportOptions: {
                    //         modifier: {
                    //             search: 'none'
                    //         }
                    //     }
                    // }
                ],
                // select: {
                //     style: 'multi' /* To Select rows. */
                // },
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
                    { data: 'ProposedTo', searchable: true, visible: false },
                    { data: 'LAST_EDITED_BY', searchable: true, visible: false }
                ],
            }).on('select', function(e, dt, node, config){
                let selectedData = dt.rows('.selected').data();
            });

            // This function runs after 0.05 seconds.
            setTimeout(() => {
                // Remove Class Secondary to change colors.
                $('.buttons-csv').removeClass('btn-secondary');
                $('.buttons-excel').removeClass('btn-secondary');
                $('.buttons-pdf').removeClass('btn-secondary');
                
                // Remove Search Input on Datatable, we use custom search to filter.
                $('#DataTables_Table_0_filter').children().remove(); /* Removing Search Input on Datatable */

                // Showing label for Server Side Datatable. if commented => ServerSide = false. if uncommented ServerSide = true.
                // $('#DataTables_Table_0_length').append('<label> <strong style="color: red; margin-left: 25px;"> *Please Show All if you want to export all data.</strong> </label>'); /* Uncomment this if serverSide = true. */

                // Change font size of Show <10, 25, 50, Show All> Entries
                $('#DataTables_Table_0_length').children().eq(0).css("font-size", "16px");
                $('#DataTables_Table_0_length').children().eq(0).children().css("font-size", "16px");
                $('#DataTables_Table_0_length').children().eq(1).css("font-size", "16px");

                // Check ToDoList to filter data after Datatable loaded.
                if( $('#to_do_list').is(':checked') && AuthUserGroup != 'USER_RMFEE' ){
                    $('#to_do_list_check_proposed_to').val(AuthUser);
                }else if( $('#to_do_list').is(':checked') && AuthUserGroup == 'USER_RMFEE' ){
                    $('#to_do_list_check_last_edited_by').val(AuthUser);
                    // $('#status_budget').val('NEW');
                }else{
                    $('#to_do_list_check_proposed_to').val('');
                    $('#to_do_list_check_last_edited_by').val('');
                }
                
                // Run Search Datatable.
                SearchDataTable();
                $('body').find('#btn_apply_filter').trigger('click');
            }, 5);
        });

        // // Show Loader when exports.
        // $('body').on('click', '.buttons-csv', function(){
        //     $('#loading').show();
        // });

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

        // Button to Apply Filter on Datatable.
        $('#btn_apply_filter').click(function(){
            let returned = AssignValueFilter();
            SearchDataTable();
            setTimeout(() => {
                AddQueryUrlParameterToButtons(returned);
            }, 500);
        });

        // Checkbox to Apply Specific filters.
        $('#to_do_list').click(function(){
            if( $(this).is(':checked') && AuthUserGroup != 'USER_RMFEE' ){
                $('#to_do_list_check_proposed_to').val(AuthUser);
            }else if( $(this).is(':checked') && AuthUserGroup == 'USER_RMFEE' ){
                $('#to_do_list_check_last_edited_by').val(AuthUser);
                // $('#th_status_budget').val('NEW');
            }else{
                $('#to_do_list_check_proposed_to').val('');
                $('#to_do_list_check_last_edited_by').val('');
            }
            SearchDataTable();
        });

        // Button to Reset Filter on Datatable.
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
            $('#status_budget').val('');
            $('#to_do_list_check_proposed_to').val('');
            
            SearchDataTable();
        });

        // Function Search / Filter Datatable.
        function SearchDataTable(){
            let broker_name = $('#broker_name').val();
            let branch = $('#branch').val();
            let nb_rn = $('#nb_rn').val();
            let start_date = moment($('#start_date').val(), 'DD-MMM-YYYY').format('DD-MMM-YYYY'); // contoh: 01-jan-2024
            let no_policy = $('#no_policy').val();
            let holder_name = $('#holder_name').val();
            let status_pembayaran_premi = $('#status_pembayaran_premi').val();
            let aging_rmf = $('#aging_rmf').val();
            let status_realisasi = $('#status_realisasi').val();
            let status_budget = $('#status_budget').val();
            let to_do_list_check_proposed_to = $('#to_do_list_check_proposed_to').val();     
            let to_do_list_check_last_edited_by = $('#to_do_list_check_last_edited_by').val();     
            let ClassBusiness = $('#ClassBusiness').val();

            if( start_date == 'Invalid date' ){
                start_date = '';
            }

            DataTableBudget.column('#th_branch').search(branch).draw();
            DataTableBudget.column('#th_broker_name').search(broker_name).draw();
            DataTableBudget.column('#th_type').search(nb_rn).draw();
            DataTableBudget.column('#th_policy_number').search(no_policy).draw();
            DataTableBudget.column('#th_holder_name').search(holder_name).draw();
            DataTableBudget.column('#th_start_date').search(start_date).draw();
            DataTableBudget.column('#th_aging_realization').search(aging_rmf).draw();
            DataTableBudget.column('#th_status_budget').search(status_budget).draw();
            DataTableBudget.column('#th_proposed_to').search(to_do_list_check_proposed_to).draw();
            DataTableBudget.column('#th_last_edited_by').search(to_do_list_check_last_edited_by).draw();
            DataTableBudget.column('#th_class').search(ClassBusiness).draw();

            /* IF DATATABLE SERVER SIDE ABOVE = TRUE, THIS SEARCH WITH REGEX DOESN'T WORK.  */
            /* WITH REGEX */
            DataTableBudget.column('#th_status_premium').search(status_pembayaran_premi ? '^'+status_pembayaran_premi+'$' : '', true, false, false).draw();
            DataTableBudget.column('#th_status_realisasi').search(status_realisasi ? '^'+status_realisasi+'$' : '', true, false, false).draw();

            /* WITHOUT REGEX */
            // DataTableBudget.column('#th_status_premium').search(status_pembayaran_premi).draw();
            // DataTableBudget.column('#th_status_realisasi').search(status_realisasi).draw();
        }

        function AssignValueFilter(isReturnObject = false){
            // alert('assignValue');
            var obj_filter = {}; /* HARUS OBJECT {} BUKAN ARRAY [], KALAU ARRAY KEY BUKAN [0,1,2,..] TETAPI STRING SEPERTI DIBAWAH, JIKA MENGGUNAKAN ARRAY MAKA TIDAK BISA $.EACH LOOP.  */
            var filter = '';
            var broker_name = $('#broker_name').val();
            var branch = $('#branch').val();
            var status_pembayaran_premi = $('#status_pembayaran_premi').val();
            var start_date = $('#start_date').val();
            var no_policy = $('#no_policy').val();
            var aging_rmf = $('#aging_rmf').val();
            var nb_rn = $('#nb_rn').val();
            var holder_name = $('#holder_name').val();
            var status_realisasi = $('#status_realisasi').val();
            var ClassBusiness = $('#ClassBusiness').val();
            var status_budget = $('#status_budget').val();

            obj_filter['broker_name'] = broker_name;
            obj_filter['branch'] = branch;
            obj_filter['status_pembayaran_premi'] = status_pembayaran_premi;
            obj_filter['start_date'] = start_date;
            obj_filter['no_policy'] = no_policy;
            obj_filter['aging_rmf'] = aging_rmf;
            obj_filter['nb_rn'] = nb_rn;
            obj_filter['holder_name'] = holder_name;
            obj_filter['status_realisasi'] = status_realisasi;
            obj_filter['ClassBusiness'] = ClassBusiness;
            obj_filter['status_budget'] = status_budget;

            /* CONVERT OBJECT TO QUERY URL PARAMETERS. */
            $.each(obj_filter, function(key, val){
                if( val != '' ){
                    filter += `${key}=${val}&`;
                }
            });

            /* REMOVE LAST CHARACTER FROM QUERY URL PARAMETERS. (&) */
            filter = filter.substring(0, filter.length - 1);

            if( isReturnObject ){
                return obj_filter;
            }

            return filter;
        }

        function AddQueryUrlParameterToButtons(filters){
            /* ?Approve */
            let hrefApprove = $('body').find('.approve').attr('href'); /*Get Href Value*/
            if( typeof hrefApprove !== 'undefined' ){
                hrefApprove = hrefApprove.split('?')[0]; /*Remove Query Parameter from url.*/
            }
            hrefApprove = `${hrefApprove}?${filters}`;
            $('body').find('.approve').attr('href', hrefApprove); /*Assign new url with Query Parameter*/
            

            /* ?Undo Approve */
            let hrefUndoApprove = $('body').find('.undo_approve').attr('href'); /*Get Href Value*/
            if( typeof hrefUndoApprove !== 'undefined' ){
                hrefUndoApprove = hrefUndoApprove.split('?')[0]; /*Remove Query Parameter from url.*/
            }
            hrefUndoApprove = `${hrefUndoApprove}?${filters}`;
            $('body').find('.undo_approve').attr('href', hrefUndoApprove); /*Assign new url with Query Parameter*/

            
            // /* ?Reject on different function. */
            // let hrefReject = $('body').find('#form-reject-budget').attr('action'); /*Get Href Value*/
            // if( typeof hrefReject !== 'undefined' ){
            //     hrefReject = hrefReject.split('?')[0]; /*Remove Query Parameter from url.*/
            // }
            // hrefReject = `${hrefReject}?${filters}`;

            // console.log(hrefReject, filters, );

            // $('body').find('#form-reject-budget').attr('action', hrefReject); /*Assign new url with Query Parameter*/

        }
    </script>
@endsection
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
    @include('add-on.modal-reject')
    @include('add-on.modal-view-document-budget')
@endsection

@section('script')
    <script>
        // Define Variable Datatable Budget.
        var DataTableBudget = '';

        // Document Ready
        $(document).ready(function() {
            // Datatable Budget
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
                    // select: {
                    //     style: 'multi'
                    // },
                    ajax: {
                        url: '{!! Route('budget.data-table') !!}',
                        type: 'get',
                        data: {
                            type: `{{ $BudgetStatus }}`
                        }
                    },
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
                        if( $('#to_do_list').is(':checked') && UserGroup != 'USER_RMFEE' ){
                            $('#to_do_list_check_proposed_to').val(AuthUser);
                        }else if( $('#to_do_list').is(':checked') && UserGroup == 'USER_RMFEE' ){
                            $('#to_do_list_check_last_edited_by').val(AuthUser);
                            // $('#status_budget').val('NEW');
                        }else{
                            $('#to_do_list_check_proposed_to').val('');
                            $('#to_do_list_check_last_edited_by').val('');
                        }
                    
                    // Run Search Datatable.
                        SearchDataTable();
                }, 5);
        });

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

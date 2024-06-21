@extends('layouts.app')
@section('content')
    <style>
        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
            /* add padding to account for vertical scrollbar */
            padding-right: 20px;
        }

        /* Adjust the position of the loading indicator */
        .autocomplete-loading {
            position: absolute;
            display: none;
        }

        .position-relative {
            position: relative;
        }

        .position-absolute {
            position: absolute;
        }

        .top-50 {
            top: 30%;
            right: 90%;
        }

        .start-100 {
            start: 100%;
        }
    </style>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h1>Report</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @include('layouts.alert')
                        </div>
                        <div class="col-lg-12">
                            {{-- Code removed as per instructions to handle loading animation post Excel generation in ReportBudgetController.php --}}
                            <form action="{{ route('report.os.generate') }}" method="post">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">As At</label>
                                            <input type="text" value="" name="updated_at"
                                                class="form-control datepicker" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">UW Year Start</label>
                                            <select name="underwriting_year_start" id="underwriting_year_start" class="form-control">
                                                @if (isset($years))
                                                    @foreach ($years as $year)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">UW Year End</label>
                                            <select name="underwriting_year_end" id="underwriting_year_end" class="form-control">
                                                @if (isset($years))
                                                    @foreach ($years as $year)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Broker Name</label>
                                            <input type="text" name="broker_name" id="broker_name" class="form-control">
                                            <div class="autocomplete-loading spinner-border text-primary position-absolute top-50 start-100"
                                                role="status">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" name="btn-generate-os-report"
                                            class="btn btn-primary">Generate OS Report</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            changeYear: true,
            changeMonth: true,
        });

        //? To give function delay. so it can't always being triggered.
        function debounce(func, wait) {
            let timeout;
            return function() {
                const context = this,
                    args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), wait);
            };
        }

        $('#broker_name').autocomplete({
            source: debounce(function(req, res) {
                $.ajax({
                    url: search_profile_on_report_os,
                    data: {
                        keywords: req.term,
                    },
                    beforeSend: function() {
                        $('.autocomplete-loading').css('display', 'block'); // Show the spinner
                    },
                    success: function(data) {
                        $('.autocomplete-loading').css('display', 'none'); // Hide the spinner
                        res($.map(data, function(item) {
                            return {
                                label: `${item.ID} - ${item.Name}`,
                                value: item.Name
                            };
                        }));
                    },
                });
            }, 300), //? Waitint 0.3 seconds.
            minLength: 3,
            select: function(event, ui) {
                let broker_name = ui.item.label.split(' - ')[1];
                $('#broker_name').val(broker_name);
            }
        });
    </script>
@endsection

@extends('layouts.app')
@section('content')
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
                            <form action="{{ route('report.budget.generate') }}" method="post">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Start Booking Date</label>
                                            <input type="text" value="" name="start_date" class="form-control datepicker">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">End Booking Date</label>
                                            <input type="text" value="" name="end_date" class="form-control datepicker">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Status Budget</label>
                                            <select name="status_budget" id="status_budget" class="form-control">
                                                <option value="">All</option>
                                                @foreach ($StatusBudget as $key => $val)
                                                    <option value="{{ $val }}">{{ $val }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" name="btn-generate-summary-budget" class="btn btn-primary">Generate Summary</button>
                                        <button type="submit" name="btn-generate-detail-budget" class="btn btn-primary">Generate Detail</button>
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
    </script>
@endsection

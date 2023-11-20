@extends('layouts.app')
@section('title')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            {{-- <form action="{{ route('realization.store') }}" method="post"> --}}
            <form action="javscript:;" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="class_of_bussiness" class="col-lg-3 col-form-label-lg">Class</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="class_of_bussiness" id="class_of_bussiness"
                                        class="form-control col-lg-8" placeholder="Class">
                                </div>
                                <div class="form-group row">
                                    <label for="source_of_business" class="col-lg-3 col-form-label-lg">SOB</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="source_of_business" id="source_of_business"
                                        class="form-control col-lg-8" placeholder="SOB">
                                </div>
                                <div class="form-group row">
                                    <label for="broker_name" class="col-lg-3 col-form-label-lg">Broker Name</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="broker_name" id="broker_name" class="form-control col-lg-8"
                                        placeholder="Broker Name">
                                </div>
                                <div class="form-group row">
                                    <label for="policy_no" class="col-lg-3 col-form-label-lg">Policy Number</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="policy_no" id="policy_no" class="form-control col-lg-8"
                                        placeholder="No Policy">
                                </div>
                                <div class="form-group row">
                                    <label for="start_date" class="col-lg-3 col-form-label-lg">Start Date</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="start_date" id="start_date" class="form-control col-lg-8"
                                        placeholder="Start Date">
                                </div>
                                <div class="form-group row">
                                    <label for="end_date" class="col-lg-3 col-form-label-lg">End Date</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="end_date" id="end_date" class="form-control col-lg-8"
                                        placeholder="End Date">
                                </div>
                                <div class="form-group row">
                                    <label for="occupation_code" class="col-lg-3 col-form-label-lg">Occupation
                                        Code</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="occupation_code" id="occupation_code"
                                        class="form-control col-lg-8" placeholder="Occupation Code">
                                </div>
                                <div class="form-group row">
                                    <label for="occupation_description" class="col-lg-3 col-form-label-lg">Occupation
                                        Description</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="occupation_description" id="occupation_description"
                                        class="form-control col-lg-8" placeholder="Occupation Description">
                                </div>
                                <div class="form-group row">
                                    <label for="source_of_business" class="col-lg-3 col-form-label-lg">SOB</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="source_of_business" id="source_of_business"
                                        class="form-control col-lg-8" placeholder="SOB">
                                </div>
                                <div class="form-group row">
                                    <label for="currency" class="col-lg-3 col-form-label-lg">Currency</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="currency" id="currency" class="form-control col-lg-8"
                                        placeholder="Currency">
                                </div>
                                <div class="form-group row">
                                    <label for="gross_premi" class="col-lg-3 col-form-label-lg">Gross Premi</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="gross_premi" id="gross_premi"
                                        class="form-control col-lg-8" placeholder="Gross Premi">
                                </div>
                                <div class="form-group row">
                                    <label for="status_premi" class="col-lg-3 col-form-label-lg">Status
                                        Premi</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="status_premi" id="status_premi"
                                        class="form-control col-lg-8" placeholder="Status Premi">
                                </div>
                                <div class="form-group row">
                                    <label for="os_premi" class="col-lg-3 col-form-label-lg">OS Premi</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="os_premi" id="os_premi" class="form-control col-lg-8"
                                        placeholder="OS Premi">
                                </div>
                                <div class="form-group row">
                                    <label for="date_of_premium_paid" class="col-lg-3 col-form-label-lg">Date of Premium
                                        Paid</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="date_of_premium_paid" id="date_of_premium_paid"
                                        class="form-control col-lg-8" placeholder="Date of Premium Paid">
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
                                        placeholder="Budget(%)">
                                </div>
                                <div class="form-group row">
                                    <label for="budget_in_amount" class="col-lg-3 col-form-label-lg">Budget in
                                        Amount</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="budget_in_amount" id="budget_in_amount"
                                        class="form-control col-lg-8" placeholder="Budget in Amount">
                                </div>
                                <div class="form-group row">
                                    <label for="document" class="col-lg-3 col-form-label-lg">Document</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="document" id="document" class="form-control col-lg-8"
                                        placeholder="Document">
                                </div>
                                <div class="form-group row">
                                    <label for="proposed_to" class="col-lg-3 col-form-label-lg">Proposed to</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="proposed_to" id="proposed_to"
                                        class="form-control col-lg-8" placeholder="Proposed to">
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <button type="submit" style="width: 100%; height: 60px;"
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
                                        <button type="submit" style="width: 100%; height: 60px;"
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
                        <th>Time</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <td>TEST DS</td>
                        <td>Proposed</td>
                        <td>2023-11-13</td>
                        <td>Propose Data</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
@endsection

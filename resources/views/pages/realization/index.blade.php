@extends('layouts.app')
@section('title')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-2">
            <a href="{{ route('realization.create') }}" class="btn btn-primary pull-right"
                style="border-radius: 100px; font-size: 18px;">
                <i class="feather icon-file-plus text-white"></i>
                <span class="text-white">Add Realization</span>
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-responsive table-realization dataTable">
                <thead>
                    <tr class="default">
                        <th>Action</th>
                        <th>Invoice No</th>
                        <th>Type</th>
                        <th>Invoice Date</th>
                        <th>Payment To</th>
                        <th>Upload To</th>
                        <th>Broker</th>
                        <th>Currency</th>
                        <th>Total Realization</th>
                        <th>No EPO</th>
                        <th>Status EPO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="white">
                        <td>
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <div class="btn-group" role="group">
                                    <a href="#" id="BtnActionGroup" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" style="">
                                        <i class="feather icon-plus-circle icon-btn-group"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="BtnActionGroup">
                                        <a class="dropdown-item success" href="#">
                                            <i class="feather icon-edit-2"></i>
                                            Edit
                                        </a>
                                        <a class="dropdown-item success" href="#">
                                            <i class="feather icon-plus"></i>
                                            Add Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>Invoice No</td>
                        <td>Type</td>
                        <td>Invoice Date</td>
                        <td>Payment To</td>
                        <td>Upload To</td>
                        <td>Broker</td>
                        <td>Currency</td>
                        <td>Total Realization</td>
                        <td>No EPO</td>
                        <td>
                            <span class="badge badge-pill badge-blue badge-status-realization">
                                WAITING
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
@endsection

@extends('layouts.app')
@section('title')
    
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-compact">
                <thead>
                    <tr class="default">
                        <th>Action</th>
                        <th>Class</th>
                        <th>SOB</th>
                        <th>Broker Name</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="white">
                        <td>
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <div class="btn-group" role="group">
                                    <a href="#" id="BtnActionGroup" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="">
                                        <i class="feather icon-plus-circle" style="font-size: 32px;"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="BtnActionGroup">
                                        <a class="dropdown-item success" href="#">
                                            <i class="feather icon-check-circle"></i>
                                            Approve
                                        </a>
                                        <a class="dropdown-item success" href="#">
                                            <i class="feather icon-delete"></i>
                                            Undro Approval
                                        </a>
                                        <a class="dropdown-item success" href="#">
                                            <i class="feather icon-edit-2"></i>
                                            Edit
                                        </a>
                                        <a class="dropdown-item success" href="#">
                                            <i class="feather icon-eye"></i>
                                            View Document
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item danger" href="#">
                                            <i class="feather icon-x-circle"></i>
                                            Reject
                                        </a>
                                        <a class="dropdown-item danger" href="#">
                                            <i class="feather icon-archive"></i>
                                            Archive
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    
@endsection
@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <a href="{{ Route('setting.user.create') }}" class="btn btn-primary pull-right">
                <i class="feather icon-plus"></i>
                Tambah
            </a>
        </div>
        <div class="col-12 mt-2">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="default">
                                <th>Action</th>
                                <th>NIK</th>
                                <th>Name</th>
                                <th>Type of Payment</th>
                                <th>NIK Approval BU</th>
                                <th>NIK Approval Finance</th>
                                <th>User EPO</th>
                                <th>Checker EPO</th>
                                <th>Approval EPO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($UserSettings as $val)
                                <tr>
                                    <td>
                                        <a href="{{ route('setting.user.edit', $val->UserID) }}">
                                            <i class="feather icon-edit"></i>
                                        </a>    
                                    </td>
                                    <td>{{ $val->UserID }}</td>
                                    <td>{{ $val->UserName }}</td>
                                    <td>{{ $val->Type_Of_Payment }}</td>
                                    <td>{{ $val->Approval_BU_UserID }}</td>
                                    <td>{{ $val->Approval_Finance_UserID }}</td>
                                    <td>{{ $val->UserID_ePO }}</td>
                                    <td>{{ $val->CheckerID_ePO }}</td>
                                    <td>{{ $val->ApprovalID_ePO }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
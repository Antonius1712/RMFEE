@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <a href="{{ Route('setting.budget-group.create') }}" class="btn btn-primary pull-right">
                <i class="feather icon-plus"></i>
                Tambah
            </a>
        </div>

        <div class="col-12">
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger text-center">
                    *{!! $error !!}
                </div>
            @endforeach

            @if( session()->has('noticication') )
            <div class="alert alert-success text-center">
                {!! session()->get('noticication') !!}
            </div>
            @endif
        </div>
        
        <div class="col-12 mt-2">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="default">
                                <th>Action</th>
                                <th>Group ID</th>
                                <th>Name</th>
                                <th>COB</th>
                                <th>Occupation</th>
                                <th>Percentage</th>
                                <th>Create Date</th>
                                <th>Create By</th>
                                <th>Last Update</th>
                                <th>Last Update By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($BudgetGroupData as $val)
                                <tr>
                                    <td>
                                        <a href="{{ route('setting.budget-group.edit', $val->GroupID) }}">
                                            <i class="feather icon-edit"></i>
                                        </a>    
                                    </td>
                                    <td>{{ $val->GroupID }}</td>
                                    <td>{{ $val->ID }}</td>
                                    <td>{{ $val->COB }}</td>
                                    <td>{{ $val->OccupationCode }}</td>
                                    <td>{{ $val->Persentage }}</td>
                                    <td>{{ $val->Create_Date }}</td>
                                    <td>{{ $val->Create_Date_By }}</td>
                                    <td>{{ $val->Last_Update }}</td>
                                    <td>{{ $val->Last_Update_By }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')
@section('title')
    
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-2">
            <a href="{{ route('realization.create') }}" class="btn btn-primary pull-right" style="border-radius: 100px; font-size: 18px;">
                <i class="feather icon-file-plus text-white"></i>
                <span class="text-white">Add Realization</span>
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-compact" style="border-radius: 100px;">
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
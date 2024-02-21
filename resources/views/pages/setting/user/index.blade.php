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
                                        <a href="{{ route('setting.user.edit', $val->UserID) }}" class="btn btn-primary btn-sm mb-2">
                                            <i class="feather icon-edit-2"></i>
                                        </a>  
                                        <form action="{{ route('setting.user.delete', $val->UserID) }}" method="post" class="form-delete-setting-user">
                                            {{ csrf_field() }}
                                            {{-- <a id="btn-delete" href="{{ route('setting.user.delete', $val->UserID) }}">
                                                <i class="feather icon-trash"></i>
                                            </a> --}}
                                            <button type="submit" id="btn-delete" class="btn btn-danger btn-sm">
                                                <i class="feather icon-trash-2"></i>    
                                            </button>    
                                        </form>    
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
@section('script')
<script>
    $('body').on('click', '#btn-delete', function(e) {
        e.preventDefault();
        let thisForm = $(this).parent();
        // console.log(thisForm);
        swal({
            title: 'Are you sure?',
            text: 'You will not be able to recover this data',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, I am sure!',
            cancelButtonText: "No, cancel it!",
        }).then(function(isConfirm){
            if( isConfirm.value == true ){
                thisForm.submit();
            }
        });
    });
</script>
@endsection
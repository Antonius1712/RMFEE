@extends('layouts.app')
@section('content')
    <div class="row">
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
            <div class="card">
                <div class="card-body">
                    <h1 class="">
                        User Setting
                    </h1>
                    <span class="text-sm">Please input data correctly.</span>
                    
                    <form action="{{ Route('setting.user.store') }}" method="post" class="mt-4">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <select name="nik" id="nik" class="form-control">
                                <option value="">Select User</option>
                                @foreach ($userList as $val)
                                    <option data-name="{{ $val->Name }}" value="{{ $val->NIK }}">{{ $val->NIK." - ".$val->Name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" readonly/>
                        </div>
                        <div class="form-group">
                            <label for="type_of_payment">Type of Payment</label>
                            <select name="type_of_payment" id="type_of_payment" class="form-control">
                                <option value="">Select Type of Payment</option>
                                @foreach ($typeOfPaymentList as $val)
                                    <option data-name="{{ $val }}" value="{{ $val }}">{{ $val }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="approval_bu">Approval BU</label>
                            <select name="approval_bu" id="approval_bu" class="form-control">
                                <option value="">Select Approval BU</option>
                                @foreach ($approvalListBu as $val)
                                    <option data-name="{{ $val->Name }}" value="{{ $val->NIK }}">{{ $val->NIK." - ".$val->Name."- ".$val->getUserGroup->getGroup->GroupName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="approval_finance">Approval Finance</label>
                            <select name="approval_finance" id="approval_finance" class="form-control">
                                <option value="">Select Approval Finance</option>
                                @foreach ($approvalListFinance as $val)
                                    <option data-name="{{ $val->Name }}" value="{{ $val->NIK }}">{{ $val->NIK." - ".$val->Name."- ".$val->getUserGroup->getGroup->GroupName }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{--! UNTUK EPO --}}
                        <div class="form-group">
                            <label for="user_id_epo">User EPO</label>
                            <input type="text" name="user_id_epo" id="user_id_epo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="checker_id_epo">Checker EPO</label>
                            <input type="text" name="checker_id_epo" id="checker_id_epo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="approval_id_epo">Approval EPO</label>
                            <input type="text" name="approval_id_epo" id="approval_id_epo" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary full-width">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('#nik').on('change', function(){
            let Name = $('option:selected', this).data('name');
            $('#name').val(Name);
        });
    </script>
@endsection
@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('special-menu.user') }}" method="post">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header">
                        Search
                    </div>
                    <div class="card-body row">
                        <div class="col-lg-8">
                            <input type="text" name="search_user" id="search_user" class="form-control" value="{{ isset($search_user) ? $search_user : '' }}">
                        </div>
                        <div class="col-lg-2">
                            <button name="btn_search" value="btn_search" type="submit" class="btn btn-primary w-100">
                                Search
                            </button>
                        </div>
                        <div class="col-lg-2">
                            <button name="btn_clear" value="btn_clear" type="submit" class="btn btn-primary w-100">
                                Clear
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-12 bg-white">
            <table class="table table-responsive table-realization dataTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Nik</th>
                        <th>Dept</th>
                        <th>Branch</th>
                        <th>Group Code</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->Name }}</td>
                            <td id="copy-nik" data-password="{{ $user->NIK }}">{{ $user->NIK }}</td>
                            <td>{{ $user->getDept->DeptCode }} - {{ $user->getDept->DeptName }}</td>
                            <td>{{ $user->getBranch->BranchCode }} - {{ $user->getBranch->BranchName }}</td>
                            <td>{{ $user->getUserGroup->GroupCode }}</td>
                            <td style="word-wrap: break-word;">
                                <div>
                                    <button id="copy-password-lgi-global" data-password="{{ $user->Password }}" class="btn btn-primary">
                                        Copy LgiGlobal Password
                                    </button>
                                    {{-- <br><br>
                                    <button id="copy-password-issurance" data-password="{{ isset($user->getIssuranceData) ? $user->getIssuranceData->Password : '' }}" class="btn btn-primary">
                                        Copy Issurance Password
                                    </button>
                                    <br><br>
                                    <button id="copy-otp-issurance" data-password="" data-email="{{ isset($user->getIssuranceData) ? $user->getIssuranceData->Email : '' }}" class="btn btn-primary">
                                        Copy Issurance OTP
                                    </button> --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
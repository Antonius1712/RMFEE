@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 mb-2">
            <a href="{{ route('documents.create') }}" class="btn btn-primary pull-right"
                style="border-radius: 100px; font-size: 18px;">
                <i class="feather icon-file-plus text-white"></i>
                <span class="text-white">Add Document</span>
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <form action="{{ route('documents.index') }}" method="get">
                    <select name="year" id="year" class="form-control" onchange="this.form.submit()">
                        <option value="">Select Year</option>
                        @foreach ($years as $year)
                            <option {{ isset(request()->query()['year']) && request()->query()['year'] == $year ? 'selected' : '' }} value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </div>

    <style>
        .hide {
            display: none;
        }
    </style>

    <div class="card {{ isset(request()->query()['year']) && request()->query()['year'] ? '' : 'hide' }}">
        <div class="card-body">
            <table class="table table-responsive table-realization dataTable"
                style="overflow-x: auto; overflow-y: none; height: 650px;">
                <thead>
                    <tr class="default">
                        <th>Document Name</th>
                        <th>Document Description</th>
                        <th>Link</th>
                        <th>Uploaded By</th>
                        <th>Uploaded At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($Documents) > 0)
                        @foreach ($Documents as $Document)
                            <tr>
                                <td>{{ $Document->DocumentName }}</td>
                                <td>{{ $Document->DocumentDescription }}</td>
                                <td>
                                    <a href="{{ asset($Document->DocumentFile) }}" target="_blank">
                                        {{ explode('/', $Document->DocumentFile)[3] }}
                                    </a>
                                </td>
                                <td>{{ $Document->UploadedBy }}</td>
                                <td>{{ $Document->UploadedAt }}</td>
                                <td>
                                    <form action="{{ route('documents.destroy', $Document) }}" method="post"
                                        class="d-inline">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this document?');">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="6">
                            <i>
                                Empty Data
                            </i>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <div class="mt-4 pull-right">

            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection

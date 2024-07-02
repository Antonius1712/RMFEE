@extends('layouts.app')
@section('content')
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger text-center">
            *{!! $error !!}
        </div>
    @endforeach

    @if (session()->has('noticication'))
        <div class="alert alert-success text-center">
            {!! session()->get('noticication') !!}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <form id="form-document" action="{{ route('documents.store') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header default">
                                <h3>Documents</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="document_name" class="col-lg-3 col-form-label-lg">Document Name</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="text" name="document_name" id="document_name"
                                        class="form-control col-lg-8" placeholder="Document Name" value="{{ old('document_name') }}">
                                </div>
                                <div class="form-group row">
                                    <label for="tax" class="col-lg-3 col-form-label-lg">Document Description</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <textarea name="document_description" id="document_description" cols="30" rows="10"
                                        class="form-control col-lg-8">{!! old('document_description') !!}</textarea>
                                </div>
                                <div class="form-group row">
                                    <label for="document_file" class="col-lg-3 col-form-label-lg">Document File</label>
                                    <label class="col-lg-1 col-form-label-lg">:</label>
                                    <input type="file" name="document_file" id="document_file"
                                        class="form-control col-lg-8" placeholder="Document File">
                                </div>
                                <div class="row">
                                    <button type="submit" class="btn btn-primary col-lg-12">
                                        Upload
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <input type="hidden" name="from" value="create" />
        </form>
    </div>
    </div>
@endsection
@section('script')
@endsection

@extends('layouts.app')
@section('title')
    
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 mb-2">
            {{-- <a class="btn btn-primary pull-left" style="border-radius: 100px; font-size: 18px;" aria-expanded="false" data-toggle="collapse" data-target="#FilterCollapse">
                <i class="feather icon-filter text-white"></i>
                <span class="text-white">Filter</span>
            </a> --}}
            
            <label>
                <input type="checkbox" name="to_do_list" id="to_do_list" class="to-do-list" style="width: 30px; height: 30px; vertical-align: middle;">
                <b style="font-size: 20px; vertical-align: middle;" class="ml-1">To do List</b>
            </label>
        </div>

        <div class="col-lg-6 mb-2">
            <a class="btn btn-primary pull-right" style="border-radius: 100px; font-size: 18px;" aria-expanded="false" data-toggle="collapse" data-target="#FilterCollapse">
                <i class="feather icon-filter text-white"></i>
                <span class="text-white">Filter</span>
            </a>
        </div>
    </div>

    <div class="card collapse" id="FilterCollapse">
        <div class="card-body row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="broker_name">Broker Name</label>
                    <input type="text" name="broker_name" id="broker_name" class="form-control radius" placeholder="Type Here..">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="start_date">Start Date</label>
                    <input type="text" name="start_date" id="start_date" class="form-control radius" placeholder="Type Here..">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="status_pembayaran_premi">Status Pembayaran Premi</label>
                    <input type="text" name="status_pembayaran_premi" id="status_pembayaran_premi" class="form-control radius" placeholder="Type Here..">
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="col-lg-4">
                <div class="form-group">
                    <label for="branch">Branch</label>
                    <input type="text" name="branch" id="branch" class="form-control radius" placeholder="Type Here..">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="no_policy">No Policy</label>
                    <input type="text" name="no_policy" id="no_policy" class="form-control radius" placeholder="Type Here..">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="aging_rmf">Aging RMF</label>
                    <input type="text" name="aging_rmf" id="aging_rmf" class="form-control radius" placeholder="Type Here..">
                </div>
            </div>
            <div class="clearfix"></div><div class="col-lg-4">
                <div class="form-group">
                    <label for="nb_rn">NB/RN</label>
                    <input type="text" name="nb_rn" id="nb_rn" class="form-control radius" placeholder="Type Here..">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="the_insured">The Insured</label>
                    <input type="text" name="the_insured" id="the_insured" class="form-control radius" placeholder="Type Here..">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="status_realisasi">Status Realisasi</label>
                    <input type="text" name="status_realisasi" id="status_realisasi" class="form-control radius" placeholder="Type Here..">
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-lg-12">
                <button class="btn btn-primary waves-effect waves-light radius-100" style="width: 100%;"> 
                    Apply Filter 
                </button>
            </div>
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
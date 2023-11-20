@extends('layouts.app')
@section('title')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-responsive table-budget dataTable">
                <thead>
                    <tr class="default tr-budget">
                        <th>Action</th>
                        <th>Class</th>
                        <th>SOB</th>
                        <th>Broker Name</th>
                        <th>ANO</th>
                        <th>Branch</th>
                        <th>Premium Note</th>
                        <th>Type</th>
                        <th>Policy No</th>
                        <th>The Insured</th>
                        <th>CAEP</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Occupation Code</th>
                        <th>Occupation Desc</th>
                        <th>Budget <span>%</span></th>
                        <th>Currency</th>
                        <th class="col-1">Gross Premi <span>(Before Disc, Comm, Adm)</span></th>
                        <th>Status Premi</th>
                        <th>OS Premi</th>
                        <th>Date of Premium Paid</th>
                        <th>Remarks</th>
                        <th>Aging Realization</th>
                        <th>Budget <span>(in Amount)</span></th>
                        <th>Realisasi RMF <span>(in Amount)</span></th>
                        <th>Realisasi Sponsorship <span>(in Amount)</span></th>
                        <th>Remain Budget</th>
                        <th>Status Budget</th>
                        <th>Archive</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="white">
                        <td>
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <div class="btn-group" role="group">
                                    <a href="#" id="BtnActionGroup" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" style="">
                                        <i class="feather icon-plus-circle icon-btn-group"></i>
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
                        <td>Class</td>
                        <td>SOB</td>
                        <td>Broker Name</td>
                        <td>ANO</td>
                        <td>Branch</td>
                        <td>Premium Note</td>
                        <td>Type</td>
                        <td>Policy No</td>
                        <td>tde Insured</td>
                        <td>CAEP</td>
                        <td>Start Date</td>
                        <td>End Date</td>
                        <td>Occupation Code</td>
                        <td>Occupation Desc</td>
                        <td>Budget <span>%</span></td>
                        <td>Currency</td>
                        <td class="col-1">Gross Premi <span>(Before Disc, Comm, Adm)</span></td>
                        <td>Status Premi</td>
                        <td>OS Premi</td>
                        <td>Date of Premium Paid</td>
                        <td>Remarks</td>
                        <td>Aging Realization</td>
                        <td>Budget <span>(in Amount)</span></td>
                        <td>Realisasi RMF <span>(in Amount)</span></td>
                        <td>Realisasi Sponsorship <span>(in Amount)</span></td>
                        <td>Remain Budget</td>
                        <td>
                            <span class="badge badge-pill badge-palegreen badge-status-budget">
                                FULLY PAID
                            </span>
                        </td>
                        <td>
                            <a href="">
                                <i class="feather icon-archive danger font-weight-bolder"></i>
                            </a>
                        </td>
                    </tr>
                    <tr class="white">
                        <td>
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <div class="btn-group" role="group">
                                    <a href="#" id="BtnActionGroup" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" style="">
                                        <i class="feather icon-plus-circle icon-btn-group"></i>
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
                        <td>Class</td>
                        <td>SOB</td>
                        <td>Broker Name</td>
                        <td>ANO</td>
                        <td>Branch</td>
                        <td>Premium Note</td>
                        <td>Type</td>
                        <td>Policy No</td>
                        <td>tde Insured</td>
                        <td>CAEP</td>
                        <td>Start Date</td>
                        <td>End Date</td>
                        <td>Occupation Code</td>
                        <td>Occupation Desc</td>
                        <td>Budget <span>%</span></td>
                        <td>Currency</td>
                        <td class="col-1">Gross Premi <span>(Before Disc, Comm, Adm)</span></td>
                        <td>Status Premi</td>
                        <td>OS Premi</td>
                        <td>Date of Premium Paid</td>
                        <td>Remarks</td>
                        <td>Aging Realization</td>
                        <td>Budget <span>(in Amount)</span></td>
                        <td>Realisasi RMF <span>(in Amount)</span></td>
                        <td>Realisasi Sponsorship <span>(in Amount)</span></td>
                        <td>Remain Budget</td>
                        <td>
                            <span class="badge badge-pill badge-gold badge-status-budget">
                                PARTIALLY PAID
                            </span>
                        </td>
                        <td>
                            <a href="">
                                <i class="feather icon-archive danger font-weight-bolder"></i>
                            </a>
                        </td>
                    </tr>
                    <tr class="white">
                        <td>
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <div class="btn-group" role="group">
                                    <a href="#" id="BtnActionGroup" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" style="">
                                        <i class="feather icon-plus-circle icon-btn-group"></i>
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
                        <td>Class</td>
                        <td>SOB</td>
                        <td>Broker Name</td>
                        <td>ANO</td>
                        <td>Branch</td>
                        <td>Premium Note</td>
                        <td>Type</td>
                        <td>Policy No</td>
                        <td>tde Insured</td>
                        <td>CAEP</td>
                        <td>Start Date</td>
                        <td>End Date</td>
                        <td>Occupation Code</td>
                        <td>Occupation Desc</td>
                        <td>Budget <span>%</span></td>
                        <td>Currency</td>
                        <td class="col-1">Gross Premi <span>(Before Disc, Comm, Adm)</span></td>
                        <td>Status Premi</td>
                        <td>OS Premi</td>
                        <td>Date of Premium Paid</td>
                        <td>Remarks</td>
                        <td>Aging Realization</td>
                        <td>Budget <span>(in Amount)</span></td>
                        <td>Realisasi RMF <span>(in Amount)</span></td>
                        <td>Realisasi Sponsorship <span>(in Amount)</span></td>
                        <td>Remain Budget</td>
                        <td>
                            <span class="badge badge-pill badge-tomatto badge-status-budget">
                                UNPAID
                            </span>
                        </td>
                        <td>
                            <a href="">
                                <i class="feather icon-archive danger font-weight-bolder"></i>
                            </a>
                        </td>
                    </tr>
                    <tr class="white">
                        <td>
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <div class="btn-group" role="group">
                                    <a href="#" id="BtnActionGroup" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" style="">
                                        <i class="feather icon-plus-circle icon-btn-group"></i>
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
                        <td>Class</td>
                        <td>SOB</td>
                        <td>Broker Name</td>
                        <td>ANO</td>
                        <td>Branch</td>
                        <td>Premium Note</td>
                        <td>Type</td>
                        <td>Policy No</td>
                        <td>tde Insured</td>
                        <td>CAEP</td>
                        <td>Start Date</td>
                        <td>End Date</td>
                        <td>Occupation Code</td>
                        <td>Occupation Desc</td>
                        <td>Budget <span>%</span></td>
                        <td>Currency</td>
                        <td class="col-1">Gross Premi <span>(Before Disc, Comm, Adm)</span></td>
                        <td>Status Premi</td>
                        <td>OS Premi</td>
                        <td>Date of Premium Paid</td>
                        <td>Remarks</td>
                        <td>Aging Realization</td>
                        <td>Budget <span>(in Amount)</span></td>
                        <td>Realisasi RMF <span>(in Amount)</span></td>
                        <td>Realisasi Sponsorship <span>(in Amount)</span></td>
                        <td>Remain Budget</td>
                        <td>
                            <span class="badge badge-pill badge-palegreen badge-status-budget">
                                FULLY PAID
                            </span>
                        </td>
                        <td>
                            <a href="">
                                <i class="feather icon-archive danger font-weight-bolder"></i>
                            </a>
                        </td>
                    </tr>
                    <tr class="white">
                        <td>
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <div class="btn-group" role="group">
                                    <a href="#" id="BtnActionGroup" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" style="">
                                        <i class="feather icon-plus-circle icon-btn-group"></i>
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
                        <td>Class</td>
                        <td>SOB</td>
                        <td>Broker Name</td>
                        <td>ANO</td>
                        <td>Branch</td>
                        <td>Premium Note</td>
                        <td>Type</td>
                        <td>Policy No</td>
                        <td>tde Insured</td>
                        <td>CAEP</td>
                        <td>Start Date</td>
                        <td>End Date</td>
                        <td>Occupation Code</td>
                        <td>Occupation Desc</td>
                        <td>Budget <span>(%)</span></td>
                        <td>Currency</td>
                        <td class="col-1">Gross Premi <span>(Before Disc, Comm, Adm)</span></td>
                        <td>Status Premi</td>
                        <td>OS Premi</td>
                        <td>Date of Premium Paid</td>
                        <td>Remarks</td>
                        <td>Aging Realization</td>
                        <td>Budget <span>(in Amount)</span></td>
                        <td>Realisasi RMF <span>(in Amount)</span></td>
                        <td>Realisasi Sponsorship <span>(in Amount)</span></td>
                        <td>Remain Budget</td>
                        <td>
                            <span class="badge badge-pill badge-palegreen badge-status-budget">
                                FULLY PAID
                            </span>
                        </td>
                        <td>
                            <a href="">
                                <i class="feather icon-archive danger font-weight-bolder"></i>
                            </a>
                        </td>
                    </tr>
                    <tr class="white">
                        <td>
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <div class="btn-group" role="group">
                                    <a href="#" id="BtnActionGroup" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" style="">
                                        <i class="feather icon-plus-circle icon-btn-group"></i>
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
                        <td>Class</td>
                        <td>SOB</td>
                        <td>Broker Name</td>
                        <td>ANO</td>
                        <td>Branch</td>
                        <td>Premium Note</td>
                        <td>Type</td>
                        <td>Policy No</td>
                        <td>tde Insured</td>
                        <td>CAEP</td>
                        <td>Start Date</td>
                        <td>End Date</td>
                        <td>Occupation Code</td>
                        <td>Occupation Desc</td>
                        <td>Budget <span>%</span></td>
                        <td>Currency</td>
                        <td class="col-1">Gross Premi <span>(Before Disc, Comm, Adm)</span></td>
                        <td>Status Premi</td>
                        <td>OS Premi</td>
                        <td>Date of Premium Paid</td>
                        <td>Remarks</td>
                        <td>Aging Realization</td>
                        <td>Budget <span>(in Amount)</span></td>
                        <td>Realisasi RMF <span>(in Amount)</span></td>
                        <td>Realisasi Sponsorship <span>(in Amount)</span></td>
                        <td>Remain Budget</td>
                        <td>
                            <span class="badge badge-pill badge-palegreen badge-status-budget">
                                FULLY PAID
                            </span>
                        </td>
                        <td>
                            <a href="">
                                <i class="feather icon-archive danger font-weight-bolder"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.dataTable').DataTable();
        });
    </script>
@endsection

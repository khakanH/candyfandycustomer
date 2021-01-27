@extends('admin.layouts.app')
@section('content')


<div class="page-wrapper">
<div class="page-content container-fluid">
                 <center>
                        @if(session('success'))
                        <p class="text-success pulse animated">{{ session('success') }}</p>
                        {{ session()->forget('success') }}
                        @elseif(session('failed'))
                        <p class="text-danger pulse animated">{{ session('failed') }}</p>
                        {{ session()->forget('failed') }}
                        @endif
                        </center>

               <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <div class="card">
                            <div class="d-flex align-items-center p-3">
                                <h5 class="card-title mb-0 text-uppercase">Recent Sales</h5>
                                <div class="ml-auto">
                                    <select class="form-control">
                                        <option>March</option>
                                        <option>April</option>
                                        <option>May</option>
                                        <option>June</option>
                                        <option>July</option>
                                    </select>
                                </div>
                            </div>
                            <div class="p-3 bg-light">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h2 class="font-normal">March 2017</h2>
                                        <p class="mb-2 text-uppercase font-14 font-light">Sales Report</p>
                                    </div>
                                    <div class="ml-auto">
                                        <h1 class="text-info mb-0 font-light">$3,690</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3">
                                <div class="table-responsive">
                                    <table class="table text-muted mb-0 no-wrap recent-table font-light">
                                        <thead>
                                            <tr class="text-uppercase">
                                                <th class="border-0">#</th>
                                                <th class="border-0">Name</th>
                                                <th class="border-0">Status</th>
                                                <th class="border-0">Date</th>
                                                <th class="border-0">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td class="txt-oflo">Elite admin</td>
                                                <td><span class="badge badge-pill text-uppercase text-white font-medium badge-success label-rouded">SALE</span> </td>
                                                <td class="txt-oflo">April 18, 2017</td>
                                                <td><span class="text-success">$24</span></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td class="txt-oflo">Real Homes WP Theme</td>
                                                <td><span class="badge badge-pill text-uppercase text-white font-medium badge-info label-rouded">EXTENDED</span></td>
                                                <td class="txt-oflo">April 19, 2017</td>
                                                <td><span class="text-info">$1250</span></td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td class="txt-oflo">Ample Admin</td>
                                                <td><span class="badge badge-pill text-uppercase text-white font-medium badge-info label-rouded">EXTENDED</span></td>
                                                <td class="txt-oflo">April 19, 2017</td>
                                                <td><span class="text-info">$1250</span></td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td class="txt-oflo">Medical Pro WP Theme</td>
                                                <td><span class="badge badge-pill text-uppercase text-white font-medium badge-danger label-rouded">TAX</span></td>
                                                <td class="txt-oflo">April 20, 2017</td>
                                                <td><span class="text-danger">-$24</span></td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td class="txt-oflo">Hosting press html</td>
                                                <td><span class="badge badge-pill text-uppercase text-white font-medium badge-warning label-rouded">SALE</span></td>
                                                <td class="txt-oflo">April 21, 2017</td>
                                                <td><span class="text-success">$24</span></td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td class="txt-oflo">Digital Agency PSD</td>
                                                <td><span class="badge badge-pill text-uppercase text-white font-medium badge-success label-rouded">SALE</span> </td>
                                                <td class="txt-oflo">April 23, 2017</td>
                                                <td><span class="text-danger">-$14</span></td>
                                            </tr>
                                            <tr>
                                                <td>7</td>
                                                <td class="txt-oflo">Helping Hands WP Theme</td>
                                                <td><span class="badge badge-pill text-uppercase text-white font-medium badge-warning label-rouded">member</span></td>
                                                <td class="txt-oflo">April 22, 2017</td>
                                                <td><span class="text-success">$64</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-uppercase">Recent Comments</h5>
                            </div>
                            <div class="comment-widgets scrollable ps-container ps-theme-default" style="height:531px;" data-ps-id="8f56d5aa-6a25-b9af-f861-c5b075be99ad">
                                <!-- Comment Row -->
                                <div class="d-flex flex-row comment-row mt-0 mb-0">
                                    <div class="p-2">
                                        <img src="{{config('app.img_url')}}users/1.jpg" alt="user" width="40" class="rounded-circle">
                                    </div>
                                    <div class="comment-text w-100">
                                        <h5 class="font-normal mb-1">Pavan kumar</h5>
                                        <span class="text-muted mr-2 font-12">10:20 AM 20 may 2016</span>
                                        <span class="badge badge-info badge-rounded text-uppercase font-medium">Pending</span>
                                        <span class="mb-2 d-block font-14 text-muted font-light mt-3">Donec ac condimentum massa. Etiam pellentesque pretium lacus. Phasellus ultricies dictum suscipit. Aenean commodo </span>
                                        <div class="mt-3">
                                            <a href="javacript:void(0)" class="btn btn btn-rounded btn-outline-success mr-2 btn-sm"><i class="ti-check mr-1"></i>Approve</a>
                                            <a href="javacript:void(0)" class="btn-rounded btn btn-outline-danger btn-sm"><i class="ti-close mr-1"></i> Reject</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Comment Row -->
                                <div class="d-flex flex-row comment-row mt-0 mb-0">
                                    <div class="p-2">
                                        <img src="{{config('app.img_url')}}users/2.jpg" alt="user" width="40" class="rounded-circle">
                                    </div>
                                    <div class="comment-text w-100">
                                        <h5 class="font-normal mb-1">Sonu Nigam</h5>
                                        <span class="text-muted mr-2 font-12">10:20 AM 20 may 2016</span>
                                        <span class="badge badge-success badge-rounded text-uppercase font-medium text-white">Approved</span>
                                        <span class="mb-2 d-block font-14 text-muted font-light mt-3">Donec ac condimentum massa. Etiam pellentesque pretium lacus. Phasellus ultricies dictum suscipit. Aenean commodo </span>
                                    </div>
                                </div>
                                <!-- Comment Row -->
                                <div class="d-flex flex-row comment-row mt-0 mb-0">
                                    <div class="p-2">
                                        <img src="{{config('app.img_url')}}users/3.jpg" alt="user" width="40" class="rounded-circle">
                                    </div>
                                    <div class="comment-text w-100">
                                        <h5 class="font-normal mb-1">Sonu Nigam</h5>
                                        <span class="text-muted mr-2 font-12">10:20 AM 20 may 2016</span>
                                        <span class="badge badge-danger badge-rounded text-uppercase font-medium text-white">Rejected</span>
                                        <span class="mb-2 d-block font-14 text-muted font-light mt-3">Donec ac condimentum massa. Etiam pellentesque pretium lacus. Phasellus ultricies dictum suscipit. Aenean commodo </span>
                                    </div>
                                </div>
                                <!-- Comment Row -->
                                <div class="d-flex flex-row comment-row mt-0 mb-0">
                                    <div class="p-2">
                                        <img src="{{config('app.img_url')}}users/1.jpg" alt="user" width="40" class="rounded-circle">
                                    </div>
                                    <div class="comment-text w-100">
                                        <h5 class="font-normal mb-1">Pavan kumar</h5>
                                        <span class="text-muted mr-2 font-12">10:20 AM 20 may 2016</span>
                                        <span class="badge badge-info badge-rounded text-uppercase font-medium">Pending</span>
                                        <span class="mb-2 d-block font-14 text-muted font-light mt-3">Donec ac condimentum massa. Etiam pellentesque pretium lacus. Phasellus ultricies dictum suscipit. Aenean commodo </span>
                                        <div class="mt-3">
                                            <a href="javacript:void(0)" class="btn btn btn-rounded btn-outline-success mr-2 btn-sm"><i class="ti-check mr-1"></i>Approve</a>
                                            <a href="javacript:void(0)" class="btn-rounded btn btn-outline-danger btn-sm"><i class="ti-close mr-1"></i> Reject</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Comment Row -->
                            <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;"><div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px;"><div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
                        </div>
                    </div>
                </div>
</div>
</div>


@endsection

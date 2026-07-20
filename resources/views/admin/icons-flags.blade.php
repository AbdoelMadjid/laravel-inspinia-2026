@extends('layouts.app')

@section('title', 'Flags | INSPINIA - Responsive Bootstrap 5 Admin Dashboard Template')

@section('content')
<div class="container-fluid">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Flags</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Inspinia</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Icons</a></li>
                                <li class="breadcrumb-item active">Flags</li>
                            </ol>
                        </div>
                    </div>


                    <div class="row justify-content-center">
                        <div class="col-xxl-10">
                            <div class="card">
                                <div class="card-header justify-content-between">
                                    <div>
                                        <h4 class="card-title mb-1 d-flex align-items-center gap-2">Flags Listing (SVG)</h4>
                                        <p class="mb-0 text-muted">We offer a set of scalable SVG flags, perfect for language selectors and international content.</p>
                                    </div>
                                    <div class="app-search">
                                        <input type="search" class="form-control" placeholder="Search country..." id="countrySearch" />
                                        <i class="ti ti-search app-search-icon text-muted"></i>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="flagTable" class="table table-bordered align-middle text-center w-100">
                                            <thead>
                                                <tr class="fs-xxs">
                                                    <th>Flag</th>
                                                    <th>Country Name</th>
                                                    <th>Path</th>
                                                    <th>Flag</th>
                                                    <th>Country Name</th>
                                                    <th>Path</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end card-body-->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col-->
                    </div>
                    <!-- end row-->
                </div>
                <!-- container -->
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/pages/flags-listing.js') }}"></script>
@endpush

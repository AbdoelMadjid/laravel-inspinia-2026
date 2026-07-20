@extends('layouts.app')

@section('html_attributes')
data-layout-width="boxed" data-sidenav-size="on-hover"
@endsection

@section('title', 'Boxed Layout | INSPINIA - Responsive Bootstrap 5 Admin Dashboard Template')

@section('content')
<div class="container-fluid">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Boxed</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Inspinia</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Layouts</a></li>
                                <li class="breadcrumb-item active">Boxed</li>
                            </ol>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info alert-bordered border-start border-info d-flex align-items-start gap-2">
                                <i class="ti ti-info-circle fs-xxl"></i>
                                <div>
                                    To enable the boxed layout, add
                                    <code>data-layout-width="boxed"</code>
                                    to the
                                    <code>&lt;html&gt;</code>
                                    tag. For optimal spacing and usability, we also recommend adding
                                    <code>data-sidenav-size="on-hover"</code>
                                    to make the sidebar compact while keeping more room for content.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h4 class="m-0">Your custom content here</h4>
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

@extends('layouts.app')

@section('html_class', 'sidebar-with-line')

@section('title', 'Sidebar with Lines | INSPINIA - Responsive Bootstrap 5 Admin Dashboard Template')

@section('content')
<div class="container-fluid">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Sidebar with Lines</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Inspinia</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Layouts</a></li>
                                <li class="breadcrumb-item active">Sidebar with Lines</li>
                            </ol>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info alert-bordered border-start border-info d-flex align-items-start gap-2">
                                <i class="ti ti-info-circle fs-xxl"></i>
                                <div>
                                    If you want to display a line with each menu item, add the class
                                    <code>"sidebar-with-line"</code>
                                    to the
                                    <code>&lt;html&gt;</code>
                                    tag.
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

@extends('layouts.app')

@section('html_attributes')
data-layout-position="scrollable"
@endsection

@section('title', 'Scrollable Layout | INSPINIA - Responsive Bootstrap 5 Admin Dashboard Template')

@section('content')
<div class="container-fluid">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Scrollable</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Inspinia</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Layouts</a></li>
                                <li class="breadcrumb-item active">Scrollable</li>
                            </ol>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info alert-bordered border-start border-info d-flex align-items-start gap-2">
                                <i class="ti ti-info-circle fs-xxl"></i>
                                <div>
                                    To enable full scrolling and view all content, please add
                                    <code>data-layout-position="scrollable"</code>
                                    to the
                                    <code>&lt;html&gt;</code>
                                    tag.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="min-height: 100vh"></div>
                </div>
                <!-- container -->
@endsection

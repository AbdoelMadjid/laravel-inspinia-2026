@extends('layouts.app')

@section('title', 'Echart Heatmap Chart | INSPINIA - Responsive Bootstrap 5 Admin Dashboard Template')

@section('content')
<div class="container-fluid">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Heatmap Echart</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Inspinia</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Charts</a></li>
                                <li class="breadcrumb-item active">Heatmap Echart</li>
                            </ol>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Basic Heatmap Chart</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-heatmap" style="min-height: 300px"></div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Heatmap Chart</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-heatmap3" style="min-height: 300px"></div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Heatmap - 20K Data Chart</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-heatmap4" style="min-height: 300px"></div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- container -->
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/chart-echart-heatmap.js') }}"></script>
@endpush

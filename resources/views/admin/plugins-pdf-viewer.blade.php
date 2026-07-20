@extends('layouts.app')

@section('title', 'PDF Viewer | INSPINIA - Responsive Bootstrap 5 Admin Dashboard Template')

@section('content')
<div class="container-fluid">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">PDF Viewer</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Inspinia</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Plugins</a></li>
                                <li class="breadcrumb-item active">PDF Viewer</li>
                            </ol>
                        </div>
                    </div>


                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <div class="btn-group text-nowrap">
                                                <button id="prev" class="btn btn-dark">
                                                    <i class="ti ti-arrow-left"></i>
                                                    <span class="d-none d-sm-inline ms-2">Previous</span>
                                                </button>

                                                <button id="next" class="btn btn-dark">
                                                    <i class="ti ti-arrow-right"></i>
                                                    <span class="d-none d-sm-inline ms-2">Next</span>
                                                </button>

                                                <button id="zoomin" class="btn btn-dark">
                                                    <i class="ti ti-zoom-in"></i>
                                                    <span class="d-none d-sm-inline ms-2">Zoom In</span>
                                                </button>

                                                <button id="zoomout" class="btn btn-dark">
                                                    <i class="ti ti-zoom-out"></i>
                                                    <span class="d-none d-sm-inline ms-2">Zoom Out</span>
                                                </button>

                                                <button id="zoomfit" class="btn btn-dark rounded-end-3">100%</button>

                                                <input type="text" class="form-control rounded-end-0 ms-1" id="page_num" style="width: 50px" />
                                                <span class="input-group-text rounded-start-0 border-start-0" id="page_count">/ 00</span>
                                            </div>
                                        </div>

                                        <div class="text-center overflow-auto mt-3">
                                            <canvas id="the-canvas" class="pdfcanvas border rounded-3"></canvas>
                                        </div>
                                    </div>
                                    <!--end card-body -->
                                </div>
                                <!-- end card-->
                            </div>
                            <!-- end col-->
                        </div>
                        <!-- end row-->
                    </div>
                    <!-- end container-->
                </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/pdfjs/pdf.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins-pdf-viewer.js') }}"></script>
@endpush

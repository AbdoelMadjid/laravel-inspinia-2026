@extends('layouts.app')

@section('title', 'Leaflet Maps | INSPINIA - Responsive Bootstrap 5 Admin Dashboard Template')

@push('styles')
    <link href="{{ asset('assets/plugins/leaflet/leaflet.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="container-fluid">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Leaflet</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Inspinia</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Maps</a></li>
                                <li class="breadcrumb-item active">Leaflet</li>
                            </ol>
                        </div>
                    </div>


                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header border-0 border-bottom border-dashed">
                                        <h4 class="card-title">Examples</h4>
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-lg-4">
                                                <h5 class="mb-1">Basic Map</h5>
                                                <p class="text-muted mb-0">A simple Leaflet map centered with default tile layer and controls.</p>
                                            </div>
                                            <div class="col-lg-8">
                                                <div id="basicMap" style="height: 300px"></div>
                                            </div>
                                        </div>

                                        <div class="my-4 border-top border-dashed"></div>

                                        <div class="row g-3">
                                            <div class="col-lg-4">
                                                <h5 class="mb-1">Marker, Circle & Polygon</h5>
                                                <p class="text-muted mb-0">Shows how to add interactive markers, circles, and polygons on the map.</p>
                                            </div>
                                            <div class="col-lg-8">
                                                <div id="shapeMap" style="height: 300px"></div>
                                            </div>
                                        </div>

                                        <div class="my-4 border-top border-dashed"></div>

                                        <div class="row g-3">
                                            <div class="col-lg-4">
                                                <h5 class="mb-1">Draggable Marker with Popup</h5>
                                                <p class="text-muted mb-0">Allows dragging a marker with a popup that displays dynamic content.</p>
                                            </div>
                                            <div class="col-lg-8">
                                                <div id="dragMap" style="height: 300px"></div>
                                            </div>
                                        </div>

                                        <div class="my-4 border-top border-dashed"></div>

                                        <div class="row g-3">
                                            <div class="col-lg-4">
                                                <h5 class="mb-1">User Location</h5>
                                                <p class="text-muted mb-0">Uses the browser's geolocation API to show the user's current location.</p>
                                            </div>
                                            <div class="col-lg-8">
                                                <div id="userLocation" style="height: 300px"></div>
                                            </div>
                                        </div>

                                        <div class="my-4 border-top border-dashed"></div>

                                        <div class="row g-3">
                                            <div class="col-lg-4">
                                                <h5 class="mb-1">Custom Icons</h5>
                                                <p class="text-muted mb-0">Demonstrates using custom image icons for Leaflet map markers.</p>
                                            </div>
                                            <div class="col-lg-8">
                                                <div id="customIcons" style="height: 300px"></div>
                                            </div>
                                        </div>

                                        <div class="my-4 border-top border-dashed"></div>

                                        <div class="row g-3">
                                            <div class="col-lg-4">
                                                <h5 class="mb-1">Layer Control</h5>
                                                <p class="text-muted mb-0">Toggles between multiple map layers or overlays using Leaflet’s layer control.</p>
                                            </div>
                                            <div class="col-lg-8">
                                                <div id="layerControl" style="height: 300px"></div>
                                            </div>
                                        </div>

                                        <div class="my-4 border-top border-dashed"></div>

                                        <div class="row g-3">
                                            <div class="col-lg-4">
                                                <h5 class="mb-1">Interactive Choropleth Map</h5>
                                                <p class="text-muted mb-0">Displays region-based data using GeoJSON and interactive color scales.</p>
                                            </div>
                                            <div class="col-lg-8">
                                                <div id="geoJson" style="height: 300px"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- card end -->
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end container-->
                </div>
                <!-- end container-fluid-->
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('assets/js/maps/leaflet-data.js') }}"></script>
    <script src="{{ asset('assets/js/pages/maps-leaflet.js') }}"></script>
@endpush

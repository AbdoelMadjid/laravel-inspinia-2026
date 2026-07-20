@extends('layouts.app')

@section('title', 'Video Player | INSPINIA - Responsive Bootstrap 5 Admin Dashboard Template')

@push('styles')
    <link href="{{ asset('assets/plugins/plyr/plyr.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
                    <div class="page-title-head d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="page-main-title m-0">Video Player</h4>
                        </div>

                        <div class="text-end">
                            <ol class="breadcrumb m-0 py-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Inspinia</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Plugins</a></li>
                                <li class="breadcrumb-item active">Video Player</li>
                            </ol>
                        </div>
                    </div>


                    <div class="container-xxl">
                        <div class="row">
                            <!-- Basic MP4 -->
                            <div class="col-12 col-xl-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Basic MP4 Video Player</h4>
                                    </div>
                                    <div class="card-body">
                                        <video id="player1" class="plyr w-100" playsinline="" controls="" poster="assets/media/sintel/poster.png" style="--plyr-color-main: #1ac266">
                                            <source src="{{ asset('assets/media/sintel/trailer_hd.mp4') }}" type="video/mp4">
                                        </video>
                                    </div>
                                </div>
                            </div>

                            <!-- Autoplay muted loop -->
                            <div class="col-12 col-xl-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Autoplay (muted), Loop Video Player</h4>
                                    </div>
                                    <div class="card-body">
                                        <video id="player3" class="plyr w-100" playsinline="" controls="" muted="" autoplay="" loop="" poster="assets/media/sintel/poster.png" style="--plyr-color-main: #1c84c6">
                                            <source src="{{ asset('assets/media/sintel/trailer_hd.mp4') }}" type="video/mp4">
                                        </video>
                                    </div>
                                </div>
                            </div>

                            <!-- YouTube embed via Plyr -->
                            <div class="col-12 col-xl-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">YouTube Video Player</h4>
                                    </div>
                                    <div class="card-body">
                                        <!-- Use provider + embed id (no iframe needed) -->
                                        <div id="yt1" class="plyr w-100" data-plyr-provider="youtube" data-plyr-embed-id="bTqVqk7FSmY" style="--plyr-color-main: #f8ac59"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Vimeo embed via Plyr -->
                            <div class="col-12 col-xl-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Vimeo Video Player</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="vimeo1" class="plyr w-100" data-plyr-provider="vimeo" data-plyr-embed-id="76979871" style="--plyr-color-main: #ed5565"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Audio Player</h4>
                                    </div>
                                    <div class="card-body">
                                        <audio class="w-100" id="player-audio" controls="" style="--plyr-color-main: #7b70ef">
                                            <source src="{{ asset('assets/media/Kishi_Bashi_-_It_All_Began_With_a_Burst.mp3') }}" type="audio/mp3">
                                            <source src="{{ asset('assets/media/Kishi_Bashi_-_It_All_Began_With_a_Burst.ogg') }}" type="audio/ogg">
                                        </audio>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row-->
                    </div>
                    <!-- container -->
                </div>
                <!-- end container-fluid-->
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/plyr/plyr.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins-plyr.js') }}"></script>
@endpush

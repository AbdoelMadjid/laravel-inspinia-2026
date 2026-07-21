<footer class="footer">
    @php $appProfile = \App\Models\Admin\System\AppProfile::get(); @endphp
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                © {{ $appProfile->app_year }} <strong>{{ $appProfile->app_name }}</strong> - Developed by
                @if($appProfile->developer_url)
                    <a href="{{ $appProfile->developer_url }}" target="_blank" class="fw-semibold text-primary text-decoration-none">{{ $appProfile->developer_name }}</a>
                @else
                    <span class="fw-semibold">{{ $appProfile->developer_name }}</span>
                @endif
            </div>
            <div class="col-md-6">
                <div class="text-md-end d-none d-md-block">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </div>
            </div>
        </div>
    </div>
</footer>

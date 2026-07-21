@if(view()->exists('template.error-404'))
    @include('template.error-404')
@else
    <div style="text-align: center; padding: 50px;">
        <h1>404 | Page Not Found</h1>
    </div>
@endif

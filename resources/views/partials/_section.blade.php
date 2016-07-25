<section class="section primary-content">
    <header class="section-header">
        <h1 class="title">{{ $title }}</h1>
    </header>
    @if (!empty($content))
        <div class="section-content">
            {!! $content !!}
        </div>
    @endif
</section>

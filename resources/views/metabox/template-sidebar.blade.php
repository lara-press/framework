<p>{!! Form::label('template') !!}</p>
{!! Form::select('template', $templateOptions, $post->getMeta('template')) !!}

<div class="sidebar-select">
    <p>{!! Form::label('sidebar') !!}</p>
    {!! Form::select('sidebar', $sidebarOptions, $post->getMeta('sidebar')) !!}
</div>

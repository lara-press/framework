<div class="sidebar-select">
    <p class="post-attributes-label-wrapper">
        <label class="post-attributes-label" for="sidebar">
            Sidebar
        </label>
    </p>
    <select name="sidebar" id="sidebar">
        @foreach($sidebarOptions as $value => $sidebarOption)
            <option value="{{ $value }}" {{ $post->getMeta('sidebar') === $value ? 'selected="selected"' : '' }}>
                {{ $sidebarOption }}
            </option>
        @endforeach
    </select>
</div>

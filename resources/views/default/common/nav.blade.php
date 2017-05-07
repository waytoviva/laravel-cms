<!-- header -->
<div class="header">
    <div class="w cl">
        <ul class="nav fl">
            @if($cache = cache()->get('navigation'))
                @foreach($cache as $navigation)
                    <li><a class="{{ Request::is($navigation->url.'*') ? 'curr' : '' }}" href="/{{ $navigation->url != '/' ? $navigation->url : '' }}">{{ $navigation->title }}</a></li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
<!-- header end -->
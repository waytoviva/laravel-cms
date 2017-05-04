<!-- footer -->
<div class="footer">
    <div class="w friendly-link">
        <ul class="cl">
            <li class="friendly-link-li1">友情链接</li>
            @if($cache = cache()->get('links'))
                @foreach($cache as $key => $link)
                    <li><a href="{{ $link->link_url }}" target="{{ $link->link_target }}">{{ $link->link_name }}</a>
                        @if($key+1 < $cache->count())
                        <em>|</em>
                        @endif
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
    <div class="copy">{{ cache()->get('setting.site_copyright') }} {{ cache()->get('setting.company_name') }}    版权所有 {{ cache()->get('setting.miitbeian') }}</div>


</div>
<!-- footer end -->

@section('js')

@show

@if (cache()->get('setting.analytics'))
@include('common.analytics')
@endif
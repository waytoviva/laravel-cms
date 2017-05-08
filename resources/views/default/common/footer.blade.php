<div id="footer">

    <p>
    友情链接:
    @if($cache = cache()->get('links'))
        @foreach($cache as $key => $link)
            <a href="{{ $link->link_url }}" target="{{ $link->link_target }}">{{ $link->link_name }}</a>
            @if($key+1 < $cache->count())
                <em>-</em>
            @endif
        @endforeach
    @endif
    </p>
    <p>
    {{ cache()->get('setting.site_copyright') }} {{ cache()->get('setting.company_name') }}
    版权所有 {{ cache()->get('setting.miitbeian') }}
    </p>
</div>


</div>

@section('js')

@show

@if (cache()->get('setting.analytics'))
    @include('common.analytics')
@endif
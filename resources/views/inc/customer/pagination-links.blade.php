<div class="biolife-panigations-block">
    {{-- @if ($paginator->hasPages())
        <ul class="panigation-contain">
            <li><a href="{{ $paginator->previousPageUrl() }}" class="link-page prev"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
            <li><span class="current-page">1</span></li>
            <li><a href="#" class="link-page">2</a></li>
            <li><a href="#" class="link-page">3</a></li>
            <li><span class="sep">....</span></li>
            <li><a href="#" class="link-page">20</a></li>
            <li><a href="{{ $paginator->nextPageUrl() }}" class="link-page next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
        </ul>
    @endif --}}

    @if ($paginator->hasPages())
    <ul class="panigation-contain">
       
        @if ($paginator->onFirstPage())
            <li class="disabled link-page prev"><span><i class="fa fa-angle-left" aria-hidden="true"></i></span></li>
        @else
            <li class="link-page prev"><a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
        @endif


      
        @foreach ($elements as $element)
           
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif


           
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li ><span class="current-page">{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}" class="link-page">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach


        
        @if ($paginator->hasMorePages())
            <li class="link-page next"><a href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
        @else
            <li class="disabled link-page next"><span><i class="fa fa-angle-right" aria-hidden="true"></i></span></li>
        @endif
    </ul>
@endif 
</div>
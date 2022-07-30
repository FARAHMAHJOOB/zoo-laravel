@if ($paginator->hasPages())
    <div class="row tm-mb-90">
        <div class="col-12 d-flex justify-content-center align-items-center tm-paging-col">
            @if ($paginator->onFirstPage())
                <a class="btn btn-primary tm-btn-prev disabled small-botton px-3 py-2 ml-2"
                    aria-label="@lang('pagination.previous')" rel="prev">قبلی</a>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-primary tm-btn-prev small-botton px-3 py-2 ml-2"
                    aria-label="@lang('pagination.previous')">قبلی</a>
            @endif
            @foreach ($elements as $element)
                @if (is_string($element))
                    <a class="disabled" aria-disabled="true"><span>{{ $element }}</span></a>
                @endif
                <div class="tm-paging d-flex">
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <a aria-current="page" class="active tm-paging-link btn btn-primary small-botton px-3 py-2"><span>{{ $page }}</span></a>
                            @else
                                <a href="{{ $url }}" class="tm-paging-link btn btn-primary  small-botton px-3 py-2">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                </div>
            @endforeach
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"
                    class="btn btn-primary tm-btn-next small-botton px-3 py-2 mr-2">بعدی</a>
            @else
                <a aria-disabled="true" aria-label="@lang('pagination.next')"
                    class="btn btn-primary tm-btn-next disabled small-botton px-3 py-2 mr-2">بعدی</a>
            @endif
        </div>
    </div>
@endif

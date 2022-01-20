<div class="text-center">            
            @if ($pagination->startButtons > 1)
                <a href="{{ route($page_list, [preg_replace('/offset=\d+/', 'offset=0', $str)]) }}" class="btn btn-primary">1</a> ...
            @endif

            @for ($i = $pagination->startButtons; $i <= $pagination->endButtons; $i++)
                @php 
                    if ($str != '') {
                        if (preg_match('/offset=\d+/', $str)) {
                            $url = preg_replace('/offset=\d+/', 'offset=' . (($i - 1) * $pagination->itemsOnPage), $str);
                        } else {
                            $url = $str . '&offset=' . (($i - 1) * $pagination->itemsOnPage);
                        }                        
                    } else {
                        $url = 'offset=' . (($i - 1) * $pagination->itemsOnPage);
                    }
                    if ($i == $pagination->currentButton) { 
                        $class = 'btn-success';
                    } else { 
                        $class = 'btn-primary';
                    }    
                @endphp                
                <a href="{{ route($page_list, [$url]) }}" class="btn {{ $class }}">{{ $i }}</a>
            @endfor  

            @if ($pagination->endButtons < $pagination->numberOfAllButtonsPagination)
                @if ($str == '') 
                    ... <a href="{{ route($page_list, ['offset=' . ($pagination->numberOfAllButtonsPagination - 1) * $pagination->itemsOnPage]) }}" class="btn btn-primary">{{$pagination->numberOfAllButtonsPagination}}</a>
                @else
                    ... <a href="{{ route($page_list, [preg_replace('/offset=\d+/', 'offset=' . ($pagination->numberOfAllButtonsPagination - 1) * $pagination->itemsOnPage, $str)]) }}" class="btn btn-primary">{{$pagination->numberOfAllButtonsPagination}}</a>
                @endif
            @endif        
</div>
            <br />
            radius: {{ $pagination->radius }}
            <br />
            offset: {{ $pagination->offset }}        
            <br />
            currentButton: {{ $pagination->currentButton }}                
            <br />
            numberOfAllItems: {{ $pagination->numberOfAllItems }}
            <br />
            foundedItems: {{ $pagination->foundedItems }}
            <br />
            startButtons: {{ $pagination->startButtons }}
            <br />
            endButtons: {{ $pagination->endButtons }}        
            <br />
            numberOfAllButtonsPagination: {{ $pagination->numberOfAllButtonsPagination }}           
            @if ($pagination->startButtons > 1)
                <a href="{{ route('category_list', [preg_replace('/offset=\d+/', 'offset=0', $str)]) }}" class="btn btn-primary">1</a> ...
            @endif

            @for ($i = $pagination->startButtons; $i <= $pagination->endButtons; $i++)
                @php 
                    if ($str != '') {
                        if (preg_match('/offset=\d+/', $str)) {
                            $url = preg_replace('/offset=\d+/', 'offset=' . (($i - 1) * $onPage), $str);
                        } else {
                            $url = $str . '&offset=' . (($i - 1) * $onPage);
                        }                        
                    } else {
                        $url = 'offset=' . (($i - 1) * $onPage);
                    }
                    if ($i == $pagination->currentButton) { 
                        $class = 'btn-success';
                    } else { 
                        $class = 'btn-primary';
                    }    
                @endphp                
                <a href="{{ route('category_list', [$url]) }}" class="btn {{ $class }}">{{ $i }}</a>
            @endfor  

            @if ($pagination->endButtons < $pagination->numberOfAllButtonsPagination)
                ... <a href="{{ route('category_list', [preg_replace('/offset=\d+/', 'offset=' . ($pagination->numberOfAllButtonsPagination - 1) * $onPage, $str)]) }}" class="btn btn-primary">{{$pagination->numberOfAllButtonsPagination}}</a>
            @endif        

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
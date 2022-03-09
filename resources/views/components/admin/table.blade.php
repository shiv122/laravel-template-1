<table
    class="table table-borderless table-hover-animation @isset($class) {{ $class }} @endisset">
    <thead>
        <tr>
            @isset($columns)
                @forelse ($columns as $col)
                    <th>{{ $col }}</th>
                @empty
                @endforelse
            @endisset


        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
@section('page-script')
    <script>
        @if (!empty($columns))
            const col = JSON.parse('{!! json_encode($columns) !!}');
        
        
            (() => {
            initYtable({
            url: "{{ $route }}",
            col: col,
            });
            })();
        @else
            alert('No columns defined , Cant initialize table');
        @endif
    </script>
@endsection

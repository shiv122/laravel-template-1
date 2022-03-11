@php
$inp = explode(',', $inputs);

@endphp
<form class="form" enctype="multipart/form-data" id="{{ $id }}">
    @csrf
    <div class="form-body">
        <div class="row ">
            @foreach ($inp as $item)
                @php
                    $type = 'text';
                    $class = null;
                    $required = '';
                    $data = explode(':', $item);
                    $item = $data[0];
                    if (!empty($data[1])) {
                        $extra = explode('|', $data[1]);
                        foreach ($extra as $key => $value) {
                            [$var, $val] = explode('=', $value);
                            $temp_val = explode('&', $val);
                            if (!empty($temp_val[1])) {
                                $required = $temp_val[1];
                            }
                            ${"$var"} = $temp_val[0];
                        }
                    }
                    $name = $id = Str::snake($item);
                @endphp


                <div class="col-lg-6 col-md-6 col-12">
                    <div class="form-group">
                        <label for="{{ $id }}">{{ Str::title($item) }}</label>
                        @if ($type == 'select')
                            <select {{ $required }} name="{{ $id }}" id="{{ $id }}"
                                class="form-control">

                            </select>
                        @elseif ($type == 'textarea')
                            <textarea {{ $required }} class="form-control" name="{{ $name }}"
                                id="{{ $id }}" rows="3"></textarea>
                        @else
                            <input {{ $required }} type="{{ $type }}" id="{{ $id }}"
                                class="form-control {{ $class }}" placeholder="Enter {{ Str::title($item) }}"
                                name="{{ $name }}">
                        @endif

                    </div>
                </div>
            @endforeach

            @if (!empty($additional))
                {{ $additional }}
            @endif
        </div>
        <div class="row">
            <div class="form-actions text-center w-100">
                <button type="submit" class="btn btn-success ">
                    Submit
                </button>
            </div>
        </div>
    </div>
</form>

@push('component-script')
    <script>
        const selects = @json($selects);
        Object.keys(selects).forEach(element => {
            var opt = [];
            const options = selects[element];
            options.forEach(el => {
                console.log(Object.entries(el));
                opt.push({
                    id: Object.entries(el)[0][1],
                    text: Object.entries(el)[1][1],
                });
            });
            $('#' + element).select2({
                data: opt
            });
        });
        @if (empty($route))
            alert('Please add route');
        @endif
        $(document).on('submit', '#{{ $id }}', function(e) {
            e.preventDefault();
            rebound({
                selector: this,
                to: '{{ $route ?? '' }}',
                method: "{{ $method ?? 'POST' }}",
            });
        });
    </script>
@endpush

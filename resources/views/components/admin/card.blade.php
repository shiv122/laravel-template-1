<div id="table-card" class="card">


    @isset($title)
        <div class="card-header text-center justify-content-center">
            <h4 class="card-title">{{ $title }}</h4>

        </div>
    @endisset


    {{ $card_body }}
</div>

@if(!empty(
        array_filter(
             ?? [],
            fn (
                array 
            ) => empty(
                ['can'] ?? null
            ) || auth()->user()?->can(['can'])
        )
    ))
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-header bg-white">
            <h5 class="mb-0">Quick Launch</h5>
            <small class="text-muted">Access the most-used workflows instantly.</small>
        </div>
        <div class="card-body">
            <div class="row g-3">
                @foreach ( as )
                    @php
                         = empty(['can'] ?? null) || auth()->user()?->can(['can']);
                    @endphp
                    @if ()
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route(['route']) }}" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center gap-2">
                                @if (!empty(['icon']))
                                    <i class="{{ ['icon'] }}"></i>
                                @endif
                                <span>{{ ['label'] }}</span>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endif

@php($linkItems = collect($links ?? []))
@if ($linkItems->isNotEmpty())
    <div class="card shadow-sm mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">{{ $title ?? 'Quick Actions' }}</h5>
                @if (! empty($subtitle))
                    <small class="text-muted">{{ $subtitle }}</small>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="row g-3">
                @foreach ($linkItems as $link)
                    @php($variant = $link['variant'] ?? 'outline-primary')
                    <div class="col-md-3 col-sm-6">
                        <a href="{{ route($link['route']) }}" class="btn btn-{{ $variant }} w-100 d-flex align-items-center justify-content-center gap-2">
                            @if (! empty($link['icon']))
                                <i class="{{ $link['icon'] }}"></i>
                            @endif
                            <span>{{ $link['label'] ?? 'Launch' }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
@php($linkItems = collect($links ?? []))
@if ($linkItems->isNotEmpty())
    <div class="container-fluid mt-4">
        <div class="card border-0">
            <div class="card-header bg-transparent border-0 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">{{ $title ?? 'Quick Actions' }}</h5>
                        @if (! empty($subtitle))
                            <p class="text-muted mb-0 mt-1">{{ $subtitle }}</p>
                        @endif
                    </div>
                    <i class="fas fa-bolt text-warning fa-lg"></i>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach ($linkItems as $link)
                        @php($variant = $link['variant'] ?? 'primary')
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <a href="{{ route($link['route']) }}" class="quick-action-btn btn w-100 d-flex align-items-center justify-content-center gap-3 p-4">
                                @if (! empty($link['icon']))
                                    <i class="{{ $link['icon'] }} fa-2x"></i>
                                @endif
                                <div class="text-start">
                                    <span class="d-block fw-bold fs-6">{{ $link['label'] ?? 'Launch' }}</span>
                                    <small class="text-muted">{{ $link['description'] ?? 'Quick action' }}</small>
                                </div>
                                <i class="fas fa-arrow-right ms-auto"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif

<style>
.quick-action-btn {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border: 2px solid transparent;
    border-radius: 16px;
    color: #2d3748;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.quick-action-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    border-color: var(--primary);
    color: #2d3748;
}

.quick-action-btn i:first-child {
    color: var(--primary);
}

.quick-action-btn .fa-arrow-right {
    opacity: 0;
    transform: translateX(-10px);
    transition: all 0.3s ease;
    color: var(--primary);
}

.quick-action-btn:hover .fa-arrow-right {
    opacity: 1;
    transform: translateX(0);
}
</style>

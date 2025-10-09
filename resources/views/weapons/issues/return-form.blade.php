@extends('admin.admin_master')
@section('title', 'Return Weapons')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Weapon Returns</h5>
                        <p class="text-muted mb-0">Close the loop on issued serials swiftly with live lookups and batch processing.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('weapons.dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item">Weapons</li>
                        <li class="breadcrumb-item active">Return</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <strong>We ran into a problem:</strong>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('message'))
        <div class="alert alert-{{ session('alert-type', 'info') }} alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('weapons.returns.process') }}" class="mb-4">
        @csrf
        <div class="row g-3">
            <div class="col-xl-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Quick Search</h5>
                            <small class="text-muted">Scan or type a weapon number to find active issues.</small>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Weapon Number</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white"><i class="feather icon-search"></i></span>
                                <input type="text"
                                       class="form-control"
                                       id="weapon-search"
                                       placeholder="e.g. GAF-M16-0015"
                                       autocomplete="off"
                                       spellcheck="false"
                                       data-search-url="{{ route('weapons.issues.search') }}">
                            </div>
                        </div>
                        <div class="table-responsive border rounded">
                            <table class="table table-sm table-hover align-middle mb-0">
                                <thead class="table-light text-uppercase small">
                                    <tr>
                                        <th>Weapon</th>
                                        <th class="text-center">Serial</th>
                                        <th>Armory</th>
                                        <th>Issued</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="weapon-search-results">
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">Start typing a weapon number to search…</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-7">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Return Summary</h5>
                            <small class="text-muted">Selected weapons will be processed in one submission.</small>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Selected Weapons</label>
                            <div id="selected-weapons" class="d-flex flex-wrap gap-2"></div>
                            <small class="text-muted">Click a chip to remove it from this batch.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Manual Entry / Paste</label>
                            <textarea class="form-control"
                                      name="weapon_numbers"
                                      id="weapon_numbers"
                                      rows="4"
                                      placeholder="Comma, space or line separated serial numbers">{{ old('weapon_numbers') }}</textarea>
                            <small class="text-muted">Manual entries will be merged with the quick selections and duplicates removed automatically.</small>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Return Notes</label>
                            <textarea class="form-control" name="return_notes" rows="3" placeholder="Optional remarks (condition, location, receiver)">{{ old('return_notes') }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer bg-white d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary">Process Return</button>
                        <a href="{{ route('weapons.dashboard') }}" class="btn btn-light">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('weapon-search');
            const resultsBody = document.getElementById('weapon-search-results');
            const selectedContainer = document.getElementById('selected-weapons');
            const textarea = document.getElementById('weapon_numbers');

            if (!searchInput || !resultsBody || !selectedContainer || !textarea) {
                return;
            }

            let debounceTimer = null;
            let syncingTextarea = false;
            let selectedNumbers = parseInput(textarea.value);
            renderSelected(false);

            searchInput.addEventListener('input', () => {
                const term = searchInput.value.trim();
                if (debounceTimer) {
                    clearTimeout(debounceTimer);
                }
                debounceTimer = setTimeout(() => runSearch(term), 250);
            });

            resultsBody.addEventListener('click', (event) => {
                const button = event.target.closest('button[data-add-number]');
                if (!button) {
                    return;
                }
                const weaponNumber = button.getAttribute('data-add-number');
                addNumber(weaponNumber);
            });

            selectedContainer.addEventListener('click', (event) => {
                const button = event.target.closest('button[data-remove-number]');
                if (!button) {
                    return;
                }
                removeNumber(button.getAttribute('data-remove-number'));
            });

            textarea.addEventListener('input', () => {
                if (syncingTextarea) {
                    return;
                }
                selectedNumbers = parseInput(textarea.value);
                renderSelected(false);
            });

            function runSearch(term) {
                if (term.length === 0) {
                    renderNoResults('Start typing a weapon number to search…');
                    return;
                }

                fetch(`${searchInput.dataset.searchUrl}?q=${encodeURIComponent(term)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                })
                    .then((response) => response.json())
                    .then((data) => renderResults(Array.isArray(data) ? data : []))
                    .catch(() => renderNoResults('Unable to fetch results right now.'));
            }

            function renderResults(items) {
                if (!items.length) {
                    renderNoResults('No issued weapons match that number.');
                    return;
                }

                resultsBody.innerHTML = '';
                items.forEach((item) => {
                    const isSelected = selectedNumbers.includes(item.weapon_number);
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>
                            <div class="fw-semibold">${escapeHtml(item.weapon_name || '—')}</div>
                            <small class="text-muted">${escapeHtml(item.weapon_variant || '')}</small>
                        </td>
                        <td class="text-center"><code class="text-primary">${escapeHtml(item.weapon_number)}</code></td>
                        <td>${escapeHtml(item.armory || '—')}</td>
                        <td>${escapeHtml(item.issued_at || '—')}</td>
                        <td class="text-end">
                            <button type="button"
                                    class="btn btn-sm ${isSelected ? 'btn-outline-secondary' : 'btn-outline-primary'}"
                                    data-add-number="${escapeHtml(item.weapon_number)}"
                                    ${isSelected ? 'disabled' : ''}>
                                ${isSelected ? 'Added' : 'Add'}
                            </button>
                        </td>
                    `;
                    resultsBody.appendChild(row);
                });
            }

            function renderNoResults(message) {
                resultsBody.innerHTML = `<tr><td colspan="5" class="text-center text-muted py-3">${escapeHtml(message)}</td></tr>`;
            }

            function addNumber(number) {
                if (!number || selectedNumbers.includes(number)) {
                    return;
                }
                selectedNumbers.push(number);
                renderSelected();
            }

            function removeNumber(number) {
                selectedNumbers = selectedNumbers.filter((value) => value !== number);
                renderSelected();
            }

            function renderSelected(syncTextarea = true) {
                selectedContainer.innerHTML = '';

                if (!selectedNumbers.length) {
                    selectedContainer.innerHTML = '<span class="text-muted">No weapons selected yet.</span>';
                } else {
                    selectedNumbers.forEach((number) => {
                        const badge = document.createElement('span');
                        badge.className = 'badge bg-primary px-3 py-2 d-flex align-items-center gap-2 rounded-pill';
                        badge.innerHTML = `
                            <span class="fw-semibold">${escapeHtml(number)}</span>
                            <button type="button" class="btn-close btn-close-white btn-sm" data-remove-number="${escapeHtml(number)}" aria-label="Remove"></button>
                        `;
                        selectedContainer.appendChild(badge);
                    });
                }

                if (syncTextarea) {
                    syncingTextarea = true;
                    textarea.value = selectedNumbers.join('\n');
                    syncingTextarea = false;
                }
            }

            function parseInput(value) {
                return Array.from(
                    new Set(
                        (value || '')
                            .split(/[\n,;\s]+/)
                            .map((entry) => entry.trim())
                            .filter(Boolean)
                    )
                );
            }

            function escapeHtml(value) {
                return (value || '')
                    .toString()
                    .replace(/[&<>"]+/g, (match) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[match] || match));
            }
        });
    </script>
@endsection

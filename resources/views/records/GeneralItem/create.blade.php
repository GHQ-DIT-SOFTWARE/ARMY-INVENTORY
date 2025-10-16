@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Issue General Control Items</h5>
                        <p class="text-muted mb-0">Allocate available stock items to units or individual personnel.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('controls.general-items.records') }}">General Items</a></li>
                        <li class="breadcrumb-item">Issue</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="issue-dashboard">
        <div class="dashboard-banner">
            <div class="banner-text">
                <span class="banner-eyebrow">Issuance Workspace</span>
                <h2>Allocate General Control Inventory</h2>
                <p>Review availability, select the recipient, and confirm an issuance in one streamlined view.</p>
            </div>
            <div class="banner-meta">
                <div class="meta-chip">
                    <i class="fas fa-clipboard-check"></i>
                    <span>{{ number_format($summary['totalStock']) }} items in stock</span>
                </div>
                <div class="meta-chip">
                    <i class="fas fa-clock"></i>
                    <span>Last sync: {{ now()->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

        <div class="overview-stats">
            <div class="stat-card">
                <div class="stat-icon stat-icon-primary">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="stat-body">
                    <span class="stat-label">Catalogues</span>
                    <span class="stat-value">{{ number_format($summary['availableItems']) }}</span>
                    <span class="stat-hint">Distinct stock entries</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon stat-icon-success">
                    <i class="fas fa-warehouse"></i>
                </div>
                <div class="stat-body">
                    <span class="stat-label">Total Stock</span>
                    <span class="stat-value">{{ number_format($summary['totalStock']) }}</span>
                    <span class="stat-hint">Current inventory balance</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon stat-icon-info">
                    <i class="fas fa-building"></i>
                </div>
                <div class="stat-body">
                    <span class="stat-label">Supported Units</span>
                    <span class="stat-value">{{ number_format($summary['units']) }}</span>
                    <span class="stat-hint">Potential destinations</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon stat-icon-muted">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-body">
                    <span class="stat-label">Personnel</span>
                    <span class="stat-value">{{ number_format($summary['personnels']) }}</span>
                    <span class="stat-hint">Individual recipients</span>
                </div>
            </div>
        </div>

        @if ($items->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h4>No stock items available</h4>
                <p>Please add inventory records before issuing items to units or personnel.</p>
                <a href="{{ route('controls.general-items.records') }}" class="btn-empty-cta">
                    <i class="fas fa-boxes"></i>
                    Manage Inventory
                </a>
            </div>
        @endif

        <div class="issuance-shell">
            <div class="form-heading">
                <div>
                    <span class="form-eyebrow">Issuance Form</span>
                    <h3>Capture Recipient & Item Information</h3>
                    <p>All required fields are marked with an asterisk (*). Stock availability is validated automatically.</p>
                </div>
                <div class="form-hint-box">
                    <i class="fas fa-lightbulb"></i>
                    <span>Select an item to reveal current stock and prevent over-allocation.</span>
                </div>
            </div>

            @php
                $selectedIssueTo = old('issue_to', 'unit');
            @endphp

            <form action="{{ route('controls.general-items.issue.store') }}" method="POST" class="issuance-form">
                @csrf
                <div class="form-columns">
                    <section class="form-panel">
                        <header class="panel-header">
                            <i class="fas fa-user-check"></i>
                            <div>
                                <h4>Recipient Information</h4>
                                <p>Choose whether the issue is for a unit or an individual.</p>
                            </div>
                        </header>

                        <div class="form-group">
                            <label class="form-label">Issue To *</label>
                            <div class="radio-group">
                                <label class="radio-card">
                                    <input type="radio" name="issue_to" value="unit" {{ $selectedIssueTo === 'unit' ? 'checked' : '' }}>
                                    <div class="radio-content">
                                        <i class="fas fa-building"></i>
                                        <span>Unit</span>
                                    </div>
                                </label>
                                <label class="radio-card">
                                    <input type="radio" name="issue_to" value="personnel" {{ $selectedIssueTo === 'personnel' ? 'checked' : '' }}>
                                    <div class="radio-content">
                                        <i class="fas fa-user"></i>
                                        <span>Personnel</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="recipient-fields">
                            <div class="recipient-field {{ $selectedIssueTo === 'unit' ? 'is-visible' : '' }}" id="unit-picker">
                                <div class="form-group">
                                    <label for="unit_id" class="form-label">
                                        <i class="fas fa-map-marker-alt"></i>
                                        Select Unit *
                                    </label>
                                    <select name="unit_id" id="unit_id" class="form-select">
                                        <option value="">-- Choose Unit --</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                                {{ $unit->unit_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('unit_id')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="recipient-field {{ $selectedIssueTo === 'personnel' ? 'is-visible' : '' }}" id="personnel-picker">
                                <div class="form-group">
                                    <label for="personnel_uuid" class="form-label">
                                        <i class="fas fa-id-card"></i>
                                        Select Personnel *
                                    </label>
                                    <select name="personnel_uuid" id="personnel_uuid" class="form-select">
                                        <option value="">-- Choose Personnel --</option>
                                        @foreach ($personnels as $personnel)
                                            @php
                                                $label = trim(($personnel->svcnumber ?? '') . ' - ' . (($personnel->surname ?? '') . ' ' . ($personnel->othernames ?? '')));
                                            @endphp
                                            <option value="{{ $personnel->uuid }}" {{ old('personnel_uuid') == $personnel->uuid ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('personnel_uuid')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="form-panel">
                        <header class="panel-header">
                            <i class="fas fa-box-open"></i>
                            <div>
                                <h4>Item Details</h4>
                                <p>Select an item and confirm the quantity to be issued.</p>
                            </div>
                        </header>

                        <div class="form-group">
                            <label for="item_id" class="form-label">
                                <i class="fas fa-cube"></i>
                                Select Item *
                            </label>
                            <select name="item_id" id="item_id" class="form-select">
                                <option value="">-- Choose Item --</option>
                                @foreach ($items as $item)
                                    @php
                                        $category = optional($item->category)->category_name ?? 'Uncategorised';
                                        $subCategory = optional($item->subcategory)->sub_category_name ?? 'N/A';
                                        $label = $item->item_name . ' (' . $category . ' / ' . $subCategory . ')';
                                    @endphp
                                    <option value="{{ $item->id }}" data-qty="{{ $item->qty }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('item_id')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="quantity-grid">
                            <div class="form-group">
                                <label for="quantity" class="form-label">
                                    <i class="fas fa-hashtag"></i>
                                    Quantity *
                                </label>
                                <div class="quantity-input">
                                    <button type="button" class="quantity-btn" data-action="decrease" aria-label="Decrease quantity">-</button>
                                    <input type="number" min="1" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', 1) }}">
                                    <button type="button" class="quantity-btn" data-action="increase" aria-label="Increase quantity">+</button>
                                </div>
                                @error('quantity')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="stock-info">
                                <label class="form-label">
                                    <i class="fas fa-chart-bar"></i>
                                    Available Stock
                                </label>
                                <div class="stock-display">
                                    <span id="available-stock">--</span>
                                    <small>units available</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="notes" class="form-label">
                                <i class="fas fa-sticky-note"></i>
                                Notes (optional)
                            </label>
                            <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Add additional instructions or reference information...">{{ old('notes') }}</textarea>
                        </div>
                    </section>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i>
                        Issue Item
                    </button>
                    <a href="{{ route('controls.general-items.records') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const issueToInputs = document.querySelectorAll('input[name="issue_to"]');
            const unitPicker = document.querySelector('#unit-picker');
            const personnelPicker = document.querySelector('#personnel-picker');
            const itemSelect = document.querySelector('#item_id');
            const stockDisplay = document.querySelector('#available-stock');
            const quantityInput = document.querySelector('#quantity');
            const quantityButtons = document.querySelectorAll('.quantity-btn');

            function toggleRecipientFields() {
                const issueTo = document.querySelector('input[name="issue_to"]:checked')?.value || 'unit';
                if (unitPicker) unitPicker.classList.toggle('is-visible', issueTo === 'unit');
                if (personnelPicker) personnelPicker.classList.toggle('is-visible', issueTo === 'personnel');
            }

            function updateAvailableStock() {
                if (!itemSelect || !stockDisplay) {
                    return;
                }
                const selectedOption = itemSelect.options[itemSelect.selectedIndex];
                const qty = selectedOption ? selectedOption.getAttribute('data-qty') : null;

                stockDisplay.textContent = qty ?? '--';
                stockDisplay.classList.toggle('low-stock', qty !== null && Number(qty) < 10);
            }

            function validateQuantity() {
                if (!itemSelect || !quantityInput) {
                    return;
                }

                const selectedOption = itemSelect.options[itemSelect.selectedIndex];
                const availableQty = selectedOption ? Number(selectedOption.getAttribute('data-qty')) : null;
                const requestedQty = Number(quantityInput.value) || 1;

                if (availableQty !== null && requestedQty > availableQty) {
                    quantityInput.classList.add('error');
                } else {
                    quantityInput.classList.remove('error');
                }
            }

            issueToInputs.forEach(input => input.addEventListener('change', toggleRecipientFields));

            if (itemSelect) {
                itemSelect.addEventListener('change', () => {
                    updateAvailableStock();
                    validateQuantity();
                });
            }

            if (quantityInput) {
                quantityInput.addEventListener('input', validateQuantity);
            }

            quantityButtons.forEach(button => {
                button.addEventListener('click', () => {
                    if (!quantityInput) return;
                    const action = button.getAttribute('data-action');
                    const currentValue = Number(quantityInput.value) || 1;
                    const newValue = action === 'increase'
                        ? currentValue + 1
                        : Math.max(1, currentValue - 1);
                    quantityInput.value = newValue;
                    validateQuantity();
                });
            });

            toggleRecipientFields();
            updateAvailableStock();
            validateQuantity();
        });
    </script>

    <style>
        :root {
            --primary: #4f6ef2;
            --primary-muted: #e9edff;
            --success: #47b9a3;
            --info: #46a8f0;
            --muted: #8892aa;
            --text-dark: #182537;
            --text-mid: #4b5565;
            --text-muted: #7c8499;
            --panel: #ffffff;
            --panel-alt: #f7f9fd;
            --border: #e4eaf6;
            --shadow-soft: 0 28px 60px -42px rgba(15, 23, 42, 0.45);
        }

        .issue-dashboard {
            background: var(--panel);
            border-radius: 24px;
            box-shadow: var(--shadow-soft);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .dashboard-banner {
            padding: 2.75rem 2.75rem 2.25rem;
            background: linear-gradient(135deg, rgba(79, 110, 242, 0.16) 0%, rgba(71, 185, 163, 0.18) 100%);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .banner-text h2 {
            margin: 0.4rem 0 0.75rem;
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .banner-text p {
            margin: 0;
            color: var(--text-mid);
            max-width: 620px;
            line-height: 1.6;
        }

        .banner-eyebrow {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.85rem;
            border-radius: 999px;
            background: rgba(79, 110, 242, 0.2);
            color: var(--primary);
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .banner-meta {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .meta-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.65rem 1.2rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(79, 110, 242, 0.2);
            color: var(--text-mid);
            font-weight: 600;
        }

        .meta-chip i {
            color: var(--primary);
        }

        .overview-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            padding: 2rem 2.75rem 2.25rem;
        }

        .stat-card {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: 0 22px 60px -38px rgba(79, 110, 242, 0.35);
            padding: 1.65rem;
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.4rem;
        }

        .stat-icon-primary { background: linear-gradient(135deg, #4f6ef2 0%, #7f8df7 100%); }
        .stat-icon-success { background: linear-gradient(135deg, #47b9a3 0%, #6cd3b7 100%); }
        .stat-icon-info { background: linear-gradient(135deg, #46a8f0 0%, #74c0fb 100%); }
        .stat-icon-muted { background: linear-gradient(135deg, #6b7a9c 0%, #9ca7c2 100%); }

        .stat-label {
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--text-muted);
            font-weight: 700;
        }

        .stat-value {
            display: block;
            font-size: 1.9rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0.2rem 0;
        }

        .stat-hint {
            font-size: 0.9rem;
            color: var(--text-mid);
        }

        .empty-state {
            margin: 0 2.75rem 2.75rem;
            padding: 2.75rem 2rem;
            border-radius: 20px;
            border: 1px dashed rgba(79, 110, 242, 0.35);
            background: var(--panel-alt);
            text-align: center;
            color: var(--text-mid);
        }

        .empty-icon {
            width: 72px;
            height: 72px;
            border-radius: 18px;
            background: rgba(79, 110, 242, 0.12);
            color: var(--primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }

        .empty-state h4 {
            margin: 0 0 0.5rem;
            color: var(--text-dark);
            font-size: 1.35rem;
        }

        .btn-empty-cta {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.7rem 1.4rem;
            border-radius: 999px;
            background: var(--primary);
            color: #fff;
            font-weight: 600;
            text-decoration: none;
        }

        .issuance-shell {
            margin: 0 2.75rem 2.75rem;
            background: var(--panel);
            border-radius: 22px;
            border: 1px solid var(--border);
            box-shadow: 0 22px 55px -36px rgba(15, 23, 42, 0.35);
            padding: 2.5rem;
        }

        .form-heading {
            display: flex;
            justify-content: space-between;
            gap: 1.75rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        .form-eyebrow {
            display: inline-flex;
            padding: 0.3rem 0.8rem;
            border-radius: 999px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 0.75rem;
            background: rgba(79, 110, 242, 0.16);
            color: var(--primary);
            font-weight: 700;
        }

        .form-heading h3 {
            margin: 0.5rem 0 0.6rem;
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .form-heading p {
            margin: 0;
            color: var(--text-mid);
            line-height: 1.5;
        }

        .form-hint-box {
            display: inline-flex;
            align-items: flex-start;
            gap: 0.6rem;
            padding: 1rem 1.2rem;
            border-radius: 16px;
            background: rgba(79, 110, 242, 0.08);
            border: 1px solid rgba(79, 110, 242, 0.18);
            color: var(--text-mid);
            flex: 1;
            max-width: 320px;
        }

        .form-hint-box i {
            color: var(--primary);
            font-size: 1.1rem;
            margin-top: 0.2rem;
        }

        .issuance-form {
            display: flex;
            flex-direction: column;
        }

        .form-columns {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
        }

        .form-panel {
            background: var(--panel-alt);
            border-radius: 18px;
            padding: 1.9rem 1.8rem;
            border: 1px solid rgba(79, 110, 242, 0.12);
        }

        .panel-header {
            display: flex;
            align-items: flex-start;
            gap: 0.85rem;
            margin-bottom: 1.5rem;
        }

        .panel-header i {
            color: var(--primary);
            font-size: 1.3rem;
        }

        .panel-header h4 {
            margin: 0;
            color: var(--text-dark);
            font-weight: 700;
        }

        .panel-header p {
            margin: 0.35rem 0 0;
            color: var(--text-muted);
            font-size: 0.88rem;
        }

        .form-group {
            margin-bottom: 1.4rem;
        }

        .form-label {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.55rem;
        }

        .form-label i {
            color: var(--text-muted);
        }

        .form-select,
        .form-control {
            width: 100%;
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            color: var(--text-mid);
            background: #fff;
            transition: border-color 0.25s ease, box-shadow 0.25s ease;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 110, 242, 0.12);
        }

        .radio-group {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .radio-card {
            flex: 1 1 140px;
            cursor: pointer;
        }

        .radio-card input {
            display: none;
        }

        .radio-content {
            background: #fff;
            border: 2px solid var(--border);
            border-radius: 14px;
            padding: 1.4rem 1rem;
            text-align: center;
            transition: all 0.25s ease;
        }

        .radio-content i {
            font-size: 1.5rem;
            color: var(--text-muted);
            display: block;
            margin-bottom: 0.45rem;
        }

        .radio-content span {
            font-weight: 600;
            color: var(--text-mid);
        }

        .radio-card input:checked + .radio-content {
            border-color: var(--primary);
            background: rgba(79, 110, 242, 0.05);
        }

        .radio-card input:checked + .radio-content i,
        .radio-card input:checked + .radio-content span {
            color: var(--primary);
        }

        .recipient-fields {
            margin-top: 1.6rem;
        }

        .recipient-field {
            display: none;
        }

        .recipient-field.is-visible {
            display: block;
        }

        .quantity-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1.2rem;
        }

        .quantity-input {
            display: flex;
            align-items: center;
            border: 2px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
        }

        .quantity-btn {
            background: var(--panel-alt);
            border: none;
            width: 44px;
            height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.1rem;
            color: var(--text-muted);
            transition: background 0.2s ease, color 0.2s ease;
        }

        .quantity-btn:hover {
            background: var(--primary);
            color: #ffffff;
        }

        .quantity-input input {
            border: none;
            text-align: center;
            width: 100%;
            padding: 0.75rem;
            font-weight: 600;
            color: var(--text-mid);
        }

        .quantity-input input:focus {
            outline: none;
        }

        .stock-info {
            background: #fff;
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
        }

        .stock-display span {
            display: block;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--success);
        }

        .stock-display span.low-stock {
            color: #e9635a;
        }

        .stock-display small {
            color: var(--text-muted);
        }

        .error-message {
            display: flex;
            align-items: center;
            gap: 0.45rem;
            margin-top: 0.45rem;
            color: #e9635a;
            font-size: 0.85rem;
        }

        .form-control.error {
            border-color: #e9635a;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2.5rem;
        }

        .btn {
            padding: 0.85rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 18px 40px -28px rgba(79, 110, 242, 0.6);
        }

        .btn-primary:hover {
            background: #3f59d6;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: var(--panel-alt);
            color: var(--text-mid);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: #fff;
            transform: translateY(-2px);
        }

        @media (max-width: 992px) {
            .dashboard-banner {
                padding: 2.25rem 2.25rem 2rem;
            }

            .overview-stats {
                padding: 1.75rem 2.25rem 2rem;
            }

            .issuance-shell {
                padding: 2.25rem;
                margin: 0 2.25rem 2.25rem;
            }
        }

        @media (max-width: 768px) {
            .dashboard-banner {
                padding: 2rem 1.75rem 1.75rem;
            }

            .overview-stats {
                padding: 1.6rem 1.75rem 1.6rem;
            }

            .issuance-shell {
                padding: 1.85rem;
                margin: 0 1.75rem 1.85rem;
            }

            .form-heading {
                flex-direction: column;
            }

            .form-hint-box {
                max-width: 100%;
            }
        }

        @media (max-width: 576px) {
            .issue-dashboard {
                border-radius: 20px;
            }

            .dashboard-banner,
            .overview-stats {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }

            .issuance-shell {
                margin: 0 1.5rem 1.75rem;
            }
        }
    </style>
@endsection

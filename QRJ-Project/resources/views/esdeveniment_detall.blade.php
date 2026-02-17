<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $esdeveniment->Nom }} - La Salle Mollerussa</title>
    @vite(['resources/css/esdeveniment_detall.css'])
</head>

<body>
    <div class="desktop-wrapper">
        <div class="main-container">
            <div class="left-panel">
                <div class="brand-content">
                    <h1 class="main-title">LA SALLE <img src="{{ asset('estrella.png') }}" class="floating-star"
                            alt="★"></h1>
                    <h1 class="main-title">MOLLERUSSA</h1>
                    <h2 class="admin-subtitle">DETALL ESDEVENIMENT</h2>
                </div>
            </div>

            <div class="right-panel">
                <div class="content-box">
                    <!-- Event Info Section -->
                    <div class="event-info-section">
                        <h1 class="page-title">{{ $esdeveniment->Nom }}</h1>

                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">📅 Data:</span>
                                <span
                                    class="info-value">{{ \Carbon\Carbon::parse($esdeveniment->Data_Esdeveniment)->format('d/m/Y') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">🕐 Hora:</span>
                                <span
                                    class="info-value">{{ \Carbon\Carbon::parse($esdeveniment->Hora_Inici)->format('H:i') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">📍 Ubicació:</span>
                                <span class="info-value">{{ $esdeveniment->Ubicacio }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">👥 Invitats:</span>
                                <span class="info-value">{{ $esdeveniment->{'Nº_Invitats'} }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">⏰ Límit confirmació:</span>
                                <span
                                    class="info-value">{{ \Carbon\Carbon::parse($esdeveniment->Data_Limit_Confirmacio)->format('d/m/Y') }}</span>
                            </div>
                            @if($isAdmin)
                                <div class="info-item"
                                    x-data="{ editing: false, value: {{ $esdeveniment->max_qrs_per_usuari }} }">
                                    <span class="info-label">🎫 Màxim QRs/usuari:</span>
                                    <div class="info-value" style="display: flex; align-items: center; gap: 0.5rem;">
                                        <span x-show="!editing" x-text="value"></span>
                                        <input x-show="editing" type="number" x-model="value" min="1"
                                            style="width: 70px; padding: 0.25rem; border: 1px solid #ccc; border-radius: 4px;"
                                            @keydown.enter="editing = false; fetch('{{ route('esdeveniment.update', $esdeveniment->id) }}', {
                                                           method: 'POST',
                                                           headers: {
                                                               'Content-Type': 'application/json',
                                                               'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                               'X-HTTP-Method-Override': 'PUT'
                                                           },
                                                           body: JSON.stringify({
                                                               type: '{{ $esdeveniment->Nom }}',
                                                               guests: {{ $esdeveniment->{'Nº_Invitats'} }},
                                                               max_qrs_per_usuari: value,
                                                               location: '{{ $esdeveniment->Ubicacio }}',
                                                               event_date: '{{ \Carbon\Carbon::parse($esdeveniment->Data_Esdeveniment)->format('Y-m-d') }}',
                                                               start_time: '{{ \Carbon\Carbon::parse($esdeveniment->Hora_Inici)->format('H:i') }}',
                                                               confirmation_deadline: '{{ \Carbon\Carbon::parse($esdeveniment->Data_Limit_Confirmacio)->format('Y-m-d') }}'
                                                           })
                                                       }).then(() => location.reload())">
                                        <button @click="editing = !editing" type="button"
                                            style="padding: 0.25rem 0.5rem; border: none; background: #3b82f6; color: white; border-radius: 4px; cursor: pointer; font-size: 0.85rem;"
                                            x-text="editing ? '✓' : '✏️'">
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="info-item">
                                    <span class="info-label">🎫 Màxim QRs/usuari:</span>
                                    <span class="info-value">{{ $esdeveniment->max_qrs_per_usuari }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr style="margin: 2rem 0; border: none; border-top: 2px solid #e5e7eb;">

                    <!-- Participants List Section -->
                    <div class="participants-list-section">
                        <div class="section-header">
                            <h2 class="section-title">Participants</h2>
                            <span class="section-count">
                                {{ $esdeveniment->assistents->count() }} inscrits
                            </span>
                        </div>

                        @if($esdeveniment->assistents->count() > 0)
                            <div class="participants-list">
                                @foreach($esdeveniment->assistents as $assistent)
                                    <div class="participant-card">
                                        <div class="participant-main">
                                            <div class="participant-name">
                                                {{ $assistent->usuari->Nom ?? 'Usuari desconegut' }}
                                            </div>
                                            <div class="participant-email">
                                                {{ $assistent->usuari->Correu ?? $assistent->usuari_correu }}
                                            </div>
                                        </div>
                                        <div class="participant-meta">
                                            <span class="meta-chip">👥 Acompanyants:
                                                {{ $assistent->num_acompanyants_confirmats }}</span>
                                            @if($assistent->confirmat)
                                                <span class="meta-chip meta-confirmed">Confirmat</span>
                                            @else
                                                <span class="meta-chip meta-pending">Pendent</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                Encara no hi ha participants registrats per aquest esdeveniment.
                            </div>
                        @endif
                    </div>

                    <hr style="margin: 2rem 0; border: none; border-top: 2px solid #e5e7eb;">

                    <!-- Participants Section -->
                    <div class="participants-section">
                        <h2 class="section-title">Enviar QR als Participants</h2>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <!-- Filters -->
                        <div class="filters-bar" x-data="{ 
                            searchName: '', 
                            searchEmail: '', 
                            filterCurs: '', 
                            filterQR: '',
                            filterAdmin: ''
                        }">
                            <input type="text" x-model="searchName" placeholder="🔍 Buscar per nom..."
                                class="filter-input">
                            <input type="text" x-model="searchEmail" placeholder="📧 Buscar per email..."
                                class="filter-input">

                            <select x-model="filterCurs" class="filter-select">
                                <option value="">Tots els cursos</option>
                                @foreach($cursos as $curs)
                                    <option value="{{ $curs->id }}">{{ $curs->nombre }}</option>
                                @endforeach
                            </select>

                            <select x-model="filterQR" class="filter-select">
                                <option value="">Estat QR</option>
                                <option value="amb">Amb QR</option>
                                <option value="sense">Sense QR</option>
                            </select>

                            <select x-model="filterAdmin" class="filter-select">
                                <option value="">Tots els usuaris</option>
                                <option value="admin">Només admins</option>
                                <option value="nonadmin">Només alumnes</option>
                            </select>
                        </div>

                        <!-- User List with checkboxes -->
                        <form method="POST" action="{{ route('qr.send.massive') }}" x-data="{ selectedUsers: [] }">
                            @csrf
                            <input type="hidden" name="esdeveniment_id" value="{{ $esdeveniment->ID }}">

                            <div class="users-list">
                                @foreach($users as $user)
                                    <div class="user-item" x-show="
                                                            (searchName === '' || '{{ strtolower($user->Nom) }}'.includes(searchName.toLowerCase())) &&
                                                            (searchEmail === '' || '{{ strtolower($user->Correu) }}'.includes(searchEmail.toLowerCase())) &&
                                                            (filterCurs === '' || '{{ $user->curs_id }}' === filterCurs) &&
                                                            (filterQR === '' || (filterQR === 'amb' && {{ $user->has_qr ? 'true' : 'false' }}) || (filterQR === 'sense' && !{{ $user->has_qr ? 'true' : 'false' }})) &&
                                                            (filterAdmin === '' || (filterAdmin === 'admin' && {{ $user->is_admin ? 'true' : 'false' }}) || (filterAdmin === 'nonadmin' && !{{ $user->is_admin ? 'true' : 'false' }}))
                                                         " x-transition>
                                        <label class="user-label">
                                            <input type="checkbox" name="user_ids[]" value="{{ $user->Correu }}"
                                                x-model="selectedUsers" class="user-checkbox">
                                            <div class="user-info">
                                                <span class="user-name">{{ $user->Nom }}</span>
                                                <span class="user-email">{{ $user->Correu }}</span>
                                                <div class="user-badges">
                                                    @if($user->curs)
                                                        <span class="badge badge-course">{{ $user->curs->nombre }}</span>
                                                    @endif
                                                    @if($user->has_qr)
                                                        <span class="badge badge-qr">✓ QR</span>
                                                    @else
                                                        <span class="badge badge-no-qr">✗ Sense QR</span>
                                                    @endif
                                                    @if($user->is_admin)
                                                        <span class="badge badge-admin">Admin</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="actions-bar">
                                <button type="button"
                                    @click="selectedUsers = $el.closest('form').querySelectorAll('input[type=checkbox]:not([disabled])'); selectedUsers.forEach(cb => cb.checked = true)"
                                    class="btn btn-secondary">
                                    Seleccionar tots
                                </button>
                                <button type="button"
                                    @click="selectedUsers = []; $el.closest('form').querySelectorAll('input[type=checkbox]').forEach(cb => cb.checked = false)"
                                    class="btn btn-secondary">
                                    Desseleccionar tots
                                </button>
                                <button type="submit" class="btn btn-primary"
                                    x-bind:disabled="selectedUsers.length === 0">
                                    Enviar QR (<span x-text="selectedUsers.length"></span>)
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="footer-nav">
                        <a href="{{ route('esdeveniment.index') }}" class="back-link">← Tornar enrere</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="//unpkg.com/alpinejs" defer></script>
</body>

</html>
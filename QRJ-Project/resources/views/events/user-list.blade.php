<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esdeveniments - La Salle Mollerussa</title>
    @vite(['resources/css/esdeveniments.css'])
    <style>
        .status-badge {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
            margin-top: 0.5rem;
        }

        .status-open {
            background-color: #86efac;
            color: #166534;
        }

        .status-closed {
            background-color: #f87171;
            color: #7f1d1d;
        }

        .status-registered {
            background-color: #60a5fa;
            color: #1e3a8a;
        }

        .btn-register {
            display: inline-block;
            background-color: #3b82f6;
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            text-decoration: none;
            margin-top: 0.5rem;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background-color 0.3s;
        }

        .btn-register:hover {
            background-color: #2563eb;
        }

        .btn-register:disabled {
            background-color: #d1d5db;
            cursor: not-allowed;
        }

        .event-item-user {
            padding: 1.5rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: white;
            transition: all 0.3s;
        }

        .event-item-user:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-color: #3b82f6;
        }

        .event-details {
            margin: 1rem 0;
            font-size: 0.9rem;
            color: #666;
        }

        .event-details-item {
            margin: 0.5rem 0;
        }

        .event-details-item strong {
            color: #333;
        }

        .deadline-warning {
            background-color: #fef08a;
            border-left: 4px solid #f59e0b;
            padding: 0.8rem;
            border-radius: 4px;
            margin: 1rem 0;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="desktop-wrapper">
        <div class="main-container">
            <div class="left-panel" id="starContainer">
                <div class="brand-content">
                    <h1 class="main-title">
                        LA SALLE
                        <img src="{{ asset('images/estrella.png') }}" class="floating-star" alt="estrella">
                    </h1>
                    <h1 class="main-title">MOLLERUSSA</h1>
                    <h2 class="admin-subtitle">EVENTS</h2>
                </div>
            </div>

            <div class="right-panel" style="height: 100%; overflow-y: scroll;">
                <div class="menu-box" style="display: flex; flex-direction: column; height: 100%; min-height: 0;">
                    <div style="width: 100%; display: flex; align-items: center; justify-content: space-between; gap: 12px;">
                        <h1 class="page-title-black" style="margin: 0;">EVENTS DISPONIBLES</h1>
                        <a href="{{ route('menu_user') }}" class="back-pill" style="margin: 0;">Tornar al menú</a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success"
                            style="background: #4ade80; color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-error"
                            style="background: #f87171; color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="event-grid-user"
                        style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem;">
                        @if(isset($events) && count($events) > 0)
                            @foreach($events as $event)
                                @php
                                    $assistents = $event->assistents;
                                    $userRegistration = $assistents ? $assistents->firstWhere('usuari_correu', auth()->user()->Correu) : null;
                                    $isRegistered = $userRegistration !== null;
                                    $deadlineDate = $event->Data_Limit_Confirmacio ?? now();
                                    $isDeadlinePassed = now()->isAfter($deadlineDate);
                                    $canRegister = !$isRegistered && !$isDeadlinePassed;
                                @endphp

                                <div class="event-item-user">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <h3 style="margin: 0; color: #1f2937;">{{ $event->Nom ?? 'Sin nombre' }}</h3>
                                        <div class="icon-square">📅</div>
                                    </div>

                                    <div class="event-details">
                                        @if($event->Data_Esdeveniment)
                                            <div class="event-details-item">
                                                <strong>Data:</strong>
                                                {{ \Carbon\Carbon::parse($event->Data_Esdeveniment)->format('d/m/Y') }}
                                            </div>
                                        @endif
                                        @if($event->Hora_Inici)
                                            <div class="event-details-item">
                                                <strong>Hora:</strong>
                                                {{ \Carbon\Carbon::parse($event->Hora_Inici)->format('H:i') }}
                                            </div>
                                        @endif
                                        <div class="event-details-item">
                                            <strong>Ubicació:</strong>
                                            {{ $event->Ubicacio ?? 'No especificada' }}
                                        </div>
                                        <div class="event-details-item">
                                            <strong>Tipus:</strong>
                                            {{ $event->Tipus ?? 'Sense especificar' }}
                                        </div>
                                        @if($event->Data_Limit_Confirmacio)
                                            <div class="event-details-item">
                                                <strong>Límit confirmació:</strong>
                                                {{ \Carbon\Carbon::parse($event->Data_Limit_Confirmacio)->format('d/m/Y') }}
                                            </div>
                                        @endif
                                    </div>

                                    @if($isDeadlinePassed)
                                        <span class="status-badge status-closed">Registracions tancades</span>
                                    @elseif($isRegistered)
                                        <span class="status-badge status-registered">Registrat ✓</span>
                                    @else
                                        <span class="status-badge status-open">Oberta per a registre</span>
                                    @endif

                                    @if($isRegistered && $userRegistration)
                                        <div style="margin-top: 1rem; font-size: 0.85rem; color: #059669;">
                                            <strong>Registrat el:</strong>
                                            {{ $userRegistration->data_confirmacio ? $userRegistration->data_confirmacio->format('d/m/Y H:i') : 'Pendent confirmació' }}
                                        </div>
                                    @endif

                                    @if($canRegister)
                                        <a href="{{ route('events.user-register', $event->id) }}" class="btn-register">
                                            Apunta't a l'event
                                        </a>
                                    @elseif(!$isRegistered && $isDeadlinePassed)
                                        <button class="btn-register" disabled>
                                            Registracions tancades
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div style="grid-column: 1 / -1; text-align: center; padding: 2rem; color: #666;">
                                <p>No hi ha events disponibles en aquest moment</p>
                            </div>
                        @endif
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/esdeveniments.js') }}"></script>
</body>

</html>
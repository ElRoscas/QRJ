<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registre Event - La Salle Mollerussa</title>
    @vite(['resources/css/esdeveniments.css'])
    <style>
        .form-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            max-width: 600px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #1f2937;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 1rem;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .info-box {
            background: #f0f9ff;
            border-left: 4px solid #0284c7;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: #0c4a6e;
        }

        .deadline-warning {
            background-color: #fef08a;
            border-left: 4px solid #f59e0b;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: #92400e;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            flex: 1;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .btn-secondary {
            background-color: #e5e7eb;
            color: #1f2937;
        }

        .btn-secondary:hover {
            background-color: #d1d5db;
        }

        .event-info-card {
            background: #f9fafb;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border: 1px solid #e5e7eb;
        }

        .event-info-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .event-info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .event-info-item strong {
            color: #1f2937;
        }

        .event-info-item span {
            color: #6b7280;
        }

        .error-message {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #dc2626;
        }

        .success-message {
            background-color: #dcfce7;
            color: #166534;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #16a34a;
        }

        .companion-info {
            background: #f3f4f6;
            padding: 1rem;
            border-radius: 6px;
            margin-top: 0.5rem;
            font-size: 0.85rem;
            color: #4b5563;
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
                    <h2 class="admin-subtitle">REGISTRE EVENT</h2>
                </div>
            </div>

            <div class="right-panel">
                <div class="menu-box">
                    <h1 class="page-title-black">{{ $event->Nom }}</h1>

                    @if(session('error'))
                        <div class="error-message">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="success-message">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="form-container">
                        <!-- Event Information Card -->
                        <div class="event-info-card">
                            <div class="event-info-item">
                                <strong>Data:</strong>
                                <span>{{ \Carbon\Carbon::parse($event->Data_Esdeveniment ?? now())->format('d/m/Y') }}</span>
                            </div>
                            <div class="event-info-item">
                                <strong>Hora:</strong>
                                <span>{{ \Carbon\Carbon::parse($event->Hora_Inici ?? now())->format('H:i') }}</span>
                            </div>
                            <div class="event-info-item">
                                <strong>Ubicació:</strong>
                                <span>{{ $event->Ubicacio ?? 'No especificada' }}</span>
                            </div>
                            <div class="event-info-item">
                                <strong>Tipus:</strong>
                                <span>{{ $event->Tipus ?? 'Sense especificar' }}</span>
                            </div>
                            <div class="event-info-item">
                                <strong>Límit confirmació:</strong>
                                <span>{{ \Carbon\Carbon::parse($event->Data_Limit_Confirmacio ?? now())->format('d/m/Y') }}</span>
                            </div>
                            <div class="event-info-item">
                                <strong>Max. acompanyants:</strong>
                                <span>{{ $event->capacitat_max_acompanyants ?? 2 }}</span>
                            </div>
                        </div>

                        @if($isDeadlinePassed)
                            <div class="deadline-warning">
                                ⚠️ El termini de registre per a aquest event ha tancat.
                            </div>
                        @else
                            <div class="info-box">
                                ℹ️ Si vols assistir a aquest event, completa el formulari de registre. Pots portar fins a
                                <strong>{{ $event->capacitat_max_acompanyants }}</strong> acompanyants.
                            </div>

                            <form action="{{ route('events.store-registration', $event->id) }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="num_acompanyants">Nombre d'acompanyants que vindran:</label>
                                    <input type="number" id="num_acompanyants" name="num_acompanyants" min="0"
                                        max="{{ $event->capacitat_max_acompanyants }}" value="0" required>
                                    <div class="companion-info">
                                        Pots traure entre 0 i {{ $event->capacitat_max_acompanyants }} persones amb tu.
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="notes">Observacions (opcional):</label>
                                    <textarea id="notes" name="notes"
                                        placeholder="Afegeix qualsevol comentari o detall addicional..."></textarea>
                                </div>

                                @if($errors->any())
                                    <div class="error-message">
                                        <strong>Errors:</strong>
                                        <ul style="margin: 0.5rem 0 0 1.5rem; padding: 0;">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="button-group">
                                    <a href="{{ route('events.user-list') }}" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-primary">Confirmar registre</button>
                                </div>
                            </form>
                        @endif

                        @if($isDeadlinePassed)
                            <div class="button-group" style="margin-top: 1.5rem;">
                                <a href="{{ route('events.user-list') }}" class="btn btn-secondary" style="flex: 1;">Tornar
                                    a events</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
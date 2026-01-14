<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $esdevenimentId ? 'Editar' : 'Crear' }} Esdeveniment - La Salle Mollerussa</title>

    <link rel="stylesheet" href="{{ asset('css/crear_esdeveniments.css') }}">
</head>
<body>
    <div class="desktop-wrapper">
        <div class="main-container">
            <div class="left-panel" id="starContainer">
                <div class="brand-content">
                    <h1 class="main-title">
                        LA SALLE 
                        <img src="{{ asset('estrella.png') }}" class="floating-star" alt="★">
                    </h1>
                    <h1 class="main-title">MOLLERUSSA</h1>
                    <h2 class="admin-subtitle">ADMINISTRADOR D'ESDEVENIMENTS</h2>
                </div>
            </div>

            <div class="right-panel scrollable">
                <div class="form-box">
                    <h1 class="form-heading-black">
                        {{ $esdevenimentId ? 'EDITAR' : 'CREAR' }}<br>ESDEVENIMENTS
                    </h1>
                    
                    <form wire:submit="save">
                        <div class="space-y-6">
                            <flux:input 
                                wire:model="nom" 
                                label="Nom de l'esdeveniment" 
                                placeholder="Ex: Conferència de tecnologia 2026"
                                required 
                            />

                            <flux:textarea 
                                wire:model="descripcio" 
                                label="Descripció" 
                                rows="4"
                                placeholder="Descriu l'esdeveniment..."
                                required 
                            />

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <flux:input 
                                    wire:model="data" 
                                    label="Data i hora" 
                                    type="datetime-local" 
                                    required 
                                />

                                <flux:input 
                                    wire:model="lloc" 
                                    label="Lloc" 
                                    placeholder="Ex: Centre de convencions"
                                    required 
                                />
                            </div>

                            <flux:input 
                                wire:model="capacitat" 
                                label="Capacitat màxima (Invitats)" 
                                type="number" 
                                min="1"
                                placeholder="100"
                                required 
                            />

                            <flux:select wire:model="tipus" label="Tipus d'esdeveniment">
                                <option value="">Selecciona un tipus</option>
                                <option value="conferencia">Conferència</option>
                                <option value="taller">Taller</option>
                                <option value="festa">Festa</option>
                                <option value="altres">Altres</option>
                            </flux:select>

                            <flux:checkbox wire:model="es_public" label="Esdeveniment públic" />

                            <div class="flex flex-col gap-3 mt-4">
                                <flux:button type="submit" variant="primary" class="save-btn-custom">
                                    {{ $esdevenimentId ? 'Actualitzar' : 'Crear' }} Esdeveniment
                                </flux:button>

                                <flux:button type="button" href="{{ route('esdeveniments.llistar') }}" variant="ghost">
                                    Cancel·lar / Tornar enrere
                                </flux:button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:navigated', () => {
            const container = document.getElementById('starContainer');
            if (container) {
                container.querySelectorAll('.bg-star').forEach(el => el.remove());
                for (let i = 0; i < 20; i++) {
                    const star = document.createElement('div');
                    star.innerHTML = '★';
                    star.className = 'bg-star';
                    star.style.left = Math.random() * 100 + '%';
                    star.style.top = Math.random() * 100 + '%';
                    star.style.fontSize = (Math.random() * 20 + 10) + 'px';
                    star.style.position = 'absolute';
                    star.style.color = 'rgba(255, 255, 255, 0.15)';
                    container.appendChild(star);
                }
            }
        });
    </script>
</body>
</html>
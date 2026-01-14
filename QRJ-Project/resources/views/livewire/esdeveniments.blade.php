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
            <div class="menu-box">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="page-title-black">ELS MEUS ESDEVENIMENTS</h1>
                    <flux:button href="{{ route('esdeveniments.crear') }}" variant="primary" class="save-btn-flux">
                        + Crear
                    </flux:button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($esdeveniments as $esdeveniment)
                        <flux:card class="custom-card-salle">
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    {{-- Icona dinàmica segons tipus (opcional) --}}
                                    <div class="icon-square-sm">📅</div>
                                    <flux:heading size="md">{{ $esdeveniment->nom }}</flux:heading>
                                </div>
                                
                                <flux:text class="text-xs line-clamp-2">
                                    {{ Str::limit($esdeveniment->descripcio, 80) }}
                                </flux:text>
                                
                                <div class="space-y-1 border-t border-gray-100 pt-2">
                                    <flux:text class="text-xs">
                                        <strong>Data:</strong> {{ $esdeveniment->data->format('d/m/Y H:i') }}
                                    </flux:text>
                                    <flux:text class="text-xs">
                                        <strong>Lloc:</strong> {{ $esdeveniment->lloc }}
                                    </flux:text>
                                    <flux:text class="text-xs">
                                        <strong>Ocupació:</strong> {{ $esdeveniment->assistents_confirmats }}/{{ $esdeveniment->capacitat }}
                                    </flux:text>
                                </div>

                                <div class="flex gap-2 pt-2">
                                    <flux:button wire:click="veureEsdeveniment({{ $esdeveniment->id }})" size="sm" class="flex-1">
                                        Detalls
                                    </flux:button>
                                    
                                    <flux:button wire:click="editarEsdeveniment({{ $esdeveniment->id }})" variant="ghost" size="sm">
                                        Editar
                                    </flux:button>
                                </div>
                            </div>
                        </flux:card>
                    @empty
                        <div class="col-span-full py-12 text-center">
                            <flux:text>No tens cap esdeveniment creat encara.</flux:text>
                        </div>
                    @endforelse
                </div>

                @if($esdeveniments->hasPages())
                    <div class="mt-6">
                        {{ $esdeveniments->links() }}
                    </div>
                @endif

                <div class="footer-nav mt-8">
                    <a href="{{ route('menu_admin') }}" class="back-pill"> < Tornar al Menú</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script per a l'efecte d'estrelles --}}
@push('scripts')
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
@endpush
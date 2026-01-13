<div>
    <div class="flex justify-between items-center mb-6">
        <flux:heading size="lg">Esdeveniments</flux:heading>
        
        <div class="flex gap-3">
            <flux:input 
                wire:model.live="search" 
                type="search" 
                placeholder="Cercar esdeveniments..."
            />
            
            <flux:button href="{{ route('esdeveniments.crear') }}" variant="primary">
                Crear Esdeveniment
            </flux:button>
        </div>
    </div>

    <flux:tabs class="mb-6">
        <flux:tab wire:click="$set('filtre', 'tots')" :active="$filtre === 'tots'">Tots</flux:tab>
        <flux:tab wire:click="$set('filtre', 'meus')" :active="$filtre === 'meus'">Els meus</flux:tab>
        <flux:tab wire:click="$set('filtre', 'propers')" :active="$filtre === 'propers'">Propers</flux:tab>
        <flux:tab wire:click="$set('filtre', 'passats')" :active="$filtre === 'passats'">Passats</flux:tab>
    </flux:tabs>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($esdeveniments as $esdeveniment)
            <flux:card>
                <div class="space-y-4">
                    <div class="flex justify-between items-start">
                        <flux:heading size="md">{{ $esdeveniment->nom }}</flux:heading>
                        
                        @if($esdeveniment->es_public)
                            <flux:badge variant="success">Públic</flux:badge>
                        @else
                            <flux:badge variant="neutral">Privat</flux:badge>
                        @endif
                    </div>
                    
                    <flux:text>{{ Str::limit($esdeveniment->descripcio, 100) }}</flux:text>
                    
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-sm">
                            <flux:icon name="calendar" size="sm" />
                            <flux:text>{{ $esdeveniment->data->format('d/m/Y H:i') }}</flux:text>
                        </div>
                        
                        <div class="flex items-center gap-2 text-sm">
                            <flux:icon name="map-pin" size="sm" />
                            <flux:text>{{ $esdeveniment->lloc }}</flux:text>
                        </div>
                        
                        <div class="flex items-center gap-2 text-sm">
                            <flux:icon name="users" size="sm" />
                            <flux:text>{{ $esdeveniment->assistents_confirmats }}/{{ $esdeveniment->capacitat }}</flux:text>
                        </div>

                        @if($esdeveniment->tipus)
                            <div class="flex items-center gap-2 text-sm">
                                <flux:icon name="tag" size="sm" />
                                <flux:text>{{ ucfirst($esdeveniment->tipus) }}</flux:text>
                            </div>
                        @endif
                    </div>

                    <div class="flex gap-2 pt-2">
                        <flux:button 
                            href="{{ route('esdeveniments.veure', $esdeveniment) }}" 
                            size="sm"
                            class="flex-1"
                        >
                            Veure Detalls
                        </flux:button>
                        
                        @if($esdeveniment->organitzador_id === auth()->id())
                            <flux:button 
                                href="{{ route('esdeveniments.editar', $esdeveniment) }}" 
                                variant="ghost" 
                                size="sm"
                            >
                                Editar
                            </flux:button>
                        @endif
                    </div>
                </div>
            </flux:card>
        @empty
            <flux:card class="col-span-full">
                <div class="text-center py-8">
                    <flux:text>No s'han trobat esdeveniments</flux:text>
                </div>
            </flux:card>
        @endforelse
    </div>

    @if($esdeveniments->hasPages())
        <div class="mt-6">
            {{ $esdeveniments->links() }}
        </div>
    @endif
</div>

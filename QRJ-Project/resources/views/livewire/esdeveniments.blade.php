<div>
    <div class="flex justify-between items-center mb-6">
        <flux:heading size="lg">Els meus Esdeveniments</flux:heading>
        <flux:button href="{{ route('esdeveniments.crear') }}" variant="primary">
            Crear Esdeveniment
        </flux:button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($esdeveniments as $esdeveniment)
            <flux:card>
                <div class="space-y-4">
                    <flux:heading size="md">{{ $esdeveniment->nom }}</flux:heading>
                    
                    <flux:text>{{ Str::limit($esdeveniment->descripcio, 100) }}</flux:text>
                    
                    <div class="space-y-2">
                        <flux:text class="text-sm">
                            <strong>Data:</strong> {{ $esdeveniment->data->format('d/m/Y H:i') }}
                        </flux:text>
                        
                        <flux:text class="text-sm">
                            <strong>Lloc:</strong> {{ $esdeveniment->lloc }}
                        </flux:text>
                        
                        <flux:text class="text-sm">
                            <strong>Capacitat:</strong> {{ $esdeveniment->assistents_confirmats }}/{{ $esdeveniment->capacitat }}
                        </flux:text>
                    </div>

                    <div class="flex gap-2">
                        <flux:button wire:click="veurEsdeveniment({{ $esdeveniment->id }})" size="sm">
                            Veure Detalls
                        </flux:button>
                        
                        <flux:button wire:click="editarEsdeveniment({{ $esdeveniment->id }})" variant="ghost" size="sm">
                            Editar
                        </flux:button>
                    </div>
                </div>
            </flux:card>
        @empty
            <flux:card class="col-span-full">
                <div class="text-center py-8">
                    <flux:text>No tens cap esdeveniment creat</flux:text>
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

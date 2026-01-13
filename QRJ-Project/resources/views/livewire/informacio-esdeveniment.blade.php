<div>
    @if($esdeveniment)
        <div class="flex justify-between items-start mb-6">
            <flux:heading size="lg">{{ $esdeveniment->nom }}</flux:heading>
            
            @if($esdeveniment->organitzador_id === auth()->id())
                <flux:button href="{{ route('esdeveniments.editar', $esdeveniment) }}" variant="ghost">
                    Editar
                </flux:button>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <flux:card>
                    <flux:heading size="md">Descripció</flux:heading>
                    <flux:text class="mt-4">{{ $esdeveniment->descripcio }}</flux:text>
                </flux:card>

                <flux:card>
                    <flux:heading size="md">Detalls</flux:heading>
                    
                    <div class="mt-4 space-y-3">
                        <div class="flex items-center gap-2">
                            <flux:icon name="calendar" />
                            <flux:text>{{ $esdeveniment->data->format('d/m/Y H:i') }}</flux:text>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <flux:icon name="map-pin" />
                            <flux:text>{{ $esdeveniment->lloc }}</flux:text>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <flux:icon name="users" />
                            <flux:text>{{ $esdeveniment->assistents_confirmats }}/{{ $esdeveniment->capacitat }} assistents</flux:text>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <flux:icon name="user" />
                            <flux:text>Organitzador: {{ $esdeveniment->organitzador->name }}</flux:text>
                        </div>
                    </div>
                </flux:card>

                @if($esdeveniment->organitzador_id === auth()->id())
                    <flux:card>
                        <flux:heading size="md">Assistents Confirmats</flux:heading>
                        
                        <div class="mt-4 space-y-2">
                            @forelse($esdeveniment->assistents as $assistent)
                                <div class="flex items-center justify-between py-2 border-b">
                                    <flux:text>{{ $assistent->name }}</flux:text>
                                    <flux:text class="text-sm text-gray-500">{{ $assistent->email }}</flux:text>
                                </div>
                            @empty
                                <flux:text>Encara no hi ha assistents confirmats</flux:text>
                            @endforelse
                        </div>
                    </flux:card>
                @endif
            </div>

            <div class="space-y-6">
                <flux:card>
                    <div class="text-center space-y-4">
                        @if($qrCode)
                            <div class="p-4 bg-white rounded-lg inline-block">
                                {!! $qrCode !!}
                            </div>
                            
                            <flux:button wire:click="downloadQR" variant="primary" class="w-full">
                                Descarregar QR
                            </flux:button>
                        @endif
                    </div>
                </flux:card>

                @if($esdeveniment->organitzador_id === auth()->id())
                    <flux:card>
                        <flux:heading size="md">Accions</flux:heading>
                        
                        <div class="mt-4 space-y-2">
                            <flux:button wire:click="enviarInvitacions" variant="primary" class="w-full">
                                Enviar Invitacions
                            </flux:button>
                            
                            <flux:button wire:click="eliminarEsdeveniment" variant="danger" class="w-full">
                                Eliminar Esdeveniment
                            </flux:button>
                        </div>
                    </flux:card>
                @endif
            </div>
        </div>
    @else
        <flux:card>
            <div class="text-center py-8">
                <flux:text>Esdeveniment no trobat</flux:text>
            </div>
        </flux:card>
    @endif
</div>

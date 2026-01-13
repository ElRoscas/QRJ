<div>
    <flux:heading size="lg">Les meves Invitacions</flux:heading>

    <flux:tabs class="mt-6">
        <flux:tab name="pendents">Pendents</flux:tab>
        <flux:tab name="acceptades">Acceptades</flux:tab>
        <flux:tab name="rebutjades">Rebutjades</flux:tab>
    </flux:tabs>

    <div class="mt-6 space-y-4">
        @forelse($invitacions as $invitacio)
            <flux:card>
                <div class="flex justify-between items-start">
                    <div class="space-y-2 flex-1">
                        <flux:heading size="md">{{ $invitacio->esdeveniment->nom }}</flux:heading>
                        
                        <flux:text>{{ $invitacio->esdeveniment->descripcio }}</flux:text>
                        
                        <div class="space-y-1">
                            <flux:text class="text-sm">
                                <strong>Data:</strong> {{ $invitacio->esdeveniment->data->format('d/m/Y H:i') }}
                            </flux:text>
                            
                            <flux:text class="text-sm">
                                <strong>Lloc:</strong> {{ $invitacio->esdeveniment->lloc }}
                            </flux:text>
                            
                            <flux:text class="text-sm">
                                <strong>Organitzador:</strong> {{ $invitacio->esdeveniment->organitzador->name }}
                            </flux:text>
                        </div>

                        @if($invitacio->estat === 'pendent')
                            <div class="flex gap-2 mt-4">
                                <flux:button wire:click="acceptarInvitacio({{ $invitacio->id }})" variant="primary" size="sm">
                                    Acceptar
                                </flux:button>
                                
                                <flux:button wire:click="rebutjarInvitacio({{ $invitacio->id }})" variant="danger" size="sm">
                                    Rebutjar
                                </flux:button>
                            </div>
                        @else
                            <flux:badge variant="{{ $invitacio->estat === 'acceptada' ? 'success' : 'danger' }}">
                                {{ ucfirst($invitacio->estat) }}
                            </flux:badge>
                        @endif
                    </div>
                </div>
            </flux:card>
        @empty
            <flux:card>
                <div class="text-center py-8">
                    <flux:text>No tens invitacions {{ $estatActual }}</flux:text>
                </div>
            </flux:card>
        @endforelse
    </div>

    @if($invitacions->hasPages())
        <div class="mt-6">
            {{ $invitacions->links() }}
        </div>
    @endif
</div>

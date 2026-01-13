<div>
    <flux:heading size="lg">Codi QR</flux:heading>
    
    <div class="mt-6">
        @if($qrCode)
            <flux:card>
                <div class="flex flex-col items-center space-y-4">
                    <div class="p-4 bg-white rounded-lg">
                        {!! $qrCode !!}
                    </div>
                    
                    <flux:subheading>{{ $eventName }}</flux:subheading>
                    
                    <div class="text-center">
                        <flux:text>Escaneja aquest codi per accedir a l'esdeveniment</flux:text>
                    </div>

                    <flux:button wire:click="downloadQR" variant="primary">
                        Descarregar QR
                    </flux:button>
                </div>
            </flux:card>
        @else
            <flux:card>
                <div class="text-center py-8">
                    <flux:text>No s'ha trobat cap codi QR</flux:text>
                </div>
            </flux:card>
        @endif
    </div>
</div>

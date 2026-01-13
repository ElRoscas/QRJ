<div>
    <flux:heading size="lg">{{ $esdevenimentId ? 'Editar Esdeveniment' : 'Crear Nou Esdeveniment' }}</flux:heading>

    <flux:card class="mt-6">
        <form wire:submit="save">
            <div class="space-y-6">
                <flux:input 
                    wire:model="nom" 
                    label="Nom de l'esdeveniment" 
                    type="text" 
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
                        type="text" 
                        placeholder="Ex: Centre de convencions"
                        required 
                    />
                </div>

                <flux:input 
                    wire:model="capacitat" 
                    label="Capacitat màxima" 
                    type="number" 
                    min="1"
                    placeholder="100"
                    required 
                />

                <flux:select wire:model="tipus" label="Tipus d'esdeveniment">
                    <option value="">Selecciona un tipus</option>
                    <option value="conferencia">Conferència</option>
                    <option value="taller">Taller</option>
                    <option value="networking">Networking</option>
                    <option value="festa">Festa</option>
                    <option value="esportiu">Esportiu</option>
                    <option value="cultural">Cultural</option>
                    <option value="altres">Altres</option>
                </flux:select>

                <flux:checkbox wire:model="es_public" label="Esdeveniment públic" />

                <div class="flex gap-3">
                    <flux:button type="submit" variant="primary">
                        {{ $esdevenimentId ? 'Actualitzar' : 'Crear' }} Esdeveniment
                    </flux:button>

                    <flux:button type="button" href="{{ route('esdeveniments.llistar') }}" variant="ghost">
                        Cancel·lar
                    </flux:button>
                </div>
            </div>
        </form>
    </flux:card>
</div>

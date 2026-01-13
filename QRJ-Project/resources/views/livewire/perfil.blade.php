<div>
    <flux:heading size="lg">El meu Perfil</flux:heading>
    
    <div class="mt-6 space-y-6">
        <flux:card>
            <form wire:submit="updateProfile">
                <div class="space-y-4">
                    <flux:heading size="md">Informació Personal</flux:heading>
                    
                    <flux:input wire:model="name" label="Nom" type="text" />
                    
                    <flux:input wire:model="email" label="Correu electrònic" type="email" />
                    
                    <flux:button type="submit" variant="primary">
                        Actualitzar Perfil
                    </flux:button>
                </div>
            </form>
        </flux:card>

        <flux:card>
            <form wire:submit="updatePassword">
                <div class="space-y-4">
                    <flux:heading size="md">Canviar Contrasenya</flux:heading>
                    
                    <flux:input wire:model="current_password" label="Contrasenya actual" type="password" />
                    
                    <flux:input wire:model="password" label="Nova contrasenya" type="password" />
                    
                    <flux:input wire:model="password_confirmation" label="Confirma la nova contrasenya" type="password" />
                    
                    <flux:button type="submit" variant="primary">
                        Actualitzar Contrasenya
                    </flux:button>
                </div>
            </form>
        </flux:card>

        <flux:card>
            <div class="space-y-4">
                <flux:heading size="md">Eliminar Compte</flux:heading>
                
                <flux:text>Una vegada eliminat el teu compte, tots els recursos i dades s'esborraran permanentment.</flux:text>
                
                <flux:button wire:click="deleteAccount" variant="danger">
                    Eliminar Compte
                </flux:button>
            </div>
        </flux:card>
    </div>
</div>

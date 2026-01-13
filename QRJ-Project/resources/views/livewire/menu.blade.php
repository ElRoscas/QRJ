<flux:navlist>
    <flux:navlist.item icon="layout-grid" href="{{ route('dashboard') }}" :current="request()->routeIs('dashboard')">
        Tauler
    </flux:navlist.item>

    <flux:navlist.group heading="Esdeveniments" expandable>
        <flux:navlist.item icon="folder-git-2" href="{{ route('esdeveniments.llistar') }}" :current="request()->routeIs('esdeveniments.llistar')">
            Els meus esdeveniments
        </flux:navlist.item>
        
        <flux:navlist.item icon="book-open-text" href="{{ route('esdeveniments.crear') }}" :current="request()->routeIs('esdeveniments.crear')">
            Crear esdeveniment
        </flux:navlist.item>
    </flux:navlist.group>

    <flux:navlist.group heading="Invitacions" expandable>
        <flux:navlist.item icon="chevrons-up-down" href="{{ route('invitacions.index') }}" :current="request()->routeIs('invitacions.index')">
            Les meves invitacions
        </flux:navlist.item>
    </flux:navlist.group>

    <flux:navlist.item icon="user" href="{{ route('perfil') }}" :current="request()->routeIs('perfil')">
        Perfil
    </flux:navlist.item>

    <flux:navlist.item icon="log-out" wire:click="logout">
        Tancar sessió
    </flux:navlist.item>
</flux:navlist>

<!DOCTYPE html>

@php
    // Rutas
    $routes = [
        [
            'name' => 'dashboard',
            'icon' => 'layout-grid',
            'label' => __('Dashboard'),
        ],
        [
            'name' => 'chirps',
            'icon' => 'chat-bubble-left-ellipsis',
            'label' => __('Chirps'),
        ],
    ];
@endphp


<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <a href="{{ route($routes[0]['name']) }}" class="ml-2 mr-5 flex items-center space-x-2 lg:ml-0" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navbar class="-mb-px max-lg:hidden">
                @foreach ( $routes as $route)
                    <flux:navbar.item :icon="$route['icon']" :href="route($route['name'])" :current="request()->routeIs($route['name'])" wire:navigate>
                        {{ __($route['label']) }}
                    </flux:navbar.item>
                @endforeach
            </flux:navbar>

            <flux:spacer />

            <flux:navbar class="mr-1.5 space-x-0.5 py-0!">
                <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
                    <flux:radio value="light" icon="moon" x-bind:hidden="$flux.appearance != 'dark'">Oscuro</flux:radio>
                    <flux:radio value="dark" icon="computer-desktop" x-bind:hidden="$flux.appearance != 'system'">Sistema</flux:radio>
                    <flux:radio value="system" icon="sun" x-bind:hidden="$flux.appearance != 'light'">Claro</flux:radio>
                </flux:radio.group>

                {{-- <flux:dark-button x-data="{ mode: $flux.appearance || 'light' }" 
                  x-on:click="
                    if (mode === 'light') {
                        mode = 'dark';
                        $flux.appearance = 'dark';
                    } else if (mode === 'dark') {
                        mode = 'system';
                        $flux.appearance = 'system';
                    } else {
                        mode = 'light';
                        $flux.appearance = 'light';
                    }
                  " 
                  variant="subtle" 
                  aria-label="Toggle dark mode">
                    <template x-if="mode === 'light'">
                        <flux:icon name="sun" />
                    </template>
                    <template x-if="mode === 'dark'">
                        <flux:icon name="moon" />
                    </template>
                    <template x-if="mode === 'system'">
                        <flux:icon name="computer-desktop" />
                    </template>
                    <span x-text="mode === 'light' ? 'Claro' : (mode === 'dark' ? 'Oscuro' : 'Sistema')"></span>
                </flux:dark-button> --}}
              
                 

                
               
                <flux:tooltip :content="__('Repository')" position="bottom">
                    <flux:navbar.item
                        class="h-10 max-lg:hidden [&>div>svg]:size-5"
                        icon="folder-git-2"
                        href="https://github.com/laravel/livewire-starter-kit"
                        target="_blank"
                        :label="__('Repository')"
                    />
                </flux:tooltip>
                <flux:tooltip :content="__('Documentation')" position="bottom">
                    <flux:navbar.item
                        class="h-10 max-lg:hidden [&>div>svg]:size-5"
                        icon="book-open-text"
                        href="https://laravel.com/docs/starter-kits"
                        target="_blank"
                        label="Documentation"
                    />
                </flux:tooltip>
            </flux:navbar>

            <!-- Desktop User Menu -->
            <flux:dropdown position="top" align="end">
                <flux:profile
                    class="cursor-pointer"
                    :initials="auth()->user()->initials()"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <!-- Mobile Menu -->
        <flux:sidebar stashable sticky class="lg:hidden border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route($routes[1]['name']) }}" class="ml-1 flex items-center space-x-2" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')">
                    @foreach ($routes as $route)
                        <flux:navlist.item :icon="$route['icon']" :href="route($route['name'])" :current="request()->routeIs($route['name'])" wire:navigate>
                        {{ __($route['label']) }}
                        </flux:navlist.item>
                    @endforeach
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                {{ __('Repository') }}
                </flux:navlist.item>

                <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits" target="_blank">
                {{ __('Documentation') }}
                </flux:navlist.item>
            </flux:navlist>
        </flux:sidebar>

        {{ $slot }}

        @fluxScripts
    </body>
</html>

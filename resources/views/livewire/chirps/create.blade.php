<?php

use Livewire\Volt\Component;
use Livewire\Volt\Attributes\Validate;

new class extends Component {
    
    #[Validate('required|string|max:255')]
    public string $message = '';

    public function store()
    {
        $this->validate();
        
        
    }



}; ?>

<div>
    <div class="flex flex-col gap-4 p-4">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="flex h-full w-full max-w-3xl flex-col items-center gap-4 p-4">
                <h1 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">
                    {{ __('Chirps') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    <flux:textarea wire:model="message" rows="auto" class="min-w-60 max-w-96"/>
                </p>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    <flux:button variant="primary">Chirp</flux:button>
                </p>
            </div>
        </div>
    </div>
</div>
    

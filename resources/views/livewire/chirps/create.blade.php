<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;

new class extends Component {
    
    #[Validate('required|string|max:255')]
    public string $message = '';

    public function store()
    {
        $validated = $this->validate();

        auth()->user()->chirps()->create($validated);

        $this->dispatch('chirp-created');
        
        $this->message = '';
        
    }

}; ?>

<div>
    <div class="flex flex-col gap-4 p-4">
        <div class="inset-0 flex items-center justify-center">
            <div class="flex h-full w-full max-w-3xl flex-col items-center gap-4 p-4">
                <h1 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">
                    {{ __('Chirps') }}
                </h1>

                <flux:textarea wire:model="message" rows="auto" class="min-w-60 max-w-96"/>
                
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    <flux:button wire:click="store" variant="primary">Chirp</flux:button>
                </p>
            </div>
        </div>
    </div>
</div>
    

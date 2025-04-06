<?php

use App\Models\Chirp;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public Chirp $chirp;
    
    #[Rule('required|string|max:255')]
    public string $message = '';
    
    public function mount(): void
    {
        $this->message = $this->chirp->message;
    }
    
    public function update(): void
    {
        $this->authorize('update', $this->chirp);
        
        $validated = $this->validate();
        
        $this->chirp->update($validated);
        
        $this->dispatch('chirp-updated');
    }
    
    public function cancel(): void
    {
        $this->dispatch('chirp-edit-canceled');
    }
}; ?>

<div>
    <form wire:submit="update">
        <flux:textarea wire:model="message" rows="auto" class="min-w-60 max-w-96"/>
        
        <div class="mt-4 space-x-2 flex justify-end">
            <flux:button wire:click="cancel" type="button" color="secondary">
                {{ __('Cancel') }}
            </flux:button>
            
            <flux:button type="submit" color="primary">
                {{ __('Save') }}
            </flux:button>
        </div>
    </form>
</div>

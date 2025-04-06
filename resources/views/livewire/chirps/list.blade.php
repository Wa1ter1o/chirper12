<?php

use App\Models\Chirp; 
use Illuminate\Database\Eloquent\Collection; 
use Livewire\Attributes\On;
use Livewire\Volt\Component;
use App\Events\ChirpCreated;

new class extends Component 
{
    public Collection $chirps; 

    public ?chirp $editing = null;
 
    public function mount(): void
    {
        $this->getChirps();
    } 

    #[On('chirp-created')]
    public function getChirps(): void
    {
        $this->chirps = Chirp::with('user')
            ->latest()
            ->get();
    } 

    public function edit(chirp $chirp): void
    {
        $this->editing = $chirp;

        $this->getChirps();

        //Event::dispatch(new ChirpCreated($chirp));
    }

    #[On('chirp-edit-canceled')]
    #[On('chirp-updated')] 
    public function disableEditing(): void
    {
        $this->editing = null;
 
        $this->getChirps();
    } 

    public function delete(Chirp $chirp): void
    {
        $this->authorize('delete', $chirp);
 
        $chirp->delete();
 
        $this->getChirps();
    } 
}; ?>

<div class="mt-6 max-w-2xl mx-auto bg-white dark:bg-gray-800 shadow-sm rounded-lg divide-y"> 
    @foreach ($chirps as $chirp)
        <div class="p-4 flex space-x-2" wire:key="{{ $chirp->id }}">
            <flux:icon.chat-bubble-oval-left-ellipsis class="-scale-x-100" />
            <div class="flex-1">
                <div class="flex justify-between items-center">
                    <div>
                        <flux:text inline="true" class="text-base">{{ $chirp->user->name }}</flux:text>
                        <flux:text inline="true" class="ml-2 text-sm">{{ $chirp->created_at->format('j M Y, g:i a') }}</flux:text>
                        @unless ($chirp->created_at->eq($chirp->updated_at))
                            <flux:text inline="true" class="ml-2 text-sm"> &middot; {{ __('edited') }}</flux:text>
                        @endunless
                    </div>
                    @if ($chirp->user->is(auth()->user()))
                        <flux:dropdown >
                            <flux:button icon:trailing="bars-3"></flux:button>
                            <flux:menu>
                                <flux:menu.item wire:click="edit({{ $chirp->id }})" icon="pencil">Edit</flux:menu.item>
                                <flux:menu.item wire:click="delete({{ $chirp->id }})" icon="trash">Delete</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    @endif
                </div>
                @if ($chirp->is($editing)) 
                    <livewire:chirps.edit :chirp="$chirp" :key="$chirp->id" />
                @else
                    <flux:text variant="strong" class="text-lg">{{ $chirp->message }}</flux:text>
                @endif 
            </div>
        </div>
    @endforeach 

    @script
    <script>
        window.Echo.private(`new-chirp`)
            .listen('ChirpCreated', (e) => {
                //console.log(e);
                $wire.dispatch('chirp-created');
            });
    </script>
    @endscript
</div>
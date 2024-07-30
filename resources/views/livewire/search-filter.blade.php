<div>
    <h3 class="title stroke-shape">Re-Fetch Airline</h3>
    <input type="text" class="form-control" wire:model="includedAirlineCodes">
    <div class="d-flex justify-content-between mt-2">
        <div wire:loading.remove>
            <button type="button" class="btn btn-primary btn-sm" wire:click="fetch">Re-Fetch</button>
            @if(session()->exists('includedAirlineCodes'))
            <button type="button" class="btn btn-secondary btn-sm" wire:click="resetFilter">Reset</button>
            @endif
        </div>
    </div>
</div>
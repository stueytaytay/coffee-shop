<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center mb-8">Shipping Partners</h2>
            @if($successMessage)
                <div class="mb-8 p-3 text-white font-semibold bg-green-500 border-1 border-green-600 rounded">
                    {{ $successMessage }}
                </div>
            @endif
            <form wire:submit.prevent="saveShippingPartners" wire:loading.class="opacity-50" class="">
                @foreach($shippingPartners as $index => $partner)
                    <div class="flex justify-center items-start gap-6 pb-6" wire:loading.class="opacity-50">
                        <div class="w-52">
                            <label for="partner_name_{{ $index }}" class="block font-semibold text-sm pb-1">Partner Name</label>
                            <x-input type="text" id="partner_name_{{ $index }}" wire:model="shippingPartners.{{ $index }}.partner_name" class="w-full" />
                            <x-input-error field="shippingPartners.{{ $index }}.partner_name" />
                        </div>
                        <div class="w-52">
                            <label for="shipping_cost_{{ $index }}" class="block font-semibold text-sm pb-1">Shipping Cost</label>
                            <x-input type="text" id="shipping_cost_{{ $index }}" wire:model="shippingPartners.{{ $index }}.shipping_cost" class="w-full" />
                            <x-input-error field="shippingPartners.{{ $index }}.shipping_cost" />
                        </div>
                        <button
                            type="button"
                            wire:click="deleteShippingPartner({{ $index }})"
                            wire:confirm="Are you sure you want to delete this shipping partner?"
                            class="bg-red-500 text-white text-xs rounded-full p-2 font-semibold mt-7"
                        >Delete</button>
                    </div>
                @endforeach
                <div class="flex justify-center w-full">
                    <button type="button" wire:click="addShippingPartner" class="text-md bg-blue-400 mt-5 px-4 py-2 rounded-full text-white font-bold transition hover:bg-blue-500">Add New Shipping Partner +</button>
                </div>
                <div class="p-4 mt-6 flex justify-center gap-6 w-full bg-gray-100 rounded">
                    <button type="submit" class="text-md bg-orange-400 px-4 py-2 rounded-full text-white font-bold transition hover:bg-orange-500">Save Shipping Partners ✔</button>
                </div>
            </form>
        </div>
    </div>
</div>
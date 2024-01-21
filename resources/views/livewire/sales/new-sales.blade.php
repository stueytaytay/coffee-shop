<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 bg-white border-b border-gray-200">
            <form wire:submit.prevent="recordSale" wire:loading.class="opacity-50" class="flex justify-center items-start gap-6">
                <div class="flex gap-6 justify-center items-start grow-0">
                    <div class="w-1/3">
                        <label for="coffee_type" class="block font-semibold text-sm pb-1">Coffee Type</label>
                        <select wire:model.live="selectedCoffeeType" id="coffee_type" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                            <option value="">Select...</option>
                            @foreach($coffeeTypes as $coffeeType)
                                <option value="{{ $coffeeType->id }}">{{ $coffeeType->coffee_name }}</option>
                            @endforeach
                        </select>
                        <x-input-error field="selectedCoffeeType" />
                    </div>
                    <div class="w-1/3">
                        <label for="quantity" class="block font-semibold text-sm pb-1">Quantity</label>
                        <x-input type="number" wire:model="quantity" wire:keyup="calculateSellingPrice" class="w-full" />
                        <x-input-error field="quantity" />
                    </div>
                    <div class="w-1/3">
                        <label for="unitCost" class="block font-semibold text-sm pb-1">Unit Cost (£)</label>
                        <x-input type="number" wire:model="unit_cost" wire:keyup="calculateSellingPrice" step="0.01" class="w-full" />
                        <x-input-error field="unit_cost" />
                    </div>
                </div>
                <div wire:loading.class="opacity-50" class="px-8 py-2 bg-gray-100 text-center rounded-lg">
                    <strong class="text-xl text-orange-400 pb-1 block">Selling Price</strong>
                    <span>{{ $formattedSellingPrice }}</span>
                </div>
                <button type="submit" class="text-md bg-orange-400 mt-5 px-4 py-2 rounded-full text-white font-bold transition hover:bg-orange-500">Record Sale ✔</button>
            </form>
        </div>
    </div>
</div>
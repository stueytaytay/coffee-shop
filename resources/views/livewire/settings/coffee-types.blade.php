<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center mb-8">Coffee Types</h2>
            @if($successMessage)
                <div class="mb-8 p-3 text-white font-semibold bg-green-500 border-1 border-green-600 rounded">
                    {{ $successMessage }}
                </div>
            @endif
            <form wire:submit.prevent="saveCoffeeTypes" wire:loading.class="opacity-50" class="">
                @foreach($coffeeTypes as $index => $type)
                    <div class="flex justify-center items-start gap-6 pb-6" wire:loading.class="opacity-50">
                        <div class="w-52">
                            <label for="coffee_name_{{ $index }}" class="block font-semibold text-sm pb-1">Coffee Name</label>
                            <x-input type="text" id="coffee_name_{{ $index }}" wire:model="coffeeTypes.{{ $index }}.coffee_name" class="w-full" />
                            <x-input-error field="coffeeTypes.{{ $index }}.coffee_name" />
                        </div>
                        <div class="w-52">
                            <label for="profit_margin_{{ $index }}" class="block font-semibold text-sm pb-1">Profit Margin (%)</label>
                            <x-input type="text" id="profit_margin_{{ $index }}" wire:model="coffeeTypes.{{ $index }}.profit_margin" class="w-full" />
                            <x-input-error field="coffeeTypes.{{ $index }}.profit_margin" />
                        </div>
                        <button
                            type="button"
                            wire:click="deleteCoffeeType({{ $index }})"
                            wire:confirm="Are you sure you want to delete this coffee type?"
                            class="bg-red-500 text-white text-xs rounded-full p-2 font-semibold mt-7"
                        >Delete</button>
                    </div>
                @endforeach
                <div class="flex justify-center w-full">
                    <button type="button" wire:click="addCoffeeType" class="text-md bg-blue-400 mt-5 px-4 py-2 rounded-full text-white font-bold transition hover:bg-blue-500">Add New Coffee Type +</button>
                </div>
                <div class="p-4 mt-6 flex justify-center gap-6 w-full bg-gray-100 rounded">
                    <button type="submit" class="text-md bg-orange-400 px-4 py-2 rounded-full text-white font-bold transition hover:bg-orange-500">Save Coffee Types ✔</button>
                </div>
            </form>
        </div>
    </div>
</div>
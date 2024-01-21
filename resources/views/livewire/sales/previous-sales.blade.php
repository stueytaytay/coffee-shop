<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div wire:loading.class="opacity-50" class="p-6 bg-white border-b border-gray-200">
            <table class="min-w-full divide-y divide-gray-200 shadow-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Coffee Type</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Cost</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Selling Price</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Shipping</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($coffeeSales as $sale)
                        <tr class="@if($loop->odd) bg-white @else bg-gray-50 @endif">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">{{ $sale->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm {{ $sale->coffeeType->trashed() ? 'text-gray-300' : 'text-gray-500' }} text-center">{{ $sale->coffeeType->coffee_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $sale->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ Akaunting\Money\Money::GBP($sale->unit_cost * 100)->format() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ Akaunting\Money\Money::GBP($sale->selling_price * 100)->format() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm {{ $sale->coffeeType->shippingPartner->trashed() ? 'text-gray-300' : 'text-gray-500' }} text-center">
                                {{ $sale->coffeeType->shippingPartner->partner_name }},
                                {{ Akaunting\Money\Money::GBP($sale->coffeeType->shippingPartner->shipping_cost * 100)->format() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $sale->created_at->format('d/m/Y H:i:s') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <button
                                    type="button"
                                    wire:click="deleteSale({{ $sale->id }})"
                                    wire:confirm="Are you sure you want to delete this sale?"
                                    class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-full text-xs px-3 py-1 text-center inline-flex items-center"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @if (!$coffeeSales->count())
            <div class="text-center text-gray-500 font-semibold pt-6">
                No sales logged...
            </div>
        @endif
        </div>
    </div>
</div>

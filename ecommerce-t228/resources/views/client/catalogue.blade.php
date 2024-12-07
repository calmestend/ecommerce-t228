<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Catalogue') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex ">
                    @foreach ($products as $product)
                    <div class="p-4 m-4 border-solid  border-2 border-indigo-600">
                        <img src="{{ url('storage/products/'. $product->thumbnail) }}" alt="{{ $product->name }}">
                        <p>{{ $product->name }}</p>
                        <p>{{ $product->description }}</p>
                        <p>Cost: {{ $product->cost }}</p>
                        <p>Price: {{ $product->price }}</p>
                        <p>Stock: {{ $product->stock->quantity }}</p>
                        <form method="post" action="{{ route('wish_list_products.store') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="wish_list_id" value="{{ Auth::user()->wish_list->id }}">
                            <x-primary-button class="ms-3">
                                {{ __('Add to wish list') }}
                            </x-primary-button>
                            <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                            <x-input-error :messages="$errors->get('wish_list_id')" class="mt-2" />
                        </form>
                        <form method="post" action="{{ route('shopping_cart.store') }}">
                            @csrf
                            <input type="hidden" name="stock_id" value="{{ $product->stock->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <x-secondary-button type="submit" class="ms-3">
                                {{ __('Add to shopping cart') }}
                            </x-secondary-button>
                            <x-input-error :messages="$errors->get('stock_id')" class="mt-2" />
                        </form>
                    </div>
                    @endforeach
                </div>
                <div class="m-4">
                    <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

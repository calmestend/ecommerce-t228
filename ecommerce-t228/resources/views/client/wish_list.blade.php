<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Wish List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (count($wishListProducts) > 0)
                    @foreach ($wishListProducts as $wishListProduct)
                    <div class="p-4 m-4 border-solid  border-2 border-indigo-600">
                        <img src="{{ url('storage/products/'. $wishListProduct->product->thumbnail) }}"
                            alt="{{ $wishListProduct->product->name }}">
                        <p>{{ $wishListProduct->product->name }}</p>
                        <p>{{ $wishListProduct->product->description }}</p>
                        <p>Cost: {{ $wishListProduct->product->cost }}</p>
                        <p>Price: {{ $wishListProduct->product->price }}</p>
                        <p>Stock: {{ $wishListProduct->product->stock->quantity }}</p>
                        <form action="{{ route('wish_list_products.destroy', ['id' => $wishListProduct->id]) }}"
                            method="post">
                            @csrf
                            <x-primary-button>Delete</x-primary-button>
                        </form>
                    </div>
                    @endforeach
                    @else
                    <h2>You don't have any products in your wish list</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

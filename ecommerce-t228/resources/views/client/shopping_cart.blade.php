<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($cartItems && count($cartItems) > 0)
                    @foreach ($cartItems as $item)
                    <div class="p-4 m-4 border-solid  border-2 border-indigo-600">
                        <img src="{{ url('storage/products/'. $item['stock']->product->thumbnail) }}"
                            alt="{{ $item['stock']->product->name }}">
                        <p>{{ $item['stock']->product->name }}</p>
                        <p>Price: {{ $item['stock']->product->price }}</p>
                        <p>Quantity: {{ $item['quantity'] }}</p>
                        <p>Subtotal: {{ $item['subtotal'] }}</p>
                        <form action="{{ route('shopping_cart.destroy', ['stock_id' => $item['stock']->id]) }}"
                            method="post">
                            @csrf
                            <x-primary-button>Delete</x-primary-button>
                        </form>
                    </div>
                    @endforeach
                    <h2>Total: {{ $total }}</h2>
                    <form action="{{ route('paypal.payment') }}" method="post">
                        @csrf
                        <input type="hidden" name="total" value="{{ $total }}">
                        <x-primary-button>Pay with PayPal</x-primary-button>
                    </form>

                    @else
                    <h2>You don't have any products in your shopping cart</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

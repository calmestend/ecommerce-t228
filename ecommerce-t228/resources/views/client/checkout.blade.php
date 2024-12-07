<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>Payment successfully created</h1>

                    <form action="{{ route('invoice.store') }}" method="post">
                        @csrf
                        <div class="flex flex-col py-4 my-2">
                            <input type="hidden" name="cartItems" value="{{ json_encode($cartItems) }}">
                            <input type="hidden" name="sale_id" value="{{ $saleId }}">

                            <label for="rfc">RFC</label>
                            <input type="text" name="rfc" id="rfc" />

                            <label for="address">Address</label>
                            <input type="text" name="address" id="address" />

                            <label for="phone_number">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" />
                        </div>
                        <x-primary-button>Download Invoice</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

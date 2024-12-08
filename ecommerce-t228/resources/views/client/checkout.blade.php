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

                    <form action="{{ route('invoice.download.pdf') }}" method="post" class="mb-4">
                        @csrf
                        <input type="hidden" name="sale_id" value="{{ $saleId }}">
                        <x-primary-button>Download PDF Invoice</x-primary-button>
                    </form>

                    <form action="{{ route('invoice.download.xml') }}" method="post" id="xmlForm">
                        @csrf
                        <input type="hidden" name="sale_id" value="{{ $saleId }}">
                        <x-primary-button>Download XML Invoice</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shopping History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @foreach ($sales as $sale)
                    <div class="p-4 m-4 border-solid  border-2 border-indigo-600">
                        <p>Folio: {{ $sale->id }}</p>
                        <p>Fecha {{ $sale->created_at }}</p>
                        <p>Monto: {{ $sale->payment->amount }}</p>
                        <form action="{{ route('invoice.download.xml') }}" method="post" id="xmlForm">
                            @csrf
                            <input type="hidden" name="sale_id" value="{{ $sale->id }}">
                            <x-primary-button>Download XML Invoice</x-primary-button>
                        </form>
                        <form action="{{ route('invoice.download.pdf') }}" method="post" class="mb-4">
                            @csrf
                            <input type="hidden" name="sale_id" value="{{ $sale->id }}">
                            <x-primary-button>Download PDF Invoice</x-primary-button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

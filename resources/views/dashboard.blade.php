
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>
 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-card>
                <h3 class="text-lg font-semibold mb-2">Ringkasan Hari Ini</h3>
                <p class="text-gray-600">Selamat datang, {{ auth()->user()->name }}.</p>
            </x-card>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-card>
                <h3 class="text-lg font-semibold mb-4">Pengujian Komponen Status Stok</h3>
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between border-b pb-2">
                        <span>Minyak Goreng 2L (Stok: 15)</span>
                        <x-badge :stock="15" />
                    </div>

                    <div class="flex items-center justify-between border-b pb-2">
                        <span>Gula Pasir 1kg (Stok: 5)</span>
                        <x-badge :stock="5" />
                    </div>

                    <div class="flex items-center justify-between pb-2">
                        <span>Beras 5kg (Stok: 0)</span>
                        <x-badge :stock="0" />
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>

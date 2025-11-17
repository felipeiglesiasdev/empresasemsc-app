@props(['title' => 'Atenção!', 'message' => ''])
<div x-data="{ show: true }"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-opacity-70 backdrop-blur-sm flex items-center justify-center z-50 p-4"
     style="display: none;">
    <div @click.away="show = false"
         {{-- AJUSTE 2: Adicionado `overflow-hidden` para um design mais limpo --}}
         class="bg-white rounded-lg shadow-2xl w-full max-w-md mx-auto p-6 text-center transform transition-all overflow-hidden"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-90">
        <div class="mx-auto mb-4 w-16 h-16 flex items-center justify-center bg-red-100 rounded-full">
            <i class="bi bi-exclamation-triangle-fill text-4xl text-[#ed1c24]"></i>
        </div>
        <h3 class="text-2xl font-semibold text-gray-800 mb-2">{{ $title }}</h3>
        <p class="text-gray-600 mb-6">{{ $message }}</p>
        <button @click="show = false" 
                class="cursor-pointer bg-[#ed1c24] text-white font-medium py-3 px-10 rounded-full text-lg hover:bg-[#c11b21] transform transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg shadow-md">
            Entendido
        </button>
    </div>
</div>

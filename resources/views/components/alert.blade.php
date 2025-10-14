@if (session('status') || session('success') || session('error'))
    @php
        $type = session('success') ? 'success' : (session('error') ? 'error' : 'status');
        $message = session('success') ?? session('error') ?? session('status');
    @endphp

    <div
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 4000)"
        x-transition
        class="fixed top-5 right-5 z-50"
    >
        <div class="flex items-center gap-3 px-4 py-3 rounded-lg shadow-lg
            @if($type === 'success') bg-green-100 text-green-800 border border-green-300
            @elseif($type === 'error') bg-red-100 text-red-800 border border-red-300
            @else bg-blue-100 text-blue-800 border border-blue-300 @endif">
            
            @if($type === 'success')
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 13l4 4L19 7" />
                </svg>
            @elseif($type === 'error')
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 20h.01" />
                </svg>
            @endif

            <p class="text-sm font-medium">{{ $message }}</p>
        </div>
    </div>
@endif

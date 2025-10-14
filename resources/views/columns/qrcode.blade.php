{{-- resources/views/columns/qrcode.blade.php --}}
@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;

    $qrValue = $getState(); // The current record’s QR code value
@endphp

<div class="flex flex-col items-center justify-center">
    @if(!empty($qrValue))
        {{-- Generate a small, clean QR Code inline --}}
        {!! QrCode::size(80)
            ->style('round')
            ->margin(1)
            ->generate($qrValue) !!}
        <p class="mt-1 text-xs text-gray-700 font-mono">{{ $qrValue }}</p>
    @else
        <p class="text-xs text-red-500 italic">No QR code</p>
    @endif
</div>

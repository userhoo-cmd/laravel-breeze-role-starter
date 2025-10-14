{{-- resources/views/columns/barcode.blade.php --}}
@php
    use Milon\Barcode\DNS1D;

    $barcodeValue = $getState(); // This retrieves the current record’s barcode value
    $barcode = new DNS1D();
    $barcode->setStorPath(storage_path('app/public/barcodes/')); // Safer storage path
@endphp

<div class="flex flex-col items-center justify-center">
    @if(!empty($barcodeValue))
        {!! $barcode->getBarcodeHTML($barcodeValue, 'C128', 1.8, 50, 'black', true) !!}
        <p class="mt-1 text-xs text-gray-700 font-mono">{{ $barcodeValue }}</p>
    @else
        <p class="text-xs text-red-500 italic">No barcode</p>
    @endif
</div>

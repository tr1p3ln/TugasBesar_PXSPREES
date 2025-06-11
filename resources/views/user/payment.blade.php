<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pembayaran Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 text-white">
            <div class="bg-gray-800/50 backdrop-blur-sm overflow-hidden shadow-xl sm:rounded-lg p-6 md:p-8">

                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-purple-400">Selesaikan Pembayaran Anda</h2>
                    <p class="text-gray-400 mt-2">Selesaikan pembayaran untuk mengamankan jadwal booking Anda.</p>
                </div>

                @if (session('success'))
                    <div class="bg-green-500/90 border border-green-600 text-white p-4 rounded-lg mb-6 text-center">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-500/90 border border-red-600 text-white p-4 rounded-lg mb-6 text-center">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($booking && $payment)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 p-6 bg-gray-900/70 rounded-lg border border-gray-700">
                        <div>
                            <h3 class="text-lg font-semibold border-b border-gray-600 pb-2 mb-4">Detail Booking</h3>
                            <div class="space-y-2 text-sm">
                                <p><span class="font-semibold text-gray-400 w-24 inline-block">Booking ID</span>: #{{ $booking->id }}</p>
                                <p><span class="font-semibold text-gray-400 w-24 inline-block">Ruangan</span>: {{ $booking->room->name }}</p>
                                <p><span class="font-semibold text-gray-400 w-24 inline-block">Tanggal</span>: {{ $booking->start_time->translatedFormat('d F Y') }}</p>
                                <p><span class="font-semibold text-gray-400 w-24 inline-block">Waktu</span>: {{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }} ({{ $booking->duration_hour }} Jam)</p>
                                <p><span class="font-semibold text-gray-400 w-24 inline-block">Pemesan</span>: {{ $booking->user->name }}</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold border-b border-gray-600 pb-2 mb-4">Instruksi Pembayaran</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-gray-300">Total Pembayaran:</p>
                                    <p class="text-4xl font-extrabold text-purple-400">Rp{{ number_format($payment->amount, 0, ',', '.') }}</p>
                                </div>
                                
                                @if($payment->payment_method === 'transfer')
                                    <div>
                                        <p class="text-gray-300">Transfer ke:</p>
                                        <div class="mt-2 p-4 bg-gray-800 rounded-lg text-sm">
                                            <p><span class="font-bold">BCA:</span> 1234-5678-90 (a.n. PSXPRESS INDONESIA)</p>
                                            <p class="mt-1"><span class="font-bold">Mandiri:</span> 098-765-4321 (a.n. PSXPRESS INDONESIA)</p>
                                        </div>
                                    </div>
                                @elseif($payment->payment_method === 'qr')
                                    <div>
                                        <p class="text-gray-300">Scan QR Code:</p>
                                        <div class="mt-2 p-4 bg-white rounded-lg">
                                            <img src="{{ asset('images/payment-qr.png') }}" alt="QR Code Pembayaran" class="mx-auto h-40">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-700 pt-8">
                        <h3 class="text-xl font-semibold text-center mb-4">Konfirmasi Pembayaran Anda</h3>

                        @if ($payment->payment_proof)
                            <div class="text-center bg-blue-900/50 border border-blue-700 p-6 rounded-lg max-w-lg mx-auto">
                                <h4 class="font-bold text-lg">Bukti Pembayaran Telah Diunggah</h4>
                                <p class="text-sm text-gray-300 mt-2">Status: 
                                    <span @class([
                                        'font-bold uppercase px-2 py-1 rounded',
                                        'bg-yellow-500 text-yellow-900' => $payment->payment_status === 'pending',
                                        'bg-green-500 text-green-900' => $payment->payment_status === 'paid',
                                        'bg-red-500 text-red-900' => $payment->payment_status === 'failed'
                                    ])>
                                        {{ $payment->payment_status }}
                                    </span>
                                </p>
                                <p class="text-sm text-gray-300 mt-1">Harap tunggu konfirmasi dari admin.</p>
                                <div class="mt-4">
                                    <a href="{{ Storage::url($payment->payment_proof) }}" target="_blank" class="inline-flex items-center text-purple-400 hover:text-purple-300 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                        </svg>
                                        Lihat Bukti Pembayaran
                                    </a>
                                </div>
                            </div>
                        @else
                            <form action="{{ route('payment.upload', $payment->id) }}" method="POST" enctype="multipart/form-data" class="max-w-md mx-auto">
                                @csrf
                                <div class="mb-4">
                                    <label for="payment_proof" class="block text-sm font-medium text-gray-300 mb-2">Unggah Bukti Pembayaran</label>
                                    <div class="flex items-center justify-center w-full">
                                        <label for="payment_proof" class="flex flex-col w-full h-32 border-2 border-dashed border-gray-600 hover:border-purple-500 rounded-lg cursor-pointer bg-gray-900/50 hover:bg-gray-900/70 transition">
                                            <div class="flex flex-col items-center justify-center pt-7">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                                <p class="pt-1 text-sm text-gray-400">Upload bukti pembayaran</p>
                                            </div>
                                            <input id="payment_proof" name="payment_proof" type="file" class="opacity-0" required accept="image/*,.pdf" />
                                        </label>
                                    </div>
                                    @error('payment_proof')
                                        <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300 focus:outline-none focus:ring-4 focus:ring-purple-500/50">
                                    Konfirmasi Pembayaran
                                </button>
                            </form>
                        @endif
                    </div>
                @else
                    <div class="text-center bg-red-900/50 border border-red-700 p-6 rounded-lg">
                        <h3 class="text-xl font-bold">Data Tidak Ditemukan</h3>
                        <p class="mt-2">Booking atau data pembayaran tidak valid.</p>
                        <a href="{{ route('bookings.index') }}" class="mt-4 inline-block px-4 py-2 bg-purple-600 rounded-lg hover:bg-purple-700 transition">
                            Kembali ke Daftar Booking
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
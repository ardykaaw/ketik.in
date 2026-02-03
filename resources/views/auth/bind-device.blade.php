<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Akun Anda belum terikat pada perangkat ini. Kebijakan keamanan kami mengharuskan 1 akun hanya digunakan pada 1 perangkat.') }}
        <br><br>
        <strong>{{ __('Apakah Anda ingin menjadikan perangkat ini sebagai perangkat utama Anda?') }}</strong>
        <br>
        {{ __('Tindakan ini akan mengeluarkan (logout) akun Anda dari perangkat lain yang sebelumnya terhubung.') }}
    </div>

    <form method="POST" action="{{ route('device.binding.store') }}">
        @csrf

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-4">
                {{ __('Ya, Ikat Perangkat Ini') }}
            </x-primary-button>
        </div>
    </form>
    
    <div class="mt-4 text-center">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 underline">
                {{ __('Batalkan') }}
            </button>
        </form>
    </div>
</x-guest-layout>

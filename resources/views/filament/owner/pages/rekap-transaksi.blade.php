<x-filament-panels::page>

    {{-- FORM FILTER --}}
    <x-filament::section heading="Filter Periode">
        <form wire:submit="tampilkan">
            {{ $this->form }}
            <div class="flex flex-wrap gap-2 mt-4">
                <x-filament::button type="button" color="gray" wire:click="setHariIni">
                    Hari Ini
                </x-filament::button>
                <x-filament::button type="button" color="gray" wire:click="setMingguIni">
                    Minggu Ini
                </x-filament::button>
                <x-filament::button type="button" color="gray" wire:click="setBulanIni">
                    Bulan Ini
                </x-filament::button>
                <x-filament::button type="submit" icon="heroicon-m-magnifying-glass">
                    Tampilkan
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>

    {{-- SUMMARY CARDS --}}
    @if($sudahFilter)
        @php $summary = $this->getSummary() @endphp
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <x-filament::section>
                <p class="text-sm text-gray-400">Total Hari Aktif</p>
                <p class="text-3xl font-bold text-primary-400 mt-1">
                    {{ $summary->total_hari ?? 0 }} Hari
                </p>
            </x-filament::section>

            <x-filament::section>
                <p class="text-sm text-gray-400">Total Kendaraan</p>
                <p class="text-3xl font-bold text-info-400 mt-1">
                    {{ number_format($summary->total_transaksi ?? 0) }}
                </p>
            </x-filament::section>

            <x-filament::section>
                <p class="text-sm text-gray-400">Total Pendapatan</p>
                <p class="text-3xl font-bold text-success-400 mt-1">
                    Rp {{ number_format($summary->total_pendapatan ?? 0) }}
                </p>
            </x-filament::section>
        </div>

        {{-- TABEL --}}
        <x-filament::section>
            <x-slot name="heading">
                Detail:
                {{ \Carbon\Carbon::parse($tanggal_mulai)->translatedFormat('d F Y') }}
                —
                {{ \Carbon\Carbon::parse($tanggal_selesai)->translatedFormat('d F Y') }}
            </x-slot>

            {{ $this->table }}
        </x-filament::section>
    @endif

</x-filament-panels::page>
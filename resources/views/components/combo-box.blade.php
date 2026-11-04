@props([
    'name',
    'id' => null,
    'opsi' => [],
    'nilai' => '',
    'peta' => null,
    'induk' => null,
    'nilaiInduk' => '',
    'placeholder' => 'Ketik untuk mencari...',
])

<div class="relative"
    x-data="comboBox(@js(['nama' => $name, 'opsi' => $opsi, 'nilai' => $nilai, 'peta' => $peta, 'induk' => $induk, 'nilaiInduk' => $nilaiInduk]))"
    @combo-berubah.window="dengarInduk($event.detail)"
    @click.outside="tutup()">

    <input type="text" id="{{ $id ?? $name }}" role="combobox" autocomplete="off"
        x-model="cari"
        :aria-expanded="terbuka.toString()"
        :disabled="peta && opsi.length === 0"
        placeholder="{{ $placeholder }}"
        @focus="bukaSemua()"
        @input="terbuka = true; sorot = 0"
        @keydown.down.prevent="turun()"
        @keydown.up.prevent="naik()"
        @keydown.enter.prevent="pilihSorotan()"
        @keydown.escape="tutup()"
        {{ $attributes->merge(['class' => 'block w-full rounded-xl border-neutral-300 bg-white px-4 py-2.5 text-xs sm:text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-neutral-900 focus:ring-0 disabled:bg-neutral-100']) }}>

    {{-- Nilai yang benar-benar dikirim ke server --}}
    <input type="hidden" name="{{ $name }}" :value="nilai">

    <ul x-show="terbuka" x-cloak
        class="absolute z-20 mt-1 max-h-56 w-full overflow-auto rounded-xl border border-neutral-200 bg-white py-1 shadow-lg">
        <template x-for="(item, i) in hasil" :key="item">
            <li x-text="item"
                @mousedown.prevent="pilih(item)"
                :class="i === sorot ? 'bg-neutral-100 text-neutral-900' : 'text-neutral-700'"
                class="cursor-pointer px-4 py-2 text-xs sm:text-sm"></li>
        </template>
        <li x-show="hasil.length === 0" class="px-4 py-2 text-xs text-neutral-500">Tidak ada hasil</li>
    </ul>
</div>
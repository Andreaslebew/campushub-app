import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Dropdown yang bisa diketik untuk mencari. Jika ada "peta" dan "induk",
// daftar pilihan otomatis berganti saat nilai di field induk berubah.
Alpine.data('comboBox', (konfig) => ({
    nama: konfig.nama,
    peta: konfig.peta,
    induk: konfig.induk,
    opsi: konfig.peta && konfig.induk
        ? (konfig.peta[konfig.nilaiInduk] ?? [])
        : (konfig.opsi ?? []),
    nilai: konfig.nilai ?? '',
    cari: konfig.nilai ?? '',
    terbuka: false,
    sorot: 0,

    get hasil() {
        const kata = this.cari.trim().toLowerCase();

        return this.opsi.filter((item) => item.toLowerCase().includes(kata));
    },

    bukaSemua() {
        this.terbuka = true;
        this.sorot = 0;
        this.cari = '';
    },

    tutup() {
        this.terbuka = false;
        this.cari = this.nilai;
        this.sorot = 0;
    },

    pilih(item) {
        this.nilai = item;
        this.cari = item;
        this.terbuka = false;
        this.sorot = 0;

        this.$dispatch('combo-berubah', { nama: this.nama, nilai: item });
    },

    pilihSorotan() {
        if (this.hasil[this.sorot] !== undefined) {
            this.pilih(this.hasil[this.sorot]);
        }
    },

    turun() {
        this.terbuka = true;
        this.sorot = Math.min(this.sorot + 1, this.hasil.length - 1);
    },

    naik() {
        this.sorot = Math.max(this.sorot - 1, 0);
    },

    dengarInduk(detail) {
        if (!this.peta || detail.nama !== this.induk) {
            return;
        }

        this.opsi = this.peta[detail.nilai] ?? [];

        if (!this.opsi.includes(this.nilai)) {
            this.nilai = '';
            this.cari = '';
        }
    },
}));

Alpine.start();
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <h6 class="text-primary fw-bold mb-0">@ {{ $post['penulis'] }}</h6>
                <small class="text-muted">Kampus: {{ $post['kampus'] }}</small>
            </div>
            <span class="badge bg-secondary text-capitalize">{{ $post['scope'] }}</span>
        </div>
        <p class="card-text mt-2">{{ $post['konten'] }}</p>
        <div class="d-flex justify-content-between align-items-center text-muted small mt-3 border-top pt-2">
            <span>📚 Prodi: {{ $post['prodi'] }}</span>
            <span>🔥 {{ $post['interaksi'] }} Interaksi | 💬 {{ $post['komentar'] }} Balasan</span>
        </div>
    </div>
</div>
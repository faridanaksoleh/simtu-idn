<div>
  <div class="pagetitle">
      <h1>Konsultasi Tabungan</h1>
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('mahasiswa.dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Konsultasi</li>
          </ol>
      </nav>
  </div>

  <section class="section">
      <div class="card">
          <div class="card-body">
              <h5 class="card-title">Kirim Pertanyaan ke Koordinator</h5>

              <form wire:submit.prevent="sendMessage">
                  <div class="mb-3">
                      <label for="subject" class="form-label">Judul Konsultasi</label>
                      <input type="text" id="subject" class="form-control" wire:model="subject" placeholder="Misal: Kesulitan menabung rutin...">
                  </div>

                  <div class="mb-3">
                      <label for="message" class="form-label">Pesan</label>
                      <textarea id="message" class="form-control" rows="4" wire:model="message" placeholder="Tulis pertanyaan atau kendala Anda..."></textarea>
                  </div>

                  <button type="submit" class="btn btn-success">
                      <i class="bi bi-send"></i> Kirim Konsultasi
                  </button>
              </form>

              <hr>

              <h5 class="card-title mt-4">Riwayat Konsultasi</h5>
              <ul class="list-group">
                  <li class="list-group-item">
                      <strong>Farid:</strong> Saya ingin tahu cara mempercepat target tabungan.
                      <br><small class="text-muted">Dijawab oleh Koordinator: "Perbanyak setoran mingguan."</small>
                  </li>
                  <li class="list-group-item">
                      <strong>Farid:</strong> Apakah boleh menarik dana sementara?
                      <br><small class="text-muted">Belum dijawab</small>
                  </li>
              </ul>
          </div>
      </div>
  </section>
</div>

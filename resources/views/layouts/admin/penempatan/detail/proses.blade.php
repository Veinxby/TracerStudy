@extends('template.main')
@section('title', 'Form Proses Kandidat | Tracer Study')


@section('content')
    <section class="section">
        <div class="section-header">
            <h1 class="text-dark">Proses Seleksi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('admin.permintaan.index') }}">Permintaan</a></div>
                <div class="breadcrumb-item active">Proses Kandidat</div>
            </div>
        </div>

        <div class="section-body pb-5">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        {{ session('error') }}
                    </div>
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            <div class="bg-white rounded-lg shadow-sm border p-4 mb-5" style="border-radius: 15px;">
                <div class="row align-items-center">
                    <div class="col-md-6 border-right-md">
                        <div class="media align-items-center">
                            <div class="bg-primary rounded d-flex align-items-center justify-content-center mr-4 shadow-sm" 
                                style="width: 65px; height: 65px; min-width: 65px;">
                                <i class="fas fa-building text-white"></i>
                            </div>
                            <div class="media-body overflow-hidden">
                                <h3 class="font-weight-bold text-dark mb-1 text-truncate">{{ $permintaan->perusahaan->nama_perusahaan }}</h3>
                                <div class="d-flex align-items-center mt-1">
                                    <span class="text-dark font-weight-bold mr-3" style="font-size: 16px;">
                                        <i class="fas fa-briefcase mr-2 text-primary"></i>{{ $permintaan->posisi }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mt-4 mt-md-0 pl-md-5">
                        <div class="row text-center text-md-left">
                            <div class="col-4 border-right">
                                <small class="text-dark d-block font-weight-bold mb-1" style="letter-spacing: 0.5px; opacity: 0.7; font-size: 10px;">TOTAL KANDIDAT</small>
                                <h5 class="font-weight-bold text-primary mb-0">
                                    {{ count($kandidat) }} <small class="text-primary font-weight-600" style="font-size: 11px;">Orang</small>
                                </h5>
                            </div>

                            <div class="col-4 border-right">
                                <small class="text-dark d-block font-weight-bold mb-1" style="letter-spacing: 0.5px; opacity: 0.7; font-size: 10px;">JENIS</small>
                                @if($permintaan->jenis == 'magang')
                                    <h5 class="font-weight-bold text-warning mb-0" style="font-size: 14px;">
                                        <i class="fas fa-user-graduate mr-1"></i> MAGANG
                                    </h5>
                                @else
                                    <h5 class="font-weight-bold text-success mb-0" style="font-size: 14px;">
                                        <i class="fas fa-briefcase mr-1"></i> KERJA
                                    </h5>
                                @endif
                            </div>

                            <div class="col-4">
                                <small class="text-dark d-block font-weight-bold mb-1" style="letter-spacing: 0.5px; opacity: 0.7; font-size: 10px;">TAHAP</small>
                                <h5 class="font-weight-bold text-info mb-0" style="font-size: 14px;">
                                    <i class="fas fa-user-check mr-1"></i> SELEKSI
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-bottom pb-2 mb-4 mt-2">
                <h5 class="font-weight-bold text-dark mb-1">Daftar Kandidat Mahasiswa</h5>
                <p class="text-secondary small mb-0">Silahkan periksa data dan tentukan hasil seleksi administrasi.</p>
            </div>

            <hr class="border-light mb-4">

            <form id="form-seleksi" action="{{ route('admin.permintaan.kandidat.proses.store', $permintaan->id) }}" method="POST">
                @csrf
                <div class="row">
                    @foreach($kandidat as $k)
                    <div class="col-xl-6 col-lg-6 col-md-12 mb-4">
                        <div class="card border-0 shadow-sm h-100 item-kandidat" 
                            style="border-radius: 12px; transition: all 0.3s ease; border-left: 5px solid transparent !important;">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light text-primary d-flex align-items-center justify-content-center rounded-circle mr-3 font-weight-bold shadow-sm" 
                                            style="width: 50px; height: 50px; border: 2px solid #fff; font-size: 1.2rem;">
                                            {{ strtoupper(substr($k->mahasiswa->user->nama, 0, 2)) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 font-weight-bold text-dark">{{ $k->mahasiswa->user->nama }}</h6>
                                            <small class="text-muted font-weight-600">{{ $k->mahasiswa->nipd ?? '-' }}</small>
                                        </div>
                                    </div>
                                    <span class="badge badge-soft-warning px-3 py-2 text-dark border" style="background: #fff9e6; border-radius: 8px;">
                                        IPK: <strong>{{ $k->mahasiswa->ipk ?? '-' }}</strong>
                                    </span>
                                </div>

                                <div class="mb-4 bg-light p-3 rounded info-jurusan position-relative" style="border-left: 4px solid #6777ef; transition: all 0.3s; min-height: 70px;">
                                    <div class="text-right position-absolute" style="top: 12px; right: 15px;">
                                        <span class="badge badge-primary px-2 py-1 shadow-sm d-block mb-1" style="font-size: 11px; font-weight: 800; border-radius: 4px;">
                                            {{ $k->mahasiswa->kelas->jurusan->kode_jurusan . $k->mahasiswa->kelas->kode_kelas ?? 'N/A' }}
                                        </span>
                                        <small class="font-weight-bold" style="font-size: 9px; letter-spacing: 0.5px;">
                                            ANGKATAN {{ $k->mahasiswa->kelas->tahun_masuk ?? '-' }}
                                        </small>
                                    </div>

                                    <div class="pr-5">
                                        <small class="text-muted d-block mb-1 font-weight-bold" style="font-size: 10px; letter-spacing: 0.5px;">PROGRAM STUDI / JURUSAN</small>
                                        <span class="font-weight-bold small text-dark uppercase d-block" style="line-height: 1.2;">
                                            {{ $k->mahasiswa->kelas->jurusan->nama ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <div class="form-row">
                                    <div class="col-sm-6">
                                        <label class="small font-weight-bold text-muted uppercase mb-2">Hasil Seleksi</label>
                                        <select name="kandidat[{{ $k->id }}][status]" 
                                                class="form-control select-status border-secondary shadow-none" 
                                                style="height: 42px; border-radius: 8px; font-weight: 600;" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="lolos">LULUS SELEKSI</option>
                                            <option value="gagal">TIDAK LULUS</option>
                                        </select>
                                    </div>

                                    {{-- WRAPPER LULUS --}}
                                    <div class="col-12 mt-3 wrapper-lulus d-none">

                                        @if($permintaan->jenis === 'magang')

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="small font-weight-bold text-success mb-2">
                                                        Tanggal Mulai Magang
                                                    </label>
                                                    <input type="date"
                                                        name="kandidat[{{ $k->id }}][tanggal_mulai]"
                                                        class="form-control border-success shadow-none input-mulai"
                                                        style="height:42px; border-radius:8px;">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="small font-weight-bold text-success mb-2">
                                                        Lama Magang
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="number"
                                                            min="1"
                                                            name="kandidat[{{ $k->id }}][durasi]"
                                                            class="form-control border-success shadow-none input-durasi"
                                                            placeholder="Contoh: 3">

                                                        <div class="input-group-append">
                                                            <select name="kandidat[{{ $k->id }}][durasi_tipe]"
                                                                    class="form-control border-success shadow-none input-durasi-tipe">
                                                                <option value="bulan">Bulan</option>
                                                                <option value="tahun">Tahun</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @elseif($permintaan->jenis === 'kerja')

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="small font-weight-bold text-success mb-2">
                                                        Tanggal Mulai Kerja
                                                    </label>
                                                    <input type="date"
                                                        name="kandidat[{{ $k->id }}][tanggal_mulai]"
                                                        class="form-control border-success shadow-none input-mulai"
                                                        style="height:42px; border-radius:8px;">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="small font-weight-bold text-success mb-2">
                                                        Tipe Kontrak
                                                    </label>
                                                    <select name="kandidat[{{ $k->id }}][tipe_kontrak]"
                                                            class="form-control border-success shadow-none input-kontrak"
                                                            style="height:42px; border-radius:8px;">
                                                        <option value="">-- Pilih Tipe --</option>
                                                        <option value="kontrak">Kontrak</option>
                                                        <option value="tetap">Tetap</option>
                                                        <option value="os">Outsource</option>
                                                    </select>
                                                </div>
                                            </div>

                                        @endif

                                    </div>

                                    <div class="col-sm-6 wrapper-gagal d-none">
                                        <label class="small font-weight-bold text-danger uppercase mb-2">Alasan Penolakan</label>
                                        <select name="kandidat[{{ $k->id }}][alasan]" 
                                                class="form-control select-alasan border-danger shadow-none" 
                                                style="height: 42px; border-radius: 8px; font-size: 13px;">
                                            <option value="">-- Pilih Alasan --</option>
                                            <option value="Tidak sesuai kriteria">Tidak sesuai kriteria</option>
                                            <option value="Tidak lolos tes">Tidak lolos tes</option>
                                            <option value="Kuota penuh">Kuota penuh</option>
                                            <option value="Mengundurkan diri">Mengundurkan diri</option>
                                            <option value="lainnya">Lainnya...</option>
                                        </select>
                                    </div>

                                    <div class="col-12 mt-3 wrapper-catatan d-none">
                                        <input type="text" name="kandidat[{{ $k->id }}][catatan]" 
                                            class="form-control border-secondary shadow-none input-catatan" 
                                            placeholder="Tulis alasan spesifik..." 
                                            style="height: 42px; border-radius: 8px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="fixed-bottom bg-white border-top py-3 shadow-lg" style="z-index: 1000;">
                    <div class="container-fluid px-5">
                        <div class="row align-items-center text-center text-md-left">
                            <div class="col-md-6 d-none d-md-block">
                                <p class="mb-0 text-muted small">Total Kandidat: <span class="font-weight-bold text-dark">{{ count($kandidat) }} Orang</span></p>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <button type="button" class="btn btn-light px-4 mr-2 font-weight-bold border" onclick="window.history.back()">BATAL</button>
                                <button type="submit" class="btn btn-primary px-5 font-weight-bold shadow-sm" style="border-radius: 8px;">
                                    <i class="fas fa-save mr-2"></i> SIMPAN HASIL SELEKSI
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.select-status').forEach(select => {
                select.addEventListener('change', function() {

                    const card = this.closest('.item-kandidat');
                    const infoJurusan = card.querySelector('.info-jurusan');
                    const wrapGagal = card.querySelector('.wrapper-gagal');
                    const wrapCatatan = card.querySelector('.wrapper-catatan');
                    const wrapLulus = card.querySelector('.wrapper-lulus');
                    const selectAlasan = card.querySelector('.select-alasan');

                    if (this.value === 'lolos') {

                        card.style.borderLeft = "6px solid #28a745";
                        card.style.backgroundColor = "#f8fff9";
                        infoJurusan.style.borderLeftColor = "#28a745";

                        wrapGagal.classList.add('d-none');
                        wrapCatatan.classList.add('d-none');

                        if (wrapLulus) {
                            wrapLulus.classList.remove('d-none');

                            wrapLulus.querySelectorAll('input, select')
                                .forEach(el => el.setAttribute('required', 'required'));
                        }

                        selectAlasan.removeAttribute('required');

                    } else if (this.value === 'gagal') {

                        card.style.borderLeft = "6px solid #dc3545";
                        card.style.backgroundColor = "#fff8f8";
                        infoJurusan.style.borderLeftColor = "#dc3545";

                        wrapGagal.classList.remove('d-none');

                        if (wrapLulus) {
                            wrapLulus.classList.add('d-none');
                            wrapLulus.querySelectorAll('input, select')
                                .forEach(el => el.removeAttribute('required'));
                        }

                        selectAlasan.setAttribute('required', 'required');

                    } else {

                        card.style.borderLeft = "5px solid transparent";
                        card.style.backgroundColor = "#ffffff";
                        infoJurusan.style.borderLeftColor = "#6777ef";

                        wrapGagal.classList.add('d-none');
                        wrapCatatan.classList.add('d-none');

                        if (wrapLulus) {
                            wrapLulus.classList.add('d-none');
                            wrapLulus.querySelectorAll('input, select')
                                .forEach(el => el.removeAttribute('required'));
                        }

                        selectAlasan.removeAttribute('required');
                    }
                });
            });

            // Logika Alasan Lainnya
            document.querySelectorAll('.select-alasan').forEach(select => {
                select.addEventListener('change', function() {
                    const wrapCatatan = this.closest('.item-kandidat').querySelector('.wrapper-catatan');
                    const inputCatatan = wrapCatatan.querySelector('.input-catatan');
                    
                    if (this.value === 'lainnya') {
                        wrapCatatan.classList.remove('d-none');
                        inputCatatan.setAttribute('required', 'required');
                    } else {
                        wrapCatatan.classList.add('d-none');
                        inputCatatan.removeAttribute('required');
                    }
                });
            });
        });
    </script>
@endsection
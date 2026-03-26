@extends('template.main')
@section('title', 'Form Tambah Kandidat | Tracer Study')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tambah Kandidat</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('admin.permintaan.index') }}">Permintaan</a>
                </div>
                <div class="breadcrumb-item">
                    <a href="{{ route('admin.permintaan.kandidat.index', $permintaan->id) }}">Kandidat</a>
                </div>
                <div class="breadcrumb-item">Create</div>
            </div>
        </div>
        <div class="section-body">
            @if($sisaKuota <= 0)
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> Kuota untuk permintaan ini sudah terpenuhi.
                </div>
            @endif
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

            <div class="card card-primary shadow-sm">
                <div class="card-header border-bottom-0 pb-0">
                    <h4 class="text-primary"><i class="fas fa-briefcase mr-2"></i> Detail Informasi Permintaan</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7 border-right">
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <small class="text-muted text-uppercase font-weight-bold">Nama Perusahaan</small>
                                    <div class="h6 font-weight-bold text-dark mt-1">
                                        {{ $permintaan->perusahaan->nama_perusahaan ?? 'PT. Tidak Diketahui' }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <small class="text-muted text-uppercase font-weight-bold">Posisi Jabatan</small>
                                    <div class="h6 text-primary font-weight-bold mt-1">
                                        {{ $permintaan->posisi }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <small class="text-muted text-uppercase font-weight-bold">Jenis Pekerjaan</small>
                                    <div class="mt-1">
                                        <span class="badge badge-light shadow-sm text-capitalize">
                                            <i class="fas fa-clock mr-1 text-warning"></i> {{ $permintaan->jenis }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <small class="text-muted text-uppercase font-weight-bold">Kebutuhan Kuota</small>
                                    <div class="mt-1">
                                        <span class="badge badge-info shadow-sm">
                                            <i class="fas fa-users mr-1"></i> {{ $permintaan->kuota }} Orang
                                        </span>
                                        <span class="badge badge-warning shadow-sm">
                                            <i class="fas fa-hourglass-half mr-1"></i> Sisa: {{ $sisaKuota }} Orang
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 pl-md-4 mt-3 mt-md-0">
                            <small class="text-muted text-uppercase font-weight-bold">Catatan / Kualifikasi Tambahan</small>
                            <div class="mt-2 p-3 bg-light rounded border" style="min-height: 80px;">
                                @if($permintaan->catatan)
                                    <p class="mb-0 text-small text-dark italic">
                                        <i class="fas fa-info-circle text-muted mr-1"></i> 
                                        "{{ $permintaan->catatan }}"
                                    </p>
                                @else
                                    <span class="text-muted italic text-small">Tidak ada catatan tambahan.</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-primary shadow-sm">
                <div class="card-header bg-whitesmoke">
                    <h4><i class="fas fa-filter mr-2 text-primary"></i> Filter Kriteria Mahasiswa</h4>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('admin.permintaan.kandidat.create', $permintaan->id) }}">
                        <div class="row">
                            {{-- Jurusan --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">Jurusan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-graduation-cap"></i></div>
                                        </div>
                                        <select name="jurusan" class="form-control selectric">
                                            <option value="">-- Pilih Semua Jurusan --</option>
                                            @foreach($jurusan as $j)
                                                <option value="{{ $j->id }}" {{ request('jurusan') == $j->id ? 'selected' : '' }}>
                                                    {{ $j->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- IPK --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-bold">Minimal IPK</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-star"></i></div>
                                        </div>
                                        <input type="number" step="0.01" min="0" max="4" name="ipk" 
                                            value="{{ request('ipk') }}" class="form-control" placeholder="Misal: 3.25">
                                    </div>
                                </div>
                            </div>

                            {{-- Angkatan --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-bold">Tahun Angkatan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                        <select name="angkatan" class="form-control selectric">
                                            <option value="">-- Semua Angkatan --</option>
                                            @foreach($angkatan as $a)
                                                <option value="{{ $a }}" {{ request('angkatan') == $a ? 'selected' : '' }}>
                                                    {{ $a }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="col-md-2">
                                <label class="d-block">&nbsp;</label>
                                <div class="btn-group w-100" role="group">
                                    <button type="submit" name="filter" value="1" class="btn btn-primary" data-toggle="tooltip" title="Cari Mahasiswa">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <a href="{{ route('admin.permintaan.kandidat.create', $permintaan->id) }}" 
                                    class="btn btn-light" data-toggle="tooltip" title="Reset Filter">
                                        <i class="fas fa-undo"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            {{-- ===================== --}}
            {{-- FORM SIMPAN --}}
            {{-- ===================== --}}
            <form method="POST" id="form-kandidat"
                action="{{ route('admin.permintaan.kandidat.store', $permintaan->id) }}">
                @csrf

                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0" id="table-create-kandidat">
                                <thead>
                                    <tr>
                                        <th width="40"></th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Jurusan</th>
                                        <th>IPK</th>
                                        <th>Angkatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!request()->has('filter'))
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                Silakan gunakan filter untuk menampilkan mahasiswa
                                            </td>
                                        </tr>
                                    @else
                                        @forelse($mahasiswa as $m)
                                        <tr>
                                            <td>
                                                <input type="checkbox"
                                                    class="cek"
                                                    name="mahasiswa[]"
                                                    value="{{ $m->id }}">
                                            </td>
                                            <td>{{ $m->nipd }}</td>
                                            <td>{{ $m->user->nama }}</td>
                                            <td>{{ $m->kelas->jurusan->nama ?? '-' }}</td>
                                            <td>{{ $m->ipk }}</td>
                                            <td>{{ $m->kelas->tahun_masuk }}</td>
                                        </tr>
                                        @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            Tidak ada data ditemukan
                                        </td>
                                    </tr>
                                        @endforelse
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer bg-whitesmoke d-flex justify-content-between align-items-center">
                        <div class="selection-info">
                            
                            <span id="sisa-kuota-val" class="d-none">{{ $sisaKuota }}</span>

                            <span id="wrapper-total" class="badge badge-primary p-2">
                                Dipilih : <b id="total">0</b> / <span id="max-kuota">{{ $sisaKuota }}</span> Kandidat
                                <span id="status-kuota" class="ml-2 d-none trik-animasi">
                                    <i class="fas fa-check-circle"></i> Kuota Terpenuhi
                                </span>
                            </span>
                        </div>

                        <div>
                            <a href="{{ route('admin.permintaan.kandidat.index', $permintaan->id) }}" class="btn btn-secondary mr-2">Batal</a>
                            <button type="submit" id="btn-submit" class="btn btn-primary shadow-secondary" disabled>
                                <i class="fas fa-save mr-1"></i> Simpan Kandidat
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // 1. Inisialisasi DataTable (simpan ke dalam variabel 'table')
            var table = $("#table-create-kandidat").DataTable({
                "columnDefs": [
                    { "sortable": false, "targets": [0] } 
                ],
                "order": [
                    [5, "desc"], // Angkatan (Indeks 5)
                    [4, "desc"]  // IPK (Indeks 4)
                ]
            });

            // 2. Ambil nilai kuota dari elemen UI
            const maxKuota = parseInt($('#max-kuota').text());
            const formKandidat = $('#form-kandidat');

            // 3. Event Listener Checkbox (Gunakan delegasi agar jalan di semua halaman)
            $('#table-create-kandidat tbody').on('change', '.cek', function() {
                // PENTING: Gunakan table.$() agar menghitung checkbox di halaman 1, 2, dst
                let countChecked = table.$('.cek:checked').length;

                if (countChecked > maxKuota) {
                    $(this).prop('checked', false); 
                    iziToast.warning({
                        title: 'Penuh!',
                        message: 'Anda hanya bisa memilih maksimal ' + maxKuota + ' kandidat.',
                        position: 'topRight'
                    });
                    return;
                }

                // Update tampilan counter & warna badge
                $('#total').text(countChecked);
                
                if (countChecked === maxKuota) {
                    $('#wrapper-total').removeClass('badge-primary badge-light').addClass('badge-success');
                    $('#status-kuota').removeClass('d-none');
                } else if (countChecked > 0) {
                    $('#wrapper-total').removeClass('badge-success badge-light').addClass('badge-primary');
                    $('#status-kuota').addClass('d-none');
                } else {
                    $('#wrapper-total').removeClass('badge-success badge-primary').addClass('badge-light');
                    $('#status-kuota').addClass('d-none');
                }

                // Aktifkan tombol jika ada minimal 1 yang dipilih
                $('#btn-submit').prop('disabled', countChecked === 0);
            });

            // 4. Konfirmasi & Submit (Menangani data lintas halaman)
            $('#btn-submit').on('click', function(e) {
                e.preventDefault();
                
                // Hitung ulang dari semua halaman
                let countChecked = table.$('.cek:checked').length;

                if (countChecked < maxKuota) {
                    iziToast.question({
                        timeout: false,
                        close: false,
                        overlay: true,
                        displayMode: 'once',
                        id: 'question',
                        zindex: 999,
                        title: 'Konfirmasi',
                        message: 'Kuota belum penuh (' + countChecked + '/' + maxKuota + '). Tetap simpan?',
                        position: 'center',
                        buttons: [
                            ['<button><b>YA, SIMPAN</b></button>', function (instance, toast) {
                                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                                submitSemuaHalaman(formKandidat, table);
                            }, true],
                            ['<button>BATAL</button>', function (instance, toast) {
                                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                            }],
                        ]
                    });
                } else {
                    submitSemuaHalaman(formKandidat, table);
                }
            });

            // Fungsi Pembantu untuk mengumpulkan ID dari semua halaman DataTable
            function submitSemuaHalaman(form, tableInstance) {
                // Bersihkan input hidden yang mungkin lama (jika ada)
                $(form).find('input[name="mahasiswa[]"]').not('.cek').remove();

                // Ambil semua checkbox yang dicentang di seluruh halaman DataTable
                tableInstance.$('.cek:checked').each(function() {
                    // Jika checkbox tidak ada di halaman saat ini (DOM), tambahkan sebagai input hidden
                    if (!$.contains(document, this)) {
                        $(form).append(
                            $('<input>')
                                .attr('type', 'hidden')
                                .attr('name', 'mahasiswa[]')
                                .val($(this).val())
                        );
                    }
                });
                
                form.submit();
            }

            function submitSemuaHalaman(form, tableInstance) {
                // Kumpulkan data mahasiswa dari semua halaman
                let formData = {
                    _token: $('input[name="_token"]').val(),
                    mahasiswa: []
                };

                tableInstance.$('.cek:checked').each(function() {
                    formData.mahasiswa.push($(this).val());
                });

                // Kirim via AJAX
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('#btn-submit').prop('disabled', true).addClass('btn-progress');
                    },
                    success: function(response) {
                        iziToast.success({
                            title: 'Berhasil',
                            message: response.message,
                            position: 'topRight',
                            timeout: 1500,
                            onClosing: function() {
                                window.location.href = response.redirect;
                            }
                        });
                    },
                    error: function(xhr) {
                        $('#btn-submit').prop('disabled', false).removeClass('btn-progress');
                        
                        let msg = 'Terjadi kesalahan saat menyimpan.';
                        if(xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }

                        iziToast.error({
                            title: 'Gagal',
                            message: msg,
                            position: 'topRight'
                        });
                    }
                });
            }
        });

        
    </script>
@endsection
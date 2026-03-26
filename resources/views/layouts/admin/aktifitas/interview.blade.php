@extends('template.main')
@section('title', 'Riwayat Interviews | Tracer Study')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Interviews</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Interviews</div>
            </div>
        </div>
        <div class="section-body">
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

            @if(session('import_success') || session('import_failed'))

                {{-- BERHASIL --}}
                @if(session('import_success') > 0)
                    <div class="alert alert-success alert-dismissible fade show">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        ✅ {{ session('import_success') }} data berhasil diimport.
                    </div>
                @endif


                {{-- GAGAL --}}
                @if(session('import_failed') > 0)
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>

                        ❌ {{ session('import_failed') }} data gagal diimport.

                        <div class="mt-2">
                            <a class="font-weight-bold"
                            data-toggle="collapse"
                            href="#collapseFailed">
                                ▶ Lihat detail
                            </a>
                        </div>

                        <div class="collapse mt-2" id="collapseFailed">
                            <div class="border-top pt-2" style="max-height:200px; overflow:auto;">
                                <ul class="mb-0 pl-3">
                                    @foreach(session('failed_list') as $fail)
                                        <li>
                                            {{ $fail['nipd'] }} - {{ $fail['nama'] }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                    </div>
                @endif

            @endif

            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                <div>
                    <h2 class="section-title">Daftar Riwayat Interviews</h2>
                    <p class="section-lead mb-0">Tabel hanya menampilkan 200 data riwayat interviews terakhir.</p>
                </div>
                <div class="text-right">
                    <div class="text-small font-weight-bold text-muted text-uppercase">
                        Total Data
                    </div>

                    <div style="font-size:35px; font-weight:700;">
                        {{ number_format($totalInterview) }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">Daftar Riwayat Interview</h4>
                            </div>

                            <div>
                                <button class="btn btn-info" data-toggle="modal" data-target="#modalImport">
                                    <i class="fas fa-file-import"></i> Import
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="table-2">
                                    <thead>
                                        <tr>
                                            <th>Kode Permintaan</th>
                                            <th>Nama</th>
                                            <th>Perusahaan</th>
                                            <th>Posisi</th>
                                            <th>Tanggal</th>
                                            <th>Metode</th>
                                            <th>Hasil</th>
                                            {{-- <th width="12%">Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($interviews as $i)
                                            <tr>
                                                <td>
                                                    @if($i->permintaanDetail && $i->permintaanDetail->permintaan)
                                                        <a href="{{ route('admin.permintaan.kandidat.index', $i->permintaanDetail->permintaan->id) }}"
                                                        class="text-primary font-weight-bold">
                                                            {{ $i->permintaanDetail->permintaan->kode_permintaan }}
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $i->mahasiswa->user->nama ?? '-' }}</td>
                                                <td>{{ $i->perusahaan->nama_perusahaan ?? '-' }}</td>
                                                <td>{{ $i->posisi ?? '-' }}</td>
                                                <td>{{ $i->tgl_interview ?? '-' }}</td>
                                                <td>{{ $i->metode ?? '-' }}</td>
                                                <td>
                                                    @php
                                                        $hasilColor = [
                                                            'lolos' => 'text-success border-success',
                                                            'pending' => 'text-danger border-warning',
                                                            'gagal' => 'text-danger border-danger'
                                                        ][$i->hasil] ?? 'text-secondary border-secondary';
                                                    @endphp
                                                    <span class="badge border {{ $hasilColor }} px-2 py-1" style="background: transparent;">
                                                        {{ $i->hasil ?? '-' }}
                                                    </span>
                                                </td>
                                                {{-- <td>
                                                    <button class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <form action="" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- Modal modal --}}
    <!-- Modal Import -->
    <div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="modalImportLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="import-form" action="{{ route('admin.interview.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalImportLabel">Import Data Mahasiswa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="import-file" name="file" accept=".xlsx,.xls,.csv" required>
                            <label class="custom-file-label" for="import-file">Pilih file Excel</label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-info">Import</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        Tambah Data Interview
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <!-- Form -->
                <form id="formTambah">
                    @csrf

                    <div class="modal-body">

                        <!-- Mahasiswa & Perusahaan -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                            <label class="font-weight-bold">Mahasiswa</label>

                            <div class="d-flex">
                                <div class="border rounded-left bg-light px-3 d-flex align-items-center">
                                    <i class="fas fa-user text-primary"></i>
                                </div>

                                <select name="user_id" id="user_id"
                                    class="form-control select2 rounded-0 rounded-right" required></select>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Perusahaan</label>

                            <div class="d-flex">
                                <div class="border rounded-left bg-light px-3 d-flex align-items-center">
                                    <i class="fas fa-building text-primary"></i>
                                </div>

                                <select name="perusahaan_id" id="perusahaan_id"
                                    class="form-control select2 rounded-0 rounded-right" required></select>
                            </div>
                        </div>

                        </div>

                        <!-- Tanggal, Posisi, Metode -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Tanggal Interview</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-calendar-alt text-primary"></i>
                                        </span>
                                    </div>
                                    <input type="date" name="tgl_interview" id="tgl_interview"
                                        class="form-control"
                                        placeholder="Pilih tanggal..." onclick="this.showPicker()">
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Posisi</label>
                                <input type="text" name="posisi" class="form-control" placeholder="Contoh: Programmer">
                            </div>
                        </div>

                        <!-- Hasil & Keterangan -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Metode</label>
                                <select name="metode" class="form-control">
                                    <option value="offline">Offline</option>
                                    <option value="online">Online</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Hasil</label>
                                <select name="hasil" class="form-control">
                                    <option value="lolos">Lolos</option>
                                    <option value="gagal">Gagal</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Keterangan</label>
                                <textarea name="keterangan" rows="2" class="form-control"
                                    placeholder="Catatan tambahan..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#table-2").dataTable({
            "columnDefs": [
                { "sortable": true, "targets": [0,3] }
            ],
            ordering: false
        });

        $('#import-file').on('change', function() {
            // Ambil nama file
            var fileName = $(this).val().split('\\').pop();
            // Set ke label
            $(this).next('.custom-file-label').html(fileName);
        });

        $('#collapseDuplicate').on('shown.bs.collapse', function () {
            $('.toggle-duplicate').text('▼ Sembunyikan daftar eror');
        });

        $('#collapseDuplicate').on('hidden.bs.collapse', function () {
            $('.toggle-duplicate').text('▶ Lihat daftar eror');
        });






        // Tambah Form Modal
        $.fn.modal.Constructor.prototype._enforceFocus = function() {};
        $('#modalTambah').on('shown.bs.modal', function () {
            $('#user_id').select2({
                width: '100%',
                placeholder: 'Ketik 3 hufuf awal nama mahasiswa...',
                dropdownParent: $('#modalTambah'),
                minimumInputLength: 3,
                ajax: {
                    url: "{{ route('admin.mahasiswa.searchMhs') }}",
                    dataType: 'json',
                    delay: 500,
                    cache: true,
                    data: function(params) {
                        return { q: params.term };
                    },
                    processResults: function(data) {
                        return { results: data };
                    }
                }
            });

            $('#perusahaan_id').select2({
                width: '100%',
                placeholder: 'Ketik 3 hufuf awal nama perusahaan...',
                dropdownParent: $('#modalTambah'),
                minimumInputLength: 3,
                ajax: {
                    url: "{{ route('admin.perusahaan.search') }}",
                    dataType: 'json',
                    delay: 500,
                    cache: true,
                    data: function(params) {
                        return { q: params.term };
                    },
                    processResults: function(data) {
                        return { results: data };
                    }
                }
            });
        })

        // confirm modal tambah
        $('#formTambah').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.interviews.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(res) {

                     $('#modalTambah').modal('hide');

                    iziToast.success({
                        title: 'Berhasil',
                        message: res.message,
                        timeout: 1200,
                        position: 'topRight',
                        onClosing: function() {
                            location.reload();
                        }
                    });
                },
                error: function(xhr) {

                    let msg = 'Terjadi kesalahan';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }

                    iziToast.error({
                        title: 'Gagal',
                        message: msg,
                        position: 'topRight'
                    });
                }
            });
        });

    </script>
@endsection
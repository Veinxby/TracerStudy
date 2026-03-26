@extends('template.main')
@section('title', 'Form Tambah Permintaan | Tracer Study')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tambah Data Permintaan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.permintaan.index') }}">Permintaan</a></div>
                <div class="breadcrumb-item">Create</div>
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

            <div class="card card-primary shadow-md">
                <div class="card-header">
                    <h4><i class="fas fa-edit mr-2"></i> Form Permintaan Baru</h4>
                </div>
                <form action="{{ route('admin.permintaan.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            {{-- Baris Pertama --}}
                            <div class="form-group col-md-8">
                                <label class="font-weight-bold">Kode Permintaan</label>
                                <input type="text" id="kode_permintaan" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-8">
                                <label class="font-weight-bold">Perusahaan</label>
                                <select name="perusahaan_id" id="perusahaan_id" class="form-control select2" required></select>
                                <small class="form-text text-muted">Pilih perusahaan yang mengajukan permintaan.</small>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">Jenis</label>
                                <select name="jenis" class="form-control" required>
                                    <option value="magang">Magang</option>
                                    <option value="kerja">Kerja</option>
                                </select>
                            </div>

                            {{-- Baris Kedua --}}
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Posisi / Jabatan</label>
                                <input type="text" name="posisi" class="form-control" placeholder="Contoh: Staff Administrasi" required>
                            </div>

                            <div class="form-group col-md-2">
                                <label class="font-weight-bold">Kuota</label>
                                <input type="text" name="kuota" class="form-control" placeholder="0" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">Tanggal Panggilan</label>
                                <input type="date" name="tgl_panggilan" class="form-control" onclick="this.showPicker()" required>
                            </div>

                            {{-- Baris Ketiga --}}
                            <div class="form-group col-12">
                                <label class="font-weight-bold">Catatan / Kualifikasi Spesifik</label>
                                <textarea name="catatan" rows="4" class="form-control" placeholder="Tuliskan detail persyaratan di sini..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary btn-lg px-4 shadow-sm">
                            <i class="fas fa-save mr-1"></i> Simpan Permintaan
                        </button>
                        <a href="{{ route('admin.permintaan.index') }}" class="btn btn-secondary btn-lg px-4 ml-2">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function () {

            function generateKode() {
                let jenis = $('select[name="jenis"]').val();

                $.ajax({
                    url: 'generate-kode',
                    type: 'GET',
                    data: { jenis: jenis },
                    success: function(response) {
                        $('#kode_permintaan').val(response.kode);
                    }
                });
            }

            // Generate saat pertama kali load
            generateKode();

            // Generate ulang saat jenis berubah
            $('select[name="jenis"]').on('change', function() {
                generateKode();
            });

            $('#perusahaan_id').select2({
                width: '100%',
                placeholder: 'Ketik 3 hufuf awal nama perusahaan...',
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
                        if (!data || data.length === 0) {
                            return {
                                results: [{
                                    id: 'add_new',
                                    text: '➕ Perusahaan belum terdaftar. Klik untuk tambah.',
                                    isNew: true
                                }]
                            };
                        }
                        return { results: data };
                    }
                }
            });
            $('#perusahaan_id').on('select2:select', function (e) {

                if (e.params.data.id === 'add_new') {
                    window.location.href = "{{ route('admin.data-perusahaan.index') }}?open_modal=1";
                }
            });
        });
    </script>
@endsection
@extends('template.main')
@section('title', 'Form Edit Permintaan | Tracer Study')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Data Permintaan</h1>
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
            @if($p->details_count >= $p->kuota)
                <div class="alert alert-warning">
                    Kuota sudah penuh. Tidak bisa dikurangi.
                </div>
            @endif

            <div class="card card-primary shadow-md">
                <div class="card-header">
                    <h4><i class="fas fa-edit mr-2"></i> Form Edit Permintaan</h4>
                </div>

                <form action="{{ route('admin.permintaan.update', $p->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            {{-- Baris Pertama --}}
                            <div class="form-group col-md-8">
                                <label class="font-weight-bold">Perusahaan</label>
                                <select name="perusahaan_id" id="perusahaan_id" class="form-control select2" required>
                                    <option value="{{ $p->perusahaan_id }}" selected>{{ $p->perusahaan->nama_perusahaan }}</option>
                                </select>

                                <small class="form-text text-muted">Pilih perusahaan yang mengajukan permintaan.</small>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">Jenis</label>
                                <select name="jenis" class="form-control" required>
                                    <option value="magang" {{ $p->jenis == 'magang' ? 'selected' : '' }}>Magang</option>
                                    <option value="kerja" {{ $p->jenis == 'kerja' ? 'selected' : '' }}>Kerja</option>
                                </select>
                            </div>

                            {{-- Baris Kedua --}}
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Posisi / Jabatan</label>
                                <input type="text" name="posisi" class="form-control" placeholder="Contoh: Staff Administrasi" value="{{ old('posisi', $p->posisi) }}" required>
                            </div>

                            <div class="form-group col-md-2">
                                <label class="font-weight-bold">Kuota</label>
                                <input type="number" name="kuota" class="form-control @error('kuota') is-invalid @enderror" placeholder="0" min="{{ $p->details_count }}" value="{{ old('kuota', $p->kuota) }}" required>
                                @error('kuota')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">Tanggal Panggilan</label>
                                <input type="date" name="tgl_panggilan" class="form-control" onclick="this.showPicker()" value="{{ old('tgl_panggilan', $p->tgl_panggilan) }}" required>
                            </div>

                            {{-- Baris Ketiga --}}
                            <div class="form-group col-12">
                                <label class="font-weight-bold">Catatan / Kualifikasi Spesifik</label>
                                <textarea name="catatan" rows="4" class="form-control" placeholder="Tuliskan detail persyaratan di sini...">{{ old('catatan', $p->catatan) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary btn-lg px-4 shadow-sm">
                            <i class="fas fa-save mr-1"></i> Simpan Perubahan
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
                        return { results: data };
                    }
                }
            });
        });
    </script>
@endsection
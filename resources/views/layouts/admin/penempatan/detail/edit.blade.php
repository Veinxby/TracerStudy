@extends('template.main')
@section('title', 'Form Edit Kandidat | Tracer Study')

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
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>
        <div class="section-body">
            {{-- @if($sisaKuota <= 0)
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> Kuota untuk permintaan ini sudah terpenuhi.
                </div>
            @endif --}}
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
                                            <i class="fas fa-hourglass-half mr-1"></i> Sisa: 1 Orang
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

            @if($permintaan->status !== 'selesai')

                <div class="row justify-content-center mt-4">
                    <div class="col-md-8">

                        <div class="card shadow-sm border-left-warning">
                            <div class="card-header bg-white">
                                <h6 class="mb-0 font-weight-bold text-warning">
                                    <i class="fas fa-user-edit mr-2"></i> Edit / Ganti Kandidat
                                </h6>
                            </div>

                            <div class="card-body">

                                {{-- Kandidat Saat Ini --}}
                                <div class="alert alert-light border">
                                    <small class="text-muted d-block mb-1">
                                        Kandidat Saat Ini
                                    </small>
                                    <strong class="text-dark">
                                        {{ $detail->mahasiswa->user->nama }}
                                    </strong>
                                    <span class="text-muted">
                                        ({{ $detail->mahasiswa->nipd }})
                                    </span>
                                </div>

                                <form method="POST"
                                    action="{{ route('admin.permintaan.kandidat.update',
                                            [$permintaan->id, $detail->id]) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group col-md-12">
                                        <label class="font-weight-bold">Mahasiswa</label>

                                        <select name="mahasiswa_id"
                                                id="mahasiswa_id"
                                                class="form-control select2"
                                                required>

                                            <option value="">-- Pilih Mahasiswa --</option>

                                        </select>

                                        <small class="form-text text-muted">
                                            Pilih mahasiswa untuk menggantikan kandidat sebelumnya.
                                        </small>

                                        @error('mahasiswa_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <a href="{{ route('admin.permintaan.kandidat.index',
                                                $permintaan->id) }}"
                                        class="btn btn-light border">
                                            Batal
                                        </a>

                                        <button type="submit"
                                                class="btn btn-warning">
                                            <i class="fas fa-save mr-1"></i>
                                            Perbarui Kandidat
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </div>

                    </div>
                </div>

            @endif
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function () {

            $('#mahasiswa_id').select2({
                width: '100%',
                placeholder: 'Ketik minimal 3 huruf nama / NIM...',
                minimumInputLength: 3,
                ajax: {
                    url: "{{ route('admin.mahasiswa.searchMhs') }}",
                    dataType: 'json',
                    delay: 500,
                    data: function(params) { return { q: params.term }; },
                    processResults: function(data) { return { results: data }; },
                    cache: true,
                },
                templateResult: formatMahasiswa,
                templateSelection: function (data) {
                    return data.nama || data.text;
                }
            });

            function formatMahasiswa(data) {
                if (data.loading) return data.text;
                return $(
                    "<div style='display: flex; justify-content: space-between; align-items: center; padding: 2px 0;'>" +
                        "<div>" +
                            "<div style='font-weight: bold; line-height: 1.2; color: inherit;'>" + data.nama + "</div>" +
                            "<div style='font-size: 0.8em; color: #d1d1d1; margin-top: 2px;'>" + data.kode_kelas + "</div>" +
                        "</div>" +
                        "<div>" +
                            "<span style='font-size: 0.8em; border: 1px solid #ddd; padding: 2px 8px; border-radius: 4px; background: rgba(255,255,255,0.1);'>" + data.tahun + "</span>" +
                        "</div>" +
                    "</div>"
                );
            }

        });
    </script>
@endsection
<div class="tab-pane fade"
    id="tab-pendidikan">

    {{-- TOP ACTION --}}
    <div class="mhs-top-action mb-4">

        <button class="btn btn-primary btn-sm px-3"
            id="btnTambahPendidikan">

            <i class="ti ti-plus mr-1"></i>
            Tambah Pendidikan

        </button>

    </div>


    {{-- ALERT PERATURAN --}}
    <div class="alert alert-light border mb-4">

        <div class="d-flex align-items-start">

            <div class="mr-3">

                <i class="ti ti-info-circle text-primary"
                    style="font-size:20px;"></i>

            </div>

            <div>

                <div class="font-weight-bold mb-2">
                    Peraturan
                </div>

                <ul class="mb-0 pl-3 text-muted">

                    <li>
                        Ukuran maksimum file yg di-unggah adalah 1MB
                    </li>

                    <li>
                        Format file yang diterima hanya PDF, JPG, dan PNG
                    </li>

                </ul>

            </div>

        </div>

    </div>


    {{-- TABLE --}}
    <div class="table-responsive">

        <table class="table align-middle"
            id="tablePendidikan">

            <thead class="table-light">

                <tr>

                    <th width="50">No</th>

                    <th>Nama Sekolah</th>

                    <th>Lokasi</th>

                    <th>Periode</th>

                    <th>Jurusan</th>

                    <th>Dokumen</th>

                    <th width="100"
                        class="text-center">

                        Aksi

                    </th>

                </tr>

            </thead>

            <tbody>

                <tr>

                    <td>1</td>

                    <td>SMK Negeri 1 Cilegon</td>

                    <td>Cilegon, Banten</td>

                    <td>2019 - 2022</td>

                    <td>RPL</td>

                    <td>

                        <a href="#"
                            class="btn btn-light btn-sm border">

                            <i class="ti ti-file-text mr-1"></i>
                            Lihat File

                        </a>

                    </td>

                    <td>

                        <div class="d-flex justify-content-center">

                            <button class="btn btn-light btn-sm border mr-2">

                                <i class="ti ti-edit text-primary"></i>

                            </button>

                            <button class="btn btn-light btn-sm border">

                                <i class="ti ti-trash text-danger"></i>

                            </button>

                        </div>

                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>

<div class="modal fade"
    id="modalPendidikan"
    tabindex="-1"
    role="dialog"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered"
        role="document">

        <div class="modal-content border-0 shadow">

            {{-- HEADER --}}
            <div class="modal-header border-0 pb-2">

                <div>

                    <h5 class="modal-title font-weight-bold mb-1">
                        Tambah Riwayat Pendidikan
                    </h5>

                    <small class="text-muted">
                        Lengkapi data pendidikan mahasiswa
                    </small>

                </div>

                <button type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>


            {{-- BODY --}}
            <div class="modal-body pt-3 px-4">

                <form id="formPendidikan">

                    <div class="row">

                        {{-- Jenjang --}}
                        <div class="col-md-6 mb-3">

                            <label class="font-weight-semibold mb-2">
                                Jenjang Pendidikan
                            </label>

                            <select class="form-control">

                                <option value="">
                                    -- Pilih Jenjang --
                                </option>

                                <option>SD</option>
                                <option>SMP</option>
                                <option>SMA</option>
                                <option>SMK</option>

                            </select>

                        </div>


                        {{-- Nama Sekolah --}}
                        <div class="col-md-6 mb-3">

                            <label class="font-weight-semibold mb-2">
                                Nama Sekolah
                            </label>

                            <input type="text"
                                class="form-control"
                                placeholder="Masukkan nama sekolah">

                        </div>


                        {{-- Lokasi --}}
                        <div class="col-12 mb-3">

                            <label class="font-weight-semibold mb-2">
                                Lokasi Sekolah
                            </label>

                            <textarea class="form-control"
                                rows="3"
                                placeholder="Masukkan alamat atau lokasi sekolah"></textarea>

                        </div>


                        {{-- Periode --}}
                        <div class="col-md-6 mb-3">

                            <label class="font-weight-semibold mb-2">
                                Periode Pendidikan
                            </label>

                            <div class="row">

                                <div class="col-6">

                                    <input type="number"
                                        class="form-control"
                                        placeholder="Tahun Masuk">

                                </div>

                                <div class="col-6">

                                    <input type="number"
                                        class="form-control"
                                        placeholder="Tahun Lulus">

                                </div>

                            </div>

                        </div>


                        {{-- Jurusan --}}
                        <div class="col-md-6 mb-3">

                            <label class="font-weight-semibold mb-2">
                                Jurusan
                            </label>

                            <input type="text"
                                class="form-control"
                                placeholder="Masukkan jurusan">

                        </div>


                        {{-- Upload Dokumen --}}
                        <div class="col-12 mb-2">

                            <label class="font-weight-semibold mb-2">
                                Upload Dokumen
                            </label>

                            <div class="custom-file">

                                <input type="file"
                                    class="custom-file-input"
                                    id="dokumenPendidikan">

                                <label class="custom-file-label"
                                    for="dokumenPendidikan">

                                    Pilih file...

                                </label>

                            </div>

                            <small class="text-muted d-block mt-2">

                                Maksimal ukuran file 1MB.
                                Format file yang diterima:
                                PDF, JPG, PNG

                            </small>

                        </div>

                    </div>

                </form>

            </div>


            {{-- FOOTER --}}
            <div class="modal-footer border-0 pt-2 px-4 pb-4">

                <button type="button"
                    class="btn btn-light px-4"
                    data-dismiss="modal">

                    Batal

                </button>

                <button type="submit"
                    form="formPendidikan"
                    class="btn btn-primary px-4">

                    <i class="ti ti-device-floppy mr-1"></i>
                    Simpan

                </button>

            </div>

        </div>

    </div>

</div>

@push('script')
    <script>
        $('#tablePendidikan').DataTable({
            pageLength: 5,
            lengthMenu: [5, 10, 25],

            language: {
                search: "",
                searchPlaceholder: "Cari keluarga..."
            },

            columnDefs: [
                {
                    sortable: false,
                    targets: [6]
                },
                {
                    className: "dt-center",
                    targets: [3, 6]
                }
            ],

            order: [[2, 'asc']]
        });

        $('#btnTambahPendidikan').on('click', function () {

            $('#modalPendidikan').modal('show');

        });
    </script>
@endpush
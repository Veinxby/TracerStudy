<div class="tab-pane fade" id="tab-biodata-keluarga">

    <div class="d-flex justify-content-end mb-3">

        <button class="btn btn-primary btn-sm px-3 rounded-3 shadow-sm"
            id="btnTambahKeluarga">

            <i class="ti ti-plus me-1"></i>
            Tambah Keluarga

        </button>

    </div>

    <div class="table-responsive">

        <table class="table align-middle"
            id="tableKeluarga">

            <thead class="table-light">
                <tr>
                    <th>NIK</th>
                    <th>Hubungan</th>
                    <th>Nama</th>
                    <th>JK</th>
                    <th>Pekerjaan</th>
                    <th>No HP</th>
                    <th>Status</th>
                    <th width="90">Aksi</th>
                </tr>
            </thead>

            <tbody>

                <tr>
                    <td>3674010101010001</td>

                    <td>
                        <span class="badge bg-primary-subtle text-primary">
                            Ayah
                        </span>
                    </td>

                    <td>Budi Santoso</td>

                    <td>L</td>

                    <td>PNS</td>

                    <td>081234567890</td>

                    <td>
                        <span class="badge bg-success-subtle text-success">
                            Hidup
                        </span>
                    </td>

                    <td>

                        <div class="d-flex justify-content-center gap-2">

                            <button class="btn btn-light btn-sm border rounded-3">
                                <i class="ti ti-edit text-primary"></i>
                            </button>

                            <button class="btn btn-light btn-sm border rounded-3">
                                <i class="ti ti-trash text-danger"></i>
                            </button>

                        </div>

                    </td>
                </tr>

                <tr>
                    <td>3674010101010002</td>

                    <td>
                        <span class="badge bg-danger-subtle text-danger">
                            Ibu
                        </span>
                    </td>

                    <td>Siti Aminah</td>

                    <td>P</td>

                    <td>Guru</td>

                    <td>081298765432</td>

                    <td>
                        <span class="badge bg-success-subtle text-success">
                            Hidup
                        </span>
                    </td>

                    <td>

                        <div class="d-flex justify-content-center gap-2">

                            <button class="btn btn-light btn-sm border rounded-3">
                                <i class="fas fa-edit text-primary"></i>
                            </button>

                            <button class="btn btn-light btn-sm border rounded-3">
                                <i class="fas fa-trash text-danger"></i>
                            </button>

                        </div>

                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>


<div class="modal fade" id="modalKeluarga" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered"
        role="document">

        <div class="modal-content border-0 shadow">

            {{-- HEADER --}}
            <div class="modal-header border-0 pb-2">

                <div>
                    <h5 class="modal-title font-weight-bold mb-1">
                        Tambah Data Keluarga
                    </h5>

                    <small class="text-muted">
                        Lengkapi data anggota keluarga anda
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

                <form id="formKeluarga">

                    <div class="row">

                        {{-- NIK --}}
                        <div class="col-md-6 mb-3">

                            <label class="font-weight-semibold mb-2">
                                NIK
                            </label>

                            <input type="text"
                                class="form-control"
                                placeholder="Masukkan NIK">

                        </div>

                        {{-- Nama --}}
                        <div class="col-md-6 mb-3">

                            <label class="font-weight-semibold mb-2">
                                Nama Lengkap
                            </label>

                            <input type="text"
                                class="form-control"
                                placeholder="Masukkan nama lengkap">

                        </div>

                        {{-- Hubungan --}}
                        <div class="col-md-6 mb-3">

                            <label class="font-weight-semibold mb-2">
                                Hubungan
                            </label>

                            <select class="form-control">

                                <option value="">
                                    -- Pilih Hubungan --
                                </option>

                                <option>Ayah</option>
                                <option>Ibu</option>
                                <option>Kakak</option>
                                <option>Adik</option>
                                <option>Wali</option>

                            </select>

                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="col-md-6 mb-3">

                            <label class="font-weight-semibold d-block mb-3">
                                Jenis Kelamin
                            </label>

                            <div class="d-flex align-items-center">

                                <div class="custom-control custom-radio mr-4">

                                    <input type="radio"
                                        id="jkL"
                                        name="jk"
                                        class="custom-control-input"
                                        checked>

                                    <label class="custom-control-label"
                                        for="jkL">

                                        Laki-Laki

                                    </label>

                                </div>

                                <div class="custom-control custom-radio">

                                    <input type="radio"
                                        id="jkP"
                                        name="jk"
                                        class="custom-control-input">

                                    <label class="custom-control-label"
                                        for="jkP">

                                        Perempuan

                                    </label>

                                </div>

                            </div>

                        </div>

                        {{-- Pekerjaan --}}
                        <div class="col-md-6 mb-3">

                            <label class="font-weight-semibold mb-2">
                                Pekerjaan
                            </label>

                            <input type="text"
                                class="form-control"
                                placeholder="Masukkan pekerjaan">

                        </div>

                        {{-- No HP --}}
                        <div class="col-md-6 mb-3">

                            <label class="font-weight-semibold mb-2">
                                No HP
                            </label>

                            <input type="text"
                                class="form-control"
                                placeholder="08xxxxxxxxxx">

                        </div>

                        {{-- Status --}}
                        <div class="col-md-6 mb-2">

                            <label class="font-weight-semibold mb-2">
                                Status
                            </label>

                            <select class="form-control">

                                <option value="">
                                    -- Pilih Status --
                                </option>

                                <option>Hidup</option>
                                <option>Meninggal</option>

                            </select>

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
                    form="formKeluarga"
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
        $('#tableKeluarga').DataTable({
            pageLength: 5,
            lengthMenu: [5, 10, 25],

            language: {
                search: "",
                searchPlaceholder: "Cari keluarga..."
            },

            columnDefs: [
                {
                    sortable: false,
                    targets: [7]
                },
                {
                    className: "dt-center",
                    targets: [3, 6, 7]
                }
            ],

            order: [[2, 'asc']]
        });

        $('#btnTambahKeluarga').on('click', function () {

            $('#modalKeluarga').modal('show');

        });
    </script>
@endpush
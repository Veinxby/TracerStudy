@extends('layouts.mahasiswa')
@section('title', 'Profile Biodata | OASIS LP3I Banten')
@section('style')
    <style>

body{
    background:#f4f7fb;
    font-family:'Segoe UI',sans-serif;
    color:#334155;
}

/* WRAPPER */
.mhs-bio-wrapper{
    padding:30px 15px;
}

/* =========================
    HERO
========================= */

.mhs-profile-hero{
    position:relative;

    background:linear-gradient(
        135deg,
        #ffffff 0%,
        #f8fbff 100%
    );

    border-radius:28px;

    padding:35px;

    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:25px;

    margin-bottom:28px;

    overflow:hidden;

    border:1px solid rgba(226,232,240,.8);

    box-shadow:
        0 15px 40px rgba(15,23,42,.04),
        0 2px 8px rgba(15,23,42,.03);
}

.mhs-hero-pattern{
    position:absolute;

    top:-120px;
    right:-120px;

    width:320px;
    height:320px;

    border-radius:50%;

    background:
        radial-gradient(
            rgba(37,99,235,.5),
            transparent 70%
        );

    pointer-events:none;
}

.mhs-hero-pattern-2{
    position:absolute;

    bottom:-100px;
    left:-100px;

    width:240px;
    height:240px;

    border-radius:50%;

    background:
        radial-gradient(
            rgba(56,189,248,.35),
            transparent 70%
        );

    pointer-events:none;
}

.mhs-profile-left,
.mhs-profile-action{
    position:relative;
    z-index:2;
}

.mhs-profile-left{
    display:flex;
    align-items:center;
    gap:25px;
    flex-wrap:wrap;
}

/* =========================
    AVATAR
========================= */

.mhs-bio-avatar-wrapper{
    position:relative;
}

.mhs-bio-file-input{
    display:none;
}

.mhs-bio-avatar{
    width:160px;
    height:160px;

    border-radius:50%;

    background:#e2e8f0;

    display:flex;
    align-items:center;
    justify-content:center;

    position:relative;
    overflow:hidden;

    cursor:pointer;

    border:5px solid #fff;

    box-shadow:
        0 10px 25px rgba(0,0,0,.08);

    transition:.3s ease;
}

#imgPreview{
    width:100%;
    height:100%;
    object-fit:cover;
    position:absolute;
    inset:0;
}

.mhs-bio-avatar:hover{
    transform:translateY(-3px);
}

.mhs-bio-avatar i.fa-user{
    font-size:70px;
    color:#94a3b8;
}

.mhs-avatar-action{
    margin-top:12px;
    display:flex;
    gap:10px;
    justify-content:center;
}

/* base button */
.mhs-avatar-action button{
    border:none;
    padding:7px 16px;
    border-radius:var(--radius-md);
    font-size:13px;
    font-weight:500;
    cursor:pointer;

    transition:var(--transition);

    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:6px;
}

/* =========================
   SIMPAN
========================= */
.mhs-btn-save-photo{
    background:var(--primary);
    color:#fff;

    box-shadow:var(--shadow-sm);
}

.mhs-btn-save-photo:hover{
    background:var(--primary-light);
    transform:translateY(-1px);
    box-shadow:var(--shadow-md);
}

/* =========================
   BATAL
========================= */
.mhs-btn-cancel-photo{
    background:var(--gray-100);
    color:var(--text-secondary);
}

.mhs-btn-cancel-photo:hover{
    background:var(--gray-200);
    transform:translateY(-1px);
}

/* OVERLAY */
.mhs-bio-avatar-overlay{
    position:absolute;
    inset:0;

    background:rgba(15,23,42,.5);

    display:flex;
    align-items:center;
    justify-content:center;

    opacity:0;
    transition:.3s ease;
}

.mhs-bio-avatar:hover .mhs-bio-avatar-overlay{
    opacity:1;
}

.mhs-bio-avatar-overlay i{
    color:#fff;
    font-size:32px;
}

/* =========================
    INFO
========================= */

.mhs-profile-info{
    display:flex;
    flex-direction:column;
}

.mhs-bio-name{
    font-size:34px;
    font-weight:700;
    color:#0f172a;
    margin-bottom:8px;
    line-height:1.2;
}

.mhs-bio-major{
    font-size:15px;
    color:#64748b;

    margin-bottom:16px;

    display:flex;
    align-items:center;
    gap:8px;
}

.mhs-bio-major::before{
    content:'';

    width:8px;
    height:8px;

    border-radius:50%;

    background:#2563eb;
}

.mhs-profile-meta{
    display:flex;
    align-items:center;
    flex-wrap:wrap;
    gap:10px;

    margin-top:2px;
}

.mhs-bio-batch{
    display:inline-flex;
    align-items:center;
    justify-content:center;

    padding:8px 18px;

    border-radius:50px;

    background:#eff6ff;
    color:#2563eb;

    font-size:13px;
    font-weight:700;

    border:1px solid rgba(37,99,235,.08);
}

.mhs-profile-semester{
    display:inline-flex;
    align-items:center;
    justify-content:center;

    padding:8px 16px;

    border-radius:50px;

    background:#f8fafc;
    color:#475569;

    font-size:13px;
    font-weight:600;

    border:1px solid #e2e8f0;
}

/* =========================
    BUTTON
========================= */

.mhs-bio-change-password{
    display:inline-flex;
    align-items:center;
    gap:10px;

    padding:15px 22px;

    border-radius:16px;

    background:#0f172a;
    color:#fff;

    font-size:14px;
    font-weight:600;

    text-decoration:none !important;

    transition:.3s ease;

    box-shadow:
        0 10px 25px rgba(15,23,42,.12);
}

.mhs-bio-change-password:hover{
    transform:translateY(-2px);

    background:#1e293b;

    color:#fff;
}

/* =========================
    CARD
========================= */

.mhs-bio-data-card{
    background:#fff;
    border-radius:24px;

    padding:30px;

    box-shadow:
        0 10px 30px rgba(0,0,0,.04);
}

.mhs-bio-title{
    font-size:28px;
    font-weight:700;
    color:#0f172a;
    margin:0;
}


/* TABS */

.tab-content{
    margin-top:20px;
}

.mhs-empty-state{
    border:1px dashed #dbe2ea;

    border-radius:18px;

    padding:60px 20px;

    text-align:center;

    background:#f8fafc;

    color:#94a3b8;

    font-size:15px;

    font-weight:500;
}

.mhs-bio-tabs{
    border-bottom:1px solid rgba(148, 163, 184, 0.25);

    margin-bottom:50px;

    display:grid;

    grid-template-columns:
        repeat(auto-fit, minmax(140px, 1fr));

    gap:10px;

    width:100%;
}

.mhs-bio-tabs::-webkit-scrollbar{
    display:none;
}

.mhs-bio-tabs .nav-item{
    width:100%;
}

.mhs-bio-tabs .nav-link{
    position:relative;

    border:none !important;
    background:none !important;

    padding:10px 8px 14px;

    color:#64748b;

    font-size:14px;
    font-weight:600;

    text-align:center;

    transition:.25s ease;

    line-height:1.4;

    white-space:normal;

    word-break:break-word;
}

.mhs-bio-tabs .nav-link::after{
    content:'';

    position:absolute;

    left:50%;
    bottom:0;

    transform:translateX(-50%);

    width:0%;
    height:2px;

    background:#2563eb;

    border-radius:20px;

    transition:.5s ease;
}

.mhs-bio-tabs .nav-link:hover{
    color:#414858;
}

.mhs-bio-tabs .nav-link:hover::after{
    width:100%;
}

.mhs-bio-tabs .nav-link.active{
    color:#414858;
    font-weight:700;
}

.mhs-bio-tabs .nav-link.active::after{
    width:100%;
}

.mhs-top-action{
    display:flex;
    justify-content:flex-end;
    align-items:center;
}


/* =========================
    FORM
========================= */

.form-group{
    margin-bottom:22px;
}

.form-group label{
    font-size:13px;
    font-weight:600;
    color:#475569;
    margin-bottom:8px;
}

.required{
    color:#ef4444;
}

.form-control{
    height:50px;

    border-radius:14px;

    border:1px solid #dbe2ea;

    padding:12px 15px;

    font-size:14px;

    box-shadow:none !important;
}

.form-control:focus{
    border-color:#60a5fa;
    box-shadow:0 0 0 4px rgba(96,165,250,.15) !important;
}

textarea.form-control{
    height:auto;
}

.custom-radio-group{
    display:flex;
    gap:20px;
    padding-top:5px;
}



/* =========================
    BUTTON SAVE
========================= */

.mhs-form-action{
    margin-top:10px;
}

.mhs-save-btn{
    border:none;

    background:#2563eb;
    color:#fff;

    padding:14px 25px;

    border-radius:14px;

    font-size:14px;
    font-weight:600;

    transition:.3s ease;
}

.mhs-save-btn:hover{
    background:#1d4ed8;
}

/* =========================
    RESPONSIVE
========================= */

@media (max-width:991.98px){

    .mhs-profile-hero{
        padding:25px;
    }

    .mhs-bio-avatar{
        width:140px;
        height:140px;
    }

    .mhs-bio-name{
        font-size:25px;
    }

    .mhs-bio-tabs{
        grid-template-columns:
            repeat(auto-fit, minmax(130px, 1fr));
    }

}

@media (max-width:767.98px){

    .mhs-profile-hero{
        flex-direction:column;
        align-items:flex-start;
    }

    .mhs-profile-left{
        width:100%;
        flex-direction:column;
        align-items:center;
        text-align:center;
    }

    .mhs-profile-info{
        align-items:center;
    }

    .mhs-profile-action{
        width:100%;
    }

    .mhs-bio-change-password{
        width:100%;
        justify-content:center;
    }

    .mhs-bio-data-card{
        padding:22px 18px;
    }

    .mhs-bio-tabs{
        flex-wrap:nowrap;
        overflow-x:auto;
        overflow-y:hidden;
        padding-bottom:5px;
    }

    .mhs-bio-tabs .nav-item{
        flex:0 0 auto;
    }

    .mhs-bio-tabs .nav-link{
        white-space:nowrap;
    }
}

@media (max-width:575.98px){

    .mhs-bio-wrapper{
        padding:18px 10px;
    }

    .mhs-profile-hero,
    .mhs-bio-data-card{
        border-radius:20px;
    }

    .mhs-bio-avatar{
        width:120px;
        height:120px;
    }

    .mhs-bio-avatar i.fa-user{
        font-size:55px;
    }

    .mhs-bio-name{
        font-size:21px;
    }

    .mhs-bio-major{
        font-size:13px;
    }

    .mhs-bio-title{
        font-size:22px;
    }

    .mhs-bio-tabs{
        grid-template-columns:
            repeat(2, 1fr);

        gap:6px;
    }

    .mhs-bio-tabs .nav-link{
        font-size:12px;

        padding:8px 4px 12px;
    }
}

</style>
@endsection
    
@section('content')

    <div class="container-fluid mhs-bio-wrapper px-xl-4 px-2">

        {{-- PROFILE HERO --}}
        <div class="mhs-profile-hero">

            <div class="mhs-hero-pattern"></div>
            <div class="mhs-hero-pattern-2"></div>

            <div class="mhs-profile-left">

                {{-- AVATAR --}}
                <div class="mhs-bio-avatar-wrapper">

                    <input type="file"
                        id="profileUpload"
                        class="mhs-bio-file-input"
                        accept="image/*">

                    <label for="profileUpload" class="mhs-bio-avatar">

                        <img id="imgPreview" src="" alt="Preview" style="display:none;">

                        <i class="fas fa-user"></i>

                        <div class="mhs-bio-avatar-overlay">
                            <i class="fas fa-camera"></i>
                        </div>

                    </label>

                    {{-- Tombol update avatar --}}
                    <div class="mhs-avatar-action">

                        <button type="button" id="btnSavePhoto" class="mhs-btn-save-photo" style="display:none;">
                            Simpan Foto
                        </button>

                        <button type="button" id="btnCancelPhoto" class="mhs-btn-cancel-photo" style="display:none;">
                            Batal
                        </button>

                    </div>

                </div>


                {{-- INFO --}}
                <div class="mhs-profile-info">

                    <h2 class="mhs-bio-name">
                        Muhammad Teguh Imaduddin
                    </h2>

                    <div class="mhs-bio-major">
                        Application Software Engineering
                    </div>

                    <div class="mhs-profile-meta">

                        <div class="mhs-bio-batch">
                            ASE 56
                        </div>

                        <div class="mhs-profile-semester">
                            Semester 4
                        </div>

                    </div>

                </div>

            </div>

            <div class="mhs-profile-action">

                <a href="#" class="mhs-bio-change-password">
                    <i class="fas fa-key"></i>
                    Change Password
                </a>

            </div>

        </div>


        {{-- BIODATA CARD --}}
        <div class="mhs-bio-data-card">

            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

                <h3 class="mhs-bio-title" id="bioTitle">
                    Info Personal
                </h3>

            </div>

            <!-- TABS -->
            <ul class="nav mhs-bio-tabs">

                <li class="nav-item">
                    <a href="#tab-info-personal" 
                        class="nav-link active"
                        data-toggle="tab"
                        data-title="Info Personal">
                        Info Personal
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#tab-biodata-keluarga" 
                        class="nav-link"
                        data-toggle="tab"
                        data-title="Biodata Keluarga">
                        Biodata Keluarga
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#tab-pendidikan" 
                        class="nav-link"
                        data-toggle="tab">
                        Pendidikan
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#tab-training" 
                        class="nav-link"
                        data-toggle="tab">
                        Training
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#tab-pengalaman-kerja" 
                        class="nav-link"
                        data-toggle="tab">
                        Pengalaman Kerja
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#tab-dokumen" 
                        class="nav-link"
                        data-toggle="tab">
                        Dokumen
                    </a>
                </li>

            </ul>

            {{-- TAB CONTENT --}}

            <div class="tab-content">

                @include('mahasiswa.profile.tabs.personal')

                @include('mahasiswa.profile.tabs.keluarga')

                @include('mahasiswa.profile.tabs.pendidikan')

                @include('mahasiswa.profile.tabs.training')

                @include('mahasiswa.profile.tabs.pengalaman')

                @include('mahasiswa.profile.tabs.dokumen')   

                {{-- PENDIDIKAN --}}

                <div class="tab-pane fade"
                    id="tab-pendidikan">

                    <div class="mhs-empty-state">
                        Isi Riwayat Pendidikan disini
                    </div>

                </div>


                {{-- TRAINING --}}

                <div class="tab-pane fade"
                    id="tab-training">

                    <div class="mhs-empty-state">
                        Isi Data Training disini
                    </div>

                </div>


                {{-- PENGALAMAN KERJA --}}

                <div class="tab-pane fade"
                    id="tab-pengalaman-kerja">

                    <div class="mhs-empty-state">
                        Isi Pengalaman Kerja disini
                    </div>

                </div>


                {{-- DOKUMEN --}}

                <div class="tab-pane fade"
                    id="tab-dokumen">

                    <div class="mhs-empty-state">
                        Upload Dokumen disini
                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {

            $('.mhs-bio-tabs .nav-link').on('shown.bs.tab', function (e) {
                console.log('TAB PINDAH');

                let title = $(e.target).data('title') || $(e.target).text().trim();
                $('#bioTitle').text(title);
            });


            $('#profileUpload').on('change', function (e) {

                const file = e.target.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        $('#imgPreview')
                            .attr('src', e.target.result)
                            .fadeIn(400)
                            .show();

                        // sembunyikan icon default
                        $('.mhs-bio-avatar i.fa-user').hide();
                    };

                    reader.readAsDataURL(file);
                }

            });

            let originalImage = '';

            $('#profileUpload').on('change', function (e) {

                const file = e.target.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function (e) {

                        // simpan lama (optional)
                        originalImage = $('#imgPreview').attr('src');

                        $('#imgPreview')
                            .attr('src', e.target.result)
                            .fadeIn(150);

                        $('.mhs-bio-avatar i.fa-user').hide();

                        // tampilkan tombol
                        $('#btnSavePhoto, #btnCancelPhoto').show();
                    };

                    reader.readAsDataURL(file);
                }

            });

            // tombol batal
            $('#btnCancelPhoto').on('click', function () {

                $('#imgPreview').attr('src', originalImage);

                if (!originalImage) {
                    $('#imgPreview').hide();
                    $('.mhs-bio-avatar i.fa-user').show();
                }

                $('#btnSavePhoto, #btnCancelPhoto').hide();
                $('#profileUpload').val('');
            });

            // tombol simpan (sementara UI saja)
            $('#btnSavePhoto').on('click', function () {

                alert('Foto berhasil disimpan (UI only)');

                $('#btnSavePhoto, #btnCancelPhoto').hide();
            });

        });

        
    </script>
@endsection
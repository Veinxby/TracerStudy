<div class="sidebar-brand">
    <a href="index.html">Tracer Study</a>
</div>
<div class="sidebar-brand sidebar-brand-sm">
    <a href="index.html">TS</a>
</div>
<ul class="sidebar-menu">

    <li class="menu-header">Dashboard</li>

    {{-- DASHBOARD --}}
    @if(auth()->user()->hasRole(['adm_tracer','educ','it']))
        <li class="{{ request()->is('adm/dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/adm/dashboard') }}">
                <i class="fas fa-fire"></i>
                <span>Dashboard</span>
            </a>
        </li>
    @elseif(auth()->user()->role === 'mhs')
        <li class="{{ request()->is('mhs/dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/mhs/dashboard') }}">
                <i class="fas fa-fire"></i>
                <span>Dashboard</span>
            </a>
        </li>
    @elseif(auth()->user()->role === 'bm')
        <li class="{{ request()->is('bm/dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/bm/dashboard') }}">
                <i class="fas fa-fire"></i>
                <span>Dashboard</span>
            </a>
        </li>
    @endif

    {{-- HEADER DATA hanya muncul kalau ada salah satu menu yang tampil --}}
    @if(auth()->user()->hasRole(['adm_tracer','educ','it']))
        <li class="menu-header">
            <i class="fas fa-database"></i> Data
        </li>
    @endif

    @if(auth()->user()->hasRole(['adm_tracer','educ','it']))
        <li class="{{ request()->is('adm/data-mhs*') ? 'active' : '' }}">
            <a class="nav-link" href="/adm/data-mhs">
                <i class="fas fa-user-graduate"></i>
                <span>Data Mahasiswa</span>
            </a>
        </li>
    @endif

    @if(auth()->user()->hasRole(['educ','it']))
        <li class="{{ request()->is('adm/jurusan*') ? 'active' : '' }}">
            <a class="nav-link" href="/adm/jurusan">
                <i class="fas fa-graduation-cap"></i>
                <span>Data Jurusan</span>
            </a>
        </li>
    @endif

    @if(auth()->user()->hasRole(['adm_tracer','it']))
        <li class="{{ request()->is('adm/data-perusahaan*') ? 'active' : '' }}">
            <a class="nav-link" href="/adm/data-perusahaan">
                <i class="fas fa-building"></i>
                <span>Data Perusahaan</span>
            </a>
        </li>
    @endif

    @if(auth()->user()->hasRole(['adm_tracer','it']))
        <li class="menu-header"><i class="fas fa-random"></i> Permintaan</li>

        <li class="{{ request()->is('adm/permintaan*') ? 'active' : '' }}">
            <a class="nav-link" href="/adm/permintaan">
                <i class="fas fa-clipboard-list"></i>
                <span>Permintaan</span>
            </a>
        </li>
    @endif

    @if(auth()->user()->hasRole(['adm_tracer','educ','it']))
        <li class="menu-header"><i class="fas fa-history"></i> Tracer</li>

        <li class="{{ request()->is('adm/interviews*') ? 'active' : '' }}">
            <a class="nav-link" href="/adm/interviews">
                <i class="fas fa-comments"></i>
                <span>Interviews</span>
            </a>
        </li>

        <li class="{{ request()->is('adm/penempatan*') ? 'active' : '' }}">
            <a class="nav-link" href="/adm/penempatan">
                <i class="fas fa-briefcase"></i>
                <span>Penempatan</span>
            </a>
        </li>
    @endif

    @if(auth()->user()->hasRole('it'))
        <li class="menu-header">User</li>

        <li class="{{ request()->is('adm/user*') ? 'active' : '' }}">
            <a class="nav-link" href="/adm/user">
                <i class="fas fa-cog"></i>
                <span>User</span>
            </a>
        </li>
    @endif
    
    
</ul>

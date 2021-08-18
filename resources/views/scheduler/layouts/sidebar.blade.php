        <aside id="aside">
            <nav id="sideNav">
                <ul class="nav nav-list">
                    <li>
                        <a class="dashboard" href="">
                            <i class="main-icon et-linegraph"></i> <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="main-icon et-profile-male"></i> <span>User</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="main-icon et-profile-male"></i> <span>Kelas</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="main-icon fa fa-graduation-cap"></i> <span>Guru</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="main-icon et-profile-male"></i> <span>Jam Pelajaran</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="main-icon et-profile-male"></i> <span>Tahun Ajaran</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="main-icon et-profile-male"></i> <span>Mata Pelajaran</span>
                        </a>
                    </li>
                </ul>

                @isset($school)
                    <h3></h3>
                    <ul class="nav nav-list">
                        <li>
                            <a href="">
                                <i class="main-icon fa fa-code-fork"></i> <span>Struktur Organisasi</span>
                            </a>
                        </li>

                        <li>
                            <a href="">
                                <i class="main-icon et-calendar"></i> <span>Tahun Ajaran</span>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <i class="fa fa-menu-arrow pull-right"></i>
                                <i class="main-icon et-profile-male"></i> <span>Pengguna</span>
                            </a>
                            <ul>
                                <li><a href="">Admin</a></li>
                                <li><a href="">Guru</a></li>
                                <li><a href="">Siswa</a></li>
                                <li><a href="">Orang Tua Siswa</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="">
                                <i class="main-icon et-flag"></i> <span>Daftar Kelas</span>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <i class="fa fa-menu-arrow pull-right"></i>
                                <i class="main-icon et-tools"></i> <span>Mata Pelajaran</span>
                            </a>
                            <ul>
                                <li><a href="">Kelompok Mapel</a></li>
                                <li><a href="">Daftar Mata Pelajaran</a></li>
                                <li><a href="">Jadwal</a></li>
                                <li><a href="">Nilai</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="#">
                                <i class="fa fa-menu-arrow pull-right"></i>
                                <i class="main-icon et-telescope"></i> <span>Ekstrakurikuler</span>
                            </a>
                            <ul>
                                <li><a href="">Daftar Ekstrakurikuler</a></li>
                                <li><a href="">Jadwal</a></li>
                                <li><a href="">Nilai</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="">
                                <i class="main-icon et-clock"></i> <span>Data Presensi</span>
                            </a>
                        </li>

                        <li>
                            <a href="">
                                <i class="main-icon et-lifesaver"></i> <span>Data Presensi Harian</span>
                            </a>
                        </li>

                        <li>
                            <a href="" target="_blank">
                                <i class="main-icon et-clock"></i> <span>Presensi Sekolah</span>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <i class="fa fa-menu-arrow pull-right"></i>
                                <i class="main-icon et-tools-2"></i> <span>Pengaturan</span>
                            </a>
                            <ul>
                                <li><a href="">Predikat Nilai</a></li>
                                <li><a href="">Bobot Penilaian</a></li>
                                <li><a href="">Pengaturan Umum</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-menu-arrow pull-right"></i>
                                <i class="main-icon et-upload"></i> <span>Import Data</span>
                            </a>
                            <ul>
                                <li><a href="">Pengguna Guru</a></li>
                                <li><a href="">Pengguna Siswa</a></li>
                                <li><a href="">Daftar Kelas</a></li>
                                <li><a href="">Siswa Kelas</a></li>
                                <li><a href="">Mapel & Kelompok Mapel</a></li>
                                <li><a href="">KI & KD</a></li>
                                <li><a href="">Jadwal</a></li>
                            </ul>
                        </li>
                    </ul>
                @endisset
            </nav>

            <span id="asidebg"></span>
        </aside>

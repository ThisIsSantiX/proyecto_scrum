    <nav class="nav navbar py-2 navbar-expand-lg navbar-light iq-navbar bg-transparent fixed-top">
        <div class="container-fluid navbar-inner">
            <a href="{{ route ('dashboard') }}" class="navbar-brand">
                <!--Logo start-->
                <!--logo End-->
                
                <!--Logo start-->
                <div class="logo-main">
                    <div class="logo-normal">
                        <img src="../../assets/images/logos/workscrum.png" alt="" width="40" height="40">
                    </div>
                    <div class="logo-mini">
                        <img src="../../assets/images/logos/workscrum.png" alt="" width="40" height="40">
                    </div>
                </div>
                <!--logo End-->
                
                
                
                
                <h4 class="logo-title">WorkScrum</h4>
            </a>
            <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                <i class="icon">
                    <svg  width="20px" class="icon-20" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                </svg>
                </i>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon">
                    <span class="mt-2 navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto align-items-center mb-2 mb-lg-0">
                    <!-- Modo oscuro -->
                    <li class="nav-item">
                        <a href="#" class="nav-link" id="darkModeToggle">
                            <svg id="moonIcon" class="icon-24" style="display:block;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M21 12.79A9 9 0 0111.21 3 7 7 0 0012 17a7 7 0 009-4.21z"/>
                            </svg>
                            <svg id="sunIcon" class="icon-24" style="display:none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="2"/>
                                <path stroke="currentColor" stroke-width="2" d="M12 1v2m0 18v2m11-11h-2M3 12H1m16.95 6.95l-1.41-1.41M6.46 6.46 5.05 5.05m12.9 0-1.41 1.41M6.46 17.54l-1.41 1.41"/>
                            </svg>
                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-center ms-2 me-3">
                        <div class="border-start border-gray mx-3" style="height:24px; opacity:0.5;"></div>
                    </li>

                    <!-- Usuario -->
                    <li class="nav-item dropdown">
                    <a class="nav-link p-0" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @php
                            $foto = Auth::user()->foto_url;
                            $esExterno = Str::startsWith($foto, ['http://', 'https://']);
                        @endphp

                        <img src="{{ $esExterno ? $foto : asset('storage/' . $foto) }}"
                            alt="User-Profile"
                            class="img-fluid rounded-circle"
                            style="width: 35px; height: 35px;">
                    </a>
                        <ul class="dropdown-menu dropdown-menu-end p-3 shadow-lg rounded-4" 
                            aria-labelledby="navbarDropdown" 
                            style="min-width: 300px; max-width: 350px; transition: all 0.3s ease;">

                            <!-- Título Cuenta -->
                            <li class="ps-1">
                                <span class="text-uppercase text-muted small">Cuenta</span>
                            </li>

                            <!-- Header del usuario -->
                            <li class="px-3 py-3 d-flex align-items-center border-bottom">
                                @php
                                    $foto = Auth::user()->foto_url;
                                    $esExterno = Str::startsWith($foto, ['http://', 'https://']);
                                @endphp
                                <img src="{{ $esExterno ? $foto : asset('storage/' . $foto) }}"
                                    alt="User-Profile"
                                    class="img-fluid rounded-circle me-3"
                                    style="width: 50px; height: 50px;">
                                <div class="d-flex flex-column">
                                    <span class="fs-6">{{ Auth::user()->nombre}} {{ Auth::user()->apellido}}</span>
                                    <small class="text-muted">{{ Auth::user()->email }}</small>
                                </div>
                            </li>

                            <!-- Opciones -->
                            <li class="mt-2">
                                <a class="dropdown-item d-flex align-items-center py-2 px-3 rounded-2" 
                                href="{{ route('user.profile', Auth::user()->username) }}">
                                    <i class="fas fa-user-circle me-2"></i> Perfil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2 px-3 rounded-2" 
                                href="../dashboard/app/user-privacy-setting.html">
                                    <i class="fas fa-lock me-2"></i> Ajustes Privacidad
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2 px-3 rounded-2 text-danger" 
                                href="#" 
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </nav
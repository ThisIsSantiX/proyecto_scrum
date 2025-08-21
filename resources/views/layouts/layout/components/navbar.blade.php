    <nav class="nav navbar py-2 navbar-expand-lg navbar-light iq-navbar">
        <div class="container-fluid navbar-inner">
            <a href="../dashboard/index.html" class="navbar-brand">
                <!--Logo start-->
                <!--logo End-->
                
                <!--Logo start-->
                <div class="logo-main">
                    <div class="logo-normal">
                        <svg class="text-primary icon-30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2" transform="rotate(-45 -0.757324 19.2427)" fill="currentColor"/>
                            <rect x="7.72803" y="27.728" width="28" height="4" rx="2" transform="rotate(-45 7.72803 27.728)" fill="currentColor"/>
                            <rect x="10.5366" y="16.3945" width="16" height="4" rx="2" transform="rotate(45 10.5366 16.3945)" fill="currentColor"/>
                            <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2" transform="rotate(45 10.5562 -0.556152)" fill="currentColor"/>
                        </svg>
                    </div>
                    <div class="logo-mini">
                        <svg class="text-primary icon-30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2" transform="rotate(-45 -0.757324 19.2427)" fill="currentColor"/>
                            <rect x="7.72803" y="27.728" width="28" height="4" rx="2" transform="rotate(-45 7.72803 27.728)" fill="currentColor"/>
                            <rect x="10.5366" y="16.3945" width="16" height="4" rx="2" transform="rotate(45 10.5366 16.3945)" fill="currentColor"/>
                            <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2" transform="rotate(45 10.5562 -0.556152)" fill="currentColor"/>
                        </svg>
                    </div>
                </div>
                <!--logo End-->
                
                
                
                
                <h4 class="logo-title">Hope UI</h4>
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

                    <!-- Equipo -->
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link" id="team-drop" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg class="icon-24" width="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="9" cy="8" r="3" fill="currentColor"/>
                                <circle cx="17" cy="8" r="3" fill="currentColor" opacity="0.7"/>
                                <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd" 
                                    d="M4 20c0-2.667 2.667-4 5-4s5 1.333 5 4H4zM14 20c0-2.667 2.667-4 5-4s5 1.333 5 4h-10z" 
                                    fill="currentColor"/>
                            </svg>
                            <span class="bg-success count-team"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="team-drop" style="min-width: 300px;">
                            <h6 class="dropdown-header">Mi Equipo</h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <svg class="icon-20 me-2" width="20" viewBox="0 0 24 24" fill="none">
                                    <circle cx="9" cy="8" r="3" fill="currentColor"/>
                                    <circle cx="17" cy="8" r="3" fill="currentColor" opacity="0.7"/>
                                    <path opacity="0.4" d="M4 20c0-2.667 2.667-4 5-4s5 1.333 5 4H4zM14 20c0-2.667 2.667-4 5-4s5 1.333 5 4h-10z" fill="currentColor"/>
                                </svg>
                                Gestionar a los miembros del equipo
                            </a>
                            <div class="text-center mt-3">
                                <p class="mb-0 text-muted">
                                    No tienes invitaciones pendientes<br>
                                    <small>Invita a miembros al equipo para disfrutar de una colaboración.</small>
                                </p>
                            </div>
                        </div>
                    </li>

                    <!-- Usuario -->
                    <li class="nav-item dropdown">
                        <a class="nav-link p-0" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ Auth::user()->foto_url }}" 
                                alt="User-Profile" 
                                class="img-fluid rounded-circle" 
                                style="width: 35px; height: 35px;">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="../dashboard/app/user-profile.html">Profile</a></li>
                            <li><a class="dropdown-item" href="../dashboard/app/user-privacy-setting.html">Privacy Setting</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="#" 
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Cerrar Sesion
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
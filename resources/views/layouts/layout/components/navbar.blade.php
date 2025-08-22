    <nav class="nav navbar py-2 navbar-expand-lg navbar-light iq-navbar bg-transparent">
        <div class="container-fluid navbar-inner">
            <a href="{{ route ('dashboard') }}" class="navbar-brand">
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
                
                
                
                
                <h4 class="logo-title">Scrum</h4>
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

            <div class="dropdown ms-auto">
                <button class="btn btn-primary btn-sm dropdown-toggle px-3" type="button" id="dropdownNew" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg viewBox="0 0 24 24" width="15px" height="24px" data-icon="Plus" focusable="false" class="svg-icon me-1">
                    <path fill="currentColor" fill-rule="evenodd"
                        d="M13,4 L13,10 C13,10.5522847 13.4477153,11 14,11 L20,11 C20.5522847,11 21,11.4477153 21,12 C21,12.5522847 20.5522847,13 20,13 L14,13 C13.4477153,13 13,13.4477153 13,14 L13,20 C13,20.5522847 12.5522847,21 12,21 C11.4477153,21 11,20.5522847 11,20 L11,14 C11,13.4477153 10.5522847,13 10,13 L4,13 C3.44771525,13 3,12.5522847 3,12 C3,11.4477153 3.44771525,11 4,11 L10,11 C10.5522847,11 11,10.5522847 11,10 L11,4 C11,3.44771525 11.4477153,3 12,3 C12.5522847,3 13,3.44771525 13,4 Z">
                    </path>
                    </svg>
                    Nuevo...
                </button>

                <ul class="dropdown-menu dropdown-menu-start shadow rounded-3 bg-body-tertiary mt-1" aria-labelledby="dropdownNew">
                <li>
                    <a class="dropdown-item d-flex align-items-center py-2" href="#">
                    <i class="bi bi-check-circle me-2 fs-5"></i> 
                    <span class="fw-semibold">Tarea</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center py-2" href="#">
                    <i class="bi bi-grid me-2 fs-5"></i> 
                    <span class="fw-semibold">Proyecto</span>
                    </a>
                </li>
                </ul>


            </div>

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
                    <li class="nav-item dropdown ms-2">
                        <a href="#" class="nav-link" id="team-drop" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon">
                                <svg class="icon-21" width="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.9488 14.54C8.49884 14.54 5.58789 15.1038 5.58789 17.2795C5.58789 19.4562 8.51765 20.0001 11.9488 20.0001C15.3988 20.0001 18.3098 19.4364 18.3098 17.2606C18.3098 15.084 15.38 14.54 11.9488 14.54Z" fill="currentColor"></path>
                                    <path opacity="0.4" d="M11.949 12.467C14.2851 12.467 16.1583 10.5831 16.1583 8.23351C16.1583 5.88306 14.2851 4 11.949 4C9.61293 4 7.73975 5.88306 7.73975 8.23351C7.73975 10.5831 9.61293 12.467 11.949 12.467Z" fill="currentColor"></path>
                                    <path opacity="0.4" d="M21.0881 9.21923C21.6925 6.84176 19.9205 4.70654 17.664 4.70654C17.4187 4.70654 17.1841 4.73356 16.9549 4.77949C16.9244 4.78669 16.8904 4.802 16.8725 4.82902C16.8519 4.86324 16.8671 4.90917 16.8895 4.93889C17.5673 5.89528 17.9568 7.0597 17.9568 8.30967C17.9568 9.50741 17.5996 10.6241 16.9728 11.5508C16.9083 11.6462 16.9656 11.775 17.0793 11.7948C17.2369 11.8227 17.3981 11.8371 17.5629 11.8416C19.2059 11.8849 20.6807 10.8213 21.0881 9.21923Z" fill="currentColor"></path>
                                    <path d="M22.8094 14.817C22.5086 14.1722 21.7824 13.73 20.6783 13.513C20.1572 13.3851 18.747 13.205 17.4352 13.2293C17.4155 13.232 17.4048 13.2455 17.403 13.2545C17.4003 13.2671 17.4057 13.2887 17.4316 13.3022C18.0378 13.6039 20.3811 14.916 20.0865 17.6834C20.074 17.8032 20.1698 17.9068 20.2888 17.8888C20.8655 17.8059 22.3492 17.4853 22.8094 16.4866C23.0637 15.9589 23.0637 15.3456 22.8094 14.817Z" fill="currentColor"></path>
                                    <path opacity="0.4" d="M7.04459 4.77973C6.81626 4.7329 6.58077 4.70679 6.33543 4.70679C4.07901 4.70679 2.30701 6.84201 2.9123 9.21947C3.31882 10.8216 4.79355 11.8851 6.43661 11.8419C6.60136 11.8374 6.76343 11.8221 6.92013 11.7951C7.03384 11.7753 7.09115 11.6465 7.02668 11.551C6.3999 10.6234 6.04263 9.50765 6.04263 8.30991C6.04263 7.05904 6.43303 5.89462 7.11085 4.93913C7.13234 4.90941 7.14845 4.86348 7.12696 4.82926C7.10906 4.80135 7.07593 4.78694 7.04459 4.77973Z" fill="currentColor"></path>
                                    <path d="M3.32156 13.5127C2.21752 13.7297 1.49225 14.1719 1.19139 14.8167C0.936203 15.3453 0.936203 15.9586 1.19139 16.4872C1.65163 17.4851 3.13531 17.8066 3.71195 17.8885C3.83104 17.9065 3.92595 17.8038 3.91342 17.6832C3.61883 14.9167 5.9621 13.6046 6.56918 13.3029C6.59425 13.2885 6.59962 13.2677 6.59694 13.2542C6.59515 13.2452 6.5853 13.2317 6.5656 13.2299C5.25294 13.2047 3.84358 13.3848 3.32156 13.5127Z" fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="bg-success count-team"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end p-0 rounded-4" aria-labelledby="team-drop" style="min-width: 300px;">
                            <h6 class="dropdown-header  fw-semibold mt-3 mb-3 ps-4 pe-4 fs-6">Mi equipo</h6>
                            <a class="dropdown-item d-flex mb-4 me-2 ms-2 text-body align-items-center small" href="#">
                                <i class="icon me-2">
                                    <svg class="icon-20" width="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.9488 14.54C8.49884 14.54 5.58789 15.1038 5.58789 17.2795C5.58789 19.4562 8.51765 20.0001 11.9488 20.0001C15.3988 20.0001 18.3098 19.4364 18.3098 17.2606C18.3098 15.084 15.38 14.54 11.9488 14.54Z" fill="currentColor"></path>
                                        <path opacity="0.4" d="M11.949 12.467C14.2851 12.467 16.1583 10.5831 16.1583 8.23351C16.1583 5.88306 14.2851 4 11.949 4C9.61293 4 7.73975 5.88306 7.73975 8.23351C7.73975 10.5831 9.61293 12.467 11.949 12.467Z" fill="currentColor"></path>
                                        <path opacity="0.4" d="M21.0881 9.21923C21.6925 6.84176 19.9205 4.70654 17.664 4.70654C17.4187 4.70654 17.1841 4.73356 16.9549 4.77949C16.9244 4.78669 16.8904 4.802 16.8725 4.82902C16.8519 4.86324 16.8671 4.90917 16.8895 4.93889C17.5673 5.89528 17.9568 7.0597 17.9568 8.30967C17.9568 9.50741 17.5996 10.6241 16.9728 11.5508C16.9083 11.6462 16.9656 11.775 17.0793 11.7948C17.2369 11.8227 17.3981 11.8371 17.5629 11.8416C19.2059 11.8849 20.6807 10.8213 21.0881 9.21923Z" fill="currentColor"></path>
                                        <path d="M22.8094 14.817C22.5086 14.1722 21.7824 13.73 20.6783 13.513C20.1572 13.3851 18.747 13.205 17.4352 13.2293C17.4155 13.232 17.4048 13.2455 17.403 13.2545C17.4003 13.2671 17.4057 13.2887 17.4316 13.3022C18.0378 13.6039 20.3811 14.916 20.0865 17.6834C20.074 17.8032 20.1698 17.9068 20.2888 17.8888C20.8655 17.8059 22.3492 17.4853 22.8094 16.4866C23.0637 15.9589 23.0637 15.3456 22.8094 14.817Z" fill="currentColor"></path>
                                        <path opacity="0.4" d="M7.04459 4.77973C6.81626 4.7329 6.58077 4.70679 6.33543 4.70679C4.07901 4.70679 2.30701 6.84201 2.9123 9.21947C3.31882 10.8216 4.79355 11.8851 6.43661 11.8419C6.60136 11.8374 6.76343 11.8221 6.92013 11.7951C7.03384 11.7753 7.09115 11.6465 7.02668 11.551C6.3999 10.6234 6.04263 9.50765 6.04263 8.30991C6.04263 7.05904 6.43303 5.89462 7.11085 4.93913C7.13234 4.90941 7.14845 4.86348 7.12696 4.82926C7.10906 4.80135 7.07593 4.78694 7.04459 4.77973Z" fill="currentColor"></path>
                                        <path d="M3.32156 13.5127C2.21752 13.7297 1.49225 14.1719 1.19139 14.8167C0.936203 15.3453 0.936203 15.9586 1.19139 16.4872C1.65163 17.4851 3.13531 17.8066 3.71195 17.8885C3.83104 17.9065 3.92595 17.8038 3.91342 17.6832C3.61883 14.9167 5.9621 13.6046 6.56918 13.3029C6.59425 13.2885 6.59962 13.2677 6.59694 13.2542C6.59515 13.2452 6.5853 13.2317 6.5656 13.2299C5.25294 13.2047 3.84358 13.3848 3.32156 13.5127Z" fill="currentColor"></path>
                                    </svg>
                                </i>
                                Gestionar a los miembros del equipo
                            </a>
                            <div class="text-center ps-4 pe-4 pt-4 pb-4 bg-opacity-50">
                                <i class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20%" height="100%" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12V5.778c0-.472-.19-.924-.527-1.257A1.812 1.812 0 0 0 19.2 4H4.8c-.477 0-.935.187-1.273.52A1.767 1.767 0 0 0 3 5.779v10.666c0 .978.81 1.778 1.8 1.778H12m9-11.555-8.073 5.066a1.762 1.762 0 0 1-1.854 0L3 6.667m15.3 8V20m-2.7-2.667H21"></path></svg>
                                </i>
                                <p class="text-muted mt-3 fw-normal mb-0">
                                    No tienes invitaciones pendientes<br>
                                    <small class="fw-light">Invita a miembros al equipo para disfrutar de una colaboración.</small>
                                </p>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item d-flex align-items-center ms-2 me-3">
                        <div class="border-start border-gray mx-3" style="height:24px; opacity:0.5;"></div>
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
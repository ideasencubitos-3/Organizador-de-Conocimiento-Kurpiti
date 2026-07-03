<nav class="navbar navbar-standard navbar-expand-lg navbar-dark fixed-top py-0" 
     style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); min-height: 81px;"
     data-navbar-darken-on-scroll="data-navbar-darken-on-scroll">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-1" href="index.html">
      <img src="imagenes/no-imagen.png" style="width: 45px; height: 45px;">
      <b class="text-white" style="font-size: 0.9rem;">Kurpiti</b>
    </a>
    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarStandard" aria-controls="navbarStandard" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarStandard">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item d-flex align-items-center me-2">
          <div class="dropdown theme-control-dropdown landing-drop">
            <a class="nav-link d-flex align-items-center dropdown-toggle" href="#" role="button" 
               id="themeSwitchDropdown" 
               data-bs-toggle="dropdown" 
               data-bs-display="static"
               aria-haspopup="true" aria-expanded="false">
              <span class="d-none d-lg-block">
                <span class="fas fa-sun" data-theme-dropdown-toggle-icon="light"></span>
                <span class="fas fa-moon" data-theme-dropdown-toggle-icon="dark"></span>
                <span class="fas fa-adjust" data-theme-dropdown-toggle-icon="auto"></span>
              </span>
              <span class="d-lg-none">Cambiar tema</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg-end border py-0 mt-1" aria-labelledby="themeSwitchDropdown">
              <div class="bg-white dark__bg-1000 rounded-2 py-2">
                <button class="dropdown-item link-600 d-flex align-items-center gap-2" type="button" value="light" data-theme-control="theme">
                  <span class="fas fa-sun"></span>Claro
                  <span class="fas fa-check dropdown-check-icon ms-auto text-600"></span>
                </button>
                <button class="dropdown-item link-600 d-flex align-items-center gap-2" type="button" value="dark" data-theme-control="theme">
                  <span class="fas fa-moon"></span>Oscuro
                  <span class="fas fa-check dropdown-check-icon ms-auto text-600"></span>
                </button>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
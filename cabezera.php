    <!-- Favicon básico -->
    <link rel="icon" type="image/png" sizes="32x32" href="imagenes/no-imagen.png?v=2">
    <link rel="icon" type="image/png" sizes="16x16" href="imagenes/no-imagen.png?v=2">
    <!-- Cambios de temas clasro/oscuro -->
    <script src="js/config.js"></script>
    <script src="js/simplebar.min.js"></script>
    <!-- ===================================== -->

    <!-- ===============================================--><!--    Stylesheets--><!-- ===============================================-->
    <link rel="stylesheet" href="css/glightbox.min.css" />
    <link href="css/swiper-bundle.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
    <link href="css/simplebar.min.css" rel="stylesheet">
    <link href="css/theme-rtl.min.css" rel="stylesheet" id="style-rtl">
    <link href="css/theme.min.css" rel="stylesheet" id="style-default">
    <link href="css/user-rtl.min.css" rel="stylesheet" id="user-style-rtl">
    <link href="css/user.min.css" rel="stylesheet" id="user-style-default">
    <link href="css/estilos.css" rel="stylesheet" id="user-style-default">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
      var isRTL = JSON.parse(localStorage.getItem('isRTL'));
      if (isRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.getElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
      } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
      }
    </script>
<!-- ================================================================================================================== -->
<?php 
 function tiempo_transcurrido($fecha) {
      $ahora = new DateTime();
      $publicado = new DateTime($fecha);
      $diferencia = $ahora->diff($publicado);

      if ($diferencia->y > 0) {
          return "hace " . $diferencia->y . " año" . ($diferencia->y > 1 ? "s" : "");
      } elseif ($diferencia->m > 0) {
          return "hace " . $diferencia->m . " mes" . ($diferencia->m > 1 ? "es" : "");
      } elseif ($diferencia->d > 0) {
          return "hace " . $diferencia->d . " día" . ($diferencia->d > 1 ? "s" : "");
      } elseif ($diferencia->h > 0) {
          return "hace " . $diferencia->h . " hora" . ($diferencia->h > 1 ? "s" : "");
      } elseif ($diferencia->i > 0) {
          return "hace " . $diferencia->i . " minuto" . ($diferencia->i > 1 ? "s" : "");
      } else {
          return "hace unos segundos";
      }
  }

?>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <!-- Responsive CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">

    <!-- Incluir SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Incluir SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- ================================================================================================================== -->    
    <script src="js/jquery-3.6.1.min.js"></script>

    <script src="../js/appweb_consumidor.js" defer></script>
    <script src="../js/c-boxy.js" defer></script>
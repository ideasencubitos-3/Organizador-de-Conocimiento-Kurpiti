<!DOCTYPE html>
<html data-bs-theme="light" lang="es-MEX" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kurpiti </title>

    <?php include'cabezera.php';?>
  </head>

  <body>
<?php include'menu_login.php';?>    
<br><br><br><br><br><br>
  

      <!-- ============================================--><!-- <section> begin ============================-->

          <ul class="nav nav-pills" id="pill-myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="pill-inicio-tab" data-bs-toggle="tab" href="#pill-tab-inicio" role="tab">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="pill-grafos-tab" data-bs-toggle="tab" href="#pill-tab-grafos" role="tab">Grafos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="pill-contacto-tab" data-bs-toggle="tab" href="#pill-tab-contacto" role="tab">Contacto</a>
            </li>
          </ul>

          <div class="tab-content border p-3 mt-3" id="pill-myTabContent">
            <div class="tab-pane fade show active" id="pill-tab-inicio" role="tabpanel">
              <?php include'inicio.php'?>
            </div>
            <div class="tab-pane fade" id="pill-tab-grafos" role="tabpanel">
              <?php include'grafos-inicio.php'?>
            </div>
            <div class="tab-pane fade" id="pill-tab-contacto" role="tabpanel">
              <?php include'contacto.php'?>
            </div>
          </div>




    <!-- ===============================================--><!--    JavaScripts--><!-- ===============================================--> 
    <?php include'footer.php';?>
  <?php include'pie-js.php';?>
  
<!--===============================================================================================-->
<script>
function confirmDelete(event, btn) {
    event.preventDefault();
    event.stopPropagation();
    Swal.fire({
        title: '¿Estás seguro?',
        html: "¡No podrás revertir esto!<br><small class='text-danger'>",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminarla',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            btn.closest('form').submit();
        }
    });
}
</script>
<!-- ===============================================-->
     <script>
        const textarea = document.getElementById('contenidotxt');
        const counter = document.getElementById('countcontenido');
        const maxLength = parseInt(textarea.getAttribute('maxlength'), 10);

        const updateCounter = () => {
            const remainingChars = maxLength - textarea.value.length;
            counter.textContent = `${remainingChars} caracteres restantes`;
        };

        updateCounter();

        textarea.addEventListener('input', updateCounter);
    </script>
<!-- =====================Gestiona-redireccion-en-Tab-desde-controlador-=====================-->
    <script>
document.addEventListener("DOMContentLoaded", function () {
    const hash = window.location.hash;

    if (hash) {
        const triggerEl = document.querySelector('[href="' + hash + '"]');

        if (triggerEl) {
            let tab = new bootstrap.Tab(triggerEl);
            tab.show();
        }
    }
});
</script>
</body>
</html>
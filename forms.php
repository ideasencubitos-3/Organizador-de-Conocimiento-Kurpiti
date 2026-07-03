<?php 
include 'conexion.php';

?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="es-MEX" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kurpiti </title>

    <?php include'cabezera.php';?>
    <script src="../js/panel_administrador_login.js" defer></script> 
  </head>

  <body>
<?php include'menu_login.php';?> <br><br><br>
      <!-- ============================================--><!-- <section> begin ============================-->
      <section class="bg-body-tertiary dark__bg-opacity-50 text-center pt-6 pb-6" id="banner">

        <?php if($_POST['tipo_form']=='editar_nodo'){?>

          <?php 
             $id_nodo=$_POST['id_nodo'];
             $id_grafo=$_POST['id_grafo'];
             $query_1 = "SELECT 
                            g.*,
                            n.*
                        FROM grafos g
                        JOIN nodos n 
                            ON n.id_grafo = g.id
                        WHERE n.id = '$id_nodo'
                        ORDER BY n.id ASC
                        LIMIT 1";
            $resultado1 = mysqli_query($conexion, $query_1)or die("Error en el query: " . mysqli_error($conexion));
          ?>

          <form action="grafo.php" method="post" class="d-flex justify-content-start ms-11">
            <input type="hidden" name="id_grafo" value="<?php echo $id_grafo;?>">
            
            <button class="btn btn-primary btn-sm mt-2" type="submit">
              Atras
            </button>
          </form>

          <div class="d-flex justify-content-center align-items-center" style="min-height: 10vh;">
            <div class="card shadow-none navbar-card-login" style="width: 300px;">
                <div class="card-body fs-10 p-4 fw-normal">
                  <div class="row text-start justify-content-between align-items-center mb-2">
                      <div class="col-auto">
                        <h5 class="mb-0">Editar nodo</h5>
                      </div>                 
                  </div>

                   <?php
                      $carpeta = 0;
                      while($fila1 = mysqli_fetch_array($resultado1)){ 
                              //$id_nodo = $fila1['id'];
                              //$nombren = $fila1['nombren'];
                              //$contenidon=$fila1['contenidon'];
                              $carpeta='imagenes/img_grafos/' . $fila1['img'];
                    ?>

                        <!-- CONTENEDOR CIRCULAR -->
                          <div class=" overflow-hidden mx-auto" >

                          <?php 
                          $carpeta  = 'imagenes/img_grafos/' . $fila1['img'] . '/';
                          $imagenes = glob($carpeta . '*.{jpg,png,gif,jpeg,webp}', GLOB_BRACE);
                          $count = 0; // ← AQUÍ la corrección

                          if($imagenes){
                          ?>

                          <div class="card-body overflow-hidden">
                              <div class="row mx-n1">
                                  <?php 
                                  $imagenes = array_slice($imagenes, 0, 5);
                                  foreach($imagenes as $imagen){
                                      $count++;
                                      $rutaImg = $imagen;
                                  ?>
                                      <div class="col-6 p-1 position-relative">
                                          <a class="glightbox" 
                                             href="<?php echo $rutaImg; ?>"
                                             data-gallery="gallery-<?php echo $fila1['id']; ?>">
                                              <img class="img-fluid rounded" 
                                                   src="<?php echo $rutaImg; ?>" 
                                                   alt="" />
                                          </a>
                                          <form action="controlador.php" method="post" style="position:absolute; top:8px; right:8px;">
                                              <input type="hidden" name="id_nodo"   value="<?php echo $fila1['id']; ?>">
                                              <input type="hidden" name="id_grafo"  value="<?php echo $fila1['id_grafo']; ?>">
                                              <input type="hidden" name="imagen"    value="<?php echo $rutaImg; ?>">
                                              <input type="hidden" name="tipo_form" value="eliminar_imagen">
                                              <button type="submit" class="btn btn-danger btn-sm">
                                                  <i class="fas fa-trash-alt"></i>
                                              </button>
                                          </form>
                                      </div>
                                  <?php } ?>
                              </div>
                          </div>
                          </div>

                              <?php } else { ?>
                                 <!--<img class="w-100 h-100" style="object-fit:cover;" src="imagenes/no-image.png">-->
                              <?php } ?>

                             <?php if($count<5){ ?>
                                  <form  action="controlador.php" method="post" enctype="multipart/form-data">

                                      <div class="col-md-auto d-flex align-items-center justify-content-center">
                                              <div id="previewImagen" class="preview-grid"></div>
                                      </div>

                                        <div class="col-md">
                                          <div class="text-center">
                                              <label for="archivo" style="cursor:pointer;">
                                                <i class="fas fa-images fa-2x mb-2"></i>
                                                  <div>Selecciona hasta 5 imágenes para tu publicación </div>
                                                  <p class="mb-0 fs-10 text-400">
                                                    JPG, PNG o GIF · Mín. 300x300 por imagen
                                                  </p>
                                              </label>

                                          <input type="file" name="archivo[]" id="archivo" accept="image/*" style="display:none;" multiple>
                                          <input type="hidden" name="id_nodo" value="<?php echo $fila1['id']; ?>">
                                          <input type="hidden" name="id_grafo" value="<?php echo $fila1['id_grafo']; ?>">
                                          <input type="hidden" name="carpeta" value="<?php echo $carpeta; ?>">
                                          <input type="hidden" name="tipo_form" value="registrar_imagen">
                                      </div>
                                      </div>
                                      <button class="btn btn-primary d-block w-100 mt-3" id="boton" type="submit">Registrar</button>
                                          <center><div id="animacion"></div></center>

                                    </form>
                            <?php }?>                              
                                  <br>

                                  <form  action="controlador.php" method="post" enctype="multipart/form-data">

                                        <div class="col-md">                                        
                                              
                                          <label class="mb-1 text-start" style="text-align: left; display: block;"><b>Nombre*</b></label> 
                                          <input class="form-control" type="text" name="nombre"  value="<?php echo $fila1['nombren']; ?>">


                                          <div id="countcontenido">500 caracteres restantes para contenido</div>
                                          <textarea class="form-control" name="contenido" id="contenido" maxlength="500" rows="4" cols="50" placeholder="Contenido*" required><?php echo $fila1['contenidon']; ?></textarea>

                                          <input type="hidden" name="id_nodo" value="<?php echo $fila1['id']; ?>">
                                          <input type="hidden" name="id_grafo" value="<?php echo $fila1['id_grafo']; ?>">
                                          <input type="hidden" name="tipo_form" value="editar_info_nodo">
                                     
                                        </div>
                                      <button class="btn btn-primary d-block w-100 mt-3" id="boton" type="submit">Editar</button>
                                          <center><div id="animacion"></div></center>

                                  </form>

                    
                     <?php }?><!--Termina While.---> 

    
              </div>
            </div>
          </div>
         

        <?php }elseif($_POST['tipo_form']=='editar_relacion'){?>
          <?php 
            $id_relacion=$_POST['id_relacion'];
            $id_grafo=$_POST['id_grafo'];
            $query_1 = "SELECT * FROM relaciones WHERE id='$id_relacion' AND id_grafo='$id_grafo'";
            $resultado1 = mysqli_query($conexion, $query_1)or die("Error en el query: " . mysqli_error($conexion));
          ?>
          <form action="grafo.php" method="post" class="d-flex justify-content-start ms-11">
            <input type="hidden" name="id_grafo" value="<?php echo $id_grafo;?>">
            
            <button class="btn btn-primary btn-sm mt-2" type="submit">
              Atras
            </button>
          </form>

          <div class="d-flex justify-content-center align-items-center" style="min-height: 10vh;">
            <div class="card shadow-none navbar-card-login" style="width: 300px;">
                <div class="card-body fs-10 p-4 fw-normal">
                  <div class="row text-start justify-content-between align-items-center mb-2">
                      <div class="col-auto">
                        <h5 class="mb-0">Editar relacion</h5>
                      </div>                 
                  </div>

                   <?php
                      while($fila1 = mysqli_fetch_array($resultado1)){ 
                          
                    ?>

                    
                    <form  action="controlador.php" method="post">

                      <div class="col-md">                                        
                                              
                        <label class="mb-1 text-start" style="text-align: left; display: block;"><b>Nombre*</b></label> 
                        <input class="form-control" type="text" name="nombre"  value="<?php echo $fila1['nombre']; ?>">


                        <div id="countcontenido">500 caracteres restantes para contenido</div>
                        <textarea class="form-control" name="contenido" id="contenido" maxlength="500" rows="4" cols="50" placeholder="Contenido*" required><?php echo $fila1['contenido']; ?></textarea>

                        <input type="hidden" name="id_relacion" value="<?php echo $fila1['id']; ?>">
                        <input type="hidden" name="id_grafo" value="<?php echo $fila1['id_grafo']; ?>">
                        <input type="hidden" name="tipo_form" value="editar_info_relacion">
                                     
                      </div>
                      <button class="btn btn-primary d-block w-100 mt-3" id="boton" type="submit">Editar</button>
                      <center><div id="animacion"></div></center>

                    </form>

                     <?php }?><!--Termina While.---> 

    
              </div>
            </div>
          </div>
         
        <?php }elseif($_POST['tipo_form']=='editar_grafo'){?>
          <?php 
            $id_grafo=$_POST['id_grafo'];
            $query_1 = "SELECT * FROM grafos WHERE id='$id_grafo'";
            $resultado1 = mysqli_query($conexion, $query_1)or die("Error en el query: " . mysqli_error($conexion));
          ?>
            <div class="text-start">
            <a class="btn btn-primary btn-sm mt-2 ms-4 mb-2" href="index.php?ok=1#pill-tab-grafos"> 
              Atras
            </a>
          </div>

          <div class="d-flex justify-content-center align-items-center" style="min-height: 10vh;">
            <div class="card shadow-none navbar-card-login" style="width: 300px;">
                <div class="card-body fs-10 p-4 fw-normal">
                  <div class="row text-start justify-content-between align-items-center mb-2">
                      <div class="col-auto">
                        <h5 class="mb-0">Editar grafo</h5>
                      </div>                 
                  </div>

                   <?php
                      while($fila1 = mysqli_fetch_array($resultado1)){ 
                          
                    ?>
                    
                    <form  action="controlador.php" method="post">

                      <div class="col-md">                                        
                                              
                        <label class="mb-1 text-start" style="text-align: left; display: block;"><b>Nombre*</b></label> 
                        <input class="form-control" type="text" name="nombre"  value="<?php echo $fila1['nombre']; ?>">

                        <div id="countcontenido">500 caracteres restantes para descripción</div>
                        <textarea class="form-control" name="descripcion" id="contenido" maxlength="500" rows="4" cols="50" placeholder="descripción*" required><?php echo $fila1['descripcion']; ?></textarea>

                        <input type="hidden" name="id_grafo" value="<?php echo $fila1['id']; ?>">
                        <input type="hidden" name="tipo_form" value="editar_info_grafo">
                                     
                      </div>
                      <button class="btn btn-primary d-block w-100 mt-3" id="boton" type="submit">Editar</button>
                      <center><div id="animacion"></div></center>

                    </form>

                     <?php }?><!--Termina While.---> 

    
              </div>
            </div>
          </div>
        <?php }?><!--Termina condicion-->
      </section><!-- <section> close ============================--><!-- ============================================-->



    <!-- ===============================================--><!--    JavaScripts--><!-- ===============================================--> 
    <?php include'footer.php';?>
  <?php include'pie-js.php';?>
  </body>
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
$('#form').submit(function(e) {
    e.preventDefault();
    
    document.getElementById('boton').setAttribute('style', 'display:none !important');
    $('#animacion').addClass('cargando');
    
    var formData = new FormData(this);
    
    $.ajax({
        type: "post",
        url: 'controlador.php',
        data: formData,
        processData: false,
        contentType: false,
        success: function(datos) {
            $("#mostrardatos").html(datos);
            document.getElementById('boton').setAttribute('style', 'display:block !important');
            $('#animacion').removeClass('cargando');
        }
    }).fail(function() {
        document.getElementById('boton').setAttribute('style', 'display:block !important');
        $('#animacion').removeClass('cargando');
    });
});
</script>
<!-- ===============================================-->
<script>
document.getElementById('archivo').addEventListener('change', function(e){

  const archivos = e.target.files;
  const preview = document.getElementById('previewImagen');

  preview.innerHTML = "";

  if(archivos.length > 5){
    alert("Solo puedes subir máximo 5 imágenes");
    this.value = "";
    return;
  }

  for(let i = 0; i < archivos.length; i++){

    const archivo = archivos[i];

    if(archivo.size > 400 * 1024){
      alert("Una imagen supera los 400 KB");
      continue;
    }

    const reader = new FileReader();

    reader.onload = function(event){

      const img = document.createElement("img");
      img.src = event.target.result;

      preview.appendChild(img);

    };

    reader.readAsDataURL(archivo);

  }

});
</script>
<!-- ===============================================-->
    <script>
      const textarea = document.getElementById('contenido');
      const counter = document.getElementById('countcontenido');
      const maxLength = textarea.getAttribute('maxlength');

      textarea.addEventListener('input', function() {
          const remainingChars = maxLength - textarea.value.length;
          counter.textContent = remainingChars + ' caracteres restantes';
      });
  </script>
</html>
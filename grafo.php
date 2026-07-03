<?php 
include 'conexion.php';
include 'objetos.php';

$id_grafo=$_POST['id_grafo'];

 $query_1 = "SELECT 
                g.*,
                n.*
            FROM grafos g
            JOIN nodos n 
                ON n.id_grafo = g.id
            WHERE g.id = '$id_grafo'
            ORDER BY n.id ASC
            LIMIT 1";
$resultado1 = mysqli_query($conexion, $query_1)or die("Error en el query: " . mysqli_error($conexion));
$totalNodos = mysqli_num_rows($resultado1);

 $query_4 = "SELECT n.img,
                    n.id AS id_nodo,
                    n.id_grafo,
                    n.nombren,
                    n.contenidon
                    FROM nodos n
                    WHERE n.id_grafo = '$id_grafo'
                    AND NOT EXISTS (
                        SELECT 1 FROM relaciones r 
                        WHERE r.de_nodo_id = n.id 
                        OR r.a_nodo_id = n.id
                    )";
$resultado4 = mysqli_query($conexion, $query_4)or die("Error en el query: " . mysqli_error($conexion));
$totalRelaciones = mysqli_num_rows($resultado4);

function dividir_texto($texto, $palabras_por_salto = 8) {
    $palabras = explode(' ', $texto);
    $bloques = array_chunk($palabras, $palabras_por_salto);
    $lineas = array_map(function($bloque) {
        return implode(' ', $bloque);
    }, $bloques);
    return implode('<br>', $lineas);
}
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
<?php include'menu_login.php';?> <br> <br><br>
      <!-- ============================================--><!-- <section> begin ============================-->
<section class="bg-body-tertiary dark__bg-opacity-50 text-center pt-6 pb-6" id="banner" >

  <div class="text-start">
  <a class="btn btn-primary btn-sm mt-2 ms-4 mb-2" href="index.php?ok=1#pill-tab-grafos"> 
    Atras
  </a>
</div>
         
    <?php if($totalNodos == 0){ ?>
        <div class="d-flex justify-content-start">                 
            <button class="btn btn-primary ms-6 mt-6 rounded-circle" type="button" data-bs-toggle="modal" data-bs-target="#grafo0-modal">
                +
            </button>
        </div>
    <?php }else{ ?>

    <?php if($totalRelaciones>0){?>


        <div class="row justify-content-right ms-3">
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card mb-3">
              <div class="card-header bg-body-tertiary">
                <h5 class="mb-0">Nodos sin conexión</h5>
              </div>
              <div class="card-body text-justify">
                <p class="mb-0 text-1000">Estos nodos no tienen ninguna conexión con otros nodos.</p>
                <div class="collapse show" id="profile-intro">
                  <!--Nodo-->
                  <div class="row justify-content-center">
                  <?php 
                  $count = 0;
                  while($fila1 = mysqli_fetch_array($resultado4)){ 
                      $count++;
                  ?>
                      <div class="col-3 text-center mb-3">

                          <!-- CONTENEDOR CIRCULAR -->
                          <div class="rounded-circle overflow-hidden mx-auto" style="width:100px; height:100px;">
                              <?php 
                              $carpeta  = 'imagenes/img_grafos/' . $fila1['img'] . '/';
                              $imagenes = glob($carpeta . '*.{jpg,png,gif,jpeg,webp}', GLOB_BRACE);
                              if($imagenes){
                              ?>
                                  <div class="d-flex flex-wrap w-100 h-100">
                                      <?php 
                                      $imagenes = array_slice($imagenes, 0, 5);
                                      foreach($imagenes as $imagen){
                                          $rutaImg = $imagen;
                                      ?>
                                          <div style="width:50%; height:50%;">
                                              <a class="glightbox"
                                                 href="<?php echo $rutaImg; ?>"
                                                 data-gallery="gallery-<?php echo $fila1['id']; ?>">
                                                  <img class="w-100 h-100" style="object-fit:cover;" src="<?php echo $rutaImg; ?>">
                                              </a>
                                          </div>
                                      <?php } ?>
                                  </div>
                              </div><!-- Cierra CONTENEDOR CIRCULAR -->
                              <?php } else { ?>
                                  <img class="w-100 h-100" style="object-fit:cover;" src="imagenes/no-imagen.png">
                              </div><!-- Cierra CONTENEDOR CIRCULAR -->
                              <?php } ?>

                          <h6 class="mb-1 mt-2 text-center"><?php echo $fila1['nombren']; ?></h6>
                          <p class="fs-11 mb-1">
                              <span class="texto-corto">
                                    <?php echo dividir_texto(mb_substr($contenidon, 0, 120), 8); ?>...
                                    <a href="#" class="ver-mas">ver más</a>
                              </span>
                              <span class="texto-completo" style="display:none;">
                                    <?php echo dividir_texto($contenidon, 8); ?>
                                    <a href="#" class="ver-menos">ver menos</a>
                              </span>
                          </p>

                          <!-- Botones: editar | link | eliminar -->
                          <div class="d-flex justify-content-center align-items-center mt-1">
                              <form action="forms.php" method="post">
                                  <input type="hidden" name="id_nodo" value="<?php echo $fila1['id_nodo']; ?>">
                                  <input type="hidden" name="id_grafo" value="<?php echo $fila1['id_grafo']; ?>">
                                  <input type="hidden" name="tipo_form" value="editar_nodo">
                                  <button class="btn btn-light btn-sm ms-1 rounded-circle" type="submit">
                                      <i class="fas fa-pen"></i>
                                  </button>
                              </form>
                              <button class="btn btn-secondary btn-sm ms-1 rounded-circle" type="button" 
                                      data-bs-toggle="modal" 
                                      data-bs-target="#relacion1-modal-<?php echo $fila1['id_nodo']; ?>" 
                                      data-id="<?php echo $fila1['id_nodo']; ?>" 
                                      data-id-grafo="<?php echo $fila1['id_grafo']; ?>">
                                  <i class="fas fa-link"></i>
                              </button>
                              <form action="controlador.php" method="post" style="display:inline-block;">
                                  <input type="hidden" name="id_nodo" value="<?php echo $fila1['id_nodo']; ?>">
                                  <input type="hidden" name="id_grafo" value="<?php echo $fila1['id_grafo']; ?>">
                                  <input type="hidden" name="tipo_form" value="eliminar_nodo">
                                  <button type="button" class="btn btn-danger btn-sm ms-1 rounded-circle" onclick="confirmDelete(event, this)">
                                      <i class="fas fa-times"></i>
                                  </button>
                              </form>
                          </div>

                      </div><!-- Cierra col -->

                        <?php

                         Objetos::modalRelacion($conexion, $fila1['id_nodo'], $fila1['id_grafo']);

                          ?>

                      <?php if($count % 4 == 0){ ?>
                          </div><div class="row justify-content-center">
                      <?php } ?>

                  <?php } ?>
                  </div><!-- Cierra row -->
                  <!--Fin-Nodo-->
                </div>
              </div>
              <div class="card-footer bg-body-tertiary p-0 border-top"><button class="btn btn-link d-block w-100 btn-intro-collapse" type="button" data-bs-toggle="collapse" data-bs-target="#profile-intro" aria-expanded="true" aria-controls="profile-intro">Ver <span class="less">menos<span class="fas fa-chevron-up ms-2 fs-11"></span></span><span class="full">todos<span class="fas fa-chevron-down ms-2 fs-11"></span></span></button></div>
            </div>
          </div>
        </div>
    <?php }?>


        <div class="row justify-content-center">

              <?php while($fila1 = mysqli_fetch_array($resultado1)){ 
                  $id_nodo    = $fila1['id'];
                  //Testeo importante--> echo $id_nodo;
                  $nombren    = $fila1['nombren'];
                  $contenidon = $fila1['contenidon'];
              ?>

          <div class="col-auto mb-3 px-3 col-xxl-2 mb-1">
            <div class="text-center">

                  <!-- CONTENEDOR CIRCULAR -->
                  <div class="rounded-circle overflow-hidden mx-auto" style="width:100px; height:100px;">

                        <?php 
                        $carpeta  = 'imagenes/img_grafos/' . $fila1['img'] . '/';
                        $imagenes = glob($carpeta . '*.{jpg,png,gif,jpeg,webp}', GLOB_BRACE);

                        if($imagenes){
                        ?>

                          <div class="d-flex flex-wrap w-100 h-100">

                            <?php 
                            $imagenes = array_slice($imagenes, 0, 5);
                            foreach($imagenes as $imagen){
                                $rutaImg = $imagen;
                            ?>

                              <div style="width:50%; height:50%;">
                                <a class="glightbox"
                                   href="<?php echo $rutaImg; ?>"
                                   data-gallery="gallery-<?php echo $fila1['id']; ?>">
                                  <img class="w-100 h-100"
                                       style="object-fit:cover;"
                                       src="<?php echo $rutaImg; ?>">
                                </a>
                              </div>

                            <?php } ?>

                          </div>
                    </div>

                        <?php } else { ?>
                          <img class="w-100 h-100" style="object-fit:cover;" src="imagenes/no-imagen.png">
                        <?php } ?>

                  </div><!-- Cierra CONTENEDOR CIRCULAR -->

                  <?php
                  $query_2 = "SELECT 
                         n.id,
                         n.nombren,
                         n.contenidon,
                         n.img,
                         n.id_grafo,
                         r.nombre,
                         r.contenido,
                         r.id AS id_relacion
                     FROM relaciones r
                     INNER JOIN nodos n ON n.id = r.a_nodo_id
                     WHERE r.de_nodo_id = '$id_nodo'";
                  $resultado2 = mysqli_query($conexion, $query_2) or die("Error en el query: " . mysqli_error($conexion));
                  $totalRelaciones = mysqli_num_rows($resultado2);

                  $query_3 = "SELECT n.*
                              FROM nodos n
                              LEFT JOIN relaciones r 
                                ON r.id_grafo = n.id_grafo
                                AND (
                                  (r.de_nodo_id = $id_nodo AND r.a_nodo_id = n.id)
                                  OR
                                  (r.de_nodo_id = n.id AND r.a_nodo_id = $id_nodo)
                                )
                              WHERE n.id_grafo = $id_grafo
                              AND n.id != $id_nodo
                              AND r.id IS NULL";
                  $resultado3 = mysqli_query($conexion, $query_3) or die("Error en el query: " . mysqli_error($conexion));
                  ?>
                  <!-- Botón + arriba centrado -->
                  <div class="d-flex justify-content-center">
                      <button class="btn btn-primary btn-sm mt-1 ms-2 rounded-circle" type="button" data-bs-toggle="modal" data-bs-target="#grafo1-modal" data-id="<?php echo $id_nodo; ?>" data-id-grafo="<?php echo $id_grafo; ?>">
                          <i class="fas fa-plus"></i>
                      </button>
                  </div>

                  <!-- Botones link, editar y eliminar abajo en fila -->
                  <div class="d-flex justify-content-center align-items-center mt-1">

                      <!-- Izquierda: link -->
                      <?php if($totalNodos != 0){?>
                      <button class="btn btn-secondary btn-sm ms-1 rounded-circle" type="button" data-bs-toggle="modal" data-bs-target="#relacion0-modal" data-id="<?php echo $id_nodo; ?>" data-id-grafo="<?php echo $id_grafo; ?>">
                          <i class="fas fa-link"></i>
                      </button>
                      <?php }?>

                      <!-- Centro: editar -->
                      <form action="forms.php" method="post">
                          <input type="hidden" name="id_nodo" value="<?php echo $id_nodo;?>">
                          <input type="hidden" name="id_grafo" value="<?php echo $id_grafo;?>">
                          <input type="hidden" name="tipo_form" value="editar_nodo">
                          <button class="btn btn-light btn-sm ms-1 rounded-circle" type="submit">
                              <i class="fas fa-pen"></i>
                          </button>
                      </form>

                      <!-- Derecha: eliminar -->
                      <!--<form action="controlador.php" method="post" style="display:inline-block;">
                          <input type="hidden" name="id_nodo" value="<?php echo $id_nodo; ?>">
                          <input type="hidden" name="id_grafo" value="<?php echo $id_grafo; ?>">
                          <input type="hidden" name="tipo_form" value="eliminar_nodo">
                          <button type="button" class="btn btn-danger btn-sm ms-1 rounded-circle" onclick="confirmDelete(event, this)">
                              <i class="fas fa-times"></i>
                          </button>
                      </form>-->

                  </div>  
                



               

                  <h6 class="mb-1 mt-2"><?php echo $nombren;?></h6>
                  <p class="fs-11 mb-1">
                      <span class="texto-corto">
                            <?php echo dividir_texto(mb_substr($contenidon, 0, 120), 8); ?>...
                            <a href="#" class="ver-mas">ver más</a>
                      </span>
                      <span class="texto-completo" style="display:none;">
                            <?php echo dividir_texto($contenidon, 8); ?>
                            <a href="#" class="ver-menos">ver menos</a>
                      </span>
                  </p>

                  <!--Relaciones-->
                  <?php if($totalRelaciones == 0){ ?>
                  <?php }else{?>
                    <div class="accordion mx-auto" id="accordionExample" style="max-width: 300px;">
                      <div class="accordion-item">
                        <?php while($fila2 = mysqli_fetch_array($resultado2)){?>
                            <h2 class="accordion-header" id="heading4">
                              <button class="accordion-button collapsed py-1 px-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $fila2['id'];?>" aria-expanded="true" aria-controls="collapse<?php echo $fila2['id'];?>">
                                <?php echo $fila2['nombren'];?>
                              </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="collapse<?php echo $fila2['id'];?>" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                              <div class="accordion-body">
                                <strong>Conexión a:</strong> <?php echo $fila2['nombren']; ?><br>
                                <small class="text-muted"><?php echo $fila2['nombre']; ?></small><br>
                                <span class="texto-corto">
                                    <?php echo mb_substr($fila2['contenido'], 0, 60); ?>...
                                    <a href="#" class="ver-mas">ver más</a>
                                </span>
                                <span class="texto-completo" style="display:none;">
                                    <?php echo $fila2['contenido']; ?>
                                    <a href="#" class="ver-menos">ver menos</a>
                                </span>

                                  <div class="d-flex align-items-center">                               
                                    <form action="forms.php" method="post">
                                          <input type="hidden" name="nombre" value="<?php echo $fila2['nombre'];?>">
                                          <input type="hidden" name="contenido" value="<?php echo $fila2['contenido'];?>">

                                          <input type="hidden" name="id_relacion" value="<?php echo $fila2['id_relacion'];?>">
                                          <input type="hidden" name="id_grafo" value="<?php echo $fila2['id_grafo'];?>">
                                          <input type="hidden" name="tipo_form" value="editar_relacion">
                                         <button class="btn btn-light btn-sm ms-1 mt-2 rounded-circle" type="submit">
                                          <i class="fas fa-pen"></i>
                                        </button>
                                    </form>     

                                    <!--<form action="controlador.php" method="post">
                                          <input type="hidden" name="id_relacion" value="<?php echo $fila2['id_relacion'];?>">
                                          <input type="hidden" name="id_grafo" value="<?php echo $fila2['id_grafo'];?>">
                                          <input type="hidden" name="tipo_form" value="eliminar_relacion">
                                         <button class="btn btn-danger btn-sm ms-1 mt-2 rounded-circle" type="submit">
                                          <i class="fas fa-times"></i>
                                        </button>
                                    </form>-->
                                  </div>

                              </div>
                            </div>
                        <?php }?>
                      </div>
                    </div>
                  <?php }?>
                  <!--Relaciones-->

                  <!-- Botón VER -->
                  <p class="mt-2">
                    <a class="btn btn-falcon-default btn-sm rounded-circle btn-conexion-activa" data-bs-toggle="collapse" href="#collapse_root_<?php echo $id_nodo;?>" role="button">
                        <i class="fas fa-code-branch"></i>
                    </a>
                  </p>                  
                  <div class="collapse" id="collapse_root_<?php echo $id_nodo;?>">
                      <div class="card card-body">
                          <?php
                          $Objetos = new Objetos();
                          $Objetos->secuencia($conexion, $id_nodo, $id_grafo);
                          ?>
                      </div>
                  </div>

            </div>
          </div><!-- Cierra col -->

              <?php }?><!--Termina While.--->

        </div><!-- Cierra row -->

    <?php }?>

    <?php if($totalNodos == 0){?>
        <p class="card-text">No tiene nodos relacionados.</p>   
    <?php }?>

</section><!-- <section> close ============================--><!-- ============================================-->


           <!--MODAL GRAFO0-->
          <div class="modal fade" id="grafo0-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
              <div class="modal-content position-relative">

                <!-- Botón cerrar -->
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                  <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                          data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-0">

                  <!-- Header -->
                  <div class="rounded-top-3 py-3 ps-4 pe-6 bg-body-tertiary">
                    <h4 class="mb-1">Nuevo nodo</h4>
                  </div>

                  <!-- Contenido -->
                  <div class="p-4">
    
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
                          </div>
                          </div>   
                                  <br>
                           
                        <input class="form-control" name="nombre"  type="text" placeholder="Nombre*" maxlength="90" required>

                        <div id="countcontenido">500 caracteres restantes para contenido</div>
                        <textarea class="form-control" name="contenido" id="contenidotxt" maxlength="500" rows="4" cols="50" placeholder="Contenido*" required></textarea>

                        <input  name="tipo_form" type="hidden" value="registrar_nodo">
                        <input type="hidden" name="id_grafo" value="<?php echo $id_grafo;?>">
                          
                        <button class="btn btn-primary d-block w-100 mt-3" id="boton" type="submit">Crear</button>
                        <center><div id="animacion"></div></center>
                      </form>
                  </div><!--FIN CONTENIDO-->
                </div>
              </div>
            </div>
          </div>
          <!--FIN MODAL GRAFO0-->

           <!--MODAL GRAFO1-->
          <div class="modal fade" id="grafo1-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
              <div class="modal-content position-relative">

                <!-- Botón cerrar -->
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                  <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                          data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-0">

                  <!-- Header -->
                  <div class="rounded-top-3 py-3 ps-4 pe-6 bg-body-tertiary">
                    <h4 class="mb-1">Nuevo nodo</h4>
                  </div>

                  <!-- Contenido -->
                  <div class="p-4">
    
                      <form  action="controlador.php" method="post" enctype="multipart/form-data">

                          <div class="col-md-auto d-flex align-items-center justify-content-center">
                                  <div id="previewImagen1" class="preview-grid"></div>
                          </div>

                            <div class="col-md">
                              <div class="text-center">
                                  <label for="archivo1" style="cursor:pointer;">
                                    <i class="fas fa-images fa-2x mb-2"></i>
                                      <div>Selecciona hasta 5 imágenes para el nodo </div>
                                      <p class="mb-0 fs-10 text-400">
                                        JPG, PNG o GIF · Mín. 300x300 por imagen
                                      </p>
                                  </label>

                              <input type="file" name="archivo1[]" id="archivo1" accept="image/*" style="display:none;" multiple>
                          </div>
                          </div>   
                            <br>
                           
                        <input class="form-control" name="nodo"  type="text" placeholder="Nombre nodo*" maxlength="90" required>

                        <div id="countcontenidon">500 caracteres restantes para contenido</div>
                        <textarea class="form-control" name="contenidon" id="contenidon" maxlength="500" rows="4" cols="50" placeholder="Contenido nodo*" required></textarea>

                        <label><b>Relación</b></label>

                        <input class="form-control" name="relacion"  type="text" placeholder="Nombre relación*" maxlength="30" required>

                        <div id="countcontenidor">90 caracteres restantes para contenido</div>
                        <textarea class="form-control" name="contenidor" id="contenidor" maxlength="90" rows="4" cols="50" placeholder="Contenido relación*" required></textarea>

                        <input  name="tipo_form" type="hidden" value="registrar_nodo_relacion">
                        <input type="hidden" id="id_grafo" name="id_grafo">
                        <input type="hidden" id="id_nodo" name="id_nodo">
                          
                        <button class="btn btn-primary d-block w-100 mt-3" id="boton" type="submit">Crear</button>
                        <center><div id="animacion"></div></center>
                      </form>
                  </div><!--FIN CONTENIDO-->
                </div>
              </div>
            </div>
          </div>
          <!--FIN MODAL GRAFO1-->

           <!--MODAL RELACION0-->
          <div class="modal fade" id="relacion0-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
              <div class="modal-content position-relative">

                <!-- Botón cerrar -->
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                  <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                          data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-0">

                  <!-- Header -->
                  <div class="rounded-top-3 py-3 ps-4 pe-6 bg-body-tertiary">
                    <h4 class="mb-1">Nueva relación</h4>
                  </div>

                  <!-- Contenido -->
                  <div class="p-4">
    
                      <form  action="controlador.php" method="post" enctype="multipart/form-data">
                           
                        <br>
                           
                        <label><b>Relación</b></label>
                        <label class="form-label" for="form-wizard-gender">A nodo*</label>

                            <select class="form-select" name="id_destino" id="form-wizard-gender" required>
                              <option value="">Selecciona nodo destino...</option>
                                <?php foreach ($resultado3 as $opciones): ?> 
                                          <option value="<?php echo $opciones['id'] ?>"><?php echo $opciones['nombren'] ?></option>
                                <?php endforeach ?>                                   
                            </select>


                        <input class="form-control" name="relacion"  type="text" placeholder="Nombre relación*" maxlength="30" required>

                        <div id="countcontenidorr">90 caracteres restantes para contenido</div>
                        <textarea class="form-control" name="contenido" id="contenidorr" maxlength="90" rows="4" cols="50" placeholder="Contenido relación*" required></textarea>

                        <input  name="tipo_form" type="hidden" value="registrar_relacion">
                        <input type="text" id="id_grafo1" name="id_grafo" value="<?php echo $id_grafo;?>">
                        <input type="text" id="id_nodo1" name="id_nodo" value="<?php echo $id_nodo;?>">
                          
                        <button class="btn btn-primary d-block w-100 mt-3" id="boton" type="submit">Crear</button>
                        <center><div id="animacion"></div></center>
                      </form>
                  </div><!--FIN CONTENIDO-->
                </div>
              </div>
            </div>
          </div>
          <!--FIN MODAL RELACION10-->
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
        confirmButtonText: 'Sí, eliminarlo',
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
$('#form1').submit(function(e) {
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
            //$("#mostrardatos").html(datos);
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
document.addEventListener('DOMContentLoaded', function() {
    const contadores = [
        { textarea: 'contenidotxt', counter: 'countcontenido' },
        { textarea: 'contenidon',   counter: 'countcontenidon' },
        { textarea: 'contenidor',   counter: 'countcontenidor' },
        { textarea: 'contenidorr',  counter: 'countcontenidorr' }
    ];

    contadores.forEach(function(item) {
        const textarea = document.getElementById(item.textarea);
        const counter  = document.getElementById(item.counter);

        if (!textarea || !counter) return; // si no existe, lo salta

        const maxLength = parseInt(textarea.getAttribute('maxlength'));

        textarea.addEventListener('input', function() {
            const restantes = maxLength - textarea.value.length;
            counter.textContent = restantes + ' caracteres restantes';
        });
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
document.getElementById('archivo1').addEventListener('change', function(){
    const archivos = this.files;
    const preview = document.getElementById('previewImagen1');
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
            img.style.width = "80px";
            img.style.margin = "5px";
            preview.appendChild(img);
        };
        reader.readAsDataURL(archivo);
    }
});
</script>
<!-- ===============================================-->
<script>
document.addEventListener("DOMContentLoaded", function () {

  const modal = document.getElementById('grafo1-modal');

  modal.addEventListener('show.bs.modal', function (event) {

    const button = event.relatedTarget; // botón que abrió el modal. Nodo Relacion.

    //obtener ambos valores
    const id = button.getAttribute('data-id');
    const idGrafo = button.getAttribute('data-id-grafo');

    console.log("ID nodo:", id);
    console.log("ID grafo:", idGrafo);

    // asignarlos a los inputs
    document.getElementById('id_nodo').value = id;
    document.getElementById('id_grafo').value = idGrafo;

  });

});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {

  const modal = document.getElementById('relacion0-modal');

  if (!modal) return; // seguridad

  modal.addEventListener('show.bs.modal', function (event) {

    const button = event.relatedTarget;

    if (!button) return; // evita errores. Relacion.

    const id = button.getAttribute('data-id');
    const idGrafo = button.getAttribute('data-id-grafo');

    console.log("ID nodo:", id);
    console.log("ID grafo:", idGrafo);

    //usar el modal como contexto
    modal.querySelector('#id_nodo1').value = id;
    modal.querySelector('#id_grafo1').value = idGrafo;

  });

});
</script>
<!--======================PARA CONTENIDO MAS y MENOS================================-->
<script>
document.addEventListener('click', function(e){
    if(e.target.classList.contains('ver-mas')){
        e.preventDefault();
        const nodo = e.target.closest('.texto-corto');
        nodo.style.display = 'none';
        nodo.nextElementSibling.style.display = 'block';
    }
    if(e.target.classList.contains('ver-menos')){
        e.preventDefault();
        const nodo = e.target.closest('.texto-completo');
        nodo.style.display = 'none';
        nodo.previousElementSibling.style.display = 'block';
    }
});
</script>
<!--======================FIN PARA CONTENIDO MAS y MENOS================================-->
</html>
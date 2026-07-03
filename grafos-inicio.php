<?php 
include 'conexion.php';

$query_1 = "SELECT 
                g.*,
                (
                    SELECT img
                    FROM nodos i
                    WHERE i.id_grafo = g.id
                    ORDER BY i.id ASC
                    LIMIT 1
                ) AS img
            FROM grafos g
            ORDER BY g.id DESC";
$resultado1 = mysqli_query($conexion, $query_1)or die("Error en el query: " . mysqli_error($conexion));
?>
<!--GRAFOS-->
                  <div class="d-flex justify-content-start">                 
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#agenda-modal">
                        +
                      </button>
                  </div>

                  <br><br>

                  <?php if($resultado1){ ?>
                      <?php if(mysqli_num_rows($resultado1) > 0){ ?>
                          <div class="row">
                          <?php
                          $count = 0;
                          while($fila1 = mysqli_fetch_array($resultado1)){ 
                              $count++;
                          ?>
                              <div class="col-md-4 mb-4">
                                  <div class="card overflow-hidden">
                                      
                                        <!--INICIO IMG-->
                                        <div class="card-img-top text-center py-2">
                                            <?php 
                                            $carpeta = 'imagenes/img_grafos/' . $fila1['img'];
                                            $imagenes = glob($carpeta . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                                            
                                            if(!empty($fila1['img']) && !empty($imagenes)){ 
                                                $primeraImg = $imagenes[0];
                                            ?>
                                                <a class="post1" href="<?php echo $primeraImg; ?>" data-gallery="gallery-<?php echo $fila1['id']; ?>">
                                                    <img class="img-fluid rounded w-100" src="<?php echo $primeraImg; ?>" style="height:180px; object-fit:cover;">
                                                </a>
                                            <?php } else { ?>
                                                <img class="img-fluid" style="width:160px; height:135px; object-fit:cover;" src="imagenes/no-imagen.png">
                                            <?php } ?>
                                        </div>
                                        <!--FIN IMG-->

                                      <div class="card-body">
                                          <h5 class="card-title"><?php echo $fila1['nombre']; ?></h5>
                                      </div>

                                      <div class="card-body">
                                          <p class="card-text"><?php echo $fila1['descripcion']; ?></p>
                                      </div>



                                      <div class="card-body">

                                          <form action="grafo.php" method="post" style="display:inline-block;">
                                              <input type="hidden" name="id_grafo" value="<?php echo $fila1['id']; ?>">
                                              <button type="submit" class="btn btn-primary btn-sm">
                                                  <i class="fas fa-eye"></i> 
                                              </button>
                                          </form> 

                                          <form action="forms.php" method="post" style="display:inline-block;">
                                              <input type="hidden" name="id_grafo" value="<?php echo $fila1['id']; ?>">
                                              <input type="hidden" name="tipo_form" value="editar_grafo">
                                              <button type="submit" class="btn btn-light btn-sm">
                                                  <i class="fas fa-pen"></i> 
                                              </button>
                                          </form>

                                          <form action="controlador.php" method="post" style="display:inline-block;">
                                              <input type="hidden" name="id_grafo" value="<?php echo $fila1['id']; ?>">
                                              <input type="hidden" name="tipo_form" value="eliminar_grafo">
                                              <button type="button" class="btn btn-danger btn-sm"  onclick="confirmDelete(event, this)">
                                                  <i class="fas fa-trash-alt"></i>
                                              </button>
                                          </form>
                                      </div>

                                  </div><!-- fin .card -->
                              </div><!-- fin .col-md-3 -->

                             

                              <?php if($count % 3 == 0){ ?>
                                  </div><div class="row">
                              <?php } ?>

                              

                          <?php } ?>
                          </div><!-- fin .row -->

                      <?php } else { ?>
                          <div class='alert alert-dismissible bg-light-danger border border-primary d-flex flex-column flex-sm-row p-5 mb-10'>
                              <div class='d-flex flex-column pe-0 pe-sm-10'>
                                 <h5 class="text-muted text-start m-0">¡Aún no has creado ningún grafo!</h5>
                                  <p class="text-muted fs-9 text-start m-0">Comienza creando tu primer grafo y explora conexiones, relaciones y estructuras.</p>
                              </div>
                          </div>
                      <?php } ?>
                  <?php } ?>
                  <!--FIN CUERPO GRAFOS-->  
                <!--FIN GRAFOS-->

           <!--MODAL-->
          <div class="modal fade" id="agenda-modal" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <h4 class="mb-1">Nuevo grafo</h4>
                  </div>

                  <!-- Contenido -->
                  <div class="p-4">
    
                      <form  action="controlador.php" method="post" enctype="multipart/form-data">
                           
                        <input class="form-control" name="nombre"  type="text" placeholder="Nombre*" maxlength="30" required>

                        <div id="countcontenido">500 caracteres restantes para descripción</div>
                        <textarea class="form-control" name="descripcion" id="contenidotxt" maxlength="500" rows="4" cols="50" placeholder="Descripción*" required></textarea>

                        <input  name="tipo_form" type="hidden" value="registrar_grafo">
                          
                        <button class="btn btn-primary d-block w-100 mt-3" id="boton" type="submit">Crear</button>
                        <center><div id="animacion"></div></center>
                      </form>
                  </div><!--FIN CONTENIDO-->
                </div>
              </div>
            </div>
          </div>
          <!--FIN MODAL-->

          
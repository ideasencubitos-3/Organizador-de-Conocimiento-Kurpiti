<?php 
require 'conexion.php';

Class Objetos{

		function dividir_texto($texto, $palabras_por_salto = 8) {
		    $palabras = explode(' ', $texto);
		    $bloques = array_chunk($palabras, $palabras_por_salto);
		    $lineas = array_map(function($bloque) {
		        return implode(' ', $bloque);
		    }, $bloques);
		    return implode('<br>', $lineas);
		}

		public static function secuencia($conexion,$id_nodo,$id_grafo){
		   // echo $id_nodo;

		    $query_2 = "SELECT n.*,
		                       EXISTS(
		                           SELECT 1 
		                           FROM relaciones r2 
		                           WHERE r2.de_nodo_id = n.id
		                       ) as tiene_hijos
		                FROM nodos n
		                INNER JOIN relaciones r ON n.id = r.a_nodo_id
		                WHERE r.de_nodo_id = '$id_nodo'
		                AND r.id_grafo='$id_grafo'";

		    $resultado2 = mysqli_query($conexion, $query_2) 
		        or die("Error en el query: " . mysqli_error($conexion));

		    $totalNodos = mysqli_num_rows($resultado2);




		    if($totalNodos== 0){

		        echo "
		            <p class='card-text'>No tiene nodos relacionados.</p>       
		        ";

		    }else{
		    
		        echo "<div class='row justify-content-center'>";

		        while($fila2 = mysqli_fetch_array($resultado2)){

		            $id_grafo = $fila2['id_grafo'];
		            $tieneHijos = $fila2['tiene_hijos'];

					$query_4 = "SELECT COUNT(*) as total
							            FROM relaciones 
							            WHERE id_grafo = '$id_grafo'
							            AND (de_nodo_id = '".$fila2['id']."' OR a_nodo_id = '".$fila2['id']."')";
					$resultado4 = mysqli_query($conexion, $query_4);
					$fila4 = mysqli_fetch_assoc($resultado4);
					$totalRelaciones1 = $fila4['total'];		            

		            echo "
		            <div class='col-auto mb-3 px-3 col-xxl-2 mb-1'>
		              <div class='text-center'>

		                <div class='rounded-circle overflow-hidden mx-auto' style='width:90px; height:90px;'>";

		                    $carpeta  = 'imagenes/img_grafos/' . $fila2['img'] . '/';
		                    $imagenes = glob($carpeta . '*.{jpg,png,gif,jpeg,webp}', GLOB_BRACE);

		                    if($imagenes){

		                        echo "<div class='d-flex flex-wrap w-100 h-100'>";
		                            $imagenes = array_slice($imagenes, 0, 4);
		                            foreach($imagenes as $imagen){

		                                $rutaImg = $imagen;    

		                                echo "<div style='width:50%; height:50%;'>";
		                                    echo "<a class='glightbox'
		                                       href='".$rutaImg."'
		                                       data-gallery='gallery-".$fila2['id']."'>
		                                      <img class='w-100 h-100'
		                                           style='object-fit:cover;'
		                                           src='".$rutaImg."'>
		                                    </a>";                        
		                                echo "</div>";
		                            }
		                        echo "</div>";
		                        
		                    }else{
		                       echo "<img class='w-100 h-100' style='object-fit:cover;' src='imagenes/no-imagen.png'>";
		                    }

		            echo "</div>

					<!-- Botón + arriba centrado -->
					<div class='d-flex justify-content-center'>
					    <button class='btn btn-primary btn-sm mt-1 ms-2 rounded-circle'
					            data-bs-toggle='modal'
					            data-bs-target='#grafo1-modal'
					            data-id='".$fila2['id']."'
					            data-id-grafo='".$fila2['id_grafo']."'>
					        <i class='fas fa-plus'></i>
					    </button>
					</div>

					<!-- Botones link, editar y eliminar abajo en fila -->
					<div class='d-flex justify-content-center align-items-center mt-1'>

					    <!-- Izquierda: link -->
					    <button class='btn btn-secondary btn-sm ms-1 rounded-circle' type='button'
					            data-bs-toggle='modal'
					            data-bs-target='#relacion1-modal-".$fila2['id']."'
					            data-id='".$fila2['id']."'
					            data-id-grafo='".$fila2['id_grafo']."'>
					        <i class='fas fa-link'></i>
					    </button>

					    <!-- Centro: editar -->
					    <form action='forms.php' method='post'>
					        <input type='hidden' name='id_nodo' value='".$fila2['id']."'>
					        <input type='hidden' name='id_grafo' value='".$fila2['id_grafo']."'>
					        <input type='hidden' name='tipo_form' value='editar_nodo'>
					        <button class='btn btn-light btn-sm ms-1 rounded-circle' type='submit'>
					            <i class='fas fa-pen'></i>
					        </button>
					    </form>";

						if($totalRelaciones1 <= 1) {
						 echo"<form action='controlador.php' method='post' style='display:inline-block;'>
						        <input type='hidden' name='id_nodo' value='".$fila2['id']."'>
						        <input type='hidden' name='id_grafo' value='".$fila2['id_grafo']."'>
						        <input type='hidden' name='tipo_form' value='eliminar_nodo'>
						        <button type='button' class='btn btn-danger btn-sm ms-1 rounded-circle' onclick='confirmDelete(event, this)'>
						            <i class='fas fa-times'></i>
						        </button>
						    </form>";
						}
				echo"</div>

		                <h6 class='mb-1 mt-2' >".$fila2['nombren']."</h6>
		                <p class='fs-11 mb-1'>
		                    <span class='texto-corto'>
							    " . dividir_texto(mb_substr($fila2['contenidon'], 0, 120), 8) . "...
							    <a href='#' class='ver-mas'>ver más</a>
							</span>
							<span class='texto-completo' style='display:none;'>
							    " . dividir_texto($fila2['contenidon'], 8) . "
							    <a href='#' class='ver-menos'>ver menos</a>
							</span>
		                </p>";

		                self::modalRelacion($conexion, $fila2['id'], $fila2['id_grafo']);
		            // ===================== RELACIONES =====================
		               //Testeo importante--> echo $fila2['id'];
		            $query_3 = "SELECT 
					                n.id,
					                n.nombren,
					                n.contenidon,
					                n.img,
					                n.id_grafo,
					                r.nombre,
					                r.contenido,
					                r.id AS id_relacion
					            FROM relaciones r
					            INNER JOIN nodos n ON n.id = r.de_nodo_id
					            WHERE r.id_grafo='$id_grafo'
					            AND r.a_nodo_id = '".$fila2['id']."'";

		            $resultado3 = mysqli_query($conexion, $query_3) 
		                or die("Error en el query: " . mysqli_error($conexion));

		            $totalRelaciones = mysqli_num_rows($resultado3);




		            if($totalRelaciones > 0){

							echo "<div class='accordion mx-auto mt-2' style='max-width: 300px;'>";
							$contador = 0;
							while($fila3 = mysqli_fetch_array($resultado3)){
							    $contador++;
							    // Usa uniqid() para garantizar unicidad absoluta
							    $id_unico = "rel_" . uniqid() . "_" . $contador;
							    
							    echo "<div class='accordion-item'>";
							    echo "<h2 class='accordion-header' id='heading_{$id_unico}'>
							        <button class='accordion-button collapsed py-1 px-2'
							            type='button'
							            data-bs-toggle='collapse'
							            data-bs-target='#{$id_unico}'
							            aria-expanded='false'
							            aria-controls='{$id_unico}'>
							            ".$fila3['nombren']."
							        </button>
							    </h2>";
							    echo "<div id='{$id_unico}'
							            class='accordion-collapse collapse'
							            data-bs-parent=''
							            aria-labelledby='heading_{$id_unico}'>
							        <div class='accordion-body'>
							            <strong>Conexión a:</strong> ".$fila3['nombren']."<br>
							            <small class='text-muted'>".$fila3['nombre']."</small><br>

							            <span class='texto-corto'>
										    " . mb_substr($fila3['contenido'], 0, 60) . "...
										    <a href='#' class='ver-mas'>ver más</a>
										</span>
										<span class='texto-completo' style='display:none;'>
										    " . $fila3['contenido'] . "
										    <a href='#' class='ver-menos'>ver menos</a>
										</span>

							             <div class='d-flex align-items-center'>  
										     <form action='forms.php' method='post'>
			                                      <input type='hidden' name='nombre' value='".$fila3['nombre']."'>
			                                      <input type='hidden' name='contenido' value='".$fila3['contenido']."'>

			                                      <input type='hidden' name='id_relacion' value='".$fila3['id_relacion']."'>
			                                      <input type='hidden' name='id_grafo' value='".$fila3['id_grafo']."'>
			                                      <input type='hidden' name='tipo_form' value='editar_relacion'>
			                                     <button class='btn btn-light btn-sm ms-1 mt-2 rounded-circle' type='submit'>
			                                      <i class='fas fa-pen'></i>
			                                    </button>
			                                </form> ";
			                                if($totalRelaciones1 <= 1) {

				                       		 echo "<form action='controlador.php' method='post'>
				                                          <input type='hidden' name='id_relacion' value='".$fila3['id_relacion']."'>
				                                          <input type='hidden' name='id_grafo' value='".$fila3['id_grafo']."'>
				                                          <input type='hidden' name='tipo_form' value='eliminar_relacion'>
				                                         <button class='btn btn-danger btn-sm ms-1 mt-2 rounded-circle' type='submit'>
				                                          <i class='fas fa-times'></i>
				                                        </button>
				                                    </form> ";
		                                	}

			                       echo"</div>

							        </div>
							    </div>";
							    echo "</div>";
							}
							echo "</div>";
		            }
		            // ===================== FIN RELACIONES =====================

		            if($tieneHijos){
		                echo "<p class='mt-2'>
		                      <a class='btn btn-falcon-default btn-sm rounded-circle btn-conexion-activa'
		                         data-bs-toggle='collapse'
		                         href='#collapse_".$fila2['id']."'
		                         role='button'>
		                         <i class='fas fa-code-branch'></i>
		                      </a>
		                    </p>";
		            }

		            if($tieneHijos){
		                echo "<div class='collapse mt-2' id='collapse_".$fila2['id']."'>
		                      <div class='card card-body p-2'>";
		                        self::secuencia($conexion, $fila2['id'],$fila2['id_grafo']);
		                echo "  </div>
		                    </div>";
		            }

		            echo "</div>
		                </div>";
		        }

		        echo "</div>";
		    }
		}


		public static function modalRelacion($conexion,$id_nodo, $id_grafo){
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
            $resultado3 = mysqli_query($conexion, $query_3)or die("Error en el query: " . mysqli_error($conexion));



			echo "
			<div class='modal fade' id='relacion1-modal-".$id_nodo."' tabindex='-1'>
			  <div class='modal-dialog modal-dialog-centered' style='max-width: 500px'>
			    <div class='modal-content position-relative'>

			      <div class='position-absolute top-0 end-0 mt-2 me-2 z-1'>
			        <button class='btn-close' data-bs-dismiss='modal'></button>
			      </div>

			      <div class='modal-body p-0'>

			        <div class='rounded-top-3 py-3 ps-4 pe-6 bg-body-tertiary'>
			          <h4 class='mb-1'>Nueva relación</h4>
			        </div>

			        <div class='p-4'>

			          <form action='controlador.php' method='post'>

			            <label><b>Relación</b></label>
			            <label class='form-label'>A nodo*</label>

			            <select class='form-select' name='id_destino' required>
			              <option value=''>Selecciona nodo destino...</option>";
			              
			              while ($opciones = $resultado3->fetch_assoc()) {
			                  echo "<option value='".$opciones['id']."'>".$opciones['nombren']."</option>";
			              }

			echo "      </select>

			            <input class='form-control mt-2' name='relacion' type='text' placeholder='Nombre relación*' maxlength='30' required>

			            <div id='countcontenidorrr_".$id_nodo."'>90 caracteres restantes</div>

			            <textarea class='form-control' name='contenido' id='contenidorrr_".$id_nodo."' maxlength='90' rows='4' placeholder='Contenido relación*' required></textarea>

			            <input type='hidden' name='tipo_form' value='registrar_relacion'>
			            <input type='hidden' name='id_grafo' value='".$id_grafo."'>
						<input type='hidden' name='id_nodo' value='".$id_nodo."'>

			            <button class='btn btn-primary d-block w-100 mt-3' type='submit'>Crear</button>

			          </form>

			        </div>
			      </div>
			    </div>
			  </div>
			</div>
			";

			echo "
				
				";
		}

}

?>
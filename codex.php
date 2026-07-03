<?php 
require "conexion.php";

Class Grafo{

	public static function registrarGrafo($conexion, $nombre, $descripcion){
	    try {
	        if(empty($nombre))   throw new Exception("No se recibió nombre.");
	        if(empty($descripcion)) throw new Exception("No se recibió descripción.");

	        mysqli_begin_transaction($conexion);

	        // Insertar grafo
	        $stmt = $conexion->prepare("INSERT INTO grafos 
	                                    (nombre, descripcion) 
	                                    VALUES (?, ?)");
	        if(!$stmt) throw new Exception("Error al preparar INSERT: " . $conexion->error);
	        $stmt->bind_param("ss", $nombre, $descripcion);
	        if(!$stmt->execute()) throw new Exception("Error al registrar grafo: " . $stmt->error);

	        // Commit solo si todo salió bien
	        mysqli_commit($conexion);
	       	/*echo "<div class='alert alert-info text-white font-weight-bold'>
	                Grafo registrado correctamente.
	              </div>";*/

	      return true;

	    } catch(Exception $e) {
	        mysqli_rollback($conexion);
	        echo "<div class='alert alert-danger text-white font-weight-bold'>
	                {$e->getMessage()}
	              </div>";
	        return null;
	    }		
	}

	public static function editarInfoGrafo($conexion, $id_grafo, $nombre, $descripcion) {
	    try {
	        $conexion->begin_transaction();

	        $sql = "UPDATE grafos SET nombre = ?, descripcion = ? WHERE id = ?";
	        $stmt = $conexion->prepare($sql);

	        if (!$stmt) {
	            throw new Exception("Error al preparar la consulta: " . $conexion->error);
	        }

	        $stmt->bind_param("ssi", $nombre, $descripcion, $id_grafo);

	        if (!$stmt->execute()) {
	            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
	        }

	        $conexion->commit();
	        return true;

	    } catch (Exception $e) {
	        $conexion->rollback();
	        return false;
	    }
	}

	public static function eliminarGrafo($conexion, $id_grafo){
    try {
        // 1. Obtener todos los nodos del grafo que tengan img válida
        $sql_nodos = "SELECT img FROM nodos WHERE id_grafo = ? AND img IS NOT NULL AND img != ''";
        $stmt = $conexion->prepare($sql_nodos);
        if (!$stmt) throw new Exception($conexion->error);
        $stmt->bind_param("i", $id_grafo);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        // 2. Eliminar imágenes y carpetas de cada nodo
        while ($nodo = $resultado->fetch_assoc()) {
            $carpeta = isset($nodo['img']) ? trim($nodo['img']) : '';
            if (!empty($carpeta)) {
                $ruta_carpeta = "imagenes/img_grafos/" . $carpeta . "/";
                if (is_dir($ruta_carpeta)) {
                    $imagenes = glob($ruta_carpeta . '*.{jpg,png,gif,jpeg,webp}', GLOB_BRACE);
                    if ($imagenes) {
                        foreach ($imagenes as $imagen) {
                            unlink($imagen);
                        }
                    }
                    rmdir($ruta_carpeta);
                }
            }
        }
        $stmt->close();
        
        // 3. Eliminar las relaciones del grafo
        $sql_relaciones = "DELETE FROM relaciones WHERE id_grafo = ?";
        $stmt = $conexion->prepare($sql_relaciones);
        if (!$stmt) throw new Exception($conexion->error);
        $stmt->bind_param("i", $id_grafo);
        $stmt->execute();
        $stmt->close();
        
        // 4. Eliminar los nodos del grafo
        $sql_nodos_del = "DELETE FROM nodos WHERE id_grafo = ?";
        $stmt = $conexion->prepare($sql_nodos_del);
        if (!$stmt) throw new Exception($conexion->error);
        $stmt->bind_param("i", $id_grafo);
        $stmt->execute();
        $stmt->close();
        
        // 5. Eliminar el grafo
        $sql_grafo = "DELETE FROM grafos WHERE id = ?";
        $stmt = $conexion->prepare($sql_grafo);
        if (!$stmt) throw new Exception($conexion->error);
        $stmt->bind_param("i", $id_grafo);
        $stmt->execute();
        $afectados = $stmt->affected_rows;
        $stmt->close();
        
        return $afectados > 0;
        
    } catch (Exception $e) {
        return false;
    }
}

	public static function registrarNodo($conexion, $nombre, $contenido, $id_grafo) {
	    try {
	        if(empty($nombre))   throw new Exception("No se recibió nombre.");
	        if(empty($contenido)) throw new Exception("No se recibió contenido.");
	        if(empty($id_grafo))       throw new Exception("No se recibió id grafo.");

	        //echo $nombre."<br>".$contenido."<br>".$id_grafo; die();
	        mysqli_begin_transaction($conexion);

	        // Generar token único
	        $token = bin2hex(random_bytes(25));

	        // Fecha y hora actual
	        $fecha_tiempo = date('Y-m-d H:i:s');

	        // Insertar publicación
	        $stmt = $conexion->prepare("INSERT INTO nodos
	                                    (nombren, contenidon, id_grafo, img) 
	                                    VALUES (?, ?, ?, ?)");
	        if(!$stmt) throw new Exception("Error al preparar INSERT: " . $conexion->error);
	        $stmt->bind_param("ssis", $nombre, $contenido, $id_grafo, $token);
	        if(!$stmt->execute()) throw new Exception("Error al registrar nodo: " . $stmt->error);

	       // Registrar imágenes solo si se subieron
			if(isset($_FILES["archivo"]) && !empty($_FILES["archivo"]["name"][0])){
			    self::registrarImagenNodo($conexion, $token);
			}

	        // Commit solo si todo salió bien
	        mysqli_commit($conexion);
	       	/*echo "<div class='alert alert-info text-white font-weight-bold'>
	                Nodo registrado correctamente.
	              </div>";*/

	        return $token;

	    } catch(Exception $e) {
	        mysqli_rollback($conexion);
	        echo "<div class='alert alert-danger text-white font-weight-bold'>
	                {$e->getMessage()}
	              </div>";
	        return null;
	    }
	}	


	public static function registrarNodoRelacion($conexion, $nodo, $contenidon, $relacion, $contenidor, $id_nodo, $id_grafo) {
	    try {
	        if(empty($nodo))   throw new Exception("No se recibió nodo.");
	        if(empty($contenidon)) throw new Exception("No se recibió contenido nodo.");
	        if(empty($relacion)) throw new Exception("No se recibió relación.");
	        if(empty($contenidor)) throw new Exception("No se recibió contenido relación.");
	        if(empty($id_nodo)) throw new Exception("No se recibió id nodo.");
	        if(empty($id_grafo))       throw new Exception("No se recibió id grafo.");

	        mysqli_begin_transaction($conexion);

	        // Generar token único
	        $token = bin2hex(random_bytes(25));

	        // Fecha y hora actual
	        $fecha_tiempo = date('Y-m-d H:i:s');

	        // Insertar publicación
	        $stmt = $conexion->prepare("INSERT INTO nodos
	                                    (nombren, contenidon, id_grafo, img) 
	                                    VALUES (?, ?, ?, ?)");
	        if(!$stmt) throw new Exception("Error al preparar INSERT: " . $conexion->error);
	        $stmt->bind_param("ssis", $nodo, $contenidon, $id_grafo, $token);
	        if(!$stmt->execute()) throw new Exception("Error al registrar nodo: " . $stmt->error);


					//OBTENER ID DEL NUEVO NODO
					$id_nodo_nuevo = $conexion->insert_id;

					// INSERTAR RELACIÓN
					$stmt2 = $conexion->prepare("INSERT INTO relaciones
					    (id_grafo, de_nodo_id,  nombre, contenido, a_nodo_id)
					    VALUES (?, ?, ?, ?, ?)");

					$stmt2->bind_param("iissi", $id_grafo, $id_nodo, $relacion, $contenidor, $id_nodo_nuevo);

					if(!$stmt2->execute()) throw new Exception("Error al registrar relación: " . $stmt2->error);

	       // Registrar imágenes solo si se subieron
			if(isset($_FILES["archivo1"]) && !empty($_FILES["archivo1"]["name"][0])){
			    self::registrarImagenNodo1($conexion, $token);
			}

	        // Commit solo si todo salió bien
	        mysqli_commit($conexion);
	       	/*echo "<div class='alert alert-info text-white font-weight-bold'>
	                Nodo registrado correctamente.
	              </div>";*/

	        return $token;

	    } catch(Exception $e) {
	        mysqli_rollback($conexion);
	        echo "<div class='alert alert-danger text-white font-weight-bold'>
	                {$e->getMessage()}
	              </div>";
	        return null;
	    }
	}


	public static function registrarRelacion($conexion, $id_destino, $relacion, $contenido, $id_nodo, $id_grafo) {
	    try {
	        if(empty($id_destino)) throw new Exception("No se recibió id destino.");
	        if(empty($relacion)) throw new Exception("No se recibió relación.");
	        if(empty($contenido)) throw new Exception("No se recibió contenido.");
	        if(empty($id_nodo)) throw new Exception("No se recibió id nodo.");
	        if(empty($id_grafo)) throw new Exception("No se recibió id grafo.");

	        mysqli_begin_transaction($conexion);

	        //Validar que no exista ya la relación
	        $check = $conexion->prepare("
	            SELECT id FROM relaciones 
	            WHERE id_grafo = ?
	            AND (
	                (de_nodo_id = ? AND a_nodo_id = ?)
	                OR
	                (de_nodo_id = ? AND a_nodo_id = ?)
	            )
	        ");

	        $check->bind_param("iiiii", $id_grafo, $id_nodo, $id_destino, $id_destino, $id_nodo);
	        $check->execute();
	        $result = $check->get_result();

	        if($result->num_rows > 0){
	            throw new Exception("Ya existe una relación entre estos nodos.");
	        }

	        // Insertar relación
	        $stmt = $conexion->prepare("
	            INSERT INTO relaciones (id_grafo, de_nodo_id, nombre, contenido, a_nodo_id)
	            VALUES (?, ?, ?, ?, ?)
	        ");

	        if(!$stmt) throw new Exception("Error prepare: " . $conexion->error);

	        $stmt->bind_param("iissi", $id_grafo, $id_destino, $relacion, $contenido, $id_nodo); //Nodo destino es nodo a donde llega conexion, es como  se conecta de asia mi. todo es asi. 

	        if(!$stmt->execute()) throw new Exception("Error al registrar relación: " . $stmt->error);

	        mysqli_commit($conexion);

	        return true;

	    } catch(Exception $e) {
	        mysqli_rollback($conexion);
	        echo "<div class='alert alert-danger'>{$e->getMessage()}</div>";
	        return false;
	    }
	}	

	public static function editarInfoNodo($conexion, $id_nodo, $nombre, $contenido) {
	    try {
	        $conexion->begin_transaction();

	        $sql = "UPDATE nodos SET nombren = ?, contenidon = ? WHERE id = ?";
	        $stmt = $conexion->prepare($sql);

	        if (!$stmt) {
	            throw new Exception("Error al preparar la consulta: " . $conexion->error);
	        }

	        $stmt->bind_param("ssi", $nombre, $contenido, $id_nodo);

	        if (!$stmt->execute()) {
	            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
	        }

	        $conexion->commit();
	        return true;

	    } catch (Exception $e) {
	        $conexion->rollback();
	        return false;
	    }
	}

	public static function editarInfoRelacion($conexion, $id_relacion, $nombre, $contenido) {
	    try {
	        $conexion->begin_transaction();

	        $sql = "UPDATE relaciones SET nombre = ?, contenido = ? WHERE id = ?";
	        $stmt = $conexion->prepare($sql);

	        if (!$stmt) {
	            throw new Exception("Error al preparar la consulta: " . $conexion->error);
	        }

	        $stmt->bind_param("ssi", $nombre, $contenido, $id_relacion);

	        if (!$stmt->execute()) {
	            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
	        }

	        $conexion->commit();
	        return true;

	    } catch (Exception $e) {
	        $conexion->rollback();
	        return false;
	    }
	}

	public static function eliminarRelacion($conexion, $id_relacion) {
	    try {
	        $conexion->begin_transaction();

	        $sql = "DELETE FROM relaciones WHERE id = ?";
	        $stmt = $conexion->prepare($sql);

	        if (!$stmt) {
	            throw new Exception("Error al preparar la consulta: " . $conexion->error);
	        }

	        $stmt->bind_param("i", $id_relacion);

	        if (!$stmt->execute()) {
	            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
	        }

	        $conexion->commit();
	        return true;

	    } catch (Exception $e) {
	        $conexion->rollback();
	        return false;
	    }
	}


	public static function eliminarNodo($conexion, $id_nodo) {
	    try {
	        $conexion->begin_transaction();

	        // Obtener la carpeta de imágenes antes de eliminar
	        $sql0 = "SELECT img FROM nodos WHERE id = ?";
	        $stmt0 = $conexion->prepare($sql0);
	        if (!$stmt0) throw new Exception($conexion->error);
	        $stmt0->bind_param("i", $id_nodo);
	        if (!$stmt0->execute()) throw new Exception($stmt0->error);
	        $result = $stmt0->get_result();
	        $nodo = $result->fetch_assoc();
	        
	        // Validar img antes de construir la ruta
	        $img = isset($nodo['img']) ? trim($nodo['img']) : '';
	        $carpeta = !empty($img) ? 'imagenes/img_grafos/' . $img . '/' : '';
	        $stmt0->close();

	        // Eliminar todas sus relaciones
	        $sql1 = "DELETE FROM relaciones WHERE de_nodo_id = ? OR a_nodo_id = ?";
	        $stmt1 = $conexion->prepare($sql1);
	        if (!$stmt1) throw new Exception($conexion->error);
	        $stmt1->bind_param("ii", $id_nodo, $id_nodo);
	        if (!$stmt1->execute()) throw new Exception($stmt1->error);

	        // Eliminar el nodo
	        $sql2 = "DELETE FROM nodos WHERE id = ?";
	        $stmt2 = $conexion->prepare($sql2);
	        if (!$stmt2) throw new Exception($conexion->error);
	        $stmt2->bind_param("i", $id_nodo);
	        if (!$stmt2->execute()) throw new Exception($stmt2->error);

	        $conexion->commit();

	        // Eliminar imágenes y carpeta del servidor
	        if (!empty($carpeta) && is_dir($carpeta)) {
	            $archivos = glob($carpeta . "*");
	            if ($archivos) {
	                foreach ($archivos as $archivo) {
	                    if (is_file($archivo)) {
	                        unlink($archivo);
	                    }
	                }
	            }
	            rmdir($carpeta);
	        }

	        return true;

	    } catch (Exception $e) {
	        $conexion->rollback();
	        return false;
	    }
	}

	public static function eliminarImagen($conexion, $imagen) {
	    try {
	        // 1. Sanitizar ruta - evitar path traversal
	        $imagen = str_replace(['../', '..\\', '..'], '', $imagen);

	        // 2. Verificar que el archivo existe
	        if (!file_exists($imagen)) {
	            throw new Exception("El archivo no existe: $imagen");
	        }

	        // 3. Iniciar transacción (por si también eliminas en BD)
	        $conexion->begin_transaction();


	        // 5. Eliminar archivo físico del servidor
	        if (!unlink($imagen)) {
	            // Si falla el unlink, revertir BD
	            $conexion->rollback();
	            throw new Exception("No se pudo eliminar el archivo: $imagen");
	        }

	        // 6. Confirmar transacción
	        $conexion->commit();
	        return true;

	    } catch (Exception $e) {
	        // Revertir cambios en BD si algo falló
	        $conexion->rollback();

	        // Opcional: registrar el error en un log
	        error_log("eliminarImagen Error: " . $e->getMessage());

	        return false;
	    }
	}


	public static function agregarImagenesNodo($conexion, $carpeta) {
	    try {
	        // 1. Limpiar slash final si viene
	        $carpeta = rtrim($carpeta, '/');

	        if (empty($carpeta)) {
	            throw new Exception("Carpeta inválida.");
	        }
	        if (!is_dir($carpeta)) {
	            throw new Exception("La carpeta no existe: $carpeta");
	        }
	        if (!isset($_FILES['archivo']) || empty($_FILES['archivo']['tmp_name'])) {
	            throw new Exception("No se ha subido ningún archivo.");
	        }
	        if (count($_FILES['archivo']['tmp_name']) > 5) {
	            throw new Exception("Solo se permiten máximo 5 imágenes.");
	        }

	        foreach ($_FILES['archivo']['tmp_name'] as $key => $tmpName) {
	            $imagenOriginal    = null;
	            $imagenNormalizada = null;

	            if ($_FILES['archivo']['error'][$key] !== UPLOAD_ERR_OK) {
	                throw new Exception("Error al subir: " . $_FILES['archivo']['name'][$key]);
	            }

	            $info = getimagesize($tmpName);
	            if (!$info) {
	                throw new Exception("Archivo no válido: " . $_FILES['archivo']['name'][$key]);
	            }

	            // 2. Destructuring correcto desde el array
	            $ancho      = $info[0];
	            $alto       = $info[1];
	            $tipoImagen = $info[2];

	            if (!$ancho || !$alto) {
	                throw new Exception("Dimensiones inválidas: " . $_FILES['archivo']['name'][$key]);
	            }

	            switch ($tipoImagen) {
	                case IMAGETYPE_JPEG:
	                    $imagenOriginal = imagecreatefromjpeg($tmpName);
	                    $ext = 'jpg';
	                break;
	                case IMAGETYPE_PNG:
	                    $imagenOriginal = imagecreatefrompng($tmpName);
	                    $ext = 'png';
	                break;
	                case IMAGETYPE_GIF:
	                    $imagenOriginal = imagecreatefromgif($tmpName);
	                    $ext = 'gif';
	                break;
	                default:
	                    throw new Exception("Formato no soportado: " . $_FILES['archivo']['name'][$key]);
	            }

	            // 3. Verificar que la imagen se cargó correctamente
	            if (!$imagenOriginal) {
	                throw new Exception("No se pudo leer la imagen: " . $_FILES['archivo']['name'][$key]);
	            }

	            // Normalizar imagen
	            $imagenNormalizada = imagecreatetruecolor($ancho, $alto);
	            if (!$imagenNormalizada) {
	                throw new Exception("No se pudo crear canvas: " . $_FILES['archivo']['name'][$key]);
	            }

	            if ($tipoImagen == IMAGETYPE_PNG || $tipoImagen == IMAGETYPE_GIF) {
	                imagealphablending($imagenNormalizada, false);
	                imagesavealpha($imagenNormalizada, true);
	            }

	            imagecopy($imagenNormalizada, $imagenOriginal, 0, 0, 0, 0, $ancho, $alto);

	            // Guardar temporal — sin doble slash
	            $tmpPath = $carpeta . '/temp_' . uniqid('', true) . '.' . $ext;

	            switch ($tipoImagen) {
	                case IMAGETYPE_JPEG: imagejpeg($imagenNormalizada, $tmpPath, 90); break;
	                case IMAGETYPE_PNG:  imagepng($imagenNormalizada, $tmpPath);      break;
	                case IMAGETYPE_GIF:  imagegif($imagenNormalizada, $tmpPath);      break;
	            }

	            if (!file_exists($tmpPath)) {
	                throw new Exception("No se pudo crear la imagen: " . $_FILES['archivo']['name'][$key]);
	            }

	            // Renombrar con hash
	            $hash      = hash_file('sha256', $tmpPath);
	            $rutaFinal = $carpeta . '/' . $hash . '.' . $ext;

	            if (!rename($tmpPath, $rutaFinal)) {
	                throw new Exception("No se pudo guardar: " . $_FILES['archivo']['name'][$key]);
	            }

	            // 4. Liberar memoria siempre
	            imagedestroy($imagenOriginal);
	            imagedestroy($imagenNormalizada);
	        }

	        return true;

	    } catch (Exception $e) {
	        // 5. Liberar memoria si quedó algo cargado al fallar
	        if (!empty($imagenOriginal))    imagedestroy($imagenOriginal);
	        if (!empty($imagenNormalizada)) imagedestroy($imagenNormalizada);

	        error_log("agregarImagenesNodo Error: " . $e->getMessage());
	        return false;
	    }
	}


	public static function registrarImagenNodo1($conexion, $token){

	    try {

	        if (empty($token)) {
	            throw new Exception("Token de nodo inválido.");
	        }

	        if (!isset($_FILES["archivo1"])) {
	            throw new Exception("No se ha subido ningún archivo.");
	        }

	        //Limitar máximo 5 imágenes
	        if (count($_FILES["archivo1"]["tmp_name"]) > 5) {
	            throw new Exception("Solo se permiten máximo 5 imágenes por nodo.");
	        }

	        // Carpeta con nombre del token
	        $directorio = 'imagenes/img_grafos/' . $token;

	        if (!file_exists($directorio)) {
	            if (!mkdir($directorio, 0777, true)) {
	                throw new Exception("No se pudo crear el directorio.");
	            }
	        }

	        foreach ($_FILES["archivo1"]["tmp_name"] as $key => $tmpName) {

	            if ($_FILES["archivo1"]["error"][$key] !== UPLOAD_ERR_OK) {
	                throw new Exception("Error al subir el archivo: " . $_FILES["archivo1"]["name"][$key]);
	            }

	            $source = $tmpName;

	            list($ancho, $alto, $tipoImagen) = getimagesize($source);

	            if (!$ancho || !$alto) {
	                throw new Exception("El archivo no es una imagen válida: " . $_FILES["archivo1"]["name"][$key]);
	            }

	            switch ($tipoImagen) {

	                case IMAGETYPE_JPEG:
	                    $imagenOriginal = imagecreatefromjpeg($source);
	                    $ext = 'jpg';
	                break;

	                case IMAGETYPE_PNG:
	                    $imagenOriginal = imagecreatefrompng($source);
	                    $ext = 'png';
	                break;

	                case IMAGETYPE_GIF:
	                    $imagenOriginal = imagecreatefromgif($source);
	                    $ext = 'gif';
	                break;

	                default:
	                    throw new Exception("Formato no soportado: " . $_FILES["archivo1"]["name"][$key]);
	            }

	            //Normaliza imagen (protección contra código malicioso)
	            $imagenNormalizada = imagecreatetruecolor($ancho, $alto);

	            if ($tipoImagen == IMAGETYPE_PNG || $tipoImagen == IMAGETYPE_GIF) {
	                imagealphablending($imagenNormalizada, false);
	                imagesavealpha($imagenNormalizada, true);
	            }

	            imagecopy($imagenNormalizada, $imagenOriginal, 0, 0, 0, 0, $ancho, $alto);

	            // Guardar temporal
	            $tmpPath = $directorio . '/temp_' . uniqid('', true) . '.' . $ext;

	            switch ($tipoImagen) {

	                case IMAGETYPE_JPEG:
	                    imagejpeg($imagenNormalizada, $tmpPath, 90);
	                break;

	                case IMAGETYPE_PNG:
	                    imagepng($imagenNormalizada, $tmpPath);
	                break;

	                case IMAGETYPE_GIF:
	                    imagegif($imagenNormalizada, $tmpPath);
	                break;

	            }

	            if (!file_exists($tmpPath)) {
	                throw new Exception("No se pudo crear la imagen: " . $_FILES["archivo1"]["name"][$key]);
	            }

	            // Renombrar con hash
	            $hash = hash_file('sha256', $tmpPath);

	            $nombreFinal = $hash . '.' . $ext;

	            $rutaFinal = $directorio . '/' . $nombreFinal;

	            if (!rename($tmpPath, $rutaFinal)) {
	                throw new Exception("No se pudo guardar la imagen: " . $_FILES["archivo1"]["name"][$key]);
	            }

	            imagedestroy($imagenOriginal);
	            imagedestroy($imagenNormalizada);
	        }

	        echo "<div class='alert alert-info text-white font-weight-bold'>
	                Imágenes registradas correctamente.
	              </div>";

	    }catch(Exception $e){
	        echo "<div class='alert alert-danger text-white font-weight-bold'>
	                {$e->getMessage()}
	              </div>";
	    }
	}



	public static function registrarImagenNodo($conexion, $token){

	    try {

	        if (empty($token)) {
	            throw new Exception("Token de nodo inválido.");
	        }

	        if (!isset($_FILES["archivo"])) {
	            throw new Exception("No se ha subido ningún archivo.");
	        }

	        //Limitar máximo 5 imágenes
	        if (count($_FILES["archivo"]["tmp_name"]) > 5) {
	            throw new Exception("Solo se permiten máximo 5 imágenes por nodo.");
	        }

	        // Carpeta con nombre del token
	        $directorio = 'imagenes/img_grafos/' . $token;

	        if (!file_exists($directorio)) {
	            if (!mkdir($directorio, 0777, true)) {
	                throw new Exception("No se pudo crear el directorio.");
	            }
	        }

	        foreach ($_FILES["archivo"]["tmp_name"] as $key => $tmpName) {

	            if ($_FILES["archivo"]["error"][$key] !== UPLOAD_ERR_OK) {
	                throw new Exception("Error al subir el archivo: " . $_FILES["archivo"]["name"][$key]);
	            }

	            $source = $tmpName;

	            list($ancho, $alto, $tipoImagen) = getimagesize($source);

	            if (!$ancho || !$alto) {
	                throw new Exception("El archivo no es una imagen válida: " . $_FILES["archivo"]["name"][$key]);
	            }

	            switch ($tipoImagen) {

	                case IMAGETYPE_JPEG:
	                    $imagenOriginal = imagecreatefromjpeg($source);
	                    $ext = 'jpg';
	                break;

	                case IMAGETYPE_PNG:
	                    $imagenOriginal = imagecreatefrompng($source);
	                    $ext = 'png';
	                break;

	                case IMAGETYPE_GIF:
	                    $imagenOriginal = imagecreatefromgif($source);
	                    $ext = 'gif';
	                break;

	                default:
	                    throw new Exception("Formato no soportado: " . $_FILES["archivo"]["name"][$key]);
	            }

	            //Normaliza imagen (protección contra código malicioso)
	            $imagenNormalizada = imagecreatetruecolor($ancho, $alto);

	            if ($tipoImagen == IMAGETYPE_PNG || $tipoImagen == IMAGETYPE_GIF) {
	                imagealphablending($imagenNormalizada, false);
	                imagesavealpha($imagenNormalizada, true);
	            }

	            imagecopy($imagenNormalizada, $imagenOriginal, 0, 0, 0, 0, $ancho, $alto);

	            // Guardar temporal
	            $tmpPath = $directorio . '/temp_' . uniqid('', true) . '.' . $ext;

	            switch ($tipoImagen) {

	                case IMAGETYPE_JPEG:
	                    imagejpeg($imagenNormalizada, $tmpPath, 90);
	                break;

	                case IMAGETYPE_PNG:
	                    imagepng($imagenNormalizada, $tmpPath);
	                break;

	                case IMAGETYPE_GIF:
	                    imagegif($imagenNormalizada, $tmpPath);
	                break;

	            }

	            if (!file_exists($tmpPath)) {
	                throw new Exception("No se pudo crear la imagen: " . $_FILES["archivo"]["name"][$key]);
	            }

	            // Renombrar con hash
	            $hash = hash_file('sha256', $tmpPath);

	            $nombreFinal = $hash . '.' . $ext;

	            $rutaFinal = $directorio . '/' . $nombreFinal;

	            if (!rename($tmpPath, $rutaFinal)) {
	                throw new Exception("No se pudo guardar la imagen: " . $_FILES["archivo"]["name"][$key]);
	            }

	            imagedestroy($imagenOriginal);
	            imagedestroy($imagenNormalizada);
	        }

	        echo "<div class='alert alert-info text-white font-weight-bold'>
	                Imágenes registradas correctamente.
	              </div>";

	    }catch(Exception $e){
	        echo "<div class='alert alert-danger text-white font-weight-bold'>
	                {$e->getMessage()}
	              </div>";
	    }
	}


}
?>
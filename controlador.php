<?php 
require "conexion.php";
require "codex.php";

if (!empty($_POST['tipo_form'])){

    switch ($_POST['tipo_form']){


        case 'registrar_grafo':
            if (
                !empty($_POST['nombre']) &&
                !empty($_POST['descripcion'])  
            ) {
                $nombre = trim($_POST['nombre']);
                $descripcion = trim($_POST['descripcion']); 

                $registrado=Grafo::registrarGrafo(
                    $conexion,
                    $nombre,
                    $descripcion
                );

                if($registrado){
                    header("Location: index.php?ok=1#pill-tab-grafos");
                } else {
                    header("Location: index.php?ok=0#pill-tab-grafos");
                }
            }
        break;

        case 'eliminar_grafo':
            if (
                !empty($_POST['id_grafo']) 
            ) {
                $id_grafo = trim($_POST['id_grafo']);

                $eliminado=Grafo::eliminarGrafo($conexion, $id_grafo);

                if($eliminado){
                    header("Location: index.php?ok=1#pill-tab-grafos");
                } else {
                    header("Location: index.php?ok=0#pill-tab-grafos");
                }
            }
        break;

        case 'editar_info_grafo':
            if (
                !empty($_POST['id_grafo']) &&
                !empty($_POST['nombre']) &&
                !empty($_POST['descripcion']) 
            ) {
                $id_grafo = trim($_POST['id_grafo']);
                $nombre = trim($_POST['nombre']);
                $descripcion = trim($_POST['descripcion']);

                $editado=Grafo::editarInfoGrafo($conexion, $id_grafo, $nombre, $descripcion);

                if($editado){
                    header("Location: index.php?ok=1#pill-tab-grafos");
                } else {
                    header("Location: index.php?ok=0#pill-tab-grafos");
                }
            }
        break;

        case 'registrar_nodo':
            if (
                isset($_FILES['archivo']) &&
                !empty($_POST['nombre']) &&
                !empty($_POST['contenido']) &&
                !empty($_POST['id_grafo'])   
            ) {
                $nombre = trim($_POST['nombre']);
                $contenido = trim($_POST['contenido']);
                $id_grafo = trim($_POST['id_grafo']);

                $registrado=Grafo::registrarNodo(
                    $conexion,
                    $nombre,
                    $contenido,
                    $id_grafo
                );

                if($registrado){
                    echo '<form id="postForm" action="grafo.php" method="post">';
                    echo '<input type="hidden" name="id_grafo" value="'.$id_grafo.'">';
                    echo '</form>';
                    echo '<script>';
                    echo 'setTimeout(function() { document.getElementById("postForm").submit(); }, 100);'; 
                    echo '</script>';
                }else{
                    echo '<form id="postForm" action="grafo.php" method="post">';
                    echo '<input type="hidden" name="id_grafo" value="'.$id_grafo.'">';
                    echo '</form>';
                    echo '<script>';
                    echo 'setTimeout(function() { document.getElementById("postForm").submit(); }, 100);';
                    echo '</script>';
                }
            }
        break;

        case 'registrar_nodo_relacion':
            if (
                isset($_FILES['archivo1']) &&
                !empty($_POST['nodo']) &&
                !empty($_POST['contenidon']) &&
                !empty($_POST['relacion']) &&
                !empty($_POST['contenidor']) &&
                !empty($_POST['id_nodo']) &&
                !empty($_POST['id_grafo'])   
            ) {
                $nodo = trim($_POST['nodo']);
                $contenidon = trim($_POST['contenidon']);
                $relacion = trim($_POST['relacion']);
                $contenidor = trim($_POST['contenidor']);
                $id_nodo = trim($_POST['id_nodo']);
                $id_grafo = trim($_POST['id_grafo']);

                $registrado=Grafo::registrarNodoRelacion(
                    $conexion,
                    $nodo,
                    $contenidon,
                    $relacion,
                    $contenidor,
                    $id_nodo,
                    $id_grafo
                );

                if($registrado){
                    echo '<form id="postForm" action="grafo.php" method="post">';
                    echo '<input type="hidden" name="id_grafo" value="'.$id_grafo.'">';
                    echo '</form>';
                    echo '<script>';
                    echo 'setTimeout(function() { document.getElementById("postForm").submit(); }, 100);'; 
                    echo '</script>';
                }else{
                    echo '<form id="postForm" action="grafo.php" method="post">';
                    echo '<input type="hidden" name="id_grafo" value="'.$id_grafo.'">';
                    echo '</form>';
                    echo '<script>';
                    echo 'setTimeout(function() { document.getElementById("postForm").submit(); }, 100);';
                    echo '</script>';
                }
            }
        break;

        case 'registrar_relacion':
            if (
                !empty($_POST['id_destino']) &&
                !empty($_POST['relacion']) &&
                !empty($_POST['contenido']) &&
                !empty($_POST['id_nodo']) &&
                !empty($_POST['id_grafo'])   
            ) {
                $id_destino = trim($_POST['id_destino']);
                $relacion = trim($_POST['relacion']);
                $contenido = trim($_POST['contenido']);
                $id_nodo = trim($_POST['id_nodo']);
                $id_grafo = trim($_POST['id_grafo']);

                $registrado=Grafo::registrarRelacion(
                    $conexion,
                    $id_destino,
                    $relacion,
                    $contenido,
                    $id_nodo,
                    $id_grafo
                );

                if($registrado){
                    echo '<form id="postForm" action="grafo.php" method="post">';
                    echo '<input type="hidden" name="id_grafo" value="'.$id_grafo.'">';
                    echo '</form>';
                    echo '<script>';
                    echo 'setTimeout(function() { document.getElementById("postForm").submit(); }, 100);'; 
                    echo '</script>';
                }else{
                    echo '<form id="postForm" action="grafo.php" method="post">';
                    echo '<input type="hidden" name="id_grafo" value="'.$id_grafo.'">';
                    echo '</form>';
                    echo '<script>';
                    echo 'setTimeout(function() { document.getElementById("postForm").submit(); }, 100);';
                    echo '</script>';
                }
            }
        break;        

        case 'eliminar_imagen':
            if (
                !empty($_POST['id_nodo']) &&
                !empty($_POST['id_grafo']) &&
                !empty($_POST['imagen']) 
            ) {
                 $id_nodo = trim($_POST['id_nodo']);
                 $id_grafo = trim($_POST['id_grafo']);
                 $imagen = trim($_POST['imagen']); 

                $eliminado=Grafo::eliminarImagen(
                        $conexion,
                        $imagen
                );

                if($eliminado){
                    echo '<form id="postForm" action="forms.php" method="post">';
                    echo '<input type="hidden" name="id_nodo" value="'.$id_nodo.'">';
                    echo '<input type="hidden" name="id_grafo" value="'.$id_grafo.'">';
                    echo '<input type="hidden" name="tipo_form" value="editar_nodo">';
                    echo '</form>';
                    echo '<script>';
                    echo 'setTimeout(function() { document.getElementById("postForm").submit(); }, 100);'; 
                    echo '</script>';
                }else{
                    echo '<form id="postForm" action="forms.php" method="post">';
                    echo '<input type="hidden" name="id_nodo" value="'.$id_nodo.'">';
                    echo '<input type="hidden" name="id_grafo" value="'.$id_grafo.'">';
                    echo '<input type="hidden" name="tipo_form" value="editar_nodo">';
                    echo '</form>';
                    echo '<script>';
                    echo 'setTimeout(function() { document.getElementById("postForm").submit(); }, 100);';
                    echo '</script>';
                }
            }        
        break;


        case 'registrar_imagen':
            if (
                !empty($_POST['id_nodo']) &&
                !empty($_POST['id_grafo']) &&
                !empty($_POST['carpeta']) &&
                isset($_FILES['archivo']) 
            ) {
                $id_nodo = trim($_POST['id_nodo']);
                $id_grafo = trim($_POST['id_grafo']);
                $carpeta  = trim($_POST['carpeta']);

                $registrado=Grafo::agregarImagenesNodo($conexion, $carpeta);

                if($registrado){
                    echo '<form id="postForm" action="forms.php" method="post">';
                    echo '<input type="hidden" name="id_nodo" value="'.$id_nodo.'">';
                    echo '<input type="hidden" name="id_grafo" value="'.$id_grafo.'">';
                    echo '<input type="hidden" name="tipo_form" value="editar_nodo">';
                    echo '</form>';
                    echo '<script>';
                    echo 'setTimeout(function() { document.getElementById("postForm").submit(); }, 100);'; 
                    echo '</script>';
                }else{
                    echo '<form id="postForm" action="forms.php" method="post">';
                    echo '<input type="hidden" name="id_nodo" value="'.$id_nodo.'">';
                    echo '<input type="hidden" name="id_grafo" value="'.$id_grafo.'">';
                    echo '<input type="hidden" name="tipo_form" value="editar_nodo">';
                    echo '</form>';
                    echo '<script>';
                    echo 'setTimeout(function() { document.getElementById("postForm").submit(); }, 100);';
                    echo '</script>';
                }
            } 
        break;      

        case 'editar_info_nodo':
            if (
                !empty($_POST['id_nodo']) &&
                !empty($_POST['id_grafo']) &&
                !empty($_POST['nombre']) &&
                !empty($_POST['contenido']) 
            ) {
                $id_nodo = trim($_POST['id_nodo']);
                $id_grafo = trim($_POST['id_grafo']);
                $nombre = trim($_POST['nombre']);
                $contenido = trim($_POST['contenido']);

                $editado=Grafo::editarInfoNodo($conexion, $id_nodo, $nombre, $contenido);

                if($editado){
                    echo '<form id="postForm" action="forms.php" method="post">';
                    echo '<input type="hidden" name="id_nodo" value="'.$id_nodo.'">';
                    echo '<input type="hidden" name="id_grafo" value="'.$id_grafo.'">';
                    echo '<input type="hidden" name="tipo_form" value="editar_nodo">';
                    echo '</form>';
                    echo '<script>';
                    echo 'setTimeout(function() { document.getElementById("postForm").submit(); }, 100);'; 
                    echo '</script>';
                }else{
                    echo '<form id="postForm" action="forms.php" method="post">';
                    echo '<input type="hidden" name="id_nodo" value="'.$id_nodo.'">';
                    echo '<input type="hidden" name="id_grafo" value="'.$id_grafo.'">';
                    echo '<input type="hidden" name="tipo_form" value="editar_nodo">';
                    echo '</form>';
                    echo '<script>';
                    echo 'setTimeout(function() { document.getElementById("postForm").submit(); }, 100);';
                    echo '</script>';
                }
            }
        break;

        case 'editar_info_relacion':
            if (
                !empty($_POST['id_relacion']) &&
                !empty($_POST['id_grafo']) &&
                !empty($_POST['nombre']) &&
                !empty($_POST['contenido']) 
            ) {
                $id_relacion = trim($_POST['id_relacion']);
                $id_grafo = trim($_POST['id_grafo']);
                $nombre = trim($_POST['nombre']);
                $contenido = trim($_POST['contenido']);

                $editado=Grafo::editarInfoRelacion($conexion, $id_relacion, $nombre, $contenido);

                if($editado){
                    echo '<form id="postForm" action="forms.php" method="post">';
                    echo '<input type="hidden" name="id_relacion" value="'.$id_relacion.'">';
                    echo '<input type="hidden" name="id_grafo" value="'.$id_grafo.'">';
                    echo '<input type="hidden" name="tipo_form" value="editar_relacion">';
                    echo '</form>';
                    echo '<script>';
                    echo 'setTimeout(function() { document.getElementById("postForm").submit(); }, 100);'; 
                    echo '</script>';
                }else{
                    echo '<form id="postForm" action="forms.php" method="post">';
                    echo '<input type="hidden" name="id_relacion" value="'.$id_relacion.'">';
                    echo '<input type="hidden" name="id_grafo" value="'.$id_grafo.'">';
                    echo '<input type="hidden" name="tipo_form" value="editar_relacion">';
                    echo '</form>';
                    echo '<script>';
                    echo 'setTimeout(function() { document.getElementById("postForm").submit(); }, 100);';
                    echo '</script>';
                }
            }
        break;

        case 'eliminar_relacion':
            if (
                !empty($_POST['id_relacion']) &&
                !empty($_POST['id_grafo']) 
            ) {
                $id_relacion = trim($_POST['id_relacion']);
                $id_grafo = trim($_POST['id_grafo']);

                $eliminado=Grafo::eliminarRelacion($conexion, $id_relacion);

                if($eliminado){
                    echo '<form id="postForm" action="grafo.php" method="post">';
                    echo '<input type="hidden" name="id_grafo" value="'.$id_grafo.'">';
                    echo '</form>';
                    echo '<script>';
                    echo 'setTimeout(function() { document.getElementById("postForm").submit(); }, 100);'; 
                    echo '</script>';
                }else{
                    echo '<form id="postForm" action="grafo.php" method="post">';
                    echo '<input type="hidden" name="id_grafo" value="'.$id_grafo.'">';
                    echo '</form>';
                    echo '<script>';
                    echo 'setTimeout(function() { document.getElementById("postForm").submit(); }, 100);';
                    echo '</script>';
                }
            }
        break;

        case 'eliminar_nodo':
            if (
                !empty($_POST['id_nodo']) &&
                !empty($_POST['id_grafo'])
            ) {
                $id_nodo = trim($_POST['id_nodo']);
                $id_grafo = trim($_POST['id_grafo']);

                $eliminado=Grafo::eliminarNodo($conexion, $id_nodo);

                if($eliminado){
                    echo '<form id="postForm" action="grafo.php" method="post">';
                    echo '<input type="hidden" name="id_grafo" value="'.$id_grafo.'">';
                    echo '</form>';
                    echo '<script>';
                    echo 'setTimeout(function() { document.getElementById("postForm").submit(); }, 100);'; 
                    echo '</script>';
                }else{
                    echo '<form id="postForm" action="grafo.php" method="post">';
                    echo '<input type="hidden" name="id_grafo" value="'.$id_grafo.'">';
                    echo '</form>';
                    echo '<script>';
                    echo 'setTimeout(function() { document.getElementById("postForm").submit(); }, 100);';
                    echo '</script>';
                }
            }
        break;

        default:
            echo "Formulario no reconocido.";
        break;
    }
}

mysqli_close($conexion);
?>
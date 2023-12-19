<?php
require_once("../config/conexion.php");
require_once("../models/Ticket.php");
$ticket = new Tickets();
require_once("../models/Usuario.php");
$usuario = new Usuario();
require_once("../models/Documento.php");
$documento = new Documento();

$key = "mi_key_987";
$cipher = "aes-256-cbc";
$ivLength = openssl_cipher_iv_length($cipher);
$iv = openssl_random_pseudo_bytes($ivLength);

switch ($_GET["op"]) {
                #region insert
        case "insert":
                $datos = $ticket->insert_ticket($_POST["usu_id"], $_POST["cat_id"], $_POST["subc_id"], $_POST["tick_titulo"], $_POST["tick_descrip"], $_POST["prio_id"]);
                if (is_array($datos) == true and count($datos) > 0) {
                        $output["tick_id"] = $datos[0]["tick_id"];

                        if (empty($_FILES['files']['name'])) {
                        } else {
                                $countfiles = count($_FILES['files']['name']);
                                $ruta = "../assets/documents/" . $output["tick_id"] . "/";
                                $files_arr = array();

                                if (!file_exists($ruta)) {
                                        mkdir($ruta, 0777, true);
                                }

                                for ($index = 0; $index < $countfiles; $index++) {
                                        $doc1 = $_FILES['files']['tmp_name'][$index];
                                        $destino = $ruta . $_FILES['files']['name'][$index];

                                        $documento->insert_documento($output["tick_id"], $_FILES['files']['name'][$index]);

                                        move_uploaded_file($doc1, $destino);
                                }
                        }
                }


                echo json_encode($datos);
                break;
                #endregion 
                #region listar_x_usu
        case 'listar_x_usu':
                $datos = $ticket->listar_ticket_x_usu($_POST["usu_id"]);
                $data = array();
                foreach ($datos as $row) {

                        $sub_array = array();
                        $sub_array[] = $row["tick_id"];
                        $sub_array[] = $row["cat_nom"];
                        $sub_array[] = $row["tick_titulo"];

                        if ($row["prio_nom"] == "Alto") {
                                $sub_array[] = '<span class="label label-pill label-danger">Alto</span>';
                        } else if ($row["prio_nom"] == "Medio") {
                                $sub_array[] = '<span class="label label-pill label-warning">Medio</span>';
                        } else {
                                $sub_array[] = '<span class="label label-pill label-info">Bajo</span>';
                        }

                        if ($row["tick_estado"] == "Abierto") {
                                $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                        } else {
                                $sub_array[] = '<a onClick="CambiarEstado(' . $row["tick_id"] . ')"><span class="label label-pill label-danger">Cerrado</span></a>';
                        }


                        $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fecha_crea"]));


                        if ($row["fecha_asign"] == null) {
                                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                        } else {
                                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fecha_asign"]));
                        }

                        if ($row["fecha_cierre"] == null) {
                                $sub_array[] = '<span class="label label-pill label-default">Sin Cerrar</span>';
                        } else {
                                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fecha_cierre"]));
                        }

                        if ($row["usu_asign"] == null) {


                                $sub_array[] = '<span class="label label-pill label-warning">Sin Asignar</span>';
                        } else {
                                $datos1 = $usuario->get_usuario_x_id($row["usu_asign"]);
                                foreach ($datos1 as $row1) {
                                        $sub_array[] = '<span class="label label-pill label-success">' . $row1["user_nom"] . ' ' . $row1["user_ape"] . '</span>';
                                }
                        }
                        $output = openssl_encrypt($row["tick_id"], $cipher, $key, OPENSSL_RAW_DATA, $iv);
                        $tick_cifra = base64_encode($iv . $output);

                        $sub_array[] = '<button type="button" data-ciphertext="(' . $tick_cifra . '"  id="' . $tick_cifra . '" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                        $data[] = $sub_array;
                }
                $results = array(
                        "sEcho" => 1,
                        "iTotalRecords" => count($data),
                        "iTotalDisplayRecords" => count($data),
                        "aaData" => $data
                );
                echo json_encode($results);

                break;
                #endregion 


        case 'listar':
                $datos = $ticket->listar_ticket();
                $data = array();
                foreach ($datos as $row) {
                        $sub_array = array();
                        $sub_array[] = $row["tick_id"];
                        $sub_array[] = $row["cat_nom"];
                        $sub_array[] = $row["tick_titulo"];


                        if ($row["prio_nom"] == "Alto") {
                                $sub_array[] = '<span class="label label-pill label-danger">Alto</span>';
                        } else if ($row["prio_nom"] == "Medio") {
                                $sub_array[] = '<span class="label label-pill label-warning">Medio</span>';
                        } else {
                                $sub_array[] = '<span class="label label-pill label-info">Bajo</span>';
                        }

                        if ($row["tick_estado"] == "Abierto") {
                                $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                        } else {
                                $sub_array[] = '<a onClick="CambiarEstado(' . $row["tick_id"] . ')"><span class="label label-pill label-danger">Cerrado</span></a>';
                        }


                        $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fecha_crea"]));

                        if ($row["fecha_asign"] == null) {
                                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                        } else {
                                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fecha_asign"]));
                        }

                        if ($row["fecha_cierre"] == null) {
                                $sub_array[] = '<span class="label label-pill label-default">Sin Cerrar</span>';
                        } else {
                                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fecha_cierre"]));
                        }

                        if ($row["usu_asign"] == null) {
                                $sub_array[] = '<a onClick="asignar(' . $row["tick_id"] . ');"><span class="label label-pill label-warning">Sin Asignar</span></a>';
                        } else {
                                $datos1 = $usuario->get_usuario_x_id($row["usu_asign"]);
                                foreach ($datos1 as $row1) {
                                        $sub_array[] = '<span class="label label-pill label-success">' . $row1["user_nom"] . ' ' . $row1["user_ape"] . '</span>';
                                }
                        }

                        $sub_array[] = '<button type="button" onClick="ver(' . $row["tick_id"] . ');"  id="' . $row["tick_id"] . '" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                        $data[] = $sub_array;
                }
                $results = array(
                        "sEcho" => 1,
                        "iTotalRecords" => count($data),
                        "iTotalDisplayRecords" => count($data),
                        "aaData" => $data
                );
                echo json_encode($results);

                break;
                #endregion 
        case 'listardetalle':
                #region listardetalle
                $iv_dec = substr(base64_decode($_POST["tick_id"]), 0, openssl_cipher_iv_length($cipher));
                /* Obtener el texto cifrado sin el IV */
                $cifradoSinIV = substr(base64_decode($_POST["tick_id"]), openssl_cipher_iv_length($cipher));
                $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

                $datos = $ticket->listar_ticketdetalle_x_ticket($decifrado);
?>

                <?php
                foreach ($datos as $row) {
                ?>

                        <article class="activity-line-item box-typical">
                                <div class="activity-line-date">
                                        <?php echo date("d/m/Y", strtotime($row["fecha_crea"])); ?>
                                </div>
                                <header class="activity-line-item-header">
                                        <div class="activity-line-item-user">
                                                <div class="activity-line-item-user-photo">
                                                        <a href="#">
                                                                <img src="../../assets/img/<?php echo $row['rol_id'] ?>.png">
                                                        </a>
                                                </div>
                                                <div class="activity-line-item-user-name">
                                                        <?php echo $row['user_nom'] . ' ' . $row['user_ape']; ?>
                                                </div>
                                                <div class="activity-line-item-user-status">
                                                        <?php
                                                        if ($row['rol_id'] == 1) {
                                                                echo 'Usuario';
                                                        } else {
                                                                echo 'Soporte';
                                                        }
                                                        ?>
                                                </div>
                                        </div>
                                </header>
                                <div class="activity-line-action-list">
                                        <section class="activity-line-action">
                                                <div class="time">
                                                        <?php echo date("H:i:s", strtotime($row["fecha_crea"])); ?>
                                                </div>
                                                <div class="cont">
                                                        <div class="cont-in">
                                                                <p>
                                                                        <?php echo $row["tickdetalle_descrip"]; ?>
                                                                </p>

                                                                <br>

                                                                <?php
                                                                $datos_det = $documento->get_documento_detalle_x_ticket($row['ticket_id']);
                                                                if (is_array($datos_det) == true and count($datos_det) > 0) {
                                                                ?>
                                                                        <p><strong> Documentos adicionales</strong></p>

                                                                        <p>

                                                                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                                                                                <thead>
                                                                                        <tr>
                                                                                                <th style="width: 60%;"> Nombre</th>
                                                                                                <th style="width: 40%;"></th>
                                                                                        </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                        <?php
                                                                                        foreach ($datos_det as $row_det) {

                                                                                        ?>

                                                                                                <tr>
                                                                                                        <td><?php echo $row_det["deta_nom"]; ?></td>
                                                                                                        <td>
                                                                                                                <a href="../../assets/document_detalle/<?php echo $row_det["ticket_id"]; ?>/<?php echo $row_det["deta_nom"]; ?>" target="_blank" class="btn btn-inline btn-primary btn-sm">Ver</a>
                                                                                                        </td>
                                                                                                </tr>

                                                                                        <?php
                                                                                        }
                                                                                        ?>

                                                                                </tbody>
                                                                        </table>

                                                                        </p>



                                                                <?php

                                                                }

                                                                ?>
                                                        </div>
                                                </div>
                                        </section>
                                </div>

                        </article>

                <?php
                }
                ?>




<?php
                break;
                #endregion 
        case 'mostrar';
                #region mostrar

                $iv_dec = substr(base64_decode($_POST["tick_id"]), 0, openssl_cipher_iv_length($cipher));
                $cifradoSinIV = substr(base64_decode($_POST["tick_id"]), openssl_cipher_iv_length($cipher));
                $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

                $datos = $ticket->listar_ticket_x_id($decifrado);
                if (is_array($datos) == true and count($datos) > 0) {
                        foreach ($datos as $row) {
                                $output["tick_id"] = $row["tick_id"];
                                $output["usu_id"] = $row["usu_id"];
                                $output["cat_id"] = $row["cat_id"];
                                $output["tick_titulo"] = $row["tick_titulo"];
                                $output["tick_descrip"] = $row["tick_descrip"];
                                $output["usu_asign"] = $row["usu_asign"];

                                if ($row["tick_estado"] == "Abierto") {
                                        $output["tick_estado"] = '<span class="label label-pill label-success">Abierto</span>';
                                } else {
                                        $output["tick_estado"] = '<span class="label label-pill label-danger">Cerrado</span>';
                                }

                                $output["tick_estado_texto"] = $row["tick_estado"];
                                $output["fecha_crea"] = date("d/m/Y H:i:s", strtotime($row["fecha_crea"]));
                                $output["fecha_cierre"] = date("d/m/Y H:i:s", strtotime($row["fecha_cierre"]));
                                $output["user_nom"] = $row["user_nom"];
                                $output["user_ape"] = $row["user_ape"];
                                $output["cat_nom"] = $row["cat_nom"];
                                $output["subc_nom"] = $row["subc_nom"];
                                $output["tick_estrellas"] = $row["tick_estrellas"];
                                $output["tick_coment"] = $row["tick_coment"];
                                $output["prio_nom"] = $row["prio_nom"];
                        }
                        echo json_encode($output);
                }
                break;
                #endregion 
        case 'insertdetalle':
                #region insertdetalle
                $iv_dec = substr(base64_decode($_POST["tick_id"]), 0, openssl_cipher_iv_length($cipher));
                /* Obtener el texto cifrado sin el IV */
                $cifradoSinIV = substr(base64_decode($_POST["tick_id"]), openssl_cipher_iv_length($cipher));
                /* TODO: Descifrado */
                $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

                $datos = $ticket->insert_ticketdetalle($decifrado, $_POST["usu_id"], $_POST["tickdetalle_descrip"]);

                if (is_array($datos) == true and count($datos) > 0) {
                        foreach ($datos as $row) {
                                /* TODO: Obtener tikd_id de $datos */
                                $output["ticket_id"] = $row["ticket_id"];
                                /* TODO: Consultamos si vienen archivos desde la vista */
                                if (empty($_FILES['files']['name'])) {
                                } else {
                                        /* TODO:Contar registros */
                                        $countfiles = count($_FILES['files']['name']);
                                        /* TODO:Ruta de los documentos */
                                        $ruta = "../assets/document_detalle/" . $output["ticket_id"] . "/";
                                        /* TODO: Array de archivos */
                                        $files_arr = array();
                                        /* TODO: Consultar si la ruta existe en caso no exista la creamos */
                                        if (!file_exists($ruta)) {
                                                mkdir($ruta, 0777, true);
                                        }
                                        /* TODO:recorrer todos los registros */
                                        for ($index = 0; $index < $countfiles; $index++) {
                                                $doc1 = $_FILES['files']['tmp_name'][$index];
                                                $destino = $ruta . $_FILES['files']['name'][$index];

                                                $documento->insert_documento_detalle($output["ticket_id"], $_FILES['files']['name'][$index]);

                                                move_uploaded_file($doc1, $destino);
                                        }
                                }
                        }
                }
                echo json_encode($datos);
                #endregion 

                break;
                //! --------------------------------------------------------------------------------------------------*/
        case "update":
                #region update

                $ticket->update_ticket($_POST["tick_id"]);
                $ticket->insert_ticketdetalle_cerrar($_POST["tick_id"], $_POST["usu_id"]);

                #endregion 
                break;
        case "reabrir":
                #region reabrir
                $ticket->reabrir_ticket($_POST["tick_id"]);
                $ticket->insert_ticketdetalle_reabrir($_POST["tick_id"], $_POST["usu_id"]);
                break;
                #endregion 
        case "total";
                #region total
                $datos = $ticket->get_ticket_total();
                if (is_array($datos) == true and count($datos) > 0) {
                        foreach ($datos as $row) {
                                $output["Total"] = $row["Total"];
                        }
                        echo json_encode($output);
                }
                break;
                #endregion 
        case "totalabierto";
                #region totalcerrado
                $datos = $ticket->get_ticket_totalabierto();
                if (is_array($datos) == true and count($datos) > 0) {
                        foreach ($datos as $row) {
                                $output["Total"] = $row["Total"];
                        }
                        echo json_encode($output);
                }
                break;
                #endregion
        case "totalcerrado";
                #region totalcerrado
                $datos = $ticket->get_ticket_totalcerrado();
                if (is_array($datos) == true and count($datos) > 0) {
                        foreach ($datos as $row) {
                                $output["Total"] = $row["Total"];
                        }
                        echo json_encode($output);
                }
                break;
                #endregion 
        case 'grafico':
                #region grafico
                $datos = $ticket->get_ticket_grafico();
                echo json_encode($datos);
                break;
                #endregion 
        case "asignar":
                #region asignar

                $ticket->update_asignar($_POST["tick_id"], $_POST["usu_asign"]);

                break;
                //! --------------------------------------------------------------------------------------------------*/
                #endregion 
        case "encuesta":
                #region encuesta
                $ticket->insert_encuesta($_POST["tick_id"], $_POST["tick_estrellas"], $_POST["tick_coment"]);
                break;
                //! --------------------------------------------------------------------------------------------------*/
                #endregion 
        case 'listar_filtro':
                #region listar_filtro
                $datos = $ticket->filtrar_ticket($_POST["tick_titulo"], $_POST["cat_id"], $_POST["prio_id"]);
                $data = array();
                foreach ($datos as $row) {


                        $sub_array = array();
                        $sub_array[] = $row["tick_id"];
                        $sub_array[] = $row["cat_nom"];
                        $sub_array[] = $row["tick_titulo"];


                        if ($row["prio_nom"] == "Alto") {
                                $sub_array[] = '<span class="label label-pill label-danger">Alto</span>';
                        } else if ($row["prio_nom"] == "Medio") {
                                $sub_array[] = '<span class="label label-pill label-warning">Medio</span>';
                        } else {
                                $sub_array[] = '<span class="label label-pill label-info">Bajo</span>';
                        }

                        if ($row["tick_estado"] == "Abierto") {
                                $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                        } else {
                                $sub_array[] = '<a onClick="CambiarEstado(' . $row["tick_id"] . ')"><span class="label label-pill label-danger">Cerrado</span></a>';
                        }


                        $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fecha_crea"]));

                        if ($row["fecha_asign"] == null) {
                                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                        } else {
                                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fecha_asign"]));
                        }

                        if ($row["fecha_cierre"] == null) {
                                $sub_array[] = '<span class="label label-pill label-default">Sin Cerrar</span>';
                        } else {
                                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fecha_cierre"]));
                        }

                        if ($row["usu_asign"] == null) {
                                $sub_array[] = '<a onClick="asignar(' . $row["tick_id"] . ');"><span class="label label-pill label-warning">Sin Asignar</span></a>';
                        } else {
                                $datos1 = $usuario->get_usuario_x_id($row["usu_asign"]);
                                foreach ($datos1 as $row1) {
                                        $sub_array[] = '<span class="label label-pill label-success">' . $row1["user_nom"] . ' ' . $row1["user_ape"] . '</span>';
                                }
                        }

                        $output = openssl_encrypt($row["tick_id"], $cipher, $key, OPENSSL_RAW_DATA, $iv);
                        $tick_cifra = base64_encode($iv . $output);

                        $sub_array[] = '<button type="button" data-ciphertext="' . $tick_cifra . '"  id="' . $tick_cifra . '" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                        $data[] = $sub_array;
                }
                $results = array(
                        "sEcho" => 1,
                        "iTotalRecords" => count($data),
                        "iTotalDisplayRecords" => count($data),
                        "aaData" => $data
                );
                echo json_encode($results);

                break;
                //! --------------------------------------------------------------------------------------------------*/
                #endregion 

        case 'mostrar_noencry':
                #region mostrar_noencry
                $datos = $ticket->listar_ticket_x_id($_POST["tick_id"]);
                if (is_array($datos) == true and count($datos) > 0) {
                        foreach ($datos as $row) {
                                $output["tick_id"] = $row["tick_id"];
                                $output["usu_id"] = $row["usu_id"];
                                $output["cat_id"] = $row["cat_id"];
                                $output["tick_titulo"] = $row["tick_titulo"];
                                $output["tick_descrip"] = $row["tick_descrip"];
                                $output["usu_asign"] = $row["usu_asign"];

                                if ($row["tick_estado"] == "Abierto") {
                                        $output["tick_estado"] = '<span class="label label-pill label-success">Abierto</span>';
                                } else {
                                        $output["tick_estado"] = '<span class="label label-pill label-danger">Cerrado</span>';
                                }

                                $output["tick_estado_texto"] = $row["tick_estado"];
                                $output["fecha_crea"] = date("d/m/Y H:i:s", strtotime($row["fecha_crea"]));
                                $output["fecha_cierre"] = date("d/m/Y H:i:s", strtotime($row["fecha_cierre"]));
                                $output["user_nom"] = $row["user_nom"];
                                $output["user_ape"] = $row["user_ape"];
                                $output["cat_nom"] = $row["cat_nom"];
                                $output["subc_nom"] = $row["subc_nom"];
                                $output["tick_estrellas"] = $row["tick_estrellas"];
                                $output["tick_coment"] = $row["tick_coment"];
                                $output["prio_nom"] = $row["prio_nom"];
                        }
                        echo json_encode($output);
                }

                break;
                //! --------------------------------------------------------------------------------------------------*/
                #endregion 
}


?>
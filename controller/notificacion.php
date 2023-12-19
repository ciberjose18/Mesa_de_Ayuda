<?php
/*TODO: llamada a las clases necesarias */
require_once("../config/conexion.php");
require_once("../models/Notificacion.php");
$notificacion = new Notificacion();
$key = "mi_key_987";
$cipher = "aes-256-cbc";
$ivLength = openssl_cipher_iv_length($cipher);
$iv = openssl_random_pseudo_bytes($ivLength);
/*TODO: opciones del controlador */
switch ($_GET["op"]) {

        /* TODO: Mostrar en formato JSON segun usu_id */
        //! --------------------------------------------------------------------------------------------------*/

    case "mostrar";
        $datos = $notificacion->get_notificacion_x_usu($_POST["usu_id"]);
        if (
            is_array($datos) == true and count($datos) > 0
        ) {
            foreach ($datos as $row) {
                $output["not_id"] = $row["not_id"];
                $output["usu_id"] = $row["usu_id"];
                $output["not_mensaje"] = $row["not_mensaje"] . ' ' . $row["tick_id"];
                $output["tick_id"] = $row["tick_id"];
            }
            echo json_encode($output);
        }
        break;
        //! --------------------------------------------------------------------------------------------------*/

        /* TODO:Actualizar estado segun not_id */
    case "actualizar";
        $notificacion->update_notificacion_estado($_POST["not_id"]);
        break;
        //! --------------------------------------------------------------------------------------------------*/

    case "listar":
        $datos = $notificacion->get_notificacion_x_usu2($_POST["usu_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["not_mensaje"] . ' ' . $row["tick_id"];
            
            $output = openssl_encrypt($row["tick_id"], $cipher, $key, OPENSSL_RAW_DATA, $iv);
            $tick_cifra = base64_encode($iv . $output);
            $sub_array[] = '<button type="button" data-ciphertext="' .$tick_cifra.'"  id="'.$tick_cifra.'" class="btn btn-inline btn-info btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
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


}

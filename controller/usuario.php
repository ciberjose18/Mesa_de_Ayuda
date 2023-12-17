<?php
require_once("../config/conexion.php");
require_once("../models/Usuario.php");
$usuario = new Usuario();

$key = "mi_key_987";
$cipher = "aes-256-cbc";
$ivLength = openssl_cipher_iv_length($cipher);
$iv = openssl_random_pseudo_bytes($ivLength);
switch ($_GET["op"]) {
        #region guardaryeditar
    case  "guardaryeditar":

        if (empty($_POST["usu_id"])) {
            $usuario->insert_usuario($_POST["user_nom"], $_POST["user_ape"], $_POST["user_email"], $_POST["user_pass"], $_POST["rol_id"], $_POST["user_tel"]);
        } else {
            $usuario->update_usuario($_POST["usu_id"], $_POST["user_nom"], $_POST["user_ape"], $_POST["user_email"], $_POST["user_pass"], $_POST["rol_id"], $_POST["user_tel"]);
        }

        break;
        #endregion 
        #region listar
    case 'listar':
        $datos = $usuario->get_usuario();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["user_nom"];
            $sub_array[] = $row["user_ape"];
            $sub_array[] = $row["user_email"];
            $sub_array[] = $row["user_pass"];

            if ($row["rol_id"] == "1") {
                $sub_array[] = '<span class="label label-pill label-success">Usuario</span>';
            } else {
                $sub_array[] = '<span class="label label-pill label-info">Soporte</span>';
            }


            $sub_array[] = '<button type="button" onClick="editar(' . $row["usu_id"] . ');"  id="' . $row["usu_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-pencil-square"></i></button>';
            $sub_array[] = '<button type="button" onClick="eliminar(' . $row["usu_id"] . ');"  id="' . $row["usu_id"] . '" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
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
        #region eliminar
    case 'eliminar':
        $datos = $usuario->delete_usuario($_POST["usu_id"]);

        break;
        #endregion 
        #region mostraruser
    case 'mostraruser';
        $datos = $usuario->get_usuario_x_id($_POST["usu_id"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["usu_id"] = $row["usu_id"];
                $output["user_nom"] = $row["user_nom"];
                $output["user_ape"] = $row["user_ape"];
                $output["user_email"] = $row["user_email"];

                $iv_dec = substr(base64_decode($row["user_pass"]), 0, openssl_cipher_iv_length($cipher));
                $cifradoSinIV = substr(base64_decode($row["user_pass"]), openssl_cipher_iv_length($cipher));
                $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

                $output["user_pass"] = $decifrado;
                $output["rol_id"] = $row["rol_id"];
                $output["user_tel"] = $row["user_tel"];
            }
            echo json_encode($output);
        }
        break;
        #endregion 


        #region total
    case "total";
        $datos = $usuario->get_usuario_total_x_id($_POST["usu_id"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["Total"] = $row["Total"];
            }
            echo json_encode($output);
        }
        break;
        #endregion 

        #region totalabierto
    case "totalabierto";
        $datos = $usuario->get_usuario_totalabierto_x_id($_POST["usu_id"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["Total"] = $row["Total"];
            }
            echo json_encode($output);
        }
        break;
        #endregion 
        #region totalcerrado
    case "totalcerrado";
        $datos = $usuario->get_usuario_totalcerrado_x_id($_POST["usu_id"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["Total"] = $row["Total"];
            }
            echo json_encode($output);
        }
        break;
        #endregion 
        #region grafico
    case 'grafico':
        $datos = $usuario->get_usuario_grafico($_POST["usu_id"]);
        echo json_encode($datos);
        break;
        #endregion 
        #region combo
    case "combo";

        $datos = $usuario->get_usuario_x_rol();
        if (is_array($datos) == true and count($datos) > 0) {
            $html = '';
            $html .= "<option label='Seleccionar'></option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['usu_id'] . "'>" . $row['user_nom'] . " " . $row['user_ape'] . "</option>";
            }
            echo $html;
        }
        break;
        #endregion 
        #region password
    case 'password':
        $output = openssl_encrypt($_POST["user_pass"], $cipher, $key, OPENSSL_RAW_DATA, $iv);
        $pass_cifra = base64_encode($iv . $output);
        $usuario->update_pass($_POST["usu_id"], $pass_cifra);
        break;
        #endregion 

}

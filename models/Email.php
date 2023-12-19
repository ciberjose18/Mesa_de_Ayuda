<?php
/* librerias necesarias para que el proyecto pueda enviar emails */
require "../include/vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
/* llamada de las clases necesaria s que se usaran en el envio del mail */
require_once("../config/conexion.php");
require_once("../models/Ticket.php");


class Email extends PHPMailer
{

    //variable que contiene el correo del destinatario
    protected $gCorreo = 'josetriana2018@outlook.es';
    protected $gContrasena = 'joseelkoko1562';
    //variable que contiene la contraseña del destinatario


    public function ticket_abierto($tick_id)
    {
        $ticket = new Tickets();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach ($datos as $row) {
            $id = $row["tick_id"];
            $usu = $row["user_nom"];
            $titulo = $row["tick_titulo"];
            $categoria = $row["cat_nom"];
            $correo = $row["usu_correo"];
        }

        //IGual//
        $this->IsSMTP();
        $this->Host = 'smtp.office365.com'; //Aqui el server
        $this->Port = 587; //Aqui el puerto
        $this->SMTPSecure = 'tls';
        $this->SMTPAuth = true;

        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->setFrom($this->gCorreo, "Ticket Abierto ".$id);

        $this->CharSet = 'UTF8';
        $this->addAddress($correo);
        $this->IsHTML(true);
        $this->Subject = "Ticket Abierto";
        //Igual//
        $cuerpo = file_get_contents('../assets/NuevoTicket.html'); /* Ruta del template en formato HTML */
        /* parametros del template a remplazar */
        $cuerpo = str_replace("xnroticket", $id, $cuerpo);
        $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
        $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
        $cuerpo = str_replace("lblCate", $categoria, $cuerpo);

        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Ticket Abierto");

        try {
            $enviado = $this->Send();
            $response = array();
            if ($enviado) {
                $response['status'] = 'success';
                $response['message'] = 'Correo enviado correctamente';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Error al enviar el correo: ' . $this->ErrorInfo;
            }
        } catch (Exception $e) {
            $response['status'] = 'exception';
            $response['message'] = 'Excepción al enviar el correo: ' . $e->getMessage();
        }
        echo json_encode($response);

        return $this->Send();
    }

    public function ticket_cerrado($tick_id)
    {
        $ticket = new Tickets();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach ($datos as $row) {
            $id = $row["tick_id"];
            $usu = $row["user_nom"];
            $titulo = $row["tick_titulo"];
            $categoria = $row["cat_nom"];
            $correo = $row["usu_correo"];
        }

        //IGual//
        $this->IsSMTP();
        $this->Host = 'smtp.office365.com'; //Aqui el server
        $this->Port = 587; //Aqui el puerto
        $this->SMTPAuth = true;
        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->SMTPSecure = 'tls';
        $this->setFrom($this->gCorreo, "Ticket Cerrado ".$id);
        
        $this->CharSet = 'UTF8';
        $this->addAddress($correo);
        $this->IsHTML(true);
        $this->Subject = "Ticket Abierto";
        //Igual//
        $cuerpo = file_get_contents('../assets/CerradoTicket.html'); /* Ruta del template en formato HTML */
        /* parametros del template a remplazar */
        $cuerpo = str_replace("xnroticket", $id, $cuerpo);
        $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
        $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
        $cuerpo = str_replace("lblCate", $categoria, $cuerpo);

        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Ticket Cerrado");

        try {
            $enviado = $this->Send();
            $response = array();
            if ($enviado) {
                $response['status'] = 'success';
                $response['message'] = 'Correo enviado correctamente';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Error al enviar el correo: ' . $this->ErrorInfo;
            }
        } catch (Exception $e) {
            $response['status'] = 'exception';
            $response['message'] = 'Excepción al enviar el correo: ' . $e->getMessage();
        }
        echo json_encode($response);

        return $this->Send();
    }

    public function ticket_asignado($tick_id)
    {
        $ticket = new Tickets();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach ($datos as $row) {
            $id = $row["tick_id"];
            $usu = $row["user_nom"];
            $titulo = $row["tick_titulo"];
            $categoria = $row["cat_nom"];
            $correo = $row["usu_correo"];
        }

        //IGual//
        $this->IsSMTP();
        $this->Host = 'smtp.office365.com'; //Aqui el server
        $this->Port = 587; //Aqui el puerto
        $this->SMTPAuth = true;
        $this->SMTPSecure = 'tls';
        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->setFrom($this->gCorreo, "Ticket Asignado ".$id);
        $this->CharSet = 'UTF8';
        $this->addAddress($correo);
        $this->IsHTML(true);
        $this->Subject = "Ticket Abierto";
        //Igual//
        $cuerpo = file_get_contents('../assets/AsignarTicket.html'); /* Ruta del template en formato HTML */
        /* parametros del template a remplazar */
        $cuerpo = str_replace("xnroticket", $id, $cuerpo);
        $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
        $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
        $cuerpo = str_replace("lblCate", $categoria, $cuerpo);

        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Ticket Asignado");

        try {
            $enviado = $this->Send();
            $response = array();
            if ($enviado) {
                $response['status'] = 'success';
                $response['message'] = 'Correo enviado correctamente';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Error al enviar el correo: ' . $this->ErrorInfo;
            }
        } catch (Exception $e) {
            $response['status'] = 'exception';
            $response['message'] = 'Excepción al enviar el correo: ' . $e->getMessage();
        }
        echo json_encode($response);

        return $this->Send();
    }
}

<?php
/* llamada de las clases necesarias que se usaran en el envio del mail */
require_once("../config/conexion.php");
require_once("../models/Ticket.php");

class Whastapp extends Conectar
{

    public function w_ticket_abierto($tick_id)
    {
        $ticket = new Tickets();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach ($datos as $row) {
            $id = $row["tick_id"];
            $titulo = $row["tick_titulo"];
            $categoria = $row["cat_nom"];
            $subcategoria = $row["subc_nom"];
            $telefono = $row["user_tel"];
        }
        $url = 'https://api.green-api.com/waInstance7103856737/sendMessage/9f4302e6f1614ef18604c24e0fb2d6790e33202468154862ab';

        //chatId is the number to send the message to (@c.us for private chats, @g.us for group chats)
        $data = array(
            'chatId' => "".$telefono."@c.us",
            'message' => "Ticket Abierto ".$id." : ".$titulo."\nCategoria : ".$categoria."\nSubCategoria : ".$subcategoria.""
            
        );

        $options = array(
            'http' => array(
                'header' => "Content-Type: application/json\r\n",
                'method' => 'POST',
                'content' => json_encode($data)
            )
        );

        $context = stream_context_create($options);

        $response = file_get_contents($url, false, $context);

        echo $response;
    }

    public function w_ticket_cerrado($tick_id)
    {
        $ticket = new Tickets();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach ($datos as $row) {
            $id = $row["tick_id"];
            $titulo = $row["tick_titulo"];
            $categoria = $row["cat_nom"];
            $subcategoria = $row["subc_nom"];
            $telefono = $row["user_tel"];
        }
        $url = 'https://api.green-api.com/waInstance7103856737/sendMessage/9f4302e6f1614ef18604c24e0fb2d6790e33202468154862ab';

        //chatId is the number to send the message to (@c.us for private chats, @g.us for group chats)
        $data = array(
            'chatId' => "".$telefono."@c.us",
            'message' => "Ticket Cerrado ".$id." : ".$titulo."\nCategoria : ".$categoria."\nSubCategoria : ".$subcategoria."\nSubCategoria : ".""
            
        );

        $options = array(
            'http' => array(
                'header' => "Content-Type: application/json\r\n",
                'method' => 'POST',
                'content' => json_encode($data)
            )
        );

        $context = stream_context_create($options);

        $response = file_get_contents($url, false, $context);

        echo $response;
    }

    public function w_ticket_asignadado($tick_id)
    {
        $ticket = new Tickets();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach ($datos as $row) {
            $id = $row["tick_id"];
            $titulo = $row["tick_titulo"];
            $categoria = $row["cat_nom"];
            $subcategoria = $row["subc_nom"];
            $telefono = $row["user_tel"];
        }
        $url = 'https://api.green-api.com/waInstance7103856737/sendMessage/9f4302e6f1614ef18604c24e0fb2d6790e33202468154862ab';

        //chatId is the number to send the message to (@c.us for private chats, @g.us for group chats)
        $data = array(
            'chatId' => "".$telefono."@c.us",
            'message' => "Ticket Asignado ".$id." : ".$titulo."\nCategoria : ".$categoria."\nSubCategoria : ".$subcategoria.""
            
        );

        $options = array(
            'http' => array(
                'header' => "Content-Type: application/json\r\n",
                'method' => 'POST',
                'content' => json_encode($data)
            )
        );

        $context = stream_context_create($options);

        $response = file_get_contents($url, false, $context);

        echo $response;
    }

}

<?php
require_once("../models/Ticket.php");
class Chatgpt extends Conectar
{
    /* TODO:Todos los registros */
    public function get_respuestaia($tick_id)
    {
        $ticket = new Tickets();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach ($datos as $row){
            $tick_descrip = $row["tick_descrip"];
        }

        $apikey = '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';
        $model = 'gpt-3.5-turbo';
    
        $messages = [
            [
                'role' => 'assistant',
                'content' => 'Responde como un tecnico de soporte TI:'.$tick_descrip,
            ]
        ];
    
        $data = [
            'model' => $model,
            'messages' => $messages,
            'temperature' => 0.5,
            'max_tokens' => 1024,
        ];
    
        $ch = curl_init('https://api.openai.com/v1/completions');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apikey
        ));
    
        $response = curl_exec($ch);
    
        return $response;
    

    }
}

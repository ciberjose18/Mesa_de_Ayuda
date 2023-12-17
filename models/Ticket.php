<?php
class Tickets extends Conectar
{

    public function insert_ticket($usu_id, $cat_id, $subc_id, $tick_titulo, $tick_descrip, $prio_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO mt_ticket (tick_id,usu_id,cat_id,subc_id,tick_titulo,tick_descrip,tick_estado,fecha_crea,usu_asign,fecha_asign, prio_id, estado) VALUES (NULL,?,?,?,?,?,'Abierto',now(),NULL,NULL,?,'1');";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->bindValue(2, $cat_id);
        $sql->bindValue(3, $subc_id);
        $sql->bindValue(4, $tick_titulo);
        $sql->bindValue(5, $tick_descrip);
        $sql->bindValue(6, $prio_id);
        $sql->execute();

        $sql1 = "select last_insert_id() as 'tick_id'";
        $sql1 = $conectar->prepare($sql1);
        $sql1->execute();
        return $resultado = $sql1->fetchAll(pdo::FETCH_ASSOC);
    }

    public function listar_ticket_x_usu($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT mt_ticket.tick_id, 
            mt_ticket.usu_id, 
            mt_ticket.cat_id, 
            mt_ticket.tick_titulo, 
            mt_ticket.tick_descrip, 
            mt_ticket.tick_estado, 
            mt_ticket.fecha_crea, 
            mt_ticket.usu_asign, 
            mt_ticket.fecha_asign, 
            mt_ticket.fecha_cierre, 
            mt_ticket.prio_id, 
            mt_usuario.user_nom, 
            mt_usuario.user_ape, 
            mt_categoria.cat_nom, 
            mt_prioridad.prio_nom 
            FROM mt_ticket 
            INNER join mt_categoria on mt_ticket.cat_id = mt_categoria.cat_id 
            INNER join mt_usuario on mt_ticket.usu_id = mt_usuario.usu_id 
            INNER join mt_prioridad on mt_ticket.prio_id = mt_prioridad.prio_id 
            WHERE mt_ticket.estado = 1 
            AND mt_usuario.usu_id=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    public function listar_ticket_x_id($tick_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
        mt_ticket.tick_id, 
        mt_ticket.usu_id, 
        mt_ticket.cat_id, 
        mt_ticket.subc_id, 
        mt_ticket.tick_titulo, 
        mt_ticket.tick_descrip, 
        mt_ticket.tick_estado, 
        mt_ticket.fecha_crea, 
        mt_ticket.usu_asign, 
        mt_ticket.tick_estrellas, 
        mt_ticket.tick_coment, 
        mt_ticket.fecha_cierre, 
        mt_usuario.user_nom, 
        mt_usuario.user_ape, 
        mt_usuario.user_email, 
        mt_usuario.user_tel, 
        mt_categoria.cat_nom, 
        mt_subcategoria.subc_nom, 
        mt_prioridad.prio_nom 
        FROM 
        mt_ticket 
        INNER join mt_categoria on mt_ticket.cat_id = mt_categoria.cat_id 
        INNER join mt_subcategoria on mt_ticket.subc_id = mt_subcategoria.subc_id 
        INNER join mt_usuario on mt_ticket.usu_id = mt_usuario.usu_id 
        INNER join mt_prioridad on mt_ticket.prio_id = mt_prioridad.prio_id 
        WHERE 
        mt_ticket.estado = 1 
        AND mt_ticket.tick_id=?";

        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }



    public function listar_ticket()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT mt_ticket.tick_id, 
            mt_ticket.usu_id, 
            mt_ticket.cat_id, 
            mt_ticket.tick_titulo, 
            mt_ticket.tick_descrip, 
            mt_ticket.tick_estado, 
            mt_ticket.fecha_crea, 
            mt_ticket.usu_asign, 
            mt_ticket.fecha_asign, 
            mt_ticket.fecha_cierre, 
            mt_ticket.prio_id, 
            mt_usuario.user_nom, 
            mt_usuario.user_ape, 
            mt_categoria.cat_nom, 
            mt_prioridad.prio_nom 
            FROM mt_ticket 
            INNER join mt_categoria on mt_ticket.cat_id = mt_categoria.cat_id 
            INNER join mt_usuario on mt_ticket.usu_id = mt_usuario.usu_id 
            INNER join mt_prioridad on mt_ticket.prio_id = mt_prioridad.prio_id 
            WHERE mt_ticket.estado = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    public function listar_ticketdetalle_x_ticket($tick_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                td_ticketdetalle.ticket_id,
                td_ticketdetalle.tickdetalle_descrip,
                td_ticketdetalle.fecha_crea,
                mt_usuario.user_nom,
                mt_usuario.user_ape,
                mt_usuario.rol_id
                FROM td_ticketdetalle 
                INNER join mt_usuario on td_ticketdetalle.usu_id = mt_usuario.usu_id    
                WHERE tick_id=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    public function insert_ticketdetalle($tick_id, $usu_id, $tickdetalle_descrip)
    {
        $conectar = parent::conexion();
        parent::set_names();

        // OBTENER USUARIO ASIGNADO DEL TICKET_ID
        $ticket = new Tickets();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach ($datos as $row) {
            $usu_asig = $row["usu_asign"];
            $usu_crea = $row["usu_id"];
        }

        /* TODO: si Rol es 1 = Usuario insertar alerta para usuario soporte */
        if ($_SESSION["rol_id"] == 1) {
            // GUARDAR NOTIFICACION DE NUEVO COMENTARIO
            $sql0 = "INSERT INTO mt_notificacion (not_id, usu_id, not_mensaje, tick_id, estado) VALUES (NULL, $usu_asig, 'Tiene una nueva respuesta del usuario del ticket Nro ', $tick_id, 2)";
            $sql0 = $conectar->prepare($sql0);
            $sql0->execute();
        } else {
            /* TODO: Else Rol es = 2 Soporte Insertar alerta para usuario que genero el ticket */

            // GUARDAR NOTIFICACION DE NUEVO COMENTARIO
            $sql0 = "INSERT INTO mt_notificacion (not_id, usu_id, not_mensaje, tick_id, estado) VALUES (NULL, $usu_crea, 'Tiene una nueva respuesta de soporte del ticket Nro ', $tick_id, 2)";
            $sql0 = $conectar->prepare($sql0);
            $sql0->execute();
        }





        $sql = "INSERT INTO td_ticketdetalle (ticket_id, tick_id, usu_id, tickdetalle_descrip, fecha_crea, estado) VALUES (NULL,?,?,?,now(), '1');";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->bindValue(2, $usu_id);
        $sql->bindValue(3, $tickdetalle_descrip);
        $sql->execute();

        // DEVUELVE EL ULTIMO ID INGRESADO
        $sql1 = "select last_insert_id() as 'ticket_id'";
        $sql1 = $conectar->prepare($sql1);
        $sql1->execute();
        return $resultado = $sql1->fetchAll(pdo::FETCH_ASSOC);
    }

    public function insert_ticketdetalle_cerrar($tick_id, $usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call sp_i_ticketdetalle_01(?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->bindValue(2, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function insert_ticketdetalle_reabrir($tick_id, $usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO td_ticketdetalle (ticket_id,tick_id,usu_id,tickdetalle_descrip,fecha_crea,estado) VALUES (NULL,?,?,'Ticket Re-Abierto...',now(),'1');";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->bindValue(2, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    public function reabrir_ticket($tick_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE mt_ticket SET mt_ticket.tick_estado = 'Abierto' WHERE mt_ticket.tick_id=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    public function update_ticket($tick_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE mt_ticket SET mt_ticket.tick_estado='Cerrado', fecha_cierre = now() WHERE mt_ticket.tick_id=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    public function update_asignar($tick_id, $usu_asign)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "update mt_ticket 
                set	
                    usu_asign = ?,
                    fecha_asign = now()
                where
                    tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_asign);
        $sql->bindValue(2, $tick_id);
        $sql->execute();


        // GUARDA NOTIFICACIONES EN LA TABLA
        $sql1 = "INSERT INTO mt_notificacion (not_id, usu_id, not_mensaje, tick_id, estado) VALUES (NULL, ?, 'Se le ha asignado el ticket Nro :', ?, 2)";
        $sql1 = $conectar->prepare($sql1);
        $sql1->bindValue(1, $usu_asign);
        $sql1->bindValue(2, $tick_id);
        $sql1->execute();
        return $resultado = $sql->fetchAll();
    }


    public function get_ticket_total()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) AS Total FROM mt_ticket";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_ticket_totalabierto()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) AS Total FROM mt_ticket WHERE tick_estado='Abierto'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_ticket_totalcerrado()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) AS Total FROM mt_ticket WHERE tick_estado='Cerrado'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_ticket_grafico()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT mt_categoria.cat_nom AS Nom, COUNT(*) AS Total 
        FROM mt_ticket 
        JOIN mt_categoria ON mt_ticket.cat_id = mt_categoria.cat_id 
        WHERE mt_ticket.estado = 1 
        GROUP BY mt_categoria.cat_nom ORDER BY Total DESC";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function insert_encuesta($tick_id, $tick_estrellas, $tick_coment)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "update mt_ticket 
            set	
                tick_estrellas = ?,
                tick_coment = ?
            where
                tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_estrellas);
        $sql->bindValue(2, $tick_coment);
        $sql->bindValue(3, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function filtrar_ticket($tick_titulo, $cat_id, $prio_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call filtrar_ticket (?,?,?);";

        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, "%" . $tick_titulo . "%");
        $sql->bindValue(2, $cat_id);
        $sql->bindValue(3, $prio_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
}

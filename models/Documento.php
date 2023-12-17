<?php
    class Documento extends Conectar{

        public function insert_documento($tick_id,$doc_nom){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="INSERT INTO td_documento (doc_id,tick_id,doc_nom,fecha_crea,estado) VALUES (null,?,?,now(),1)";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(1,$tick_id);
            $sql->bindParam(2,$doc_nom);
            $sql->execute();
            
        }


        public function get_documento_x_ticket($tick_id){
            $conectar= parent::conexion();
            $sql="SELECT * FROM td_documento WHERE tick_id=?";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(1,$tick_id);
            $sql->execute();
            return $resultado = $sql->fetchAll(pdo::FETCH_ASSOC);

            /* consulta sql */
        }



        public function insert_documento_detalle($ticket_id,$deta_nom){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="INSERT INTO td_document_detalle (deta_id,ticket_id,deta_nom,estado) VALUES (null,?,?,1);";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(1,$ticket_id);
            $sql->bindParam(2,$deta_nom);
            $sql->execute();
        }

        
        public function get_documento_detalle_x_ticket($ticket_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="SELECT * FROM td_document_detalle WHERE ticket_id=?";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(1,$ticket_id);
            $sql->execute();
            return $resultado = $sql->fetchAll(pdo::FETCH_ASSOC);
        }
    }
?>
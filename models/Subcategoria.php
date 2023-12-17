<?php
class Subcategoria extends Conectar
{

    public function get_subcategoria($cat_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM mt_subcategoria WHERE cat_id=? AND estado=1";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cat_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    public function get_subcategoria_all()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
            mt_subcategoria.subc_id,
            mt_subcategoria.cat_id,
            mt_subcategoria.subc_nom,
            mt_categoria.cat_nom
            FROM mt_subcategoria INNER JOIN
            mt_categoria on mt_subcategoria.cat_id = mt_categoria.cat_id
            WHERE mt_subcategoria.estado=1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO:Insert */
    public function insert_subcategoria($cat_id, $subc_nom)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO mt_subcategoria (subc_id,cat_id,subc_nom,estado) VALUES (NULL,?,?,'1');";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cat_id);
        $sql->bindValue(2, $subc_nom);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO:Update */
    public function update_subcategoria($subc_id, $cat_id, $subc_nom)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE mt_subcategoria set
                cat_id = ?,
                subc_nom = ?
                WHERE
                subc_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cat_id);
        $sql->bindValue(2, $subc_nom);
        $sql->bindValue(3, $subc_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO:Delete */
    public function delete_subcategoria($subc_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE mt_subcategoria SET
                estado = 0
                WHERE 
                subc_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $subc_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO:Registro x id */
    public function get_subcategoria_x_id($subc_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM mt_subcategoria WHERE subc_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $subc_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
}

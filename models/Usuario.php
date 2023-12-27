<?php

class Usuario extends Conectar
{
    private $key;
    private $cipher;
    private $ivLength;
    private $iv;

    public function __construct() {
        // Inicializa las propiedades de encriptación
        $this->key = "mi_key_987";
        $this->cipher = "aes-256-cbc";
        $this->ivLength = openssl_cipher_iv_length($this->cipher);
        $this->iv = openssl_random_pseudo_bytes($this->ivLength);
    }
    #region login     
    public function login()
    {
        
        $conectar = parent::conexion();
        parent::set_names();
        if (isset($_POST["enviar"])) {           #isset — Determina si una variable está definida y no es null
            $correo = $_POST["usu_correo"];
            $pass = $_POST["usu_pass"];
            $rol = $_POST["rol_id"];
            if (empty($correo) and empty($pass)) {        # Determinar si una variable está vacía
                header("Location:" . Conectar::ruta() . "index.php?m=2");   # m=2 si esta vacío
                exit();
            } else {
                $sql = "SELECT * FROM mt_usuario WHERE user_email=? and rol_id=? and estado=1";
                $stmt = $conectar->prepare($sql);
                $stmt->bindValue(1, $correo);
                $stmt->bindValue(2, $rol);
                $stmt->execute();
                $resultado = $stmt->fetch();
                if($resultado){
                    $textocifrado = $resultado["user_pass"];

                    $iv_dec = substr(base64_decode($textocifrado), 0, openssl_cipher_iv_length($this->cipher));
                    $cifradoSinIV = substr(base64_decode($textocifrado), openssl_cipher_iv_length($this->cipher));
                    $decifrado = openssl_decrypt($cifradoSinIV, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv_dec);
                    if($decifrado==$pass){
                        if (is_array($resultado) and count($resultado) > 0) {
                            $_SESSION["usu_id"] = $resultado["usu_id"];
                            $_SESSION["user_nom"] = $resultado["user_nom"];
                            $_SESSION["user_ape"] = $resultado["user_ape"];
                            $_SESSION["rol_id"] = $resultado["rol_id"];
                            header("Location:" . Conectar::ruta() . "view/Home/");
                            exit();
                        } else {
                            header("Location:" . Conectar::ruta() . "index.php?m=1");
                            exit();
                        }
                    }
                }
            }
        }
    }
    #endregion

    #region insert_usuario   
    public function insert_usuario($user_nom, $user_ape, $user_email, $user_pass, $rol_id, $user_tel)
    {
        $output = openssl_encrypt($user_pass, $this->cipher, $this->key, OPENSSL_RAW_DATA, $this->iv);
        $pass_cifra = base64_encode($this->iv . $output);
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO mt_usuario (usu_id, user_nom, user_ape, user_email, user_pass, rol_id, user_tel, fecha_crea, fecha_modi, fecha_elim, estado) VALUES (NULL,?,?,?,?,?,?, now(), NULL, NULL, '1')";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $user_nom);
        $sql->bindValue(2, $user_ape);
        $sql->bindValue(3, $user_email);
        $sql->bindValue(4, $pass_cifra);
        $sql->bindValue(5, $rol_id);
        $sql->bindValue(6, $user_tel);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    #endregion

    #region update_usuario   
    public function update_usuario($usu_id, $user_nom, $user_ape, $user_email, $user_pass, $rol_id, $user_tel)
    {
        $output = openssl_encrypt($user_pass, $this->cipher, $this->key, OPENSSL_RAW_DATA, $this->iv);
        $pass_cifra = base64_encode($this->iv . $output);
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE mt_usuario SET user_nom =?, user_ape=?, user_email=?, user_pass=?, rol_id=?, user_tel=? WHERE usu_id=? ";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $user_nom);
        $sql->bindValue(2, $user_ape);
        $sql->bindValue(3, $user_email);
        $sql->bindValue(4, $pass_cifra);
        $sql->bindValue(5, $rol_id);
        $sql->bindValue(6, $user_tel);
        $sql->bindValue(7, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    #endregion

    #region delete_usuario   
    public function delete_usuario($usu_id)
    {

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE mt_usuario SET estado='0', fecha_elim=now() WHERE usu_id=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    #endregion

    #region update_pass   
    public function update_pass($usu_id, $user_pass)
    {

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE mt_usuario SET user_pass = ? WHERE usu_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $user_pass);
        $sql->bindValue(2, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    #endregion

    #region get_usuario 
    public function get_usuario()
    {

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call sp_l_usuario_01()";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    #endregion

    #region get_usuario_x_id 
    public function get_usuario_x_id($usu_id)
    {

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call sp_l_usuario_02(?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    #endregion

    #region get_usuario_total_x_id 
    public function get_usuario_total_x_id($usu_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) AS Total FROM mt_ticket WHERE usu_id=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    #endregion
    #region get_usuario_totalabierto_x_id 
    public function get_usuario_totalabierto_x_id($usu_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) AS Total FROM mt_ticket WHERE usu_id=? AND tick_estado='Abierto'";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    #endregion

    #region get_usuario_totalcerrado_x_id 
    public function get_usuario_totalcerrado_x_id($usu_id)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) AS Total FROM mt_ticket WHERE usu_id=? AND tick_estado='Cerrado'";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    #endregion

    #region get_usuario_grafico 
    public function get_usuario_grafico($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT mt_categoria.cat_nom AS Nom, COUNT(*) AS Total 
            FROM mt_ticket 
            JOIN mt_categoria ON mt_ticket.cat_id = mt_categoria.cat_id 
            WHERE mt_ticket.estado = 1 AND mt_ticket.usu_id = ? 
            GROUP BY mt_categoria.cat_nom ORDER BY total DESC;";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    #endregion
    #region get_usuario_x_rol 
    public function get_usuario_x_rol()
    {

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM mt_usuario WHERE mt_usuario.estado='1' AND mt_usuario.rol_id='2'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    #endregion

        #region get_usuario_x_correo 
        public function get_usuario_x_correo($user_email)
        {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM mt_usuario WHERE user_email=?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $user_email);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }
        #endregion
}

<?php
    session_start();

    class Conectar{
        protected $dbh;

        protected function Conexion(){
            try {
                //Local
                $conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=mesa_ayuda", "root", "");
                return $conectar;
            } catch (Exception $e) {
                print "!ERROR DB!" . $e->getMessage() . "<br/>";
                die();
            }
        }


        public function set_names(){
            return $this->dbh->query("SET NAMES 'utf8'");
        }
        
        public static function ruta(){
            return "http://localhost/Mesa_de_Ayuda/";
        }
    }
?>
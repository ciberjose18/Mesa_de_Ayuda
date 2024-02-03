<?php
    /* TODO: Inicio de Sesion en la WebApp */
    session_start();

    class Conectar{
        protected $dbh;

        protected function Conexion(){
            try {
                //TODO: Cadena de Conexion Local
				$conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=mesa_ayuda","root","");
                //TODO: Cadena de Conexion Produccion
				return $conectar;
			} catch (Exception $e) {
				print "¡Error BD!: " . $e->getMessage() . "<br/>";
				die();
			}
        }

        //Mesa de Ayuda

        /* TODO: Set Name para utf 8 español - evitar tener problemas con las tildes */
        public function set_names(){
			return $this->dbh->query("SET NAMES 'utf8'");
        }

        /* TODO: Ruta o Link del proyecto */
        public static function ruta(){
            //TODO: Ruta Proyecto Local
			return "http://localhost/Mesa_de_Ayuda/";
            //TODO: Ruta Proyecto Produccion
		}

    }
?>
<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usu_id"])) {
?>

    <!DOCTYPE html>
    <html>

    <head lang="es">
        <title>Ciberjose - Perfil</title>
        <?php
        require_once("../MainHead/head.php");
        ?>
    </head>

    <body class="with-side-menu">

        <?php
        require_once("../MainHeader/header.php");
        ?>

        <div class="mobile-menu-left-overlay"></div>

        <?php
        require_once("../MainNav/Nav.php");
        ?>
        <!--.CONTENIDO-->
        <div class="page-content">
            <div class="container-fluid">



                <header class="section-header">
                    <div class="tbl">
                        <div class="tbl-row">
                            <div class="tbl-cell">
                                <h3>Perfil</h3>
                                <ol class="breadcrumb breadcrumb-simple">
                                    <li><a href="../Home/">Home</a></li>
                                    <li class="active">Cambiar Contraseña</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </header>

                <div class="box-typical box-typical-padding">

                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="exampleInput">Nueva Contraseña</label>
                                <input type="password" class="form-control" id="txtpass" name="txtpass">                            
                            </fieldset>
                            <div class="checkbox-toggle">
                                    <input class="form-check-input" type="checkbox" onclick="togglePassword('txtpassconfirm')" id="showPassword1">
                                    <label class="form-check-label" for="showPassword1">Mostrar contraseña</label>
                                </div>
                        </div>

                        <div class="col-lg-6">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="exampleInput">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="txtpassconfirm" name="txtpassconfirm">
                            </fieldset>
            
                        </div>



                        <div class="col-lg-12" align="center">

                            <button type="submit" name="btnactualizar" id="btnactualizar" class="btn btn-rounded btn-inline btn-primary">Actualizar</button>
                        </div>

                    </div><!--.row-->
                </div>
            </div><!--.container-fluid-->
        </div><!--.page-content-->

        <?php require_once("../MainJs/js.php"); ?>

        <script type="text/javascript" src="mntperfil.js"></script>
        <script type="text/javascript" src="../notificacion.js"></script>

    </body>

    </html>
<?php
} else {
    header("Location:" . Conectar::ruta() . "index.php");
}
?>
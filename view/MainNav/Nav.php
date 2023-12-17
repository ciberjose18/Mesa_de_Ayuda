<?php
//Rol 1 es de usuario
    if ($_SESSION["rol_id"]==1){
        ?>
<nav class="side-menu">
        <ul class="side-menu-list">
            <li class="blue-dirty">
                <a href="../Home/">
                    <span class="glyphicon glyphicon-th"></span>
                    <span class="lbl">Inicio</span>
                </a>
            </li>

            <li class="green with-sub">
            <a href="../NuevoTicket/">
                    <span class="font-icon glyphicon glyphicon-send"></span>
                    <span class="lbl">Nuevo Ticket</span>
                </a>
            </li>

            <li class="magenta with-sub">
            <a href="../ConsultarTicket/">
                    <span class="font-icon font-icon-notebook"></span>
                    <span class="lbl">Consultar Ticket</span>
                </a>
            </li>
        </ul>
    </nav>


        
<?php
    }else {
        ?>
        <nav class="side-menu">
        <ul class="side-menu-list">
            <li class="blue-dirty">
                <a href="../Home/">
                    <span class="glyphicon glyphicon-th"></span>
                    <span class="lbl">Inicio</span>
                </a>
            </li>

            <li class="magenta with-sub">
            <a href="../ConsultarTicket/">
                    <span class="font-icon font-icon-notebook"></span>
                    <span class="lbl">Consultar Ticket</span>
                </a>
            </li>

            <li class="magenta with-sub">
            <a href="../MntUsuario/">
                    <span class="font-icon font-icon-notebook"></span>
                    <span class="lbl">Mant. Usuario</span>
                </a>
            </li>

            <li class="magenta with-sub">
            <a href="../MntCategoria/">
                    <span class="font-icon font-icon-notebook"></span>
                    <span class="lbl">Mant. Categoria</span>
                </a>
            </li>
            
            
            <li class="magenta with-sub">
            <a href="../MntSubCategoria/">
                    <span class="font-icon font-icon-notebook"></span>
                    <span class="lbl">Mant. SubCategoria</span>
                </a>
            </li>

            <li class="magenta with-sub">
            <a href="../MntPrioridad/">
                    <span class="font-icon font-icon-notebook"></span>
                    <span class="lbl">Mant. Prioridad</span>
                </a>
            </li>

        </ul>
    </nav>
        <?php
    }
?>

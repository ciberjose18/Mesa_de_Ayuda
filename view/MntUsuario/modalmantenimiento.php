<div id="modalmantenimiento" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo"></h4>
            </div>
            <form method="post" id="usuario_form">
                <div class="modal-body">
                    <input type="hidden" id="usu_id" name="usu_id">

                    <div class="form-group">
                        <label class="form-label" for="user_nom">Nombre</label>
                        <input type="text" class="form-control" id="user_nom" name="user_nom" placeholder="Ingrese Nombre" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="user_ape">Apellido</label>
                        <input type="text" class="form-control" id="user_ape" name="user_ape" placeholder="Ingrese Apellido" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="user_email">Correo Electronico</label>
                        <input type="email" class="form-control" id="user_email" name="user_email" placeholder="test@test.com" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="user_pass">Contraseña</label>
                        <input type="text" class="form-control" id="user_pass" name="user_pass" placeholder="************" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="rol_id">Rol</label>
                        <select class="select2" id="rol_id" name="rol_id">
                            <option value="1">Usuario</option>
                            <option value="2">Soporte</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="user_tel">Telefono</label>
                        <input type="text" class="form-control" id="user_tel" name="user_tel" placeholder="Ingrese Telefono" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="action" id="#" value="add" class="btn btn-rounded btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
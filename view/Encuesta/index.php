<!DOCTYPE html>
<html>

<head>
    <title>Encuesta</title>
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" />
    <link rel="stylesheet" href="../../assets/css/lib/bootstrap-sweetalert/sweetalert.css">
<link rel="stylesheet" href="../../assets/css/separate/vendor/sweet-alert-animations.min.css">
</head>

<body>

    <div class="container">
        <section class="row">
            <div class="col-md-12">
                <h1 class="text-center">Formato de Encuesta de Satisfacción.</h1>
            </div>
        </section>
        <hr><br />
        <section class="row">
            <section class="col-md-12">
                <h3>Datos basicos</h3>
                <p></p>
            </section>
        </section>

        <section class="row">
            <section class="col-md-12">
                <section class="row">


                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombreCompleto">Nro de Ticket</label>
                            <input type="text" class="form-control" id="lblnomidticket" name="lblnomidticket" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombreCompleto">Fecha de Cierre</label>
                            <input type="text" class="form-control" id="lblfechacierre" name="lblfechacierre" readonly>
                        </div>
                    </div>
                </section>
                <section class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="tick_titulo">Titulo </label>
                            <input type="text" class="form-control" id="tick_titulo" name="tick_titulo" placeholder="Titulo" readonly />
                        </div>
                    </div>
                </section>
                <section class="row">
                    <div class="col-md-4">
                        <label for="tipoAtencion">Categoria</label>
                        <input type="text" class="form-control" id="cat_nom" name="cat_nom" readonly>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="subc_nom">SubCategoria </label>
                            <input type="text" class="form-control" id="subc_nom" name="subc_nom" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="subc_nom">Prioridad </label>
                            <input type="text" class="form-control" id="prio_nom" name="prio_nom" readonly>
                        </div>
                    </div>
                </section>
            </section>
        </section>
        <section class="row">
            <div class="col-md-4">
                <label for="tipoAtencion">Usuario</label>
                <input type="text" class="form-control" id="lblnomusuario" name="lblnomusuario" readonly>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="fechaActual">Estado</label>
                    <input type="text" class="form-control" id="lblestado" name="lblestado" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="fechaActual">Fecha Creacion</label>
                    <input type="text" class="form-control" id="lblfechcrea" name="lblfechcrea" readonly>
                </div>
            </div>
        </section>


        </section>
        </section>
        <hr />
        <div id="panel1">
            <!--  Encuesta  -->
            <section class="row">
                <div class="col-md-12 text-center">
                    <input id="tick_estrellas" name="tick_estrellas" class="rating rating-loading" data-min="0" data-max="5" data-step="1" value="0">
                </div>
            </section>


            
            <section class="row">
                <div class="col-md-12">
                    <h3>Comentarios.</h3>
                    <p></p>
                </div>
            </section>
            <section class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="comment">Comentarios:</label>
                        <textarea class="form-control" rows="6" id="tick_coment" name="tick_coment"></textarea>
                    </div>
                </div>
            </section>

            <section class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-info" id="btnguardar">Guardar Encuesta</button>

                    <button type="button" class="btn btn-danger" id="clearForm">Limpiar Formulario</button>
                </div>
            </section>

            <!--  Encuesta  -->
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>
<script src="../../assets/js/lib/bootstrap-sweetalert/sweetalert.min.js"></script>
    <script>
    $('#tick_estrellas').rating({ 
        showCaption: false
    });
    </script>
    <script type="text/javascript" src="encuesta.js"></script>
</body>

</html>
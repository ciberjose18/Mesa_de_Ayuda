<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Recuperar Contraseña</title>

	<link href="../../assets/img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="../../assets/img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="../../assets/img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="../../assets/img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
	<link href="../../assets/img/favicon.png" rel="icon" type="image/png">
	<link href="../../assets/img/favicon.ico" rel="shortcut icon">

    <link rel="stylesheet" href="../../assets/css/separate/pages/login.min.css">
    <link rel="stylesheet" href="../../assets/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="../../assets/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/main.css">

    <link rel="stylesheet" href="../../assets/css/lib/bootstrap-sweetalert/sweetalert.css">
    <link rel="stylesheet" href="../../assets/css/separate/vendor/sweet-alert-animations.min.css">

</head>
<body>
    <div class="page-center">
        <div class="page-center-in">
            <div class="container-fluid">
                <form class="sign-box reset-password-box">
                    <header class="sign-title">Recuperar Contraseña</header>
                    <div class="form-group">
                        <input type="email" id="user_email" name="user_email" class="form-control" placeholder="E-Mail"/>
                    </div>
                    <button type="button" id="btnenviar" class="btn btn-rounded">Enviar</button> o <a href="../../index.php">Regresar</a>
                </form>
            </div>
        </div>
    </div><!--.page-center-->

<script src="../../assets/js/lib/jquery/jquery.min.js"></script>
<script src="../../assets/js/lib/tether/tether.min.js"></script>
<script src="../../assets/js/lib/bootstrap/bootstrap.min.js"></script>
<script src="../../assets/js/plugins.js"></script>
<script type="text/javascript" src="../../assets/js/lib/match-height/jquery.matchHeight.min.js"></script>
<script src="../../assets/js/lib/bootstrap-sweetalert/sweetalert.min.js"></script>
<script>
    $(function() {
        $('.page-center').matchHeight({
            target: $('html')
        });

        $(window).resize(function(){
            setTimeout(function(){
                $('.page-center').matchHeight({ remove: true });
                $('.page-center').matchHeight({
                    target: $('html')
                });
            },100);
        });
    });
</script>
<script src="../../assets/js/app.js"></script>
<script type="text/javascript" src="resetpassword.js"></script>
</body>
</html>
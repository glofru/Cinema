<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600%7CUbuntu:300,400,500,700" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="Smarty/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="Smarty/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="Smarty/css/owl.carousel.min.css">
    <link rel="stylesheet" href="Smarty/css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="Smarty/css/nouislider.min.css">
    <link rel="stylesheet" href="Smarty/css/ionicons.min.css">
    <link rel="stylesheet" href="Smarty/css/plyr.css">
    <link rel="stylesheet" href="Smarty/css/photoswipe.css">
    <link rel="stylesheet" href="Smarty/css/default-skin.css">
    <link rel="stylesheet" href="Smarty/css/main.css">

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="Smarty/icon/favicon-32x32.png" sizes="32x32">
    <link rel="apple-touch-icon" href="Smarty/icon/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="72x72" href="Smarty/icon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="Smarty/icon/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="144x144" href="Smarty/icon/apple-touch-icon-144x144.png">

    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Dmitry Volkov">
    <title>Installazione</title>

</head>
<body class="body" onload="setcookie()">

<div class="sign section--bg" data-bg="Smarty/img/section/section.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sign__content">
                    <!-- authorization form -->
                    <form action="/" onsubmit="return validate()" class="sign__form" method="POST">
                        <!-- Logo -->
                        <a href="/" class="sign__logo">
                            <img src="Smarty/img/logo.svg" alt="">
                        </a>

                        <!-- Nome database -->
                        <div class="sign__group">
                            <input type="text" minlength="1" class="sign__input" placeholder="Nome database" name="dbname">
                        </div>

                        <!-- username -->
                        <div class="sign__group">
                            <input type="text" class="sign__input" placeholder="Username" name="username">
                        </div>

                        <!-- password -->
                        <div class="sign__group">
                            <input type="password" class="sign__input" placeholder="Password" name="password">
                        </div>

                        <!-- populate -->
                        <div class="sign__group sign__group--checkbox">
                            <input id="population" name="population" type="checkbox" checked="checked">
                            <label for="population">Popola con alcuni film</label>
                        </div>

                        <button class="sign__btn" type="submit">Installa</button>

                    </form>
                    <!-- end authorization form -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="Smarty/js/jquery-3.3.1.min.js"></script>
<script src="Smarty/js/bootstrap.bundle.min.js"></script>
<script src="Smarty/js/owl.carousel.min.js"></script>
<script src="Smarty/js/jquery.mousewheel.min.js"></script>
<script src="Smarty/js/jquery.mCustomScrollbar.min.js"></script>
<script src="Smarty/js/wNumb.js"></script>
<script src="Smarty/js/nouislider.min.js"></script>
<script src="Smarty/js/plyr.min.js"></script>
<script src="Smarty/js/jquery.morelines.min.js"></script>
<script src="Smarty/js/photoswipe.min.js"></script>
<script src="Smarty/js/photoswipe-ui-default.min.js"></script>
<script src="Smarty/js/main.js"></script>

<script>
    function setcookie(){
        document.cookie= "js_enabled=true"
    }
</script>
</body>

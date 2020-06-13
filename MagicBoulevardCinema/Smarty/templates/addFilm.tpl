<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600%7CUbuntu:300,400,500,700" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{$path}Smarty/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="{$path}Smarty/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="{$path}Smarty/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{$path}Smarty/css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="{$path}Smarty/css/nouislider.min.css">
    <link rel="stylesheet" href="{$path}Smarty/css/ionicons.min.css">
    <link rel="stylesheet" href="{$path}Smarty/css/plyr.css">
    <link rel="stylesheet" href="{$path}Smarty/css/photoswipe.css">
    <link rel="stylesheet" href="{$path}Smarty/css/default-skin.css">
    <link rel="stylesheet" href="{$path}Smarty/css/main.css">

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="{$path}Smarty/icon/favicon-32x32.png" sizes="32x32">
    <link rel="apple-touch-icon" href="{$path}Smarty/icon/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="72x72" href="{$path}Smarty/icon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="{$path}Smarty/icon/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="144x144" href="{$path}Smarty/icon/apple-touch-icon-144x144.png">

    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Dmitry Volkov">
    <title>Aggiungi un film</title>

    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .custom_upload::-webkit-file-upload-button {
            visibility: hidden;
        }
        .custom_upload::before {
            content: 'Carica copertina';
            display: inline-block;
            background: linear-gradient(top, #f9f9f9, #e3e3e3);
            border: 1px solid #999;
            border-radius: 3px;
            padding: 5px 8px;
            outline: none;
            white-space: nowrap;
            -webkit-user-select: none;
            cursor: pointer;
            text-shadow: 1px 1px #fff;
            font-weight: 700;
            font-size: 10pt;
        }
        .custom_upload:hover::before {
            border-color: black;
        }
        .custom_upload:active::before {
            background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
        }
    </style>
</head>
<body class="body">
<div class="sign section--bg" data-bg="{$path}Smarty/img/section/section.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sign__content">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="{$path}Smarty/js/jquery-3.3.1.min.js"></script>
<script src="{$path}Smarty/js/bootstrap.bundle.min.js"></script>
<script src="{$path}Smarty/js/owl.carousel.min.js"></script>
<script src="{$path}Smarty/js/jquery.mousewheel.min.js"></script>
<script src="{$path}Smarty/js/jquery.mCustomScrollbar.min.js"></script>
<script src="{$path}Smarty/js/wNumb.js"></script>
<script src="{$path}Smarty/js/nouislider.min.js"></script>
<script src="{$path}Smarty/js/plyr.min.js"></script>
<script src="{$path}Smarty/js/jquery.morelines.min.js"></script>
<script src="{$path}Smarty/js/photoswipe.min.js"></script>
<script src="{$path}Smarty/js/photoswipe-ui-default.min.js"></script>
<script src="{$path}Smarty/js/main.js"></script>



</body>
</html>
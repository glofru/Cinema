<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600%7CUbuntu:300,400,500,700" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../../Smarty/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="../../Smarty/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="../../Smarty/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../../Smarty/css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="../../Smarty/css/nouislider.min.css">
    <link rel="stylesheet" href="../../Smarty/css/ionicons.min.css">
    <link rel="stylesheet" href="../../Smarty/css/plyr.css">
    <link rel="stylesheet" href="../../Smarty/css/photoswipe.css">
    <link rel="stylesheet" href="../../Smarty/css/default-skin.css">
    <link rel="stylesheet" href="../../Smarty/css/main.css">

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="../../Smarty/icon/favicon-32x32.png" sizes="32x32">
    <link rel="apple-touch-icon" href="../../Smarty/icon/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../../Smarty/icon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../../Smarty/icon/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../../Smarty/icon/apple-touch-icon-144x144.png">

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
    </style>
</head>
<body class="body">
<div class="sign section--bg" data-bg="../../Smarty/img/section/section.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sign__content">
                    <!-- authorization form -->
                    <form action="/Admin/addProiezione" onsubmit="return validate()" method="POST" class="sign__form" enctype="multipart/form-data">

                        <!-- Film -->
                        <div class="sign__group">
                            <input id="filmChosen" list="films" class="sign__input" placeholder="Film">

                            <datalist id="films">
                                {foreach $films as $film}
                                    <option id="{$film->getId()}" value="{$film->getNome()}"></option>
                                {/foreach}
                            </datalist>

                            <input id="film" type="hidden" name="film" value="">
                        </div>

                        <!-- Film -->
                        <div class="sign__group">
                            <input id="roomChosen" list="rooms" type="number" class="sign__input" placeholder="Sala">

                            <datalist id="rooms">
                                {foreach $sale as $sala}
                                    <option id="{$sala->getNumeroSala()}" value="{$sala->getNumeroSala()}"></option>
                                {/foreach}
                            </datalist>

                            <input id="room" type="hidden" name="room" value="">
                        </div>

                        <!-- DataInizio -->
                        <div class="sign__group">
                            <input id="dataInizio" type="date" class="sign__input" placeholder="Data inizio: GG/MM/AAAA" name="dataInizio">
                        </div>

                        <!-- DataInizio -->
                        <div class="sign__group">
                            <input id="dataFine" type="date" class="sign__input" placeholder="Data fine: GG/MM/AAAA" name="dataFine">
                        </div>

                        <button id="submit" class="sign__btn" type="submit">Aggiungi proiezione</button>
                    </form>
                    <!-- end authorization form -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="../../Smarty/js/jquery-3.3.1.min.js"></script>
<script src="../../Smarty/js/bootstrap.bundle.min.js"></script>
<script src="../../Smarty/js/owl.carousel.min.js"></script>
<script src="../../Smarty/js/jquery.mousewheel.min.js"></script>
<script src="../../Smarty/js/jquery.mCustomScrollbar.min.js"></script>
<script src="../../Smarty/js/wNumb.js"></script>
<script src="../../Smarty/js/nouislider.min.js"></script>
<script src="../../Smarty/js/plyr.min.js"></script>
<script src="../../Smarty/js/jquery.morelines.min.js"></script>
<script src="../../Smarty/js/photoswipe.min.js"></script>
<script src="../../Smarty/js/photoswipe-ui-default.min.js"></script>
<script src="../../Smarty/js/main.js"></script>

<script>
    function validate() {
        if ($("#filmChosen").val() === "" ||
            $("#roomChosen").val() === "" ||
            $("#dataInizio").val() === "" ||
            $("#dataFine").val() === "") {
            alert("Compila tutti i campi");
            return false;
        }

        return true;
    }
</script>

</body>
</html>
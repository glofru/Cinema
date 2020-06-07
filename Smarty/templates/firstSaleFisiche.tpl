<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600%7CUbuntu:300,400,500,700" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{$path}../../Smarty/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="{$path}../../Smarty/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="{$path}../../Smarty/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{$path}../../Smarty/css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="{$path}../../Smarty/css/nouislider.min.css">
    <link rel="stylesheet" href="{$path}../../Smarty/css/ionicons.min.css">
    <link rel="stylesheet" href="{$path}../../Smarty/css/plyr.css">
    <link rel="stylesheet" href="{$path}../../Smarty/css/photoswipe.css">
    <link rel="stylesheet" href="{$path}../../Smarty/css/default-skin.css">
    <link rel="stylesheet" href="{$path}../../Smarty/css/main.css">

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="{$path}../../Smarty/icon/favicon-32x32.png" sizes="32x32">
    <link rel="apple-touch-icon" href="{$path}../../Smarty/icon/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="72x72" href="{$path}../../Smarty/icon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="{$path}../../Smarty/icon/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="144x144" href="{$path}../../Smarty/icon/apple-touch-icon-144x144.png">

    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Dmitry Volkov">
    <title>Registrati</title>

</head>

<body class="body">

<div class="sign section--bg" data-bg="../../Smarty/img/section/section.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sign__content">
                    <!-- registration form -->
                    <form id="form" action="/" onsubmit="return validate()" method="POST" class="sign__form">
                        <a href="/" class="sign__logo">
                            <img src="../../Smarty/img/logo.svg" alt="">
                        </a>
                        <div class="col-12">
                            <h2 class="section__title section__title--center">Crea le sale del cinema</h2>
                        </div>
                        <div id="content">
                        <div class="col-12">
                            <h2 class="section__title section__title--center">Sala</h2>
                        </div>
                        <!-- Nome -->
                        <div class="sign__group">
                            <input id="numeroSala" type="number" min="1" name="numeroSala" class="sign__input" placeholder="Numero Sala">
                        </div>

                        <!-- Cognome -->
                        <div class="sign__group">
                            <input id="file" type="number" name="file" min="1" class="sign__input" placeholder="Numero di file">
                        </div>

                        <!-- Username -->
                        <div class="sign__group">
                            <input id="postiPerFila" type="number" name="postiPerFila" min="1" class="sign__input" placeholder="Numero di posti per fila">
                        </div>

                        <div class="sign__group sign__group--checkbox">
                            <input id="disponibile" name="disponibile" type="checkbox" checked="checked">
                            <label for="remember">Sala disponibile</label>
                        </div>
                            <button class="sign__btn" type="button" onclick="removeRow(this)">Rimuovi</button>
                        </div>
                        <div>
                            <div class="col-12">
                                <h2 class="section__title section__title--center">Sala</h2>
                            </div>
                            <!-- Nome -->
                            <div class="sign__group">
                                <input id="numeroSala" type="number" min="1" name="numeroSala" class="sign__input" placeholder="Numero Sala">
                            </div>

                            <!-- Cognome -->
                            <div class="sign__group">
                                <input id="file" type="number" name="file" min="1" class="sign__input" placeholder="Numero di file">
                            </div>

                            <!-- Username -->
                            <div class="sign__group">
                                <input id="postiPerFila" type="number" name="postiPerFila" min="1" class="sign__input" placeholder="Numero di posti per fila">
                            </div>

                            <div class="sign__group sign__group--checkbox">
                                <input id="disponibile" name="disponibile" type="checkbox" checked="checked">
                                <label for="remember">Sala disponibile</label>
                            </div>
                            <button class="sign__btn" type="button" onclick="removeRow(this)">Rimuovi</button>
                        </div>
                        <div>
                            <div class="col-12">
                                <h2 class="section__title section__title--center">Sala</h2>
                            </div>
                            <!-- Nome -->
                            <div class="sign__group">
                                <input id="numeroSala" type="number" min="1" name="numeroSala" class="sign__input" placeholder="Numero Sala">
                            </div>

                            <!-- Cognome -->
                            <div class="sign__group">
                                <input id="file" type="number" name="file" min="1" class="sign__input" placeholder="Numero di file">
                            </div>

                            <!-- Username -->
                            <div class="sign__group">
                                <input id="postiPerFila" type="number" name="postiPerFila" min="1" class="sign__input" placeholder="Numero di posti per fila">
                            </div>

                            <div class="sign__group sign__group--checkbox">
                                <input id="disponibile" name="disponibile" type="checkbox" checked="checked">
                                <label for="remember">Sala disponibile</label>
                            </div>
                            <button class="sign__btn" type="button" onclick="removeRow(this)">Rimuovi</button>
                        </div>
                        <div id="content"></div>
                        <button class="sign__btn" type="button">Aggiungi sala</button>
                        <button class="sign__btn" type="submit">Conferma</button>
                    </form>
                    <!-- registration form -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="{$path}../../Smarty/js/jquery-3.3.1.min.js"></script>
<script src="{$path}../../Smarty/js/bootstrap.bundle.min.js"></script>
<script src="{$path}../../Smarty/js/owl.carousel.min.js"></script>
<script src="{$path}../../Smarty/js/jquery.mousewheel.min.js"></script>
<script src="{$path}../../Smarty/js/jquery.mCustomScrollbar.min.js"></script>
<script src="{$path}../../Smarty/js/wNumb.js"></script>
<script src="{$path}../../Smarty/js/nouislider.min.js"></script>
<script src="{$path}../../Smarty/js/plyr.min.js"></script>
<script src="{$path}../../Smarty/js/jquery.morelines.min.js"></script>
<script src="{$path}../../Smarty/js/photoswipe.min.js"></script>
<script src="{$path}../../Smarty/js/photoswipe-ui-default.min.js"></script>
<script src="{$path}../../Smarty/js/main.js"></script>

<script>

    function isValid(name) {
        return name > 0;
    }

    function validate() {
        if (isValid($("#numeroSala").val())) {
            if (isValid($("#file").val())) {
                if (isValid($("#postiPerFila").val())) {
                } else {
                    alert("Sala non valida!");
                }
            } else {
                alert("numero di file non valido");
            }
        } else {
            alert("numero di posti per file non valido");
        }

        return false;
    }
</script>
<script>
    //STACKOVERFLOW <3
    let a = 0;
    function addRow () {
        a += 1;
        document.querySelector('#content').insertAdjacentHTML(
            'afterbegin',
            `<div>
                        <div class="col-12">
                            <h2 class="section__title section__title--center">Sala</h2>
                        </div>
            <div class="sign__group">
            <input id="numeroSala" type="number" min="1" name="numeroSala" class="sign__input" placeholder="Numero Sala">
            </div>
            <div class="sign__group">
            <input id="file" type="number" name="file" min="1" class="sign__input" placeholder="Numero di file">
            </div>

            <div class="sign__group">
            <input id="postiPerFila" type="number" name="postiPerFila" min="1" class="sign__input" placeholder="Numero di posti per fila">
            </div>

            <div class="sign__group sign__group--checkbox">
            <input id="disponibile" name="disponibile" type="checkbox" checked="checked">
            <label for="remember">Sala disponibile</label>
            </div>
            <button class="sign__btn" type="button" onclick="removeRow(this)">Rimuovi</button>
            </div>`
        )
    }

    function removeRow (input) {
        input.parentNode.remove()
    }
</script>

</body>

</html>
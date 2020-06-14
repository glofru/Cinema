<!DOCTYPE html>
<html lang="it">

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
    <title>Registrati</title>

</head>

<body class="body">

<div class="sign section--bg" data-bg="{$path}Smarty/img/section/section.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sign__content">
                    <!-- registration form -->
                    <form id="form" action="{$path}Utente/signup" onsubmit="return validate()" method="POST" class="sign__form" enctype="multipart/form-data">
                        <a href="/MagicBoulevardCinema" class="sign__logo">
                            <img src="{$path}Smarty/img/logo.svg" alt="">
                        </a>
                        <div class="sign__group">
                            <button id="insert_image" class="sign__btn" type="button" style="width: 200px" onclick="document.getElementById('choose_image').click()">Immagine del profilo</button>
                            <input id="choose_image" type="file" name="propic" onchange="validateImage()" style="display: none" accept=".jpg, .jpeg, .gif, .png">
                            <br>
                            <b><p id="image_name" class="faq__text" style="text-align: center; max-width: 300px">Nessuna immagine caricata (MAX 2MB)</p></b>
                        </div>
                        <!-- Nome -->
                        <div class="sign__group">
                            <input id="nome" type="text" name="nome" value="{$nome}" class="sign__input" placeholder="Nome">
                        </div>

                        <!-- Cognome -->
                        <div class="sign__group">
                            <input id="cognome" type="text" name="cognome" value="{$cognome}" class="sign__input" placeholder="Cognome">
                        </div>

                        <!-- Username -->
                        <div class="sign__group">
                            <input id="username" type="text" name="username" value="{$username}" class="sign__input" placeholder="Username">
                        </div>

                        {if isset($emailExists) && !$emailExists}
                        <div class="sign__group">
                            <span class="sign__text" style="color: red">Username già utilizzato</span>
                        </div>
                        {/if}

                        <!-- Email -->
                        <div class="sign__group">
                            <input id="email" type="email" name="email" value="{$email}" class="sign__input" placeholder="Email">
                        </div>

                        {if isset($emailExists) && $emailExists}
                            <div class="sign__group">
                                <span class="sign__text" style="color: red">Email già registrata</span>
                            </div>
                        {/if}

                        <!-- Password -->
                        <div class="sign__group">
                            <input id="pw1" type="password" name="password" class="sign__input" placeholder="Password">
                        </div>

                        <!-- Reinserisci password -->
                        <div class="sign__group">
                            <input id="pw2" type="password" class="sign__input" placeholder="Reinserisci la password">
                        </div>

                        <!-- News Letter --->
                        <div class="sign__group sign__group--checkbox">
                            <input id="newsletter" name="newsletter" type="checkbox" onchange="changing(this.checked)">
                            <label for="newsletter">Iscrivimi alla newsletter</label>
                        </div>
                        <div id="content"></div>
                        <button class="sign__btn">Registrati</button>

                        <span class="sign__text">Hai già un account? <a href="{$path}Utente/login">Login!</a></span>
                    </form>
                    <!-- registration form -->
                </div>
            </div>
        </div>
    </div>
</div>
<noscript>
    <meta http-equiv="refresh" content="0;url=/MagicBoulevardCinema/noJS.html">
</noscript>
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

<script>

    function changing(me){
        if(me === true){
            document.querySelector('#content').insertAdjacentHTML(
                'beforebegin',
                `<br/>
                 <div class="container" id="checklist">
                    <div class="row">
                    <h2 class="faq__text" style="margin: auto">Scegli i tuoi generi preferiti</h2>
                         <div class="col-lg-12">
                          {foreach $genere as $item}
                         <div class="sign__group sign__group--checkbox">
                            <input id="{$item}" name="{$item}" type="checkbox">
                            <label for="{$item}">{$item}</label>
                        </div>
                         {/foreach}
                            </div>
                         </div>
                    </div>
                 </div>`
            )
        } else {
            document.getElementById("checklist").remove();
        }
    }



    $(document).ready(function() {
        // Aggiorna nome copertina
        $('#choose_image').change(function (e) {
            document.getElementById("image_name").innerText = e.target.files[0].name;
        });
    })


    {if isset($error)}
    alert("{$error}");
    {/if}

    function nameIsValid(name) {
        let exp = /^([a-zA-Z '-]*)$/;

        return name.match(exp) != null;
    }

    function usernameIsValid(username) {
        let exp = /^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/;

        return username.match(exp) != null;
    }

    function emailIsValid(email) {
        let exp = /^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/;

        return email.match(exp) != null;
    }

    function passwordIsValid(password) {
        return password.length > 6;
    }

    function checkPwd(pw1, pw2) {
        return pw1 === pw2;
    }

    function validate() {
        if (nameIsValid($("#nome").val())) {
            if (nameIsValid($("#cognome").val())) {
                if (usernameIsValid($("#username").val())) {
                    if (emailIsValid($("#email").val())) {
                        if (passwordIsValid($("#pw1").val())) {
                            if (checkPwd($("#pw1").val(), $("#pw2").val())) {
                                return true;
                            } else {
                                alert("Le password non combaciano!");
                            }
                        } else {
                            alert("La password deve avere almeno 6 caratteri")
                        }
                    } else {
                        alert("Email non valida")
                    }
                } else {
                    alert("Username non valido!");
                }
            } else {
                alert("Cognome non valido");
            }
        } else {
            alert("Nome non valido");
        }

        return false;
    }

    function validateImage() {
        var formData = new FormData();

        var file = document.getElementById("choose_image").files[0];

        formData.append("Filedata", file);
        var t = file.type.split('/').pop().toLowerCase();
        if (t != "jpeg" && t != "jpg" && t != "png" && t != "gif") {
            alert('Inserire un file di immagine valido!');
            document.getElementById("choose_image").value = '';
            return false;
        }
        if (file.size > 2048000) {
            alert('Non puoi caricare file più grandi di 2 MB');
            document.getElementById("choose_image").value = '';
            return false;
        }
        return true;
    }
</script>

</body>

</html>
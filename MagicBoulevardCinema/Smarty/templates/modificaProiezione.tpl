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
    <title>Magic Boulevard Cinema - Dove i sogni diventano realtà</title>

</head>
<body class="body" {if (isset($error))}onload="alert('{$error}')"{/if}>

{include file="{$path}Smarty/templates/header.tpl"}

<!-- content -->
<section class="content">
    <div class="content__head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- content title -->
                    <h2 class="content__title">Discover</h2>
                    <!-- end content title -->

                    <!-- content tabs nav -->
                    <ul class="nav nav-tabs content__tabs" id="content__tabs" role="tablist" style="margin-top: 50px">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Modifica proiezione</a>
                        </li>
                    </ul>
                    <!-- end content tabs nav -->

                    <!-- content mobile tabs nav -->
                    <div class="content__mobile-tabs" id="content__mobile-tabs">
                        <div class="content__mobile-tabs-btn dropdown-toggle" role="navigation" id="mobile-tabs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <input type="button" value="Modifica proiezione">
                            <span></span>
                        </div>

                        <div class="content__mobile-tabs-menu dropdown-menu" aria-labelledby="mobile-tabs">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="1-tab" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Modifica proiezione</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- end content mobile tabs nav -->
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 col-xl-8" style="margin: auto">
                <!-- content tabs -->
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="1-tab">
                        <div class="row">
                            <form id="form" onsubmit="return validate()" action="{$path}/Admin/modificaProiezione" method="POST" class="form" enctype="multipart/form-data" style="margin: auto">

                                <!-- Proiezione -->
                                <input type="hidden" name="proiezione" value="{$proiezione->getId()}">

                                <!-- Film -->
                                <h3 style="color: white">Film [NON MODIFICABILE]</h3>
                                <div class="sign__group">
                                    <input class="sign__input" value="{$proiezione->getFilm()->getNome()} - {$proiezione->getFilm()->getAnno()}" disabled="disabled">
                                </div>

                                <!-- Sala -->
                                <h3 style="color: white">Sala {if !$cambioSala}[NON MODIFICABILE<br> - ALMENO UN BIGLIETTO PRESENTE]{/if}</h3>
                                <div class="sign__group">
                                    {if $cambioSala}
                                        <input id="roomChosen" list="rooms" type="number" class="sign__input" value="{$proiezione->getSala()->getNumeroSala()}" name="sala" placeholder="Sala">

                                        <datalist id="rooms">
                                            {foreach $sale as $s}
                                                <option value="{$s->getNumeroSala()}"></option>
                                            {/foreach}
                                        </datalist>
                                    {else}
                                        <input type="number" class="sign__input" value="{$proiezione->getSala()->getNumeroSala()}" disabled="disabled">
                                    {/if}
                                </div>

                                <!-- Orario -->
                                <h3 style="color: white">Orario</h3>
                                <div class="sign__group">
                                    <input id="orario" type="time" class="sign__input" placeholder="Orario: HH:mm" value="{$proiezione->getDataProiezione()->format("H:i")}" name="orario">
                                </div>

                                <!-- Data -->
                                <h3 style="color: white">Data [NON MODIFICABILE]</h3>
                                <div class="sign__group">
                                    <input type="date" class="sign__input" value="{$proiezione->getDataProiezione()->format("Y-m-d")}" disabled="disabled">
                                </div>

                                <button id="submit" class="sign__btn" type="submit">Modifica</button>
                                <button onclick="erase()" class="sign__btn" type="button">Cancella</button>
                                <button onclick="window.location.href = '/Admin/modificaProgrammazione?film={$proiezione->getFilm()->getId()}'" class="sign__btn" type="button">Annulla</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end content tabs -->
    </div>
</section>
<!-- end content -->

{include file="{$path}Smarty/templates/footer.tpl"}

<!-- Root element of PhotoSwipe. Must have class pswp. -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

    <!-- Background of PhotoSwipe.
    It's a separate element, as animating opacity is faster than rgba(). -->
    <div class="pswp__bg"></div>

    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">

        <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
        <!-- don't modify these 3 pswp__item elements, data is added later on. -->
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>

        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">

            <div class="pswp__top-bar">

                <!--  Controls are self-explanatory. Order can be changed. -->

                <div class="pswp__counter"></div>

                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                <!-- Preloader -->
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>

            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>

            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>

            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>

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
    function erase() {
        let choice = confirm("Sei sicuro di voler cancellare la proiezione?");

        if (choice) {
            $("<input>").attr({
                id: 'erase',
                type: 'hidden',
                name: 'erase',
                value: 'true'
            }).appendTo($("#form"));
            document.getElementById("form").submit.click();
        }
    }

    function validate() {
        if (document.getElementById("erase") === null) {
            {if $cambioSala}
            let valSala = $("#roomChosen").val();
            {/if}

            if ({if $cambioSala}valSala === "" ||{/if} $("#orario").val() === "") {
                alert("Inserisci sala e orario");
                return false;
            }
        }

        return true;
    }
</script>

</body>

</html>
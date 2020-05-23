<?php
/* Smarty version 3.1.36, created on 2020-05-23 22:19:59
  from '/opt/lampp/htdocs/Smarty/templates/error.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_5ec9856f847680_16373868',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2670af8866c797bce77843ed81f4b8451b7924ac' => 
    array (
      0 => '/opt/lampp/htdocs/Smarty/templates/error.tpl',
      1 => 1590265197,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ec9856f847680_16373868 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
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
    <title>Errore — Conttatare l'amministratore</title>

</head>
<body class="body">

<!-- page 404 -->
<div class="page-404 section--bg" data-bg="img/section/section.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-404__wrap">
                    <div class="page-404__content">
                        <h1 class="page-404__title">Errore <?php echo $_smarty_tpl->tpl_vars['error_number']->value;?>
</h1>
                        <p class="page-404__text"><?php echo $_smarty_tpl->tpl_vars['error_description']->value;?>
</p>
                        <a href="/" class="page-404__btn">Torna indietro</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end page 404 -->

<!-- JS -->
<?php echo '<script'; ?>
 src="Smarty/js/jquery-3.3.1.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="Smarty/js/bootstrap.bundle.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="Smarty/js/owl.carousel.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="Smarty/js/jquery.mousewheel.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="Smarty/js/jquery.mCustomScrollbar.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="Smarty/js/wNumb.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="Smarty/js/nouislider.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="Smarty/js/plyr.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="Smarty/js/jquery.morelines.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="Smarty/js/photoswipe.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="Smarty/js/photoswipe-ui-default.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="Smarty/js/main.js"><?php echo '</script'; ?>
>
</body>

</html>
<?php }
}

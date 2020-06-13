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
<body class="body">

	<div class="sign section--bg" data-bg="{$path}../../Smarty/img/section/section.jpg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="sign__content">
						<!-- authorization form -->
						<form action="{$path}/MagicBoulevardCinema/Utente/login" method="POST" class="sign__form">
							<a href="/" class="sign__logo">
								<img src="{$path}../../Smarty/img/logo.svg" alt="">
							</a>

							<div class="sign__group">
								<input name="username" type="text" value="{$username}" class="sign__input" placeholder="Username/Email">
							</div>

							{if $error}
								<div class="sign__group">
									<span class="sign__text" style="color: red">Username o password errate</span>
								</div>
							{/if}

							<div class="sign__group">
								<input name="password" type="password" class="sign__input" placeholder="Password">
							</div>

							<div class="sign__group sign__group--checkbox">
								<input id="remember" name="remember" type="checkbox" {if isset($checked)} checked="checked" {else} {/if}>
								<label for="remember">Ricordami</label>
							</div>
							
							<button class="sign__btn" type="submit">Accedi</button>

							<span class="sign__text"><a href="{$path}/MagicBoulevardCinema/Utente/forgotPassword">Password dimenticata?</a></span>

							<span class="sign__text">Non hai un account? <a href="{$path}/MagicBoulevardCinema/Utente/signup">Registrati!</a></span>
						</form>
						<!-- end authorization form -->
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
</body>

</html>
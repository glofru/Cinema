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
	<title>Magic Boulevard Cinema - Dove i sogni diventano realtà</title>

</head>
<body class="body">

<!-- header -->
<header class="header">
	<div class="header__wrap">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="header__content">
						<!-- header logo -->
						<a href="/" class="header__logo">
							<img src="../../Smarty/img/logo.svg" alt="">
						</a>
						<!-- end header logo -->

						<!-- header nav -->
						<ul class="header__nav">
							<!-- dropdown -->
							<li class="header__nav-item">
								<a class="dropdown-toggle header__nav-link" href="/" role="button" id="dropdownMenuHome" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Home</a>
							</li>
							<!-- end dropdown -->

							<!-- dropdown -->
							<li class="header__nav-item">
								<a class="dropdown-toggle header__nav-link" href="#" role="button" id="dropdownMenuCatalog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cinema</a>

								<ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuCatalog">
									<li><a href="catalog1.html">Prossime Uscite</a></li>
									<li><a href="catalog2.html">Programmazione</a></li>
									<li><a href="details1.html">Film più apprezzati</a></li>
								</ul>
							</li>
							<!-- end dropdown -->

							<li class="header__nav-item">
								<a href="../../Informazioni/getCosti/" class="header__nav-link">Prezzi</a>
							</li>

							<li class="header__nav-item">
								<a href="faq.html" class="header__nav-link">Aiuto</a>
							</li>

							<!-- dropdown -->
							<li class="dropdown header__nav-item">
								<a class="dropdown-toggle header__nav-link header__nav-link--more" href="#" role="button" id="dropdownMenuMore" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon ion-ios-more"></i></a>
								{if (!isset($utente))}
									<ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuMore">
										<li><a href="../../Informazioni/getAbout/">Su di noi</a></li>
										<li><a href="/Utente/signup">Registrati</a></li>
									</ul>
								{else}
									<ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuMore">
										<li><a href="../../Informazioni/getAbout/">Su di noi</a></li>
									</ul>
								{/if}
							</li>
							<!-- end dropdown -->
						</ul>
						<!-- end header nav -->

						<!-- header auth -->
						<div class="header__auth">
							<button class="header__search-btn" type="button">
								<i class="icon ion-ios-search"></i>
							</button>
								<li class="header__nav-item">
									<a class="header__sign-in" href="#" role="button" id="dropdownMenuCatalog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span>@{$utente->getUsername()}</span>
									</a>
									<ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuCatalog">
										<li><a href="/Utente/showUtente/?idShow={$utente->getId()}">Il mio profilo</a></li>
										<li><a href="/Utente/bigliettiAcquistati">I miei acquisti</a></li>
										<li><a href="https://www.youporn.com/watch/15481840/il-sole-sul-balcone-amatoriale-italianovery-myller/#1">I miei video porno</a></li>
										<li><a href="/Utente/logout">Logout <i class="icon ion-ios-log-out"></i></a></li>
									</ul>
								</li>
						</div>
						<!-- end header auth -->

						<!-- header menu btn -->
						<button class="header__btn" type="button">
							<span></span>
							<span></span>
							<span></span>
						</button>
						<!-- end header menu btn -->
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- header search -->
	<form action="/Ricerca/cercaFilm" method= "POST" class="header__search">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="header__search-content">
						<input type="text" name="filmCercato" placeholder="Cerca un film">

						<button type="submit">Cerca</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<!-- end header search -->
</header>
<!-- end header -->

	<!-- page title -->
	<section class="section section--first section--bg" data-bg="../../Smarty/img/section/section.jpg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section__wrap">
						<!-- section title -->
						<h2 class="section__title">Biglietti acquistati</h2>
						<!-- end section title -->

						<!-- breadcrumb-->
						<ul class="breadcrumb">
							<li class="breadcrumb__item"><a href="/">Home</a></li>
							<li class="breadcrumb"><a href="">I miei acquisti</a></li>
						</ul>
						<!-- end breadcrumb -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end page title -->
<!-- filter -->
<div class="filter">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="filter__content">
					<div class="filter__items">
						<!-- filter item -->
						<div class="card__description">
							<p>Qui puoi osservare tutti i biglietti che hai acquistato presso il nostro cinema :)</p>
						</div>
						<!-- end filter item -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end filter -->
	<!-- catalog -->
<form></form>
	<div class="catalog">
		<div class="container">
			<div class="row">
				{if (sizeof($biglietti) > 0)}
				{foreach $biglietti as $key => $item}
				<!-- card -->
				<div class="col-6 col-sm-12 col-lg-6">
					<div class="card card--list">
						<div class="row">
							<div class="col-12 col-sm-4">
								<div class="card__cover">
									<img src="{$locandine[$key]->getImmagineHTML()}" alt="">
								</div>
							</div>

							<div class="col-12 col-sm-8">
								<div class="card__content">
									<h3 class="card__title"><a href="#">{$item->getProiezione()->getFilm()->getNome()}</a></h3>
									<span class="card__category">
										<a style="font-size:20px;">{$item->getPosto()}</a>
									</span>

									<div class="card__wrap">
										{if ($item->getProiezione()->getFilm()->getetaConsigliata() != "")}
											<ul class="card__list">
												<li>{$item->getProiezione()->getFilm()->getetaConsigliata()}</li>
											</ul>
										{/if}
									</div>

									<div class="card__description">
										<p>Giorno {$item->getProiezione()->getData()} <br> Spettacolo delle {$item->getProiezione()->getOra()} <br> Sala {$item->getProiezione()->getSala()->getNumeroSala()} <br> Prezzo: {$item->getCosto()}€</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- end card -->
				{/foreach}
				{else}
					<div class="col-12">
						<h2 class="section__title section__title--center">Non hai ancora effettuato alcun acquisto... :(</h2>
					</div>
				{/if}
			</div>

		</div>
	</div>
	<!-- end catalog -->

	<!-- footer -->
	<footer class="footer">
		<div class="container">
			<div class="row">
				<!-- footer list -->
				<div class="col-12 col-md-3">
					<h6 class="footer__title">Download Our App</h6>
					<ul class="footer__app">
						<li><a href="#"><img src="../../Smarty/img/Download_on_the_App_Store_Badge.svg" alt=""></a></li>
						<li><a href="#"><img src="../../Smarty/img/google-play-badge.png" alt=""></a></li>
					</ul>
				</div>
				<!-- end footer list -->

				<!-- footer list -->
				<div class="col-6 col-sm-4 col-md-3">
					<h6 class="footer__title">Resources</h6>
					<ul class="footer__list">
						<li><a href="#">About Us</a></li>
						<li><a href="#">Pricing Plan</a></li>
						<li><a href="#">Help</a></li>
					</ul>
				</div>
				<!-- end footer list -->

				<!-- footer list -->
				<div class="col-6 col-sm-4 col-md-3">
					<h6 class="footer__title">Legal</h6>
					<ul class="footer__list">
						<li><a href="#">Terms of Use</a></li>
						<li><a href="#">Privacy Policy</a></li>
						<li><a href="#">Security</a></li>
					</ul>
				</div>
				<!-- end footer list -->

				<!-- footer list -->
				<div class="col-12 col-sm-4 col-md-3">
					<h6 class="footer__title">Contact</h6>
					<ul class="footer__list">
						<li><a href="tel:+18002345678">+1 (800) 234-5678</a></li>
						<li><a href="mailto:support@moviego.com">support@flixgo.com</a></li>
					</ul>
					<ul class="footer__social">
						<li class="facebook"><a href="#"><i class="icon ion-logo-facebook"></i></a></li>
						<li class="instagram"><a href="#"><i class="icon ion-logo-instagram"></i></a></li>
						<li class="twitter"><a href="#"><i class="icon ion-logo-twitter"></i></a></li>
						<li class="vk"><a href="#"><i class="icon ion-logo-vk"></i></a></li>
					</ul>
				</div>
				<!-- end footer list -->

				<!-- footer copyright -->
				<div class="col-12">
					<div class="footer__copyright">
						<small><a target="_blank" href="https://www.templateshub.net">Templates Hub</a></small>

						<ul>
							<li><a href="#">Terms of Use</a></li>
							<li><a href="#">Privacy Policy</a></li>
						</ul>
					</div>
				</div>
				<!-- end footer copyright -->
			</div>
		</div>
	</footer>
	<!-- end footer -->

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
</body>

</html>
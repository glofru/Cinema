<!DOCTYPE html>
<html lang="it">

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
						<a href="../../index.php" class="header__logo">
							<img src="../../Smarty/img/logo.svg" alt="">
						</a>
						<!-- end header logo -->

						<!-- header nav -->
						<ul class="header__nav">
							<!-- dropdown -->
							<li class="header__nav-item">
								<a class="dropdown-toggle header__nav-link" href="../../index.php" role="button" >Home</a>


							</li>
							<!-- end dropdown -->

							<!-- dropdown -->
							<li class="header__nav-item">
								<a class="dropdown-toggle header__nav-link" href="#" role="button" id="dropdownMenuCatalog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Catalogo</a>

								<ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuCatalog">
									<li><a href="../../Catalogo/prossimeUscite/">Prossime uscite</a></li>
									<li><a href="../../Catalogo/programmazioniPassate/">Programmazioni</a></li>
									<li><a href="../../Catalogo/piuApprezzati/">Film più apprezzati</a></li>
								</ul>
							</li>
							<!-- end dropdown -->

							<li class="header__nav-item">
								<a href="pricing.html" class="header__nav-link">Prezzi</a>
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
										<li><a href="../../Utente/signup">Registrati</a></li>
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

							{if (!isset($utente))}
								<a href="../../Utente/login" methods="GET" class="header__sign-in">
									<i class="icon ion-ios-log-in"></i>
									<span>Login</span>
								</a>
							{elseif (isset($utente) && !$admin)}
								<li class="header__nav-item">
									<a class="header__sign-in" href="#" role="button" id="dropdownMenuCatalog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span>@{$utente->getUsername()}</span>
									</a>
									<ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuCatalog">
										<li><a href="../../Utente/showUtente/?idShow={$utente->getId()}">Il mio profilo</a></li>
										<li><a href="../../Utente/bigliettiAcquistati">I miei acquisti</a></li>
										<li><a href="https://www.youporn.com/watch/15481840/il-sole-sul-balcone-amatoriale-italianovery-myller/#1">I miei video porno</a></li>
										<li><a href="../../Utente/logout">Logout <i class="icon ion-ios-log-out"></i></a></li>
									</ul>
								</li>
							{elseif (isset($utente) && $admin)}
								<li class="header__nav-item">
									<a class="header__sign-in" href="#" role="button" id="dropdownMenuCatalog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span>@{$utente->getUsername()}</span>
									</a>
									<ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuCatalog">
										<li><a href="../../Utente/showUtente/?idShow={$utente->getId()}">Il mio profilo</a></li>
										<li><a href="">Gestione film</a></li>
										<li><a href="">Gestione Proiezioni</a></li>
										<li><a href="../../Admin/gestioneUtenti/?">Gestione Utenti</a></li>
										<li><a href="../../Utente/logout">Logout <i class="icon ion-ios-log-out"></i></a></li>
									</ul>
								</li>
							{/if}
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
						<h2 class="section__title">Prezzi</h2>
						<!-- end section title -->

						<!-- breadcrumb -->
						<ul class="breadcrumb">
							<li class="breadcrumb__item"><a href="/">Home</a></li>
							<li class="breadcrumb__item breadcrumb__item--active">Costi</li>
						</ul>
						<!-- end breadcrumb -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end page title -->

	<!-- pricing -->
	<div class="section">
		<div class="container">
			<div class="row">
				<!-- plan features -->
				<div class="col-12">
					<ul class="row plan-features">
						<li class="col-12 col-md-12 col-lg-20">Ai seguenti prezzi va applicato un sovrapprezzo di {$extra}€ se si acquista un biglietto per una proiezione che si terrà almeno 7 giorni dopo il giorno di acquisto!*</li>
					</ul>
				</div>
				<!-- end plan features -->

				<!-- price -->
				<div class="col-12 col-md-6 col-lg-4">
				</div>
				<!-- end price -->

				<!-- price -->
				<div class="col-12 col-md-6 col-lg-4">
					<div class="price price--premium">
						<div class="price__item price__item--first"><span>Costo biglietti</span></div>
						<div class="price__item"><span>Lunedi: {$price["Mon"]}€</span></div>
						<div class="price__item"><span>Martedì: {$price["Tue"]}€</span></div>
						<div class="price__item"><span>Mercoledì: {$price["Wed"]}€</span></div>
						<div class="price__item"><span>Giovedì: {$price["Thu"]}€</span></div>
						<div class="price__item"><span>Venerdì: {$price["Fri"]}€</span></div>
						<div class="price__item"><span>Sabato: {$price["Sat"]}€</span></div>
						<div class="price__item"><span>Domenica: {$price["Sun"]}€</span></div>
					</div>
				</div>
				<!-- end price -->

				<!-- price -->
				<div class="col-12 col-md-6 col-lg-4">
				</div>
				<!-- end price -->
				<div class="col-12">
					<ul class="row plan-features">
						<li class="col-24 col-md-6 col-lg-40">*I biglietti una volta acquistati non saranno rimbosati!</li>
					</ul>
				</div>
				<!-- end plan features -->
			</div>
		</div>
	</div>
	<!-- end pricing -->

	<!-- features -->
	<section class="section section--dark">
		<div class="container">
			<div class="row">
				<!-- section title -->
				<div class="col-12">
					<h2 class="section__title section__title--no-margin">Cosa offriamo</h2>
				</div>
				<!-- end section title -->

				<!-- feature -->
				<div class="col-12 col-md-6 col-lg-4">
					<div class="feature">
						<i class="icon ion-ios-tv feature__icon"></i>
						<h3 class="feature__title">IMAX</h3>
						<p class="feature__text">Le nostre sale sono dotate di schermi <a href="https://it.wikipedia.org/wiki/IMAX" target="_blank">IMAX</a>, di ultima generazione, per garantirti la migliore immersività possibile.</p>
					</div>
				</div>
				<!-- end feature -->

				<!-- feature -->
				<div class="col-12 col-md-6 col-lg-4">
					<div class="feature">
						<i class="icon ion-ios-film feature__icon"></i>
						<h3 class="feature__title">Film</h3>
						<p class="feature__text">Grazie al nostro portale potrai essere informato sugli spettacoli che sono in programmazione e consultare le nostre programmazioni passate... magari per recuperare qualche gran bel film :)</p>
					</div>
				</div>
				<!-- end feature -->

				<!-- feature -->
				<div class="col-12 col-md-6 col-lg-4">
					<div class="feature">
						<i class="icon ion-ios-trophy feature__icon"></i>
						<h3 class="feature__title">Premi</h3>
						<p class="feature__text">Nel 2020 siamo stati eletti il miglior sito di cinema fittizio mai inventato. Il premio ci è stato assegnato da parte di una commissione specializzata di inesperti del settore.</p>
					</div>
				</div>
				<!-- end feature -->

				<!-- feature -->
				<div class="col-12 col-md-6 col-lg-4">
					<div class="feature">
						<i class="icon ion-ios-notifications feature__icon"></i>
						<h3 class="feature__title">Newsletter</h3>
						<p class="feature__text">Per rimanere sempre aggiornato sui nuovi film in programmazione e le prossime uscite puoi iscriverti alla nostra newsletter! Ti aspettiamo ;)</p>
					</div>
				</div>
				<!-- end feature -->

				<!-- feature -->
				<div class="col-12 col-md-6 col-lg-4">
					<div class="feature">
						<i class="icon ion-ios-rocket feature__icon"></i>
						<h3 class="feature__title">Massima efficienza</h3>
						<p class="feature__text">Una volta acquistato il tuo biglietto potrai, in tempo lampo, osservare sulla tua mail la ricevuta dell'acquisto. utile per acquisti last-minute.</p>
					</div>
				</div>
				<!-- end feature -->

				<!-- feature -->
				<div class="col-12 col-md-6 col-lg-4">
					<div class="feature">
						<i class="icon ion-ios-globe feature__icon"></i>
						<h3 class="feature__title">Dove Siamo...</h3>
						<p class="feature__text">Il nostro cinema si trova nella città metropolitana di <a href="https://it.wikipedia.org/wiki/Morterone" target="_blank">Morterone(LC)</a></p>
					</div>
				</div>
				<!-- end feature -->
			</div>
		</div>
	</section>
	<!-- end features -->

	<!-- partners -->
	<section class="section">
		<div class="container">
			<div class="row">
				<!-- section title -->
				<div class="col-12">
					<h2 class="section__title section__title--no-margin">Our Partners</h2>
				</div>
				<!-- end section title -->

				<!-- section text -->
				<div class="col-12">
					<p class="section__text section__text--last-with-margin">It is a long <b>established</b> fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using.</p>
				</div>
				<!-- end section text -->

				<!-- partner -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
					<a href="#" class="partner">
						<img src="../../Smarty/img/partners/themeforest-light-background.png" alt="" class="partner__img">
					</a>
				</div>
				<!-- end partner -->

				<!-- partner -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
					<a href="#" class="partner">
						<img src="../../Smarty/img/partners/audiojungle-light-background.png" alt="" class="partner__img">
					</a>
				</div>
				<!-- end partner -->

				<!-- partner -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
					<a href="#" class="partner">
						<img src="../../Smarty/img/partners/codecanyon-light-background.png" alt="" class="partner__img">
					</a>
				</div>
				<!-- end partner -->

				<!-- partner -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
					<a href="#" class="partner">
						<img src="../../Smarty/img/partners/photodune-light-background.png" alt="" class="partner__img">
					</a>
				</div>
				<!-- end partner -->

				<!-- partner -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
					<a href="#" class="partner">
						<img src="../../Smarty/img/partners/activeden-light-background.png" alt="" class="partner__img">
					</a>
				</div>
				<!-- end partner -->

				<!-- partner -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
					<a href="#" class="partner">
						<img src="../../Smarty/img/partners/3docean-light-background.png" alt="" class="partner__img">
					</a>
				</div>
				<!-- end partner -->
			</div>
		</div>
	</section>
	<!-- end partners -->

<!-- footer -->
<footer class="footer">
	<div class="container">
		<div class="row">
			<!-- footer list -->
			<div class="col-12 col-md-3">
				<h6 class="footer__title">Scarica la nsotra App</h6>
				<ul class="footer__app">
					<li><a href="https://play.google.com/store?hl=it"><img src="../../Smarty/img/Download_on_the_App_Store_Badge.svg" alt=""></a></li>
					<li><a href="https://www.apple.com/it/ios/app-store/"><img src="../../Smarty/img/google-play-badge.png" alt=""></a></li>
				</ul>
			</div>
			<!-- end footer list -->

			<!-- footer list -->
			<div class="col-6 col-sm-4 col-md-3">
				<h6 class="footer__title">Informazioni</h6>
				<ul class="footer__list">
					<li><a href="../../Informazioni/getAbout/">Su di noi</a></li>
					<li><a href="#">Costi</a></li>
					<li><a href="#">Aiuto</a></li>
				</ul>
			</div>
			<!-- end footer list -->

			<!-- footer list -->
			<div class="col-6 col-sm-4 col-md-3">
				<h6 class="footer__title">Termini legali</h6>
				<ul class="footer__list">
					<li><a href="#">Termini d'uso</a></li>
					<li><a href="#">Privacy Policy</a></li>
					<li><a href="#">Sicurezza</a></li>
				</ul>
			</div>
			<!-- end footer list -->

			<!-- footer list -->
			<div class="col-12 col-sm-4 col-md-3">
				<h6 class="footer__title">Contatti</h6>
				<ul class="footer__list">
					<li><a href="tel:+393357852000">+39 3357852000</a></li>
					<li><a href="mailto:support@magicboulevardcinema.com">support@magicboulevardcinema.com</a></li>
				</ul>
				<ul class="footer__social">
					<li class="facebook"><a href="https://facebook.com" target="_blank"><i class="icon ion-logo-facebook"></i></a></li>
					<li class="instagram"><a href="https://instagram.com" target="_blank"><i class="icon ion-logo-instagram"></i></a></li>
					<li class="twitter"><a href="https://twitter.com" target="_blank"><i class="icon ion-logo-twitter"></i></a></li>
					<li class="vk"><a href="https://vk.com" target="_blank"><i class="icon ion-logo-vk"></i></a></li>
				</ul>
			</div>
			<!-- end footer list -->

			<!-- footer copyright -->
			<div class="col-12">
				<div class="footer__copyright">
					<small><a target="_blank" href="https://www.templateshub.net">Templates Hub</a></small>

					<ul>
						<li><a href="#">Termini d'uso</a></li>
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
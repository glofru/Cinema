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
								<a href="../../Informazioni/getCosti/" class="header__nav-link">Prezzi</a>
							</li>

							<li class="header__nav-item">
								<a href="../../Informazioni/getHelp/" class="header__nav-link">Aiuto</a>
							</li>

							<!-- dropdown -->
							<li class="dropdown header__nav-item">
								<a class="dropdown-toggle header__nav-link header__nav-link--more" href="#" role="button" id="dropdownMenuMore" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon ion-ios-more"></i></a>
								{if (!isset($utente))}
									<ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuMore">
										<li><a href="#">Su di noi</a></li>
										<li><a href="../../Utente/signup">Registrati</a></li>
										<li><a href="/Utente/controlloBigliettiNonRegistrato/?">I miei biglietti</a></li>
									</ul>
								{else}
									<ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuMore">
										<li><a href="#">Su di noi</a></li>
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
										<li><a href="../../Utente/show/?id={$utente->getId()}">Il mio profilo</a></li>
										<li><a href="../../Utente/bigliettiAcquistati">I miei acquisti</a></li>
										<li><a href="../../Utente/showCommenti/">I miei giudizi</a></li>
										<li><a href="../../Utente/logout">Logout <i class="icon ion-ios-log-out"></i></a></li>
									</ul>
								</li>
							{elseif (isset($utente) && $admin)}
								<li class="header__nav-item">
									<a class="header__sign-in" href="#" role="button" id="dropdownMenuCatalog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span>@{$utente->getUsername()}</span>
									</a>
									<ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuCatalog">
										<li><a href="../../Utente/show/?id={$utente->getId()}">Il mio profilo</a></li>
										<li><a href="/Admin/addFilm/?">Gestione film</a></li>
										<li><a href="">Gestione Proiezioni</a></li>
										<li><a href="../../Admin/gestioneUtenti/?">Gestione Utenti</a></li>
										<li><a href="../../Admin/modificaPrezzi/?">Gestione Prezzi</a></li>
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
						<h2 class="section__title">Su di noi</h2>
						<!-- end section title -->

						<!-- breadcrumb -->
						<ul class="breadcrumb">
							<li class="breadcrumb__item"><a href="/">Home</a></li>
							<li class="breadcrumb__item breadcrumb__item--active">Su di noi</li>
						</ul>
						<!-- end breadcrumb -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end page title -->

	<!-- about -->
	<section class="section">
		<div class="container">
			<div class="row">
				<!-- section title -->
				<div class="col-12">
					<h2 class="section__title"><b>Magic Boulevard Cinema</b> - La tua seconda casa</h2>
				</div>
				<!-- end section title -->

				<!-- section text -->
				<div class="col-12">
					<p class="section__text">Questo sito (e cinema) è stato creato da Alessio Di Santo, Gianluca Lofrumento e Giorgio Susanna. L'obbiettivo che ci siamo prefissati è quello di creare un portale per facilitare l'incontro fra il nostro cinema e l'utente. Velocità, semplicità e varietà sono le parole chiave del nostro prodotto. Speriamo che vi piaccia.</p>

					<p class="section__text section__text--last-with-margin">Di seguito ti verranno spiegati i passi da compiere per acquisatre uno o più biglietti per le nostre proiezioni a seconda del tuo status di utente (Registrato o Non Registrato). <br> <b>Da utente non registrato non avrai la possibilità di commentare i film e quindi di usufruire di tutte le features del nostro sito...</b></p>
				</div>
				<!-- end section text -->
			</div>
		</div>
	</section>
	<!-- end about -->

	<!-- how it works -->
	<section class="section section--dark">
		<div class="container">
			<div class="row">
				<!-- section title -->
				<div class="col-12">
					<h2 class="section__title section__title--no-margin">Vuoi acquistare un biglietto registrandoti sul nostro sito?</h2>
				</div>
				<!-- end section title -->

				<!-- how box -->
				<div class="col-12 col-md-6 col-lg-4">
					<div class="how">
						<span class="how__number">01</span>
						<h3 class="how__title">Crea un account</h3>
						<p class="how__text">Per creare un account ti basterà andare nella nostra home page e cliccare sul menù a tendina con i puntini di sospsensione (...) e premere su registrati. Inserisci i dati richiesti e pufff ora sei un nostro utente :)</p>
					</div>
				</div>
				<!-- ebd how box -->

				<!-- how box -->
				<div class="col-12 col-md-6 col-lg-4">
					<div class="how">
						<span class="how__number">02</span>
						<h3 class="how__title">Scegli la proiezione alla quale assistere</h3>
						<p class="how__text">Nella parte centrale della nostra home sono presentati i film in proiezione questa settimana. Clicca sulla locandina del film che ti interessa. Una volta all'interno della pagina del film scegli il giorno e l'ora della proiezione, clicca sui posti che vorresti e premi Acquista.</p>
					</div>
				</div>
				<!-- ebd how box -->

				<!-- how box -->
				<div class="col-12 col-md-6 col-lg-4">
					<div class="how">
						<span class="how__number">03</span>
						<h3 class="how__title">Conferma l'Acquisto</h3>
						<p class="how__text">A questo punto sarai indirizzato alla pagina di riepilogo del tuo acquisto. Per completare l'acquisto dovrai premere su Acquista. Adesso i biglietti sranno presenti nella tua sezione personale e ti verrà inviata una mail di conferma dell'ordine effettuato. </p>
					</div>
				</div>
				<!-- ebd how box -->
			</div>
		</div>
	</section>
	<!-- end how it works -->
<div class="col-12">
	<h2 class="section__title"></h2>
</div>
<!-- how it works -->
<section class="section section--dark">
	<div class="container">
		<div class="row">
			<!-- section title -->
			<div class="col-12">
				<h2 class="section__title section__title--no-margin">Vuoi acquistare un biglietto senza registrarti sul nostro sito?</h2>
			</div>
			<!-- end section title -->

			<!-- how box -->
			<div class="col-12 col-md-6 col-lg-4">
				<div class="how">
					<span class="how__number">01</span>
					<h3 class="how__title">Scegli la proiezione alla quale assistere</h3>
					<p class="how__text">Recati nella nostra home page e scegli il film che vorresti andare a vedere. Adesso dovrai scegliere il giorno e l'ora della proiezione per poi cliccare sui posti che vorresti prendere.</p>
				</div>
			</div>
			<!-- ebd how box -->

			<!-- how box -->
			<div class="col-12 col-md-6 col-lg-4">
				<div class="how">
					<span class="how__number">02</span>
					<h3 class="how__title">Conferma dell'acquisto</h3>
					<p class="how__text">Arrivato a questo punto avrai davanti a te una pagina di riepilogo dell'ordine che stai effettuando. Per proseguire dovrai premere su Acquista. Ti verrà chiesto, quindi, di inserire la tua mail per poterti inviare i biglietti. Nella tua mail troverai i tuoi biglietti insieme ad un <a href="">codice di accesso</a> </p>
				</div>
			</div>
			<!-- ebd how box -->
			<div class="col-12 col-md-6 col-lg-4">
				<div class="how">
					<span class="how__number">03</span>
					<h3 class="how__title">Codice di accesso?</h3>
					<p class="how__text">Il codice di accesso che ti sarà recapitato ti permetterà di consultare sul nostro sito i tuoi acquisti. Per accedere, alla sezione dei tuoi acquisti, dovrai andare nella parte superiore della pagina e dal menù a tendina (...) premere su <a href="../../Utente/controlloBigliettiNonRegistrato/?">I miei biglietti</a>. Da qui potrai consultare tutti i tuoi acquisti. Il codice sarà valido anche per i tuoi prossimi acquisti così avrai sempre a disposizione un recap dei tuoi acquisti.</p>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- end how it works -->
	<!-- partners -->
	<section class="section">
		<div class="container">
			<div class="row">
				<!-- section title -->
				<div class="col-12">
					<h2 class="section__title section__title--no-margin">I nostri sponsor</h2>
				</div>
				<!-- end section title -->

				<!-- section text -->
				<div class="col-12">
					<p class="section__text section__text--last-with-margin">Ringraziamo i nostri sponsor per il loro supporto alla nostra attività.</p>
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
				<h6 class="footer__title">Scarica la nostra App</h6>
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
					<li><a href="../../Informazioni/getCosti/">Costi</a></li>
					<li><a href="../../Informazioni/getHelp/">Aiuto</a></li>
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
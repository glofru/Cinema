<!DOCTYPE html>
<html lang="it">

<head>
	<script>
		function ready(){
			if (!navigator.cookieEnabled) {
				alert('Caro utente, ti invitiamo ad abilitare i cookie sul nostro sito per permetterti un\'esperienza migliore e personalizzata in bae alle tue preferenze.');
			}
		}
		document.addEventListener("DOMContentLoaded", ready);
	</script>
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
							<a href="index.html" class="header__logo">
								<img src="Smarty/img/logo.svg" alt="">
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
									<a href="pricing.html" class="header__nav-link">Costi</a>
								</li>

								<li class="header__nav-item">
									<a href="faq.html" class="header__nav-link">Aiuto</a>
								</li>

								<!-- dropdown -->
								<li class="dropdown header__nav-item">
									<a class="dropdown-toggle header__nav-link header__nav-link--more" href="#" role="button" id="dropdownMenuMore" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon ion-ios-more"></i></a>
									 {if ($user == "")}
									<ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuMore">
										<li><a href="about.html">Su di noi</a></li>
										<li><a href="signin.html">Login</a></li>
										<li><a href="signup.html">Registrati</a></li>
									{else}
									<ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuMore">
										<li><a href="about.html">Su di noi</a></li>
									{/if}
									</ul>
								</li>
								<!-- end dropdown -->
							</ul>
							<!-- end header nav -->

							<!-- header auth -->
							<div class="header__auth">
								<button class="header__search-btn" type="button">
									<i class="icon ion-ios-search"></i>
								</button>
								
								<a href="signin.html" class="header__sign-in">
									<i class="icon ion-ios-log-in"></i>
									{if ($user === "")}
									<span>login</span>
									{else}
									<span>Bentornato</span>
									{/if}
								</a>
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
		<form action="#" class="header__search">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="header__search-content">
							<input type="text" placeholder="Cerca un film">

							<button type="button">Cerca</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		<!-- end header search -->
	</header>
	<!-- end header -->

	<!-- home -->
	<section class="home home--bg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h1 class="home__title"><b>PROSSIME</b> USCITE</h1>

					<button class="home__nav home__nav--prev" type="button">
						<i class="icon ion-ios-arrow-round-back"></i>
					</button>
					<button class="home__nav home__nav--next" type="button">
						<i class="icon ion-ios-arrow-round-forward"></i>
					</button>
				</div>

				<div class="col-12">
					<div class="owl-carousel home__carousel">
						{if $filmProssimi}
							{if is_array($filmProssimi)}
							{$i = 0}
								{foreach $filmProssimi as $film}
						<div class="item">
							<!-- card -->
							<div class="card card--big">
								<div class="card__cover">
									<img src="{$immaginiProssimi[$i]->getImmagineHTML()}" alt="">
									<a href="/Film/show/?film={$film->getId()}&autoplay=true" class="card__play">
										<i class="icon ion-ios-play"></i>
									</a>
								</div>
								<div class="card__content">
									<h3 class="card__title"><a href="/Film/show/?film={$film->getId()}">{$film->getNome()}</a></h3>
									<span class="card__category">
										<a href="#">{$film->getGenere()}</a>
									</span>
								</div>
							</div>
							<!-- end card -->
						</div>
						{$i++}
								{/foreach}
							{/if}
						{/if}
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end -->

	<!-- content -->
	<section class="content">
		<div class="content__head">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<!-- content title -->
						<h2 class="content__title">La nostra programmazione</h2>
						<!-- end content title -->

						<!-- content tabs nav -->
						<ul class="nav nav-tabs content__tabs" id="content__tabs" role="tablist">

							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="false">Settimana Scorsa</a>
							</li>


							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="true">Questa settimana</a>
							</li>


							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#tab-3" role="tab" aria-controls="tab-3" aria-selected="false">Settimana prossima</a>
							</li>

						</ul>
						<!-- end content tabs nav -->

						<!-- content mobile tabs nav -->
						<div class="content__mobile-tabs" id="content__mobile-tabs">
							<div class="content__mobile-tabs-btn dropdown-toggle" role="navigation" id="mobile-tabs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<input type="button" value="New items">
								<span></span>
							</div>

							<div class="content__mobile-tabs-menu dropdown-menu" aria-labelledby="mobile-tabs">
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item"><a class="nav-link active" id="1-tab" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-1" aria-selected="true">Settimana scorsa</a></li>

									<li class="nav-item"><a class="nav-link" id="2-tab" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-2" aria-selected="false">Questa settimana</a></li>

									<li class="nav-item"><a class="nav-link" id="3-tab" data-toggle="tab" href="#tab-3" role="tab" aria-controls="tab-3" aria-selected="false">Settimana prossima</a></li>
								</ul>
							</div>
						</div>
						<!-- end content mobile tabs nav -->
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<!-- content tabs -->
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade" id="tab-1" role="tabpanel" aria-labelledby="1-tab">
					<div class="row">
						{if $filmSettimanaScorsa}
							{foreach $filmSettimanaScorsa as $key => $film}
						<!-- card -->
						<div class="col-6 col-sm-12 col-lg-6">
							<div class="card card--list">
								<div class="row">
									<div class="col-12 col-sm-4">
										<div class="card__cover">
											<img src="{$immaginiSettimanaScorsa[$key]->getImmagineHTML()}" alt="">
											<a href="/Film/show/?film={$film->getId()}&autoplay=true" class="card__play">
												<i class="icon ion-ios-play"></i>
											</a>
										</div>
									</div>
									<div class="col-12 col-sm-8">
										<div class="card__content">
											<h3 class="card__title"><a href="/Film/show/?film={$film->getId()}">{$film->getNome()}</a></h3>

											<div class="card__wrap">
												<span class="card__rate"><i class="icon ion-ios-star"></i>{$film->getVotoCritica()} &nbsp;</span>
												{if ($punteggioProgrammazione[$key] != '0')}
													<span class="card__category">
													<a href="/Film/show/?film={$film->getId()}#acquista" >Voto utenti: {$punteggioProgrammazione[$key]}</a>
												</span>
												{/if}
												{if ($film->getetaConsigliata() != "")}
													<ul class="card__list">
														<li>{$film->getetaConsigliata()}</li>
													</ul>
												{/if}
											</div>

											<div class="card__description">
												<p>{$dateSettimanaScorsa[$key]}</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- end card -->
						{/foreach}
					{/if}
					</div>
				</div>
				<div class="tab-pane fade show active" id="tab-2" role="tabpanel" aria-labelledby="2-tab">
					<div class="row">
						{if $filmProgrammazione}
							{foreach $filmProgrammazione as $key => $film}
						<!-- card -->
						<div class="col-6 col-sm-12 col-lg-6">
							<div class="card card--list">
								<div class="row">
									<div class="col-12 col-sm-4">
										<div class="card__cover">
											<img src="{$immaginiProgrammazione[$key]->getImmagineHTML()}" alt="">
											<a href="/Film/show/?film={$film->getId()}&autoplay=true" class="card__play">
												<i class="icon ion-ios-play"></i>
											</a>
										</div>
									</div>

									<div class="col-12 col-sm-8">
										<div class="card__content">
											<h3 class="card__title"><a href="/Film/show/?film={$film->getId()}">{$film->getNome()}</a></h3>

											<div class="card__wrap">
												<span class="card__rate"><i class="icon ion-ios-star"></i>{$film->getVotoCritica()} &nbsp;</span>
												{if ($punteggioProgrammazione[$key] != '0')}
												<span class="card__category">
													<a href="/Film/show/?film={$film->getId()}#acquista" >Voto utenti: {$punteggioProgrammazione[$key]}</a>
												</span>
												{/if}
												{if ($film->getetaConsigliata() != "")}
												<ul class="card__list">
													<li>{$film->getetaConsigliata()}</li>
												</ul>
												{/if}
											</div>

											<div class="card__description">
												<p>{$dateProgrammazione[$key]}</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- end card -->
						{/foreach}
					{/if}
					</div>
				</div>
				<div class="tab-pane fade" id="tab-3" role="tabpanel" aria-labelledby="3-tab">
					<div class="row">
						{if $filmSettimanaProssima}
							{foreach $filmSettimanaProssima as $key => $film}
						<!-- card -->
						<div class="col-6 col-sm-12 col-lg-6">
							<div class="card card--list">
								<div class="row">
									<div class="col-12 col-sm-4">
										<div class="card__cover">
											<img src="{$immaginiSettimanaProssima[$key]->getImmagineHTML()}" alt="">
											<a href="/Film/show/?film={$film->getId()}&autoplay=true" class="card__play">
												<i class="icon ion-ios-play"></i>
											</a>
										</div>
									</div>

									<div class="col-12 col-sm-8">
										<div class="card__content">
											<h3 class="card__title"><a href="/Film/show/?film={$film->getId()}">{$film->getNome()}</a></h3>

											<div class="card__wrap">
												<span class="card__rate"><i class="icon ion-ios-star"></i>{$film->getVotoCritica()} &nbsp;</span>
												{if ($punteggioProgrammazione[$key] != '0')}
													<span class="card__category">
													<a href="/Film/show/?film={$film->getId()}#acquista" >Voto utenti: {$punteggioProgrammazione[$key]}</a>
												</span>
												{/if}
												{if ($film->getetaConsigliata() != "")}
													<ul class="card__list">
														<li>{$film->getetaConsigliata()}</li>
													</ul>
												{/if}
											</div>

											<div class="card__description">
												<p>{$dateSettimanaProssima[$key]}</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- end card -->
						{/foreach}
					{/if}
					</div>
				</div>
			</div>
			<!-- end content tabs -->
		</div>
	</section>>
	<!-- end content -->

	<!-- expected premiere -->
	<section class="section section--bg" data-bg="img/section/section.jpg">
		<div class="container">
			<div class="row">
				<!-- section title -->
				<div class="col-12">
					<h2 class="section__title">Consigliati per te</h2>
				</div>
				<!-- end section title -->
				{if $filmConsigliati}
					{foreach $filmConsigliati as $key => $film}
				<!-- card -->
				<div class="col-6 col-sm-4 col-lg-3 col-xl-2">
					<div class="card">
						<div class="card__cover">
							<img src="{$immaginiConsigliati[$key]->getImmagineHTML()}" alt="">
							<a href="/Film/show/?film={$film->getId()}&autoplay=true" class="card__play">
								<i class="icon ion-ios-play"></i>
							</a>
						</div>
						<div class="card__content">
							<h3 class="card__title"><a href="/Film/show/?film={$film->getId()}">{$film->getNome()}</a></h3>
							<span class="card__category">
								<a href="#">{$film->getGenere()}</a>
							</span>
							{if ($film->getVotoCritica() != 0)}
							<span class="card__rate"><i class="icon ion-ios-star"></i>{$film->getVotoCritica()}</span>
							{else}
							<div class="card__description"> <p>Data di uscita: <br> {$film->getDataRilascioString()}</p></div>
							{/if}
						</div>
					</div>
				</div>
				<!-- end card -->
					{/foreach}
				{/if}
				<!-- section btn -->
				<div class="col-12">
					<a href="#" class="section__btn">Altro</a>
				</div>
				<!-- end section btn -->
			</div>
		</div>
	</section>
	<!-- end expected premiere -->

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
					<p class="section__text section__text--last-with-margin">It is a long <b>established</b> fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using.</p>
				</div>
				<!-- end section text -->

				<!-- partner -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
					<a href="#" class="partner">
						<img src="Smarty/img/partners/themeforest-light-background.png" alt="" class="partner__img">
					</a>
				</div>
				<!-- end partner -->

				<!-- partner -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
					<a href="#" class="partner">
						<img src="Smarty/img/partners/audiojungle-light-background.png" alt="" class="partner__img">
					</a>
				</div>
				<!-- end partner -->

				<!-- partner -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
					<a href="#" class="partner">
						<img src="Smarty/img/partners/codecanyon-light-background.png" alt="" class="partner__img">
					</a>
				</div>
				<!-- end partner -->

				<!-- partner -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
					<a href="#" class="partner">
						<img src="Smarty/img/partners/photodune-light-background.png" alt="" class="partner__img">
					</a>
				</div>
				<!-- end partner -->

				<!-- partner -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
					<a href="#" class="partner">
						<img src="Smarty/img/partners/activeden-light-background.png" alt="" class="partner__img">
					</a>
				</div>
				<!-- end partner -->

				<!-- partner -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
					<a href="#" class="partner">
						<img src="Smarty/img/partners/3docean-light-background.png" alt="" class="partner__img">
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
					<h6 class="footer__title">Download Our App</h6>
					<ul class="footer__app">
						<li><a href="#"><img src="Smarty/img/Download_on_the_App_Store_Badge.svg" alt=""></a></li>
						<li><a href="#"><img src="Smarty/img/google-play-badge.png" alt=""></a></li>
					</ul>
				</div>
				<!-- end footer list -->

				<!-- footer list -->
				<div class="col-6 col-sm-4 col-md-3">
					<h6 class="footer__title">Informazioni</h6>
					<ul class="footer__list">
						<li><a href="#">Su di noi</a></li>
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
						<li><a href="#">Securezza</a></li>
					</ul>
				</div>
				<!-- end footer list -->

				<!-- footer list -->
				<div class="col-12 col-sm-4 col-md-3">
					<h6 class="footer__title">Contatti</h6>
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
	<script src="Smarty/js/jquery-3.3.1.min.js"></script>
	<script src="Smarty/js/bootstrap.bundle.min.js"></script>
	<script src="Smarty/js/owl.carousel.min.js"></script>
	<script src="Smarty/js/jquery.mousewheel.min.js"></script>
	<script src="Smarty/js/jquery.mCustomScrollbar.min.js"></script>
	<script src="Smarty/js/wNumb.js"></script>
	<script src="Smarty/js/nouislider.min.js"></script>
	<script src="Smarty/js/plyr.min.js"></script>
	<script src="Smarty/js/jquery.morelines.min.js"></script>
	<script src="Smarty/js/photoswipe.min.js"></script>
	<script src="Smarty/js/photoswipe-ui-default.min.js"></script>
	<script src="Smarty/js/main.js"></script>
</body>

</html>
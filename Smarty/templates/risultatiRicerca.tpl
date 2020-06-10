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

	{include file="{$path}Smarty/templates/header.tpl"}

	<!-- page title -->
	<section class="section section--first section--bg" data-bg="{$path}../../Smarty/img/section/section.jpg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section__wrap">
						<!-- section title -->
						<h2 class="section__title">Lista risultati</h2>
						<!-- end section title -->

						<!-- breadcrumb -->
						<ul class="breadcrumb">
							<li class="breadcrumb__item"><a href="/">Home</a></li>
							<li class="breadcrumb__item breadcrumb__item--active">Lista risultati</li>
						</ul>
						<!-- end breadcrumb -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end page title -->

	<!-- filter -->
	<form action="{$path}../../Ricerca/cercaFilmAttributi" method="POST">
	<div class="filter">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="filter__content">
						<div class="filter__items">
							<!-- filter item -->
							<div class="filter__item" id="filter__genre">
								<span class="filter__item-label">GENERE:</span>

								<div class="filter__item-btn dropdown-toggle" role="navigation" id="filter-genre" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									{if isset($genere)}
										<input type="button" id="g" name="g" value="{$genere}">
									{else}
										<input type="button" id="g" name="g" value="AZIONE">
									{/if}
									<span></span>
								</div>

								<ul class="filter__item-menu dropdown-menu scrollbar-dropdown" aria-labelledby="filter-genre">
									{foreach $generi as $g}
										<li>{$g}</li>
									{/foreach}
								</ul>

								<input type="hidden" name="genere" id="Genere">
							</div>
							<!-- end filter item -->

							<!-- filter item -->
							<div class="filter__item" id="filter__rate">
								<span class="filter__item-label">Voto Critica:</span>

								<div class="filter__item-btn dropdown-toggle" role="button" id="filter-rate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<div class="filter__range">
										<div id="filter__imbd-start"></div>
										<input type="hidden" name="voto_inizio" id="voto_inizio">
										<div id="filter__imbd-end"></div>
										<input type="hidden" name="voto_fine" id="voto_fine">
									</div>
									<span></span>
								</div>

								<div class="filter__item-menu filter__item-menu--range dropdown-menu" aria-labelledby="filter-rate">
									<div id="filter__imbd"></div>
								</div>
							</div>
							<!-- end filter item -->

							<!-- filter item -->
							<div class="filter__item" id="filter__year">
								<span class="filter__item-label">Anno di Rilascio:</span>
								<div class="filter__item-btn dropdown-toggle" role="button" id="filter-year" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<div class="filter__range">
										<div id="filter__years-start"></div>
										<input type="hidden" name="anno_inizio" id="anno_inizio">
										<div id="filter__years-end"></div>
										<input type="hidden" name="anno_fine" id="anno_fine">
									</div>
									<span></span>
								</div>

								<div class="filter__item-menu filter__item-menu--range dropdown-menu" aria-labelledby="filter-year">
									<div id="filter__years"></div>
								</div>
							</div>
							<!-- end filter item -->
						</div>

						<!-- filter btn -->
						<button class="filter__btn" onclick="sender()">Applica filtri</button>
						<!-- end filter btn -->
					</div>
				</div>
			</div>
		</div>
		</div>
	</form>
	<!-- end filter -->

	<!-- catalog -->
	<div class="catalog">
		<div class="container">
			<div class="row">
				{if (sizeof($filmCercati) > 0)}
				{foreach $filmCercati as $key => $film}
				<!-- card -->
				<div class="col-6 col-sm-12 col-lg-6">
					<div class="card card--list">
						<div class="row">
							<div class="col-12 col-sm-4">
								<div class="card__cover">
									<img src="{$immaginiCercati[$key]->getImmagineHTML()}" alt="">
									<a href="{$path}../../Film/show/?film={$film->getId()}&autoplay=true" class="card__play">
										<i class="icon ion-ios-play"></i>
									</a>
								</div>
							</div>

							<div class="col-12 col-sm-8">
								<div class="card__content">
									<h3 class="card__title"><a href="{$path}../../Film/show/?film={$film->getId()}">{$film->getNome()}</a></h3>

									<div class="card__wrap">
										{if ($film->getVotoCritica() != 0)}
											<span class="card__rate"><i class="icon ion-ios-star"></i>{$film->getVotoCritica()}</span>
										{else}
											<div class="card__description"> <p>Data di uscita: {$film->getDataRilascioString()}</p></div>
										{/if}

										{if ($punteggio[$key] != 0)}
											<span class="card__category">
													<a href="{$path}../../Film/show/?film={$film->getId()}#acquista" >Voto utenti: {$punteggio[$key]}</a>
												</span>
										{/if}

										{if ($film->getetaConsigliata() != "")}
											<ul class="card__list">
												<li>{$film->getetaConsigliata()}</li>
											</ul>
										{/if}
									</div>

									<div class="card__description">
										<p>{$film->getDescrizioneHTML()}</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				{/foreach}
				<!-- end card -->
				{else}
					<div class="col-12">
						<h2 class="section__title section__title--center">Nessun risultato ottenuto</h2>
					</div>
				{/if}
			</div>
		</div>
	</div>
	<!-- end catalog -->

	<!-- expected premiere -->
	<section class="section section--bg" data-bg="{$path}../../img/section/section.jpg">
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
									<a href="{$path}../../Film/show/?film={$film->getId()}&autoplay=true" class="card__play">
										<i class="icon ion-ios-play"></i>
									</a>
								</div>
								<div class="card__content">
									<h3 class="card__title"><a href="{$path}../../Film/show/?film={$film->getId()}">{$film->getNome()}</a></h3>
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
			</div>
		</div>
	</section>
	<!-- end expected premiere -->

<!-- footer -->
<footer class="footer">
	<div class="container">
		<div class="row">
			<!-- footer list -->
			<div class="col-12 col-md-3">
				<h6 class="footer__title">Scarica la nostra App</h6>
				<ul class="footer__app">
					<li><a href="https://play.google.com/store?hl=it"><img src="{$path}../../Smarty/img/Download_on_the_App_Store_Badge.svg" alt=""></a></li>
					<li><a href="https://www.apple.com/it/ios/app-store/"><img src="{$path}../../Smarty/img/google-play-badge.png" alt=""></a></li>
				</ul>
			</div>
			<!-- end footer list -->

			<!-- footer list -->
			<div class="col-6 col-sm-4 col-md-3">
				<h6 class="footer__title">Informazioni</h6>
				<ul class="footer__list">
					<li><a href="{$path}../../Informazioni/getAbout/">Su di noi</a></li>
					<li><a href="{$path}../../Informazioni/getCosti/">Costi</a></li>
					<li><a href="{$path}../../Informazioni/getHelp/">Aiuto</a></li>
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
	function sender() {
		document.getElementById("voto_inizio").value = document.getElementById("filter__imbd-start").innerText;
		document.getElementById("voto_fine").value = document.getElementById("filter__imbd-end").innerText;
		document.getElementById("anno_inizio").value = document.getElementById("filter__years-start").innerText;
		document.getElementById("anno_fine").value = document.getElementById("filter__years-end").innerText;
		document.getElementById("Genere").value = document.getElementById("g").value;
	}


	$(window).on('load', function () {
		{if isset($annoInizio)}
		initializeFirstSlider({$annoInizio}, {$annoFine});
		initializeSecondSlider({$votoInizio}, {$votoFine});
		{else}
		initializeFirstSlider();
		initializeSecondSlider();
		{/if}
	});

	function initializeFirstSlider(begin = 2000, end = 2020) {
		if ($('#filter__years').length) {
			var firstSlider = document.getElementById('filter__years');
			noUiSlider.create(firstSlider, {
				range: {
					'min': 1998,
					'max': 2022
				},
				step: 1,
				connect: true,
				start: [begin, end],
				format: wNumb({
					decimals: 0,
				})
			});
			var firstValues = [
				document.getElementById('filter__years-start'),
				document.getElementById('filter__years-end')
			];
			firstSlider.noUiSlider.on('update', function( values, handle ) {
				firstValues[handle].innerHTML = values[handle];
			});
		} else {
			return false;
		}
		return false;
	}

	function initializeSecondSlider(begin = 3.0, end = 8.0) {
		if ($('#filter__imbd').length) {
			var secondSlider = document.getElementById('filter__imbd');
			noUiSlider.create(secondSlider, {
				range: {
					'min': 0,
					'max': 10
				},
				step: 0.1,
				connect: true,
				start: [begin, end],
				format: wNumb({
					decimals: 1,
				})
			});

			var secondValues = [
				document.getElementById('filter__imbd-start'),
				document.getElementById('filter__imbd-end')
			];

			secondSlider.noUiSlider.on('update', function( values, handle ) {
				secondValues[handle].innerHTML = values[handle];
			});

			$('.filter__item-menu--range').on('click.bs.dropdown', function (e) {
				e.stopPropagation();
				e.preventDefault();
			});
		} else {
			return false;
		}
		return false;
	}
</script>

</body>

</html>
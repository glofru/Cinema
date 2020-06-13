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
	<title>Magic Boulevard Cinema - Dove i sogni diventano realtà</title>

</head>
<body class="body">

	{include file="header.tpl"}

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
								{foreach $filmProssimi as $key => $film}
						<div class="item">
							<!-- card -->
							<div class="card card--big">
								<div class="card__cover">
									<img src="{$immaginiProssimi[$key]->getImmagineHTML()}" alt="">
									<a href="{$path}Film/show/?film={$film->getId()}&autoplay=true" class="card__play">
										<i class="icon ion-ios-play"></i>
									</a>
								</div>
								<div class="card__content">
									<h3 class="card__title"><a href="{$path}Film/show/?film={$film->getId()}">{$film->getNome()}</a></h3>
									<span class="card__category">
										<a href="#">{$film->getGenere()}</a>
									</span>
								</div>
							</div>
							<!-- end card -->
						</div>
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
											<a href="{$path}Film/show/?film={$film->getId()}&autoplay=true" class="card__play">
												<i class="icon ion-ios-play"></i>
											</a>
										</div>
									</div>
									<div class="col-12 col-sm-8">
										<div class="card__content">
											<h3 class="card__title"><a href="{$path}Film/show/?film={$film->getId()}">{$film->getNome()}</a></h3>

											<div class="card__wrap">
												<span class="card__rate"><i class="icon ion-ios-star"></i>{$film->getVotoCritica()} &nbsp;</span>
												{if ($punteggioSettimanaScorsa[$key] != '0')}
													<span class="card__category">
													<a href="{$path}Film/show/?film={$film->getId()}#acquista" >Voto utenti: {$punteggioSettimanaScorsa[$key]}</a>
												</span>
												{/if}
												{if ($film->getEtaConsigliata() != "")}
													<ul class="card__list">
														<li>{$film->getEtaConsigliata()}</li>
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
											<a href="{$path}Film/show/?film={$film->getId()}&autoplay=true" class="card__play">
												<i class="icon ion-ios-play"></i>
											</a>
										</div>
									</div>

									<div class="col-12 col-sm-8">
										<div class="card__content">
											<h3 class="card__title"><a href="{$path}Film/show/?film={$film->getId()}">{$film->getNome()}</a></h3>

											<div class="card__wrap">
												<span class="card__rate"><i class="icon ion-ios-star"></i>{$film->getVotoCritica()} &nbsp;</span>
												{if ($punteggioProgrammazione[$key] != '0')}
												<span class="card__category">
													<a href="{$path}Film/show/?film={$film->getId()}#acquista" >Voto utenti: {$punteggioProgrammazione[$key]}</a>
												</span>
												{/if}
												{if ($film->getEtaConsigliata() != "")}
												<ul class="card__list">
													<li>{$film->getEtaConsigliata()}</li>
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
											<a href="{$path}Film/show/?film={$film->getId()}&autoplay=true" class="card__play">
												<i class="icon ion-ios-play"></i>
											</a>
										</div>
									</div>

									<div class="col-12 col-sm-8">
										<div class="card__content">
											<h3 class="card__title"><a href="{$path}Film/show/?film={$film->getId()}">{$film->getNome()}</a></h3>

											<div class="card__wrap">
												<span class="card__rate"><i class="icon ion-ios-star"></i>{$film->getVotoCritica()} &nbsp;</span>
												{if ($punteggioSettimanaProssima[$key] != '0')}
													<span class="card__category">
													<a href="{$path}Film/show/?film={$film->getId()}#acquista" >Voto utenti: {$punteggioSettimanaProssima[$key]}</a>
												</span>
												{/if}
												{if ($film->getEtaConsigliata() != "")}
													<ul class="card__list">
														<li>{$film->getEtaConsigliata()}</li>
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
	<section class="section section--bg" data-bg="{$path}img/section/section.jpg">
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
							<a href="{$path}Film/show/?film={$film->getId()}&autoplay=true" class="card__play">
								<i class="icon ion-ios-play"></i>
							</a>
						</div>
						<div class="card__content">
							<h3 class="card__title"><a href="{$path}Film/show/?film={$film->getId()}">{$film->getNome()}</a></h3>
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
						<img src="{$path}Smarty/img/partners/themeforest-light-background.png" alt="" class="partner__img">
					</a>
				</div>
				<!-- end partner -->

				<!-- partner -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
					<a href="#" class="partner">
						<img src="{$path}Smarty/img/partners/audiojungle-light-background.png" alt="" class="partner__img">
					</a>
				</div>
				<!-- end partner -->

				<!-- partner -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
					<a href="#" class="partner">
						<img src="{$path}Smarty/img/partners/codecanyon-light-background.png" alt="" class="partner__img">
					</a>
				</div>
				<!-- end partner -->

				<!-- partner -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
					<a href="#" class="partner">
						<img src="{$path}Smarty/img/partners/photodune-light-background.png" alt="" class="partner__img">
					</a>
				</div>
				<!-- end partner -->

				<!-- partner -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
					<a href="#" class="partner">
						<img src="{$path}Smarty/img/partners/activeden-light-background.png" alt="" class="partner__img">
					</a>
				</div>
				<!-- end partner -->

				<!-- partner -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
					<a href="#" class="partner">
						<img src="{$path}Smarty/img/partners/3docean-light-background.png" alt="" class="partner__img">
					</a>
				</div>
				<!-- end partner -->
			</div>
		</div>
	</section>
	<!-- end partners -->

{include file="footer.tpl"}

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
</body>

</html>
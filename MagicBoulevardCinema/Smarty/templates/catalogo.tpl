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
	<title>Magic Boulevard Cinema - Dove i sogni diventano realtà</title>

</head>
<body class="body">

{include file="header.tpl"}

<!-- page title -->
	<section class="section section--first section--bg" data-bg="{$path}Smarty/img/section/section.jpg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section__wrap">
						<!-- section title -->
						<h2 class="section__title">{$whois}</h2>
						<!-- end section title -->

						<!-- breadcrumb -->
						<ul class="breadcrumb">
							<li class="breadcrumb__item"><a href="/MagicBoulevardCinema">Home</a></li>
							<li class="breadcrumb__item breadcrumb__item--active">{$whois}</li>
						</ul>
						<!-- end breadcrumb -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end page title -->
<section> <div class="col-12">
		<h2 class="section__title"></h2>
	</div> </section>
{if (isset($filmProssimi))}
	<!-- catalog -->
	<div class="catalog">
		<div class="container">
			<div class="row">
					{foreach $filmProssimi as $key => $item}
				<!-- card -->
				<div class="col-6 col-sm-12 col-lg-6">
					<div class="card card--list">
						<div class="row">
							<div class="col-12 col-sm-4">
								<div class="card__cover">
									<img src="{$immaginiProssimi[$key]->getImmagineHTML()}" alt="">
									<a href="{$path}Film/show/?film={$item->getId()}&autoplay=true" class="card__play">
										<i class="icon ion-ios-play"></i>
									</a>
								</div>
							</div>

							<div class="col-12 col-sm-8">
								<div class="card__content">
									<h3 class="card__title"><a href="{$path}Film/show/?film={$item->getId()}&autoplay=true">{$item->getNome()}</a></h3>
									<span class="card__category">
										<a href="{$path}Film/show/?film={$item->getId()}&autoplay=true">{$item->getGenere()}</a>
									</span>

									<div class="card__wrap">
										<div class="card__description"> <p>Data di uscita: <br> {$item->getDataRilascioString()}</p></div>
										<ul class="card__list">
											{if ($item->getEtaConsigliata() != "")}
											<ul class="card__list">
												<li>{$item->getEtaConsigliata()}</li>
											</ul>
											{/if}
										</ul>
									</div>

									<div class="card__description">
										<p>{$item->getDescrizioneHTMLLess()}</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
					{/foreach}
				<!-- end card -->
			</div>
		</div>
	</div>
{/if}

{if (isset($filmPassati))}
	<!-- catalog -->
	<div class="catalog">
		<div class="container">
			{for $i=0 to sizeof($filmPassati) step 1}
				<section> <div class="col-12">
						<h2 class="section__title align-content-center">{$toShow[$i]}</h2>
					</div> </section>
			<div class="row">
				{foreach $filmPassati[$i] as $key => $item}
					<!-- card -->
					<div class="col-6 col-sm-12 col-lg-6">
						<div class="card card--list">
							<div class="row">
								<div class="col-12 col-sm-4">
									<div class="card__cover">
										<img src="{$immaginiPassati[$i][$key]->getImmagineHTML()}" alt="">
										<a href="{$path}Film/show/?film={$item->getId()}&autoplay=true" class="card__play">
											<i class="icon ion-ios-play"></i>
										</a>
									</div>
								</div>

								<div class="col-12 col-sm-8">
									<div class="card__content">
										<h3 class="card__title"><a href="{$path}Film/show/?film={$item->getId()}&autoplay=true">{$item->getNome()}</a></h3>
										<span class="card__category">
										<a href="{$path}Film/show/?film={$item->getId()}&autoplay=true">{$item->getGenere()}</a>
									</span>

										<div class="card__wrap">
											<span class="card__rate"><i class="icon ion-ios-star"></i>{$item->getVotoCritica()} &nbsp;</span>
											{if ($punteggio[$i][$key] != '0')}
												<span class="card__category">
													<a href="{$path}Film/show/?film={$item->getId()}#acquista" >Voto utenti: {$punteggio[$i][$key]}</a>
												</span>
											{/if}
											{if ($item->getEtaConsigliata() != "")}
												<ul class="card__list">
													<li>{$item->getEtaConsigliata()}</li>
												</ul>
											{/if}
										</div>

										<div class="card__description">
											<p>{$date[$i][$key]}</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				{/foreach}
				<!-- end card -->
			</div>
			{/for}
		</div>
	</div>
{/if}

{if (isset($filmApprezzati))}
	<!-- catalog -->
	<div class="catalog">
		<div class="container">
					{foreach $filmApprezzati as $key => $item}
						<section> <div class="col-12">
								<h2 class="section__title align-content-center">#{$key+1}</h2>
							</div> </section>
						<!-- card -->
						<div class="col-6 col-sm-12 col-lg-6">
							<div class="card card--list">
								<div class="row">
									<div class="col-12 col-sm-4">
										<div class="card__cover">
											<img src="{$immaginiApprezzati[$key]->getImmagineHTML()}" alt="">
											<a href="{$path}Film/show/?film={$item->getId()}&autoplay=true" class="card__play">
												<i class="icon ion-ios-play"></i>
											</a>
										</div>
									</div>

									<div class="col-12 col-sm-8">
										<div class="card__content">
											<h3 class="card__title"><a href="{$path}Film/show/?film={$item->getId()}&autoplay=true">{$item->getNome()}</a></h3>
											<span class="card__category">
										<a href="{$path}Film/show/?film={$item->getId()}&autoplay=true">{$item->getGenere()}</a>
									</span>

											<div class="card__wrap">
												<span class="card__rate"><i class="icon ion-ios-star"></i>{$item->getVotoCritica()} &nbsp;</span>
													<span class="card__category">
													<a href="{$path}Film/show/?film={$item->getId()}#acquista" >Voto utenti: {$punteggio[$item->getId()]}</a>
												</span>
												{if ($item->getEtaConsigliata() != "")}
													<ul class="card__list">
														<li>{$item->getEtaConsigliata()}</li>
													</ul>
												{/if}
											</div>

											<div class="card__description">
												<p>{$item->getDescrizioneHTMLLess()}</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					{/foreach}
					<!-- end card -->
				</div>
		</div>
	</div>
{/if}

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
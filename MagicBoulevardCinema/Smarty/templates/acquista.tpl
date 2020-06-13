<!DOCTYPE html>
<html lang="en">

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
						<h2 class="section__title">Riepilogo acquisto</h2>
						<!-- end section title -->

						<!-- breadcrumb-->
						<ul class="breadcrumb">
							<li class="breadcrumb__item"><a href="/MagicBoulevardCinema">Home</a></li>
							<li class="breadcrumb__item"><a href="{$path}Film/show/?film={$biglietti[0]->getProiezione()->getFilm()->getId()}&autoplay=true">Film</a></li>
							<li class="breadcrumb__item breadcrumb__item--active">Acquisto Biglietto</li>
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
							<p>Cliccare su acquista per procedere. Oppure puoi annullare l'acquisto.</p>
						</div>
						<!-- end filter item -->
					</div>

					<!-- filter btn -->
					<form action="{$path}Acquisto/confermaAcquisto" method="POST">
						<button class="filter__btn" type="submit">Acquista</button>
					</form>
					<button class="filter__btn" type="button" onclick="window.">Annulla</button>
					<!-- end filter btn -->
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
				{if (isset($biglietti))}
				{foreach $biglietti as $item}
				<!-- card -->
				<div class="col-6 col-sm-12 col-lg-6">
					<div class="card card--list">
						<div class="row">
							<div class="col-12 col-sm-4">
								<div class="card__cover">
									<img src="{$locandina->getImmagineHTML()}" alt="">
								</div>
							</div>

							<div class="col-12 col-sm-8">
								<div class="card__content">
									<h3 class="card__title"><a href="#">{$item->getProiezione()->getFilm()->getNome()}</a></h3>
									<span class="card__category">
										<a style="font-size:20px;">{$item->getPosto()}</a>
									</span>

									<div class="card__wrap">
										{if ($item->getProiezione()->getFilm()->getEtaConsigliata() != "")}
											<ul class="card__list">
												<li>{$item->getProiezione()->getFilm()->getEtaConsigliata()}</li>
											</ul>
										{/if}
									</div>

									<div class="card__description">
										<p>Biglietto #{$item->getId()} <br> Giorno {$item->getProiezione()->getData()} <br> Spettacolo delle {$item->getProiezione()->getOra()} <br> Sala {$item->getProiezione()->getSala()->getNumeroSala()} <br> Prezzo: {$item->getCosto()}€</p>
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
		<div class="col-12">
			<h2 class="section__title section__title--center">Totale: {$totale}€</h2>
		</div>
	</div>
	<!-- end catalog -->

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
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
<body class="body" {if (isset($status))}onload="result('{$status}')"{/if}>

{include file="header.tpl"}

{if ($isGet === true)}
<!-- content -->
<section class="content">
	<form><h2></h2></form>
	<div class="content__head">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<!-- content title -->
					<h2 class="content__title">Discover</h2>
					<!-- end content title -->

					<!-- authorization form -->
					<form action="{$path}Utente/loginNonRegistrato" method="POST" class="sign__form">
						<a href="/MagicBoulevardCinema" class="sign__logo">
							<img src="Smarty/img/logo.svg" alt="">
						</a>

						<div class="sign__group">
							<input name="email" type="text" value="{$email}" class="sign__input" placeholder="Email">
						</div>

						<div class="sign__group">
							<input name="password" type="password" class="sign__input" placeholder="Codice">
						</div>

						<button class="sign__btn" type="submit">Accedi</button>

						<span class="sign__text"><a href="{$path}Utente/forgotPassword">Password dimenticata?</a></span>
					</form>
					<!-- end authorization form -->
				</div>
			</div>
		</div>
	</div>
</section>
	{else}
	<!-- page title -->
	<section class="section section--first section--bg" data-bg="{$path}Smarty/img/section/section.jpg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section__wrap">
						<!-- section title -->
						<h2 class="section__title">I miei biglietti</h2>
						<!-- end section title -->

						<!-- breadcrumb-->
						<ul class="breadcrumb">
							<li class="breadcrumb__item"><a href="/MagicBoulevardCinema">Home</a></li>
							<li class="breadcrumb"><a href="">I miei biglietti</a></li>
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
								<p>Qui puoi osservare tutti i biglietti che hai acquistato presso il nostro cinema {$email} :)</p>
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
					{foreach $biglietti as $key => $item}
						<!-- card -->
						<div class="col-6 col-sm-12 col-lg-6">
							<div class="card card--list">
								<div class="row">
									<div class="col-12 col-sm-4">
										<div class="card__cover">
											<img src="{$immagini[$key]->getImmagineHTML()}" alt="">
										</div>
									</div>

									<div class="col-12 col-sm-8">
										<div class="card__content">
											<h3 class="card__title"><a href="{$path}Film/show/?film={$item->getProiezione()->getFilm()->getId()}">{$item->getProiezione()->getFilm()->getNome()}</a></h3>
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
												<p>Giorno {$item->getProiezione()->getData()} <br> Spettacolo delle {$item->getProiezione()->getOra()} <br> Sala {$item->getProiezione()->getSala()->getNumeroSala()} <br> Prezzo: {$item->getCosto()}€</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- end card -->
					{/foreach}
			</div>
		</div>
	</div>
	<!-- end catalog -->
{/if}
{include file="footer.tpl"}

<!-- Root element of PhotoSwipe. Must have class pswp. -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

	<!-- Background of PhotoSwipe.
    It's a separate element, as animating opacity is faster than rgba(). -->
	<div class="pswp__bg"></div>

	<!-- Slides wrapper with overflow:hidden. -->
	<div class="pswp__scroll-wrap">

		<!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
		<!-- don't modify these 3 pswp__item elements, data is added later on. -->
		<div class="pswp__container">
			<div class="pswp__item"></div>
			<div class="pswp__item"></div>
			<div class="pswp__item"></div>
		</div>

		<!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
		<div class="pswp__ui pswp__ui--hidden">

			<div class="pswp__top-bar">

				<!--  Controls are self-explanatory. Order can be changed. -->

				<div class="pswp__counter"></div>

				<button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

				<button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

				<!-- Preloader -->
				<div class="pswp__preloader">
					<div class="pswp__preloader__icn">
						<div class="pswp__preloader__cut">
							<div class="pswp__preloader__donut"></div>
						</div>
					</div>
				</div>
			</div>

			<button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>

			<button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>

			<div class="pswp__caption">
				<div class="pswp__caption__center"></div>
			</div>
		</div>
	</div>
</div>

<!-- JS -->
<script>
	function result(value){
		alert(value);
	}
	
	function control() {
		if($("#toBan").val().length < 6){
			alert("L'utente ha uno username di almeno 7 caratteri");
			return false;
		} else {
			return true;
		}
	}
</script>
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
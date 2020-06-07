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
<body class="body" {if (isset($status))}onload="result('{$status}')"{/if}>

<!-- header -->
<header class="header">
	<div class="header__wrap">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="header__content">
						<!-- header logo -->
						<a href="{$path}../../index.php" class="header__logo">
							<img src="{$path}../../Smarty/img/logo.svg" alt="">
						</a>
						<!-- end header logo -->

						<!-- header nav -->
						<ul class="header__nav">
							<!-- dropdown -->
							<li class="header__nav-item">
								<a class="dropdown-toggle header__nav-link" href="{$path}../../index.php" role="button" >Home</a>


							</li>
							<!-- end dropdown -->

							<!-- dropdown -->
							<li class="header__nav-item">
								<a class="dropdown-toggle header__nav-link" href="#" role="button" id="dropdownMenuCatalog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Catalogo</a>

								<ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuCatalog">
									<li><a href="{$path}../../Catalogo/prossimeUscite/">Prossime uscite</a></li>
									<li><a href="{$path}../../Catalogo/programmazioniPassate/">Programmazioni</a></li>
									<li><a href="{$path}../../Catalogo/piuApprezzati/">Film più apprezzati</a></li>
								</ul>
							</li>
							<!-- end dropdown -->

							<li class="header__nav-item">
								<a href="{$path}../../Informazioni/getCosti/" class="header__nav-link">Prezzi</a>
							</li>

							<li class="header__nav-item">
								<a href="{$path}../../Informazioni/getHelp/" class="header__nav-link">Aiuto</a>
							</li>

							<!-- dropdown -->
							<li class="dropdown header__nav-item">
								<a class="dropdown-toggle header__nav-link header__nav-link--more" href="#" role="button" id="dropdownMenuMore" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon ion-ios-more"></i></a>
								{if (!isset($utente))}
									<ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuMore">
										<li><a href="{$path}../../Informazioni/getAbout/">Su di noi</a></li>
										<li><a href="{$path}../../Utente/signup">Registrati</a></li>
										<li><a href="{$path}../../Utente/controlloBigliettiNonRegistrato/?">I miei biglietti</a></li>
									</ul>
								{else}
									<ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuMore">
										<li><a href="{$path}../../Informazioni/getAbout/">Su di noi</a></li>
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
										<li><a href="{$path}../../Utente/show/?id={$utente->getId()}">Il mio profilo</a></li>
										<li><a href="{$path}../../Admin/addFilm/?">Aggiungi film</a></li>
										<li><a href="">Gestione Proiezioni</a></li>
										<li><a href="{$path}../../Admin/gestioneUtenti">Gestione Utenti</a></li>
										<li><a href="{$path}../../Admin/modificaPrezzi/?">Gestione Prezzi</a></li>
										<li><a href="{$path}../../Utente/logout">Logout <i class="icon ion-ios-log-out"></i></a></li>
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
	<form action="{$path}../../Ricerca/cercaFilm" method= "POST" class="header__search">
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

<!-- content -->
<section class="content">
	<div class="content__head">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<!-- content title -->
					<h2 class="content__title">Discover</h2>
					<!-- end content title -->

					<!-- content tabs nav -->
					<ul class="nav nav-tabs content__tabs" id="content__tabs" role="tablist" style="margin-top: 50px">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Gestione sale</a>
						</li>

						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false">Aggiungi sala</a>
						</li>
					</ul>
					<!-- end content tabs nav -->

					<!-- content mobile tabs nav -->
					<div class="content__mobile-tabs" id="content__mobile-tabs">
						<div class="content__mobile-tabs-btn dropdown-toggle" role="navigation" id="mobile-tabs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<input type="button" value="Utenti bannati">
							<span></span>
						</div>

						<div class="content__mobile-tabs-menu dropdown-menu" aria-labelledby="mobile-tabs">
							<ul class="nav nav-tabs" role="tablist">
								<li class="nav-item"><a class="nav-link active" id="1-tab" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Gestione sale</a></li>

								<li class="nav-item"><a class="nav-link" id="2-tab" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false">Aggiungi sala</a></li>
							</ul>
						</div>
					</div>
					<!-- end content mobile tabs nav -->
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-8 col-xl-8" style="margin: auto">
				<!-- content tabs -->
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="1-tab">
						<div class="row">
							<!-- comments -->
							<div class="col-12">
								<div class="comments">
									<ul class="comments__list">
											<form action="{$path}../../Admin/gestioneSale" method="POST">
												<input type="hidden" name="id" value="1">
												{foreach $sale as $item}
													<div>
												<div class="col-12">
													<h2 class="section__title section__title--center">Sala {$item->getNumeroSala()}</h2>
												</div>
													<div class="sign__group sign__group--checkbox">
														<input id="remember{$item->getNumeroSala()}" name="sala{$item->getNumeroSala()}" type="checkbox" {if ($item->isDisponibile())} checked="checked" {else} {/if}>
														<label for="remember{$item->getNumeroSala()}">Disponibile</label>
													</div>
													</div>
												{/foreach}
										<button type="submit" style="margin: auto" class="form__btn align-content-center">Conferma</button>
											</form>
									</ul>
								</div>
							</div>
							<!-- end comments -->
						</div>
					</div>

					<div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="2-tab">
						<div class="row" style="align-content: center">
							<!-- reviews -->
									<form action="{$path}../../Admin/gestioneSale" method="POST" style="margin: auto" class="form" style="align-content: center">
										<input type="hidden" name="id" value="2">
										<input type="number" min="0" id="" class="form__input" name="sala" placeholder="Numero di Sala">
										<input type="number" min="0" id="" class="form__input" name="file" placeholder="Numero di file">
										<input type="number" min="0" id="" class="form__input" name="posti" placeholder="Numero di posti per fila">
										<div class="sign__group sign__group--checkbox">
											<input id="remember" name="disponibile" type="checkbox" checked="checked">
											<label for="remember">Disponibile</label>
										</div>
										<button type="submit" onclick="return control()" style="margin: auto" class="form__btn align-content-center">Aggiungi</button>
									</form>
								</div>
							</div>
							<!-- end reviews -->
						</div>
					</div>
				</div>
				<!-- end content tabs -->
			</div>
		</div>
	</div>
</section>
<!-- end content -->

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

	function isValid(name) {
		return (name !== "") ;
	}
	
	function control() {

		/*if(!isValid($("#sala").val())){
			alert("Devi inserire un numero di sala");
			return false;
		} else if (!isValid($("#file").val())) {
			alert("Devi inserire un numero di file");
			return false;
		}else if (!isValid($("#posti").val())) {
			alert("Devi inserire un numero di posti per fila");
			return false;
		}*/
		return true;
	}

</script>
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
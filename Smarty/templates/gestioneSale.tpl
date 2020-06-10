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
<body class="body" {if (isset($status))}onload="alert('{$status}')"{/if}>

{include file="{$path}Smarty/templates/header.tpl"}

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
							<a class="nav-link {if (!isset($nSala) && !isset($nPosti) && !isset($nFile))}active{/if}" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Gestione sale</a>
						</li>

						<li class="nav-item">
							<a class="nav-link {if (isset($nSala) || isset($nPosti) || isset($nFile))}active{/if}" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false">Aggiungi sala</a>
						</li>
					</ul>
					<!-- end content tabs nav -->

					<!-- content mobile tabs nav -->
					<div class="content__mobile-tabs" id="content__mobile-tabs">
						<div class="content__mobile-tabs-btn dropdown-toggle" role="navigation" id="mobile-tabs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<input type="button" value="Gestione sale">
							<span></span>
						</div>

						<div class="content__mobile-tabs-menu dropdown-menu" aria-labelledby="mobile-tabs">
							<ul class="nav nav-tabs" role="tablist">
								<li class="nav-item"><a class="nav-link {if (!isset($nSala) && !isset($nPosti) && !isset($nFile))}active{/if}" id="1-tab" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Gestione sale</a></li>

								<li class="nav-item"><a class="nav-link {if (isset($nSala) || isset($nPosti) || isset($nFile))}active{/if}" id="2-tab" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false">Aggiungi sala</a></li>
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
					<div class="tab-pane fade {if (!isset($nSala) && !isset($nPosti) && !isset($nFile))}show active{/if}" id="tab-1" role="tabpanel" aria-labelledby="1-tab">
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

					<div class="tab-pane fade {if (isset($nSala) || isset($nPosti) || isset($nFile))}show active{/if}" id="tab-2" role="tabpanel" aria-labelledby="2-tab">
						<div class="row" style="align-content: center">
							<!-- reviews -->
							<form action="{$path}../../Admin/gestioneSale" method="POST" style="margin: auto" class="form" style="align-content: center">
								<input type="hidden" name="id" value="2">
								<input type="number" min="1" id="sala" class="form__input" name="sala" {if (isset($nSala))}value="{$nSala}"{/if} placeholder="Numero di Sala">
								<input type="number" min="1" id="file" class="form__input" name="file" {if (isset($nFile))}value="{$nFile}"{/if} placeholder="Numero di file">
								<input type="number" min="1" id="posti" class="form__input" name="posti" {if (isset($nPosti))}value="{$nPosti}"{/if} placeholder="Numero di posti per fila">
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

		if(!isValid($("#sala").val())){
			alert("Devi inserire un numero di sala");
			return false;
		} else if (!isValid($("#file").val())) {
			alert("Devi inserire un numero di file");
			return false;
		}else if (!isValid($("#posti").val())) {
			alert("Devi inserire un numero di posti per fila");
			return false;
		}
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
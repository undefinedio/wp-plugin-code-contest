<div class="cc-wrapper">
	<div class="contest-image"
	     style="background-image: url(<?= $options['image']; ?>); background-size: cover; background-position: center top"></div>

	<section class="intro active">
		<h1><?= $options['intro_title']; ?></h1>

		<p><?= $options['intro_copy']; ?></p>

		<h2>Stap 1: Like ons op Facebook</h2>

		<div class="fb-like-box">
			<div class="fb-like" data-href="<?= $options['fb_page']; ?>" data-width="200px" data-layout="box_count"
			     data-action="like" data-show-faces="false" data-share="false"></div>
		</div>

		<h2>Stap 2: vul je code in:</h2>

		<form action="#" id="js-code-form">
			<input placeholder="Je code" type="text" class="js-code-input" value=""/>

			<p class="js-error error">&nbsp;</p>
			<input type="submit" value="Verzenden"/>

		</form>
	</section>

	<section class="form">
		<h1><?= $options['form_title']; ?></h1>

		<p><?= $options['form_copy']; ?></p>

		<form action="#" id="js-form">
			<input type="text" placeholder="Voornaam" class="required" value="" id="name"/>
			<input type="text" placeholder="Naam" class="required" value="" id="surname"/>
			<input type="email" placeholder="Email" class="required" value="" id="email"/>
			<input type="hidden" name="Code" value="" id="js-code-input">
			<input type="checkbox" name="accept" id="accept" value="true" class="js-checkbox-accept">
			<label for="accept">Ik accepteer de voorwaarden</label><br>
			<input type="checkbox" name="mailing" id="mailing" value="true" class="js-checkbox-mailing">
			<label for="mailing">Blijf op de hoogte van de laatste nieuwtjes</label><br>

			<p class="js-error-form error">&nbsp;</p>
			<input type="submit" value="Verzenden"/>
		</form>

	</section>
	<section class="thanks">
		<h1><?= $options['bedankt_title']; ?></h1>

		<p><?= $options['bedankt_copy']; ?></p>

		<div class="button js-share-fb">Share on FB</div>
	</section>
</div>

<div id="fb-root"></div>
<script>
	window.fbAsyncInit = function () {
		FB.init({
			appId: '<?= $options['fb_app_id']; ?>',
			xfbml: true,
			version: 'v2.2'
		});
	};

	(function (d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {
			return;
		}
		js = d.createElement(s);
		js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>
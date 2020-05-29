<?php

	require 'includes/initialise.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="icon" type="image/png" href="favicon.png">
	<title><?= $g->getSettings('site-name') ?></title>
	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta property="og:title" content="<?= $g->getSettings('site-name') ?>">
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?= $g->getSettings('site-url') ?>">
	<meta property="og:image" content="<?= $g->getSettings('site-image') ?>">
	<meta property="og:description" content="<?= $g->getSettings('site-description') ?>">

	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<!-- Styles -->
	<link rel="stylesheet" type="text/css" href="/styles/custom.php?v=<?= $g->getSettings('site-version') ?>">

	<!-- FontAwesome -->
	<script src="https://kit.fontawesome.com/129680e694.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

	<!-- Animate on Scroll -->
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

	<!-- Bootstrap Select Picker -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

	<!-- Bootstrap Switch Button -->
	<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

	<!-- Map -->
	<link rel="stylesheet" type="text/css" href="/map/style.css">

	<!-- Leaflet -->
	<link rel="stylesheet" type="text/css" href="https://unpkg.com/leaflet@1.1.0/dist/leaflet.css">
	<script src="https://unpkg.com/leaflet@1.1.0/dist/leaflet.js"></script>

	<!-- Leaflet Search -->
	<script src="/map/src/leaflet-search.js"></script>

	<!-- Leaflet Font Awesome Icons -->
	<link rel="stylesheet" type="text/css" href="/map/src/leaflet.awesome-markers.css">
	<script src="/map/src/leaflet.awesome-markers.js"></script>
</head>
<body id="top">
	<div class="wrapper">
	<?php
		require("templates/sidebar.php");
		echo '<div id="container">';
			require("includes/breadcrumbs.php");
			echo '<div class="container mt-5">';
				require("routes.php");
			echo '</div>';
			require("templates/footer.php");
	?>
		</div>
	</div>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){

			// Animate on Scroll Initiation
			AOS.init();

			// Select Picker Initiation
			$('.selectpicker').selectpicker();

		});
	</script>
</body>
</html>
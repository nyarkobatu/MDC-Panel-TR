<?php

	$json = json_decode(file_get_contents('db/generators.json'), true);

	$generatorsMDC = '';
	$generatorsLSPD = '';
	$generatorsLSSD = '';
	$generatorsLSDA = '';
	$generatorsJSA = '';

	foreach ($json as $generator) {

		$generatorTitle = $generator['title'];
		$generatorType = $generator['type'];
		$generatorLink = $generator['link'];
		$generatorTooltip = $generator['tooltip'];
		$generatorCard = $generator['card'];
		$generatorIconType = $generator['iconType'];
		$generatorIcon = $generator['icon'];

		if ($generatorIconType == "icon") {
			$generatorIcon = '<i class="fas fa-fw fa-5x fa-'.$generatorIcon.' text-muted"></i>';
		} elseif ($generatorIconType == "image") {
			$generatorIcon = '<img src="'.$generatorIcon.'" width="80px"/>';
		}

		$card = '<div class="grid-item">
					<div class="card card-panel" id="'.$generatorCard.'">
						<a href="'.$generatorLink.'"
							data-toggle="tooltip"
							data-html="true"
							data-placement="bottom"
							title="'.$generatorTooltip.'">
							<div class="card-body text-center">
								<p class="card-text">'.$generatorIcon.'</p>
								<h6 class="card-title mb-0">'.$generatorTitle.'</h6>
							</div>
						</a>
					</div>
				</div>';

		switch($generatorType) {

			case 'LSPD':
				$generatorsLSPD .= $card;
				break;
			case 'LSSD':
				$generatorsLSSD .= $card;
				break;
			case 'LSDA':
				$generatorsLSDA .= $card;
				break;
			case 'JSA':
				$generatorsJSA .= $card;
				break;
			case 'MDC':
			default:
				$generatorsMDC .= $card;
				break;

		}

	}

?>

<div class="container" data-aos="fade-out" data-aos-duration="500" data-aos-delay="250">
	<h1><i class="fas fa-fw fa-archive mr-2"></i>Evrak Oluşturucusu</h1>
	<hr>
	<h5>Mobile Data Computer</h5>
	<div class="grid" id="generators">
		<div class="grid-col grid-col--1"></div>
		<div class="grid-col grid-col--2"></div>
		<div class="grid-col grid-col--3"></div>
		<div class="grid-col grid-col--4"></div>
		<?= $generatorsMDC ?>
	</div>
	<h5>Los Santos Police Department</h5>
	<div class="grid" id="generators">
		<div class="grid-col grid-col--1"></div>
		<div class="grid-col grid-col--2"></div>
		<div class="grid-col grid-col--3"></div>
		<div class="grid-col grid-col--4"></div>
		<?= $generatorsLSPD ?>
	</div>
	<h5>Los Santos Sheriff's Department</h5>
	<div class="grid" id="generators">
		<div class="grid-col grid-col--1"></div>
		<div class="grid-col grid-col--2"></div>
		<div class="grid-col grid-col--3"></div>
		<div class="grid-col grid-col--4"></div>
		<?= $generatorsLSSD ?>
	</div>
	<h5>Los Santos District Attorney's Office</h5>
	<div class="grid" id="generators">
		<div class="grid-col grid-col--1"></div>
		<div class="grid-col grid-col--2"></div>
		<div class="grid-col grid-col--3"></div>
		<div class="grid-col grid-col--4"></div>
		<?= $generatorsLSDA ?>
	</div>
	<h5>Mahkeme Prosedürleri</h5>
	<div class="grid" id="generators">
		<div class="grid-col grid-col--1"></div>
		<div class="grid-col grid-col--2"></div>
		<div class="grid-col grid-col--3"></div>
		<div class="grid-col grid-col--4"></div>
		<?= $generatorsJSA ?>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('.grid').colcade({
			columns: '.grid-col',
			items: '.grid-item'
		});

		// Tooltips
		$('a').tooltip();

		// Hide Charges Table if Accessing Arrest Report Link Directly
		/*
		$('body').on('click', '#card-generators-arrest a', function(e) {

			e.preventDefault();

			$.ajax({
				url: '/controllers/form-processor.php',
				type: 'POST',
				data: {
					getType: 'setChargeTable'
				},
				success: function(response) {
					window.location.href = '/paperwork-generators/arrest-report';
				},
			});

		});
		*/

	});
</script>
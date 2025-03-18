<?php
if ($g->findCookie('notificationVersion') != $g->getSettings('site-version')) {
?>
<div id="notification">
	<div class="container">
		<i class="mr-1 fas fa-fw fa-plug"></i>Güncelleme
		<a class="mx-1" href="/changelogs#<?= $g->getSettings('site-version') ?>">
			<span class="badge badge-dark"><?= $g->getSettings('site-version') ?></span>
		</a>
		şimdi yayınladı!
		<a class="ml-3" id="notification-dissmiss"><span class="badge badge-trans p-2"><i class="fas fa-fw fa-times"></i></span></a>
	</div>
</div>
<?php
}
?>

<?php
if ($g->getSettings('special-notification') && ($g->findCookie('specialNotification') != $g->getSettings('special-notification'))) {
?>
<div id="special-notification">
	<div class="container">
		<i class="mr-1 fas fa-fw fa-bullhorn"></i><?= $g->getSettings('special-notification-msg') ?>
		<a class="ml-3" id="special-notification-dissmiss"><span class="badge badge-trans p-2"><i class="fas fa-fw fa-times"></i></span></a>
	</div>
</div>
<?php
}
?>
<script type="text/javascript">
	$(document).ready(function() {
		// Hide notification
		$('body').on('click', '#notification-dissmiss', function (e) {

			e.preventDefault();

			$.ajax({
				url: '/controllers/form-processor.php',
				type: 'POST',
				data: {
					getType: 'setNotificationVersion'
				},
				success: function(response) {
					$('#notification').css('transform', 'translateY(-48.5px)');
					$('#notification').css('opacity', '0');
					$('#breadcrumb').css('transform', 'translateY(-48.5px)');
					$('#footer').css('transform', 'translateY(-48.5px)');
				},
			});

		});

		// Hide special notification
		$('body').on('click', '#special-notification-dissmiss', function (e) {

			e.preventDefault();

			$.ajax({
				url: '/controllers/form-processor.php',
				type: 'POST',
				data: {
					getType: 'hideSpecialNotification'
				},
				success: function(response) {
					$('#special-notification').css('transform', 'translateY(-48.5px)');
					$('#special-notification').css('opacity', '0');
					$('#breadcrumb').css('transform', 'translateY(-48.5px)');
					$('#footer').css('transform', 'translateY(-48.5px)');
				},
			});

		});


	});
</script>
<div class="container" data-aos="fade-in" data-aos-duration="500" data-aos-delay="250">
	<h1 class="my-3"><i class="fas fa-fw fa-bug mr-2"></i>Fatal Error!</h1>
	<div class="container p-0">
		<h4>Hoppala! Burada olmaman gerekiyor, büyük bir hata oluştu.</h4>
		Lütfen <span class="text-golden" id="username"><?= $g->getSettings('site-discord-contact') ?></span> ile <span class="text-golden">Discord</span> üzerinden iletişime geç ve bunun nasıl başardığını anlat.
	</div>
	<div class="container mt-5 text-center">
		<a tabindex="0" class="btn btn-primary px-5" onclick="copy()" data-toggle="tooltip" title="Copied!">
			<i class="fas fa-copy fa-fw mr-2"></i>Discord Kullanıcı Adını Kopyala
		</a>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('a[data-toggle="tooltip"]').tooltip({
			delay: { "show": 100, "hide": 100 },
			animated: 'fade',
			placement: 'top',
			trigger: 'click'
		});
	});
	$(function () {
		$(document).on('shown.bs.tooltip', function (e) {
			setTimeout(function () {
				$(e.target).tooltip('hide');
			}, 500);
		});
	});
	function copy() {
		var range = document.createRange();
		range.selectNode(document.getElementById("username"));
		window.getSelection().removeAllRanges();
		window.getSelection().addRange(range);
		document.execCommand("copy");
		window.getSelection().removeAllRanges();
	}
</script>
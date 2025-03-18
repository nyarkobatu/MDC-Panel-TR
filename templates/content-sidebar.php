<nav id="sidebar">
	<div class="text-center my-3">
		<a class="d-block" id="sidebar-logo" href="/"><img alt="MDC Panel"/></a>
	</div>
	<?php
		if (!$g->findCookie('toggleClock')) {
			require_once('templates/content-clock.php');
		}
		if (!$g->findCookie('toggleLiveVisitorCounter')) {
			require_once('templates/content-visitors.php');
		}
	?>
	<ul class="list-unstyled components px-3">
		<li class="nav-item">
			<a class="nav-link" href="/">
				<i class="fas fa-fw fa-th-large mr-2"></i><span class="icon-text">Pano</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" target="_blank" rel="noopener noreferrer" href="<?= $g->getSettings('url-mdc') ?>">
				<i class="fas fa-fw fa-desktop mr-2"></i><span class="icon-text">Mobile Data Computer<i class="fas fa-fw fa-xs fa-ss fa-external-link-alt ml-2"></i></span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" target="_blank" rel="noopener noreferrer" href="<?= $g->getSettings('url-cad') ?>">
				<i class="fas fa-fw fa-headset mr-2"></i><span class="icon-text">Computer Aided Dispatch<i class="fas fa-fw fa-xs fa-ss fa-external-link-alt ml-2"></i></span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="/street-guide">
				<i class="fas fa-fw fa-map-marker-alt mr-2"></i><span class="icon-text">Harita Rehberi</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link dropdown-toggle" href="#generatorSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
				<i class="fas fa-fw fa-archive mr-2"></i><span class="icon-text">Evrak Oluşturucu</span>
			</a>
			<ul class="collapse list-unstyled" id="generatorSubmenu">
				<li>
					<a class="nav-link" href="/paperwork-generators/arrest-charges">
						<i class="fas fa-fw fa-gavel mr-2"></i><span class="icon-text">Arrest Charges Calculator</span>
					</a>
				</li>
				<li>
					<a class="nav-link" href="/paperwork-generators/arrest-report">
						<i class="fas fa-fw fa-landmark mr-2"></i><span class="icon-text">Tutuklama Raporu</span>
					</a>
				</li>
				<li>
					<a class="nav-link" href="/paperwork-generators/traffic-report">
						<i class="fas fa-fw fa-car mr-2"></i><span class="icon-text">Trafik Raporu</span>
					</a>
				</li>
				<li>
					<a class="nav-link" href="/paperwork-generators/impound-report">
						<i class="fas fa-fw fa-truck-pickup mr-2"></i><span class="icon-text">Araç Çekme Raporu</span>
					</a>
				</li>
				<li>
					<a class="nav-link" href="/paperwork-generators/parking-ticket">
						<i class="fas fa-fw fa-parking mr-2"></i><span class="icon-text">Park Cezası</span>
					</a>
				</li>
				<li>
					<a class="nav-link" href="/paperwork-generators/trespass-notice">
						<i class="fas fa-fw fa-clipboard mr-2"></i><span class="icon-text">Trespass Notice</span>
					</a>
				</li>
			</ul>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="/useful-resources">
				<i class="fas fa-fw fa-book mr-2"></i><span class="icon-text">Useful Resources</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" target="_blank" rel="noopener noreferrer" href="<?= $g->getSettings('url-bbcoderip') ?>">
				<img class="mr-2" src="/images/Logo-ReBB.png" alt="LSPD Logo" width="16px" style="margin-top: -4px" /><span class="icon-text">ReBB<i class="fas fa-fw fa-xs fa-ss fa-external-link-alt ml-2"></i></span>
			</a>
		</li>
		<hr class="my-3">
		<li class="nav-item">
			<a class="nav-link" target="_blank" rel="noopener noreferrer" href="<?= $g->getSettings('url-lspd') ?>">
				<img class="mr-2" src="/images/Logo-LSPD.png" alt="LSPD Logo" width="16px" style="margin-top: -4px" /><span class="icon-text">LSPD<i class="fas fa-fw fa-xs fa-ss fa-external-link-alt ml-2"></i></span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" target="_blank" rel="noopener noreferrer" href="<?= $g->getSettings('url-lssd') ?>">
				<img class="mr-2" src="/images/Logo-LSSD.png" alt="LSSD Logo" width="16px" style="margin-top: -4px" /><span class="icon-text">LSSD<i class="fas fa-fw fa-xs fa-ss fa-external-link-alt ml-2"></i></span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" target="_blank" rel="noopener noreferrer" href="<?= $g->getSettings('url-sfm') ?>">
				<img class="mr-2" src="/images/Logo-SANFIRE.png" alt="SANFIRE Logo" width="16px" style="margin-top: -4px" /><span class="icon-text">SANFIRE<i class="fas fa-fw fa-xs fa-ss fa-external-link-alt ml-2"></i></span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" target="_blank" rel="noopener noreferrer" href="<?= $g->getSettings('url-sasp') ?>">
				<img class="mr-2" src="/images/Logo-SASP.png" alt="SASP Logo" width="16px" style="margin-top: -4px" /><span class="icon-text">SASP<i class="fas fa-fw fa-xs fa-ss fa-external-link-alt ml-2"></i></span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" target="_blank" rel="noopener noreferrer" href="<?= $g->getSettings('url-sadcr') ?>">
				<img class="mr-2" src="/images/Logo-SADOC.png" alt="SADCR Logo" width="16px" style="margin-top: -4px" /><span class="icon-text">SADCR<i class="fas fa-fw fa-xs fa-ss fa-external-link-alt ml-2"></i></span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" target="_blank" rel="noopener noreferrer" href="<?= $g->getSettings('url-lsfd') ?>">
				<img class="mr-2" src="/images/Logo-LSFD.png" alt="LSFD Logo" width="16px" style="margin-top: -4px" /><span class="icon-text">LSFD<i class="fas fa-fw fa-xs fa-ss fa-external-link-alt ml-2"></i></span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" target="_blank" rel="noopener noreferrer" href="<?= $g->getSettings('url-lsda') ?>">
				<img class="mr-2" src="/images/Logo-LSDA.png" alt="LSDA Logo" width="16px" style="margin-top: -4px" /><span class="icon-text">LSDA<i class="fas fa-fw fa-xs fa-ss fa-external-link-alt ml-2"></i></span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" target="_blank" rel="noopener noreferrer" href="<?= $g->getSettings('url-st3fan') ?>">
				<img class="mr-2" src="/images/Logo-St3fan.png" alt="St3fan Logo" width="16px" style="margin-top: -4px" /><span class="icon-text">St3fan's Toolbox<i class="fas fa-fw fa-xs fa-ss fa-external-link-alt ml-2"></i></span>
			</a>
		</li>
		<hr class="my-3">
		<li class="nav-item">
			<a class="nav-link" href="/settings">
				<i class="fas fa-fw fa-cog mr-2"></i><span class="icon-text">Settings</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" target="_blank" rel="noopener noreferrer" href="<?= $g->getSettings('url-github') ?>">
				<i class="fab fa-fw fa-github mr-2"></i><span class="icon-text">Github<i class="fas fa-fw fa-xs fa-ss fa-external-link-alt ml-2"></i></span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" target="_blank" rel="noopener noreferrer" href="<?= $g->getSettings('url-discord') ?>">
				<i class="fab fa-fw fa-discord mr-2"></i><span class="icon-text">Discord<i class="fas fa-fw fa-xs fa-ss fa-external-link-alt ml-2"></i></span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="/changelogs#<?= $g->getSettings('site-version') ?>">
				<i class="fas fa-fw fa-plug mr-2"></i><span class="icon-text">Changelogs<span class="badge badge-danger ml-3"><?= $g->getSettings('site-version') ?></span></span>
			</a>
		</li>
	</ul>
</nav>

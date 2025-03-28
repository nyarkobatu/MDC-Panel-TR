<?php

	$array = '';

	if ($slots) {
		$array = '[]';
	}

	if(!isset($faction)) $faction = "all";

	$title = "Officer";

	if($faction == "LSSD") $title = "Deputy";

?>
<hr>
<h4 class="mb-2"><i class="fas fa-fw fa-user-shield mr-2"></i><?php echo $title; ?> Bölümü</h4>
<div class="form-row groupSlotOfficer">
	<?php
		// Form - Textfield - Officer's Name
		$c->form('textfield', 'forms', array(
			'size' => '4',
			'type' => 'text',
			'label' => '<label>Tam İsim</label>',
			'icon' => 'id-card',
			'class' => '',
			'id' => 'inputName',
			'name' => 'inputName'.$array,
			'value' => $g->findCookie('officerName'),
			'placeholder' => 'İsim Soyisim',
			'tooltip' => 'Officer - Tam İsim',
			'attributes' => 'required',
			'style' => ''
		));
		// Form - List - Officer's Rank
		$c->form('list', 'forms', array(
			'size' => '3',
			'label' => '<label>Rütbe</label>',
			'icon' => 'user-shield',
			'class' => 'selectpicker',
			'id' => 'inputRank',
			'name' => 'inputRank'.$array,
			'attributes' => 'required',
			'title' => 'Rütbe Seçin',
			'list' => $pg->rankChooser(1, $faction),
			'hint' => '',
			'hintClass' => ''
		));
		if ($badge) {
			// Form - Textfield - Officer's Badge
			$c->form('textfield', 'forms', array(
				'size' => '2',
				'type' => 'number',
				'label' => '<label>Rozet</label>',
				'icon' => 'shield-alt',
				'class' => '',
				'id' => 'inputBadge',
				'name' => 'inputBadge'.$array,
				'value' => $g->findCookie('officerBadge'),
				'placeholder' => '#####',
				'tooltip' => 'Officer - Rozet',
				'attributes' => 'required',
				'style' => 'text-transform: uppercase;'
			));
		}
		if ($slots) {
			// Form - Options Add - Officer
			$c->form('options', 'forms', array(
				'size' => '1',
				'label' => '<label>Ayarlar</label>',
				'action' => 'addOfficer',
				'colour' => 'success',
				'icon' => 'fa-plus-square',
				'text' => 'Slot'
			));
		}
	?>
</div>
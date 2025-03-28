<?php

	$array = '';

	if ($slots) {
		$array = '[]';
	}

?>
<hr>
<h4 class="mb-2"><i class="fas fa-fw fa-user-shield mr-2"></i>Dahil Olan Kimseler</h4>
<div class="form-row groupSlotPerson">
	<?php
		// Form - Textfield - Person's Name
		$c->form('textfield', 'forms', array(
			'size' => '4',
			'type' => 'text',
			'label' => '<label>Tam İsim</label>',
			'icon' => 'id-card',
			'class' => '',
			'id' => 'inputPersonName',
			'name' => 'inputPersonName'.$array,
			'value' => '',
			'placeholder' => 'İsim Soyisim',
			'tooltip' => 'Kişi - Tam İsim',
			'attributes' => 'required',
			'style' => ''
		));
		// Form - List - Classification
		$c->form('list', 'forms', array(
			'size' => '3',
			'label' => '<label>Sınıflandırma</label>',
			'icon' => 'user-shield',
			'class' => 'selectpicker',
			'id' => 'inputClassification',
			'name' => 'inputClassification'.$array,
			'attributes' => 'required',
			'title' => 'Sınıflandırma Seçin',
			'list' => $pg->pClassificationChooser(),
			'hint' => '',
			'hintClass' => ''
		));
		if ($detailed_info) {
			// Form - Textfield - Age
			$c->form('textfield', 'forms', array(
				'size' => '2',
				'type' => 'text',
				'label' => '<label>Yaş</label>',
				'icon' => 'calendar',
				'class' => '',
				'id' => 'inputDoB',
				'name' => 'inputDoB'.$array,
				'value' => '',
				'placeholder' => '##',
				'tooltip' => 'Numara Formatı',
				'attributes' => '',
				'style' => 'text-transform: uppercase;'
			));
			// Form - Textfield - Phone Number
			$c->form('textfield', 'forms', array(
				'size' => '3',
				'type' => 'number',
				'label' => '<label>Telefon Numarası</label>',
				'icon' => 'phone',
				'class' => '',
				'id' => 'inputPhone',
				'name' => 'inputPhone'.$array,
				'value' => '',
				'placeholder' => '#######',
				'tooltip' => 'Kişi - Telefon Numarası',
				'attributes' => '',
				'style' => 'text-transform: uppercase;'
			));
			// Form - Textfield - Residence
			$c->form('textfield', 'forms', array(
				'size' => '4',
				'type' => 'text',
				'label' => '<label>İkametgah</label>',
				'icon' => 'home',
				'class' => '',
				'id' => 'inputResidence',
				'name' => 'inputResidence'.$array,
				'value' => '',
				'placeholder' => '1000 Grove Street',
				'tooltip' => 'Kişi - İkametgah',
				'attributes' => '',
				'style' => ''
			));
		}
		if ($relation) {
			// Form - Textfield - Relation to Incident
			$c->form('textfield', 'forms', array(
				'size' => '4',
				'type' => 'text',
				'label' => '<label>Olay ile Bağlantısı</label>',
				'icon' => 'sticky-note',
				'class' => '',
				'id' => 'inputRelation',
				'name' => 'inputRelation'.$array,
				'value' => '',
				'placeholder' => 'Zanlı officera saldırdı.',
				'tooltip' => 'Kişi - Bağlantı',
				'attributes' => 'required',
				'style' => ''
			));
		}
		if ($slots) {
			// Form - Options Add - Person
			$c->form('options', 'forms', array(
				'size' => '1',
				'label' => '<label>Ayarlar</label>',
				'action' => 'addPerson',
				'colour' => 'success',
				'icon' => 'fa-plus-square',
				'text' => 'Slot'
			));
		}
	?>
</div>
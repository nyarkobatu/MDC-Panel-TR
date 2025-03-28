<div class="container copyGroupSlotPerson" style="display: none;">
	<?php
		// Form - Textfield - Person's Name
		$c->form('textfield', 'forms', array(
			'size' => '4',
			'type' => 'text',
			'label' => '<label>Tam İsim</label>',
			'icon' => 'id-card',
			'class' => '',
			'id' => 'inputPersonName',
			'name' => 'inputPersonName[]',
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
			'name' => 'inputClassification[]',
			'attributes' => 'required',
			'title' => 'Sınıflandırma Seçin',
			'list' => $pg->pClassificationChooser(),
			'hint' => '',
			'hintClass' => ''
		));
		// Form - Textfield - Age
		$c->form('textfield', 'forms', array(
			'size' => '2',
			'type' => 'text',
			'label' => '<label>Yaş</label>',
			'icon' => 'calendar',
			'class' => '',
			'id' => 'inputDoB',
			'name' => 'inputDoB[]',
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
			'name' => 'inputPhone[]',
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
			'name' => 'inputResidence[]',
			'value' => '',
			'placeholder' => '1000 Grove Street',
			'tooltip' => 'Kişi - İkametgah',
			'attributes' => '',
			'style' => ''
		));
		// Form - Textfield - Relation to Incident
		$c->form('textfield', 'forms', array(
			'size' => '4',
			'type' => 'text',
			'label' => '<label>Olay ile Bağlantısı</label>',
			'icon' => 'sticky-note',
			'class' => '',
			'id' => 'inputRelation',
			'name' => 'inputRelation[]',
			'value' => '',
			'placeholder' => 'Zanlı officera saldırdı.',
			'tooltip' => 'Kişi - Bağlantı',
			'attributes' => 'required',
			'style' => ''
		));
		// Form - Options - Remove Slot
		$c->form('options', 'forms', array(
			'size' => '1',
			'label' => '',
			'action' => 'removePerson',
			'colour' => 'danger',
			'icon' => 'fa-minus-square',
			'text' => 'Slot'
		));
	?>
</div>
<div class="container copyGroupSlotSuspect" style="display: none;">
	<?php
		// Form - Textfield - Person's Name
		$c->form('textfield', 'forms', array(
			'size' => '4',
			'type' => 'text',
			'label' => '<label>Tam İsim</label>',
			'icon' => 'id-card',
			'class' => '',
			'id' => 'inputSuspectName',
			'name' => 'inputSuspectName[]',
			'value' => '',
			'placeholder' => 'İsim Soyisim',
			'tooltip' => 'Kişi - Tam İsim',
			'attributes' => 'required',
			'style' => ''
		));
		// Form - List - Status
		$c->form('list', 'forms', array(
			'size' => '3',
			'label' => '<label>Durum</label>',
			'icon' => 'user-shield',
			'class' => 'selectpicker',
			'id' => 'inputSuspectStatus',
			'name' => 'inputSuspectStatus[]',
			'attributes' => 'required',
			'title' => 'Durum Seçin',
			'list' => $pg->sStatusChooser(),
			'hint' => '',
			'hintClass' => ''
		));
		// Form - Options - Remove Slot
		$c->form('options', 'forms', array(
			'size' => '1',
			'label' => '',
			'action' => 'removeSuspect',
			'colour' => 'danger',
			'icon' => 'fa-minus-square',
			'text' => 'Slot'
		));
	?>
</div>
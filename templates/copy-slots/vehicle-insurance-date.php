<div class="container copyGroupSlotInsurance" style="display: none;">
<?php
	// Form - Textfield - Insurance Expired Date
	$c->form('textfield', 'forms', array(
		'size' => '3 slotInsuranceDate',
		'type' => 'text',
		'label' => '<label>Sigorta Bitiş Tarihi</label>',
		'icon' => 'calendar',
		'class' => '',
		'id' => 'inputVehInsuranceDate',
		'name' => 'inputVehInsuranceDate',
		'value' => '',
		'placeholder' => 'GG/AAA/YYYY',
		'tooltip' => 'GG/AAA/YYYY Formatı',
		'attributes' => 'required',
		'style' => 'text-transform: uppercase;'
	));
	// Form - Textfield - Insurance Expired Time
	$c->form('textfield', 'forms', array(
		'size' => '2 slotInsuranceTime',
		'type' => 'text',
		'label' => '<label>Sigorta Bitiş Saati</label>',
		'icon' => 'clock',
		'class' => '',
		'id' => 'inputVehInsuranceTime',
		'name' => 'inputVehInsuranceTime',
		'value' => '',
		'placeholder' => '00:00',
		'tooltip' => '00:00 Formatı',
		'attributes' => 'required',
		'style' => 'text-transform: uppercase;'
	));
?>
</div>
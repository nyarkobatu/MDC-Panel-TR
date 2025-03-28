<hr>
<h4><i class="fas fa-fw fa-car mr-2"></i>Araç Detayları</h4>
<div class="form-row groupSlotRegistered">
<?php
	// Registration
	if ($registered) {
		// Form - Toggle - Registered
		$c->form('toggle', 'forms', array(
			'size' => '3',
			'label' => 'Kayıt Durumu',
			'class' => '',
			'attributes' => $registeredAttributes,
			'id' => 'inputVehRegistered',
			'name' => 'inputVehRegistered',
			'dataOff' => "<i class='mr-1 fas fa-fw fa-check-circle'></i>Kayıtlı",
			'dataOn' => "<i class='mr-1 fas fa-fw fa-times-circle'></i>Kayıtsız",
			'dataOffStyle' => 'success',
			'dataOnStyle' => 'danger',
			'dataWidth' => '100%',
			'dataHeight' => '38'
		));
	}
?>
</div>
<div class="form-row groupSlotInsurance">
<?php
	// Insurance
	if ($insurance) {
		// Form - Toggle - Insurance
		$c->form('toggle', 'forms', array(
			'size' => '3',
			'label' => 'Sigorta Durumu',
			'class' => '',
			'attributes' => '',
			'id' => 'inputVehInsurance',
			'name' => 'inputVehInsurance',
			'dataOff' => "<i class='mr-1 fas fa-fw fa-check-circle'></i>Sigortalı",
			'dataOn' => "<i class='mr-1 fas fa-fw fa-times-circle'></i>Sigortasız",
			'dataOffStyle' => 'success',
			'dataOnStyle' => 'danger',
			'dataWidth' => '100%',
			'dataHeight' => '38',
		));
	}
?>
</div>
<div class="form-row">
<?php
// Form - Datalist - Vehicle's Make & Model
$c->form('datalist', 'forms', array(
	'size' => '3',
	'label' => '<label>Marka & Model</label>',
	'icon' => 'car',
	'id' => 'inputVeh',
	'name' => 'inputVeh',
	'placeholder' => 'Marka & Model',
	'tooltip' => 'E.g: Benefactor Dubsta',
	'attributes' => 'required',
	'list' => 'vehicle_list',
	'listChooser' => $pg->listChooser('vehiclesList')
));
// Tints
if ($tints) {
	// Form - List - Vehicle's Tint Level
	$c->form('list', 'forms', array(
		'size' => '2',
		'label' => '<label>Cam Filmi Seviyesi</label>',
		'icon' => 'adjust',
		'class' => 'selectpicker',
		'id' => 'inputVehTint',
		'name' => 'inputVehTint',
		'attributes' => 'required',
		'title' => '',
		'list' => $pg->tintChooser(),
		'hint' => '',
		'hintClass' => ''
	));
}
?>
</div>
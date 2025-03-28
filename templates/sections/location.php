<hr>
<h4 class="mb-2"><i class="fas fa-fw fa-map-marked-alt mr-2"></i>Konum Detayları</h4>
<div class="form-row">
	<?php
		// Form - Datalist - District
		$c->form('datalist', 'forms', array(
			'size' => '4',
			'label' => '<label>Bölge</label>',
			'icon' => 'map-marked-alt',
			'id' => 'inputDistrict',
			'name' => 'inputDistrict',
			'placeholder' => 'Bölge',
			'tooltip' => 'Konum - Bölge',
			'attributes' => 'required',
			'list' => 'district_list',
			'listChooser' => $pg->listChooser('districtsList')
		));
		// Form - Datalist - Street Name
		$c->form('datalist', 'forms', array(
			'size' => '4',
			'label' => '<label>Sokak Adı</label>',
			'icon' => 'road',
			'id' => 'inputStreet',
			'name' => 'inputStreet',
			'placeholder' => 'Sokak Adı',
			'tooltip' => 'Bölge - Sokak Adı',
			'attributes' => 'required',
			'list' => 'street_list',
			'listChooser' => $pg->listChooser('streetsList')
		));
	?>
</div>
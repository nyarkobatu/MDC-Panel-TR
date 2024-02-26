<div class="container" data-aos="fade-in" data-aos-duration="500" data-aos-delay="250">
	<h1><i class="fas fa-fw fa-bolt mr-2"></i>SEB Incident Log</h1>
	<form action="/controllers/form-processor.php" method="POST">
		<input type="hidden" id="generatorType" name="generatorType" value="SEBIncidentLog">
		<h4 class="mb-2"><i class="fas fa-fw fa-clipboard mr-2"></i>Incident Information</h4>
		<div class="form-row">
			<?php
				// Form - Textfield - Date & Time
				$c->form('textfield', 'forms', array(
					'size' => '4',
					'type' => 'text',
					'label' => '<label>Date & Time</label>',
					'icon' => 'calendar',
					'class' => '',
					'id' => 'inputDateTime',
					'name' => 'inputDateTime',
					'value' => '',
					'placeholder' => 'DD/MMM/YYYY',
					'tooltip' => 'Date & Time - DD/MMM/YYYY',
					'attributes' => 'required',
					'style' => 'text-transform: uppercase;'
				));
				// Form - Textfield - Date & Time
				$c->form('textfield', 'forms', array(
					'size' => '4',
					'type' => 'text',
					'label' => '<label>SEB Activation Number</label>',
					'icon' => 'hashtag',
					'class' => '',
					'id' => 'inputActivationNumber',
					'name' => 'inputActivationNumber',
					'value' => '',
					'placeholder' => 'YY-NO (E.G. 22-001)',
					'tooltip' => 'YY-NO (E.G. 22-001)',
					'attributes' => 'required',
					'style' => 'text-transform: uppercase;'
				));
				// Form - Textfield - Incident Type
				$c->form('textfield', 'forms', array(
					'size' => '4',
					'type' => 'text',
					'label' => '<label>Type of Incident</label>',
					'icon' => 'font',
					'class' => '',
					'id' => 'inputIncidentType',
					'name' => 'inputIncidentType',
					'value' => '',
					'placeholder' => 'INCIDENT (E.G. 605B BARRICADED - 998)',
					'tooltip' => 'INCIDENT (E.G. 605B BARRICADED - 998)',
					'attributes' => 'required',
					'style' => 'text-transform: uppercase;'
				));
			?>
		</div>
		<div class="form-row">
			<?php
				// Form - Textfield - Station Requesting
				$c->form('textfield', 'forms', array(
					'size' => '4',
					'type' => 'text',
					'label' => '<label>Station / Unit Requesting</label>',
					'icon' => 'house-user',
					'class' => '',
					'id' => 'inputRequestingUnit',
					'name' => 'inputRequestingUnit',
					'value' => '',
					'placeholder' => 'UNIT or STATION (E.G. OSS or 60D)',
					'tooltip' => 'UNIT or STATION (E.G. OSS or 60D)',
					'attributes' => 'required',
					'style' => 'text-transform: uppercase;'
				));

				// Form - Textfield - Station Requesting
				$c->form('textfield', 'forms', array(
					'size' => '4',
					'type' => 'text',
					'label' => '<label>Authorized By</label>',
					'icon' => 'user-check',
					'class' => '',
					'id' => 'inputAuthorizedBy',
					'name' => 'inputAuthorizedBy',
					'value' => '',
					'placeholder' => 'SEB LT / SGT NAME',
					'tooltip' => 'SEB LT / SGT NAME',
					'attributes' => 'required',
					'style' => 'text-transform: uppercase;'
				));
			?>
		</div>
		<?php
			// Section - Location
			require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/sections/location.php';
		?>
        <hr>
		<h4 class="mb-2"><i class="fas fa-fw fa-clipboard mr-2"></i>Personnel</h4>
		<div class="form-row">
			<?php
				// Form - Textfield - Incident Commander
				$c->form('textfield', 'forms', array(
					'size' => '4',
					'type' => 'text',
					'label' => '<label>Incident Commander</label>',
					'icon' => 'user-tie',
					'class' => '',
					'id' => 'inputIncidentCommander',
					'name' => 'inputIncidentCommander',
					'value' => '',
					'placeholder' => 'Name Lastname',
					'tooltip' => 'Name Lastname - John Doe',
					'attributes' => '',
					'style' => ''
				));
				// Form - Textfield - Team Commander
				$c->form('textfield', 'forms', array(
					'size' => '4',
					'type' => 'text',
					'label' => '<label>Team Commander</label>',
					'icon' => 'user-shield',
					'class' => '',
					'id' => 'inputTeamCommander',
					'name' => 'inputTeamCommander',
					'value' => '',
					'placeholder' => 'Name Lastname',
					'tooltip' => 'Name Lastname - John Doe',
					'attributes' => '',
					'style' => ''
				));
				// Form - Textfield - Team Leader
				$c->form('textfield', 'forms', array(
					'size' => '4',
					'type' => 'text',
					'label' => '<label>Team Leader</label>',
					'icon' => 'user-cog',
					'class' => '',
					'id' => 'inputTeamLeader',
					'name' => 'inputTeamLeader',
					'value' => '',
					'placeholder' => 'Name Lastname',
					'tooltip' => 'Name Lastname - John Doe',
					'attributes' => 'required',
					'style' => ''
				));
			?>
		</div>
		<?php
			// Section - Officers
			$c->form('officer', 'sections', array(
				'g' => $g,
				'pg' => $pg,
				'c' => $c,
				'badge' => false,
				'slots' => true,
                'faction' => "LSSD"
			));
		?>
		<hr>
		<h4><i class="fas fa-fw fa-receipt mr-2"></i>Narrative</h4>
        <div class="form-row">
            <?php
                // Section - Officers
                $c->form('textbox', 'forms', array(
                    'size' => '12',
                    'label' => '<label>Incident Narrative & External References</label>',
                    'icon' => 'clipboard',
                    'id' => 'inputNarrative',
                    'name' => 'inputNarrative',
                    'rows' => '4',
                    'placeholder' => 'List as needed.',
                    'attributes' => 'required',
                    'hint' => 'Enter the detailed account of the incident in <strong>first person</strong> and in chronological order.'
                ));
            ?>
		</div>
		<?php
			// Form - Submit
			$c->form('submit', 'forms', array());
		?>
	</form>
</div>
<!-- COPY SLOTS -->
<?php
	// COPY SLOT - OFFICER
	require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/copy-slots/officer-nobadge.php';
?>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/form-footer.php'; ?>
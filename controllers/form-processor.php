<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/initialise.php';

$penal = $pg->penalCode();

// GET Types

if (isset($_REQUEST['getType'])) {

	$getType = $_REQUEST['getType'];

	if ($getType == 'getCrime') {

		$crimeID = $_REQUEST['crimeID'];

		$crime = $penal[$crimeID];
		$crimeClasses = $crime['class'];
		$crimeOffences = $crime['offence'];
		$outputClass = array();
		$outputOffence = array();
		$outputDrugSubstanceCategories = array();
		$classes = null;
		$offences = null;
		$categories = null;

		foreach ($crimeClasses as $crimeClass => $crimeClassBool) {
			$outputClass[] .= $crimeClassBool;
		}

		foreach ($crimeOffences as $crimeOffence => $crimeOffenceBool) {
			$outputOffence[] .= $crimeOffenceBool;
		}

		if (in_array($crimeID, $pg->chargesDrug) && $crime['drugs']) {
			$crimeDrugSubstanceCategories = $crime['drugs'];
			foreach ($crimeDrugSubstanceCategories as $crimeDrugSubstanceCategory => $crimeDrug) {
				$outputDrugSubstanceCategories[] .= $crimeDrug;
			}
			$categories = $pg->getCrimeDrugSubstanceCategory($outputDrugSubstanceCategories);
		}

		$classes = $pg->getCrimeClass2(array_reverse($outputClass));
		$offences = $pg->getCrimeOffence($outputOffence);

		echo json_encode(array($classes, $offences, $categories));
	}

	if ($getType == 'getUNIX') {

		echo $g->getUNIX($_REQUEST['typeUNIX']);
	}

	if ($getType == 'setNotificationVersion') {

		setCookiePost('notificationVersion', $g->getSettings('site-version'));
	}

	if ($getType == 'hideSpecialNotification') {

		setCookiePost('specialNotification', $g->getSettings('special-notification'));
	}

	/*
		if ($getType == 'setChargeTable') {

			$_SESSION['showGeneratedArrestChargeTables'] = false;

		}
		*/
}


if (isset($_POST['openStatus'])) {
	$guidelineDropdownStatus = $_POST['openStatus'] ?? 0;
	setCookiePost('openStatus', $guidelineDropdownStatus);
}

if (isset($_POST['openBailStatus'])) {
	$guidelineBailDropdownStatus = $_POST['openBailStatus'] ?? 0;
	setCookiePost('openBailStatus', $guidelineBailDropdownStatus);
}


// Generator Types

if (isset($_POST['generatorType'])) {

	// Initialise Constant Variables
	$generatorType = $_POST['generatorType'];
	$checked = '[cbc][/cbc]';
	$unchecked = '[cb][/cb]';

	// Default Values
	$defaultName = 'UNKNOWN NAME';
	$defaultSuspectName = 'UNKNOWN SUSPECT NAME';
	$defaultDistrict = 'UNKNOWN DISTRICT';
	$defaultStreet = 'UNKNOWN STREET';
	$defaultBuilding = 'UNKNOWN BUILDING';
	$defaultVehicle = 'UNKNOWN VEHICLE';
	$defaultVehiclePlate = 'UNKNOWN VEHICLE IDENTIFICATION PLATE';
	$defaultRegisteredOwner = 'UNKNOWN REGISTERED OWNER';

	// Common Post Values
	$postInputDate = $_POST['inputDate'] ?? $g->getUNIX('date');
	$postInputTime = $_POST['inputTime'] ?? $g->getUNIX('time');
	$postInputCallsign = $_POST['inputCallsign'] ?? 'N/A';
	$postInputName = $_POST['inputName'] ?? $defaultName;
	$postInputNameArray = $_POST['inputName'] ?? array();
	$postInputRank = $_POST['inputRank'] ?? 0;
	$postInputRankArray = $_POST['inputRank'] ?? array();
	$postInputBadge = $_POST['inputBadge'] ?? 0;
	$postInputBadgeArray = $_POST['inputBadge'] ?? array();
	$postInputDefName = $_POST['inputDefName'] ?? $defaultSuspectName;
	$postInputDistrict = $_POST['inputDistrict'] ?? $defaultDistrict;
	$postInputStreet = $_POST['inputStreet'] ?? $defaultStreet;
	$postInputBuilding = $_POST['inputBuilding'] ?? $defaultBuilding;
	$postInputVeh = $_POST['inputVeh'] ?? $defaultVehicle;
	$postInputVehPlate = $_POST['inputVehPlate'] ?? $defaultVehiclePlate;
	$postInputEvidenceImageArray = $_POST['inputEvidenceImage'] ?? array();
	$postInputEvidenceImageArray = array_values(array_filter($postInputEvidenceImageArray));
	$postInputVehRO = $_POST['inputVehRO'] ?? $defaultRegisteredOwner;


	// Session Variables
	$generatedReportType = '';
	$generatedReport = '';
	$generatedThreadURL = '';
	$generatedThreadTitle = '';
	$showGeneratedArrestChargeTables = false;
	$generatedArrestChargeList = '';
	$generatedArrestChargeTotals = '';


	if ($generatorType == 'ArrestChargesTest') {
		echo json_encode($pg->processCharges(), JSON_PRETTY_PRINT);
		die();
	}

	if ($generatorType == 'TrafficReport') {

		// Array Maps
		$postInputNameArray = arrayMap($_POST['inputName'], $defaultName);
		$postInputRankArray = arrayMap($_POST['inputRank'], 0);
		$postInputBadgeArray = arrayMap($_POST['inputBadge'], '');
		$inputCrime = arrayMap($_POST['inputCrime'], 'UNKNOWN CHARGE');
		$inputCrimeClass = arrayMap($_POST['inputCrimeClass'], 0);
		$inputCrimeFine = arrayMap($_POST['inputCrimeFine'], 0);

		// Variables
		$inputDefLicense = $_POST['inputDefLicense'] ?: 0;
		$inputNarrative = $_POST['inputNarrative'] ?: '';
		$inputDashcam = $_POST['inputDashcam'] ?: '';
		$inputVehRegistered = $_POST['inputVehRegistered'] ?: false;
		$inputVehRO = $_POST['inputVehRO'] ?: $postInputDefName;
		$inputVehTint = $_POST['inputVehTint'] ?? -1;
		$inputVehInsurance = $_POST['inputVehInsurance'] ?: false;
		$inputVehInsuranceDate = $_POST['inputVehInsuranceDate'] ?? $g->getUNIX('date');
		$inputVehInsuranceTime = $_POST['inputVehInsuranceTime'] ?? $g->getUNIX('time');

		// Cookies
		setCookiePost('callSign', $postInputCallsign);
		setCookiePost('officerNameArray', $postInputNameArray[0]);
		setCookiePost('officerRankArray', $postInputRankArray[0]);
		setCookiePost('officerBadgeArray', $postInputBadgeArray[0]);
		setCookiePost('defName', $postInputDefName);

		// Officer Resolver
		$officers = '';
		foreach ($postInputNameArray as $iOfficer => $officer) {
			$officers .= resolverOfficer($officer, $postInputRankArray[$iOfficer], $postInputBadgeArray[$iOfficer]);
		}

		// Vehicle Registered Resolver
		$registered = '';
		if (!$inputVehRegistered) {
			$registered = 'The vehicle was <strong>registered</strong> to ' . textBold(1, $inputVehRO) . ', with the identification plate reading ' . textBold(2, $postInputVehPlate) . '.<br>';
		} else {
			$registered = 'The vehicle was <strong>unregistered</strong> at the time of the traffic stop.<br>';
		}

		// Vehicle Insurance Resolver
		$insurance = '';
		if ($inputVehInsurance) {
			$insurance = 'The vehicle was uninsured at the time of the conducted traffic stop, having expired on the ' . textBold(2, $inputVehInsuranceDate) . ', ' . textBold(1, $inputVehInsuranceTime) . '.<br>';
		}

		// Crime Resolver
		$fines = '';
		foreach ($inputCrime as $iCrime => $crime) {
			$charge = $penal[$crime];
			$chargeTitle = $charge['charge'];
			$chargeType = $charge['type'];
			$chargeClass = '?';
			if (!empty($inputCrimeClass[$iCrime])) {
				$chargeClass = $pg->getCrimeClass($inputCrimeClass[$iCrime]);
			}
			if ($inputCrimeFine[$iCrime] == 0) {
				$fines .= '<li><strong class="style-underline chargeCopy" data-clipboard-target="#charge-' . $crime . '" data-toggle="tooltip" title="Copied!"><span id="charge-' . $crime . '">' . $pg->getCrimeColour($chargeType) . $chargeType . $chargeClass . ' ' . $crime . '. ' . $chargeTitle . '</strong></span></strong></li>';
			} else {
				$fines .= '<li><strong class="style-underline chargeCopy" data-clipboard-target="#charge-' . $crime . '" data-toggle="tooltip" title="Copied!"><span id="charge-' . $crime . '">' . $pg->getCrimeColour($chargeType) . $chargeType . $chargeClass . ' ' . $crime . '. ' . $chargeTitle . '</strong></span></strong> - <strong style="color: green!important;">$' . number_format($inputCrimeFine[$iCrime]) . '</strong> Para Cezası</li>';
			}
		}

		// Report Builder
		$redirectPath = redirectPath(1);
		$generatedReportType = 'Traffic Report';
		$generatedReport = $officers . 'under the call sign ' . textBold(2, $postInputCallsign) . ' on the ' . textBold(2, $postInputDate) . ', ' . textBold(1, $postInputTime) . '.<br>Conducted a traffic stop on a ' . textBold(1, $postInputVeh) . ', on ' . textBold(1, $postInputStreet) . ', ' . textBold(1, $postInputDistrict) . '.<br>' . $registered . $insurance . $pg->getVehicleTint($inputVehTint) . '<br>The driver was identified as ' . textBold(1, $postInputDefName) . ', possessing ' . $pg->getDefLicense($inputDefLicense) . '<br>' . $inputNarrative . '<br><br>Following charge(s) were issued:<ul>' . $fines . '</ul>' . $pg->getDashboardCamera($inputDashcam);
	}

	if ($generatorType == 'ArrestReport') {

		// Array Maps
		$postInputNameArray = arrayMap($_POST['inputName'], $defaultName);
		$postInputRankArray = arrayMap($_POST['inputRank'], 0);
		$postInputBadgeArray = arrayMap($_POST['inputBadge'], '');

		// Variables
		$inputNarrative = $_POST['inputNarrative'] ?: 'UNKNOWN NARRATIVE';
		$inputEvidence = $_POST['inputEvidence'] ?: '';
		$inputDashcam = $_POST['inputDashcam'] ?: '';
		$inputPrisonAssignment = $_POST['inputPrisonAssignment'] ?: 0;
		//$inputPlea = $_POST['inputPlea'] ?: 0;

		$suspectURL = str_replace(' ', '_', $postInputDefName);

		// Set Cookies
		setCookiePost('callSign', $postInputCallsign);
		setCookiePost('officerNameArray', $postInputNameArray[0]);
		setCookiePost('officerRankArray', $postInputRankArray[0]);
		setCookiePost('officerBadgeArray', $postInputBadgeArray[0]);
		setCookiePost('defName', $postInputDefName);
		setCookiePost('defNameURL', $postInputDefName);

		// Formatting
		$callsign = textBold(2, $postInputCallsign);
		$datetime = textBold(2, $postInputDate) . ', ' . textBold(1, $postInputTime);
		$suspect = textBold(1, $postInputDefName);
		$location = textBold(1, $postInputStreet) . ', ' . textBold(1, $postInputDistrict) . '.';

		// Officer Resolver
		$officers = '';
		foreach ($postInputNameArray as $iOfficer => $officer) {
			$officers .= resolverOfficer($officer, $postInputRankArray[$iOfficer], $postInputBadgeArray[$iOfficer]);
		}

		// Section Resolver
		$narrative = (empty($inputNarrative)) ? '' : '<br><br><u><strong>Arrest Narrative:</strong></u><br>' . nl2br($inputNarrative);
		$evidence = (empty($inputEvidence)) ? '' : '<br><br><u><strong>Supporting Evidence:</strong></u><br>' . nl2br($inputEvidence);
		$evidence2 = (empty($inputEvidence)) ? 'N/A' : '[b]Supporting Evidence[/b]: ' . ($inputEvidence);
		$dashboard = (empty($inputDashcam)) ? '' : '<br><br><u><strong>Dashboard Camera:</strong></u><br>' . $pg->getDashboardCamera($inputDashcam);

		// Processing Details Resolver
		$processingDetails = '';
		if ($inputPrisonAssignment != 0) {
			$processingDetails = '<u><strong>Processing Details:</strong></u><br><strong>' . $ar->getPrisonAssignment($inputPrisonAssignment) . '</strong>.';
		}
		$processingDetails = '<br><br>' . $processingDetails . '<br>';

		// Plea Resolver
		/*$plea = $ar->getPlea($inputPlea, $postInputDefName);
		$plea2 = $ar->getPleaRaw($inputPlea);
		$plea3 = $ar->getPleaRawShort($inputPlea);*/

		// Crime Resolver
		$charges = '';
		foreach ($arrestChargeList as $iCharge => $charge) {
			$charges .= '[*]' . strip_tags($charge);
		}

		// Report Builder
		$redirectPath = redirectPath(1);
		$generatedReportType = 'Arrest Report';
		$generatedReport = $officers . 'under the callsign ' . $callsign . ' on the ' . $datetime . '. Conducted an arrest on ' . $suspect . ', the apprehension took place on ' . $location . $narrative . $evidence . $dashboard . $processingDetails;
		$showGeneratedArrestChargeTables = $_SESSION['showGeneratedArrestChargeTables'];
		$generatedArrestChargeList = $_SESSION['generatedArrestChargeList'];
		$generatedArrestChargeTotals = $_SESSION['generatedArrestChargeTotals'];
	}

	if ($generatorType == 'DeathReport') {

		// Variables
		$inputDeathName = $_POST['inputDeathName'] ?: 'JOHN/JANE DOE';
		$inputDeathReason = $_POST['inputDeathReason'] ?: 'UNKNOWN CAUSE OF DEATH';
		$inputWitnessName = $_POST['inputWitnessName'] ?: array();
		$inputWitnessName = array_values(array_filter($inputWitnessName));
		$inputRespondingName = $_POST['inputRespondingName'] ?: 'UNKNOWN RESPONDING OFFICER';
		$inputRespondingRank = $_POST['inputRespondingRank'] ?: 0;
		$inputHandlingName = $_POST['inputHandlingName'] ?: 'N/A';
		$inputHandlingRank = $_POST['inputHandlingRank'] ?: 0;
		$inputCoronerName = $_POST['inputCoronerName'] ?: 'N/A';
		$inputCaseNumber = $_POST['inputCaseNumber'] ?: 'N/A';
		$inputRecord = $_POST['inputRecord'] ?: '#';
		$inputEvidenceBox = $_POST['inputEvidenceBox'] ?? array();
		$inputEvidenceBox = array_values(array_filter($inputEvidenceBox));

		// Witness Resolver
		$witnesses = 'N/A';
		if (!empty($inputWitnessName)) {

			$witnesses = '';
			$iWitnesses = count($inputWitnessName);

			if ($iWitnesses > 1) {
				$witnesses .= '[list]';
				foreach ($inputWitnessName as $witness) {
					$witnesses .= '[*]' . $witness;
				}
				$witnesses .= '[/list]';
			} else {
				foreach ($inputWitnessName as $witness) {
					$witnesses .= $witness;
				}
			}
		}

		// Evidence Resolver
		$evidenceImage = '';
		if (!empty($postInputEvidenceImageArray)) {

			$evidenceImage = '';
			foreach ($postInputEvidenceImageArray as $eImgID => $image) {
				$evidenceImageCount = $eImgID + 1;
				$evidenceImage .= '[altspoiler=EXHIBIT - Photograph #' . $evidenceImageCount . '][img]' . $image . '[/img][/altspoiler]';
			}
		}

		$evidenceBox = '';
		if (!empty($inputEvidenceBox)) {

			$evidenceBox = '';
			foreach ($inputEvidenceBox as $eBoxID => $box) {
				$evidenceBoxCount = $eBoxID + 1;
				$evidenceBox .= '[altspoiler=EXHIBIT - Description #' . $evidenceBoxCount . ']' . $box . '[/altspoiler]';
			}
		}

		// Report Builder
		$redirectPath = redirectPath(2);
		$generatedReportType = 'Death Report';
		$generatedThreadURL = 'https://lspd.gta.world/posting.php?mode=post&f=1356';
		$generatedThreadTitle = $inputDeathName . ' - ' . strtoupper($postInputDate) . ' - ' . $postInputStreet . ', ' . $postInputDistrict;
		$generatedReport = '
				[divbox2=white]
				[aligntable=right,0,0,15,0,0,transparent]LOS SANTOS POLICE DEPT.
				RECORDS AND INFORMATION ARCHIVES
				VESPUCCI POLICE HEADQUARTERS
				LOS SANTOS, SAN ANDREAS

				[/aligntable][aligntable=left,0,15,0,0,0,transparent][lspdlogo=130][/lspdlogo][/aligntable]
				[color=transparent]tt[/color]
				[color=transparent]tt[/color]
				[color=transparent]tt[/color]
				[hr][/hr]
				[b]1. GENERAL INFORMATION[/b]
				[hr][/hr]
				[list=none][b]NAME OF DECEASED:[/b] ' . $inputDeathName . '
				[b]TIME & DATE OF DEATH:[/b] ' . $postInputTime . ' - ' . strtoupper($postInputDate) . '
				[b]LOCATION OF DEATH:[/b] ' . $postInputStreet . ', ' . $postInputDistrict . '
				[b]APPARENT CAUSE OF DEATH:[/b] ' . $inputDeathReason . '
				[b]WITNESSES:[/b] ' . $witnesses . '[/list]
				[b]2. ADMINISTRATIVE INFORMATION[/b]
				[hr][/hr]
				[list=none][b]FIRST RESPONDING OFFICER:[/b] ' . $pg->getRank($inputRespondingRank) . ' ' . $inputRespondingName . '
				[b]HANDLING DETECTIVE/FORENSIC ANALYST:[/b] ' . $pg->getRank($inputHandlingRank) . ' ' . $inputHandlingName . '
				[b]HANDLING CORONER:[/b] ' . $inputCoronerName . '
				[b]CORONER CASE NUMBER:[/b] ' . $inputCaseNumber . '
				[b]RELEVANT MDC RECORDS:[/b] [url=' . $inputRecord . ']LINK[/url][/list]
				[b]3. EVIDENCE[/b]
				' . $evidenceImage . '
				' . $evidenceBox . '
				[hr][/hr]
				[/divbox2]';
		$generatedReport = str_replace('				', '', $generatedReport);
	}

	if ($generatorType == 'SEBIncidentLog') {

		// Variables
		$inputDateTime = strtoupper($_POST['inputDateTime']) ?: '';
		$inputActivationNumber = strtoupper($_POST['inputActivationNumber']) ?: '';
		$inputIncidentType = strtoupper($_POST['inputIncidentType']) ?: '';
		$inputRequestingUnit = strtoupper($_POST['inputRequestingUnit']) ?: '';
		$inputAuthorizedBy = strtoupper($_POST['inputAuthorizedBy']) ?: '';
	
		$inputIncidentCommander = $_POST['inputIncidentCommander'] ?: 'N/A';
		$inputTeamCommander = $_POST['inputTeamCommander'] ?: 'N/A';
		$inputTeamLeader = $_POST['inputTeamLeader'] ?: '';
	
		$inputNarrative = $_POST['inputNarrative'] ?: '';

		// Officer Resolver
		$officers = '';
		foreach ($postInputNameArray as $iOfficer => $officer) {
			$officers .= resolverOfficerList($officer, $postInputRankArray[$iOfficer]);
		}

	
		// Report Builder
		$redirectPath = redirectPath(2);
		$generatedReportType = 'SEB Incident Log';
		$generatedThreadURL = 'https://lssd.gta.world/viewforum.php?f=456';
		$generatedThreadTitle = '[IL#'. $inputActivationNumber .'] ' . strtoupper($postInputStreet) . ', ' . $inputIncidentType;
		$generatedReport = '
	[hr][/hr]
	[center][b][size=125]LOS SANTOS COUNTY SHERIFF\'S DEPARTMENT
	SPECIAL ENFORCEMENT BUREAU[/size][/b]
	[size=110]SPECIAL WEAPONS TEAM INCIDENT LOG[/size][/center]
	[hr][/hr]
	[divbox=black][color=white][b][center]INCIDENT INFORMATION[/center][/b][/color][/divbox]
	[table=Arial][tr]
	[td][b]DATE & TIME:[/b][/td]
	[td][b]S.E.B. ACTIVATION NO.:[/b][/td]
	[td][b]LOCATION:[/b][/td]
	[/tr]
	[tr]
	[td]' . $inputDateTime . '[/td]
	[td]' . $inputActivationNumber . '[/td]
	[td]' . strtoupper($postInputStreet) . ', ' . strtoupper($postInputDistrict) . '[/td]
	[/tr]
	[tr]
	[td][b]TYPE OF INCIDENT:[/b][/td]
	[td][b]STATION/UNIT REQUESTING:[/b][/td]
	[td][b]AUTHORIZED BY:[/b][/td]
	[/tr]
	[tr]
	[td]' . $inputIncidentType . '[/td]
	[td]' . $inputRequestingUnit . '[/td]
	[td]' . $inputAuthorizedBy . '[/td]
	[/tr][/table]
	
	[divbox=black][color=white][b][center]PERSONNEL[/center][/b][/color][/divbox]
	[divbox=white][center][size=85][b]PERSONNEL LOG[/b][/size][/center]
	[size=85][u][b]FIELD/SEB COMMAND[/b][/u]
	[list]
	[*][b]Incident Commander:[/b] ' . $inputIncidentCommander . '
	[*][b]Team Commander:[/b] ' . $inputTeamCommander . '
	[*][b]Team Leader:[/b] ' . $inputTeamLeader . '
	[/list]
	[u][b]RESPONDING PERSONNEL[/b][/u]
	[list]' . $officers . '[/list][/size]
	[/divbox]
	
	[divbox=black][color=white][b][center]NARRATIVE[/center][/b][/color][/divbox]
	[divbox=white][center][size=85][b]INCIDENT NARRATIVE & EXTERNAL REFERENCES[/b][/size][/center]
	[size=85]' . $inputNarrative . '[/size][/divbox]
		';
		$generatedReport = str_replace('	', '', $generatedReport);
	}	

	if ($generatorType == 'IncidentReport') {

		// Variables
		$inputPersonName = $_POST['inputPersonName'] ?: array();
		$inputPersonName = array_values(array_filter($inputPersonName));
		$inputClassification = $_POST['inputClassification'] ?: array();
		$inputClassification = array_values(array_filter($inputClassification));
		$inputClassificationArray = arrayMap($_POST['inputClassification'], 0);
		$inputDoB = $_POST['inputDoB'] ?: array();
		$inputDoB = array_values(array_filter($inputDoB));
		$inputPhone = $_POST['inputPhone'] ?: array();
		$inputPhone = array_values(array_filter($inputPhone));
		$inputResidence = $_POST['inputResidence'] ?: array();
		$inputResidence = array_values(array_filter($inputResidence));
		$inputRelation = $_POST['inputRelation'] ?: array();
		$inputRelation = array_values(array_filter($inputRelation));
		$inputEvidenceBox = $_POST['inputEvidenceBox'] ?? array();
		$inputEvidenceBox = array_values(array_filter($inputEvidenceBox));
		$inputNarrative = $_POST['inputNarrative'] ?: '';
		$inputIncidentTitle = $_POST['inputIncidentTitle'] ?: '';
		$inputReportingDistrict = $_POST['inputReportingDistrict'];
		$inputCrime = arrayMap($_POST['inputCrime'], 'UNKNOWN CHARGE');
		$inputCrimeClass = arrayMap($_POST['inputCrimeClass'], 0);

		// Set Cookies
		setCookiePost('callSign', $postInputCallsign);
		setCookiePost('officerNameArray', $postInputNameArray[0]);
		setCookiePost('officerRankArray', $postInputRankArray[0]);
		setCookiePost('defName', $postInputDefName);
		setCookiePost('defNameURL', $postInputDefName);

		// Officer Resolver
		$officers = '';
		foreach ($postInputNameArray as $iOfficer => $officer) {
			$officers .= resolverOfficerBB($officer, $postInputRankArray[$iOfficer]);
		}

		// Get rid of comma at the end
		$officers = substr($officers, 0, -2);

		// Person Resolver
		$persons = '';
		$index = 0;
		if (!empty($inputPersonName)) {
			foreach ($inputPersonName as $indPerson => $person) {
				/*$inputPhone[$indPerson] = $inputPhone[$indPerson] ?: 'UNK';
				$inputDoB[$indPerson] = $inputPhone[$indPerson] ?: 'UNK';
				$inputResidence[$indPerson] = $inputPhone[$indPerson] ?: 'UNK';*/
				$persons .= "[u]Person #" .	$index + 1	. ' - ' . $person . '[/u]
[b]Classification:[/b] ' . $pg->getClassification($inputClassificationArray[$indPerson]) . '
[b]Age:[/b] ' . $inputDoB[$indPerson] . '
[b]Phone Number:[/b] ' . $inputPhone[$indPerson] . '
[b]Residence:[/b] ' . $inputResidence[$indPerson] . '
[b]Relation to Incident:[/b] ' . $inputRelation[$indPerson] . '

';
				$index++;
			}
		}

		// Evidence Resolver
		$evidenceImage = '';
		if (!empty($postInputEvidenceImageArray)) {

			$evidenceImage = '';
			foreach ($postInputEvidenceImageArray as $eImgID => $image) {
				$evidenceImageCount = $eImgID + 1;
				$evidenceImage .= '[altspoiler="EXHIBIT Photograph ' . $evidenceImageCount . '"][img]' . $image . '[/img][/altspoiler]';
			}
		}

		$evidenceBox = '';
		if (!empty($inputEvidenceBox)) {

			$evidenceBox = '';
			foreach ($inputEvidenceBox as $eBoxID => $box) {
				$evidenceBoxCount = $eBoxID + 1;
				$evidenceBox .= '[altspoiler="EXHIBIT Description ' . $evidenceBoxCount . '"]' . $box . '[/altspoiler]';
			}
		}

		if ($evidenceImage == '' && $evidenceBox == '') {
			$evidenceImage = 'No Evidence Submitted.';
		}

		// Crime Resolver
		$charges = '';
		foreach ($inputCrime as $iCrime => $crime) {
			$charge = $penal[$crime];
			$chargeTitle = $charge['charge'];
			$chargeType = $charge['type'];
			$chargeClass = '?';
			if (!empty($inputCrimeClass[$iCrime])) {
				$chargeClass = $pg->getCrimeClass($inputCrimeClass[$iCrime]);
			}
			$charges .= $chargeType . $chargeClass . ' ' . $crime . '. ' . $chargeTitle . ', ';
		}

		// Get rid of comma at the end
		$charges = substr($charges, 0, -2);

		// Report Builder
		$redirectPath = redirectPath(2);
		$generatedReportType = 'Incident Report';
		$generatedThreadURL = 'https://lssd.gta.world/posting.php?mode=post&f=1188';
		$generatedThreadTitle = '[IR] ' . $inputIncidentTitle . ', ' . $pg->getSheriffsReportingDistrict($inputReportingDistrict) . ' - ' . strtoupper($postInputDate);
		$generatedReport = '
[font=Arial][color=black]

[center][img]https://i.imgur.com/LEWTXbL.png[/img]

[size=125][b]SHERIFF\'S DEPARTMENT
COUNTY OF LOS SANTOS[/b]
[i]"A Tradition of Service Since 1850"[/i][/size]

[size=110][u]INCIDENT REPORT[/u][/size][/center][hr][/hr]

[font=arial][color=black][indent][size=105][b]Filing Information[/b][/size]

[indent]
[b]Time & Date:[/b] ' . $postInputTime . ', ' . strtoupper($postInputDate) . '
[b]Penal Code:[/b] '. $charges .'
[b]Location:[/b] ' . $postInputStreet . ', ' . $postInputDistrict . '

[b]Filed By:[/b] ' . $officers . '
[b]Unit Number:[/b] ' . $postInputCallsign . '
[/indent]

[size=105][b]Involved Persons[/b][/size]
[indent]' . $persons . '[/indent]
[size=105][b]Narrative[/b][/size]
[indent]' . $inputNarrative . '[/indent]

[size=105][b]Evidence[/b][/size]
' . $evidenceBox . '
' . $evidenceImage;
		$generatedReport = str_replace('				', '', $generatedReport);
	}

	if ($generatorType == 'UOFReport') {

		// Variables
		$inputSuspectName = $_POST['inputSuspectName'] ?: array();
		$inputSuspectName = array_values(array_filter($inputSuspectName));
		$inputSuspectStatus = $_POST['inputSuspectStatus'] ?: array();
		$inputSuspectStatus = array_values(array_filter($inputSuspectStatus));
		$inputSuspectStatusArray = arrayMap($_POST['inputSuspectStatus'], 0);
		$inputEvidenceBox = $_POST['inputEvidenceBox'] ?? array();
		$inputEvidenceBox = array_values(array_filter($inputEvidenceBox));
		$inputNarrative = $_POST['inputNarrative'] ?: '';

		// Set Cookies
		setCookiePost('callSign', $postInputCallsign);
		setCookiePost('officerNameArray', $postInputNameArray[0]);
		setCookiePost('officerRankArray', $postInputRankArray[0]);
		setCookiePost('officerBadgeArray', $postInputBadgeArray[0]);
		setCookiePost('defName', $postInputDefName);
		setCookiePost('defNameURL', $postInputDefName);

		// Officer Resolver
		$officers = '';
		foreach ($postInputNameArray as $iOfficer => $officer) {
			$officers .= resolverOfficerBB($officer, $postInputRankArray[$iOfficer], $postInputBadgeArray[$iOfficer]);
		}

		// Person Resolver
		$suspects = 'Unknown';
		if (!empty($inputSuspectName)) {

			foreach ($inputSuspectName as $indSuspect => $suspect) {
				$suspects .= '[indent][u]Person #1 - ' . $inputSuspectName[$indSuspect] . '[/u]
[b]Status:[/b] ' . $pg->getStatus($inputSuspectStatusArray[$indSuspect]) . '[/indent]

';
				$index++;
			}
		}

		// Evidence Resolver
		$evidenceImage = '';
		if (!empty($postInputEvidenceImageArray)) {

			$evidenceImage = '';
			foreach ($postInputEvidenceImageArray as $eImgID => $image) {
				$evidenceImageCount = $eImgID + 1;
				$evidenceImage .= '[altspoiler="EXHIBIT - Photograph #' . $evidenceImageCount . '"][img]' . $image . '[/img][/altspoiler]';
			}
		}

		$evidenceBox = '';
		if (!empty($inputEvidenceBox)) {

			$evidenceBox = '';
			foreach ($inputEvidenceBox as $eBoxID => $box) {
				$evidenceBoxCount = $eBoxID + 1;
				$evidenceBox .= '[altspoiler="EXHIBIT - Description #' . $evidenceBoxCount . '"]' . $box . '[/altspoiler]';
			}
		}

		if ($evidenceImage == '' && $evidenceBox == '') {
			$evidenceImage = 'No Evidence Submitted.';
		}

		// Report Builder
		$redirectPath = redirectPath(2);
		$generatedReportType = 'Use of Force Report';
		$generatedThreadURL = 'https://lssd.gta.world/posting.php?mode=post&f=469';
		$generatedThreadTitle = 'UOF - ' . $postInputStreet . ', ' . $postInputDistrict . ' - ' . strtoupper($postInputDate);
		$generatedReport = '
[font=Arial][color=black]

[center][img]https://i.imgur.com/LEWTXbL.png[/img]

[size=125][b]SHERIFF\'S DEPARTMENT
COUNTY OF LOS SANTOS[/b]
[i]"A Tradition of Service Since 1850"[/i][/size]

[size=110][u]USE OF FORCE REPORT[/u][/size][/center][hr][/hr]

[font=arial][color=black][indent][size=105][b]Filing Information[/b][/size]

[indent]
[b]Time & Date:[/b] ' . $postInputTime . ', ' . strtoupper($postInputDate) . '
[b]Location:[/b] ' . $postInputStreet . ', ' . $postInputDistrict . '

[b]Filed By:[/b] ' . $pg->getRank($postInputRankArray[0]) . ' ' . $postInputNameArray[0] . '
[b]Unit Number:[/b] ' . $postInputCallsign . '
[/indent]

[size=105][b]Suspects[/b][/size]
' . $suspects . '[size=105][b]Employees Involved (Only include employees who used lethal force)[/b][/size]
[list]' . $officers . '[/list]

[size=105][b]Narrative[/b][/size]
[indent]' . $inputNarrative . '[/indent]

[size=105][b]Evidence[/b][/size]
' . $evidenceBox . '
' . $evidenceImage;
		$generatedReport = str_replace('				', '', $generatedReport);
	}

	if ($generatorType == 'TrafficDivisionPatrolReport') {

		// Variables
		$inputDateFrom = $_POST['inputDateFrom'] ?: $g->getUNIX('date');
		$inputDateTo = $_POST['inputDateTo'] ?: $g->getUNIX('date');
		$inputTimeFrom = $_POST['inputTimeFrom'] ?: $g->getUNIX('time');
		$inputTimeTo = $_POST['inputTimeTo'] ?: $g->getUNIX('time');
		$inputPatrolVehicle = $_POST['inputPatrolVehicle'] ?: false;
		$inputVehicleModel = $_POST['inputVehicleModel'] ?? $defaultVehicle;
		$inputTrafficStops = $_POST['inputTrafficStops'] ?: '0';
		$inputCitations = $_POST['inputCitations'] ?: '0';
		$inputVehicleImpounds = $_POST['inputVehicleImpounds'] ?: '0';
		$inputTrafficAssists = $_POST['inputTrafficAssists'] ?: '0';
		$inputTrafficInvestigations = $_POST['inputTrafficInvestigations'] ?: '0';
		$inputEnforcementSpeed = $_POST['inputEnforcementSpeed'] ?: false;
		$inputEnforcementParking = $_POST['inputEnforcementParking'] ?: false;
		$inputEnforcementRegistration = $_POST['inputEnforcementRegistration'] ?: false;
		$inputEnforcementMoving = $_POST['inputEnforcementMoving'] ?: false;

		$inputNotes = $_POST['inputNotes'] ?: 'N/A';
		$inputTDPatrolReportURL = $_POST['inputTDPatrolReportURL'] ?: 'https://lspd.gta.world/viewforum.php?f=101';

		// Set Cookies
		setCookiePost('inputTDPatrolReportURL', $inputTDPatrolReportURL);

		// Patrol Vehicle Resolver
		$patrolVehicle = '';
		if (!$inputPatrolVehicle) {
			$patrolVehicle = '[*]Marked: [cbc][/cbc]';
		} else {
			$patrolVehicle = '[*]Unmarked: [cbc][/cbc] - Model: ' . $inputVehicleModel;
		}

		// Counts Resolver
		$trafficStopCount = (empty($inputTrafficStops)) ? 0 : $inputTrafficStops;
		$citationCount = (empty($inputCitations)) ? 0 : $inputCitations;

		// Enforcement Resolver
		$enforcementSpeed = (empty($inputEnforcementSpeed)) ? $unchecked : $checked;
		$enforcementParking = (empty($inputEnforcementParking)) ? $unchecked : $checked;
		$enforcementMoving = (empty($inputEnforcementMoving)) ? $unchecked : $checked;
		$enforcementRegistration = (empty($inputEnforcementRegistration)) ? $unchecked : $checked;

		// Report Builder
		$redirectPath = redirectPath(2);
		$generatedReportType = 'Traffic Division: Patrol Report';
		$generatedThreadURL = $inputTDPatrolReportURL;
		$generatedReport = '
				[divbox2=#f7f7f7]
				[center][tedlogo=175][/tedlogo]
				[hr][/hr]
				[img]https://i.imgur.com/7njmZU1.png[/img][size=130] [b]LOS SANTOS POLICE DEPARTMENT[/b][/size][img]https://i.imgur.com/7njmZU1.png[/img]
				[size=100][b]Traffic Division[/b][/size]
				[size=85][color=#012B47][b]TRAFFIC PATROL REPORT[/b][/color][/size][/center]
				[hr][/hr]
				[b]Date:[/b] ' . strtoupper($pg->dateResolver($inputDateFrom, $inputDateTo)) . '
				[b]Time:[/b] ' . $inputTimeFrom . ' - ' . $inputTimeTo . '

				[b]Type of patrol vehicle:[/b]
				[list=circle]' . $patrolVehicle . '[/list]

				[b]Traffic Stops:[/b] ' . $trafficStopCount . '
				[b]Citations Issued:[/b] ' . $citationCount . '
				[b]Vehicles Impounded:[/b] ' . $inputVehicleImpounds . '
				[b]Traffic Assists:[/b] ' . $inputTrafficAssists . '
				[b]Traffic Investigations:[/b] ' . $inputTrafficInvestigations . '

				[b]Targeted Enforcement Undertaken:[/b][list][*]' . $enforcementSpeed . ' SPEED
				[*]' . $enforcementParking . ' PARKING
				[*]' . $enforcementMoving . ' MOVING VIOLATIONS
				[*]' . $enforcementRegistration . ' REGISTRATION[/list]
				[b]Location Enforcement Undertaken[/b]: ' . $postInputDistrict . '

				[b]Notes (Optional):[/b] ' . $inputNotes . '
				[/divbox2]';
		$generatedReport = str_replace('				', '', $generatedReport);
	}

	if ($generatorType == 'ArrestCharges') {

		// Variables
		$redirectPath = redirectPath(3);
		$rowBuilder = '';
		$rowBuilderTotals = '';

		if (isset($_POST['inputCrime'])) {

			$charges = $_POST['inputCrime'];

			$multiDimensionalCrimeTimes = [412];
			$bailArray = [];
			$bailCost = [];
			// Charge List Builder
			foreach ($charges as $iCharge => $charge) {

				// Charge Base
				$charge = $penal[$charge];
				$chargeID = $charge['id'];
				$chargeName = $charge['charge'];
				$chargeOffence = $_POST['inputCrimeOffence'][$iCharge] ?? 1;
				$chargeAddition = $_POST['inputCrimeAddition'][$iCharge];
				$chargeSubstanceCategory = $_POST['inputCrimeSubstanceCategory'][$iCharge];

				if (in_array($chargeID, $pg->chargesDrug)) {
					$chargeFine[] = $charge['fine'][$chargeSubstanceCategory];
					$chargeFineFull = '$' . number_format($chargeFine[$iCharge]);
					$drugChargeTitle = ' (Category ' . $chargeSubstanceCategory . ')';
				} else {
					$chargeFine[] = $charge['fine'][$chargeOffence];
					$chargeFineFull = '$' . number_format($chargeFine[$iCharge]);
					$drugChargeTitle = null;
				}

				// Charge Sentencing Additions
				switch ($chargeAddition) {
					case 3:
						$chargeReduction = 2;
						$chargeMultiplyPoints = 1;
						break;
					case 4:
						$chargeReduction = 4;
						$chargeMultiplyPoints = 1;
						break;
					case 5:
						$chargeReduction = 2;
						$chargeMultiplyPoints = 1;
						break;
					case 6:
						$chargeReduction = 4;
						$chargeMultiplyPoints = 1;
						break;
					case 7:
						$chargeReduction = 1;
						$chargeMultiplyPoints = 4;
						break;
					default:
						$chargeReduction = 1;
						$chargeMultiplyPoints = 1;
				}

				// Charge Type Builder
				$chargeType = $charge['type'];
				$chargeTypeFull = '';

				// Charge Class Builder
				$chargeClass = $_POST['inputCrimeClass'][$iCharge];

				switch ($chargeClass) {
					case 1:
						$chargeClass = 'C';
						break;
					case 2:
						$chargeClass = 'B';
						break;
					case 3:
						$chargeClass = 'A';
						break;
					default:
						$chargeClass = '?';
						break;
				}

				switch ($chargeType) {
					case 'F':
						$chargeTypeFull = '<strong class="text-danger">Felony</strong>';
						break;
					case 'M':
						$chargeTypeFull = '<strong class="text-warning">Misdemeanor</strong>';
						break;
					case 'I':
						$chargeTypeFull = '<strong class="text-success">Infraction</strong>';
						break;
					default:
						$chargeTypeFull = '<strong class="text-danger">UNKNOWN</strong>';
						break;
				}

				// Points Builder
				$chargePoints[] = ceil($charge['points'][$chargeClass] * $chargeMultiplyPoints / $chargeReduction);

				// Impound Builder
				$chargeImpound[] = $charge['impound'][$chargeOffence];
				if ($chargeImpound[$iCharge] == 0) {
					$chargeImpoundColour = 'dark';
					$chargeImpoundQuestion = 'No';
					$chargeImpoundTime = '';
				} else {
					$chargeImpoundColour = 'success';
					$chargeImpoundQuestion = 'Yes';
					$chargeImpoundString = $chargeImpound[$iCharge] == 1 ? ' Day' : ' Days';
					$chargeImpoundTime = ' | ' . number_format($chargeImpound[$iCharge]) . $chargeImpoundString;
				}
				$chargeImpoundFull = '<span class="badge badge-' . $chargeImpoundColour . '">' . $chargeImpoundQuestion . $chargeImpoundTime . '</span>';

				// Suspension Builder
				$chargeSuspension[] = $charge['suspension'][$chargeOffence];
				if ($chargeSuspension[$iCharge] == 0) {
					$chargeSuspensionColour = 'dark';
					$chargeSuspensionQuestion = 'No';
					$chargeSuspensionTime = '';
				} else {
					$chargeSuspensionColour = 'success';
					$chargeSuspensionQuestion = 'Yes';
					$chargeSuspensionString = $chargeSuspension[$iCharge] == 1 ? ' Day' : ' Days';
					$chargeSuspensionTime = ' | ' . number_format($chargeSuspension[$iCharge]) . $chargeSuspensionString;
				}
				$chargeSuspensionFull = '<span class="badge badge-' . $chargeSuspensionColour . '">' . $chargeSuspensionQuestion . $chargeSuspensionTime . '</span>';

				// Extra Builder
				$chargeExtra[] = $charge['extra'];
				if ($chargeExtra[$iCharge] == 'N/A') {
					$chargeExtraColour = 'muted';
					$chargeExtraIcon = 'minus-circle';
				} else {
					$chargeExtraColour = 'success';
					$chargeExtraIcon = 'check-circle';
				}
				$chargeExtraFull = '<span class="badge badge-' . $chargeExtraColour . '"><i class="fas fa-fw fa-' . $chargeExtraIcon . ' mr-1"></i>' . $chargeExtra[$iCharge] . '</span>';

				// Plea for maxtime
				// $pleaPre = $_POST['inputPleaPre'] ?: '';

				// Time Builder
				/*
				if (in_array($chargeID, $pg->chargesDrug)) {
					$days[] = ($charge['time'][$chargeSubstanceCategory]['days'] / $chargeReduction);
					$hours[] = ($charge['time'][$chargeSubstanceCategory]['hours'] / $chargeReduction);
					$mins[] = ($charge['time'][$chargeSubstanceCategory]['min'] / $chargeReduction);
				} elseif (in_array($chargeID, $multiDimensionalCrimeTimes)) {
					$days[] = ($charge['time'][$chargeOffence]['days'] / $chargeReduction);
					$hours[] = ($charge['time'][$chargeOffence]['hours'] / $chargeReduction);
					$mins[] = ($charge['time'][$chargeOffence]['min'] / $chargeReduction);
				} elseif ($pleaPre == 3 && $charge['maxtime']) {
					$days[] = ($charge['maxtime']['days'] / $chargeReduction);
					$hours[] = ($charge['maxtime']['hours'] / $chargeReduction);
					$mins[] = ($charge['maxtime']['min'] / $chargeReduction);
				} else {
					$days[] = ($charge['time']['days'] / $chargeReduction);
					$hours[] = ($charge['time']['hours'] / $chargeReduction);
					$mins[] = ($charge['time']['min'] / $chargeReduction);
				}
				*/

				// Minimum Time Builder
				if (in_array($chargeID, $pg->chargesDrug)) {
					$days[] = ($charge['time'][$chargeSubstanceCategory]['days'] / $chargeReduction);
					$hours[] = ($charge['time'][$chargeSubstanceCategory]['hours'] / $chargeReduction);
					$mins[] = ($charge['time'][$chargeSubstanceCategory]['min'] / $chargeReduction);
				} elseif (in_array($chargeID, $multiDimensionalCrimeTimes)) {
					$days[] = ($charge['time'][$chargeOffence]['days'] / $chargeReduction);
					$hours[] = ($charge['time'][$chargeOffence]['hours'] / $chargeReduction);
					$mins[] = ($charge['time'][$chargeOffence]['min'] / $chargeReduction);
				} else {
					$days[] = ($charge['time']['days'] / $chargeReduction);
					$hours[] = ($charge['time']['hours'] / $chargeReduction);
					$mins[] = ($charge['time']['min'] / $chargeReduction);
				}

				// Maximum Time Builder
				if (in_array($chargeID, $pg->chargesDrug)) {
					$max_days[] = ($charge['time'][$chargeSubstanceCategory]['days'] / $chargeReduction);
					$max_hours[] = ($charge['time'][$chargeSubstanceCategory]['hours'] / $chargeReduction);
					$max_mins[] = ($charge['time'][$chargeSubstanceCategory]['min'] / $chargeReduction);
				} elseif (in_array($chargeID, $multiDimensionalCrimeTimes)) {
					$max_days[] = ($charge['time'][$chargeOffence]['days'] / $chargeReduction);
					$max_hours[] = ($charge['time'][$chargeOffence]['hours'] / $chargeReduction);
					$max_mins[] = ($charge['time'][$chargeOffence]['min'] / $chargeReduction);
				} elseif (array_key_exists('maxtime', $charge)) {
					$max_days[] = ($charge['maxtime']['days'] / $chargeReduction);
					$max_hours[] = ($charge['maxtime']['hours'] / $chargeReduction);
					$max_mins[] = ($charge['maxtime']['min'] / $chargeReduction);
				} else {
					$max_days[] = ($charge['time']['days'] / $chargeReduction);
					$max_hours[] = ($charge['time']['hours'] / $chargeReduction);
					$max_mins[] = ($charge['time']['min'] / $chargeReduction);
				}


				// Minimum Time Calculation
				$chargeTimeFull = $pg->calculateCrimeTime($days[$iCharge], $hours[$iCharge], $mins[$iCharge]);

				// Maximum Time Calculation
				$chargeTimeFullMax = $pg->calculateCrimeTime($max_days[$iCharge], $max_hours[$iCharge], $max_mins[$iCharge]);

				// Finalisation Builders
				$chargeOffenceFull = null;
				if ($chargeOffence > 1) {
					$chargeOffenceFull = ' (Offence #' . $chargeOffence . ')';
				}
				$chargeTitle[] = '<span class="style-underline chargeCopy" data-clipboard-target="#charge-' . $chargeID . '" data-toggle="tooltip" title="Copied!"><span id="charge-' . $chargeID . '">' . $chargeType . $chargeClass . ' ' . $chargeID . '. ' . $chargeName . $chargeOffenceFull . $drugChargeTitle . '</span></span>';

				// Autobail Builder
				$autoBailRow = 'N/A';
				if (in_array($chargeID, $pg->chargesDrug)) {
					$autoBailCost = $charge['bail']['cost'][$chargeSubstanceCategory];
					$autoBailRaw = $charge['bail']['auto'][$chargeSubstanceCategory];
				} else {
					$autoBailRaw = $charge['bail']['auto'];
					$autoBailCost = $charge['bail']['cost'];
					array_push($bailArray, $autoBailRaw);

					switch ($autoBailRaw) {
						case 0:
						case false:
							$autoBail = 'NO BAIL';
							$autoBailIcon = 'minus-circle';
							$autoBailColour = 'danger';
							break;
						case 1:
						case true:
							$autoBail = 'AUTO BAIL';
							$autoBailIcon = 'check-circle';
							$autoBailColour = 'success';
							break;
						case 2:
							$autoBail = 'DISCRETIONARY';
							$autoBailIcon = 'check-circle';
							$autoBailColour = 'warning';
							break;
						default:
							$autoBail = 'ERROR';
							break;
					}

					if (!is_string($autoBailCost)) {
						if ($autoBailCost > 0) {
							$autoBondCost = (BOND_PERCENTAGE / 100) * $autoBailCost;
							$autoBondCost = '$' . number_format($autoBondCost);
							$bailCost[$iCharge] = $autoBailCost;
							$autoBailCost = '$' . number_format($autoBailCost);
							$autoBailRow = $autoBailCost . ' / ' . $autoBondCost . ' (' . BOND_PERCENTAGE . '%)';
						} else {
							$autoBailCost = 'N/A';
							$autoBondCost = 'N/A';
							$autoBailRow = 'N/A';
						}
					}
				} /* else {
					array_push($bailArray, 5);
					$autoBail = 'N/A';
					$autoBailIcon = 'minus-circle';
					$autoBailColour = 'muted';
					$autoBailCost = "$0";
				} */
				$autoBailFull = '<span class="badge badge-' . $autoBailColour . '"><i class="fas fa-fw fa-' . $autoBailIcon . ' mr-1"></i>' . $autoBail . '</span>';
				$bailStatusFull = '<span class="badge badge-' . $bailArray[$iCharge] . '"><i class="fas fa-fw fa-' . $autoBailIcon . ' mr-1"></i>' . $autoBail . '</span>';


				// Rows Builder
				$rowBuilder .= '<tr>
						<td>' . $chargeTitle[$iCharge] . '</td>
						<td class="text-center">' . $pg->getCrimeSentencing($chargeAddition) . '</td>
						<td class="text-center">' . $chargeOffence . '</td>
						<td>' . $chargeTypeFull . '</td>
						<td>' . $chargeTimeFull . '</td>
						<td>' . $chargeTimeFullMax . '</td>
						<td class="text-center">' . $chargePoints[$iCharge] . '</td>
						<td>' . $chargeFineFull . '</td>
						<td class="text-center">' . $chargeImpoundFull . '</td>
						<td class="text-center">' . $chargeSuspensionFull . '</td>
						<td class="text-center">' . $chargeExtraFull . '</td>
						<td class="text-center">' . $autoBailFull . '</td>
						<td class="text-center">' . $autoBailRow . '</td>
					</tr>';
			}

			// Total Time
			$chargeTimeTotalDays = array_sum($days);
			$chargeTimeTotalHours = array_sum($hours);
			$chargeTimeTotalMinutes = array_sum($mins);
			$chargeTimeTotal = $pg->calculateCrimeTime($chargeTimeTotalDays, $chargeTimeTotalHours, $chargeTimeTotalMinutes);
			$chargeTimeTotalRaw = ($chargeTimeTotalDays * 24 * 60) + ($chargeTimeTotalHours * 60) + $chargeTimeTotalMinutes;

			// Total Time Max
			$chargeTimeTotalDaysMax = array_sum($max_days);
			$chargeTimeTotalHoursMax = array_sum($max_hours);
			$chargeTimeTotalMinutesMax = array_sum($max_mins);
			$chargeTimeTotalMax = $pg->calculateCrimeTime($chargeTimeTotalDaysMax, $chargeTimeTotalHoursMax, $chargeTimeTotalMinutesMax);
			$chargeTimeTotalMaxRaw = ($chargeTimeTotalDaysMax * 24 * 60) + ($chargeTimeTotalHoursMax * 60) + $chargeTimeTotalMinutesMax;

			// Total Points
			$chargePointsTotal = array_sum($chargePoints);
			$chargePointsTotal .= $chargePointsTotal == 1 ? ' Point' : ' Points';

			// Total Fines
			$chargeFineTotal = '$' . number_format(array_sum($chargeFine));

			// Total Impound Time
			$chargeImpoundTotal = number_format(array_sum($chargeImpound));
			if ($chargeImpoundTotal > 14) {
				$chargeImpoundTotal = '14 Days';
			} elseif ($chargeImpoundTotal != 0) {
				$chargeImpoundTotal .= $chargeImpoundTotal == 1 ? ' Day' : ' Days';
			} else {
				$chargeImpoundTotal = 'No Impounds';
			}

			// Total Suspension Time
			$chargeSuspensionTotal = number_format(array_sum($chargeSuspension));
			if ($chargeSuspensionTotal > 14) {
				$chargeSuspensionTotal = '14 Days';
			} elseif ($chargeSuspensionTotal != 0) {
				$chargeSuspensionTotal .= $chargeSuspensionTotal == 1 ? ' Day' : ' Days';
			} else {
				$chargeSuspensionTotal = 'No Suspensions';
			};

			// Bail Cost Builder
			if(!empty($bailCost)) {
				$bailCost = max($bailCost);
				$bondCost = (BOND_PERCENTAGE / 100) * $bailCost;
				$bailCostTotal = '$' . number_format($bailCost) . ' / $' . number_format($bondCost) . ' ('. BOND_PERCENTAGE . '%)' ;
				if (in_array(0, $bailArray)) {
					$bailState = "NOT ELIGIBLE";
					$bailStateColour = "danger";
					$bailStateIcon = 'minus-circle';
				} elseif (in_array(2, $bailArray, true)) {
					$bailState = "DISCRETIONARY";
					$bailStateColour = "warning";
					$bailStateIcon = 'check-circle';
				} else {
					$bailState = "ELIGIBLE";
					$bailStateColour = "success";
					$bailStateIcon = 'check-circle';
				} /* else {
					$bailState = "N/A";
					$bailStateColour = "muted";
					$bailStateIcon = 'minus-circle';
				} */;
			} else {
				$bailState = "NOT ELIGIBLE";
				$bailStateColour = "danger";
				$bailStateIcon = 'minus-circle';
				$bailCostTotal = "N/A";
				$bailCost = "N/A";
				$bondCost = "N/A";
			}

			$bailStatusFull = '<span class="badge badge-' . $bailStateColour . '"><i class="fas fa-fw fa-' . $bailStateIcon . ' mr-1"></i>' . $bailState . '</span>';

			// Totals Row Builder
			$rowBuilderTotals = '<tr>
					<td>' . $chargeTimeTotal . '</td>
					<td>' . $chargeTimeTotalMax . '</td>
					<td>' . $chargePointsTotal . '</td>
					<td>' . $chargeFineTotal . '</td>
					<td>' . $chargeImpoundTotal . '</td>
					<td>' . $chargeSuspensionTotal . '</td>
					<td>' . $bailCostTotal . '</td>
					<td>' . $bailStatusFull. '</td>
				</tr>'
				.
				'<tr>
					<td>' . $chargeTimeTotalRaw . '</td>
					<td>' . $chargeTimeTotalMaxRaw . '</td>
					<td>' . array_sum($chargePoints) . '</td>
					<td>' . array_sum($chargeFine) . '</td>
					<td>' . array_sum($chargeImpound) . '</td>
					<td>' . array_sum($chargeSuspension) . '</td>
					<td>' . $bailCost . '</td>
					<td><- COPY HERE</td>
				</tr>';

			// Session Builder
			$showGeneratedArrestChargeTables = true;
			$generatedArrestChargeList = $rowBuilder;
			$generatedArrestChargeTotals = $rowBuilderTotals;
			$arrestChargeList = $chargeTitle;

			
			echo $c->form('templates/generators/form-arrest-report', '', [
				"charges" => $pg->processCharges(),
				"chargeTable" => $generatedArrestChargeList,
				"pg" => $pg,
				"chargeTableTotals" => $rowBuilderTotals,
				"arrestChargeList" => $chargeTitle,
				"bailState" => $bailState,
				"bailStatusFull" => $bailStatusFull,
				"bailCost" => $bailCost,
				"bondCost" => $bondCost,
				"c" => $c,
				"g" => $g,
				"showChargeTable" => true,
				//"plea" => $pleaPre
	
			], false);
			return;
		} else {
			$showGeneratedArrestChargeTables = false;
		}
		//$_SESSION['plea'] = $pleaPre;
	
	}

	if ($generatorType == 'ParkingTicket') {

		// Variables
		$inputVehInsurance = $_POST['inputVehInsurance'] ?: false;
		$inputVehInsuranceDate = $_POST['inputVehInsuranceDate'] ?? $g->getUNIX('date');
		$inputVehInsuranceTime = $_POST['inputVehInsuranceTime'] ?? $g->getUNIX('time');
		$inputReason = $_POST['inputReason'] ?? array();
		$inputReason = array_values($inputReason);
		$inputCrime = arrayMap($_POST['inputCrime'], 'UNKNOWN CHARGE');
		$inputCrimeClass = arrayMap($_POST['inputCrimeClass'], 0);
		$inputCrimeFine = arrayMap($_POST['inputCrimeFine'], 0);

		// Set Cookies
		setCookiePost('officerName', $postInputName);
		setCookiePost('officerRank', $postInputRank);
		setCookiePost('officerBadge', $postInputBadge);
		setCookiePost('defNameVehRO', $postInputVehRO);

		// Vehicle Insurance Resolver
		$insurance = '';
		if ($inputVehInsurance) {
			$insurance = 'Park cezasının düzenlendiği tarihte aracın sigortası yoktu, ' . textBold(2, $inputVehInsuranceDate) . ', ' . textBold(1, $inputVehInsuranceTime) . ' sigorta süresi dolmuştu.<br>';
		}

		// Evidence Resolver
		$evidence = 'N/A';
		if (!empty($postInputEvidenceImageArray)) {

			$evidence = '';
			foreach ($postInputEvidenceImageArray as $image) {
				$evidence .= '<img src="' . $image . '" style="max-width: 100%" />';
			}
		}

		// Officer Resolver
		$officers = resolverOfficer($postInputName, $postInputRank, $postInputBadge);

		// Crime Resolver
		$fines = '';
		foreach ($inputCrime as $iCrime => $crime) {
			$charge = $penal[$crime];
			$chargeTitle = $charge['charge'];
			$chargeType = $charge['type'];
			$chargeClass = '?';
			if (!empty($inputCrimeClass[$iCrime])) {
				$chargeClass = $pg->getCrimeClass($inputCrimeClass[$iCrime]);
			}
			if ($inputCrimeFine[$iCrime] == 0) {
				$fines .= '<li><strong class="style-underline chargeCopy" data-clipboard-target="#charge-' . $crime . '" data-toggle="tooltip" title="Copied!"><span id="charge-' . $crime . '">' . $pg->getCrimeColour($chargeType) . $chargeType . $chargeClass . ' ' . $crime . '. ' . $chargeTitle . '</strong></span></strong>.</li>';
			} else {
				$fines .= '<li><strong class="style-underline chargeCopy" data-clipboard-target="#charge-' . $crime . '" data-toggle="tooltip" title="Copied!"><span id="charge-' . $crime . '">' . $pg->getCrimeColour($chargeType) . $chargeType . $chargeClass . ' ' . $crime . '. ' . $chargeTitle . '</strong></span></strong> - <strong style="color: green!important;">$' . number_format($inputCrimeFine[$iCrime]) . '</strong> Para Cezası.</li>';
			}
		}

		// Parking Ticket Resolver
		$statementReason = '';
		foreach ($inputReason as $reason) {
			$statementReason .= '<li>' . $pt->getIllegalParking($reason) . '</li>';
		}

		// Report Builder
		$redirectPath = redirectPath(1);
		$generatedReportType = 'Parking Ticket';
		$generatedReport = $generatedReport = $officers . textBold(2, $postInputDate) . ' tarihinde ' . textBold(1, $postInputTime) . ' saatinde.<br>Kontroller doğrultusunda ' . $pg->getVehiclePlates($postInputVehPlate, 0) . ', ' . $pg->getVehicleRO($postInputVehRO) . ', ' . textBold(1, $postInputStreet) . ', ' . textBold(1, $postInputDistrict) . ' bölgesinde bulunan ' . textBold(1, $postInputVeh) . ' aracına ceza kesildi.<br>' . $insurance . '
				<br>
				<strong>Ceza(lar):</strong>
				<ul>' . $fines . '</ul>
				<strong>Ceza Sebep(ler)i:</strong>
				<ul>' . $statementReason . '</ul>
				<strong>Kanıt:</strong><br>' . $evidence;
	}

	if ($generatorType == 'ImpoundReport') {

		// Variables
		$inputDuration = $_POST['inputDuration'] ?: 0;
		$inputReason = $_POST['inputReason'] ?: 'UNKNOWN REASON';

		// Set Cookies
		setCookiePost('officerName', $postInputName);
		setCookiePost('officerRank', $postInputRank);
		setCookiePost('officerBadge', $postInputBadge);
		setCookiePost('defNameVehRO', $postInputVehRO);

		// Officer Resolver
		$officers = resolverOfficer($postInputName, $postInputRank, $postInputBadge);

		// Report Builder
		$redirectPath = redirectPath(1);
		$generatedThreadTitle = $postInputVeh . ' - ' . $postInputVehPlate;
		$generatedReportType = 'Impound Raporu';
		$generatedReport = $officers . textBold(2, $postInputDate) . ' tarihinde ' . textBold(1, $postInputTime) . ' saatinde.<br>Kontroller doğrultusunda ' . textBold(1, $postInputVeh) . ' modelinde, ' . $pg->getVehiclePlates($postInputVehPlate, 0) . ', ' . $pg->getVehicleRO($postInputVehRO) . ' araç ' . textBold(1, $inputDuration) . ' günlüğüne, ' . textBold(1, $postInputStreet) . ', ' . textBold(1, $postInputDistrict) . ' adresinden impound edilmiştir.<br>

				<strong>Impound Sebebi:</strong>
				<ul><li>' . $inputReason . '</li></ul>';
	}

	if ($generatorType == 'TrespassNotice') {

		// Variables
		$inputDuration = $_POST['inputDuration'] ?: 0;
		$inputProperty = $_POST['inputProperty'] ?: 'UNKNOWN PROPERTY';
		$inputManagerName = $_POST['inputManagerName'] ?: 'Unknown Manager';
		$inputPhone = $_POST['inputPhone'] ?: '###-###-###';

		// Set Cookies
		setCookiePost('officerName', $postInputName);
		setCookiePost('officerRank', $postInputRank);
		setCookiePost('officerBadge', $postInputBadge);
		setCookiePost('defName', $postInputDefName);

		// Officer Resolver
		$officers = resolverOfficer($postInputName, $postInputRank, $postInputBadge);

		$durationResolver = null;
		if ($inputDuration != 0) {
			$durationResolver = ', for ' . textBold(1, $inputDuration) . ' days. ';
		} else $durationResolver = ', permanently. ';

		// Report Builder
		$redirectPath = redirectPath(1);
		$generatedThreadTitle = 'TRESPASS NOTICE - ' . $inputProperty;
		$generatedReportType = 'Trespass Notice';
		$generatedReport = $officers . ' on the ' . textBold(2, $postInputDate) . ' operating under ' . textBold(1, $postInputCallsign) . ', ' . textBold(1, $postInputTime) . '.<br>Issued trespass notice to ' . textBold(1, $postInputDefName) . $durationResolver . 'At ' . textBold(1, $postInputStreet) . ', ' . textBold(1, $postInputDistrict) . '.<br>

				<strong>Property:</strong>
				<ul><li>' . $inputProperty . '</li></ul>
				
				<strong>Manager Information:</strong>
				<ul><li>' . $inputManagerName . '</li>
				<li>PH #: ' . $inputPhone . '</li></ul>';
	}




	//LSDA Dismissal Petition
	if ($generatorType == 'DA_DismissalPetition') {
		$generatedThreadTitle = '[' . date("y") . 'GJCR' . str_pad($_POST["petitionNumber"], 5, "0", STR_PAD_LEFT) . '] People of the State of San Andreas v. ' . $_POST["inputDefName"];
		$chargesGroup = "";
		$defendant = $_POST["inputDefName"];

		$generatedReport = $c->form('templates/generators/lsda/formats/dismissal', '', [
			"charges" => $pg->processCharges(),
			"defendant" => $defendant,
			"pg" => $pg,
			"motion_name" => "<strong>MOTION TO DISMISS</strong>",
			"filler"=> $pg->getRank($_POST["inputRank"]). " ". $_POST["employeeName"]

		], false);
		$redirectPath = "court";
	}
	//LSDA Dismissal Petition - Speedy Trial
	if ($generatorType == 'JSA_SpeedyTrial') {
		$generatedThreadTitle = '[' . date("y") . 'GJCR' . str_pad($_POST["petitionNumber"], 5, "0", STR_PAD_LEFT) . '] People of the State of San Andreas v. ' . $_POST["inputDefName"];
		$chargesGroup = "";
		$defendant = $_POST["inputDefName"];

		$generatedReport = $c->form('templates/generators/lsda/formats/dismissal', '', [
			"charges" => $pg->processCharges(),
			"defendant" => $defendant,
			"pg" => $pg,
			"motion_name" => "<strong>MOTION TO DISMISS</strong><br>SPEEDY TRIAL<br>VIOLATION",
			"filler"=> $_POST["employeeName"]

		], false);
		$redirectPath = "court";
	}


	if(empty($generatedReport)){
		if(file_exists(dirname(__FILE__).'/forms-backend/'.$generatorType.'.php'))
			include (dirname(__FILE__).'/forms-backend/'.$generatorType.'.php');

			//echo dirname(__FILE__).'/forms-backend/'.$generatorType.'.php';
			//echo $generatedReport;
		//die;
	}



	// Generator Finalisation
	$_SESSION['generatedReport'] = $generatedReport;
	$_SESSION['generatedReportType'] = $generatedReportType;
	$_SESSION['generatedThreadTitle'] = $generatedThreadTitle;
	$_SESSION['generatedThreadURL'] = $generatedThreadURL;
	$_SESSION['showGeneratedArrestChargeTables'] = $showGeneratedArrestChargeTables;
	$_SESSION['generatedArrestChargeList'] = $generatedArrestChargeList;
	$_SESSION['generatedArrestChargeTotals'] = $generatedArrestChargeTotals;
	$_SESSION['arrestChargeList'] = $arrestChargeList;

	// Redirect
	switch ($redirectPath) {
		case 'court':
			//header('Location: /paperwork-generators/generated-court');
			echo $c->form("templates/generated-court", "", [
				"courtURL" => "https://forum.gta.world/en/forum/389-criminal-division/",
				"extra" => empty($extra)?null:$extra,
				"g"=> $g,
				"type"=> $type,
				"title"=> $generatedThreadTitle,
				"report"=> $generatedReport,
			], false);
			return;
		case 'report':
			header('Location: /paperwork-generators/generated-report');
			break;
		case 'thread':
			header('Location: /paperwork-generators/generated-thread');
			break;
		case 'arrest':
			header('Location: /paperwork-generators/arrest-report');
			break;
		case 'error':
		default:
			header('Location: /paperwork-generators/error');
			break;
	}
	//*/
}

// Functions
function redirectPath($input)
{

	$output = '';

	switch ($input) {
		case 1:
			$output = 'report';
			break;
		case 2:
			$output = 'thread';
			break;
		case 3:
			$output = 'arrest';
			break;
		default:
			$output = 'error';
	}

	return $output;
}

function setCookiePost($inputCookie, $inputVariable)
{

	global	$g;

	$cPath = '/';
	$iTime = 2147483647;
	$tTime = time() + 21960;
	$dTime = time() + 3660;

	switch ($inputCookie) {
		case 'notificationVersion':
			$cookie = 'notificationVersion';
			$time = $iTime;
			break;
		case 'specialNotification':
			$cookie = 'specialNotification';
			$time = $iTime;
			break;
		case 'callSign':
			$cookie = 'callSign';
			$time = $tTime;
			break;
		case 'officerName':
		case 'officerNameArray':
			$cookie = 'officerName';
			$time = $iTime;
			break;
		case 'officerRank':
		case 'officerRankArray':
			$cookie = 'officerRank';
			$time = $iTime;
			break;
		case 'officerBadge':
		case 'officerBadgeArray':
			$cookie = 'officerBadge';
			$time = $iTime;
			break;
		case 'defName':
		case 'defNameVehRO':
			$cookie = 'defName';
			$time = $dTime;
			break;
		case 'defNameURL':
			$cookie = 'defNameURL';
			$time = $dTime;
			break;
		case 'openStatus':
			$cookie = 'openStatus';
			break;
		case 'openBailStatus':
			$cookie = 'openBailStatus';
			break;
		case 'inputTDPatrolReportURL':
			$cookie = 'inputTDPatrolReportURL';
			$time = $iTime;
			break;
		default:
			break;
	}

	return setcookie($cookie, $inputVariable, $time, $cPath, $g->getSettings('site-url'), $g->getSettings('site-live'));
}

function arrayMap($input, $default)
{

	$input = $input ?? array();
	return array_map(function ($value) use ($default) {
		return $value === '' ? $default : $value;
	}, $input);
}


function textBold($option, $input)
{

	switch ($option) {
		case 1:
			return '<strong>' . $input . '</strong>';
		case 2:
			return '<strong>' . strtoupper($input) . '</strong>';
		default:
			return '<strong>' . $input . '</strong>';
	}
}

function textRP($option)
{

	switch ($option) {
		case 1:
			return '<strong style="color: #9944dd!important;">*</strong>';
		case 2:
			break;
		default:
			return '<strong style="color: #9944dd!important;">?</strong>';
	}
}

function resolverOfficer($name, $rank, $badge)
{

	global $pg;

	return '<strong>' . $pg->getRank($rank) . ' ' . $name . '</strong> (<strong>#' . $badge . '</strong>), ';
}

function resolverOfficerBB($name, $rank)
{

	global $pg;

	return $pg->getRank($rank) . ' ' . $name . ', ';
}

function resolverOfficerList($name, $rank)
{

	global $pg;

	return '[*] ' . $pg->getRank($rank) . ' ' . $name . ' ';
}

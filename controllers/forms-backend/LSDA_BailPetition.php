<?php

$generatedThreadTitle = '[CFXXX-' . date("y") . '] State of San Andreas v. ' . $_POST["inputDefName"];
$internalCharges = "";
$chargesGroup = "";
$action = $_POST["inputApproveBail"];
$defendant = $_POST["inputDefName"];

$bond = 0;
$hours = 0;
$days = 0;
$fine = 0;

// Charge List Builder
foreach ($pg->processCharges() as $iCharge => $charge) {
    $internalCharges .= "[*]" . $charge['type'] . $charge['class'] . ' ' . $charge['id'] . '. ' . $charge["name"] . "
";
    $bond += $charge["autoBailCost"];
    $days += $charge["time"]["days"];
    $hours += $charge["time"]["hours"];
    $fine += $charge["fine"];
}

$days += floor($hours / 24);
$hours = fmod($hours, 24);


$conditionsGroup = '';
foreach (arrayMap($_POST["inputReason"], "") as $value) {
    if (!empty($value)) {
        $conditionsGroup .= '<li style="color:#555555;font-size:14px;">
				<strong>' . substr($da->getBailReason($value), 1) . '</strong>
				</li>';
    }
}

switch ($action) {
    case 1:
        $total = 'grant bail';
        $bailLong = "That Defendant shall deposit, with the clerk of the court, \$" . $bond . " as bail security indicated on his bail bond with the following conditions:";
        break;
    case 0:
        $total = 'release the defendant on their own recognizance';
        $bailLong = "That Defendant shall be released without bail on their own recognizance.";

        break;
    case 2:
        $total = 'commit the defendant into custody';
        $bailLong = "That Defendant shall not be granted bail and instead be committed to custody for the following reasons:";

        break;
}

$generatedThreadTitle = '[' . date("y") . 'GJCR' . str_pad($_POST["petitionNumber"], 5, "0", STR_PAD_LEFT) . '] People of the State of San Andreas v. ' . $_POST["inputDefName"];
$defendant = $_POST["inputDefName"];

$generatedReport = $c->form('templates/generators/lsda/formats/arraignment', '', [
    "charges" => $pg->processCharges(),
    "defendant" => $defendant,
    "pg" => $pg,
    "motion_name" => "<strong>ARRAIGNMENT</strong>",
    "filler" => $pg->getRank($_POST["inputRank"]) . " " . $_POST["employeeName"],
    "exhibits" => $_POST["exhibits"],
    "bailSummary" => $total,
    "bailLong" => $bailLong,
    "bailMoney" => $bond,
    "bailReasons" => $conditionsGroup,
    "fine" => $fine,
    "days" => $days,
    "hours" => $hours

], false);

$extra = "[divbox=white]
[center]
[dalogo=150][/dalogo]
[size=120][u][b]LOS SANTOS COUNTY DISTRICT ATTORNEY’S OFFICE[/b][/u][/size]
[/center]
[hr][/hr]
[center][size=200][color=#791616][b]" . date("y") . "GJCR" . str_pad($_POST["petitionNumber"], 5, "0", STR_PAD_LEFT) . ": ARRAIGNMENT[/b][/color][/size][/center]
[hr][/hr]

[legend=#791616, Case Information]
[b]Defendant Name:[/b] $defendant 
[b]Docket Number:[/b] [url=INSERT THE URL TO THE CASE ON GTAW FORUMS HERE][" . date("y") . "GJCR" . str_pad($_POST["petitionNumber"], 5, "0", STR_PAD_LEFT) . "][/url]
[b]Post Arrest Submission:[/b] [url=https://mdc.gta.world/postarrest/view/" . $_POST["pasID"] . "]ACCESS[/url]

[b]Trial Deputy (counsel):[/b] " . $_POST["employeeName"] . " 
[b]Trial Deputy (co-counsel):[/b] DNA
[/legend]

[legend=#791616, Charges]
[u]CHARGES BROUGHT AGAINST THE DEFENDANT:[/u]
[list]
"
    . $internalCharges . "
[/list]
[/legend]

[legend=#791616, Trial Information]
[b]Strategy (Optional):[/b] Briefly explain your trial strategy or seek advice from senior prosecutors.
[/legend]

[/divbox]
";

$redirectPath = "court";

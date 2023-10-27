<hr>
<table class="table table-striped table-light table-hover table-sm table-borderless">
	<thead>
		<th scope="col">Title</th>
		<th scope="col" class="text-center">Sentencing</th>
		<th scope="col" class="text-center">Offence</th>
		<th scope="col">Type</th>
		<th scope="col">Time</th>
		<th scope="col" class="text-center">Points</th>
		<th scope="col">Fine</th>
		<th scope="col" class="text-center">Impound</th>
		<th scope="col" class="text-center">Suspension</th>
		<th scope="col" class="text-center">Extra</th>
		<th scope="col" class="text-center">Auto Bail</th>
		<th scope="col" class="text-center">Bail / Bond</th>
	</thead>
	<tbody style="font-size: 75%!important">
		<?= $chargeTable ?>
	</tbody>
</table>
<hr>
<table class="table table-striped table-light table-hover table-sm table-borderless">
	<thead>
		<th>Total Time</th>
		<th>Total Points</th>
		<th>Total Fines</th>
		<th>Total Impound Time</th>
		<th>Total Suspension Time</th>
		<th>Bail Cost / Bond Cost</th>
		<th>Bail Status</th>
	</thead>
	<tbody>
		<?= $chargeTableTotals ?>
	</tbody>
</table>

<?php if($plea == 2){?>
<div class="row">
<small class="form-text text-muted mb-3 pl-3"><strong>*</strong> Bail and bond conditions are determined based on the bail schedule.
The bail/bond cost is <strong>not</strong> the total cost of all charges as that is not how bail/bond is calculated, instead, 
<strong>bail/bond is set from the most serious charge only</strong>.<br></small>
</div>
<?php }?>
<details id="guidelineDropdown" class="card text-white bg-info p-2 text-center" <?php
																				$openStatus = $g->findCookie('openStatus');
																				if ($openStatus == 1) {
																					echo "open";
																				}
																				?>>
	<summary>Arrest & Charging Guidelines</summary>
	<div class="card text-white bg-info">
		<div class="card-body">
			<h4 class="card-title text-center font-weight-bold"><i class="mr-2 fas fa-fw fa-info-circle"></i>Arresting & Charging</h4>
			<h5 class="card-title text-center">Rules & Guidelines</h5>
			<div class="card-text text-center">
				<div class="row">
					<div class="col-8 mx-auto text-centre">
						<h6>When arresting & charging someone, the following guidelines must be followed by the Law Enforcement Personnel performing the arrest. This will act as a barrier for protection and failure to follow these rules may result in administrative punishment.</h6>

					</div>
				</div>
			</div>
			<hr>

			<?php if($plea == 2){?>
			<div class="card-text text-center">
				
				<div class="row">
					<div class="col-8 mx-auto text-centre">
						<h5>The following only applies to <strong>Not Guilty</strong> pleas:</h6>
					</div>
					<div class="col-8 mx-auto text-left">
						<ul>
							<li>If they are eligible for bail as outlined by the <a href="<?= $g->getSettings('url-bail-schedule'); ?>"> <strong>outlined conditions</strong></a>, the defendant must be presented with the option to bail out of prison. </a></li>
							<li>They <strong>must</strong> pay the bail in full, or bond (10% from the full amount) prior to being released.</li>
							<li>If they do not wish to take bail, are unable to pay it or do not meet conditions for bail. they are to be imprisoned for <strong>9999</strong> days.</li>
							<li>The District Attorney's Office must be informed (via the Post Arrest Submission system) that the defendant has pled Not Guilty and the bail conditions must be relayed to the District Attorney's Office.</li>
						</ul>
					</div>
				</div>
			</div>
			<?php } else if($plea == 3||$plea == 4){?>
			<div class="card-text text-center">
				<div class="row">
					<div class="col-8 mx-auto text-centre">
						<h5>The following only applies to <strong>No Contest</strong> and </strong>Guilty</strong> pleas:</h6>
					</div>
					<div class="col-8 mx-auto text-left">
						<ul>
							<li>No arest can exceed <strong>20 days</strong> This is the maximum arrest length.</li>
							<li>Do not impound vehicles for longer then <strong>14 days</strong> This is the maximum impound length.</li>
							<li>Do not suspend licenses for longer then <strong>14 days</strong> This is the maximum suspension length.</li>
						</ul>
					</div>
				</div>
			</div>
			<?php } if($plea == 3){?>
			<div class="card-text text-center">
				<div class="row">
					<div class="col-8 mx-auto text-centre">
						<h5>The following only applies to <strong>No Contest</strong> pleas:</h6>
					</div>
					<div class="col-8 mx-auto text-left">
						<ul>
							<li>The defendant must be charged with the <strong>maximum sentence</strong> for each of the charges brought against them.</li>
							<li>The District Attorney's Office must be informed (Via the Post Arrest Submission system) that the defendant has pled No Contest.</li>
						</ul>
					</div>
				</div>
			</div>
			<?php } if($plea == 1){?>
			<div class="card-text text-center">
				<div class="row">
					<div class="col-8 mx-auto text-centre">
						<h5>The following only applies to <strong>Guilty</strong> pleas:</h6>
					</div>
					<div class="col-8 mx-auto text-left">
						<ul>
							<li>The defendant must be charged with the <strong>minimum sentence</strong> for each of the charges brought against them.</li>
						</ul>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</details>
<?php if($plea == 2){?>
<details id="guidelineBailDropdown" class="card text-dark bg-warning p-2 text-center mt-2" <?php
																				$openBailStatus = $g->findCookie('openBailStatus');
																				if ($openBailStatus == 1) {
																					echo "open";
																				}
																				?>>
	<summary>Bail / Bond Guidelines</summary>
	<div class="card text-dark bg-warning">
		<div class="card-body">
			<h4 class="card-title text-center font-weight-bold"><i class="mr-2 fas fa-fw fa-info-circle"></i>Bail / Bond Guidelines</h4>
			<h5 class="card-title text-center">Bail / Bond Guidelines</h5>
			<div class="card-text text-center">
				<div class="row">
					<div class="col-8 mx-auto text-centre">
						<h6>When arresting & charging someone that had pled <strong>NOT GUILTY</strong>, the following guidelines are to be utilized by Law Enforcement in order to set Bail or Bond Conditions with the suspect. Note that failing to follow these guidelines may result in administrative punishment.</h6>

					</div>
				</div>
			</div>
			<hr>
			<div class="card-text text-center">
				<div class="row">
					<div class="col-8 mx-auto text-centre">
						<h5>Please follow this step by step process:</h6>
					</div>
					<div class="col-8 mx-auto text-left">
						<?php if($bailState == "NOT ELIGIBLE") { ?>
						<ol>
							<li>Please inform the suspect that they are <?php echo($bailStatusFull) ?> for bail or bond conditions and if they wish to proceed with the arrest.</li>
							<textarea class="form-control textboxRP" readonly="">/b Your charges unfortunately make you not eligible for automatic bail/bond conditions which means you will be arrested pending your forum court case, you may be offered bail by a judge on the forums, do you wish to proceed?</textarea>
							<li>Afterwards, if they answer in the affirmative, you are to arrest them for <strong>9999</strong> days.</li>
							<li>Get the suspect's forum name and discord name before proceeding to submit the arrest report.</li>
						</ol>
						<?php } ?>
						<?php if($bailState == "DISCRETIONARY") { ?>
						<ol>
							<li>The suspect's bail/bond conditions are <?php echo($bailStatusFull) ?> meaning you are able to make the decision on if they are allowed to auto-bail or not.</li>
								<ul>
									<li>If you decide to <strong>DENY</strong> bail, then you must inform the suspect they are not elegible for bail and if they wish to proceed with the arrest.</li>
									<textarea class="form-control textboxRP" readonly="">/b Your charges unfortunately make you not eligible for bail/bond conditions which means you will be arrested pending trial, do you wish to proceed?</textarea>
									<li>Skip to step <strong>4c</strong>.</li>
								</ul>
							<li>The panel does this automatically for you: Proceeding with bail, the price for bail is to be calculated most severe charge only, <strong>you are <u>not</u> to tally up the total of all charges.</strong></li>
							<li>The bail is set to <strong><?php echo('$' . number_format($bailCost)) ?></strong> and the bond is set to <strong><?php echo('$' . number_format($bondCost)) ?></strong>. Please explain the following to the suspect:</li>
							<textarea class="form-control textboxRP" readonly="">/b You have three options: Pay full bail and get it refunded after your case (win or lose), pay 10% bond that won't be refunded, or pay nothing now and go to jail pending your forum court case.</textarea>
							<textarea class="form-control textboxRP" readonly="">/b If you commit a crime or fail to show up in court while on bail release, you will get a warrant, be re-arrested, go back to jail, and you will have to pay the full price of bail.</textarea>
							<textarea class="form-control textboxRP" readonly="">/b Full bail for you is <?php echo('$' . number_format($bailCost)) ?>. 10% bond is <?php echo('$' . number_format($bondCost)) ?>. Which do you pick?</textarea>
							<li>Depending on their choice, do the following:</li>
							<ol type="a">
								<li><strong style="color: darkgreen;"><u>FULL BAIL</u></strong></li>
								<ol type="i">
									<li>/fine [targ] <?php echo($bailCost) ?> BAIL PAID ON <?php echo strtoupper(date("d/M/Y")); ?></li>
									<li>Ensure they pay the /fine on the spot.</li>
									<li>Add "BAIL/BOND RELEASE" caution code.</li>
									<li>Get their discord and forum name.</li>
									<li>Release them in front of the station.</li>
									<li>Submit their Arrest Report.</li>
								</ol>

								<li><strong style="color: darkorange;"><u>10% BOND</u></strong></li>
								<ol type="i">
									<li>/fine [targ] <?php echo($bondCost) ?> BOND PAID ON <?php echo strtoupper(date("d/M/Y")); ?></li>
									<li>Ensure they pay the /fine on the spot.</li>
									<li>Add "BAIL/BOND RELEASE" caution code.</li>
									<li>Get their discord and forum name.</li>
									<li>Release them in front of the station.</li>
									<li>Submit their Arrest Report.</li>
								</ol>

								<li><strong style="color: darkred;"><u>NO BAIL / BOND</u></strong></li>
								<ol type="i">
									<li>Get their discord and forum name.</li>
									<li>/arrestprison them for 9999 days.</li>
									<li>Submit their Arrest Report and indicate on the report they did not pay bail or bond.</li>
								</ol>
							</ol>
						</ol>
						<?php } ?>
						<?php if($bailState == "ELIGIBLE") { ?>
						<ol>
							<li>The suspect's bail/bond conditions are <?php echo($bailStatusFull) ?> meaning you are <strong>required</strong> to present them the ability to bail.</li>
							<li>The panel does this automatically for you: Proceeding with bail, the price for bail is to be calculated most severe charge only, <strong>you are <u>not</u> to tally up the total of all charges.</strong></li>
							<li>The bail is set to <strong><?php echo('$' . number_format($bailCost)) ?></strong> and the bond is set to <strong><?php echo('$' . number_format($bondCost)) ?></strong>. Please explain the following to the suspect:</li>
							<textarea class="form-control textboxRP" readonly="">/b You have three options: Pay full bail and get it refunded after your case (win or lose), pay 10% bond that won't be refunded, or pay nothing now and go to jail pending your forum court case.</textarea>
							<textarea class="form-control textboxRP" readonly="">/b If you commit a crime or fail to show up in court while on bail release, you will get a warrant, be re-arrested, go back to jail, and you will have to pay the full price of bail.</textarea>
							<textarea class="form-control textboxRP" readonly="">/b Full bail for you is <?php echo('$' . number_format($bailCost)) ?>. 10% bond is <?php echo('$' . number_format($bondCost)) ?>. Which do you pick?</textarea>
							<li>Depending on their choice, do the following:</li>
							<ol type="a">
								<li><strong style="color: darkgreen;"><u>FULL BAIL</u></strong></li>
								<ol type="i">
									<li>/fine [targ] <?php echo($bailCost) ?> BAIL PAID ON <?php echo strtoupper(date("d/M/Y")); ?></li>
									<li>Ensure they pay the /fine on the spot.</li>
									<li>Add "BAIL/BOND RELEASE" caution code.</li>
									<li>Get their discord and forum name.</li>
									<li>Release them in front of the station.</li>
									<li>Submit their Arrest Report.</li>
								</ol>

								<li><strong style="color: darkorange;"><u>10% BOND</u></strong></li>
								<ol type="i">
									<li>/fine [targ] <?php echo($bondCost) ?> BOND PAID ON <?php echo strtoupper(date("d/M/Y")); ?></li>
									<li>Ensure they pay the /fine on the spot.</li>
									<li>Add "BAIL/BOND RELEASE" caution code.</li>
									<li>Get their discord and forum name.</li>
									<li>Release them in front of the station.</li>
									<li>Submit their Arrest Report.</li>
								</ol>

								<li><strong style="color: darkred;"><u>NO BAIL / BOND</u></strong></li>
								<ol type="i">
									<li>Get their discord and forum name.</li>
									<li>/arrestprison them for 9999 days.</li>
									<li>Submit their Arrest Report and indicate on the report they did not pay bail or bond.</li>
								</ol>
							</ol>
						</ol>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</details>
<?php } ?>
<hr>
<html>
<head>
	<title>
		Available methods on <?php echo $api_name; ?> api
	</title>
	<script type="text/javascript">
		//converts the parameters into the submit url
		//each parameter adds another part to the url
		function submit_form(form, method, numparams) {
			if (numparams == 0) { return true; }
			action = '<?php echo settings::base."/".$api_name."/"; ?>'+method;
			for (i=0;i<numparams;i++) {
				id = 'param_'+method+'_'+i.toString();
				action = action + '/' + document.getElementById(id).value;
			}
			form.action = action
		}
	</script>
	<style type="text/css">
		.params {font-size:x-small;}
	</style>
</head>
<body>
	<table>
		<tr>
			<th>Method Name</th>
			<th>Method Description</th>
			<th>Test</th>
		</tr>
		<?php foreach ($methods as $method) { ?>
			<tr>
				<td>
					<?php echo $method["name"]; ?>
				</td>
				<td>
					<?php echo nl2br($method["docs"]); ?>
					<?php if ($method["numparams"] > 0) { ?>
						<div class='params'>
							Takes <?php echo $method["numparams"]; ?> url parameter<?php if ($method["numparams"] > 1) echo "s"; ?>
						</div>
					<?php } 
					if (count($method["postparams"]) > 0) {
					?>
						<div class='params'>
							Post parameters: <?php echo implode(", ", $method["postparams"]); ?>
						</div>
					<?php } ?>
					</div>
				</td>
				<td>
					<form action='<?php echo settings::base."/".$api_name."/".$method["name"]; ?>' 
						method='post' 
						onsubmit="return submit_form(this, '<?php echo $method["name"] ?>', <?php echo $method["numparams"] ?>);">
						<table>
						<?php
							for ($i=0;$i<$method["numparams"];$i++) {
								?>
								<tr>
									<td>
										Param <?php echo $i+1; ?>
									</td>
									<td>
										<input type="text" id="param_<?php echo $method["name"]."_".$i; ?>">
									</td>
								</tr>
								<?php
							}
							
							foreach ($method["postparams"] as $postparam) {
								?>
								<tr>
									<td>
										<?php echo $postparam; ?>
									</td>
									<td>
										<input type="text" name="<?php echo $postparam ?>">
									</td>
								</tr>
								<?php
							}
						?>
						<tr>
							<td>&nbsp;</td>
							<td><input type="submit" value="Submit"></td>
						</tr>
						</table>
					</form>
				</td>
			</tr>
		<?php } ?>
</body>
</html>

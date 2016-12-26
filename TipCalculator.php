<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
<style type="text/css">
	.error{
	color: red;
	font-weight: bold;
}
.okay{
	color: blue;
}
</style>
</head>
<body>
<?php 
$subtotal = $custom_percentage = '';
$percentage = $tip = $total = 0;
$subtotal_format = $set = $cust_perc_format = $stotal_error = $percentage_error = false;
function calculatePercentage($value='')
{
	$value = (float) $value / 100;
	return $value;
}

// If the subtotal looks like a valid currency number,
// any number of numerics possibly followed by a decimal 
// with 1,2 numbers, and the radio button is set

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$subtotal_format = preg_match('/^[0-9]+(?:\.[0-9]{0,2})?$/', $_POST["subtotal"]);
	$cust_perc_format = preg_match('/^[+]?([.]\d+|\d+[.]?\d*)$/', $_POST["custom_percentage"]);

	if ($subtotal_format){
		if(!empty($_POST["percentage"])){
			$percentage = calculatePercentage($_POST["percentage"]);
			$subtotal = (float) $_POST["subtotal"];
			$set = true;
		}
		elseif ($cust_perc_format) {
			$custom_percentage = $_POST["custom_percentage"]; 
			$percentage = calculatePercentage($_POST["custom_percentage"]);
			$subtotal = (float) $_POST["subtotal"];
			$set = true;
		}
		else{
			$percentage_error = true;
		}
	}
	else{
		$stotal_error = true;
	}
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<h1>Tip Calculator</h1>
<p class="<?php echo ($stotal_error) ? "error" : "";?>">Bill subtotal: $ <input type="text" name="subtotal" value="<?php echo $subtotal;?>"></p>
<p class="<?php echo ($percentage_error) ? "error" : "";?>">Tip percentage: </p>


<?php 
$values = array("10", "15", "20") ;
for($i = 0; $i < 4; $i++){					
	if($i < 3){
		$val = $values[$i]; 
		?>
			<input type="radio" name="percentage" value="<?php echo $val; ?>" 
			<?php 
			if (isset($percentage) && ($percentage * 100)==$val)
				echo "checked";
		?>
			> <?php echo $val; ?>%
			<?php	
	}
	else{
		
		echo "</br>";?>
			<input type="radio" name="percentage" value="<?php echo $custom_percentage; ?>" class="more"
			<?php 
			if ($custom_percentage != '')
				echo "checked";
		?>
			> 
			<input type="text" name="custom_percentage" value="<?php echo $custom_percentage; ?>" 
			<?php echo $val . "</br>";?>%
			<?php
	}
}

?>
<p><input type="submit"></p>
</form>

<?php
if($set){
	$tip = number_format((float) ($subtotal * $percentage), 2, '.', '');
	$total = number_format((float) ($subtotal + $tip ), 2, '.', '');
	?>
		<p>
		<span>
		<?php
		echo "Tip: $" . $tip . "</br>" ;
		echo "Total: $" . $total . "</br>" ;
	?>
		</span>
		</p>
		<?php
}
?>
</body>
</html>

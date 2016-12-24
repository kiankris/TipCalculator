 <!DOCTYPE html>
 <html>
	<body>
	<?php 
		$subtotal = $custom_percentage = '';
		$percentage = $tip = $total = 0;
		$set = false;

		function calculatePercentage($value='')
		{
			$value = (float) $value / 100;
			return $value;
		}

		// If the subtotal looks like a valid currency number,
		// any number of numerics possibly followed by a decimal 
		// with 1,2 numbers, and the radio button is set
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (preg_match('/^[0-9]+(?:\.[0-9]{0,2})?$/', $_POST["subtotal"])){
				$subtotal = (float) $_POST["subtotal"];
				if(!empty($_POST["percentage"])){
					$percentage = calculatePercentage($_POST["percentage"]);
					$set = true;
				}
				elseif (!empty($_POST["custom_percentage"])) {
					$percentage = calculatePercentage($_POST["custom_percentage"]);
					$set = true;
				}
			}
		}
	?>

		<form method="post">
			<h1>Tip Calculator</h1>
			<p>Bill subtotal: $ <input type="text" name="subtotal" value="<?php echo $subtotal;?>"></p>
			<?php 
				$values = array("10", "15", "20", "-1") ;
				for($i = 0; $i < 4; $i++){
					$val = $values[$i]; 
					
					if($i < 3){
						?>
						<input type="radio" name ="percentage" value="<?php echo $val; ?>" 
							<?php 
							if (isset($percentage) && ($percentage * 100)==$val) 
								echo "checked";
							?>
						> <?php echo $val; ?>%
						<?php	
					}
					else{
						echo "</br>";
						?>
						<input type="radio" name="percentage" value="<?php echo $custom_percentage; ?>" class="more"> 
							<?php 
								if (isset($custom_percentage) && ($custom_percentage * 100)==$val)
									echo "checked";
							?>
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
					$tip = $subtotal * $percentage;
					$total = $subtotal + $tip ;
						echo "Tip: $" . $tip . "</br>" ;
						echo "Total: $" . $total . "</br>" ;
			}
		?>
	</body>
 </html>


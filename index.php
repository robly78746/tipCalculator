<!DOCTYPE html>
<html>
<body>
<h1>Tip Calculator</h1>
<?php 
$invalid = false; 
define("DEFAULT_VAL", 0);
function check_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

/*input: float value
output: true if valid bill*/
function check_bill($bill){
	return $bill >= 0;	
}

/*input: float value
output: true if valid percentage; false if not*/
function check_percentage($percent) {
	return $percent >= 0 && $percent <= 100;
}

$tip = null;
$total = null;
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$billSubtotal = check_input(empty($_POST['billSubtotal']) ? '' : $_POST['billSubtotal']);
	$tipPercentage = check_input(empty($_POST['tipPercentage']) ? '' : $_POST['tipPercentage']);
	

	if(is_numeric($billSubtotal) && is_numeric($tipPercentage)) {
		$billSubtotal = floatval($billSubtotal);
		$tipPercentage = floatval($tipPercentage);
		if(check_bill($billSubtotal) && check_percentage($tipPercentage)) {
			$tipVal = $tipPercentage / 100 * $billSubtotal;
			$tip = sprintf('%0.2f', $tipVal);
			$totalVal = $tip + $billSubtotal;
			$total = sprintf('%0.2f', $totalVal);
		}
	} else {
		$invalid = true;
	}
}

$billSubtotalVal = $invalid ? DEFAULT_VAL : $billSubtotal;
$tipPercentageVal = $invalid ? DEFAULT_VAL : $tipPercentage;
?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	Bill subtotal: $<input type="text" name="billSubtotal" value = <?php echo htmlentities($billSubtotalVal);?>><br>
	<br>Tip percentage:<br>
	
<?php
$percentages = array(10.0,  15.0, 20.0);
?><br>
<?php foreach($percentages as $percent) { ?>
	<input type="radio" name="tipPercentage" value=<?php echo htmlentities($percent);?> <?php echo htmlentities($tipPercentageVal === $percent ? 'checked' : '');?> ><?php echo htmlentities($percent);?>%
<?php } ?>
<br>
<input type="submit" value="Submit">
</form>


<br>
<br>
<?php 
if($tip != null && $total != null) {?>
	Tip: $<?php echo htmlentities($tip);?><br>
	Total: $<?php echo htmlentities($total);
}?>

</body>
</html>
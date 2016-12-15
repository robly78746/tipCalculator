<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="tipCalculator.css">
</head>
<body>
<h1>Tip Calculator</h1>
<?php 
define("DEFAULT_VAL", "0");
define("NAN_BILL_ERROR_MESSAGE", "Bill subtotal is not a number");
define("NAN_TIP_ERROR_MESSAGE", "Tip percentage is not selected");
define("INVALID_BILL_ERROR_MESSAGE", "Bill subtotal is less than 0");
define("INVALID_TIP_ERROR_MESSAGE", "Tip percentage is less than 0");

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
	return $percent >= 0;
}

$tip = null;
$total = null;
$error = '';
$numErrors = 0;
$tipValid = false;
$billValid = false;
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$tipValid = true;
	$billValid = true;
	$billSubtotal = check_input(isset($_POST['billSubtotal']) ? $_POST['billSubtotal'] : '');
	$tipPercentage = check_input(isset($_POST['tipPercentage']) ? $_POST['tipPercentage'] : '');
	
	if(!is_numeric($billSubtotal)) {
		$error .= NAN_BILL_ERROR_MESSAGE . "\n";
		$numErrors += 1;
		$billValid = false;
	} else {
		$billSubtotal = floatval($billSubtotal);
	}
	if(!is_numeric($tipPercentage)) {
		$error .= NAN_TIP_ERROR_MESSAGE . "\n";
		$numErrors += 1;
		$tipValid = false;
	} else {
		$tipPercentage = floatval($tipPercentage);
	}
	if($error === '') {
		
		
		if(!check_bill($billSubtotal))
		{
			$error .= INVALID_BILL_ERROR_MESSAGE . "\n";
			$numErrors += 1;
			$billValid = false;
		}
		if(!check_percentage($tipPercentage)) {
			$error .= INVALID_TIP_ERROR_MESSAGE . "\n";
			$numErrors += 1;
			$tipValid = false;
		}
		if($error === '') {
			$tipVal = $tipPercentage / 100 * $billSubtotal;
			$tip = sprintf('%0.2f', $tipVal);
			$totalVal = $tip + $billSubtotal;
			$total = sprintf('%0.2f', $totalVal);
		}
	}
}

$billSubtotalVal = $billValid ? $billSubtotal : DEFAULT_VAL;
$tipPercentageVal = $tipValid ? $tipPercentage : DEFAULT_VAL;
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
<br>
<input type="submit" value="Submit"><br>

<?php 
if($_SERVER["REQUEST_METHOD"] == "POST"){
if($tip != null && $total != null) {?>
<p>	Tip: $<?php echo htmlentities($tip);?><br>
	Total: $<?php echo htmlentities($total);?></p>
<?php } else {?>
<p> Error<?php echo htmlentities($numErrors > 1 ? 's': '');?>: <?php echo nl2br(htmlentities($error));?></p>
<?php	} 
}?>
</form>


<br>
<br>


</body>
</html>
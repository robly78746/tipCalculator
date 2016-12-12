<!DOCTYPE html>
<html>
<body>
<h1>Tip Calculator</h1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	Bill subtotal: $<input type="text" name="billSubtotal"><br>
	<br>Tip percentage:<br>
	
<?php
$percentages = array(10,  15, 20);
echo "Hello world";
?><br>
<?php foreach($percentages as $percent) { ?>
	<input type="radio" name="tipPercentage" value=<?php echo $percent;?>><?php echo $percent;?>%
<?php } ?>
<br>
<input type="submit" value="Submit">
</form>

<?php 
function check_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$billSubtotal = check_input(empty($_POST['billSubtotal']) ? '' : $_POST['billSubtotal']);
	$percentage = check_input(empty($_POST['tipPercentage']) ? '' : $_POST['tipPercentage']);
	$tip = null;
	$total = null;

	if(is_numeric($billSubtotal) && is_numeric($percentage)) {
		$tip = $percentage / 100 * $billSubtotal;
		$total = $tip + $billSubtotal;
	}




?>
<br>
<br>
<?php 

if($tip != null && $total != null) {?>
	Tip: $<?php echo $tip;?><br>
	Total: $<?php echo $total;?>
<?php } 
}else {
	echo  "not post";
	}?>

</body>
</html>
<!DOCTYPE html>
<html>
<head>
<title>Tip Calculator</title>

</head>
<body>
<?php
	$bill=$percent=$cpercent=0.0;
	$split=0;
	$print=$printSplit=false;
	$error_bill=$error_per=$error_split='';
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		$bill=$_POST["bill"];
		if(is_numeric($_POST["bill"]) && $_POST["bill"]>0){
			$bill=(intval(100*$_POST["bill"]))/100.0;
			$print=true;
		}
		else{
			$error_bill='color: salmon';
		}
		$cpercent=$_POST["custompercent"];
		if($_POST["percent"]=="custom" && (!is_numeric($_POST["custompercent"]) || $_POST["custompercent"]<=0)){
			$error_per='color: salmon';
			$print=false;
		}
		switch($_POST["percent"]){
			case "10%":
				$percent=0.10;
				break;
			case "15%":
				$percent=0.15;
				break;
			case "20%":
				$percent=0.20;
				break;
			case "custom":
				if($print){
					$percent=$cpercent/100.0;
				}
				break;
			default:
				$percent=0.0;
				$print=false;
		}
		$split=$_POST["split"];
		if(!is_numeric($_POST["split"]) || $_POST["split"]<=0 || !is_int(intval($split))){
			$error_split='color: salmon';
			$print=false;
		}
		elseif($split>1){
			$printSplit=true;
		}
	}
	if(empty($_POST['submitbutton'])){
		$bill=123.45;
		$cpercent=18.5;
		$split=12;
	}
?>
<div class="outer"><!--text box that encloses this calculator-->
<h2>Tip Calculator</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
<p><!--form fields and labels-->
	<span style="<?php echo $error_bill;?>">Bill subtotal:
	$<input type="text" name="bill" placeholder="123.45" maxlength="8" value="<?php echo $bill?>" style="width: 70px">
	</span><br><br>

	<span style="<?php echo $error_per;?>">Tip percentage:<br>
	<input type="radio" name="percent" <?php if(isset($_POST["percent"]) && $_POST["percent"]=="10%") echo 'checked="checked"';?> value="10%">10%<br>
	<input type="radio" name="percent" <?php if(isset($_POST["percent"]) && $_POST["percent"]=="15%") echo 'checked="checked"';?> value="15%">15%<br>
	<input type="radio" name="percent" <?php if(isset($_POST["percent"]) && $_POST["percent"]=="20%") echo 'checked="checked"';?> value="20%">20%<br>
	<input type="radio" name="percent" <?php if(!isset($_POST["percent"]) || $_POST["percent"]=="custom") echo 'checked="checked"';?> value="custom">Custom:
	<input type="text" name="custompercent" placeholder="18.5" maxlength="6" value="<?php echo $cpercent;?>" style="width: 45px">%
	</span><br><br>

	<span style="<?php echo $error_split;?>">Split between:
	<input type="text" name="split" placeholder="12" maxlength="2" value="<?php echo $split;?>" style="width: 30px">
	person(s)
	</span><br><br>

	<input type="submit" name="submitbutton" value="Calculate" style="margin-left: 38%;">
</p>
</form>
<!--following field prints results, if input is correct-->
<?php
	if($print){
		echo "<br><div class='inner'>";
			printf("Tip:\t$%.2f<br><br>Total:\t$%.2f", $bill*$percent, $bill*(1+$percent));
			if($printSplit){
				printf("<br><br>Tip each:\t$%.2f<br><br>Total each:\t$%.2f", $bill*$percent/$split, $bill*(1+$percent)/$split);
			}
		echo "</div>";
	}
?>
</div>
</body>
</html>

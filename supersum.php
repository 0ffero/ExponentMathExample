<!--
	A quick script to show that 0 + 1/2 + 1/4 + 1/8 ... ! = 1/12
	Precision is changeable (currently set at 60 decimal places)
	Also a good example of what I like to call precision death.
	It's a simple way to show how computers deal with floating
	point maths and their limitations.
//-->
<style type="text/css">
table { font-family: monospace; }
td { border: 1px solid black; }
.precdeath { color: red; }
</style>
<?php
// This var can be changed to whatever you want really
$precision = 60;

// These are init vars used by the script
$br="<br/>";
$loopCount=256;
$div = 1;
$total = 0;
$precisionDeath = 0;

// set the precision
bcscale($precision);

// start doing shit
$opTable = '<table cellpadding="2" cellspacing="4">';
for ($i=1; $i<=$loopCount; $i++) {
	$div = $div*2;
	$strDiv = number_format($div,0,'','');
	if (strpos((string)$div, "E")>0) {
		// Precision Death;
		$strpos = strpos((string)$div, "E");
		$exponent = substr((string)$div,$strpos+2);
		if ($exponent>=$precision) { $precDeath = ' class="precdeath"'; if ($precisionDeath==0) { $precisionDeath = $i; $opTable .= '<tr style="background-color: black; color: red; font-variant: small-caps; font-size: 20px;"><td colspan="5">Precision Death occurs here</td></tr>'; } }
	} else {
		$exponent = "none";
	}
	$total = bcadd($total, bcdiv("1",$strDiv));
	$opTable .= "<tr$precDeath><td>Loop#: " . $i . "</td><td>Div: " . $div . "</td><td>Exponent: " . $exponent . "</td><td>Real Div: 1/" . $strDiv . "</td><td>Total: " . $total . "</td></tr>";
}
$opTable .= "</table>";

if ($precisionDeath==0) { $precisionDeath = 'No precision death found (loop count of ' . $loopCount . ' is too small to show precision death with a precision of ' . $precision . ')'; } else { $precisionDeath = 'loop number ' . $precisionDeath; }

$header = '<span>Table rows in <span class="precdeath">red</span> show when the maximum precision is inhibiting the ability to add to the total (precision death)</span><br/>Basically the "real division" (and hence the fraction) is so small it will now be rounded to 0 with its precision being a max of ' . $precision . '<br/>Thankfully, before precision death (' . $precisionDeath . '), we can see a pattern. The number is converging to 0.999\' (that \' means that the 9 never ends no matter the precision)<br/>Some basic rounding on each culculation (after a short time) will leave you with a number between 0.999 (non recurring) and 1. The more loops the more 9\'s in that first number';

echo $header;
echo $opTable;
?>
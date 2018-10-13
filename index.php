<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Css Convert</title>
<script type="text/javascript">
var lastSeen = [0, 0];
function checkScroll(div1, div2) {
  if(!div1 || !div2) return;
  var control = null;
  if(div1.scrollTop != lastSeen[0]) control = div1;
  else if(div2.scrollTop != lastSeen[1]) control = div2;
  if(control == null) return;
  else div1.scrollTop = div2.scrollTop = control.scrollTop;
  lastSeen[0] = div1.scrollTop;
  lastSeen[1] = div2.scrollTop;
}

window.setInterval("checkScroll(document.getElementById('ta1'), document.getElementById('ta2'))", 200);
</script>
</head>

<body>
<?php 
	include ("classes/css_convert.php");
	$CssConvert = new CssConvert();

if($_SERVER['REQUEST_METHOD']=="POST" && $_POST['submit'] && !empty($_POST['css'])){

	$css = @$_POST['css'];
	$dir = @$_POST['dir'];	
	$css = CssConvert::clean_css($css);
	if(@$_POST['float']==1){
		$css = $CssConvert->replace_float_textalign($css,'float');
	}
	if(@$_POST['textalign']==1){
		$css = $CssConvert->replace_float_textalign($css,'text-align');
	}
	if(@$_POST['direction']==1){
		$css = $CssConvert->replace_dir($css);
	}
	if(@$_POST['position']==1){
		$css = $CssConvert->replace_position($css);
	}
	if(@$_POST['pm']==1){
		$css = $CssConvert->replace_padding_margin($css);
	}
	//$css = $CssConvert->replace_padding_margin($css,"margin");

	$css = $CssConvert->reformat_css($css);
		
	if($dir =='rtl'){
		//$css="*{direction:rtl;}\n".$css;
	}
	echo "<div style='float:left; width:50%'>
	<h2>After</h2>
	<textarea style='height: 250px; width: 98%; ' id='ta1'>".($css)."</textarea></div>";
	echo "<div style='float:left; width:50%'>
	<h2>Before</h2>
	<textarea style='height: 250px; width: 98%; ' id='ta2'>".($CssConvert->reformat_css(CssConvert::clean_css($_POST['css'])))."</textarea></div>"
	;
}
?>
<h2>CSS Convert</h2>

<form action="" method="POST" enctype="application/x-www-form-urlencoded">
	<p><label>Direction: 
	<select name="dir">
    	<option value="rtl"<?php if(@$_POST['dir']=="rtl"){echo " selected";}?>>Right To Left</option>
    	<option value="ltr"<?php if(@$_POST['dir']=="ltr"){echo " selected";}?>>Left To Right</option>
    </select>
    </label>
    <label>Float:<input type="checkbox" name="float" value="1" <?php if(@$_POST['float']==1 || !isset($_POST['float'])){ echo "checked='checked'";} ?> /></label> 
    <label>Text-Align:<input type="checkbox" name="textalign" value="1" <?php if(@$_POST['textalign']==1  || !isset($_POST['textalign']) ){ echo "checked='checked'";}?> /></label> 
    <label>Direction:<input type="checkbox" name="direction" value="1" <?php if(@$_POST['direction']==1  || !isset($_POST['direction']) ){ echo "checked='checked'";}?> /></label> 
    <label>Padding & Margin:<input type="checkbox" name="pm" value="1" <?php if(@$_POST['pm']==1  || !isset($_POST['pm']) ){ echo "checked='checked'";}?> /></label> 
    <label>Position:<input type="checkbox" name="position" value="1" <?php if(@$_POST['position']==1  || !isset($_POST['position']) ){ echo "checked='checked'";}?> /></label> 
    </p>
	<p>
    <textarea name="css" style="height: 250px; width: 100%; "><?php echo @$_POST['css']?></textarea>
    </p>
    <input type="submit" name="submit" value="Convert" />
</form>

<?php 
//test cases
/*	$padding = "padding   :   10px    auto   50px   20px  ;  margin :auto   1000px ; ";
		$padding =  $CssConvert->clean_css($padding);
		
		echo $padding;
		
		$padding =$CssConvert->extract_unit($padding,":",";");
		$padding = explode(" ",$padding);
		
		echo "<pre>";
		//var_dump($padding);
		$padding = array($padding[0],$padding[3],$padding[2],$padding[1]);
		//var_dump($padding);
		$padding = implode(" ",$padding);
		echo $CssConvert->clean_css($padding);*/ 
?>

</body>
</html>


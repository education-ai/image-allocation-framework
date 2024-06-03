<?php
/* *
 * Framework to Evaluate the Uniqueness of Textual Chunks to Images
 * Author: Sylvio Rüdian, 2023
 * 
 * IMPORTANT NOTE: Not checked for vulnerable code.
 * */

/* Identify the current step */
$nrg = (int)$_GET['nr'];
$nr = 0;

/* Store Evaluation of previous round */
if (isset($_POST['dat'])){
		
	$result = explode("\n",trim($_POST['result']));
	
	$result_filtered = [];
	foreach($result as $k) {
		$t = explode(';',$k);
		$result_filtered[$t[0]] = trim($t[1]);
	}
		
	$fin = '';
	foreach ($result_filtered as $k => $v) {
		$fin .= $k.';'.$v.'|';
	}
	
	$res = implode('|',array($_POST['dat'],$fin))."\n";
	file_put_contents('evaluation.txt',$res, FILE_APPEND );
	
}

/* Select next course by number */
$dat = '';
$cache = explode("\n",file_get_contents('res.txt'));
foreach($cache as $k){
	if (strpos($k,'|1|1|1|1|1|1') > 1){
		$t = explode('|',$k);
		$test = $t[0];
			
		if (file_exists('course/'.$test)){
			$nr++;
			if ($nr == $nrg) {
				$dat = $t[0];
			}
		}
	}
}

echo $dat; /* display course name */

/* Get data of the chosen course */
$cont = json_decode(file_get_contents('course/'.$dat));

/* Build form */
echo '<div style="width:100%; float:left;"><br><br>';

$alldrag = array();
$alldrop = array();

/* show images in random order */
function showimgs($arr){
	global $alldrag; global $alldrop;
	shuffle($arr);
	$this_drag = [];
	foreach($arr as $k){
		array_push($alldrag,'draggable_'.$k[0]);
		array_push($this_drag,'draggable_'.$k[0]);
	}
?>
<div style="clear:both">
	<div class="dragzone">
	  <div id="<?php echo $this_drag[0];?>" draggable="true" class="cimg" style="background: url('img_aimini/<?php echo strtolower($arr[0][2]);?>.jpg') no-repeat center center;" ></div>
	  
	  <div id="<?php echo $this_drag[1];?>" draggable="true" class="cimg" style="background: url('img_aimini/<?php echo strtolower($arr[1][2]);?>.jpg') no-repeat center center;" ></div>
	  
	  <div id="<?php echo $this_drag[2];?>" draggable="true" class="cimg" style="background: url('img_aimini/<?php echo strtolower($arr[2][2]);?>.jpg') no-repeat center center;" ></div>
	  
	  <div id="<?php echo $this_drag[3];?>" draggable="true" class="cimg" style="background: url('img_aimini/<?php echo strtolower($arr[3][2]);?>.jpg') no-repeat center center;" ></div>
	</div>
	<?php 
	
	shuffle($arr);
	$this_drop = [];
	foreach($arr as $k){
		array_push($alldrop,'droptarget_'.$k[0]);
		array_push($this_drop,'droptarget_'.$k[0]);
	}
	?>
	<div class="dropzoneframe">
		<div class="dropzone" id="<?php echo $this_drop[0];?>"></div>
		<div class="dropzone" id="<?php echo $this_drop[1];?>"></div>
		<div class="dropzone" id="<?php echo $this_drop[2];?>"></div>
		<div class="dropzone" id="<?php echo $this_drop[3];?>"></div>
	</div>
	<div class="dropzoneframe0">
		<div class="dropzone0"><?php echo $arr[0][1];?> &nbsp;</div>
		<div class="dropzone0"><?php echo $arr[1][1];?> &nbsp;</div>
		<div class="dropzone0"><?php echo $arr[2][1];?> &nbsp;</div>
		<div class="dropzone0"><?php echo $arr[3][1];?> &nbsp;</div>
	</div>

</div>

<?php
}

/* *
 * All boxes containing chunks and images to allocate 
 * */
echo '<div class="c">';
echo 'Nouns:<br>';
showimgs([
	['A',$cont->A,$cont->img->A],
	['B',$cont->B,$cont->img->B],
	['C',$cont->C,$cont->img->C],
	['D',$cont->D,$cont->img->D]]);
echo '</div>';

echo '<div class="c">';
echo 'Verbs:<br>';
showimgs([
	['a',$cont->a,$cont->img->a],
	['b',$cont->b,$cont->img->b],
	['c',$cont->c,$cont->img->c],
	['d',$cont->d,$cont->img->d]]);
echo '</div>';

echo '<div class="c">';
echo 'Nouns:<br>';
showimgs([
	['E',$cont->E,$cont->img->E],
	['F',$cont->F,$cont->img->F],
	['G',$cont->G,$cont->img->G],
	['H',$cont->H,$cont->img->H]]);
echo '</div>';

echo '<div class="c">';
echo 'Sätze (2er):<br>';
showimgs([
	['Aa',$cont->Aa,$cont->img->Aa],
	['Ba',$cont->Ba,$cont->img->Ba],
	['Ca',$cont->Ca,$cont->img->Ca],
	['Da',$cont->Da,$cont->img->Da]]);
echo '</div>';

echo '<div class="c">';
echo 'Sätze (3er):<br>';
showimgs([
	['ABb',$cont->ABb,$cont->img->ABb],
	['CDc',$cont->CDc,$cont->img->CDc],
	['ACa',$cont->ACa,$cont->img->ACa],
	['BDa',$cont->BDa,$cont->img->BDa]]);
echo '</div>';

echo '<div class="c">';
echo 'Text 1-4:<br>';
showimgs([
	['t0',$cont->txt[0],$cont->img->txt[0]],
	['t1',$cont->txt[1],$cont->img->txt[1]],
	['t2',$cont->txt[2],$cont->img->txt[2]],
	['t3',$cont->txt[3],$cont->img->txt[3]]]);
echo '</div>';

echo '<div class="c">';
echo 'Text 5-8:<br>';
showimgs([
	['t4',$cont->txt[4],$cont->img->txt[4]],
	['t5',$cont->txt[5],$cont->img->txt[5]],
	['t6',$cont->txt[6],$cont->img->txt[6]],
	['t7',$cont->txt[7],$cont->img->txt[7]]]);
echo '</div>';

echo '<div class="c">';
echo 'Further Text:<br>';
showimgs([
	['t8',$cont->txt[8],$cont->img->txt[8]],
	['t9',$cont->txt[9],$cont->img->txt[9]],
	['t10',$cont->txt[10],$cont->img->txt[10]],
	['t11',$cont->txt[11],$cont->img->txt[11]]]);
echo '</div>';
?></div>

<div style="float:left;width:10%; padding:5%;"><div style="position:fixed; background:#fff;right:50px;bottom:0px;"><form method="post" action="index.php?nr=<?php echo $nrg+1; ?>">
<input type="hidden" name="dat" value="<?php echo $dat;?>">
<input type="hidden" id="active_from" value="0"><br>
<input type="hidden" id="active_to" value="0"><br>
<textarea id="result" name="result" rows="10" cols="20" style="display:none;"></textarea>
<input type="submit" value="speichern">
</form>


<iframe name="frame" id="frame" src="" style="width:200px; height:20px;display:none;"></iframe>
</div>
</div>

<style>

.c {float:left;width:404px;margin: 5px 1px;border: 1px dotted #000;}
.c100{width:100%!important}
.cimg{width:100px;height:100px;background-size:cover !important;-webkit-background-size: cover !important;
  -moz-background-size: cover !important; -o-background-size: cover; !important} /*margin: 0 auto;*/
  
.cimg{float:left;}
.c_in{float:left; width:40%; padding:10px 5%; text-align:center;font-size:11px;}
.ibut{float:right;}
.imgpre{width:100px;}
.clear{clear:both}

body {
  /* Prevent the user selecting text in the example */
  user-select: none;
}

.dragzone, .dropzoneframe {width:404px; height:100px;  background: #EDEDED;}

.dropzone {
  float:left;
  width: 100px;
  height: 100px;
  background: #C9EAFF;
  margin: 0px;
  padding:0px;
  border-right:1px solid #000;
}
.dropzone0 {
  float:left;
  width: 100px;
  font-size:11px;
  border-right:1px solid #000;
  text-align:center;
}
.dropzoneframe0{width:404px;}

.dropzone.dragover {
  background-color: #CCCCCC;
}

.dragging {
  opacity: 0.5;
}
</style>

<script>
// add draggable attributes to containers
let dragged;
let result = ''; 

dragel = [<?php foreach($alldrag as $k) echo '\'',$k,'\','; ?>];
for (var i = 0; i < dragel.length; i++) {
	/* events fired on the draggable target */
	const source = document.getElementById(dragel[i]);
	source.addEventListener("drag", (event) => {
	  console.log("dragging");
	});

	source.addEventListener("dragstart", (event) => {
	  // store a ref. on the dragged elem
	  dragged = event.target;
	  // make it half transparent
	  event.target.classList.add("dragging");
	  document.getElementById('active_from').value=source.id;
	});

	source.addEventListener("dragend", (event) => {
	  // reset the transparency
	  event.target.classList.remove("dragging");
	});
}
/* events fired on the drop targets */
dropelemem = [<?php foreach($alldrop as $k) echo '\'',$k,'\','; ?>];
for (var i = 0; i < dropelemem.length; i++) {
	const target = document.getElementById(dropelemem[i]);
	target.addEventListener(
	  "dragover",
	  (event) => {
		// prevent default to allow drop
		event.preventDefault();
	  },
	  false
	);

	target.addEventListener("dragenter", (event) => {
	  // highlight potential drop target when the draggable element enters it
	  if (event.target.classList.contains("dropzone")) {
		event.target.classList.add("dragover");
	  }
	});

	target.addEventListener("dragleave", (event) => {
	  // reset background of potential drop target when the draggable element leaves it
	  if (event.target.classList.contains("dropzone")) {
		event.target.classList.remove("dragover");
	  }
	});

	target.addEventListener("drop", (event) => {
	  // prevent default action (open as link for some elements)
	  event.preventDefault();
	  // move dragged element to the selected drop target
	  if (event.target.classList.contains("dropzone")) {
		event.target.classList.remove("dragover");
		event.target.appendChild(dragged);
	    document.getElementById('active_to').value=target.id;
	    addtoresult();

	  }
	});
	
	function addtoresult(){
		result += document.getElementById('active_from').value.replace('draggable_','')+';'+document.getElementById('active_to').value.replace('droptarget_','')+"\n";
		document.getElementById('result').innerHTML = result;
		document.getElementById('active_from').value = '';
		document.getElementById('active_to').value = '';
	}
}
</script>
<form method="POST" action="">
Start Hour:<input type="text" name="1"/><Br/>
End Hour:<input type="text" name="2"/><Br/>
Length of Slots:<input type="text" name="3"/><Br/>
<!--Length of Break:<input type="text" value="0"/><br/>-->
<input type="submit" name="yay"/>
</form>
<?php
if($_POST['yay']){
	boom();
}


function boom(){
	$f=$_POST['1'];
	$s=$_POST['2'];
	$n = $_POST['3'];
//if($_POST['1']<=$_POST['2']){
	bulk_add_new($f,$s,$n);
//}
}
function bulk_add_new($first,$second,$third){
	$distance = $second-$first;
	switch($third){
		case 60:
			add_six($first,$second,$third,$distance);
			break;
		case 50:
			add_six($first,$second,$third,$distance);
			break;
		case 10:
			add_ten($first,$second,$third,$distance);
			break;
		default:
			add_generate($first,$second,$third,$distance);
			break;
	}

}
function add_six($first,$second,$third,$distance){
	echo '<br/>60<br/>';
	$minutes=$distance*60;
	if ($third==60){
		$third-=10;
	}
	$slots= $minutes/$third;
	$ending='00';
	//$final_tm=50;
	while($first<$second){
		echo $first.':'.$ending.'-'.$first.':50<br/>';
		$first+=1;
	}

}
function add_ten($first,$second,$third,$distance){
	$distance= $second-$first;
	echo 'distance= '.$distance.'<br/>';
	$minutes=$distance*60;
	echo 'minutes= '.$minutes;
	$slots= $minutes/$third;
	echo '<br/>slots= '.$slots.'<br/>';
	$ending='00';
	$final_tm=60-$third;
	echo $final_tm.'<br/>';
	while($x<=$slots){
		if($ending<=40){
			$last=$ending+$third;
			$lasty=$first;
		}else{
			$last='00';
			$lasttest=$first+1;
			if($lasttest<=$second){
				$lasty=$first+1;
			}else{
				$lasty=$first;
			}
		}
		echo $first.':'.$ending.'-'.$lasty.':'.$last.'<br/>';
		if($ending<=40){

			$ending+=$third;
		
		}else{
			$ending='00';
			$first+=1;
		}

		$x +=1;
	}

}
function add_generate($first,$second,$third,$distance){
	$distance= $second-$first;
	echo 'distance= '.$distance.'<br/>';
	$minutes=$distance*60;
	echo 'minutes= '.$minutes;
	$slots= $minutes/$third;
	echo '<br/>slots= '.$slots.'<br/>';
	$ending='00';
	$final_tm=60-$third;
	echo $final_tm.'<br/>';
	while($x<=$slots){
		if($ending<=40){
			$last=$ending+$third;
			$lasty=$first;
		}else{
			$last='00';
			$lasttest=$first+1;
			if($lasttest<=$second){
				$lasty=$first+1;
			}else{
				$lasty=$first;
			}
		}
		echo $first.':'.$ending.'-'.$lasty.':'.$last.'<br/>';
		if($ending<=40){

			$ending+=$third;
		
		}else{
			$ending='00';
			$first+=1;
		}

		$x +=1;
	}

}
?>
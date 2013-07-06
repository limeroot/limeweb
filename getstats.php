<?php
// $output = array();
// exec('/var/www/limestat', $output);

function percent($number, $total){
	$a = ($number * 100)/$total;
	return round($a, 2);
}

function hddstat(){
	exec('/bin/df -h | grep -E \'/dev/sd[a-z]*|hd[a-z]*\' | awk \'{print $5}\'', $output);
	$output = str_replace('%', '', $output);
	$free = 100 - $output[0];
    $hdd[0] = array("Used", intval($output[0]) );
    $hdd[1] = array("Free", intval($free) );
    return json_encode($hdd);
}

function memorystat(){
	// $output = shell_exec('free -mo | grep \'Mem:\' | awk \'{print $3" "$4" "$5" "$6" "$7}\'');
	$output = shell_exec('liweb --mem stat');
	$output = explode(" ", $output);
	// used       free     shared    buffers     cached
	$shared = $output[2];
	$buffers = $output[3];
	$cached = $output[4];
	$tused = $output[0];
	$used = $tused - ($shared + $buffers + $cached);
	$free = $output[1];
	$total = $tused + $free;
	$mem[0] = array(name=>"Used", y=>percent($used, $total), amount=>$used, sliced=>'true', selected=>'true' );
	$mem[1] = array(name=>"Shared", y=>percent($shared, $total), amount=>$shared );
	$mem[2] = array(name=>"Buffers", y=>percent($buffers, $total), amount=>$buffers );
	$mem[3] = array(name=>"Cached", y=>percent($cached, $total), amount=>$cached );
	$mem[4] = array(name=>"Free", y=>percent($free, $total), amount=>$free );
    return json_encode($mem);
}

function localbwd(){    
    $rx[0] = shell_exec('liweb --net eth0 down');
    $tx[0] = shell_exec('liweb --net eth0 up');
    sleep(1);
    $rx[1] = shell_exec('liweb --net eth0 down');
    $tx[1] = shell_exec('liweb --net eth0 up');
    $bwd[0] = $tx[1] - $tx[0];
    $bwd[0] = ($bwd[0] * 8);
    $bwd[1] = $rx[1] - $rx[0];
    $bwd[1] = ($bwd[1] * 8);
    $time = date("U");
    $time = $time * 1000;
    $serie = array( 'x' => $time, 'up' => $bwd[0], 'down' => $bwd[1] );
    return json_encode($serie);
}

switch ($_GET["id"]) {
	case 'hdd':
		echo hddstat();
		break;
	case 'mem':
		echo memorystat();
		break;
	case 'lbwd':
		echo localbwd();
		break;
}
?>
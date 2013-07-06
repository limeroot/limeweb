<?php
	class HTML{
		public static function tabs($href, $text){
            return "<li><a href='$href'> $text</a></li>";
		}
		public static function msgbox($type='info', $text=''){
			echo "<script type=\"text/javascript\">";
			echo "$(document).ready(function(){";
				echo "$(\"div[class^='isa_']\").fadeIn('slow').delay(6000).slideUp('fast');";
				echo "});";
        	echo "</script>";
        	if ($text[0] == "E"){
        		$type = "1";
        	}elseif ($text[0] == "S") {
        		$type = "0";
        	}
        	if ($text == "0"){
        		$text = substr($type, 1);
        		$type = $type[0];
        	}
			echo "<div class=\"isa_" . $type . "\">" . $text . "</div>";
		}
	}

	class limebox{
		var $output;
		function wan($action='show', $data=''){
			if(!empty($data)){
				$type = $data['type'];
				$ifname = $data['iface'];
	            $conname = $data['name'];
	            $ip = $data['ip'];
	            $gw = $data['gateway'];
	            $uname = $data['username'];
	            $pass = $data['password'];
	            $up = $data['up'];
	            $down = $data['down'];
        	}
			switch ($action) {
				case 'create':
					if ($type == "dhcp"){ 
						$command =  "$conname use $ifname dhcp $down/$up";
					}elseif ($type == "static") {
						$command = "$conname use $ifname $ip gw $gw $down/$up";
					}else{
						$command = "$conname use $ifname user $uname password \"$pass\" $down/$up";
                    }
					break;
				case 'remove':
					$command = "delete $conname";
					break;
				case 'show':
					$command = "json_list";
				break;
				case 'show':
					$command = "json_list";
				break;
				}
			$this->output = shell_exec("sudo wan $command");
		}

		function lan($action='show', $data=''){
			if(!empty($data)){
				$ifname = $data['iface'];
	            $conname = $data['name'];
	            $ip = $data['ip'];
	            $gw = $data['gateway'];
        	}
			switch ($action) {
				case 'create':
					if(!isset($gw)){
						$command = "$conname use $ifname $ip gw $gw";
					}else{
						$command = "$conname use $ifname $ip";
					}
					break;
				case 'remove':
					$command = "delete $conname";
					break;
				case 'show':
					$command = "json_list";
					break;
			}
			$this->output = shell_exec("sudo lan $command");
		}

		function client($action='show', $data=''){
			if(!empty($data)){
				$lan = $data['lan'];
				$user = $data['user'];
	            $pass = $data['password'];
				$mac = $data['mac'];
	            $ip = $data['ip'];
	            $content = $data['userlist'];
        	}
			switch ($action) {
				case 'add':
					$command =  "$lan set name \"$user\" password \"$password\" mac $mac ip $ip";
					break;
				case 'usefile':
					$file = '/tmp/limeusers.db';
					file_put_contents($file, $content);
					$command = "$lan set file /tmp/limeusers.db";
					break;
				case 'show':
					echo "content unavailable for this version";
				break;
				}
			$this->output = shell_exec("limebox lan $command");
		}

		function devices(){
			$this->output = shell_exec("limebox device json_list");
		}
	}

	class json_helper{
		var $values;
		function decode($json=''){
			if (sizeof($json) != 1){
                $this->values[0] = $json;
            }else{
                foreach ($json as $name => $value) {
                    $this->values = $value;
                }
            }
		}
	}

	class manager{
		var $output;
		function newState($action=''){
			switch ($action) {
				case 'poweroff':
					$command = "poweroff";
					break;
				case 'reboot':
					$command = "reboot";
					break;
			}
			$this->output = shell_exec("sudo $command");
		}

		function webuser($action='list', $data=''){
			if(!empty($data)){
				$user = $data['id'];
	            $pass = $data['password'];
        	}
			switch ($action) {
				case 'new':
					$command = "--usr new $user $pass";
					break;
				case 'edit':
					$command = "--usr edit $user $pass";
					break;
				case 'delete':
					$command = "--usr delete $user";
					break;
				default:
					$command = "--usr list";
					break;
			}
			$this->output = shell_exec("liweb $command");
		}
	}

?>
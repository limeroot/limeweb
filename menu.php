<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
?>
<?php require 'classes.php'; ?>
<?php
	//Function Top Menu:
	function topmenu(){
		$items = array(
			'home'=>'/index.php',
	        'setup'=>'/setup/',
	        'plugins'=>'/plugins.php');
        $menu='';
		foreach ($items as $item => $url) {
			$menu = $menu . "<li><a href='$url'>" . $item . "</a></li>";
		}
		return $menu;
	}
?>
<div id="menu">
<ul class="mainmenu">
    <?php echo topmenu(); ?>
    <li><a href="#" id="showmsg">messages</a>
        <span id="floatnum"><div id="qmsg"></div></span>
        <div class="arrow_box" id="messages">
            <ul id="listmsg"></ul>
        </div>
    </li>
    <li><a href="#" id="showalarm">alerts</a>
        <span id="floatnum"><div id="qalert"></div></span>
        <div class="arrow_box" id="messages">
            <ul id="alarms"></ul>
        </div>
    </li>
</ul>
</div>
<div id="rowinfo">
    <table border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="16px"></td>
            <td width="115px">Welcome, <?php echo $_SERVER['REMOTE_USER']; ?>.</td>
            <td width="30px"></td>
            <td width="100px">Online: (not included)</td>
            <td width="30px"></td>
            <td>Ram: <?php echo shell_exec('liweb --mem ram free'); ?>Mb Free</td>
            <td width="35px"></td>
            <td>Average: (not included) Kb/s</td>
        </tr>
    </table>
</div>
<div id="sidebar">
    <ul class="menu">
        <?php
            foreach (glob($_SERVER['DOCUMENT_ROOT'] . "/plugins/*", GLOB_ONLYDIR) as $pluginName) {
                $dir = glob($pluginName . "/*", GLOB_ONLYDIR);
                $i = count($dir);
                if ($i == 0){
                    echo "<li><a href='/plugins/".basename($pluginName)."'>".basename($pluginName)." <img src=\"/plugins/" . basename($pluginName) . "/icon.png\" width=\"16px\" id=\"ext_icon\"/></a></li>";
                }else{
                    echo "<li><a href='#'>".basename($pluginName)." <img src=\"/plugins/" . basename($pluginName) . "/icon.png\" width=\"16px\" id=\"ext_icon\"/></a><ul>";
                    foreach (glob($pluginName . "/*", GLOB_ONLYDIR) as $subfolder) {
                        echo "<li><a href='/plugins/".basename($pluginName)."/".basename($subfolder)."'>".basename($subfolder)."</a></li>";
                    }
                    echo "</ul></li>";
                }
            }
        ?>
    </ul>
</div>
<script>
$(document).ready(function() {
    ajaxd();
    menus();
});
function ajaxd() {
    $("#alarms").empty();
    $("#qalert").empty();
    $("#listmsg").empty();
    $("#qmsg").empty();
    $.ajax({
        'url' : '/alerts.php',
        dataType: 'json',
        success: function(alert){
            var nalerts = alert.length;
            $.each(alert, function(key, value){
                $("#alarms").append('<li>'+value.title+': '+value.alert+'<span class=\"info\">'+value.date+' by '+value.origin+'</span></li>');
            });
            $("#alarms").append('<li><div class=\"title\"><center>Show All</center></div></li>');
            $("#qalert").append(nalerts);
        }
    });
    $.ajax({
        'url' : '/messages.php',
        dataType: 'json',
        success: function(msg){
            var nmsgs = msg.length;
            $.each(msg, function(key, value){
                $("#listmsg").append('<li>'+value.title+'<span class=\"data\">'+value.abstract+'</span><span class=\"info\">'+value.date+' by '+value.origin+'</span></li>');
            });
            $("#listmsg").append('<li><div class=\"title\"><center>Show All</center></div></li>');
            $("#qmsg").append(nmsgs);
        }
    });
}
function menus() {
    var menu_ul = $('.menu > li > ul'),
    menu_a  = $('.menu > li > a');
    menu_ul.hide();
    menu_a.click(function() {
        if(!$(this).hasClass('active')) {
            menu_a.removeClass('active');
            menu_ul.filter(':visible').slideUp('normal');
            $(this).addClass('active').next().stop(true,true).slideDown('fast');
        } else {
            $(this).removeClass('active');
            $(this).next().stop(true,true).slideUp('fast');
        }
        e.preventDefault();
    });
    $(".arrow_box").hide();
    $("#showmsg").click(function(){$(".arrow_box").eq(0).fadeIn("slow");$(".arrow_box").eq(1).hide();});
    $("#showalarm").click(function(){$(".arrow_box").eq(1).fadeIn("slow");$(".arrow_box").eq(0).hide();});
    $(document).mouseup(function(e){ if ($(".arrow_box").is(":visible")){$(".arrow_box").eq(1).hide();$(".arrow_box").eq(0).hide();}});
    var sname = "<?php echo basename($_SERVER['SCRIPT_NAME']); ?>";
    var mname = "<?php echo $_SERVER['REQUEST_URI']; ?>";
    var dname = "<?php echo substr_replace($_SERVER['REQUEST_URI'],"",-1); ?>";
    var ditem = "<?php echo dirname($_SERVER['REQUEST_URI']); ?>";
    $('.mainmenu > li > a[href$="' + mname + '"]').addClass('selected');
    $('.mainmenu > li > a[href$="' + ditem + '/"]').addClass('selected');
    $('.hmenu > li > a[href$="/' + sname + '"]').addClass('active');
    $('.menu > li > a[href$="' + dname + '"]').addClass('actived');
    $('.menu > li > a[href$="' + ditem + '"]').addClass('actived');
}
</script>

<!-- TODO HERE:
Limit the number of messanges and alerts to show -->
<!DOCTYPE html>
<html>
    <head>
        <title>LimeRoot</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- The follow lines is only to prevent caching of the preview of this dummy in some sites, pls remove after the first beta release if it include limeweb. DELETE FROM HERE-->
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
        <meta http-equiv="pragma" content="no-cache" />
        <!-- TO HERE -->
        <link rel="stylesheet" type="text/css" href="../css/body.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/table.css" />
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#type").change(function(){
                    var value=$(this).val();
                    switch(value){
                    case 'static':
                        $("#static").fadeIn('slow', function(){
                            $("#ppp").fadeOut('slow');
                        });
                    break;
                    case 'ppp':
                        $("#ppp").fadeIn('slow', function(){
                            $("#static").fadeOut('slow');
                        });
                    break;
                    default:
                        $("#static").fadeOut('slow');
                        $("#ppp").fadeOut('slow');
                    }
                });
            });
        </script>
    </head>
    <body>
        <div id="back_ribbon"></div><div id="back_ribbon2"></div>
        <div id="content">
            <?php include ("../menu.php"); ?>
            <div id="page">
                <?php
                    if (isset($_POST['action'])){
                        $limenet = new limebox;
                        $limenet->wan($_POST['action'], $_POST);
                        if (is_null($limenet->output)){
                            $msg = "Action ready: " . $_POST['action'] . " " . $_POST['name'];
                            HTML::msgbox('0', $msg);
                        }else{
                            HTML::msgbox('info', $limenet->output);
                        }
                    }
                ?>
                <h2 id="title">Setup</h2><br/>
                <table class="tabs" border="0" cellspacing="0" cellpadding="0" width="100%">
                    <?php include ("tabs.php"); ?>
                    <tr><td id="area">
                        <p>Here you can configure or reconfigure all settings about network interfaces.</p>
                        <h3 id="subtitle">Configured Interfaces - WAN</h3><br/>
                        <div class="limetable" >
                            <table >
                                <tr>
                                    <td>Name</td>
                                    <td>Device</td>
                                    <td>IP Address</td>
                                    <td>Connection</td>
                                    <td>Gateway</td>
                                    <td>Bandwidth<br/> UP/DOWN</td>
                                    <td>Delete</td>
                                </tr>
                                <?php
                                    $json = new limebox;
                                    $json->wan('show');
                                    $output = json_decode($json->output, true);
                                    $test = new json_helper;
                                    $test->decode($output);
                                    $values = $test->values;
                                    if(empty($values)){
                                        echo "<tr><td colspan=\"7\">(WAN not configured)</td></tr>";
                                    }else{
                                        for ($i = 0; $i <= sizeof($values)-1; $i++) {
                                            echo '<FORM method=post action="wan.php">';
                                            echo '<input type="hidden" name="action" value="remove">';
                                            echo "<tr>";
                                            echo "<td>" . $values[$i]['name'] . "</td>";
                                            echo '<input type="hidden" name="name" value="' . $values[$i]['name'] . '">';
                                            echo "<td>" . $values[$i]['device'] . "</td>";
                                            echo "<td>" . $values[$i]['ip'] . "</td>";
                                            echo "<td>" . $values[$i]['connection'] . "</td>";
                                            echo "<td>" . $values[$i]['gateway'] . "</td>";
                                            echo "<td>" . $values[$i]['bandwidth'] . "</td>";
                                            echo '<td><INPUT type="submit" value=" Remove "/></td>';
                                            echo "</tr>";
                                            echo "</FORM>";
                                        }
                                    }
                                ?>
                            </table>
                        </div><br/>
                        <h3 id="subtitle">WAN Interfaces</h3><br/>
                        <FORM method=post action="wan.php">
                            <input type="hidden" name="action" value="create">
                            <div class="limetable" >
                                <table width="65%">
                                    <tr>
                                        <td></td>
                                        <td width="30%"></td>
                                    </tr>
                                    <tr>
                                        <td>Please, select the interface that you want set as WAN from the list:</td>
                                        <td>
                                            <SELECT name="iface">
                                            <?php
                                                $json = new limebox;
                                                $json->devices();
                                                $output = json_decode($json->output, true);
                                                foreach($output['device'] as $key=>$val){
                                                    if (($val['state']=='DOWN' OR $val['state']=='UNKNOWN') && isset($val['mac'])){
                                                        echo "<option>" . $val['name'] . "</option>";
                                                    }
                                                }                                       
                                            ?>
                                            </SELECT>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Give a connection name (ie.: The name of the ISP, or plan):</td>
                                        <td><INPUT type="text" name="name" size="15"></td>
                                    </tr>
                                    <tr>
                                        <td>Select the connection type:</td>
                                        <td>
                                            <SELECT name="type" id="type">
                                                <OPTION value="dhcp">dhcp</OPTION>
                                                <OPTION value="static">static</OPTION>
                                                <OPTION value="ppp">ppp</OPTION>
                                            </SELECT>
                                        </td>
                                    </tr>
                                    <tr class="hide" id="static">
                                        <td colspan="2" style="background-color:#DFDFDF; ">
                                            <table width="100%">
                                                <tr>
                                                    <td>IP Address:</td>
                                                    <td>Gateway:</td>
                                                </tr>
                                                <tr>
                                                    <td><center><INPUT type="text" name="ip" size="15"/></center></td>
                                                    <td><center><INPUT type="text" name="gateway" size="15"/></center></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr class="hide" id="ppp">
                                        <td colspan="2" style="background-color:#DFDFDF; ">
                                            <table width="100%">
                                                <tr>
                                                    <td>Username:</td>
                                                    <td>Password:</td>
                                                </tr>
                                                <tr>
                                                    <td><center><INPUT type="text" name="username"/></center></td>
                                                    <td><center><INPUT type="password" name="password"/></center></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Upload:</td>
                                        <td><INPUT type="text" name="up" size="5"/> kB/s</td>
                                    </tr>
                                    <tr>
                                        <td>Download:</td>
                                        <td><INPUT type="text" name="down" size="5"/> kB/s</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <INPUT type="submit" value=" Just do it. "/>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </FORM>
                        <br/>
                    </td></tr>
                </table>
            </div>
        </div>
    </body>
</html>
<!-- TODO HERE
Define p and h1,h2,h3 css style -->
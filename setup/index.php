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
    </head>
    <body>
        <div id="back_ribbon"></div><div id="back_ribbon2"></div>
        <div id="content">
            <?php include ("../menu.php"); ?>
            <div id="page">
                <h2 id="title">Setup</h2><br/>
                <!-- <p id="area">Here, you can get new plugins for your limeroot system.<br/> -->
                <table class="tabs" border="0" cellspacing="0" cellpadding="0" width="100%">
                    <?php include ("tabs.php"); ?>
                    <tr><td id="area">
                        <br/>
                        <h3 id="subtitle">Configured Network Devices</h3><br/>
                        <div class="limetable" >
                            <table >
                                <tr>
                                    <td>Interface</td>
                                    <td>Network</td>
                                    <td>MAC</td>
                                    <td>State</td>
                                    <td>Rx</td>
                                    <td>Tx</td>
                                </tr>
                                <?php
                                    $json_output = shell_exec('limebox device json_list');
                                    $output = json_decode($json_output, true);
                                    foreach($output['device'] as $key=>$val){ 
                                        if (isset($val['ipv4']) && $val['name'] !== 'lo'){
                                            echo "<tr>";
                                            echo "<td>" . $val['name'] . "</td>";
                                            echo "<td>" . $val['ipv4'] . "</td>";
                                            echo "<td>" . $val['mac'] . "</td>";
                                            echo "<td>" . $val['state'] . "</td>";
                                            echo "<td>" . shell_exec('liweb --net ' . $val['name'] . ' down') . " Kbits </td>";
                                            echo "<td>" . shell_exec('liweb --net ' . $val['name'] . ' up') . " Kbits </td>";
                                            echo "</tr>";
                                        }
                                    }
                                ?>
                            </table>
                        </div>
                        <br/>
                    </td></tr>
                </table>
            </div>
        </div>
    </body>
</html>
<!-- TODO HERE
Define p and h1,h2,h3 css style -->
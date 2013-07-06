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
        <link rel="stylesheet" type="text/css" href="/css/body.css" />
        <link rel="stylesheet" type="text/css" href="/css/menu.css" />
        <link rel="stylesheet" type="text/css" href="/css/table.css" />
        <script type="text/javascript" src="/js/jquery.js"></script>
    </head>
    <body>
        <div id="back_ribbon"></div><div id="back_ribbon2"></div>
        <div id="content">
            <?php include ($_SERVER['DOCUMENT_ROOT'] . "/menu.php"); ?>
            <div id="page">
				<?php
                    if (isset($_POST['action'])){
                        $useradd = new limebox;
                        $useradd->client($_POST['action'], $_POST);
                        if (is_null($useradd->output)){
                            $msg = " Sorry, action '" . $_POST['action'] . "' return an empty state.";
                            HTML::msgbox(2, $msg);
                        }else{
                            HTML::msgbox($useradd->output, 0);
                        }
                    }
                ?>
				<h2 id="title">Users</h2><br/>
				<table class="tabs" border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td>
							<ul class="hmenu">
								<?= HTML::tabs('./index.php', 'Main'); ?>
								<?= HTML::tabs('#', 'Manage'); ?>
							</ul>
						</td>
					</tr>
                    <tr>
						<td id="area">
                        <h3 id="subtitle">Add Single User</h3><br/>	
                        <FORM method=post action="index.php">
                            <input type="hidden" name="action" value="add">
							<div class="limetable" >
								<table width="65%">
									<tr>
                                        <td></td>
                                        <td width="40%"></td>
                                    </tr>
                                    <tr>
                                        <td>Use LAN:</td>
                                        <td>
                                            <SELECT name="lan">
                                                <?php
                                                    $json = new limebox;
                                                    $json->lan('show');
                                                    $output = json_decode($json->output, true);
                                                    $test = new json_helper;
                                                    $test->decode($output);
                                                    $values = $test->values;
                                                    for ($i = 0; $i <= sizeof($values)-1; $i++) {
                                                        echo "<option>" . $values[$i]['name'] . "</option>";
                                                    }
                                                ?>
                                            </SELECT>
                                        </td>
                                    </tr>
									<tr>
										<td>Username:</td>
										<td><INPUT type="text" name="user" size="17"></td>
									</tr>
									<tr>
										<td>Password:</td>
										<td><INPUT type="password" name="password" size="17"></td>
									</tr>
									<tr>
										<td>MAC Number:</td>
										<td><INPUT type="text" name="mac" maxlength="17" size="17"></td>
									</tr>
                                    <tr>
                                        <td>IP Number:</td>
                                        <td><INPUT type="text" name="ip" maxlength="15" size="17"></td>
                                    </tr>
									<tr>
										<td></td>
										<td><INPUT type="submit" value=" Just do It. "/></td>
									</tr>
								</table>
							</div>
						</FORM>
                        <h3 id="subtitle">Add Users (fast mode)</h3><br/>    
                        <FORM method=post action="index.php">
                            <input type="hidden" name="action" value="usefile">
                            <div class="limetable" >
                                <table width="65%">
                                    <tr>
                                        <td></td>
                                        <td width="60%"></td>
                                    </tr>
                                    <tr>
                                        <td>Use LAN:</td>
                                        <td>
                                            <SELECT name="lan">
                                                <?php
                                                    $json = new limebox;
                                                    $json->lan('show');
                                                    $output = json_decode($json->output, true);
                                                    $test = new json_helper;
                                                    $test->decode($output);
                                                    $values = $test->values;
                                                    for ($i = 0; $i <= sizeof($values)-1; $i++) {
                                                        echo "<option>" . $values[$i]['name'] . "</option>";
                                                    }
                                                ?>
                                            </SELECT>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Users List:<br/>Sintax: ip,mac.name,passord</td>
                                        <td>
                                            <textarea name="userlist" cols="40"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><INPUT type="submit" value=" Just do It. "/></td>
                                    </tr>
                                </table>
                            </div>
                        </FORM>
						</td>
					</tr>
                </table>
            </div>
        </div>
    </body>
</html>

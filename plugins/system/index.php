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
                        $limesys = new manager;
                        $limesys->webuser($_POST['action'], $_POST);
                        if (is_null($limesys->output)){
                            $msg = "Sorry, action: " . $_POST['action'] . "return a empty state.";
                            HTML::msgbox('info', $msg);
                        }else{
                            HTML::msgbox($limesys->output, 0);
                        }
                    }
                ?>
				<h2 id="title">System</h2><br/>
				<table class="tabs" border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td>
							<ul class="hmenu">
								<?= HTML::tabs('./index.php', 'Main'); ?>
								<?= HTML::tabs('./states.php', 'States'); ?>
							</ul>
						</td>
					</tr>
                    <tr>
						<td id="area">
                        <h3 id="subtitle">Lime Admins</h3><br/>
                        <div class="limetable" >
                                <table width="50%">
                                    <tr>
                                        <td width="70%">Name</td>
                                        <td>Delete</td>
                                    </tr>
                                    <?php
                                        $liweb = new manager;
                                        $liweb->webuser('list');
                                        $output = explode("\n", $liweb->output);
                                        foreach ($output as $value) {
                                            if ($value != ''){
                                                echo '<FORM method=post action="index.php">';
                                                echo '<input type="hidden" name="action" value="delete">';
                                                echo "<tr>";
                                                echo "<td>" . $value . "</td>";
                                                echo '<input type="hidden" name="id" value="' . $value . '">';
                                                echo '<td><INPUT type="submit" value=" Remove "/></td>';
                                                echo "</tr>";
                                                echo "</FORM>";
                                            }
                                        }
                                    ?>
                                </table>
                        </div><br/>
                        <h3 id="subtitle">Limeweb</h3><br/>	
                        <FORM method=post action="index.php">
                            <input type="hidden" name="action" value="new">
							<div class="limetable" >
								<table width="65%">
									<tr>
                                        <td></td>
                                        <td width="40%"></td>
                                    </tr>
									<tr>
										<td>Username:</td>
										<td><INPUT type="text" name="id" size="15" value="<?php echo $_SERVER['REMOTE_USER'] ;?>"></td>
									</tr>
									<tr>
										<td>Password:</td>
										<td><INPUT type="password" name="password" size="15"></td>
									</tr>
									<tr>
										<td>Port:</td>
										<td><?php echo $_SERVER['SERVER_PORT']; ?></td>
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

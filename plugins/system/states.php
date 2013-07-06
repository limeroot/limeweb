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
                        $limesys->newState($_POST['action']);
                        if (is_null($limesys->output)){
                            $msg = "Action: " . $_POST['action'] . " ready.";
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
                    <tr><td id="area">
                        <h3 id="subtitle">Change LimeRoot State:</h3><br/>
                        <div class="limetable" >
                            <p>
								<FORM method=post action="states.php">
									Select New State: <SELECT name="action">
										<option value="reboot">Reboot</option>
										<option value="poweroff">Poweroff</option>
									</SELECT>
									<br/><br/><br/><br/>
									<INPUT type="submit" value=" Just do It. "/>
								</FORM>
                            </p>
                        </div>
                        <br/>
                    </td></tr>
                </table>
            </div>
        </div>
    </body>
</html>

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
        <link rel="stylesheet" type="text/css" href="css/body.css" />
        <link rel="stylesheet" type="text/css" href="css/menu.css" />
        <link rel="stylesheet" type="text/css" href="css/table.css" />
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script>
    </head>
    <body>
        <script>
        var memtotal = "<?php echo exec('liweb --mem total'); ?>";
        $(function(){
            Highcharts.setOptions({
                global: {
                    useUTC: false
                }
            });
            var memchart = {
                chart: {
                    type: 'pie',
                    renderTo: container2,
                    marginRight: -80,
                    height: 200,
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                },
                credits: {
                    text: 'LimeRoot.org',
                    href: 'http://www.limeroot.org'
                },
                title: {
                    floating: true,
                    align: 'left',
                    text: 'Memory (' + memtotal + ' MB)'
                },
                tooltip: {
                    headerFormat: '<b>{point.key}</b><br/>',
                    pointFormat: '{series.name}: <b>{point.amount} MB<br/>({point.percentage}%)</b>',
                    percentageDecimals: 1,
                },
                legend: {
                    layout: 'vertical',
                    align: 'left',
                    verticalAlign: 'top',
                    floating: true,
                    x: 0,
                    y: 30
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        innerSize: '80%',
                        dataLabels: {
                            enabled: false,
                        },
                        showInLegend: true
                    }
                },
                series: []
            };

            $.getJSON('getstats.php?id=mem', function(data) {        
                var series = {
                    data: [],
                    name: 'Mem'
                }; 
                $.each(data, function(key, value) {
                    series.data.push(value);
                });
                memchart.series.push(series);
                var chart = new Highcharts.Chart(memchart);
            });

            $('#container').highcharts({
                colors: [
                   '#89A54E', 
                   '#3D96AE'
                ],
                chart: {
                    height: 180,
                    type: 'spline',
                    events: {
                        load: function() {
                            var series = this.series[0];
                            var series1 = this.series[1];
                            setInterval(function() {
                                $.get('getstats.php?id=lbwd',null,function(data){
                                    x=data.x
                                    y=data.down;
                                    z=data.up;
                                series.addPoint([x, y], true, true);
                                series1.addPoint([x, z], true, true);
                                },'json');
                            }, 5000);
                        }
                    }
                },
                credits: {
                    text: 'LimeRoot.org',
                    href: 'http://www.limeroot.org'
                },
                title: {
                    text: 'Live Graph',
                    style: {
                        color: '#75AD4F',
                        fontSize: '16px',
                    }
                },
                subtitle: {
                    text: '(Local Bandwidth)'
                },
                xAxis: {
                    type: 'datetime',
                    tickPixelInterval: 150
                },
                yAxis: {
                    title: {
                        text: 'SpeeD'
                    },
                    labels: {
                        format: '{value} kb/s'
                    },
                    gridLineColor: '#DAE8DD',
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#2C773B'
                    }]
                },
                plotOptions:{
                    series: {
                        threshold:0
                    }
                },
                tooltip: {
                    formatter: function() {
                            return '<b>'+ this.series.name +'</b><br/>'+
                            Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +'<br/>'+
                            Highcharts.numberFormat(this.y, 2);
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    floating: true,
                    x: 0,
                    y: 0
                },
                series:[{
                name: 'Input',
                data: (function() {
                    var data = [],
                        time = (new Date()).getTime(),
                        i;
    
                    for (i = -19; i <= 0; i++) {
                        data.push({
                            x: time + i * 5000,
                            y: 0
                        });
                    }
                    return data;
                })()
            }, {
                name: 'Output',
                data: (function() {
                    var data = [],
                        time = (new Date()).getTime(),
                        i;
    
                    for (i = -19; i <= 0; i++) {
                        data.push({
                            x: time + i * 5000,
                            y: 0
                        });
                    }
                    return data;
                })()
            }]
            });
        });
        </script>
        <div id="back_ribbon"></div><div id="back_ribbon2"></div>
        <div id="content">
            <?php include ("menu.php"); ?>
            <div id="page">
                <h2 id="title">Overview</h2><br/>
                <table class="tabs" border="0" cellspacing="0" cellpadding="0" width="100%">
                    <?php include ("tabs.php"); ?>
                    <tr><td id="area">
                        <h3 id="subtitle">Local Traffic</h3><br/>
                        <center><div id="container" style="max-width:900px"></div></center>
                        <br/>
                        <h3 id="subtitle">About Server</h3><br/>
                        <div class="limetable">
                            <table width="100%">
                                <tbody class="indextable">
                                <tr>
                                    <td colspan="1" rowspan="7" width="33%"><div id="container2" style="max-width:350px;"></div></td>
                                    <td colspan="2" rowspan="1">Other data about this server</td>
                                </tr>
                                <tr>
                                    <td width="20%">HDD Usage</td>
                                    <td>
                                        <?php
                                            $output = shell_exec('liweb --hdd');
                                            $output = explode("\n", $output);
                                            foreach ($output as $key => $value) {
                                                $info = explode(' ', $value);
                                                if (count($info) > 1){
                                                $fs = $info[0];
                                                $size = $info[1];
                                                $used = $info[2];
                                                $percent = $info[3];
                                                $mountp = $info[4];
                                                echo "$fs on $mountp:<br/>" . '<progress max="100" value="' . substr_replace($percent ,"",-1) . '"></progress><span class="progress-value">' . $percent . " ($used / $size)" . '</span>';
                                                echo "<br/>";
                                                }
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Name</td>
                                    <td><?php system("hostname"); ?></td>
                                </tr>
                                <tr>
                                    <td>Plataform</td>
                                    <td><?php system("uname -m"); ?></td>
                                </tr>
                                <tr>
                                    <td>System</td>
                                    <td><?php system("uname -o"); ?></td>
                                </tr>
                                <tr>
                                    <td>Version</td>
                                    <td>Kernel: <?php system("uname -r"); ?><br/>
                                        <?php system("uname -v"); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>CPU Model</td>
                                    <td><?php system("grep 'model name' /proc/cpuinfo | cut -d':' -f2"); ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Time</td>
                                    <td><?php system("date"); ?> <br/>
                                        Server UpTime: <?php system("uptime | awk '{print $3}'"); ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div><br/>
                    </td></tr>
                </table>
            </div>
        </div>
    </body>
</html>
<!-- TODO HERE
Define p and h1,h2,h3 css style -->

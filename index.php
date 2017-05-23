<?php header('refresh: 1'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>sysi</title>
</head>
<body>
<h1>Load Average</h1>
<table>
<tr>
<td align="center">1min</td>
<td align="center">5min</td>
<td align="center">15min</td>
</tr>
<tr>
<?php $ans= explode(' ',shell_exec("cat /proc/loadavg | awk '{print $1, $2, $3}'"););
	for ($i=0; $i < 3; $i++) { 
		echo '<td align="center">$ans[$i]</td>';
	}
?>
</tr>
</table>
<h1>CPU</h1>
<pre>----- Usr+nice ------------ sys ---------- idle ---------- iowait</pre>
<pre><?php echo shell_exec("cat /var/log/mpstat.log | tail -n 1 | awk '{printf(\"%15f %15s %15s %15s \n\",$3+$4, $5, $12, $6)}'");?></pre>
<h1>Disk and Inodes info</h1>
<pre>----- File system ---- %Free space ---- Free space --- %Free inodes --  Free inodes</pre>
<pre><?php echo shell_exec("cat /var/log/df.log | grep -v /dev* | grep -v /proc* | grep -v /sys* | awk ' NR>1 {printf(\"%15s %15s %15s %15s %15s \n\",$1,(100-$2),$3,(100-$4),$5)}'");?></pre>
<h1>TCP connection</h1>
<pre><?php echo shell_exec("cat /var/log/tcp.log");?></pre>
<h1>UDP connection</h1>
<pre><?php echo shell_exec("cat /var/log/udp.log");?></pre>
<h1>Network Loading</h1>
<pre>---- inteface --- bytes_recived --- packet_recived --- bytes_transmit --- packet_transmit</pre>
<pre><?php echo shell_exec("cat /var/log/network | awk '  {printf(\"%15s %15s %15s %15s %15s \n\",$1,$2,$3,$10,$11)}'");?></pre>
<h1>TCP connection status</h1>
<pre> ESTABLISHED <?php echo shell_exec("netstat | grep EST | wc -l");?></pre>
<h1>Load Disks</h1>
<pre> -------- Device ---------- r/s ---------- w/s ---------- await ---------- %util</pre>
<pre><?php echo shell_exec("cat /var/log/iostat.log | tail -n 3 |awk ' {printf(\"%15s %15s %15s %15s %15s \n\",$1, $4, $5, $10, $14)}'");?></pre>
</body>
</html>

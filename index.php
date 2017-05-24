<?php header('refresh: 2'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>sysinfo</title>
</head>
<body>
<?php echo "NGINX_ADDR: " . $_SERVER['REMOTE_ADDR'] . "<br>"; 
	echo "NGINX_PORT: " . $_SERVER['REMOTE_PORT'] . "<br>";
	echo "CLIENT_ADDR: " . $_SERVER['HTTP_X_REAL_IP'] . "<br>"; 
	echo "CLIENT_PORT: " . $_SERVER['HTTP_X_FORWARDER_FOR_PORT'] . "<br>";  
	echo "NGINX_VERSION: " . $_SERVER['HTTP_X_NGX_VERSION'];  

?>

<h1 align="left">Load Average</h1>
<table border="1px">
<tr>
<td align="center">1min</td>
<td align="center">5min</td>
<td align="center">15min</td>
</tr>
<tr>
<?php $ans =preg_split("/[^0-9\.\,]+/",shell_exec("cat /proc/loadavg | awk '{print $1, $2, $3}'")); 
$ncpu = shell_exec("lscpu | grep ^CPU\(s\) | awk '{print $2}'");
$warn = $ncpu * 0.80;
$crit = $ncpu * 0.90;
for ($i=0; $i < 3; $i++) {
        if($ans[$i] >= $crit ){
        echo "<td align='center'><span style='color: red;'>$ans[$i]</span></td>";
        }
        elseif($ans[$i] >= $warn and $ans[$i] < $crit) {
        echo "<td align='center'><span style='color: yellow;'>$ans[$i]</span></td>";
        }
        else {
                echo "<td align='center'><span style='color: blue;'>$ans[$i]</span></td>";
        }
}
?>
</tr>
</table>

<h1 align="left">CPU</h1>
<table border="1px">
	<tr>
		<td align="center">%Usr+%nice</td>
		<td align="center">%sys</td>
		<td align="center">%idle</td>
		<td align="center">%iowait</td>
	</tr>
	<tr>
<?php $ans =preg_split("/[^0-9\.\,]+/",shell_exec("cat /var/log/mpstat.log | tail -n 1 | awk '{print $3+$4, $5, $12, $6}'"));
for ($i=0; $i < 4; $i++) { 
	echo "<td align='center'>$ans[$i]</td>";
}?>
	</tr>
</table>

<h1 align="left">Disk and Inodes info</h1>
<table border="1px">
	<tr>
		<td align="center">File system</td>
		<td align="center">%Free space</td>
		<td align="center">Free space</td>
		<td align="center">%Free inodes</td>
		<td align="center">Free inodes</td>
	</tr>
		<?php $all = preg_split("/\s[a-z]/",shell_exec("cat /var/log/df.log | grep -v /dev* | grep -v /proc* | grep -v /sys* | awk ' NR>1 {print $1,(100-$2), $3, (100-$4), $5}'"));
		$c = 0;
		$count = count($all);
		while ($c < $count) {
			$ans = preg_split("/[^A-Za-z0-9\.\,]+/","$all[$c]");
			echo "<tr>";
			for ($i=0; $i < 5; $i++) { 
				echo "<td align='center'>$ans[$i]</td>";
			}
			echo "</tr>";
			$c = $c + 1;
		}
			?>
</table>

<h1 align="left">TCP connection</h1>
<table border="1px">
		<?php $all = preg_split("/\n/",shell_exec("cat /var/log/tcp.log"));
		$c = 0;
		$count = count($all);
		while ($c < $count-1) {
			$ans = preg_split("/\s+/","$all[$c]");
			echo "<tr>";
			for ($i=0; $i < 5; $i++) { 
				echo "<td align='center'>$ans[$i]</td>";
			}
			echo "</tr>";
			$c = $c + 1;
		}?>
</table>
<h1 align="left">UDP connection</h1>
<table border="1px">
		<?php $all = preg_split("/\n/",shell_exec("cat /var/log/udp.log"));
		$c = 0;
		$count = count($all);
		while ($c < $count-1) {
			$ans = preg_split("/\s+/","$all[$c]");
			echo "<tr>";
			for ($i=0; $i < 4; $i++) { 
				echo "<td align='center'>$ans[$i]</td>";
			}
			echo "</tr>";
			$c = $c + 1;
		}?>
</table>
<h1 align="left">Network Loading</h1>
<table border="1px">
<tr>
<td align="center">inteface</td>
<td align="center">bytes_recived</td>
<td align="center">packet_recived</td>
<td align="center">bytes_transmit</td>
<td align="center">packet_transmit</td>
</tr>
		<?php $all = preg_split("/\n/",shell_exec("cat /proc/net/dev | awk '{print $1, $2, $3, $10, $11}'"));
		$c = 2;
		$count = count($all);
		while ($c < $count-1) {
			$ans = preg_split("/[\s\|]+/","$all[$c]");
			echo "<tr>";
			for ($i=0; $i < 5; $i++) { 
				echo "<td align='center'>$ans[$i]</td>";
			}
			echo "</tr>";
			$c = $c + 1;
		}?>
</table>
<h1 align="left">TCP connection status</h1>
<table border="1px">
<tr>
	<td align="center">Status</td>
	<td align="center">Quantity</td>
</tr>
<tr>
	<td align="center">ESTABLISHED</td>
	<td align="center"><?php echo shell_exec("netstat | grep EST | wc -l");?></td>
</tr>
<tr>
	<td align="center">TIME_WAIT</td>
	<td align="center"><?php echo shell_exec("netstat | grep TIME | wc -l");?></td>
</tr>
</table>
<h1 align="left">Load Disks</h1>
<table border="1px">
	<tr>
		<td align="center">Device</td>
		<td align="center">r/s</td>
		<td align="center">r/s</td>
		<td align="center">await</td>
		<td align="center">%util</td>
	</tr>
	<tr>
		<?php $ans =preg_split("/\s+/",shell_exec("cat /var/log/iostat.log | tail -n 3 |awk ' {print $1, $4, $5, $10, $14}'"));
		for ($i=1; $i < 6; $i++) { 
			echo "<td align='center'>$ans[$i]</td>";}?>
	</tr>
</table>
</body>
</html>

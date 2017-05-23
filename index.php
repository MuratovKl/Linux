<?php header('refresh: 15'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>sysi</title>
</head>
<body>
<h1>Load Average</h1>
<?php echo shell_exec(cat /proc/loadavg | awk '{print $1" "$2" "$3}'); ?>

</body>
</html>

<!DOCTYPE html>
<html>
<body>

<?php

require 'getSensorData.php';

//echo "hiok";


$data = getAllSensorData();

echo json_encode($data);


?>
<script type="text/javascript" src="https://getfirebug.com/firebug-lite.js"></script>

</body>
</html>
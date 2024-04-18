<?php

$base_url = 'local'; // Change this to 'server' when deploying to the production server
if ($base_url === 'local') {
    require('local-server.php');
} else {
    require('live-server.php');
}

?>
 
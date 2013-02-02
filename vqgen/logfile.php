<?php
echo json_encode(file_get_contents($_GET['log'], FILE_USE_INCLUDE_PATH, null));
?>
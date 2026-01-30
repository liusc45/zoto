<?php
$path  = current_url(true)->getPath();
$module = ucfirst(substr($path,1));
echo $module;
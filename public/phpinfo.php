<?php
echo "<h2>Informações do PHP do Servidor Web</h2>";
echo "<p><strong>PHP Binary:</strong> " . PHP_BINARY . "</p>";
echo "<p><strong>PHP Version:</strong> " . PHP_VERSION . "</p>";
echo "<p><strong>PHP INI:</strong> " . php_ini_loaded_file() . "</p>";
echo "<p><strong>GD Extension:</strong> " . (extension_loaded('gd') ? 'LOADED' : 'NOT LOADED') . "</p>";
echo "<p><strong>GD Functions:</strong> " . (function_exists('imagecreatefrompng') ? 'AVAILABLE' : 'NOT AVAILABLE') . "</p>";

if (extension_loaded('gd')) {
    echo "<h3>GD Information:</h3>";
    $gd_info = gd_info();
    foreach ($gd_info as $key => $value) {
        echo "<p><strong>$key:</strong> " . (is_bool($value) ? ($value ? 'Yes' : 'No') : $value) . "</p>";
    }
}
?> 
<?php
// misc utilities

function osdi_get_options()
{
    $defaults = array(
        'osdi_checkbox_logging' => true,
        'osdi_settings_logging' => 'Enabled'
    );
    $options = get_option('osdi_settings');
    $osdi_options = wp_parse_args($options, $defaults);
    return $osdi_options;

}

if (!function_exists('osdi_log')) {
    function osdi_log($message)
    {
        $options = osdi_get_options();
        $enabled = $options['osdi_settings_logging'] == 'Enabled';
        if ($enabled) {
            if (is_array($message) || is_object($message)) {
                osdi_log_write(print_r($message, true));
            } else {
                osdi_log_write($message);
            }
        }
    }

    function osdi_log_dir()
    {
        #$log_dir= get_home_path() . '/wp-content/osdi';
        $log_dir = ABSPATH . '/wp-content/osdi';
        return $log_dir;
    }

    function osdi_log_file()
    {
        $log_file = osdi_log_dir() . '/osdi.log';
        return $log_file;

    }
}

function osdi_log_write($message)
{

    if (!file_exists(osdi_log_dir())) {
        mkdir(osdi_log_dir(), 0777, true);
        #TODO create .htaccess file
        $htaccess = "Deny from all\n";
        file_put_contents(osdi_log_dir() . '/.htaccess', $htaccess);
    }
    $handle = fopen(osdi_log_file(), 'a');
    $entry = "[" . date('Y-m-d H:i:s') . "] " . $message . "\n";
    fwrite($handle, $entry);
    fclose($handle);
}

function osdi_nav($obj)
{

    $val = $obj;
    if ($val == null) {
        $val = '';
    }
    return $val;

}


function tailCustom($filepath, $lines = 1, $adaptive = true)
{
    // Open file
    $f = @fopen($filepath, "rb");
    if ($f === false) return false;
    // Sets buffer size
    if (!$adaptive) $buffer = 4096;
    else $buffer = ($lines < 2 ? 64 : ($lines < 10 ? 512 : 4096));
    // Jump to last character
    fseek($f, -1, SEEK_END);
    // Read it and adjust line number if necessary
    // (Otherwise the result would be wrong if file doesn't end with a blank line)
    if (fread($f, 1) != "\n") $lines -= 1;

    // Start reading
    $output = '';
    $chunk = '';
    // While we would like more
    while (ftell($f) > 0 && $lines >= 0) {
        // Figure out how far back we should jump
        $seek = min(ftell($f), $buffer);
        // Do the jump (backwards, relative to where we are)
        fseek($f, -$seek, SEEK_CUR);
        // Read a chunk and prepend it to our output
        $output = ($chunk = fread($f, $seek)) . $output;
        // Jump back to where we started reading
        fseek($f, -mb_strlen($chunk, '8bit'), SEEK_CUR);
        // Decrease our line counter
        $lines -= substr_count($chunk, "\n");
    }
    // While we have too many lines
    // (Because of buffer size we might have read too many)
    while ($lines++ < 0) {
        // Find first newline and remove all text before that
        $output = substr($output, strpos($output, "\n") + 1);
    }
    // Close file and return
    fclose($f);
    return trim($output);
}


function MergeArrays($Arr1, $Arr2)
{
    foreach ($Arr2 as $key => $Value) {
        if (array_key_exists($key, $Arr1) && is_array($Value))
            $Arr1[$key] = MergeArrays($Arr1[$key], $Arr2[$key]);

        else
            if ($Value != "") {
                $Arr1[$key] = $Value;
            }
    }

    return $Arr1;

}

function osdi_prune($arr) {
    foreach ($arr as $key => $value) {
        if ( is_array($value)) {
            $arr[$key]=osdi_prune($value);
            $value=$arr[$key];
        }

        if ( $value=='' || empty($value)) {
            $arr[$key]='blank';
            unset($arr[$key]);
        }

    }
    return $arr;
}

?>
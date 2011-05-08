<?php

// Debug
function debug($data, $exit = true, $action = null, $label=null) {
    switch ($action) {
		case 'dump' :
			echo '<pre>';
        	var_dump($data);
        	echo '</pre>';
            break;
		case 'zend' :
        	Zend_Debug::dump($data, $label);
            break;
        default :
        	echo '<pre>';
            print_r($data);
            echo '</pre>';
            break;
    }

    if ($exit) { exit(); }
}

// Debug, print runtime statistics
function debug_print_stats() {
	$_st = array_sum(explode(' ', $_ENV['REQUEST_TIME']));
	$_et = substr(array_sum(explode(' ', microtime())) - $_st, 0, 7);
	$_mem = human_readable_size(memory_get_peak_usage(true), 6, 'kb');
	$_inc = count(get_included_files());

	print '<div style="margin:0 auto; margin-bottom:30px; text-align:left; font:12px Tahoma; width:80%; clear:both;">
           <b>Page gen:</b> ' . $_et . ' s&nbsp;&nbsp;&nbsp;<b>Mem peak usage:</b> ' .
		   $_mem . '&nbsp;&nbsp;&nbsp;<b>Includes:</b> ' . $_inc . '</div>';
}

// Debug, print included files
function debug_print_included_files($base_path=null, $sort=false) {
	$inc = get_included_files();

	if (null !== $base_path) {
		array_walk($inc, function (&$val, $key, $base_path) {
		    $val = str_ireplace($base_path, '', $val);
		}, $base_path);
	}

	if ($sort) { sort($inc); }

	debug($inc);
}

// Returns sizes in human readable format (e.g., 1K 234M 2G) 
function human_readable_size($val, $round = 2, $unit = 'b') {
    $units = array(
        'b' => 0,
        'kb' => 1,
        'mb' => 2,
        'gb' => 3,
        'tb' => 4,
        'pb' => 5,
        'eb' => 6,
        'zb' => 7,
        'yb' => 8
    );

    if ($val <= 0) { return '0 B'; }

    if ('auto' == $unit || 'a' == $unit) {
        $dv = floor(log($val, 1024));
        $unit = array_search($dv, $units);
    } else {
        $dv = $units[$unit];
    }

    for ($i = 0; $i < $dv; $i++) {
        $val = $val / 1024;
    }

    return round($val, $round) . ' ' . mb_convert_case($unit, MB_CASE_UPPER);
}

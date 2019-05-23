<?php

$stop = pow (2, 2);
$ords = range(32, 126);

foreach ($ords as $i) {
	
	foreach ($ords as $j) {
		
		foreach ($ords as $k) {
			foreach ($ords as $l) {
	 			$pass = sprintf('%c%c%c%c', $i, $j, $k, $l);
				$hash = hash('sha1', $pass);
				$filename = __DIR__.'/lookups/'.sprintf('%s', substr($hash, 0, 2));
				$fp = fopen($filename, 'a');
				fputs($fp, sprintf('%s%s'.PHP_EOL, substr($hash, 0, 5), $pass));
				fclose($fp);
			}
    	}
	}
}

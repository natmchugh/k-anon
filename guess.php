<?php



function search_for_prefix($prefix)
{
	$prefix = strtolower($prefix);
	$filename = __DIR__.'/lookups/'.substr($prefix, 0, 2);
	$fp = fopen($filename, 'r');
	$matches = [];
	while ($fp && !feof($fp)) {
		$line = fgets($fp);
		$hash = substr($line, 0, 5);
		$pass = substr($line, 5, 4);
		if ($hash == $prefix) {
			$matches[] = $pass;
		}
	}
	fclose($fp);
	return $matches;
}

function extend($matches, $prefix)
{
	$prefix = strtolower($prefix);
	$extendedMatches = [];
	$ords = range(32, 126);
	foreach ($matches as $match) {
		$hash = hash('sha1', $match);
		if ($prefix === substr($hash, 0, 5)) {
			return $matches;
		}
		foreach ($ords as $i) {
			$password = sprintf('%s%c', $match, $i);
			$hash = hash('sha1', $password);
			if ($prefix === substr($hash, 0, 5)) {
				$extendedMatches[] = $password;
			}
		}
	}
	return $extendedMatches;
}


function extendTwice($matches, $prefix)
{
	$prefix = strtolower($prefix);
	$extendedMatches = [];
	$ords = range(32, 126);
	foreach ($matches as $match) {
		foreach ($ords as $i) {
			foreach ($ords as $j) {
				$password = sprintf('%s%c%c', $match, $i, $j);
				$hash = hash('sha1', $password);
				if ($prefix === substr($hash, 0, 5)) {
					$extendedMatches[] = $password;
				}
			}
		}
	}
	return $extendedMatches;
}

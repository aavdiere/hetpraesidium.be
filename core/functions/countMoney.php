<?php
function countMoney($rows, $case, $start = 0, $end = null) {
	$bank = 0;
	$kas = 0;
	$x = $start;

	foreach ($rows as $row) {
		if ($end !== null) {
			if ($x <= $end) {
				$bank = $bank + $row->bank;
				$kas = $kas + $row->kas;
			}
		} else {
			$bank = $bank + $row->bank;
			$kas = $kas + $row->kas;	
		}
		$x++;
	}

	switch ($case) {
		case 'bank':
			return  number_format($bank, 2, '.', '');
			break;
		
		case 'kas':
			return number_format($kas, 2, '.', '');
			break;

		case 'totaal':
			return number_format($kas + $bank, 2, '.', '');
			break;
	}

	return false;
}
?>
<?php

header('Content-Type: text/html; charset=UTF-8');

require_once XOOPS_ROOT_PATH . '/header.php';

$root =& XCube_Root::getSingleton();
$force_fetch = $root->mContext->mRequest->getRequest('force_fetch')=='1'?true:false;
$cache_path = XOOPS_CACHE_PATH . '/circle/studentcache.json';
$cache = array('cache_status', 'student_list');
if (!is_file($cache_path) || $force_fetch) {
	$prefix = 'http://www.edu.tuis.ac.jp/students/';
	$depList = array('s', 'e', 'm', 'c', 'j');
	$suffix = '.htm';
	foreach ($depList as $dep) {
		$html = mb_convert_encoding(file_get_contents($prefix.$dep.$suffix), 'UTF-8', 'SJIS-WIN');
		$years = array();
		preg_match_all('/href="(inside\/.*\.htm)"/', $html, $years, PREG_PATTERN_ORDER);
		foreach ($years[1] as $year) {
			$html = mb_convert_encoding(file_get_contents($prefix.$year), 'UTF-8', 'SJIS-WIN');
			$students = array();
			$students = explode('<br>', $html);
            foreach ($students as $student) {
                if (!preg_match('/.*href.*/', $student)) continue;
                preg_match('/（.*）/', $student, $number);
				$number = str_replace('）', '', str_replace('（', '', $number[0]));
				preg_match('/href="(.*)"/', $student, $eduid);
			 	preg_match('/\/~(.*)\//', $eduid[1], $eduid);
				preg_match('/<a[^>]+>(.*)<\/a>/', $student, $name);
				$cache['student_list'][strtoupper($number)] = array(strtoupper($number), strtolower($eduid[1]), $name[1]);
			}
		}
	}
	$cache['cache_status'] = array(
		'cache_timestamp' => time(),
    );
	file_put_contents($cache_path, json_encode($cache));
	$fetch_status = true;
} else {
	$cache = json_decode(file_get_contents($cache_path),true);
	$fetch_status = false;
}
$query = strtoupper($root->mContext->mRequest->getRequest('q_student_id'));
$answer_section = array();

$keys = array_keys($cache['student_list']);
$response_status = 500;
foreach ($keys as $key) {
	if (preg_match('/.*'.$query.'.*/', $key)) {
		$answer_section[] = $cache['student_list'][$key];
		$response_status = 200;
	}
}
if ($response_status == 500) {
	$answer_section = $query . ' is not found';
	$response_status = 404;
}
$response = array(
	'cache_status' => array(
		'cache_timestamp'	=> $cache['cache_status']['cache_timestamp'],
		'cache_fetched'		=> $fetch_status,
	),
	'request_info' => array(
		'query'	=> $query,
		'force_fetch' => $force_fetch,
	),
	'response_status' => $response_status,
	'answer_section' => $answer_section,
);
?><?php echo json_encode($response); ?>


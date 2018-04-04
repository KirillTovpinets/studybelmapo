<?php
	ini_set("display_errors", 1);
	$data = json_decode(file_get_contents("php://input"));

	if (empty($data)) {
		echo file_get_contents("./log.txt");
		return;
	}
	$date= date(DATE_RFC822);
	$page = $data->page;
	$error = array($data->error);
	$response = $data->response->_body;
	print_r($data);
	$log = "<article style='background:#1976d2; color:#fff;'>date: $date <br /> page: $page <br /> error: $error <br /> response: $response </article>";
	file_put_contents('./log.txt', $log, FILE_APPEND);
?>
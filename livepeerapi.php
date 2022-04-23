<?php
$GLOBALS['bearertoken'] = "";

public function create_stream($title)
{
	$url = "https://livepeer.com/api/stream";
	$data = array(
		"name" => $title,
		"profiles" => array(
		array(
			"name" => "720p",
			"bitrate" => 2000000,
			"fps" => 30,
			"width" => 1280,
			"height" => 720,
		), array(
			"name" => "480p",
			"bitrate" => 1000000,
			"fps" => 30,
			"width" => 854,
			"height" => 480,
		), array(
			"name" => "360p",
			"bitrate" => 500000,
			"fps" => 30,
			"width" => 640,
			"height" => 360
		))
	);

	$post = json_encode($data); // Encode the data array into a JSON string

	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, 1); // Specify the request method as POST
	curl_setopt($curl, CURLOPT_POSTFIELDS, $post); // Set the posted fields
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects

	$headers = array(
		"Content-Type: application/json",
		"Accept: application/json",
		"Authorization: Bearer " . $GLOBALS['bearertoken'],
	);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);


	//for debug only!
	//TODO: figure out how to remove later
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	//TODO: figure out how to remove later

	$resp = curl_exec($curl);
	curl_close($curl);
	return json_decode($resp);
}

function get_stream($id)
{
	$url = "https://livepeer.com/api/stream/" . $id;    

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 

	$headers = array(
		"Content-Type: application/json",
		"Accept: application/json",
		"Authorization: Bearer " . $GLOBALS['bearertoken'],
	);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

	//for debug only!
	//TODO: figure out how to remove later
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	//TODO: figure out how to remove later

	$result = curl_exec($curl);
	$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl);

	return json_decode($result);
}

public function enable_recording($id)
{
	$url = "https://livepeer.com/api/stream/" . $id . "/record";
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");

	$headers = array(
		"Content-Type: application/json",
		"Accept: application/json",
		"Authorization: Bearer " . $GLOBALS['bearertoken'],
	);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

	$post = json_encode(array("record" => true));

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, 1); // Specify the request method as POST
	curl_setopt($curl, CURLOPT_POSTFIELDS, $post); // Set the posted fields
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirect s
	
	//for debug only!
	//TODO: figure out how to remove later
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	//TODO: figure out how to remove later

	$result = curl_exec($curl);
	$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl);

	return json_decode($result);
}

public function delete_stream($id)
{
	$url = "https://livepeer.com/api/stream/" . $id;    

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");

	$headers = array(
		"Content-Type: application/json",
		"Accept: application/json",
		"Authorization: Bearer " . $GLOBALS['bearertoken'],
	);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

	//for debug only!
	//TODO: figure out how to remove later
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	//TODO: figure out how to remove later

	$result = curl_exec($curl);
	$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl);

	return json_decode($result);
}

?>

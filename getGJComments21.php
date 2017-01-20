<?php
//set POST variables
$url = 'http://www.boomlings.com/database/getGJComments21.php';
$fields = array(
            //post parameters to be sent to the other website
            'gameVersion'=>urlencode($_POST['gameVersion']),
			'binaryVersion'=>urlencode($_POST['binaryVersion']),
			'gdw'=>urlencode($_POST['gdw']),
			'levelID'=>urlencode($_POST['levelID']),
			'page'=>urlencode($_POST['page']),
			'userID'=>urlencode($_POST['userID']),
			'total'=>urlencode($_POST['total']),
			'secret'=>urlencode($_POST['secret']),
			'mode'=>urlencode($_POST['mode'])
        );
$fields_string = '';
		
//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string,'&');

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POST,count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

//execute post
$result = curl_exec($ch);
//close connection
curl_close($ch);

$resultarr = explode('|', $result);

for ($j = 0; $j < count($resultarr); $j++) {
    $comment[$j] = file_get_contents('https://translate.googleapis.com/translate_a/single?client=gtx&sl=auto&tl=en&dt=t&q='.urlencode(base64_decode(explode('~', $resultarr[$j])[1])));
	
	$contents = explode('~', $resultarr[$j]);
	for ($i = 0; $i < count($contents); $i++) {
		if ($i == 1) {
			echo base64_encode(explode('"', $comment[$j])[1]);
		} else {
			echo $contents[$i];
		}
		if ($i != count($contents) - 1) {
			echo '~';
		}
	}
	if ($j != count($resultarr) - 1) {
		echo '|';
	}
}


?>
<?php
//set POST variables
$url = 'http://www.boomlings.com/database/downloadGJLevel22.php';
$fields = array(
            //post parameters to be sent to the other website
            'gameVersion'=>urlencode($_POST['gameVersion']),
			'binaryVersion'=>urlencode($_POST['binaryVersion']),
			'gdw'=>urlencode($_POST['gdw']),
			'levelID'=>urlencode($_POST['levelID']),
			'inc'=>urlencode($_POST['inc']),
			'extras'=>urlencode($_POST['extras']),
			'secret'=>urlencode($_POST['secret'])
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

$resultarr = explode(':', $result);

$leveldesc = $resultarr[5];

$translation = file_get_contents('https://translate.googleapis.com/translate_a/single?client=gtx&sl=auto&tl=en&dt=t&q='.urlencode(base64_decode($leveldesc)));

$resultarr[5] = base64_encode(explode('"', $translation)[1]);

for ($i = 0; $i < count($resultarr); $i++) {
    echo $resultarr[$i];
	if ($i != count($resultarr) - 1) {
		echo ':';
	}
}
?>
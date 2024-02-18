<?php
// POST 요청으로부터 데이터를 받아옵니다.
// $input = $_POST['input'];

header("Content-Type:application/json");
// $input = "38d481a6f2a7411386723eaa5c50f480";
// 이 아래는 수정할 필요 없음

if(!empty($_GET['input']))
{
	$input=$_GET['input'];
	
	if(empty($input))
	{
		response(200,"Product Not Found",NULL);
	}
	else
	{
        echo $input;
        require_once("WebsenderAPI.php"); // 라이브러리 불러오기
    
        $wsr = new WebsenderAPI("103.124.102.253", "D&2(D#%*3[:]du8&2&", "40403");
        $uuid = convertToUUID($input);
    
        if ($wsr->connect()) { // 연결 열기
            $wsr->sendCommand("trg vars premiumSession $uuid");
            $wsr->sendCommand("trg run #CALL \"updatePremium\"");
        } else {
            echo "오류가 발생했습니다. 게임모드 고객센터로 문의해 주세요.";
        }
    
        $wsr->disconnect(); // 연결 닫기
		response(200,"Product Found", $input);
	}
	
}
else
{
	response(400,"Invalid Request",NULL);
}

function response($status,$status_message,$data)
{
	header("HTTP/1.1 ".$status);
	
	$response['status']=$status;
	$response['status_message']=$status_message;
	$response['data']=$data;
	
	$json_response = json_encode($response);
	echo $json_response;
}

function convertToUUID($string) {
    $string = str_pad($string, 32, '0', STR_PAD_LEFT);
    $result = substr($string, 0, 8) . '-' . substr($string, 8, 4) . '-' . substr($string, 12, 4) . '-' . substr($string, 16, 4) . '-' . substr($string, 20, 12);
    return strtolower($result);
}

?>

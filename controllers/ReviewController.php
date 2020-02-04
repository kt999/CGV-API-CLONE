<?php
require 'function.php';

const JWT_SECRET_KEY = "TEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEY";

$res = (Object)Array();
header('Content-Type: json');
$req = json_decode(file_get_contents("php://input"));
try {
    addAccessLogs($accessLogs, $req);
    switch ($handler) {


        /*
         * API No. 3
         * API Name : 테스트 Body & Insert API
         * 마지막 수정 날짜 : 19.04.29
         */
        case "reviewList":
            http_response_code(200);
            $res->result = reviewList($_GET["filter"],$vars["movieId"]);
            $res->isSuccess = TRUE;
            $res->code = 100;

            if($_GET["filter"]=="general"){
                $res->message = "실관람평 종합정보 조회 성공";
            }
            else {
                $res->message = "실관람평 정보 리스트 조회 성공";
            }
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        /*
         * API No. 3
         * API Name : 테스트 Body & Insert API
         * 마지막 수정 날짜 : 19.04.29
         */
        case "reviewAdd":
            http_response_code(201);
            reviewAdd($req->movieId,$req->userId,$req->goldenEggStatus,$req->content);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "실관람평 등록 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;


        /*
         * API No. 5
         * API Name : 테스트 Path Variable API
         * 마지막 수정 날짜 : 19.04.29
         */
        case "reviewDelete":
            http_response_code(200);
            reviewDelete($vars["id"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "실관람평 삭제 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;



    }
} catch (\Exception $e) {
    return getSQLErrorException($errorLogs, $e, $req);
}
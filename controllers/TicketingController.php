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
        case "sawInfo":
            http_response_code(200);
            $res->result = sawInfo($vars["movieId"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "누적관람객 정보 조회 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        /*
         * API No. 3
         * API Name : 테스트 Body & Insert API
         * 마지막 수정 날짜 : 19.04.29
         */
        case "ticketingSaw":
            http_response_code(201);
            ticketingSaw($vars["movieId"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "관람완료로 변경 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;


        /*
         * API No. 3
         * API Name : 테스트 Body & Insert API
         * 마지막 수정 날짜 : 19.04.29
         */
        case "ticketingAdd":
            http_response_code(201);
            ticketingAdd($req->movieId,$req->userId);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "예매 하기 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        /*
         * API No. 5
         * API Name : 테스트 Path Variable API
         * 마지막 수정 날짜 : 19.04.29
         */
        case "ticketingDelete":
            http_response_code(200);
            ticketingDelete($vars["id"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "예매 취소 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

    }
} catch (\Exception $e) {
    return getSQLErrorException($errorLogs, $e, $req);
}

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
        case "likesCount":
            http_response_code(200);
            $res->result = likesCount($vars["movieId"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "영화 좋아요 갯수 조회 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;


        /*
         * API No. 3
         * API Name : 테스트 Body & Insert API
         * 마지막 수정 날짜 : 19.04.29
         */
        case "isLiked":
            http_response_code(200);
            $res->result = isLiked($vars["userId"],$vars["movieId"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "유저 영화 좋아요 유무확인 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        /*
         * API No. 3
         * API Name : 테스트 Body & Insert API
         * 마지막 수정 날짜 : 19.04.29
         */
        case "likesAdd":
            http_response_code(201);
            likesAdd($vars["userId"],$vars["movieId"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "영화 좋아요 추가 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;


        /*
         * API No. 5
         * API Name : 테스트 Path Variable API
         * 마지막 수정 날짜 : 19.04.29
         */
        case "likesDelete":
            http_response_code(200);
            likesDelete($vars["userId"],$vars["movieId"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "영화 좋아요 삭제 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;



    }
} catch (\Exception $e) {
    return getSQLErrorException($errorLogs, $e, $req);
}
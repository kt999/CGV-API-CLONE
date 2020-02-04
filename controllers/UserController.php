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
        * API No. 1
        * API Name : 테스트 API
        * 마지막 수정 날짜 : 19.04.29
        */
        case "userList":
            http_response_code(200);
            $res->result = userList();
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "회원 리스트 조회 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        /*
         * API No. 2
         * API Name : 테스트 Path Variable API
         * 마지막 수정 날짜 : 19.04.29
         */
        case "user":
            http_response_code(200);
            $res->result = user($vars["userId"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "회원 리스트 개별 조회 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        /*
         * API No. 3
         * API Name : 테스트 Body & Insert API
         * 마지막 수정 날짜 : 19.04.29
         */
        case "userAdd":
            http_response_code(201);
            userAdd($req->email,$req->password,$req->nickname,$req->sexStatus,$req->ageStatus);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "회원가입 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        /*
         * API No. 5
         * API Name : 테스트 Path Variable API
         * 마지막 수정 날짜 : 19.04.29
         */
        case "userDelete":
            http_response_code(200);
            userDelete($vars["userId"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "회원탈퇴 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;


        /*
         * API No. 1
         * API Name : 테스트 API
         * 마지막 수정 날짜 : 19.04.29
         */
        case "castList":
            http_response_code(200);
            $res->result = castList();
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "출연진 리스트 조회 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        /*
         * API No. 2
         * API Name : 테스트 Path Variable API
         * 마지막 수정 날짜 : 19.04.29
         */
        case "cast":
            http_response_code(200);
            $res->result = cast($vars["castId"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "출연진 리스트 개별 조회 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        /*
         * API No. 3
         * API Name : 테스트 Body & Insert API
         * 마지막 수정 날짜 : 19.04.29
         */
        case "castAdd":
            http_response_code(201);
            castAdd($req->nameKR,$req->nameEN,$req->profileImg);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "출연진 등록 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        /*
         * API No. 5
         * API Name : 테스트 Path Variable API
         * 마지막 수정 날짜 : 19.04.29
         */
        case "castDelete":
            http_response_code(200);
            castDelete($vars["castId"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "출연진 삭제 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

    }
} catch (\Exception $e) {
    return getSQLErrorException($errorLogs, $e, $req);
}

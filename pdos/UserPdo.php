<?php


//READ
function userList()
{
    $pdo = pdoSqlConnect();
    $query = "SELECT id,email,nickname,sexStatus,ageStatus,createdAt,updatedAt FROM users;";

    $st = $pdo->prepare($query);
    //    $st->execute([$param,$param]);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

//READ
function user($userId)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT id,email,nickname,sexStatus,ageStatus,createdAt,updatedAt FROM users WHERE id = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$userId]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}


function userAdd($email,$password,$nickname,$sexStatus,$ageStatus)
{

    $pdo = pdoSqlConnect();
    $query = "INSERT INTO users (email,password,nickname,sexStatus,ageStatus) VALUES (?,?,?,?,?);";

    $st = $pdo->prepare($query);
    $st->execute([$email, $password, $nickname, $sexStatus, $ageStatus]);

    $st = null;
    $pdo = null;

}

//function userUpdate($id,$case,$content)
//{
//
//    $pdo = pdoSqlConnect();
//    $query = "";
//
//    if($case == "name"){
//        $query = "UPDATE users SET name = ? WHERE id = ?;";
//    }
//    else if($case == "password"){
//        $query = "UPDATE users SET password = ? WHERE id = ?;";
//    }
//
//    $st = $pdo->prepare($query);
//    $st->execute([$content, $id]);
//
//    $st = null;
//    $pdo = null;
//
//}

function userDelete($userId)
{
    $pdo = pdoSqlConnect();
    $query = "DELETE from users WHERE id = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$userId]);

    $st = null;
    $pdo = null;

    return "success";

}





//READ
function castList()
{
    $pdo = pdoSqlConnect();
    $query = "SELECT * FROM casts;";

    $st = $pdo->prepare($query);
    //    $st->execute([$param,$param]);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

//READ
function cast($castId)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT * FROM casts WHERE id = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$castId]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}


function castAdd($nameKR,$nameEN,$profileImg)
{

    $pdo = pdoSqlConnect();
    $query = "INSERT INTO users (nameKR,nameEN,profileImg) VALUES (?,?,?);";

    $st = $pdo->prepare($query);
    $st->execute([$nameKR,$nameEN,$profileImg]);

    $st = null;
    $pdo = null;

}

function castDelete($castId)
{
    $pdo = pdoSqlConnect();
    $query = "DELETE from casts WHERE id = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$castId]);

    $st = null;
    $pdo = null;

    return "success";

}
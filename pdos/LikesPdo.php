<?php


function likesCount($movieId)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT count(*) as count FROM likes WHERE movieId = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$movieId]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0]["count"];
}

function isLiked($userId,$movieId)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT count(*) as count FROM likes WHERE movieId = ? AND userId = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$movieId,$userId]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0]["count"];
}


function likesAdd($userId,$movieId)
{

    $pdo = pdoSqlConnect();

    $query = "INSERT INTO likes (movieId,userId) VALUES (?,?);";

    $st = $pdo->prepare($query);
    $st->execute([$movieId,$userId]);

    $st = null;
    $pdo = null;

}

function likesDelete($userId,$movieId)
{

    $pdo = pdoSqlConnect();

    $query = "DELETE from likes WHERE movieId = ? AND userId = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$movieId,$userId]);

    $st = null;
    $pdo = null;

}
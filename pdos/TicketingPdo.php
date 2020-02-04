<?php

function sawInfo($movieId)
{

    $pdo = pdoSqlConnect();

    $query = "SELECT t.count AS totalCount, s.maleRatio, s.femaleRatio, a.oneRatio, a.twoRatio, a.threeRatio, a.fourRatio, a.fiveRatio

                FROM
                
                (
                SELECT
                
                t.movieId,
                ifnull(TRUNCATE(m.count/t.count*100,0),0) AS maleRatio,
                ifnull(TRUNCATE(f.count/t.count*100,0),0) AS femaleRatio
                
                FROM
                
                (SELECT movieId, count(*) AS count
                FROM (SELECT t.movieId, u.id, u.sexStatus
                FROM ticketing AS t
                JOIN users AS u
                ON t.userId = u.id
                WHERE t.sawStatus = 1) AS t
                GROUP BY movieId) AS t
                
                LEFT OUTER JOIN
                
                (SELECT movieId, count(*) AS count
                FROM (SELECT t.movieId, u.id, u.sexStatus
                FROM ticketing AS t
                JOIN users AS u
                ON t.userId = u.id
                WHERE t.sawStatus = 1) AS t
                where sexStatus = 0 GROUP BY movieId) AS m
                
                ON t.movieId = m.movieId
                
                LEFT OUTER JOIN
                
                (SELECT movieId, count(*) AS count
                FROM (SELECT t.movieId, u.id, u.sexStatus
                FROM ticketing AS t
                JOIN users AS u
                ON t.userId = u.id
                WHERE t.sawStatus = 1) AS t
                where sexStatus = 1 GROUP BY movieId) AS f
                
                ON t.movieId = f.movieId
                
                ) AS s
                
                JOIN
                
                (
                SELECT
                
                t.movieId,
                ifnull(TRUNCATE(a.count/t.count*100,0),0) AS oneRatio,
                ifnull(TRUNCATE(b.count/t.count*100,0),0) AS twoRatio,
                ifnull(TRUNCATE(c.count/t.count*100,0),0) AS threeRatio,
                ifnull(TRUNCATE(d.count/t.count*100,0),0) AS fourRatio,
                ifnull(TRUNCATE(e.count/t.count*100,0),0) AS fiveRatio
                
                FROM
                
                (SELECT movieId, count(*) AS count
                FROM (SELECT t.movieId, u.id, u.ageStatus
                FROM ticketing AS t
                JOIN users AS u
                ON t.userId = u.id
                WHERE t.sawStatus = 1) AS t
                GROUP BY movieId) AS t
                
                LEFT OUTER JOIN
                
                (SELECT movieId, count(*) AS count
                FROM (SELECT t.movieId, u.id, u.ageStatus
                FROM ticketing AS t
                JOIN users AS u
                ON t.userId = u.id
                WHERE t.sawStatus = 1) AS t
                where ageStatus = 1 GROUP BY movieId) AS a
                
                ON t.movieId = a.movieId
                
                LEFT OUTER JOIN
                
                (SELECT movieId, count(*) AS count
                FROM (SELECT t.movieId, u.id, u.ageStatus
                FROM ticketing AS t
                JOIN users AS u
                ON t.userId = u.id
                WHERE t.sawStatus = 1) AS t
                where ageStatus = 2 GROUP BY movieId) AS b
                
                ON t.movieId = b.movieId
                
                LEFT OUTER JOIN
                
                (SELECT movieId, count(*) AS count
                FROM (SELECT t.movieId, u.id, u.ageStatus
                FROM ticketing AS t
                JOIN users AS u
                ON t.userId = u.id
                WHERE t.sawStatus = 1) AS t
                where ageStatus = 3 GROUP BY movieId) AS c
                
                ON t.movieId = c.movieId
                
                LEFT OUTER JOIN
                
                (SELECT movieId, count(*) AS count
                FROM (SELECT t.movieId, u.id, u.ageStatus
                FROM ticketing AS t
                JOIN users AS u
                ON t.userId = u.id
                WHERE t.sawStatus = 1) AS t
                where ageStatus = 4 GROUP BY movieId) AS d
                
                ON t.movieId = d.movieId
                
                LEFT OUTER JOIN
                
                (SELECT movieId, count(*) AS count
                FROM (SELECT t.movieId, u.id, u.ageStatus
                FROM ticketing AS t
                JOIN users AS u
                ON t.userId = u.id
                WHERE t.sawStatus = 1) AS t
                where ageStatus = 5 GROUP BY movieId) AS e
                
                ON t.movieId = e.movieId
                ) AS a
                
                ON s.movieId = a.movieId
                
                LEFT OUTER JOIN
                
                (SELECT movieId, count(*) AS count
                FROM (SELECT t.movieId, u.id, u.sexStatus
                FROM ticketing AS t
                JOIN users AS u
                ON t.userId = u.id
                WHERE t.sawStatus = 1) AS t
                GROUP BY movieId) AS t
                
                ON s.movieId = t.movieId
                
                WHERE s.movieId = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$movieId]);

    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];

}

function ticketingSaw($movieId)
{

    $pdo = pdoSqlConnect();

    $query = "UPDATE ticketing SET sawStatus = 1 WHERE movieId = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$movieId]);

    $st = null;
    $pdo = null;

}


function ticketingAdd($movieId,$userId)
{

    $pdo = pdoSqlConnect();



    $query = "INSERT INTO ticketing (movieId,userId) VALUES (?,?);";

    $st = $pdo->prepare($query);
    $st->execute([$movieId,$userId]);

    $st = null;
    $pdo = null;

}

function ticketingDelete($id)
{

    $pdo = pdoSqlConnect();

    $query = "DELETE from ticketing WHERE id = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$id]);

    $st = null;
    $pdo = null;

}
<?php


function movie($id){

    $pdo = pdoSqlConnect();
    $query = "SELECT m.title,m.subTitle, m.viewAge, m.releaseDate, m.runningTime, m.description,m.genre, ifnull(g.goldenEggRatio,0) AS goldenEggRatio, ifnull(t.ticketingRatio,0) AS ticketingRatio
                
                FROM movies AS m
                
                
                LEFT OUTER JOIN (
                    SELECT g.movieId AS movieId, TRUNCATE((g.count/t.count*100),0) AS goldenEggRatio
                    FROM (SELECT movieId, count(*) AS count FROM reviews where goldenEggStatus = 1 GROUP BY movieId) AS g
                    JOIN (SELECT movieId, count(*) AS count FROM reviews GROUP BY movieId) AS t
                    ON g.movieId = t.movieId
                ) AS g
                
                    ON m.id = g.movieId
                
                LEFT OUTER JOIN (
                    SELECT m.id AS movieId,TRUNCATE(t.ticketingCount/t.totalCount*100,1) AS ticketingRatio
                    FROM movies AS m
                    JOIN (SELECT movieId, count(*) AS ticketingCount,(SELECT count(*) FROM ticketing) AS totalCount FROM ticketing GROUP BY movieId) AS t
                    ON m.id = t.movieId
                ) AS t
                
                    ON m.id = t.movieId
                
                WHERE m.id = ?
                ";

    $st = $pdo->prepare($query);
    $st->execute([$id]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $query = "SELECT type,fileUrl,status FROM movieFiles WHERE movieId = ?;";
    $st = $pdo->prepare($query);
    $st->execute([$id]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $files = $st->fetchAll();

    $query = "SELECT castId,status FROM movieCasts WHERE movieId = ?;";
    $st = $pdo->prepare($query);
    $st->execute([$id]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $casts = $st->fetchAll();

    $res[0]["movieFiles"] = $files;
    $res[0]["movieCasts"] = $casts;

    $st = null;
    $pdo = null;

    return $res[0];

}

function movieList($queryString){
    $pdo = pdoSqlConnect();
    $query = "";

    if(!$queryString){
        $query = "SELECT m.id, m.title, m.viewAge, m.releaseDate, f.fileUrl as mainImgUrl, ifnull(g.goldenEggRatio,0) AS goldenEggRatio, ifnull(t.ticketingRatio,0) AS ticketingRatio

                    FROM movies AS m
                    
                    JOIN movieFiles AS f
                    
                        ON m.id = f.movieId
                    
                    LEFT OUTER JOIN (
                        SELECT g.movieId AS movieId, TRUNCATE((g.count/t.count*100),0) AS goldenEggRatio
                        FROM (SELECT movieId, count(*) AS count FROM reviews where goldenEggStatus = 1 GROUP BY movieId) AS g
                        JOIN (SELECT movieId, count(*) AS count FROM reviews GROUP BY movieId) AS t
                        ON g.movieId = t.movieId
                    ) AS g
                    
                        ON m.id = g.movieId
                    
                    LEFT OUTER JOIN (
                        SELECT m.id AS movieId,TRUNCATE(t.ticketingCount/t.totalCount*100,1) AS ticketingRatio
                        FROM movies AS m
                        JOIN (SELECT movieId, count(*) AS ticketingCount,(SELECT count(*) FROM ticketing) AS totalCount FROM ticketing GROUP BY movieId) AS t
                        ON m.id = t.movieId
                    ) AS t
                    
                        ON m.id = t.movieId
                    
                    WHERE f.status = 0";
    }
    else if($queryString == "rank"){
        $query = "SELECT m.id, m.title, m.viewAge, m.releaseDate, f.fileUrl as mainImgUrl, ifnull(g.goldenEggRatio,0) AS goldenEggRatio, ifnull(t.ticketingRatio,0) AS ticketingRatio

                    FROM movies AS m
                    
                    JOIN movieFiles AS f
                    
                        ON m.id = f.movieId
                    
                    LEFT OUTER JOIN (
                        SELECT g.movieId AS movieId, TRUNCATE((g.count/t.count*100),0) AS goldenEggRatio
                        FROM (SELECT movieId, count(*) AS count FROM reviews where goldenEggStatus = 1 GROUP BY movieId) AS g
                        JOIN (SELECT movieId, count(*) AS count FROM reviews GROUP BY movieId) AS t
                        ON g.movieId = t.movieId
                    ) AS g
                    
                        ON m.id = g.movieId
                    
                    LEFT OUTER JOIN (
                        SELECT m.id AS movieId,TRUNCATE(t.ticketingCount/t.totalCount*100,1) AS ticketingRatio
                        FROM movies AS m
                        JOIN (SELECT movieId, count(*) AS ticketingCount,(SELECT count(*) FROM ticketing) AS totalCount FROM ticketing GROUP BY movieId) AS t
                        ON m.id = t.movieId
                    ) AS t
                    
                        ON m.id = t.movieId
                    
                    WHERE f.status = 0
                    
                    ORDER BY t.ticketingRatio DESC";
    }

    $st = $pdo->prepare($query);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;

}

function movieAdd($title,$subTitle,$description,$genre,$runningTime,$viewAge,$releaseDate,$fileList,$castList)
{

    $pdo = pdoSqlConnect();



    $query = "INSERT INTO movies (title,subTitle,description,genre,runningTime,viewAge,releaseDate) VALUES (?,?,?,?,?,?,?);";

    $st = $pdo->prepare($query);
    $st->execute([$title,$subTitle,$description,$genre,$runningTime,$viewAge,$releaseDate]);

    //getMaxId

    $getMaxIdQuery = "SELECT max(id) as maxId from movies;";
    $getId = $pdo->prepare($getMaxIdQuery);
    $getId->execute();
    $getId->setFetchMode(PDO::FETCH_ASSOC);
    $res = $getId->fetchAll();

    $movieId = $res[0]["maxId"];

    for($i=0;$i<count($fileList);$i++) {
        $fileQuery = "INSERT INTO movieFiles (movieId,type,fileUrl,status) VALUES (?,?,?,?);";
        $fileSt = $pdo->prepare($fileQuery);
        $fileSt->execute([$movieId,$fileList[$i]->type,$fileList[$i]->url,$fileList[$i]->positionStatus]);
    }
    for($i=0;$i<count($castList);$i++) {
        $castQuery = "INSERT INTO movieCasts (movieId,castId,status) VALUES (?,?,?);";
        $castSt = $pdo->prepare($castQuery);
        $castSt->execute([$movieId, $castList[$i]->castId, $castList[$i]->castStatus]);
    }

    $st = null;
    $pdo = null;

}

function movieDelete($movieId)
{
    $pdo = pdoSqlConnect();

    $query = "DELETE from movies WHERE id = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$movieId]);

    $query = "DELETE from movieFiles WHERE movieId = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$movieId]);

    $query = "DELETE from movieCasts WHERE movieId = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$movieId]);

    $st = null;
    $pdo = null;

}

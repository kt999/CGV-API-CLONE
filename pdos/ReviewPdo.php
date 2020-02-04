<?php


function reviewList($queryString,$movieId)
{

    $pdo = pdoSqlConnect();

    if($queryString == "general"){

        $query = "
                    SELECT t.count AS totalCount, tm.count AS maniaCount, tg.totalRatio, s.maleRatio, s.femaleRatio, a.oneRatio, a.twoRatio, a.threeRatio, a.fourRatio, a.fiveRatio

                    FROM
                    
                    (
                    SELECT
                    
                    mt.movieId,
                    ifnull(TRUNCATE(m.count/mt.count*100,0),0)AS maleRatio,
                    ifnull(TRUNCATE(f.count/ft.count*100,0),0) AS femaleRatio
                    
                    FROM
                    
                    (SELECT movieId, count(*) AS count
                    FROM (SELECT t.movieId, u.id, u.sexStatus
                    FROM reviews AS t
                    JOIN users AS u
                    ON t.userId = u.id
                    where u.sexStatus = 0) AS t
                    GROUP BY movieId
                    ) AS mt
                    
                    LEFT OUTER JOIN
                    
                    (SELECT movieId, count(*) AS count
                    FROM (SELECT t.movieId, u.id, u.sexStatus
                    FROM reviews AS t
                    JOIN users AS u
                    ON t.userId = u.id
                    where u.sexStatus = 1) AS t
                    GROUP BY movieId
                    ) AS ft
                    
                    ON mt.movieId = ft.movieId
                    
                    LEFT OUTER JOIN
                    
                    (SELECT movieId, count(*) AS count
                    FROM (SELECT t.movieId, u.id, u.sexStatus
                    FROM reviews AS t
                    JOIN users AS u
                    ON t.userId = u.id
                    where t.goldenEggStatus=1) AS t
                    where sexStatus = 0 GROUP BY movieId) AS m
                    
                    ON mt.movieId = m.movieId
                    
                    LEFT OUTER JOIN
                    
                    (SELECT movieId, count(*) AS count
                    FROM (SELECT t.movieId, u.id, u.sexStatus
                    FROM reviews AS t
                    JOIN users AS u
                    ON t.userId = u.id
                    where t.goldenEggStatus=1) AS t
                    where sexStatus = 1 GROUP BY movieId) AS f
                    
                    ON mt.movieId = f.movieId
                    
                    ) AS s
                    
                    JOIN
                    
                    (
                    SELECT
                    
                    at.movieId,
                    ifnull(TRUNCATE(a.count/at.count*100,0),0) AS oneRatio,
                    ifnull(TRUNCATE(b.count/bt.count*100,0),0) AS twoRatio,
                    ifnull(TRUNCATE(c.count/ct.count*100,0),0) AS threeRatio,
                    ifnull(TRUNCATE(d.count/dt.count*100,0),0) AS fourRatio,
                    ifnull(TRUNCATE(e.count/et.count*100,0),0) AS fiveRatio
                    
                    FROM
                    
                    (SELECT movieId, count(*) AS count
                    FROM (SELECT t.movieId, u.id, u.sexStatus
                    FROM reviews AS t
                    JOIN users AS u
                    ON t.userId = u.id
                    where u.ageStatus = 1) AS t
                    GROUP BY movieId
                    ) AS at
                    
                    LEFT OUTER JOIN
                    
                    (SELECT movieId, count(*) AS count
                    FROM (SELECT t.movieId, u.id, u.sexStatus
                    FROM reviews AS t
                    JOIN users AS u
                    ON t.userId = u.id
                    where u.ageStatus = 2) AS t
                    GROUP BY movieId
                    ) AS bt
                    
                    ON at.movieId = bt.movieId
                    
                    LEFT OUTER JOIN
                    
                    (SELECT movieId, count(*) AS count
                    FROM (SELECT t.movieId, u.id, u.sexStatus
                    FROM reviews AS t
                    JOIN users AS u
                    ON t.userId = u.id
                    where u.ageStatus = 3) AS t
                    GROUP BY movieId
                    ) AS ct
                    
                    ON at.movieId = ct.movieId
                    
                    LEFT OUTER JOIN
                    
                    (SELECT movieId, count(*) AS count
                    FROM (SELECT t.movieId, u.id, u.sexStatus
                    FROM reviews AS t
                    JOIN users AS u
                    ON t.userId = u.id
                    where u.ageStatus = 4) AS t
                    GROUP BY movieId
                    ) AS dt
                    
                    ON at.movieId = dt.movieId
                    
                    LEFT OUTER JOIN
                    
                    (SELECT movieId, count(*) AS count
                    FROM (SELECT t.movieId, u.id, u.sexStatus
                    FROM reviews AS t
                    JOIN users AS u
                    ON t.userId = u.id
                    where u.ageStatus = 5) AS t
                    GROUP BY movieId
                    ) AS et
                    
                    ON at.movieId = et.movieId
                    
                    LEFT OUTER JOIN
                    
                    (SELECT movieId, count(*) AS count
                    FROM (SELECT t.movieId, u.id, u.ageStatus
                    FROM reviews AS t
                    JOIN users AS u
                    ON t.userId = u.id
                    where t.goldenEggStatus=1) AS t
                    where ageStatus = 1 GROUP BY movieId) AS a
                    
                    ON at.movieId = a.movieId
                    
                    LEFT OUTER JOIN
                    
                    (SELECT movieId, count(*) AS count
                    FROM (SELECT t.movieId, u.id, u.ageStatus
                    FROM reviews AS t
                    JOIN users AS u
                    ON t.userId = u.id
                    where t.goldenEggStatus=1) AS t
                    where ageStatus = 2 GROUP BY movieId) AS b
                    
                    ON at.movieId = b.movieId
                    
                    LEFT OUTER JOIN
                    
                    (SELECT movieId, count(*) AS count
                    FROM (SELECT t.movieId, u.id, u.ageStatus
                    FROM reviews AS t
                    JOIN users AS u
                    ON t.userId = u.id
                    where t.goldenEggStatus=1) AS t
                    where ageStatus = 3 GROUP BY movieId) AS c
                    
                    ON at.movieId = c.movieId
                    
                    LEFT OUTER JOIN
                    
                    (SELECT movieId, count(*) AS count
                    FROM (SELECT t.movieId, u.id, u.ageStatus
                    FROM reviews AS t
                    JOIN users AS u
                    ON t.userId = u.id
                    where t.goldenEggStatus=1) AS t
                    where ageStatus = 4 GROUP BY movieId) AS d
                    
                    ON at.movieId = d.movieId
                    
                    LEFT OUTER JOIN
                    
                    (SELECT movieId, count(*) AS count
                    FROM (SELECT t.movieId, u.id, u.ageStatus
                    FROM reviews AS t
                    JOIN users AS u
                    ON t.userId = u.id
                    where t.goldenEggStatus=1) AS t
                    where ageStatus = 5 GROUP BY movieId) AS e
                    
                    ON at.movieId = e.movieId
                    )
                    AS a
                    
                    ON s.movieId = a.movieId
                    
                    LEFT OUTER JOIN
                    
                    (SELECT movieId, count(*) AS count
                    FROM (SELECT t.movieId, u.id, u.sexStatus
                    FROM reviews AS t
                    JOIN users AS u
                    ON t.userId = u.id) AS t
                    GROUP BY movieId) AS t
                    
                    ON s.movieId = t.movieId
                    
                    LEFT OUTER JOIN
                    
                    (SELECT
                    
                    t.movieId,
                    ifnull(TRUNCATE(g.count/t.count*100,0),0) AS totalRatio
                    
                    FROM
                    
                    (SELECT movieId, count(*) AS count
                    FROM (SELECT t.movieId, u.id, u.sexStatus
                    FROM reviews AS t
                    JOIN users AS u
                    ON t.userId = u.id) AS t
                    GROUP BY movieId
                    ) AS t
                    
                    LEFT OUTER JOIN
                    
                    (SELECT movieId, count(*) AS count
                    FROM (SELECT t.movieId, u.id, u.sexStatus
                    FROM reviews AS t
                    JOIN users AS u
                    ON t.userId = u.id
                    where t.goldenEggStatus = 1) AS t
                    GROUP BY movieId
                    ) AS g
                    
                    ON t.movieId = g.movieId) AS tg
                    
                    ON s.movieId = tg.movieId
                    
                    LEFT OUTER JOIN
                    
                    (SELECT movieId, count(*) AS count
                    FROM (SELECT t.movieId, u.id, u.ageStatus
                    FROM reviews AS t
                    JOIN users AS u
                    ON t.userId = u.id
                    WHERE u.maniaStatus = 1) AS t
                    GROUP BY movieId) AS tm
                    
                    ON s.movieId = tm.movieId
                    
                    WHERE s.movieId = ?;";

        $st = $pdo->prepare($query);
        $st->execute([$movieId]);
        $st->setFetchMode(PDO::FETCH_ASSOC);
        $res = $st->fetchAll();
        $res=$res[0];

    }
    else {


        $query = "SELECT id,userId,goldenEggStatus,content,createdAt FROM reviews WHERE movieId = ?;";

        $st = $pdo->prepare($query);
        $st->execute([$movieId]);
        $st->setFetchMode(PDO::FETCH_ASSOC);
        $res = $st->fetchAll();

    }

    $st = null;
    $pdo = null;

    return $res;
}


function reviewAdd($movieId,$userId,$goldenEggStatus,$content)
{

    $pdo = pdoSqlConnect();

    $query = "INSERT INTO reviews (movieId,userId,goldenEggStatus,content) VALUES (?,?,?,?);";

    $st = $pdo->prepare($query);
    $st->execute([$movieId,$userId,$goldenEggStatus,$content]);

    $st = null;
    $pdo = null;

}

function reviewDelete($id)
{

    $pdo = pdoSqlConnect();

    $query = "DELETE from reviews WHERE id = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$id]);

    $st = null;
    $pdo = null;

}
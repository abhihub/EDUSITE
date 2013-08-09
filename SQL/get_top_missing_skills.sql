-- Find the top missing skills for a resume (skills that when added will give add to most jobs)
DELIMITER $$
DROP PROCEDURE IF EXISTS `fillskils`.`get_top_missing_skills`$$
CREATE PROCEDURE  `fillskils`.`get_top_missing_skills`
(
IN usersid INT
)
BEGIN
SELECT count(dd.`missingskill`) as numberofskills, sk.`name` as skillname, group_concat(jobid) as jobs 
FROM
(
SELECT b.`skillid` as missingskill, b.`jobid`
FROM jobsskills AS b LEFT OUTER JOIN 
(SELECT * FROM usersskills WHERE userid = usersid) AS usert 
USING (`skillid`) WHERE usert.`skillid` IS NULL ) AS dd 
JOIN skills AS sk ON dd.`missingskill` = sk.`id`
GROUP BY dd.`missingskill`
ORDER BY count(dd.missingskill) DESC LIMIT 9;
END $$
DELIMITER ;
-- Find the top recommended courses for a resume (skills that when added will give add to most jobs)
DELIMITER $$
DROP PROCEDURE IF EXISTS `fillskils`.`get_top_courses`$$
CREATE PROCEDURE  `fillskils`.`get_top_courses`
(
IN usersid INT
)
BEGIN
SELECT co.`name` as coursename, csk.courseid, missingskills.numberofskills, 
missingskills.skillname, co.`description`, co.`url` 
FROM coursesskills csk 
INNER JOIN skills sk ON csk.`skillid` = sk.`id` 
INNER JOIN courses co on co.`id` = csk.`courseid`
INNER JOIN
	(
	SELECT count(dd.`missingskill`) AS numberofskills, sk.`name` as skillname, group_concat(jobid) from
	(
	SELECT b.`skillid` as missingskill, b.`jobid`
	FROM jobsskills as b LEFT OUTER JOIN 
		(select * from usersskills where userid = usersid) as usert using (`skillid`) 
		 where usert.`skillid` is NULL ) as dd 
		 join skills as sk 
		 on dd.`missingskill` = sk.`id`
		 group by dd.`missingskill`
		 order by count(dd.missingskill) desc
	) as missingskills on sk.`name` = missingskills.skillname
order by missingskills.numberofskills desc limit 6;
END $$
DELIMITER ;
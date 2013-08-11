-- Find the top recommended courses for a resume (skills that when added will give add to most jobs)
DELIMITER $$
DROP PROCEDURE IF EXISTS `fillskils`.`get_top_courses_more`$$
CREATE PROCEDURE  `fillskils`.`get_top_courses_more`
(
IN usersid INT
)
BEGIN
SELECT co.`name` as coursename, csk.courseid, missingskills.numberofskills, 
missingskills.skillname, co.`description`, co.`url` 
FROM coursesskills csk 
INNER JOIN skills sk ON csk.`skillid` = sk.`id` 
inner join courses co on co.`id` = csk.`courseid`
inner join
	(
	select count(dd.`missingskill`) as numberofskills, sk.`name` as skillname, group_concat(jobid) from
	(
	SELECT b.`skillid` as missingskill, b.`jobid`
	FROM jobsskills as b left outer JOIN (select * from usersskills where userid = usersid) as usert using (`skillid`) where usert.`skillid` is NULL ) as dd join skills as sk on 		dd.`missingskill` = sk.`id`
	group by dd.`missingskill`
	order by count(dd.missingskill) desc
	) as missingskills on sk.`name` = missingskills.skillname
order by missingskills.numberofskills desc limit 12;
END $$
DELIMITER ;
-- Find the top recommended courses for a resume (skills that when added will give add to most jobs)
DELIMITER $$
DROP PROCEDURE IF EXISTS `fillskils`.`get_top3_courses_skill`$$
CREATE PROCEDURE  `fillskils`.`get_top3_courses_skill`
(
IN skillname VARCHAR(50)
)
BEGIN
select co.`name` as coursename, co.`description`, co.`url` 
from skills sk 
inner join coursesskills csk on sk.`id` = csk.`skillid`
inner join courses co on csk.courseid = co.id where sk.name = skillname
limit 3;
END $$
DELIMITER ;
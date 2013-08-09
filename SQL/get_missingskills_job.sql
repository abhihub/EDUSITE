-- Get all skills that do not match certain jobs
DELIMITER $$
DROP PROCEDURE IF EXISTS `fillskils`.`get_missingskills_job`$$
CREATE PROCEDURE  `fillskils`.`get_missingskills_job`
(
IN usersid INT,
IN jobidin INT
)
BEGIN
SELECT b.`skillid` as skillid, b.`jobid` as jobid
FROM jobsskills as b 
LEFT OUTER JOIN 
(select * from usersskills where userid = usersid) as a 
using (`skillid`) 
where b.`jobid` = jobidin and a.`skillid` is NULL; 
END $$
DELIMITER ;
DELIMITER $$
DROP PROCEDURE IF EXISTS `fillskils`.`get_bestmatch_jobs`$$
CREATE PROCEDURE  `fillskils`.`get_bestmatch_jobs`
(
IN usersid INT
)
BEGIN
SELECT COUNT(aa.jobid) as numberofskills, aa.jobid as jobid, jj.url as url,
jj.jobtitle as jobtitle, CONCAT(jj.`city`, " ,", jj.`state`)
as location
FROM (
SELECT DISTINCT a.`skillid`, a.`userid`, b.`jobid` FROM 
(select * from usersskills where userid = usersid) as a 
INNER JOIN jobsskills as b using (`skillid`) 
) as aa 
join
jobs as jj on aa.`jobid` = jj.`id`
group by aa.`jobid`
order by count(aa.`jobid`) DESC LIMIT 6;
END $$
DELIMITER ;
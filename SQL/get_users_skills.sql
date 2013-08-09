-- Get the User's skills
DELIMITER $$
DROP PROCEDURE IF EXISTS `fillskils`.`get_users_skills`$$
CREATE PROCEDURE  `fillskils`.`get_users_skills`
(
IN usersid INT
)
BEGIN
select us.skillid, sk.`name` as skillname
from usersskills us join skills sk on us.`skillid` = sk.`id`
where us.`userid` = usersid;
END $$
DELIMITER ;

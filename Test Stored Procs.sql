CALL fillskils.get_bestmatch_jobs('3');

CALL fillskils.get_missingskills_job('1', '64');

CALL fillskils.get_top_missing_skills('3');

CALL fillskils.get_users_skills('1');

CALL fillskils.get_top_courses('1');

CALL fillskils.get_top3_courses_skill('cloud');

CALL fillskils.insert_new_skill('Algorithm Development');

CALL fillskils.check_if_is_skill('agile');

CALL fillskils.insert_skillsets('ios', 'cocos2d');

CALL get_skillset_matches(3);

CALL get_topjobs_skillsets;

CALL get_missingskills_skillset(3,8);

CALL get_skillsetid_byname('java development');

CALL insert_resume_for_user('java development', 1);
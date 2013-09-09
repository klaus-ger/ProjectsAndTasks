CREATE TABLE tx_projectsandtasks_domain_model_project (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL, 
    crdate int(11) unsigned DEFAULT '0' NOT NULL, 
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL, 
	
    project_title varchar(30) DEFAULT '' NOT NULL,
    project_short text,
    project_text text,
    project_sort int(11) DEFAULT '0' NOT NULL,
    project_status int(11) DEFAULT '0' NOT NULL,
    project_level int(11) DEFAULT '0' NOT NULL,
    project_typ int(11) DEFAULT '0' NOT NULL,
    project_parent int(11) DEFAULT '0' NOT NULL,
    project_owner int(11) DEFAULT '0' NOT NULL,
    project_icon varchar(255) DEFAULT '' NOT NULL,
    project_start int(11) DEFAULT '0' NOT NULL,
    project_budget_time int(11) DEFAULT '0' NOT NULL,
    project_budget_money int(11) DEFAULT '0' NOT NULL,
    project_revision_date int(11) DEFAULT '0' NOT NULL,
    project_start_date int(11) DEFAULT '0' NOT NULL,
    project_end_date int(11) DEFAULT '0' NOT NULL,

    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(30) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3_origuid int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l18n_parent int(11) DEFAULT '0' NOT NULL,
    l18n_diffsource mediumblob NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid)
);

CREATE TABLE fe_users (
    
    projects_and_tasks_user int(4) DEFAULT '0' NOT NULL,
);

CREATE TABLE tx_projectsandtasks_domain_model_todo (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL, 
    crdate int(11) unsigned DEFAULT '0' NOT NULL, 
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL, 
	
    todo_nr int(11) unsigned DEFAULT '0' NOT NULL,
    todo_list int(11) unsigned DEFAULT '0' NOT NULL, 
    todo_typ int(11) unsigned DEFAULT '0' NOT NULL, 
    todo_assigned int(11) unsigned DEFAULT '0' NOT NULL, 
    todo_title varchar(100) DEFAULT '' NOT NULL,
    todo_description text,
    todo_comment text,
    todo_status int(11) DEFAULT '0' NOT NULL,
    todo_date int(11) DEFAULT '0' NOT NULL,
    todo_end int(11) DEFAULT '0' NOT NULL,
    todo_plantime int(11) DEFAULT '0' NOT NULL,

    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(30) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3_origuid int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l18n_parent int(11) DEFAULT '0' NOT NULL,
    l18n_diffsource mediumblob NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid)
);

CREATE TABLE tx_projectsandtasks_domain_model_todolist (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL, 
    crdate int(11) unsigned DEFAULT '0' NOT NULL, 
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL, 
	
    todolist_project int(11) unsigned DEFAULT '0' NOT NULL, 
    todolist_titel varchar(100) DEFAULT '' NOT NULL,
    todolist_short_titel varchar(12) DEFAULT '' NOT NULL,
    todolist_description text,
    
    todolist_owner int(11) unsigned DEFAULT '0' NOT NULL,
    todolist_status int(11) DEFAULT '0' NOT NULL,

    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(30) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3_origuid int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l18n_parent int(11) DEFAULT '0' NOT NULL,
    l18n_diffsource mediumblob NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid)
);

CREATE TABLE tx_projectsandtasks_domain_model_work (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL, 
    crdate int(11) unsigned DEFAULT '0' NOT NULL, 
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL, 
	
    work_project int(11) unsigned DEFAULT '0' NOT NULL,
    work_user int(11) unsigned DEFAULT '0' NOT NULL,  
    work_title varchar(100) DEFAULT '' NOT NULL,
    work_description text,
    work_status int(11) DEFAULT '0' NOT NULL,
    work_date int(11) DEFAULT '0' NOT NULL,
    work_start int(11) DEFAULT '0' NOT NULL,
    work_end int(11) DEFAULT '0' NOT NULL,

    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(30) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3_origuid int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l18n_parent int(11) DEFAULT '0' NOT NULL,
    l18n_diffsource mediumblob NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid)
);


CREATE TABLE tx_projectsandtasks_domain_model_message (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL, 
    crdate int(11) unsigned DEFAULT '0' NOT NULL, 
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL, 
	
    message_title varchar(150) DEFAULT '' NOT NULL,
    message_text text,
    message_date int(11) DEFAULT '0' NOT NULL,
    message_project int(11) DEFAULT '0' NOT NULL,
    message_status int(3) DEFAULT '0' NOT NULL,
    message_sender varchar(255) DEFAULT '' NOT NULL,
    message_receiver varchar(255) DEFAULT '' NOT NULL,

    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(30) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3_origuid int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l18n_parent int(11) DEFAULT '0' NOT NULL,
    l18n_diffsource mediumblob NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid)
);


CREATE TABLE tx_projectsandtasks_domain_model_projectrights (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL, 
    crdate int(11) unsigned DEFAULT '0' NOT NULL, 
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL, 
	
    projectrights_project int(11) DEFAULT '0' NOT NULL,
    projectrights_user int(11) DEFAULT '0' NOT NULL,
    projectrights_rights int(11) DEFAULT '0' NOT NULL,
    projectrights_sticky int(11) DEFAULT '0' NOT NULL,

    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(30) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3_origuid int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l18n_parent int(11) DEFAULT '0' NOT NULL,
    l18n_diffsource mediumblob NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid)
);

CREATE TABLE tx_projectsandtasks_domain_model_calender_daynotes (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL, 
    crdate int(11) unsigned DEFAULT '0' NOT NULL, 
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL, 
	
    calender_user int(11) DEFAULT '0' NOT NULL,
    calender_date int(11) DEFAULT '0' NOT NULL,
    calender_daynote text,

    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(30) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3_origuid int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l18n_parent int(11) DEFAULT '0' NOT NULL,
    l18n_diffsource mediumblob NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid)
);

CREATE TABLE tx_projectsandtasks_domain_model_budget (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL, 
    crdate int(11) unsigned DEFAULT '0' NOT NULL, 
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL, 
	
    budget_project int(11) DEFAULT '0' NOT NULL,
    budget_title varchar(255) DEFAULT '' NOT NULL,
    budget_text text,
    budget_value int(11) DEFAULT '0' NOT NULL,
    budget_time int(11) DEFAULT '0' NOT NULL,
    budget_invoice int(11) DEFAULT '0' NOT NULL,

    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(30) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3_origuid int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l18n_parent int(11) DEFAULT '0' NOT NULL,
    l18n_diffsource mediumblob NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid)
);





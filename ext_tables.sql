CREATE TABLE tx_projectsandtasks_domain_model_projectteam (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL, 
    crdate int(11) unsigned DEFAULT '0' NOT NULL, 
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL, 
	
    pt_project int(11) unsigned DEFAULT '0' NOT NULL,
    pt_user int(11) unsigned DEFAULT '0' NOT NULL,
   
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

CREATE TABLE tx_projectsandtasks_domain_model_sprints (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL, 
    crdate int(11) unsigned DEFAULT '0' NOT NULL, 
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL, 
	
    sprint_project int(11) unsigned DEFAULT '0' NOT NULL,
    sprint_titel varchar(255) DEFAULT '' NOT NULL,
    sprint_text text,
    sprint_start varchar(255) DEFAULT '' NOT NULL,
    sprint_end varchar(255) DEFAULT '' NOT NULL,
    sprint_status int(11) unsigned DEFAULT '0' NOT NULL, 

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

CREATE TABLE tx_projectsandtasks_domain_model_tickets (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL, 
    crdate int(11) unsigned DEFAULT '0' NOT NULL, 
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL, 
	
    ticket_project int(11) unsigned DEFAULT '0' NOT NULL,
    ticket_milestone int(11) unsigned DEFAULT '0' NOT NULL,
    ticket_sprint int(11) unsigned DEFAULT '0' NOT NULL, 
    ticket_titel varchar(255) DEFAULT '' NOT NULL,
    ticket_date varchar(255) DEFAULT '' NOT NULL,
    ticket_schedule_date varchar(255) DEFAULT '' NOT NULL,
    ticket_schedule_time varchar(255) DEFAULT '' NOT NULL,
    ticket_status int(11) unsigned DEFAULT '0' NOT NULL, 
    ticket_typ int(11) unsigned DEFAULT '0' NOT NULL,  
    ticket_text text,
    ticket_custom_id varchar(10) DEFAULT '' NOT NULL,
    ticket_owner int(11) unsigned DEFAULT '0' NOT NULL,
    ticket_assigned int(11) unsigned DEFAULT '0' NOT NULL, 

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

CREATE TABLE tx_projectsandtasks_domain_model_projects (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL, 
    crdate int(11) unsigned DEFAULT '0' NOT NULL, 
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL, 
	
    project_titel varchar(255) DEFAULT '' NOT NULL,
    project_short varchar(255) DEFAULT '' NOT NULL,
    project_date varchar(255) DEFAULT '' NOT NULL,
    project_owner int(11) unsigned DEFAULT '0' NOT NULL,
    project_status tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    project_text text,
    project_cat tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    project_client tinyint(4) unsigned DEFAULT '0' NOT NULL, 

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

CREATE TABLE tx_projectsandtasks_domain_model_contracts (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL, 
    crdate int(11) unsigned DEFAULT '0' NOT NULL, 
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    
    contract_typ int(11) unsigned DEFAULT '0' NOT NULL,
    contract_titel varchar(255) DEFAULT '' NOT NULL,
    contract_project int(11) unsigned DEFAULT '0' NOT NULL,
    contract_status int(11) unsigned DEFAULT '0' NOT NULL,
    contract_value int(11) unsigned DEFAULT '0' NOT NULL,
    contract_description text,

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

CREATE TABLE tx_projectsandtasks_domain_model_status (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL, 
    crdate int(11) unsigned DEFAULT '0' NOT NULL, 
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    
    status_typ int(11) DEFAULT '0' NOT NULL, 
    status_text varchar(20) DEFAULT '' NOT NULL,
    status_behaviour tinyint(4) unsigned DEFAULT '0' NOT NULL,

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

CREATE TABLE tx_projectsandtasks_domain_model_statustyp (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL, 
    crdate int(11) unsigned DEFAULT '0' NOT NULL, 
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    
    statustyp_text varchar(20) DEFAULT '' NOT NULL,
    
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

CREATE TABLE tx_projectsandtasks_domain_model_ticketresponse (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL, 
    crdate int(11) unsigned DEFAULT '0' NOT NULL, 
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL, 
	
    tr_ticket int(11) unsigned DEFAULT '0' NOT NULL,
    tr_typ int(11) unsigned DEFAULT '0' NOT NULL,
    tr_titel varchar(100) DEFAULT '' NOT NULL,
    tr_text text,
    tr_date int(11) unsigned DEFAULT '0' NOT NULL,
    tr_start varchar(100) DEFAULT '' NOT NULL,
    tr_end varchar(100) DEFAULT '' NOT NULL,
    tr_time int(11) unsigned DEFAULT '0' NOT NULL,
    tr_owner int(11) unsigned DEFAULT '0' NOT NULL,
    
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

CREATE TABLE tx_projectsandtasks_domain_model_documents (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL, 
    crdate int(11) unsigned DEFAULT '0' NOT NULL, 
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    
    doc_project int(11) unsigned DEFAULT '0' NOT NULL,
    doc_description text;
    files text NOT NULL,

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

CREATE TABLE tx_projectsandtasks_domain_model_milestones (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL, 
    crdate int(11) unsigned DEFAULT '0' NOT NULL, 
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    
    ms_project int(11) unsigned DEFAULT '0' NOT NULL,
    ms_titel varchar(100) DEFAULT '' NOT NULL,
    ms_order int(11) unsigned DEFAULT '0' NOT NULL, 
    ms_text text,
    ms_start int(11) unsigned DEFAULT '0' NOT NULL,
    ms_end int(11) unsigned DEFAULT '0' NOT NULL,
    ms_status int(11) unsigned DEFAULT '0' NOT NULL,

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

CREATE TABLE tx_projectsandtasks_domain_model_projectcats (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL, 
    crdate int(11) unsigned DEFAULT '0' NOT NULL, 
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    
    cat_title varchar(100) DEFAULT '' NOT NULL,
    cat_parent int(11) unsigned DEFAULT '0' NOT NULL, 
    cat_order int(11) unsigned DEFAULT '0' NOT NULL, 

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

CREATE TABLE tx_projectsandtasks_domain_model_company (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL, 
    crdate int(11) unsigned DEFAULT '0' NOT NULL, 
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    
    cy_name varchar(255) DEFAULT '' NOT NULL,
    cy_short varchar(25) DEFAULT '' NOT NULL, 
    cy_street varchar(255) DEFAULT '' NOT NULL,
    cy_plz varchar(255) DEFAULT '' NOT NULL,
    cy_city varchar(255) DEFAULT '' NOT NULL,
    cy_web varchar(255) DEFAULT '' NOT NULL,
    cy_mail varchar(255) DEFAULT '' NOT NULL,
    cy_telephone varchar(255) DEFAULT '' NOT NULL,
    cy_customer tinyint(4) unsigned DEFAULT '0' NOT NULL,
    cy_comment text,

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

CREATE TABLE tx_projectsandtasks_domain_model_boardcat (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL, 
    crdate int(11) unsigned DEFAULT '0' NOT NULL, 
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    
    bc_title varchar(255) DEFAULT '' NOT NULL,
    bc_text text, 

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

CREATE TABLE tx_projectsandtasks_domain_model_boardtopic (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL, 
    crdate int(11) unsigned DEFAULT '0' NOT NULL, 
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    
    bt_title varchar(255) DEFAULT '' NOT NULL,
    bt_text text,
    bt_image varchar(255) DEFAULT '' NOT NULL,
    bt_date int(11) DEFAULT '0' NOT NULL,
    bt_user int(11) DEFAULT '0' NOT NULL,

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

CREATE TABLE tx_projectsandtasks_domain_model_boardmessage (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL, 
    crdate int(11) unsigned DEFAULT '0' NOT NULL, 
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    
    bm_title varchar(255) DEFAULT '' NOT NULL,
    bm_text text,
    bm_image varchar(255) DEFAULT '' NOT NULL,
    bm_date int(11) DEFAULT '0' NOT NULL,
    bm_user int(11) DEFAULT '0' NOT NULL,

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

CREATE TABLE tx_projectsandtasks_domain_model_statistic (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL, 
    crdate int(11) unsigned DEFAULT '0' NOT NULL, 
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL, 
    
    stats_date int(11) unsigned DEFAULT '0' NOT NULL,
    stats_tickets int(11) unsigned DEFAULT '0' NOT NULL,
    stats_opentime double(11,2) DEFAULT '0.00' NOT NULL,
    stats_age double(11,2) DEFAULT '0.00' NOT NULL,

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
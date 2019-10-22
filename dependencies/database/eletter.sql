drop database if exists eletter;
create database if not exists eletter;
use eletter;

create table el_organs (
	`id` int primary key auto_increment,
    `brand` varchar(100) null,
	`name` varchar(80) not null default '',
	`initials` varchar(10) not null default '',
    `created_at` timestamp null,
    `updated_at` timestamp null
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table el_users (
	`organ_id` int null,
	`id` int primary key auto_increment,
	`avatar` varchar(100) null,
	`first_name` varchar(20) not null default '',
	`last_name` varchar(45) not null default '',
	`email` varchar(100) not null default '',
	`username` varchar(20) not null default '',
	`password` varchar(255) not null default '',
	`status` int null default 0,
    `last_access` timestamp null,
    `created_at` timestamp null,
    `updated_at` timestamp null,
    foreign key (organ_id) 
	references el_organs (id) 
	on delete cascade 
	on update no action
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table el_templates (
	`organ_id` int not null,
	`id` int primary key auto_increment,
	`name` varchar(45) not null default '',
    `content` longtext not null,
	`created_at` timestamp null,
	`updated_at` timestamp null,
    foreign key (organ_id)
    references el_organs (id)
    on delete cascade
    on update no action
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table el_letters (
	`organ_id` int not null,
    `template_id` int not null,
	`id` int primary key auto_increment,
    `subject` varchar(100) not null default '',
	`content` text not null,
    `lot` int not null default 0,
    `status` int not null default 0,
	`send` timestamp not null default current_timestamp,
    `recipient_name` varchar(65) not null default '',
	`recipient_addr_zipcode` varchar(10) not null default '',
	`recipient_addr_street` varchar(45) not null default '',
	`recipient_addr_number` varchar(10) not null default '',
	`recipient_addr_neighborhood` varchar(20) not null default '',
	`recipient_addr_complement` varchar(20) null,
	`recipient_addr_city` varchar(20) not null default '',
	`recipient_addr_state` varchar(2) not null default '',
	`recipient_addr_country` varchar(20) not null default '',
    `created_at` timestamp null,
	`updated_at` timestamp null,
    
    foreign key (organ_id)
    references el_organs (id)
    on delete cascade
    on update no action,
    
    foreign key (template_id)
    references el_templates (id)
    on delete cascade
    on update no action
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table el_letters_attachments (
	`letter_id` int not null,
	`id` int primary key auto_increment,
	`data` mediumblob not null,
	foreign key (letter_id) 
	references el_letters (id) 
	on delete cascade 
	on update no action
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table el_fields (
	`organ_id` int not null,
	`id` int primary key auto_increment,
    `label` varchar(45) not null default '',
    `element` varchar(10) not null default '',
    `type` varchar(10) not null default '',
	`name` varchar(20) not null default '',
    `created_at` timestamp null,
    `updated_at` timestamp null,
    foreign key (organ_id)
    references el_organs (id)
    on delete cascade
    on update no action
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table el_fields_values (
	`letter_id` int not null,
	`field_id` int not null,
    `id` int primary key auto_increment,
	`value` text not null,
    
    foreign key (letter_id)
    references el_letters (id)
    on delete cascade
    on update no action,
    
    foreign key (field_id)
    references el_fields (id)
    on delete cascade
    on update no action
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table el_templates_has_fields (
	`template_id` int not null,
	`field_id` int not null,
    `id` int primary key auto_increment,
    `required` int null default 0,
    `order` int null default 0,
    
    foreign key (template_id)
    references el_templates (id)
    on delete cascade
    on update no action,
    
    foreign key (field_id)
    references el_fields (id)
    on delete cascade
    on update no action
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
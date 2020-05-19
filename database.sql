/**
 * Author:  Gino Tome
 * Created: May 6, 2020
 */


CREATE DATABASE IF NOT EXISTS tasker;

USE tasker;

CREATE TABLE IF NOT EXISTS users(
    id         int auto_increment not null,
    role       varchar(50),    
    name       varchar(100),  
    surname    varchar(100),  
    email      varchar(255),  
    password   varchar(255), 
    created_at datetime,
    CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb;

INSERT INTO users VALUES(NULL,'ROLE_USER','GINO','TOME','mail@mail.com','secret',NOW());
INSERT INTO users VALUES(NULL,'ROLE_USER','PEPE','ARG','mail@mail.com','secret',NOW());
INSERT INTO users VALUES(NULL,'ROLE_USER','CACH','MEX','mail@mail.com','secret',NOW());

CREATE TABLE IF NOT EXISTS tasks(
    id         int auto_increment not null,
    user_id    int not null,    
    title      varchar(255) DEFAULT NULL,  
    content    text DEFAULT NULL,  
    priority   varchar(20) DEFAULT NULL,  
    hours      int DEFAULT NULL DEFAULT NULL, 
    created_at datetime,
    CONSTRAINT pk_tasks PRIMARY KEY(id),
    CONSTRAINT fk_task_user FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb;


INSERT INTO tasks VALUES(NULL,1,'Feed the dog','grab some food and feed the doggo','high','0.25',NOW());
INSERT INTO tasks VALUES(NULL,1,'Wash the car','Grab a bucket and do the task','low','1.10',NOW());
INSERT INTO tasks VALUES(NULL,2,'Study Symfony','Go to Udemy and study!!','high','30',NOW());
INSERT INTO tasks VALUES(NULL,3,'Clean tha house','do your stuff man','medium','1.5',NOW());


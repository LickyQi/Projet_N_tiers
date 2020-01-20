create database ntiers;

use ntiers;

CREATE TABLE `Contracts` (
    `id` int(11) NOT NULL auto_increment,
    `name` varchar(100) NOT NULL,
    `date` text NOT NULL,
    `company` text NOT NULL,
    `description_pdf` longblob NOT NULL,
    `description` text NOT NULL,
    `description_text` MEDIUMTEXT NOT NULL,
    `comment` text NOT NULL,
    `state` text NOT NULL,
    PRIMARY KEY  (`id`)
);

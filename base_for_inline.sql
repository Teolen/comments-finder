CREATE DATABASE `base_for_inline`

CREATE TABLE `posts` (
    `id` INT unsigned NOT NULL AUTO_INCREMENT, 
    `userId` INT unsigned NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `body` TEXT(65535),
    PRIMARY KEY (`id`)
)ENGINE=innoDB

CREATE TABLE `comments` (
    `id` INT unsigned NOT NULL AUTO_INCREMENT, 
    `postId` INT REFERENCES posts(`id`), 
    `name` VARCHAR(255), 
    `email` VARCHAR(255), 
    `body` TEXT(65535), 
    PRIMARY KEY (`id`) 
)ENGINE=innoDB
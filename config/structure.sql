CREATE DATABASE tsn;

USE tsn;

CREATE TABLE `user` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT now(),
  `nickname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
);

CREATE TABLE `post` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT now(),
  `user_id` int NOT NULL,
  `content` mediumtext NOT NULL
);

CREATE TABLE `comment` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT now(),
  `user_id` int NOT NULL,
  `post_id` int NOT NULL,
  `content` varchar(255) NOT NULL DEFAULT ""
);

ALTER TABLE `post` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `comment` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `comment` ADD FOREIGN KEY (`post_id`) REFERENCES `post` (`id`);

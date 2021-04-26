USE tsn;

DELETE FROM `user`;
ALTER TABLE `user` AUTO_INCREMENT = 1;

INSERT INTO `user`(`id`, `created_at`, `nickname`, `password`) VALUES (1, "2020-01-01", "user1","pwd1");
INSERT INTO `user`(`id`, `created_at`, `nickname`, `password`) VALUES (2, "2020-01-02", "user2","pwd2");
INSERT INTO `user`(`id`, `created_at`, `nickname`, `password`) VALUES (3, "2020-01-03", "user3","pwd3");
INSERT INTO `user`(`id`, `created_at`, `nickname`, `password`) VALUES (4, "2020-01-04", "user4","pwd4");

DELETE FROM `post`;
ALTER TABLE `post` AUTO_INCREMENT = 1;
INSERT INTO `post`(`id`, `created_at`, `user_id`, `content`) VALUES (1, "2020-01-01", 1, "This is my first post on this tiny social network !!!");
INSERT INTO `post`(`id`, `created_at`, `user_id`, `content`) VALUES (2, "2020-02-01", 2, "<:3)-- This is a mouse...");
INSERT INTO `post`(`id`, `created_at`, `user_id`, `content`) VALUES (3, "2020-03-02", 1, "This is my second post ;)");

DELETE FROM `comment`;
ALTER TABLE `comment` AUTO_INCREMENT = 1;
INSERT INTO `comment`(`id`, `created_at`, `user_id`, `post_id`, `content`) VALUES (1, "2020-01-03", 2, 1, "It's a good start.");
INSERT INTO `comment`(`id`, `created_at`, `user_id`, `post_id`, `content`) VALUES (2, "2020-01-04", 3, 1, "Nice Dude :D");
INSERT INTO `comment`(`id`, `created_at`, `user_id`, `post_id`, `content`) VALUES (3, "2020-01-05", 1, 1, "Thx !!!");
INSERT INTO `comment`(`id`, `created_at`, `user_id`, `post_id`, `content`) VALUES (4, "2020-02-04", 1, 2, "You are an artist ^^");
INSERT INTO `comment`(`id`, `created_at`, `user_id`, `post_id`, `content`) VALUES (5, "2020-02-05", 4, 2, "-.-");

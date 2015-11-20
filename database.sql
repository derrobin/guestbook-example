CREATE DATABASE IF NOT EXISTS `guestbook` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;

USE `guestbook`;

CREATE TABLE `guestbook` (
  `id` int(11) NOT NULL,
  `username` varchar(90) NOT NULL,
  `email` varchar(140) NOT NULL,
  `title` varchar(140) NOT NULL,
  `content` text NOT NULL,
  `createdAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `guestbook` ADD PRIMARY KEY (`id`);
ALTER TABLE `guestbook` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
<?php

class Tables {

    private $kohana_auth = "CREATE TABLE IF NOT EXISTS `role` (
      `role_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `name` varchar(32) NOT NULL,
      `description` varchar(255) NOT NULL,
      PRIMARY KEY  (`role_id`),
      UNIQUE KEY `uniq_name` (`name`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

    INSERT INTO `role` (`role_id`, `name`, `description`) VALUES(1, 'login', 'Login privileges, granted after account confirmation');
    INSERT INTO `role` (`role_id`, `name`, `description`) VALUES(2, 'admin', 'Administrative user, has access to everything.');

    CREATE TABLE IF NOT EXISTS `user_role` (
      `user_id` INT UNSIGNED NOT NULL,
      `role_id` INT UNSIGNED NOT NULL,
      PRIMARY KEY (`role_id`, `user_id`),
      KEY `fk_role_id` (`role_id`),
      KEY `fk_user_id` (`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    CREATE TABLE IF NOT EXISTS `user` (
      `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `email` varchar(127) NOT NULL,
      `username` varchar(127),
      `standart_username` varchar(30)
      `password` char(64) NOT NULL,
      `registration_date` DATETIME,
      `last_login` DATETIME,
      `last_active` DATETIME,
      `last_calculate` DATETIME,
      `active` INT NOT NULL DEFAULT 1,
      `time_zone` INT NOT NULL DEFAULT 3,
      `language` varchar(2) NOT NULL DEFAULT 'ru',
      `logout` INT DEFAULT 0,
      `sonic_enabled` INT DEFAULT 0,
      index(username),
      index(standart_username),
      PRIMARY KEY  (`user_id`),
      UNIQUE KEY `uniq_email` (`email`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

    CREATE TABLE IF NOT EXISTS `user_token` (
      `token_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `user_id` INT UNSIGNED NOT NULL,
      `user_agent` varchar(40) NOT NULL,
      `token` varchar(32) NOT NULL,
      `created` DATETIME NOT NULL,
      `expires` DATETIME NOT NULL,
      PRIMARY KEY  (`token_id`),
      UNIQUE KEY `uniq_token` (`token`),
      KEY `fk_user_id` (`user_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

    ALTER TABLE `user_role`
      ADD CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
      ADD CONSTRAINT `user_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE CASCADE;

    ALTER TABLE `user_token`
      ADD CONSTRAINT `user_token_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;";

    private $user_data = "CREATE TABLE `user_data` (
            `user_data_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `user_id` INT UNSIGNED NOT NULL,
            `is_woman` INT,
            `name` VARCHAR (64) CHARACTER SET utf8,
            `birthday` DATE,
            `country_id` INT,
            `region_id` INT,
            `city_id` INT,
            `eyescolor` INT,
            `haircolor` INT,
            `growth` INT,
            `physique` INT,
            `ethnos` INT,
            `relationshep_status` INT,
            `family_status` INT,
            `material_lavel` INT,
            `education_lavel` INT,
            `baby_exist` INT,
            `baby_want` INT,
            `religion` INT,
            `spirituality` INT,
            `political_views` INT,
            `atmosphere_views` INT,
            `smoke_times` INT,
            `drink_times` INT,
            `humor_sense` INT,
            `profession` INT,
            `languages` VARCHAR (255) CHARACTER SET utf8,
            `zodiak_id` INT,
            KEY `fk_user_id` (`user_id`),
  CONSTRAINT `user_data_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    private $sputnik_data = "CREATE TABLE `sputnik_data` (
            `sputnik_data_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `user_id` INT UNSIGNED NOT NULL,
            `is_woman` INT,
            `age_min` DATE,
            `age_max` DATE,
            `country_id` INT,
            `region_id` INT,
            `city_id` INT,
            `eyescolor` VARCHAR (64) CHARACTER SET utf8,
            `haircolor` VARCHAR (64) CHARACTER SET utf8,
            `growth_min` INT,
            `growth_max` INT,
            `physique` VARCHAR (64) CHARACTER SET utf8,
            `ethnos` VARCHAR (64) CHARACTER SET utf8,
            `relationshep_status` VARCHAR (64) CHARACTER SET utf8,
            `family_status` VARCHAR (64) CHARACTER SET utf8,
            `material_lavel` VARCHAR (64) CHARACTER SET utf8,
            `education_lavel` VARCHAR (64) CHARACTER SET utf8,
            `baby_exist` VARCHAR (64) CHARACTER SET utf8,
            `baby_want` VARCHAR (64) CHARACTER SET utf8,
            `religion` VARCHAR (64) CHARACTER SET utf8,
            `spirituality` VARCHAR (64) CHARACTER SET utf8,
            `political_views` VARCHAR (64) CHARACTER SET utf8,
            `atmosphere_views` VARCHAR (64) CHARACTER SET utf8,
            `smoke_times` VARCHAR (64) CHARACTER SET utf8,
            `drink_times` VARCHAR (64) CHARACTER SET utf8,
            `humor_sense` VARCHAR (64) CHARACTER SET utf8,
            `profession` VARCHAR (64) CHARACTER SET utf8,
            `languages` VARCHAR (64) CHARACTER SET utf8,
            KEY `fk_user_id` (`user_id`),
  CONSTRAINT `sputnik_data_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    private $user_character = "CREATE TABLE `user_character` (
            `user_character_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `user_id` INT UNSIGNED NOT NULL,
            `strong` INT,
            `hardness` INT,
            `latitude` INT,
            `fragility` INT,
            `softness` INT,
            `nonchalance` INT,
            KEY `fk_user_id` (`user_id`),
  CONSTRAINT `user_character_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    private $user_card = "CREATE TABLE `user_card` (
            `user_card_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `user_id` INT UNSIGNED NOT NULL,
            `card_1` INT,
            `card_2` INT,
            `card_3` INT,
            `card_4` INT,
            `card_5` INT,
            `card_6` INT,
            `card_7` INT,
            `card_8` INT,
            `card_9` INT,
            `card_10` INT,
            `card_11` INT,
            `card_12` INT,
            KEY `fk_user_id` (`user_id`),
  CONSTRAINT `user_card_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    private $how_do_get = "CREATE TABLE `how_do_get` (
            `how_do_get_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `variant` INT) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    private $mail_prove = "CREATE TABLE `mail_prove` (
            `mail_prove_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `id_user` INT,
            `password` VARCHAR (40) CHARACTER SET utf8,
            KEY `fk_user_id` (`user_id`),
  CONSTRAINT `mail_prove_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    private $zodiac = "CREATE TABLE IF NOT EXISTS `zodiac` (
      `zodiac_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `day_begin` INT UNSIGNED NOT NULL,
      `month_begin` INT UNSIGNED NOT NULL,
      `day_end` INT UNSIGNED NOT NULL,
      `month_end` INT UNSIGNED NOT NULL,
      `name` VARCHAR (10) CHARACTER SET utf8,
      PRIMARY KEY  (`zodiac_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";

    private $zodiac_harmony = "CREATE TABLE IF NOT EXISTS `zodiac_harmony` (
      `zodiac_harmony_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `zodiac_id` INT UNSIGNED,
      `sputnik_zodiak` VARCHAR (30) CHARACTER SET utf8,
      `weight` FLOAT UNSIGNED NOT NULL,
      PRIMARY KEY  (`zodiac_harmony_id`),
      KEY `fk_zodiac_id` (`zodiac_id`),
      CONSTRAINT `zodiac_harmony_ibfk_1` FOREIGN KEY (`zodiac_id`) REFERENCES `zodiac` (`zodiac_id`) ON DELETE CASCADE
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";

    private $relationsheeps = "CREATE TABLE IF NOT EXISTS `rs_new` (
      `user_id` INT UNSIGNED NOT NULL,
      `sputnik_id` INT UNSIGNED NOT NULL,
      `dt_added` DATETIME NOT NULL,
      `dt_active` DATETIME,
      `ball` FLOAT,
      `lineno` BIGINT,
      PRIMARY KEY (`user_id`, `sputnik_id`),
      KEY `fk_user_id` (`user_id`),
      KEY `fk_sputnik_id` (`sputnik_id`),
      CONSTRAINT `rs_new_ibfk_2` FOREIGN KEY (`sputnik_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
      CONSTRAINT `rs_new_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `rs_interesme` (
      `user_id` INT UNSIGNED NOT NULL,
      `sputnik_id` INT UNSIGNED NOT NULL,
      `dt_added` DATETIME NOT NULL,
      `dt_active` DATETIME,
      `ball` FLOAT,
      `lineno` BIGINT,
      PRIMARY KEY (`user_id`, `sputnik_id`),
      KEY `fk_user_id` (`user_id`),
      KEY `fk_sputnik_id` (`sputnik_id`),
      CONSTRAINT `rs_interesme_ibfk_2` FOREIGN KEY (`sputnik_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
      CONSTRAINT `rs_interesme_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `rs_interes` (
      `user_id` INT UNSIGNED NOT NULL,
      `sputnik_id` INT UNSIGNED NOT NULL,
      `dt_added` DATETIME NOT NULL,
      `dt_active` DATETIME,
      `ball` FLOAT,
      `lineno` BIGINT,
      PRIMARY KEY (`user_id`, `sputnik_id`),
      KEY `fk_user_id` (`user_id`),
      KEY `fk_sputnik_id` (`sputnik_id`),
      CONSTRAINT `rs_interes_ibfk_2` FOREIGN KEY (`sputnik_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
      CONSTRAINT `rs_interes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `rs_saved` (
      `user_id` INT UNSIGNED NOT NULL,
      `sputnik_id` INT UNSIGNED NOT NULL,
      `dt_added` DATETIME NOT NULL,
      `dt_active` DATETIME,
      `ball` FLOAT,
      `lineno` BIGINT,
      PRIMARY KEY (`user_id`, `sputnik_id`),
      KEY `fk_user_id` (`user_id`),
      KEY `fk_sputnik_id` (`sputnik_id`),
      CONSTRAINT `rs_saved_ibfk_2` FOREIGN KEY (`sputnik_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
      CONSTRAINT `rs_saved_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `rs_ignor` (
      `user_id` INT UNSIGNED NOT NULL,
      `sputnik_id` INT UNSIGNED NOT NULL,
      `dt_added` DATETIME NOT NULL,
      `dt_active` DATETIME,
      `ball` FLOAT,
      `lineno` BIGINT,
      PRIMARY KEY (`user_id`, `sputnik_id`),
      KEY `fk_user_id` (`user_id`),
      KEY `fk_sputnik_id` (`sputnik_id`),
      CONSTRAINT `rs_ignor_ibfk_2` FOREIGN KEY (`sputnik_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
      CONSTRAINT `rs_ignor_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `rs_nosearch` (
      `user_id` INT UNSIGNED NOT NULL,
      `sputnik_id` INT UNSIGNED NOT NULL,
      `dt_added` DATETIME NOT NULL,
      `dt_active` DATETIME,
      `ball` FLOAT,
      `lineno` BIGINT,
      PRIMARY KEY (`user_id`, `sputnik_id`),
      KEY `fk_user_id` (`user_id`),
      KEY `fk_sputnik_id` (`sputnik_id`),
      CONSTRAINT `rs_nosearch_ibfk_2` FOREIGN KEY (`sputnik_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
      CONSTRAINT `rs_nosearch_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";

    private $niccards = "CREATE TABLE IF NOT EXISTS `nic_card` (
      `nic_card_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `user_id` INT UNSIGNED,
      `type`  VARCHAR (20) CHARACTER SET utf8,
      `lineno` INT,
      `strong` FLOAT(1) DEFAULT 0,
      `hardness` FLOAT(1) DEFAULT 0,
      `latitude` FLOAT(1) DEFAULT 0,
      `fragility` FLOAT(1) DEFAULT 0,
      `softness` FLOAT(1) DEFAULT 0,
      `nonchalance` FLOAT(1) DEFAULT 0,
      `a_l` INT DEFAULT 0,
      `b_l` INT DEFAULT 0,
      `c_l` INT DEFAULT 0,
      `d_l` INT DEFAULT 0,
      `e_l` INT DEFAULT 0,
      `f_l` INT DEFAULT 0,
      `a_b` INT DEFAULT 0,
      `b_b` INT DEFAULT 0,
      `c_b` INT DEFAULT 0,
      `d_b` INT DEFAULT 0,
      `e_b` INT DEFAULT 0,
      `f_b` INT DEFAULT 0,
      PRIMARY KEY  (`nic_card_id`),
      KEY `fk_user_id` (`user_id`),
      CONSTRAINT `nic_card_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";

    private $user_options = "CREATE TABLE `user_options` (
            `user_options_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `user_id` INT UNSIGNED NOT NULL,
            `confidence` varchar(126) CHARACTER SET utf8,
            `alerts` varchar(126) CHARACTER SET utf8,
            `sms` varchar(126) CHARACTER SET utf8,
            `commercial` varchar(126) CHARACTER SET utf8,
            `commercial_off` varchar(126) CHARACTER SET utf8,
            KEY `fk_user_id` (`user_id`),
  CONSTRAINT `user_options_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    private $tmp_pass = "CREATE TABLE `tmp_pass` (
            `tmp_pass_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `user_id` INT UNSIGNED NOT NULL,
            `password` varchar(40) CHARACTER SET utf8,
            `dt_create` BIGINT,
            `dt_expected` BIGINT,
            `handler` varchar(40) CHARACTER SET utf8,
            `data` varchar(255) CHARACTER SET utf8,
            KEY `fk_user_id` (`user_id`),
  CONSTRAINT `tmp_pass_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    private $question = "CREATE TABLE `question` (
            `question_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `user_id` INT UNSIGNED NOT NULL,
            `text` TEXT CHARACTER SET utf8,
            `dt_create` BIGINT,
            KEY `fk_user_id` (`user_id`),
  CONSTRAINT `question_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    private $calced = "CREATE TABLE IF NOT EXISTS `calced` (
      `user_id1` INT UNSIGNED NOT NULL,
      `user_id2` INT UNSIGNED NOT NULL,
      `dt_calc` DATE NOT NULL,
      `showed` INT,
      `ball` FLOAT,
      PRIMARY KEY (`user_id1`, `user_id2`),
      KEY `fk_user_id1` (`user_id1`),
      KEY `fk_user_id2` (`user_id2`),
      CONSTRAINT `calced_ibfk_2` FOREIGN KEY (`user_id2`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
      CONSTRAINT `calced_ibfk_1` FOREIGN KEY (`user_id1`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";

    private $system_options = "CREATE TABLE IF NOT EXISTS `system_options` (
      `system_options_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `name` VARCHAR (255) CHARACTER SET utf8,
      `value` VARCHAR (255) CHARACTER SET utf8,
      PRIMARY KEY  (`system_options_id`),
      KEY `fk_name` (`name`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";

    private $album = "CREATE TABLE IF NOT EXISTS `album` (
      `album_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `user_id` INT UNSIGNED NOT NULL,
      `name` VARCHAR (255) CHARACTER SET utf8,
      `comment` TEXT CHARACTER SET utf8,
      `dt_create` BIGINT,
      `dt_update` BIGINT,
      PRIMARY KEY  (`album_id`),
      KEY `fk_user_id` (`user_id`),
      CONSTRAINT `album_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";

    private $photo = "CREATE TABLE IF NOT EXISTS `photo` (
      `photo_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
      `album_id` INT UNSIGNED NOT NULL,
      `user_id` INT UNSIGNED NOT NULL,
      `name` VARCHAR (255) CHARACTER SET utf8,
      `comment` TEXT CHARACTER SET utf8,
      `lineno` BIGINT UNSIGNED,
      `type` VARCHAR (8) CHARACTER SET utf8 DEFAULT 'N',
      `link` VARCHAR (255) CHARACTER SET utf8,
      `dt_create` BIGINT,
      index(`type`),
      PRIMARY KEY  (`photo_id`),
      KEY `fk_user_id` (`user_id`),
      KEY `fk_album_id` (`album_id`),
      CONSTRAINT `photo_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
      CONSTRAINT `photo_ibfk_2` FOREIGN KEY (`album_id`) REFERENCES `album` (`album_id`) ON DELETE CASCADE
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";

    private $photo_like = "CREATE TABLE IF NOT EXISTS `photo_like` (
      `photo_id` BIGINT UNSIGNED NOT NULL,
      `user_id` INT UNSIGNED NOT NULL,
      `like_num` INT NOT NULL,
      PRIMARY KEY  (`photo_id`, `user_id`),
      KEY `fk_photo_id` (`photo_id`),
      KEY `fk_user_id` (`user_id`),
      CONSTRAINT `photo_like_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
      CONSTRAINT `photo_like_ibfk_2` FOREIGN KEY (`photo_id`) REFERENCES `photo` (`photo_id`) ON DELETE CASCADE
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";

    private $message = "CREATE TABLE IF NOT EXISTS `message` (
      `user_id` INT UNSIGNED NOT NULL,
      `message_id` VARCHAR(64) CHARACTER SET utf8,
      `sputnik_id` INT UNSIGNED NOT NULL,
      `dt_send`  BIGINT,
      `text` TEXT,
      `is_out` INT(1),
      `attribute` INT(1),
      PRIMARY KEY  (`user_id`, `message_id`),
      KEY `fk_user_id` (`user_id`),
      KEY `fk_message_id` (`message_id`),
      KEY `fk_sputnik_id` (`sputnik_id`),
      CONSTRAINT `massag_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
      CONSTRAINT `massag_ibfk_2` FOREIGN KEY (`sputnik_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";

    private $spam = "CREATE TABLE IF NOT EXISTS `spam` (
      `user_id` INT UNSIGNED NOT NULL,
      `message_id` VARCHAR(64) CHARACTER SET utf8,
      `sputnik_id` INT UNSIGNED NOT NULL,
      `dt_send` BIGINT,
      `dt_spam` BIGINT,
      `text` TEXT,
      PRIMARY KEY  (`user_id`, `message_id`),
      KEY `fk_user_id` (`user_id`),
      KEY `fk_message_id` (`message_id`),
      KEY `fk_sputnik_id` (`sputnik_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";

    private $message = "CREATE TABLE IF NOT EXISTS `admin_message` (
      `user_id` INT UNSIGNED NOT NULL,
      `message_id` VARCHAR(64) CHARACTER SET utf8,
      `dt_send`  BIGINT,
      `text` TEXT,
      `attribute` INT(1),
      PRIMARY KEY  (`user_id`, `message_id`),
      KEY `fk_user_id` (`user_id`),
      KEY `fk_message_id` (`message_id`),
      CONSTRAINT `admin_message_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";

}

?>

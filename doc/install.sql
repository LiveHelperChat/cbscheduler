CREATE TABLE `lhc_cbscheduler_reservation` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `slot_id` bigint(20) NOT NULL,
  `tz` varchar(50) NOT NULL,
  `cb_time_start` bigint(20) NOT NULL,
  `cb_time_end` bigint(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `outcome` text NOT NULL,
  `subject_id` int(11) NOT NULL,
  `schedule_id` bigint(20) NOT NULL,
  `daytime` bigint(20) NOT NULL,
  `dep_id` bigint(20) NOT NULL,
  `chat_id` bigint(20) NOT NULL,
  `region` varchar(2) NOT NULL,
  `ctime` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `slot_id` (`slot_id`),
  KEY `schedule_id` (`schedule_id`),
  KEY `daytime` (`daytime`),
  KEY `chat_id` (`chat_id`),
  KEY `dep_id` (`dep_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `lhc_cbscheduler_scheduler` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `tz` varchar(50) NOT NULL,
  `active` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `lhc_cbscheduler_scheduler_dep` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `schedule_id` int(11) NOT NULL,
  `dep_id` int(11) NOT NULL,
  `dep_group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `dep_group_id` (`dep_group_id`),
  KEY `schedule_id` (`schedule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `lhc_cbscheduler_scheduler_dep_group` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `schedule_id` int(11) NOT NULL,
  `dep_group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `schedule_id` (`schedule_id`),
  KEY `dep_group_id` (`dep_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `lhc_cbscheduler_slot` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `schedule_id` bigint(20) NOT NULL,
  `time_start_h` int(11) NOT NULL,
  `time_start_m` int(11) NOT NULL,
  `time_end_h` int(11) NOT NULL,
  `time_end_m` int(11) NOT NULL,
  `max_calls` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `day` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `schedule_id` (`schedule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `lhc_cbscheduler_subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pos` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
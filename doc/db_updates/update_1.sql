ALTER TABLE `lhc_cbscheduler_reservation`
                                                ADD `parent_id` bigint(20) NOT NULL DEFAULT '0',
                                                COMMENT='';

CREATE TABLE `oc_brax_payment_term` (
  `customer_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`customer_id`,`customer_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
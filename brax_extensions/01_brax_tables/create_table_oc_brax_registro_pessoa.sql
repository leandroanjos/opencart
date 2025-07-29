CREATE TABLE `oc_brax_registro_pessoa` (
  `registro_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `brax_id` int(11) DEFAULT NULL,
  `tipo_pessoa` char(1) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `razao_social` varchar(80) DEFAULT NULL,
  `doc` varchar(18) NOT NULL,
  `rgie` varchar(14) DEFAULT NULL,
  `data_alteracao` date NOT NULL,
  PRIMARY KEY (`registro_id`),
  UNIQUE KEY `customer_id` (`customer_id`),
  KEY `brax_id` (`brax_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11308 DEFAULT CHARSET=utf8;
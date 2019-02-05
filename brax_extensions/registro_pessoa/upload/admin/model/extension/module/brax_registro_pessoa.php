<?php
class ModelExtensionModuleBraxRegistroPessoa extends Model {
	public function install() {
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "brax_registro_pessoa` (
				`registro_id` INT(11) NOT NULL AUTO_INCREMENT,
				`customer_id` INT(11) NOT NULL UNIQUE,
				`brax_id` INT(11),
				`tipo_pessoa` CHAR(1) NOT NULL,
				`nome` VARCHAR(80) NOT NULL,
				`razao_social` VARCHAR(80),
				`doc` VARCHAR(18) NOT NULL,
				`rgie` VARCHAR(14),
				PRIMARY KEY (`registro_id`)
			) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;");
	}

	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "brax_registro_pessoa`;");
	}
}
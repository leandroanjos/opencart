<?php
class ModelExtensionBraxPaymentTerm extends Model {
	public function getLookupByCustomerId($customer_id) {
		return $this->db->query("SELECT * FROM `" . DB_PREFIX . "payment_term` WHERE `customer_id` = " . (int)$customer_id);
	}

	public function install() {
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "payment_term` (
				`customer_id` INT(11) NOT NULL,
				`customer_group_id` INT(11) NOT NULL,
				`name` text NOT NULL,
				PRIMARY KEY (`customer_id`, `customer_group_id`)
			) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;");
	}

	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "payment_term`;");
	}
}

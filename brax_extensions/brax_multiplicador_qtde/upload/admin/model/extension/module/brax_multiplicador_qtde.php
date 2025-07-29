<?php
class ModelExtensionModuleBraxMultiplicadorQtde extends Model {
	public function install() {
		$this->db->query("ALTER TABLE " . DB_PREFIX . "product ADD COLUMN measure_unit VARCHAR(80) AFTER quantity;");
		$this->db->query("ALTER TABLE " . DB_PREFIX . "product ADD COLUMN quantity_multiplier DECIMAL(10, 2) AFTER quantity;");
	}

	public function uninstall() {
		$this->db->query("ALTER TABLE " . DB_PREFIX . "product DROP COLUMN measure_unit;");
		$this->db->query("ALTER TABLE " . DB_PREFIX . "product DROP COLUMN quantity_multiplier;");
	}
}

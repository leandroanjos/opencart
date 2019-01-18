<?php
class ModelBraxPaymentTerm extends Model {
	public function getPaymentTerms($customer_id) {
		$cache_id = 'payment_term.catalog_' . $customer_id;
		$payment_term_data = $this->cache->get($cache_id);

		if (!$payment_term_data) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "payment_term WHERE payment_term = '" . (int)$customer_id . "' ORDER BY name ASC");

			$payment_term_data = $query->rows;

			$this->cache->set($cache_id, $payment_term_data);
		}

		return $payment_term_data;
	}
}
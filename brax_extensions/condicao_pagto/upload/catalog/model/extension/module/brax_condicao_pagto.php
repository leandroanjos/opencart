<?php
class ModelExtensionModuleBraxCondicaoPagto extends Model {
	public function getPaymentTerms($customer_id) {
		/*
		$cache_id = 'brax_condicao_pagto.catalog_' . $customer_id;
		$payment_term_data = $this->cache->get($cache_id);

		if (!$payment_term_data) {
		*/
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "brax_payment_term WHERE customer_id = '" . (int)$customer_id . "' ORDER BY name ASC");

		$payment_term_data = $query->rows;

		/*
			$this->cache->set($cache_id, $payment_term_data);
		}
		*/
		return $payment_term_data;
	}
}
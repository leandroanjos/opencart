<?php
class ControllerExtensionModuleBraxCondicaoPagto extends Controller {
	public function index() {
		$this->load->language('extension/module/brax_condicao_pagto');
		$this->load->model('extension/module/brax_condicao_pagto');
		$this->load->model('account/customer');
		$paymentTerms = array();
		$customer = array();
		
		// Identifica a condição de pagamento selecionada
		if (isset($this->session->data['customer_id'])) {
			$customer_id = $this->session->data['customer_id'];
			$this->log->write('Customer ID = ' . $customer_id . '.');

			// Pesquisa os dados do cliente
			$customer = $this->model_account_customer->getCustomer($customer_id);
			$this->log->write('Customer Group = ' . $customer['customer_group_id'] . '.');

			// Pesquisa as condições liberadas para o cliente
			$paymentTerms = $this->model_extension_module_brax_condicao_pagto->getPaymentTerms($customer_id);
			
			// Define o codigo do grupo selecionado para ser utilizado pelo combobox
			$data['code'] = $customer['customer_group_id'];
		} else {
			$data['code'] = 0;
		}

		// Gera a URL para o Redirecionamento em caso de alteração da condição
		$url_data = $this->request->get;

		if (isset($url_data['route'])) {
			$route = $url_data['route'];
		} else {
			$route = $this->config->get('action_default');
		}

		$redirect = urlencode(str_replace('&amp;', '&', $this->url->link($route)));

		// Popula os dados usado para o combo de condições e pagamento
		$data['payment_terms'] = array();

		foreach ($paymentTerms as $result) {
			if ($result['name']) {
				$data['payment_terms'][] = array(
					'name' => $result['name'],
					'code' => $result['customer_group_id'],
					'href' => $this->url->link('extension/module/brax_condicao_pagto/select', 'code=' . $result['customer_group_id'] . '&redirect=' . $redirect)
				);
			}
		}

		// Renderiza a view contendo o combobox
		return $this->load->view('extension/module/brax_condicao_pagto', $data);
	}

	public function select() {		
		// Verifica se algum código foi selecionado
		if (isset($this->request->get['code']) && $this->request->get['code'] > 0) {
			// Carrega o model de clientes
			$this->load->model('account/customer');
			// Atualiza o cadastro do cliente
			$customer_id = $this->session->data['customer_id'];
			$customer_group_id = $this->request->get['code'];
			// Atualiza o cadastro do cliente
			$this->model_account_customer->setPaymentTerm($customer_id, $customer_group_id);
		}

		// Aciona o redirecionamento
		if (isset($this->request->get['redirect']) && substr($this->request->get['redirect'], 0, strlen($this->config->get('config_url'))) == $this->config->get('config_url')) {
			$this->response->redirect(str_replace('&amp;', '&', $this->request->get['redirect']));
		} else {
			$this->response->redirect($this->url->link($this->config->get('action_default')));
		}
	}
}
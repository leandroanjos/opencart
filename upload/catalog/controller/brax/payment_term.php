<?php
class ControllerBraxPaymentTerm extends Controller {
	public function index() {
		$this->load->model('brax/payment_tem');

		$paymentTerms = array();

		if (isset($this->session->data['customer'])) {
			$customer_id = $this->session->data['customer']['customer_id'];
			$paymentTerms = $this->model_payment_term->getPaymentTerms($customer_id);
		}

		$data['code'] = $this->session->data['customer_group_id'];

		$data['payment_terms'] = array();

		foreach ($results as $result) {
			if ($result['status']) {
				$data['payment_terms'][] = array(
					'name' => $result['name'],
					'code' => $result['customer_group_id'],
					'href' => $this->url->link('brax/payment_term/payment_term', 'language=' . $this->config->get('config_language') . '&code=' . $result['customer_group_id'] . '&redirect=' . urlencode(str_replace('&amp;', '&', $this->url->link($route, 'language=' . $url))))
				);
			}
		}

		return $this->load->view('brax/payment_term', $data);
	}

	public function payment_term() {
		if (isset($this->request->post['code'])) {
			$this->session->data['customer_group_id'] = $this->request->post['code'];
		}
		
		if (isset($this->request->post['redirect']) && substr($this->request->post['redirect'], 0, strlen($this->config->get('config_url'))) == $this->config->get('config_url')) {
			$this->response->redirect(str_replace('&amp;', '&', $this->request->post['redirect']));
		} else {
			$this->response->redirect($this->url->link($this->config->get('action_default')));
		}
	}
}
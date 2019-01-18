<?php
class ControllerExtensionBraxPaymentTerm extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/brax/payment_term');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$this->load->model('extension/brax/payment_term');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('brax_payment_term', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment'));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/brax/payment_term', 'user_token=' . $this->session->data['user_token'])
		);

		$data['action'] = $this->url->link('extension/brax/payment_term', 'user_token=' . $this->session->data['user_token']);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment');

		$this->load->model('localisation/order_status');

		if (isset($this->request->post['brax_payment_term_status'])) {
			$data['brax_payment_term_status'] = $this->request->post['brax_payment_term_status'];
		} else {
			$data['brax_payment_term_status'] = $this->config->get('brax_payment_term_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/brax/payment_term', $data));
	}

	public function install() {
		$this->load->model('extension/brax/payment_term');
		$this->model_extension_brax_payment_term->install();
	}

	public function uninstall() {
		$this->load->model('extension/brax/payment_term');
		$this->model_extension_brax_payment_term->uninstall();
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/brax/payment_term')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}
?>
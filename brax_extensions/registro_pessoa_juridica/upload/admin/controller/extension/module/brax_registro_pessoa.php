<?php
class ControllerExtensionModuleBraxRegistroPessoa extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/brax_registro_pessoa');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_brax_registro_pessoa', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module'));
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
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/brax_registro_pessoa', 'user_token=' . $this->session->data['user_token'])
		);

		$data['action'] = $this->url->link('extension/module/brax_registro_pessoa', 'user_token=' . $this->session->data['user_token']);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module');

		if (isset($this->request->post['module_brax_registro_pessoa_status'])) {
			$data['module_brax_registro_pessoa_status'] = $this->request->post['module_brax_registro_pessoa_status'];
		} else {
			$data['module_brax_registro_pessoa_status'] = $this->config->get('module_brax_registro_pessoa_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/brax_registro_pessoa', $data));
	}

	public function install() {
		$this->load->model('extension/module/brax_registro_pessoa');
		$this->model_extension_module_brax_registro_pessoa->install();
	}

	public function uninstall() {
		$this->load->model('extension/module/brax_registro_pessoa');
		$this->model_extension_module_brax_registro_pessoa->uninstall();
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/brax_registro_pessoa')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}
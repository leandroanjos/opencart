<?php
class ControllerExtensionModuleBraxBotaoDownload extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/brax_botao_download');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_brax_botao_download', $this->request->post);

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
			'href' => $this->url->link('extension/module/brax_botao_download', 'user_token=' . $this->session->data['user_token'])
		);

		$data['action'] = $this->url->link('extension/module/brax_botao_download', 'user_token=' . $this->session->data['user_token']);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module');

		//$this->load->model('localisation/order_status');

		if (isset($this->request->post['module_brax_botao_download_status'])) {
			$data['module_brax_botao_download_status'] = $this->request->post['module_brax_botao_download_status'];
		} else {
			$data['module_brax_botao_download_status'] = $this->config->get('module_brax_botao_download_status');
		}

		if (isset($this->request->post['module_brax_botao_download_information_code_01'])) {
			$data['module_brax_botao_download_information_code_0'] = $this->request->post['module_brax_botao_download_information_code_0'];
			$data['module_brax_botao_download_information_code_1'] = $this->request->post['module_brax_botao_download_information_code_1'];
			$data['module_brax_botao_download_information_code_2'] = $this->request->post['module_brax_botao_download_information_code_2'];
			$data['module_brax_botao_download_information_code_3'] = $this->request->post['module_brax_botao_download_information_code_3'];
			$data['module_brax_botao_download_information_code_4'] = $this->request->post['module_brax_botao_download_information_code_4'];
		} else {
			$data['module_brax_botao_download_information_code_0'] = $this->config->get('module_brax_botao_download_information_code_0');
			$data['module_brax_botao_download_information_code_1'] = $this->config->get('module_brax_botao_download_information_code_1');
			$data['module_brax_botao_download_information_code_2'] = $this->config->get('module_brax_botao_download_information_code_2');
			$data['module_brax_botao_download_information_code_3'] = $this->config->get('module_brax_botao_download_information_code_3');
			$data['module_brax_botao_download_information_code_4'] = $this->config->get('module_brax_botao_download_information_code_4');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/brax_botao_download', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/brax_botao_download')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}
?>
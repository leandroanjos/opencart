<?php
class ControllerExtensionModuleBraxRegistroPessoa extends Controller {
	private $error = array();
	
	public function index() {
		if ($this->customer->isLogged()) {
			$this->response->redirect($this->url->link('account/account', 'language=' . $this->config->get('config_language')));
		}
		$this->load->language('extension/module/brax_registro_pessoa');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment/moment.min.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment/moment-with-locales.min.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

		$data['firstname'] = '';
		$data['lastname'] = '';
		
		if (isset($this->request->post['nome'])) {
			$nome = $this->request->post['nome'];
			$data['nome'] = $nome;

			$palavras = explode(" ", $nome);
			$data['firstname'] = $palavras[0];
			
			if (sizeof($palavras) > 1) {
				$data['lastname'] = $palavras[sizeof($palavras) - 1];
			}
		} else {
			$data['nome'] = '';
		}

		$this->load->model('account/customer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			unset($this->session->data['guest']);

			$this->load->model('extension/module/brax_registro_pessoa');

			$customer_data = $this->request->post;
			$customer_data['firstname'] = $data['firstname'];
			$customer_data['lastname'] = $data['lastname'];

			$customer_id = $this->model_account_customer->addCustomer($customer_data);
			$registro_id = $this->model_extension_module_brax_registro_pessoa->addRegistro($customer_data, $customer_id);

			// Clear any previous login attempts for unregistered accounts.
			$this->model_account_customer->deleteLoginAttempts($this->request->post['email']);

			$this->customer->login($this->request->post['email'], $this->request->post['password']);

			unset($this->session->data['guest']);

			$this->response->redirect($this->url->link('account/success'));
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'language=' . $this->config->get('config_language'))
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', 'language=' . $this->config->get('config_language'))
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_register'),
			'href' => $this->url->link('account/register', 'language=' . $this->config->get('config_language'))
		);

		$data['text_account_already'] = sprintf($this->language->get('text_account_already'), $this->url->link('account/login', 'language=' . $this->config->get('config_language')));

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}
		if (isset($this->error['firstname'])) {
			$data['error_firstname'] = $this->error['firstname'];
		} else {
			$data['error_firstname'] = '';
		}

		if (isset($this->error['lastname'])) {
			$data['error_lastname'] = $this->error['lastname'];
		} else {
			$data['error_lastname'] = '';
		}

		if (isset($this->error['telephone'])) {
			$data['error_telephone'] = $this->error['telephone'];
		} else {
			$data['error_telephone'] = '';
		}

		if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}

		if (isset($this->error['nome'])) {
			$data['error_nome'] = $this->error['nome'];
		} else {
			$data['error_nome'] = '';
		}
		
		if (isset($this->error['razaosocial'])) {
			$data['error_razaosocial'] = $this->error['razaosocial'];
		} else {
			$data['error_razaosocial'] = '';
		}
		
		if (isset($this->error['doc'])) {
			$data['error_doc'] = $this->error['doc'];
		} else {
			$data['error_doc'] = '';
		}
		
		if (isset($this->error['rgie'])) {
			$data['error_rgie'] = $this->error['rgie'];
		} else {
			$data['error_rgie'] = '';
		}

		if (isset($this->error['confirm'])) {
			$data['error_confirm'] = $this->error['confirm'];
		} else {
			$data['error_confirm'] = '';
		}

		$data['action'] = $this->url->link('extension/module/brax_registro_pessoa', 'language=' . $this->config->get('config_language'));

		$data['customer_groups'] = array();

		if (is_array($this->config->get('config_customer_group_display'))) {
			$this->load->model('account/customer_group');

			$customer_groups = $this->model_account_customer_group->getCustomerGroups();

			foreach ($customer_groups as $customer_group) {
				if (in_array($customer_group['customer_group_id'], $this->config->get('config_customer_group_display'))) {
					$data['customer_groups'][] = $customer_group;
				}
			}
		}

		$data['customer_group_id'] = $this->config->get('config_customer_group_id');

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} else {
			$data['telephone'] = '';
		}

		if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}

		if (isset($this->request->post['razaosocial'])) {
			$data['razaosocial'] = $this->request->post['razaosocial'];
		} else {
			$data['razaosocial'] = '';
		}
		
		if (isset($this->request->post['doc'])) {
			$data['doc'] = $this->request->post['doc'];
		} else {
			$data['doc'] = '';
		}
		
		if (isset($this->request->post['rgie'])) {
			$data['rgie'] = $this->request->post['rgie'];
		} else {
			$data['rgie'] = '';
		}

		if (isset($this->request->post['confirm'])) {
			$data['confirm'] = $this->request->post['confirm'];
		} else {
			$data['confirm'] = '';
		}
		
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('extension/module/brax_registro_pessoa', $data));
	}

	private function validate() {
		if ((utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if ((utf8_strlen(trim($this->request->post['nome'])) < 3) || (utf8_strlen(trim($this->request->post['nome'])) > 80)) {
			$this->error['nome'] = $this->language->get('error_nome');
		}
		
		if ((utf8_strlen(trim($this->request->post['razaosocial'])) > 0 && utf8_strlen(trim($this->request->post['razaosocial'])) < 3) 
			|| (utf8_strlen(trim($this->request->post['razaosocial'])) > 80)) {
			$this->error['razaosocial'] = $this->language->get('error_razaosocial');
		}
		
		if ((utf8_strlen(trim($this->request->post['doc'])) < 1) || (utf8_strlen(trim($this->request->post['doc'])) > 18)) {
			$this->error['doc'] = $this->language->get('error_doc');
		}
		
		if (utf8_strlen(trim($this->request->post['rgie'])) > 15) {
			$this->error['rgie'] = $this->language->get('error_rgie');
		}	

		if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
			$this->error['warning'] = $this->language->get('error_email_exists');
		}

		if ($this->model_account_customer->getTotalCustomersByDoc($this->request->post['doc'])) {
			$this->error['warning'] = $this->language->get('error_doc_exists');
		}

		if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}

		// Customer Group
		if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $this->request->post['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		if ((utf8_strlen(html_entity_decode($this->request->post['password'], ENT_QUOTES, 'UTF-8')) < 4) || (utf8_strlen(html_entity_decode($this->request->post['password'], ENT_QUOTES, 'UTF-8')) > 40)) {
			$this->error['password'] = $this->language->get('error_password');
		}

		if ($this->request->post['confirm'] !== $this->request->post['password']) {
			$this->error['confirm'] = $this->language->get('error_confirm');
		}
		
		return !$this->error;
	}
}
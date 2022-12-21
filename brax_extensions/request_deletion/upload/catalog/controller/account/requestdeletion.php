<?php
class ControllerAccountRequestDeletion extends Controller {
	private $error = array();

	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/requestdeletion', 'language=' . $this->config->get('config_language'));

			$this->response->redirect($this->url->link('account/login', 'language=' . $this->config->get('config_language')));
		}

		$this->load->language('account/requestdeletion');

		$this->document->setTitle($this->language->get('heading_title'));

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
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('account/requestdeletion', 'language=' . $this->config->get('config_language'))
		);

		if (isset($this->error['confirm'])) {
			$data['error_confirm'] = $this->error['confirm'];
		} else {
			$data['error_confirm'] = '';
		}

		$data['action'] = $this->url->link('account/requestdeletion/confirm', 'language=' . $this->config->get('config_language'));

		if (isset($this->request->post['confirm'])) {
			$data['confirm'] = $this->request->post['confirm'];
		} else {
			$data['confirm'] = '';
		}

		$data['back'] = $this->url->link('account/account', 'language=' . $this->config->get('config_language'));

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/requestdeletion', $data));
	}

	public function confirm() {
		if ($this->customer->isLogged()) {
			$this->load->model('account/customer');

			$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());

			if ($customer_info) {
				$this->load->model('setting/store');
				
				$store_name = html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');
				$store_url = $this->config->get('config_url');

				$this->load->model('localisation/language');

				$language_info = $this->model_localisation_language->getLanguage($customer_info['language_id']);

				if ($language_info) {
					$language_code = $language_info['code'];
				} else {
					$language_code = $this->config->get('config_language');
				}

				$language = new Language($language_code);
				$language->load($language_code);
				$language->load('mail/requestdeletion');

				// HTML Mail
				$subject = sprintf($language->get('text_subject'), $store_name);
				
				$data['title'] = $subject;
				$data['text_store_message'] = $language->get('text_store_message');
				$data['text_admin_url'] = $language->get('text_admin_url');
				$data['admin_url'] = $store_url . 'admin/index.php?route=customer/customer/edit&customer_id=' . $this->customer->getId();

				$data['text_name'] = $language->get('text_name');
				$data['name'] = $this->customer->getFirstName() . ' ' . $this->customer->getLastName();
				$data['text_mail'] = $language->get('text_mail');
				$data['mail'] = $customer_info['email'];

				$data['text_customer_message'] = $language->get('text_customer_message');
				$data['text_customer_footer'] = $language->get('text_customer_footer');
				
				$data['login'] = $store_url . 'index.php?route=account/login';
				$data['store'] = $store_name;
				$data['store_url'] = $store_url;

				$this->load->model('tool/image');

				if (is_file(DIR_IMAGE . html_entity_decode($this->config->get('config_logo'), ENT_QUOTES, 'UTF-8'))) {
					$data['logo'] = $this->model_tool_image->resize(html_entity_decode($this->config->get('config_logo'), ENT_QUOTES, 'UTF-8'), $this->config->get('theme_default_image_location_width'), $this->config->get('theme_default_image_cart_height'));
				} else {
					$data['logo'] = '';
				}

				$mail = new Mail($this->config->get('config_mail_engine'));
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
				
				// Envia o e-mail para a loja
				$mail->setTo($this->config->get('config_email'));
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($store_name);
				$mail->setSubject($subject);
				$mail->setHtml($this->load->view('mail/requestdeletionstore', $data));
				$mail->send();

				// Envia o e-mail para o cliente
				$mail->setHtml($this->load->view('mail/requestdeletioncustomer', $data));
				$mail->setTo($customer_info['email']);
				$mail->send();

				//$this->model_account_customer->requestdeletionAccount($this->customer->getEmail());

				$this->session->data['success'] = $this->language->get('text_success');

				$this->response->redirect($this->url->link('account/account', 'language=' . $this->config->get('config_language')));
			} else {
				$this->session->data['error'] = $this->language->get('error_confirm');

				$this->response->redirect($this->url->link('account/account', 'language=' . $this->config->get('config_language')));
			}
		} else {
			$this->session->data['redirect'] = $this->url->link('account/requestdeletion', 'language=' . $this->config->get('config_language'));

			$this->response->redirect($this->url->link('account/login', 'language=' . $this->config->get('config_language')));
		}
	}
}
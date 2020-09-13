<?php
class ControllerExtensionModuleBraxNotificacao extends Controller {
	public function index() {
		$this->load->language('extension/module/brax_notificacao');
		$store_name = html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');

		$data['login'] = $this->url->link('common/home', '', true);
		$data['store'] = $store_name;
		
		$url_data = $this->request->get;

		if ($this->config->get('module_brax_notificacao_status')) {			
			if ($url_data != null && $url_data['type'] != null && $url_data['type'] == 'registro_aprovado') {
				if ($url_data['email'] != null && $url_data['status'] == '1') {
					log_message("Notificacao de Registro Aprovado...");
					$this->load->model('account/customer');
			
					$last_email = "";
					if ($url_data['customer_id'] != null) {
						$customer_info = $this->model_account_customer->getCustomer($url_data['customer_id']);

						if ($customer_info) {
							$last_email = $customer_info['email'];
						}
					}

					if ($url_data['email'] != $last_email) {
						log_message('Novo e-mail: ' . $url_data['email']);
						
						$subject = sprintf($this->language->get('text_subject'), $store_name);

						$data['text_welcome'] =  sprintf($this->language->get('text_welcome'), $store_name);
						$data['text_login'] = $this->language->get('text_login');
						$data['text_redefine'] = $this->language->get('text_redefine');
						$data['text_service'] = $this->language->get('text_service');
						$data['text_thanks'] = $this->language->get('text_thanks');

						// Renderiza o email
						$message = $this->load->view('mail/registro_aprovado', $data);
						
						$receiver = $url_data['email'];
						//$receiver = 'leandro.anjos2@gmail.com';
						//$message = "Teste no envio de email via middleware...";
						send_mail($this->config, $receiver, $subject, $message);
					} else {
						log_message('E-mail ja cadastrado: ' . $url_data['email']);
					}
				}
			}
		}
		return $this->load->view('extension/module/brax_notificacao', $data);
	}
}
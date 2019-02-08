<?php
class ControllerExtensionModuleBraxBotaoDownload extends Controller {
	public function index() {
		$this->load->language('extension/module/brax_botao_download');
	
		$information_code = 0;
		$information_href = "";

		if ($this->config->get('module_brax_botao_download_status') && 
			$this->config->get('module_brax_botao_download_information_code') > 0) {
			$information_code = $this->config->get('module_brax_botao_download_information_code');
			$information_href = "index.php?route=information/information&information_id=" . $information_code;
		}
		
		$data['information_code'] = $information_code;
		$data['information_href'] = $information_href;		

		// Renderiza o botão
		return $this->load->view('extension/module/brax_botao_download', $data);
	}
}
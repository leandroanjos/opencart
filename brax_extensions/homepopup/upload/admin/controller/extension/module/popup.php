<?php

class ControllerExtensionModulePopup extends Controller {

    private $error = array();

    public function install() {
        
    }
    public function uninstall() {
        $this->load->model('setting/setting');
        
        $this->model_setting_setting->deleteSetting('popup');
        
    }
    public function index() {
        $data['route'] = $this->url->link('extension/module/popup', 'user_token=' . $this->session->data['user_token'], 'SSL');
        
        $this->load->language('extension/module/popup');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');
        $this->load->model('setting/store');
        $this->load->model('extension/module/popup');
        $this->load->model('tool/image');
        if (isset($this->request->get['store_id'])) {
            $store_id = $this->request->get['store_id'];
        } else {
            $store_id = 0;
        }
        $this->module_path = 'extension/module';
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            $this->model_setting_setting->editSetting('popup', $this->request->post,$store_id);
            if($this->request->post['popup']['general']['enable']){
                $this->model_extension_module_popup->enableModule('popup',$store_id,'module_popup_status',1);
            } else {
                $this->model_extension_module_popup->disableModule('popup',$store_id,'module_popup_status',0);
            }
            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], 'SSL'));
        }

        $data['heading_title'] = $this->language->get('heading_title');
        $data['heading_title_module'] = $this->language->get('heading_title_module');
        
        
        $data['tab_general'] = $this->language->get('tab_general');
        $data['tab_look'] = $this->language->get('tab_look');
        $data['tab_discount'] = $this->language->get('tab_discount');
        $data['tab_statistics'] = $this->language->get('tab_statistics');
        $data['general_text_discount_text'] = $this->language->get('general_text_discount_text');
        $data['general_text_discount_limit_text'] = $this->language->get('general_text_discount_limit_text');
        $data['general_text_button'] = $this->language->get('general_text_button');
        $data['look_text_expires'] = $this->language->get('look_text_expires');
        $data['general_text_popup_background'] = $this->language->get('general_text_popup_background');
        $data['general_text_title_text'] = $this->language->get('general_text_title_text');
        $data['general_text_border_color'] = $this->language->get('general_text_border_color');
        $data['general_text_discount_info_color'] = $this->language->get('general_text_discount_info_color');
        $data['general_text_discount_limit_color'] = $this->language->get('general_text_discount_limit_color');
        $data['general_text_button_text'] = $this->language->get('general_text_button_text');
        $data['general_text_button_background'] = $this->language->get('general_text_button_background');
        $data['discount_text_type'] = $this->language->get('discount_text_type');
        $data['discount_text_value'] = $this->language->get('discount_text_value');
        $data['discount_text_period'] = $this->language->get('discount_text_period');
        
        
        
        $data['text_edit'] = $this->language->get('text_edit');
            
        $data['text_general_enable']        = $this->language->get('text_general_enable');
        $data['text_discount_info']         = $this->language->get('text_discount_info');
        $data['text_discount_text']         = $this->language->get('text_discount_text');
        $data['general_text_title']        = $this->language->get('general_text_title');
        $data['general_text_banner_background']        = $this->language->get('general_text_banner_background');
        $data['general_text_banner_text']        = $this->language->get('general_text_banner_text');
        $data['general_text_button_background']        = $this->language->get('general_text_button_background');
        $data['general_text_button_text']        = $this->language->get('general_text_button_text');
        $data['tab_look']        = $this->language->get('tab_look');
        $data['tab_discount']        = $this->language->get('tab_discount');
        $data['tab_statistics']        = $this->language->get('tab_statistics');
        $data['tab_statistics_text']        = $this->language->get('tab_statistics_text');
        $data['popup_id']        = $this->language->get('popup_id');
        $data['text_email']        = $this->language->get('text_email');
        $data['text_device']        = $this->language->get('text_device');
        $data['text_ip']        = $this->language->get('text_ip');
        $data['text_date']        = $this->language->get('text_date');
        $data['button_export']        = $this->language->get('button_export');
        $data['text_coupon']        = $this->language->get('text_coupon');
        
        $data['text_discount_info_color']   = $this->language->get('text_discount_info_color');
           
         
        
        $data['text_percentage']            = $this->language->get('text_percentage');
        $data['text_fixed_amount']                 = $this->language->get('text_fixed_amount');
        
        
        
        
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel'); 
        
        $data['text_general_title_tooltip'] =  $this->language->get('text_general_title_tooltip'); 
        $data['text_general_discount_text_tooltip'] = $this->language->get('text_general_discount_text_tooltip');
        $data['text_general_discount_limit_text_tooltip'] = $this->language->get('text_general_discount_limit_text_tooltip');
        $data['text_general_text_button_tooltip'] = $this->language->get('text_general_text_button_tooltip');
        $data['text_look_expires_tooltip'] = $this->language->get('text_look_expires_tooltip');
        $data['text_general_popup_background_tooltip'] = $this->language->get('text_general_popup_background_tooltip');
        $data['text_general_title_text_tooltip'] = $this->language->get('text_general_title_text_tooltip');
        $data['text_general_border_color_tooltip'] = $this->language->get('text_general_border_color_tooltip');
        $data['text_general_discount_info_color_tooltip'] = $this->language->get('text_general_discount_info_color_tooltip');
        $data['text_general_discount_limit_color_tooltip'] = $this->language->get('text_general_discount_limit_color_tooltip');
        $data['text_general_button_text_tooltip'] = $this->language->get('text_general_button_text_tooltip');
        $data['text_general_button_background_tooltip'] = $this->language->get('text_general_button_background_tooltip');
        $data['text_type_tooltip'] = $this->language->get('text_type_tooltip');
        $data['text_discount_value_tooltip'] = $this->language->get('text_discount_value_tooltip');
        $data['text_discount_period_tooltip'] = $this->language->get('text_discount_period_tooltip');
        
        
        $data['text_general_enable_tooltip']= $this->language->get('text_general_enable_tooltip');
        $data['text_general_button_background_tooltip']= $this->language->get('text_general_button_background_tooltip');
        $data['text_general_button_text_tooltip']= $this->language->get('text_general_button_text_tooltip');
        
        $data['user_token'] = $this->session->data['user_token'];
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        
        if (isset($this->request->cookie['rightMenu'])) {
                $data['rightMenu'] = true;
        }
        else {
                $data['rightMenu'] = false;
        }
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'user_token=' . $this->session->data['user_token'], 'SSL'),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'user_token=' . $this->session->data['user_token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title_main'),
            'href' => $this->url->link('extension/module/popup', 'user_token=' . $this->session->data['user_token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['action'] = $this->url->link('extension/module/popup', 'user_token=' . $this->session->data['user_token']. '&store_id=' . $store_id, 'SSL', 'SSL');

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], 'SSL');
        $this->load->model('localisation/language');
        $data['languages'] = $this->model_localisation_language->getLanguages();
        $data['exitpopup'] = array();
        $settings = $this->model_setting_setting->getSetting('popup', $store_id);
        
        if(!empty($settings)){
            $data['popup']=$this->model_setting_setting->getSetting('popup', $store_id);
                        
        } else{
            $data['popup']['popup'] = $this->model_extension_module_popup->getDefaultValues();
            $this->load->model('localisation/language');
            $languages = $this->model_localisation_language->getLanguages();
            foreach($languages as $language){
                $data['popup']['popup']['general']['title'.$language['language_id']] = $this->load->view($this->module_path . '/popup_text');
            }
        }
        
        
        $data['store_id'] = $store_id;
        $this->load->model('setting/store');
        
        if (isset($this->request->post['popup']['general']['enable'])) {
            $data['popup']['popup']['general']['enable'] = $this->request->post['popup']['general']['enable'];
        }
        if (isset($this->request->post['popup']['look']['background_image']) && is_file(DIR_IMAGE . $this->request->post['popup']['look']['background_image'])) {
                $data['thumb'] = $this->model_tool_image->resize($this->request->post['popup']['look']['background_image'], 100, 100);
        } else if(isset ($data['popup']['popup']['look']['background_image']) && $data['popup']['popup']['look']['background_image'] != '') {
                $data['thumb'] = $this->model_tool_image->resize($data['popup']['popup']['look']['background_image'], 100, 100);
        }else{
            $data['thumb'] = $this->model_tool_image->resize('algocovid/default.png', 100, 100);
        }
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('extension/module/popup', $data));
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/popup')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        return !$this->error;
    }
    
    
}


?>
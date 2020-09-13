<?php

class ModelExtensionModulePopUp extends Model {
    
    
    public function getDefaultValues(){
        $default = array();
        $default = array(
            'general'=> array(
                'enable' => 0,
                'display_type' => 0
                
            ),
            'look' => array(
                'background_color' => '#000000',
                'title_text_color' => '#FFFFFF',
            )
        );
        return $default;
        
    }
    public function enableModule($module,$store_id,$key,$status){
       $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($module) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($status) . "'");
    }
    public function disableModule($module,$store_id,$key,$status){
       $this->db->query("Delete From " . DB_PREFIX . "setting where store_id = '" . (int)$store_id . "' and `code` = '" . $this->db->escape($module) . "' and `key` = '" . $this->db->escape($key) . "'");
    }
    public function getPopupData(){
       $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "exit_popup_statistics` order by popup_id desc limit 20");
       return $query->rows;
    }
    public function getAllPopupData(){
       $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "exit_popup_statistics` order by popup_id desc");
       return $query->rows;
    }
}

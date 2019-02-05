<?php
class ModelExtensionModuleBraxRegistroPessoa extends Model {
  public function addRegistro($data, $customer_id) {

    $numero_doc = preg_replace("/[^0-9]/", "", $data['doc']);

    $tipo_pessoa = 'F';
    if (strlen(trim($data['razaosocial'])) > 0 && strlen($numero_doc) > 12) {
      $tipo_pessoa = 'J';
    }

    $query_string = "INSERT INTO " . DB_PREFIX . "brax_registro_pessoa SET "
    . "customer_id = '" . (int)$customer_id . "', "
    . "nome = '" . $this->db->escape((string)$data['nome']) . "', "
    . "razao_social = '" . $this->db->escape((string)$data['razaosocial']) . "', "
    . "doc = '" . $this->db->escape((string)$numero_doc) . "', "
    . "rgie = '" . $this->db->escape((string)$data['rgie']) . "', "
    . "tipo_pessoa = '" . $this->db->escape((string)$tipo_pessoa) . "'";

    $this->db->query($query_string);

		$registro_id = $this->db->getLastId();


		return $registro_id;
	}
}
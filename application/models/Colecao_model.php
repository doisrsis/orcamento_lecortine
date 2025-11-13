<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model de Coleções
 * 
 * Gerencia coleções de tecidos
 * 
 * @author Rafael Dias - doisr.com.br
 * @date 13/11/2024
 */
class Colecao_model extends CI_Model {

    protected $table = 'colecoes';

    /**
     * Buscar todas as coleções
     */
    public function get_all($filtros = []) {
        $this->db->select('colecoes.*, COUNT(tecidos.id) as total_tecidos');
        $this->db->from($this->table);
        $this->db->join('tecidos', 'tecidos.colecao_id = colecoes.id', 'left');
        
        if (isset($filtros['status'])) {
            $this->db->where('colecoes.status', $filtros['status']);
        }
        
        $this->db->group_by('colecoes.id');
        $this->db->order_by('colecoes.nome', 'ASC');
        
        return $this->db->get()->result();
    }

    /**
     * Buscar coleção por ID
     */
    public function get($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    /**
     * Inserir coleção
     */
    public function insert($dados) {
        $dados['slug'] = $this->gerar_slug($dados['nome']);
        $dados['criado_em'] = date('Y-m-d H:i:s');
        
        $this->db->insert($this->table, $dados);
        return $this->db->insert_id();
    }

    /**
     * Atualizar coleção
     */
    public function update($id, $dados) {
        if (isset($dados['nome'])) {
            $dados['slug'] = $this->gerar_slug($dados['nome'], $id);
        }
        $dados['atualizado_em'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $id);
        return $this->db->update($this->table, $dados);
    }

    /**
     * Deletar coleção
     */
    public function delete($id) {
        // Verificar se tem tecidos vinculados
        $this->db->where('colecao_id', $id);
        $count = $this->db->count_all_results('tecidos');
        
        if ($count > 0) {
            return false;
        }
        
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Contar coleções
     */
    public function count($filtros = []) {
        if (isset($filtros['status'])) {
            $this->db->where('status', $filtros['status']);
        }
        
        return $this->db->count_all_results($this->table);
    }

    /**
     * Gerar slug único
     */
    private function gerar_slug($nome, $id = null) {
        $this->load->helper('text');
        $slug = url_title(convert_accented_characters($nome), '-', true);
        
        // Verificar se slug já existe
        $this->db->where('slug', $slug);
        if ($id) {
            $this->db->where('id !=', $id);
        }
        $count = $this->db->count_all_results($this->table);
        
        if ($count > 0) {
            $slug .= '-' . time();
        }
        
        return $slug;
    }
}

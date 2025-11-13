<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model de Categorias
 * 
 * Gerencia operações relacionadas às categorias de produtos
 * 
 * @author Rafael Dias - doisr.com.br
 * @date 13/11/2024
 */
class Categoria_model extends CI_Model {

    protected $table = 'categorias';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Buscar categoria por ID
     */
    public function get($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    /**
     * Buscar categoria por slug
     */
    public function get_by_slug($slug) {
        return $this->db->get_where($this->table, ['slug' => $slug])->row();
    }

    /**
     * Listar todas as categorias
     */
    public function get_all($filters = []) {
        if (isset($filters['status'])) {
            $this->db->where('status', $filters['status']);
        }
        
        $this->db->order_by('ordem', 'ASC');
        $this->db->order_by('nome', 'ASC');
        
        return $this->db->get($this->table)->result();
    }

    /**
     * Listar categorias ativas
     */
    public function get_ativas() {
        return $this->get_all(['status' => 'ativo']);
    }

    /**
     * Inserir nova categoria
     */
    public function insert($data) {
        // Gerar slug se não fornecido
        if (!isset($data['slug']) || empty($data['slug'])) {
            $data['slug'] = $this->gerar_slug($data['nome']);
        }
        
        $data['criado_em'] = date('Y-m-d H:i:s');
        
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Atualizar categoria
     */
    public function update($id, $data) {
        // Atualizar slug se o nome foi alterado
        if (isset($data['nome'])) {
            $data['slug'] = $this->gerar_slug($data['nome'], $id);
        }
        
        $data['atualizado_em'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Deletar categoria
     */
    public function delete($id) {
        // Verificar se há produtos vinculados
        $this->db->where('categoria_id', $id);
        $produtos = $this->db->count_all_results('produtos');
        
        if ($produtos > 0) {
            return false; // Não pode deletar categoria com produtos
        }
        
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Gerar slug único
     */
    private function gerar_slug($nome, $id = null) {
        $slug = url_title(convert_accented_characters($nome), '-', true);
        
        // Verificar se slug já existe
        $this->db->where('slug', $slug);
        if ($id) {
            $this->db->where('id !=', $id);
        }
        $existe = $this->db->count_all_results($this->table);
        
        if ($existe > 0) {
            $slug .= '-' . time();
        }
        
        return $slug;
    }

    /**
     * Reordenar categorias
     */
    public function reordenar($ordem) {
        foreach ($ordem as $posicao => $id) {
            $this->db->where('id', $id);
            $this->db->update($this->table, ['ordem' => $posicao]);
        }
        return true;
    }

    /**
     * Contar categorias
     */
    public function count($filters = []) {
        if (isset($filters['status'])) {
            $this->db->where('status', $filters['status']);
        }
        
        return $this->db->count_all_results($this->table);
    }

    /**
     * Obter categoria com contagem de produtos
     */
    public function get_with_produtos_count($id) {
        $this->db->select('categorias.*, COUNT(produtos.id) as total_produtos');
        $this->db->from($this->table);
        $this->db->join('produtos', 'produtos.categoria_id = categorias.id', 'left');
        $this->db->where('categorias.id', $id);
        $this->db->group_by('categorias.id');
        
        return $this->db->get()->row();
    }
}

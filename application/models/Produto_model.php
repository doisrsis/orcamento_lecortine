<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model de Produtos
 * 
 * Gerencia operações relacionadas aos produtos
 * 
 * @author Rafael Dias - doisr.com.br
 * @date 13/11/2024
 */
class Produto_model extends CI_Model {

    protected $table = 'produtos';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Buscar produto por ID
     */
    public function get($id) {
        $this->db->select('produtos.*, categorias.nome as categoria_nome');
        $this->db->from($this->table);
        $this->db->join('categorias', 'categorias.id = produtos.categoria_id', 'left');
        $this->db->where('produtos.id', $id);
        
        return $this->db->get()->row();
    }

    /**
     * Buscar produto por slug
     */
    public function get_by_slug($slug) {
        $this->db->select('produtos.*, categorias.nome as categoria_nome');
        $this->db->from($this->table);
        $this->db->join('categorias', 'categorias.id = produtos.categoria_id', 'left');
        $this->db->where('produtos.slug', $slug);
        
        return $this->db->get()->row();
    }

    /**
     * Listar todos os produtos
     */
    public function get_all($filters = [], $limit = null, $offset = 0) {
        $this->db->select('produtos.*, categorias.nome as categoria_nome');
        $this->db->from($this->table);
        $this->db->join('categorias', 'categorias.id = produtos.categoria_id', 'left');
        
        if (isset($filters['status'])) {
            $this->db->where('produtos.status', $filters['status']);
        }
        
        if (isset($filters['categoria_id'])) {
            $this->db->where('produtos.categoria_id', $filters['categoria_id']);
        }
        
        if (isset($filters['destaque'])) {
            $this->db->where('produtos.destaque', $filters['destaque']);
        }
        
        if (isset($filters['search'])) {
            $this->db->group_start();
            $this->db->like('produtos.nome', $filters['search']);
            $this->db->or_like('produtos.descricao', $filters['search']);
            $this->db->group_end();
        }
        
        $this->db->order_by('produtos.ordem', 'ASC');
        $this->db->order_by('produtos.nome', 'ASC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get()->result();
    }

    /**
     * Listar produtos ativos
     */
    public function get_ativos($categoria_id = null) {
        $filters = ['status' => 'ativo'];
        
        if ($categoria_id) {
            $filters['categoria_id'] = $categoria_id;
        }
        
        return $this->get_all($filters);
    }

    /**
     * Listar produtos em destaque
     */
    public function get_destaques($limit = 6) {
        return $this->get_all(['status' => 'ativo', 'destaque' => 1], $limit);
    }

    /**
     * Inserir novo produto
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
     * Atualizar produto
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
     * Deletar produto
     */
    public function delete($id) {
        // Verificar se há orçamentos vinculados
        $this->db->where('produto_id', $id);
        $orcamentos = $this->db->count_all_results('orcamento_itens');
        
        if ($orcamentos > 0) {
            return false; // Não pode deletar produto com orçamentos
        }
        
        // Deletar imagens do produto
        $this->db->where('produto_id', $id);
        $this->db->delete('produto_imagens');
        
        // Deletar produto
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
     * Obter imagens do produto
     */
    public function get_imagens($produto_id) {
        $this->db->where('produto_id', $produto_id);
        $this->db->order_by('ordem', 'ASC');
        return $this->db->get('produto_imagens')->result();
    }

    /**
     * Adicionar imagem ao produto
     */
    public function add_imagem($produto_id, $imagem, $legenda = null, $ordem = 0) {
        $data = [
            'produto_id' => $produto_id,
            'imagem' => $imagem,
            'legenda' => $legenda,
            'ordem' => $ordem,
            'criado_em' => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert('produto_imagens', $data);
        return $this->db->insert_id();
    }

    /**
     * Remover imagem do produto
     */
    public function remove_imagem($imagem_id) {
        $this->db->where('id', $imagem_id);
        return $this->db->delete('produto_imagens');
    }

    /**
     * Reordenar produtos
     */
    public function reordenar($ordem) {
        foreach ($ordem as $posicao => $id) {
            $this->db->where('id', $id);
            $this->db->update($this->table, ['ordem' => $posicao]);
        }
        return true;
    }

    /**
     * Contar produtos
     */
    public function count($filters = []) {
        if (isset($filters['status'])) {
            $this->db->where('status', $filters['status']);
        }
        
        if (isset($filters['categoria_id'])) {
            $this->db->where('categoria_id', $filters['categoria_id']);
        }
        
        if (isset($filters['search'])) {
            $this->db->group_start();
            $this->db->like('nome', $filters['search']);
            $this->db->or_like('descricao', $filters['search']);
            $this->db->group_end();
        }
        
        return $this->db->count_all_results($this->table);
    }

    /**
     * Obter produtos mais solicitados
     */
    public function get_mais_solicitados($limit = 10) {
        $this->db->select('produtos.*, COUNT(orcamento_itens.id) as total_solicitacoes');
        $this->db->from($this->table);
        $this->db->join('orcamento_itens', 'orcamento_itens.produto_id = produtos.id', 'left');
        $this->db->group_by('produtos.id');
        $this->db->order_by('total_solicitacoes', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model de Clientes
 * 
 * Gerencia operações relacionadas aos clientes
 * 
 * @author Rafael Dias - doisr.com.br
 * @date 13/11/2024
 */
class Cliente_model extends CI_Model {

    protected $table = 'clientes';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Buscar cliente por ID
     */
    public function get($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    /**
     * Buscar cliente por email
     */
    public function get_by_email($email) {
        return $this->db->get_where($this->table, ['email' => $email])->row();
    }

    /**
     * Buscar cliente por WhatsApp
     */
    public function get_by_whatsapp($whatsapp) {
        return $this->db->get_where($this->table, ['whatsapp' => $whatsapp])->row();
    }

    /**
     * Listar todos os clientes
     */
    public function get_all($filters = [], $limit = null, $offset = 0) {
        if (isset($filters['search'])) {
            $this->db->group_start();
            $this->db->like('nome', $filters['search']);
            $this->db->or_like('email', $filters['search']);
            $this->db->or_like('telefone', $filters['search']);
            $this->db->or_like('whatsapp', $filters['search']);
            $this->db->group_end();
        }
        
        if (isset($filters['origem'])) {
            $this->db->where('origem', $filters['origem']);
        }
        
        $this->db->order_by('criado_em', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get($this->table)->result();
    }

    /**
     * Inserir novo cliente
     */
    public function insert($data) {
        $data['criado_em'] = date('Y-m-d H:i:s');
        
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Atualizar cliente
     */
    public function update($id, $data) {
        $data['atualizado_em'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Deletar cliente
     */
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Buscar ou criar cliente
     */
    public function find_or_create($data) {
        // Verificar se já existe por email
        if (isset($data['email'])) {
            $cliente = $this->get_by_email($data['email']);
            if ($cliente) {
                return $cliente->id;
            }
        }
        
        // Verificar se já existe por WhatsApp
        if (isset($data['whatsapp'])) {
            $cliente = $this->get_by_whatsapp($data['whatsapp']);
            if ($cliente) {
                return $cliente->id;
            }
        }
        
        // Criar novo cliente
        return $this->insert($data);
    }

    /**
     * Contar clientes
     */
    public function count($filters = []) {
        if (isset($filters['search'])) {
            $this->db->group_start();
            $this->db->like('nome', $filters['search']);
            $this->db->or_like('email', $filters['search']);
            $this->db->or_like('telefone', $filters['search']);
            $this->db->or_like('whatsapp', $filters['search']);
            $this->db->group_end();
        }
        
        if (isset($filters['origem'])) {
            $this->db->where('origem', $filters['origem']);
        }
        
        return $this->db->count_all_results($this->table);
    }

    /**
     * Obter estatísticas de clientes
     */
    public function get_stats() {
        $stats = [];
        
        // Total de clientes
        $stats['total'] = $this->db->count_all($this->table);
        
        // Clientes por origem
        $this->db->select('origem, COUNT(*) as total');
        $this->db->group_by('origem');
        $stats['por_origem'] = $this->db->get($this->table)->result();
        
        // Novos clientes este mês
        $this->db->where('MONTH(criado_em)', date('m'));
        $this->db->where('YEAR(criado_em)', date('Y'));
        $stats['novos_mes'] = $this->db->count_all_results($this->table);
        
        return $stats;
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Dashboard Administrativo
 * 
 * Painel principal com estatísticas e informações
 * 
 * @author Rafael Dias - doisr.com.br
 * @date 13/11/2024
 */
class Dashboard extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Orcamento_model');
        $this->load->model('Cliente_model');
        $this->load->model('Produto_model');
        $this->load->model('Categoria_model');
    }

    /**
     * Página principal do dashboard
     */
    public function index() {
        $data['titulo'] = 'Dashboard - Le Cortine';
        $data['menu_ativo'] = 'dashboard';
        
        // Estatísticas gerais
        $data['stats'] = $this->get_estatisticas();
        
        // Orçamentos recentes
        $data['orcamentos_recentes'] = $this->Orcamento_model->get_all([], 10);
        
        // Produtos mais solicitados
        $data['produtos_populares'] = $this->Produto_model->get_mais_solicitados(5);
        
        // Gráfico de orçamentos por mês
        $data['grafico_orcamentos'] = $this->get_grafico_orcamentos();
        
        // Carregar views
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/dashboard/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Obter estatísticas gerais
     */
    private function get_estatisticas() {
        $stats = [];
        
        // Orçamentos
        $stats['orcamentos_total'] = $this->Orcamento_model->count();
        $stats['orcamentos_hoje'] = $this->Orcamento_model->count([
            'data_inicio' => date('Y-m-d'),
            'data_fim' => date('Y-m-d')
        ]);
        $stats['orcamentos_mes'] = $this->Orcamento_model->count([
            'data_inicio' => date('Y-m-01'),
            'data_fim' => date('Y-m-t')
        ]);
        $stats['orcamentos_pendentes'] = $this->Orcamento_model->count(['status' => 'pendente']);
        
        // Clientes
        $stats['clientes_total'] = $this->Cliente_model->count();
        $stats['clientes_mes'] = $this->Cliente_model->count();
        
        // Produtos
        $stats['produtos_total'] = $this->Produto_model->count(['status' => 'ativo']);
        $stats['categorias_total'] = $this->Categoria_model->count(['status' => 'ativo']);
        
        // Valor total de orçamentos
        $this->db->select_sum('valor_final');
        $this->db->where('MONTH(criado_em)', date('m'));
        $this->db->where('YEAR(criado_em)', date('Y'));
        $valor_mes = $this->db->get('orcamentos')->row();
        $stats['valor_mes'] = $valor_mes->valor_final ?? 0;
        
        // Taxa de conversão (exemplo simplificado)
        $stats['taxa_conversao'] = $stats['orcamentos_total'] > 0 
            ? round(($stats['orcamentos_mes'] / $stats['orcamentos_total']) * 100, 2) 
            : 0;
        
        return $stats;
    }

    /**
     * Obter dados para gráfico de orçamentos
     */
    private function get_grafico_orcamentos() {
        $dados = [];
        
        // Últimos 12 meses
        for ($i = 11; $i >= 0; $i--) {
            $mes = date('Y-m', strtotime("-{$i} months"));
            
            $this->db->where("DATE_FORMAT(criado_em, '%Y-%m') =", $mes);
            $total = $this->db->count_all_results('orcamentos');
            
            $dados[] = [
                'mes' => date('M/y', strtotime($mes . '-01')),
                'total' => $total
            ];
        }
        
        return $dados;
    }

    /**
     * API: Obter estatísticas em tempo real
     */
    public function api_stats() {
        $stats = $this->get_estatisticas();
        $this->json_success('Estatísticas obtidas', $stats);
    }

    /**
     * API: Obter gráfico de orçamentos
     */
    public function api_grafico() {
        $tipo = $this->input->get('tipo') ?? 'mes';
        $grafico = $this->get_grafico_orcamentos();
        $this->json_success('Gráfico obtido', $grafico);
    }
}

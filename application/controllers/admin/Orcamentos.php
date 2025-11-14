<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller: Admin/Orcamentos
 * Gerenciamento de orçamentos no painel administrativo
 * 
 * @author Rafael Dias - doisr.com.br
 * @date 14/11/2024
 */
class Orcamentos extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Orcamento_model');
        $this->load->model('Cliente_model');
        $this->load->model('Produto_model');
        $this->load->model('Tecido_model');
        $this->load->library('pagination');
    }

    /**
     * Listagem de orçamentos
     */
    public function index() {
        $data['titulo'] = 'Orçamentos';
        $data['menu_ativo'] = 'orcamentos';
        
        // Configuração de paginação
        $config['base_url'] = base_url('admin/orcamentos/index');
        $config['total_rows'] = $this->Orcamento_model->count_all();
        $config['per_page'] = 20;
        $config['uri_segment'] = 4;
        
        // Estilo da paginação
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'Primeira';
        $config['last_link'] = 'Última';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = ['class' => 'page-link'];
        
        $this->pagination->initialize($config);
        
        // Filtros
        $filtros = [];
        
        if ($this->input->get('status')) {
            $filtros['status'] = $this->input->get('status');
        }
        
        if ($this->input->get('busca')) {
            $filtros['busca'] = $this->input->get('busca');
        }
        
        if ($this->input->get('data_inicio')) {
            $filtros['data_inicio'] = $this->input->get('data_inicio');
        }
        
        if ($this->input->get('data_fim')) {
            $filtros['data_fim'] = $this->input->get('data_fim');
        }
        
        // Buscar orçamentos
        $data['orcamentos'] = $this->Orcamento_model->get_all_with_cliente($config['per_page'], $this->uri->segment(4), $filtros);
        $data['pagination'] = $this->pagination->create_links();
        $data['filtros'] = $filtros;
        
        // Estatísticas
        $data['total'] = $this->Orcamento_model->count_all();
        $data['pendentes'] = $this->Orcamento_model->count_by_status('pendente');
        $data['aprovados'] = $this->Orcamento_model->count_by_status('aprovado');
        $data['valor_total'] = $this->Orcamento_model->sum_valor_total();
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/orcamentos/index', $data);
        $this->load->view('admin/layout/footer');
    }

    /**
     * Visualizar orçamento detalhado
     */
    public function visualizar($id) {
        $orcamento = $this->Orcamento_model->get($id);
        
        if (!$orcamento) {
            $this->session->set_flashdata('erro', 'Orçamento não encontrado.');
            redirect('admin/orcamentos');
        }
        
        $data['titulo'] = 'Orçamento #' . $orcamento->numero;
        $data['menu_ativo'] = 'orcamentos';
        $data['orcamento'] = $orcamento;
        $data['cliente'] = $this->Cliente_model->get($orcamento->cliente_id);
        $data['itens'] = $this->Orcamento_model->get_itens($id);
        
        // Buscar detalhes dos itens
        foreach ($data['itens'] as &$item) {
            $item->produto = $this->Produto_model->get($item->produto_id);
            if ($item->tecido_id) {
                $item->tecido = $this->Tecido_model->get($item->tecido_id);
            }
            if ($item->cor_id) {
                $item->cor = $this->Tecido_model->get_cor($item->cor_id);
            }
            $item->extras = $this->Orcamento_model->get_item_extras($item->id);
        }
        
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/orcamentos/visualizar', $data);
        $this->load->view('admin/layout/footer');
    }

    /**
     * Alterar status do orçamento
     */
    public function alterar_status($id) {
        if ($this->input->method() !== 'post') {
            redirect('admin/orcamentos');
        }
        
        $status = $this->input->post('status');
        $observacoes = $this->input->post('observacoes_internas');
        
        $dados = ['status' => $status];
        
        if ($observacoes) {
            $dados['observacoes_internas'] = $observacoes;
        }
        
        if ($this->Orcamento_model->update($id, $dados)) {
            $this->session->set_flashdata('sucesso', 'Status alterado com sucesso!');
        } else {
            $this->session->set_flashdata('erro', 'Erro ao alterar status.');
        }
        
        redirect('admin/orcamentos/visualizar/' . $id);
    }

    /**
     * Excluir orçamento
     */
    public function excluir($id) {
        $orcamento = $this->Orcamento_model->get($id);
        
        if (!$orcamento) {
            $this->session->set_flashdata('erro', 'Orçamento não encontrado.');
            redirect('admin/orcamentos');
        }
        
        if ($this->Orcamento_model->delete($id)) {
            $this->session->set_flashdata('sucesso', 'Orçamento excluído com sucesso!');
        } else {
            $this->session->set_flashdata('erro', 'Erro ao excluir orçamento.');
        }
        
        redirect('admin/orcamentos');
    }

    /**
     * Enviar orçamento por WhatsApp
     */
    public function enviar_whatsapp($id) {
        $orcamento = $this->Orcamento_model->get($id);
        
        if (!$orcamento) {
            $this->session->set_flashdata('erro', 'Orçamento não encontrado.');
            redirect('admin/orcamentos');
        }
        
        $cliente = $this->Cliente_model->get($orcamento->cliente_id);
        $itens = $this->Orcamento_model->get_itens($id);
        
        // Montar mensagem
        $mensagem = "🎯 *ORÇAMENTO #{$orcamento->numero}*\n\n";
        $mensagem .= "👤 *Cliente:* {$cliente->nome}\n";
        $mensagem .= "📧 *Email:* {$cliente->email}\n";
        $mensagem .= "📱 *WhatsApp:* {$cliente->whatsapp}\n\n";
        
        $mensagem .= "📦 *PRODUTOS:*\n";
        foreach ($itens as $item) {
            $produto = $this->Produto_model->get($item->produto_id);
            $mensagem .= "• {$produto->nome}\n";
            
            if ($item->tecido_id) {
                $tecido = $this->Tecido_model->get($item->tecido_id);
                $mensagem .= "  Tecido: {$tecido->nome}\n";
            }
            
            if ($item->cor_id) {
                $cor = $this->Tecido_model->get_cor($item->cor_id);
                $mensagem .= "  Cor: {$cor->nome}\n";
            }
            
            $mensagem .= "  Dimensões: {$item->largura}m x {$item->altura}m\n";
            $mensagem .= "  Valor: R$ " . number_format($item->valor_unitario, 2, ',', '.') . "\n\n";
        }
        
        $mensagem .= "💰 *VALOR TOTAL:* R$ " . number_format($orcamento->valor_final, 2, ',', '.') . "\n\n";
        $mensagem .= "📍 *Endereço:*\n{$cliente->endereco}\n{$cliente->cidade} - {$cliente->estado}\nCEP: {$cliente->cep}\n\n";
        $mensagem .= "---\n";
        $mensagem .= "Le Cortine - Cortinas Sob Medida\n";
        $mensagem .= "www.lecortine.com.br";
        
        // Atualizar registro
        $this->Orcamento_model->update($id, [
            'enviado_whatsapp' => 1,
            'data_envio_whatsapp' => date('Y-m-d H:i:s')
        ]);
        
        // Redirecionar para WhatsApp
        $whatsapp_url = "https://api.whatsapp.com/send?phone=" . preg_replace('/[^0-9]/', '', $cliente->whatsapp) . "&text=" . urlencode($mensagem);
        redirect($whatsapp_url);
    }

    /**
     * Imprimir orçamento
     */
    public function imprimir($id) {
        $orcamento = $this->Orcamento_model->get($id);
        
        if (!$orcamento) {
            show_404();
        }
        
        $data['orcamento'] = $orcamento;
        $data['cliente'] = $this->Cliente_model->get($orcamento->cliente_id);
        $data['itens'] = $this->Orcamento_model->get_itens($id);
        
        // Buscar detalhes dos itens
        foreach ($data['itens'] as &$item) {
            $item->produto = $this->Produto_model->get($item->produto_id);
            if ($item->tecido_id) {
                $item->tecido = $this->Tecido_model->get($item->tecido_id);
            }
            if ($item->cor_id) {
                $item->cor = $this->Tecido_model->get_cor($item->cor_id);
            }
            $item->extras = $this->Orcamento_model->get_item_extras($item->id);
        }
        
        $this->load->view('admin/orcamentos/imprimir', $data);
    }
}

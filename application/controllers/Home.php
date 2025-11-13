<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Home
 * 
 * Página inicial pública do sistema
 * 
 * @author Rafael Dias - doisr.com.br
 * @date 13/11/2024
 */
class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Produto_model');
        $this->load->model('Categoria_model');
    }

    /**
     * Página inicial
     */
    public function index() {
        $data['titulo'] = 'Le Cortine - Orçamento Online de Cortinas e Toldos';
        $data['descricao'] = 'Faça seu orçamento online de cortinas, persianas e toldos de forma rápida e fácil. Produtos de qualidade com os melhores preços.';
        
        // Buscar produtos em destaque
        $data['produtos_destaque'] = $this->Produto_model->get_destaques(6);
        
        // Buscar categorias ativas
        $data['categorias'] = $this->Categoria_model->get_ativas();
        
        // Carregar views
        $this->load->view('public/header', $data);
        $this->load->view('public/home', $data);
        $this->load->view('public/footer');
    }

    /**
     * Sobre nós
     */
    public function sobre() {
        $data['titulo'] = 'Sobre Nós - Le Cortine';
        $data['descricao'] = 'Conheça a Le Cortine, especialista em cortinas, persianas e toldos sob medida.';
        
        $this->load->view('public/header', $data);
        $this->load->view('public/sobre', $data);
        $this->load->view('public/footer');
    }

    /**
     * Contato
     */
    public function contato() {
        $data['titulo'] = 'Contato - Le Cortine';
        $data['descricao'] = 'Entre em contato conosco. Estamos prontos para atendê-lo.';
        
        // Processar formulário de contato
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nome', 'Nome', 'required');
            $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');
            $this->form_validation->set_rules('mensagem', 'Mensagem', 'required');

            if ($this->form_validation->run()) {
                // Enviar e-mail de contato
                $this->enviar_email_contato();
                
                $this->session->set_flashdata('sucesso', 'Mensagem enviada com sucesso! Entraremos em contato em breve.');
                redirect('contato');
            }
        }
        
        $this->load->view('public/header', $data);
        $this->load->view('public/contato', $data);
        $this->load->view('public/footer');
    }

    /**
     * Produtos
     */
    public function produtos($categoria_slug = null) {
        $data['titulo'] = 'Produtos - Le Cortine';
        $data['descricao'] = 'Conheça nossa linha completa de produtos.';
        
        // Buscar categorias
        $data['categorias'] = $this->Categoria_model->get_ativas();
        
        // Filtrar por categoria se fornecida
        if ($categoria_slug) {
            $categoria = $this->Categoria_model->get_by_slug($categoria_slug);
            
            if (!$categoria) {
                show_404();
            }
            
            $data['categoria_atual'] = $categoria;
            $data['produtos'] = $this->Produto_model->get_ativos($categoria->id);
            $data['titulo'] = $categoria->nome . ' - Le Cortine';
        } else {
            $data['produtos'] = $this->Produto_model->get_ativos();
        }
        
        $this->load->view('public/header', $data);
        $this->load->view('public/produtos', $data);
        $this->load->view('public/footer');
    }

    /**
     * Detalhes do produto
     */
    public function produto($slug) {
        $produto = $this->Produto_model->get_by_slug($slug);
        
        if (!$produto) {
            show_404();
        }
        
        $data['titulo'] = $produto->nome . ' - Le Cortine';
        $data['descricao'] = $produto->descricao_curta ?? strip_tags(substr($produto->descricao, 0, 160));
        $data['produto'] = $produto;
        $data['imagens'] = $this->Produto_model->get_imagens($produto->id);
        
        $this->load->view('public/header', $data);
        $this->load->view('public/produto_detalhes', $data);
        $this->load->view('public/footer');
    }

    /**
     * Enviar e-mail de contato
     */
    private function enviar_email_contato() {
        $this->load->library('email');

        $nome = $this->input->post('nome');
        $email = $this->input->post('email');
        $telefone = $this->input->post('telefone');
        $mensagem = $this->input->post('mensagem');

        $corpo = "
            <h2>Nova Mensagem de Contato</h2>
            <p><strong>Nome:</strong> {$nome}</p>
            <p><strong>E-mail:</strong> {$email}</p>
            <p><strong>Telefone:</strong> {$telefone}</p>
            <p><strong>Mensagem:</strong></p>
            <p>{$mensagem}</p>
        ";

        $this->email->from($email, $nome);
        $this->email->to('contato@lecortine.com.br');
        $this->email->subject('Nova Mensagem de Contato - Le Cortine');
        $this->email->message($corpo);

        return $this->email->send();
    }
}

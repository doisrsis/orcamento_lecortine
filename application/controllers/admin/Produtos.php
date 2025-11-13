<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller de Produtos
 * 
 * CRUD completo de produtos com galeria de imagens
 * 
 * @author Rafael Dias - doisr.com.br
 * @date 13/11/2024
 */
class Produtos extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Produto_model');
        $this->load->model('Categoria_model');
    }

    /**
     * Listar produtos
     */
    public function index() {
        $data['titulo'] = 'Produtos - Le Cortine';
        $data['menu_ativo'] = 'produtos';
        
        // Filtros
        $filtros = [];
        if ($this->input->get('categoria')) {
            $filtros['categoria_id'] = $this->input->get('categoria');
        }
        if ($this->input->get('status')) {
            $filtros['status'] = $this->input->get('status');
        }
        if ($this->input->get('busca')) {
            $filtros['busca'] = $this->input->get('busca');
        }
        
        // Buscar produtos
        $data['produtos'] = $this->Produto_model->get_all($filtros);
        $data['categorias'] = $this->Categoria_model->get_all(['status' => 'ativo']);
        
        // Carregar views
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/produtos/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Criar produto
     */
    public function criar() {
        $data['titulo'] = 'Novo Produto - Le Cortine';
        $data['menu_ativo'] = 'produtos';
        $data['categorias'] = $this->Categoria_model->get_all(['status' => 'ativo']);
        
        // Processar formulário
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nome', 'Nome', 'required|max_length[200]');
            $this->form_validation->set_rules('categoria_id', 'Categoria', 'required|integer');
            $this->form_validation->set_rules('descricao_curta', 'Descrição Curta', 'max_length[500]');
            $this->form_validation->set_rules('descricao_completa', 'Descrição Completa', 'max_length[5000]');
            $this->form_validation->set_rules('preco_base', 'Preço Base', 'numeric');
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[ativo,inativo]');
            $this->form_validation->set_rules('destaque', 'Destaque', 'in_list[0,1]');

            if ($this->form_validation->run()) {
                $dados = [
                    'nome' => $this->input->post('nome'),
                    'categoria_id' => $this->input->post('categoria_id'),
                    'descricao_curta' => $this->input->post('descricao_curta'),
                    'descricao_completa' => $this->input->post('descricao_completa'),
                    'caracteristicas' => $this->input->post('caracteristicas'),
                    'preco_base' => $this->input->post('preco_base') ?: null,
                    'status' => $this->input->post('status'),
                    'destaque' => $this->input->post('destaque') ? 1 : 0,
                    'ordem' => $this->input->post('ordem') ?? 0,
                    'meta_title' => $this->input->post('meta_title'),
                    'meta_description' => $this->input->post('meta_description'),
                    'meta_keywords' => $this->input->post('meta_keywords')
                ];

                // Upload de imagem principal
                if (!empty($_FILES['imagem_principal']['name'])) {
                    $imagem = $this->upload_arquivo('imagem_principal', 'produtos');
                    if ($imagem) {
                        $dados['imagem_principal'] = $imagem;
                    }
                }

                $id = $this->Produto_model->insert($dados);

                if ($id) {
                    // Upload de galeria
                    $this->processar_galeria($id);
                    
                    $this->registrar_log('criar', 'produtos', $id, null, $dados);
                    $this->session->set_flashdata('sucesso', 'Produto criado com sucesso!');
                    redirect('admin/produtos/editar/' . $id);
                } else {
                    $this->session->set_flashdata('erro', 'Erro ao criar produto.');
                }
            }
        }
        
        // Carregar views
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/produtos/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Editar produto
     */
    public function editar($id) {
        $produto = $this->Produto_model->get($id);
        
        if (!$produto) {
            show_404();
        }
        
        $data['titulo'] = 'Editar Produto - Le Cortine';
        $data['menu_ativo'] = 'produtos';
        $data['produto'] = $produto;
        $data['categorias'] = $this->Categoria_model->get_all(['status' => 'ativo']);
        $data['imagens'] = $this->Produto_model->get_imagens($id);
        
        // Processar formulário
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nome', 'Nome', 'required|max_length[200]');
            $this->form_validation->set_rules('categoria_id', 'Categoria', 'required|integer');
            $this->form_validation->set_rules('descricao_curta', 'Descrição Curta', 'max_length[500]');
            $this->form_validation->set_rules('descricao_completa', 'Descrição Completa', 'max_length[5000]');
            $this->form_validation->set_rules('preco_base', 'Preço Base', 'numeric');
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[ativo,inativo]');
            $this->form_validation->set_rules('destaque', 'Destaque', 'in_list[0,1]');

            if ($this->form_validation->run()) {
                $dados = [
                    'nome' => $this->input->post('nome'),
                    'categoria_id' => $this->input->post('categoria_id'),
                    'descricao_curta' => $this->input->post('descricao_curta'),
                    'descricao_completa' => $this->input->post('descricao_completa'),
                    'caracteristicas' => $this->input->post('caracteristicas'),
                    'preco_base' => $this->input->post('preco_base') ?: null,
                    'status' => $this->input->post('status'),
                    'destaque' => $this->input->post('destaque') ? 1 : 0,
                    'ordem' => $this->input->post('ordem') ?? 0,
                    'meta_title' => $this->input->post('meta_title'),
                    'meta_description' => $this->input->post('meta_description'),
                    'meta_keywords' => $this->input->post('meta_keywords')
                ];

                // Upload de imagem principal
                if (!empty($_FILES['imagem_principal']['name'])) {
                    $imagem = $this->upload_arquivo('imagem_principal', 'produtos');
                    if ($imagem) {
                        // Deletar imagem antiga
                        if ($produto->imagem_principal) {
                            $this->deletar_arquivo('./uploads/produtos/' . $produto->imagem_principal);
                        }
                        $dados['imagem_principal'] = $imagem;
                    }
                }

                if ($this->Produto_model->update($id, $dados)) {
                    // Upload de galeria
                    $this->processar_galeria($id);
                    
                    $this->registrar_log('editar', 'produtos', $id, $produto, $dados);
                    $this->session->set_flashdata('sucesso', 'Produto atualizado com sucesso!');
                    redirect('admin/produtos/editar/' . $id);
                } else {
                    $this->session->set_flashdata('erro', 'Erro ao atualizar produto.');
                }
            }
        }
        
        // Carregar views
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/produtos/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Deletar produto
     */
    public function deletar($id) {
        $produto = $this->Produto_model->get($id);
        
        if (!$produto) {
            show_404();
        }

        // Buscar imagens da galeria
        $imagens = $this->Produto_model->get_imagens($id);

        // Deletar produto
        if ($this->Produto_model->delete($id)) {
            // Deletar imagem principal
            if ($produto->imagem_principal) {
                $this->deletar_arquivo('./uploads/produtos/' . $produto->imagem_principal);
            }
            
            // Deletar imagens da galeria
            foreach ($imagens as $imagem) {
                $this->deletar_arquivo('./uploads/produtos/' . $imagem->imagem);
            }

            $this->registrar_log('deletar', 'produtos', $id, $produto);
            $this->session->set_flashdata('sucesso', 'Produto deletado com sucesso!');
        } else {
            $this->session->set_flashdata('erro', 'Erro ao deletar produto.');
        }

        redirect('admin/produtos');
    }

    /**
     * Deletar imagem da galeria (AJAX)
     */
    public function deletar_imagem($id) {
        $imagem = $this->Produto_model->get_imagem($id);
        
        if (!$imagem) {
            $this->json_error('Imagem não encontrada', null, 404);
        }

        if ($this->Produto_model->delete_imagem($id)) {
            $this->deletar_arquivo('./uploads/produtos/' . $imagem->imagem);
            $this->json_success('Imagem deletada com sucesso!');
        } else {
            $this->json_error('Erro ao deletar imagem');
        }
    }

    /**
     * Reordenar imagens da galeria (AJAX)
     */
    public function reordenar_imagens() {
        if ($this->input->method() !== 'post') {
            $this->json_error('Método não permitido', null, 405);
        }

        $ordem = $this->input->post('ordem');

        if (!$ordem || !is_array($ordem)) {
            $this->json_error('Dados inválidos');
        }

        if ($this->Produto_model->reordenar_imagens($ordem)) {
            $this->json_success('Ordem atualizada com sucesso!');
        } else {
            $this->json_error('Erro ao atualizar ordem');
        }
    }

    /**
     * Toggle status (AJAX)
     */
    public function toggle_status($id) {
        $produto = $this->Produto_model->get($id);
        
        if (!$produto) {
            $this->json_error('Produto não encontrado', null, 404);
        }

        $novo_status = $produto->status === 'ativo' ? 'inativo' : 'ativo';
        
        if ($this->Produto_model->update($id, ['status' => $novo_status])) {
            $this->registrar_log('toggle_status', 'produtos', $id);
            $this->json_success('Status alterado com sucesso!', ['status' => $novo_status]);
        } else {
            $this->json_error('Erro ao alterar status');
        }
    }

    /**
     * Toggle destaque (AJAX)
     */
    public function toggle_destaque($id) {
        $produto = $this->Produto_model->get($id);
        
        if (!$produto) {
            $this->json_error('Produto não encontrado', null, 404);
        }

        $novo_destaque = $produto->destaque ? 0 : 1;
        
        if ($this->Produto_model->update($id, ['destaque' => $novo_destaque])) {
            $this->json_success('Destaque alterado com sucesso!', ['destaque' => $novo_destaque]);
        } else {
            $this->json_error('Erro ao alterar destaque');
        }
    }

    /**
     * Processar upload de galeria
     */
    private function processar_galeria($produto_id) {
        if (empty($_FILES['galeria']['name'][0])) {
            return;
        }

        $total = count($_FILES['galeria']['name']);
        
        for ($i = 0; $i < $total; $i++) {
            $_FILES['file']['name'] = $_FILES['galeria']['name'][$i];
            $_FILES['file']['type'] = $_FILES['galeria']['type'][$i];
            $_FILES['file']['tmp_name'] = $_FILES['galeria']['tmp_name'][$i];
            $_FILES['file']['error'] = $_FILES['galeria']['error'][$i];
            $_FILES['file']['size'] = $_FILES['galeria']['size'][$i];

            $imagem = $this->upload_arquivo('file', 'produtos');
            
            if ($imagem) {
                $this->Produto_model->add_imagem($produto_id, $imagem);
            }
        }
    }
}

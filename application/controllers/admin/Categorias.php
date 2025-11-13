<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller de Categorias
 * 
 * CRUD completo de categorias de produtos
 * 
 * @author Rafael Dias - doisr.com.br
 * @date 13/11/2024
 */
class Categorias extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Categoria_model');
    }

    /**
     * Listar categorias
     */
    public function index() {
        $data['titulo'] = 'Categorias - Le Cortine';
        $data['menu_ativo'] = 'categorias';
        
        // Buscar categorias
        $data['categorias'] = $this->Categoria_model->get_all();
        
        // Carregar views
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/categorias/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Criar categoria
     */
    public function criar() {
        $data['titulo'] = 'Nova Categoria - Le Cortine';
        $data['menu_ativo'] = 'categorias';
        
        // Processar formulário
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nome', 'Nome', 'required|max_length[100]');
            $this->form_validation->set_rules('descricao', 'Descrição', 'max_length[500]');
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[ativo,inativo]');
            $this->form_validation->set_rules('ordem', 'Ordem', 'integer');

            if ($this->form_validation->run()) {
                $dados = [
                    'nome' => $this->input->post('nome'),
                    'descricao' => $this->input->post('descricao'),
                    'status' => $this->input->post('status'),
                    'ordem' => $this->input->post('ordem') ?? 0
                ];

                // Upload de ícone
                if (!empty($_FILES['icone']['name'])) {
                    $icone = $this->upload_arquivo('icone', 'categorias', 'jpg|jpeg|png|gif|svg|webp');
                    if ($icone) {
                        $dados['icone'] = $icone;
                    }
                }

                // Upload de imagem
                if (!empty($_FILES['imagem']['name'])) {
                    $imagem = $this->upload_arquivo('imagem', 'categorias');
                    if ($imagem) {
                        $dados['imagem'] = $imagem;
                    }
                }

                $id = $this->Categoria_model->insert($dados);

                if ($id) {
                    $this->registrar_log('criar', 'categorias', $id, null, $dados);
                    $this->session->set_flashdata('sucesso', 'Categoria criada com sucesso!');
                    redirect('admin/categorias');
                } else {
                    $this->session->set_flashdata('erro', 'Erro ao criar categoria.');
                }
            }
        }
        
        // Carregar views
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/categorias/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Editar categoria
     */
    public function editar($id) {
        $categoria = $this->Categoria_model->get($id);
        
        if (!$categoria) {
            show_404();
        }
        
        $data['titulo'] = 'Editar Categoria - Le Cortine';
        $data['menu_ativo'] = 'categorias';
        $data['categoria'] = $categoria;
        
        // Processar formulário
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nome', 'Nome', 'required|max_length[100]');
            $this->form_validation->set_rules('descricao', 'Descrição', 'max_length[500]');
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[ativo,inativo]');
            $this->form_validation->set_rules('ordem', 'Ordem', 'integer');

            if ($this->form_validation->run()) {
                $dados = [
                    'nome' => $this->input->post('nome'),
                    'descricao' => $this->input->post('descricao'),
                    'status' => $this->input->post('status'),
                    'ordem' => $this->input->post('ordem') ?? 0
                ];

                // Upload de ícone
                if (!empty($_FILES['icone']['name'])) {
                    $icone = $this->upload_arquivo('icone', 'categorias', 'jpg|jpeg|png|gif|svg|webp');
                    if ($icone) {
                        // Deletar ícone antigo
                        if ($categoria->icone) {
                            $this->deletar_arquivo('./uploads/categorias/' . $categoria->icone);
                        }
                        $dados['icone'] = $icone;
                    }
                }

                // Upload de imagem
                if (!empty($_FILES['imagem']['name'])) {
                    $imagem = $this->upload_arquivo('imagem', 'categorias');
                    if ($imagem) {
                        // Deletar imagem antiga
                        if ($categoria->imagem) {
                            $this->deletar_arquivo('./uploads/categorias/' . $categoria->imagem);
                        }
                        $dados['imagem'] = $imagem;
                    }
                }

                if ($this->Categoria_model->update($id, $dados)) {
                    $this->registrar_log('editar', 'categorias', $id, $categoria, $dados);
                    $this->session->set_flashdata('sucesso', 'Categoria atualizada com sucesso!');
                    redirect('admin/categorias');
                } else {
                    $this->session->set_flashdata('erro', 'Erro ao atualizar categoria.');
                }
            }
        }
        
        // Carregar views
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/categorias/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Deletar categoria
     */
    public function deletar($id) {
        $categoria = $this->Categoria_model->get($id);
        
        if (!$categoria) {
            show_404();
        }

        // Verificar se pode deletar
        $result = $this->Categoria_model->delete($id);

        if ($result) {
            // Deletar arquivos
            if ($categoria->icone) {
                $this->deletar_arquivo('./uploads/categorias/' . $categoria->icone);
            }
            if ($categoria->imagem) {
                $this->deletar_arquivo('./uploads/categorias/' . $categoria->imagem);
            }

            $this->registrar_log('deletar', 'categorias', $id, $categoria);
            $this->session->set_flashdata('sucesso', 'Categoria deletada com sucesso!');
        } else {
            $this->session->set_flashdata('erro', 'Não é possível deletar esta categoria pois existem produtos vinculados.');
        }

        redirect('admin/categorias');
    }

    /**
     * Reordenar categorias (AJAX)
     */
    public function reordenar() {
        if ($this->input->method() !== 'post') {
            $this->json_error('Método não permitido', null, 405);
        }

        $ordem = $this->input->post('ordem');

        if (!$ordem || !is_array($ordem)) {
            $this->json_error('Dados inválidos');
        }

        if ($this->Categoria_model->reordenar($ordem)) {
            $this->json_success('Ordem atualizada com sucesso!');
        } else {
            $this->json_error('Erro ao atualizar ordem');
        }
    }

    /**
     * Alternar status (AJAX)
     */
    public function toggle_status($id) {
        $categoria = $this->Categoria_model->get($id);
        
        if (!$categoria) {
            $this->json_error('Categoria não encontrada', null, 404);
        }

        $novo_status = $categoria->status === 'ativo' ? 'inativo' : 'ativo';
        
        if ($this->Categoria_model->update($id, ['status' => $novo_status])) {
            $this->registrar_log('toggle_status', 'categorias', $id);
            $this->json_success('Status alterado com sucesso!', ['status' => $novo_status]);
        } else {
            $this->json_error('Erro ao alterar status');
        }
    }
}

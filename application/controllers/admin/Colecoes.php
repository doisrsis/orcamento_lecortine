<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller de Coleções
 * 
 * CRUD completo de coleções de tecidos
 * 
 * @author Rafael Dias - doisr.com.br
 * @date 13/11/2024
 */
class Colecoes extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Colecao_model');
    }

    /**
     * Listar coleções
     */
    public function index() {
        $data['titulo'] = 'Coleções - Le Cortine';
        $data['menu_ativo'] = 'colecoes';
        
        // Buscar coleções
        $data['colecoes'] = $this->Colecao_model->get_all();
        
        // Carregar views
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/colecoes/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Criar coleção
     */
    public function criar() {
        $data['titulo'] = 'Nova Coleção - Le Cortine';
        $data['menu_ativo'] = 'colecoes';
        
        // Processar formulário
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nome', 'Nome', 'required|max_length[100]');
            $this->form_validation->set_rules('descricao', 'Descrição', 'max_length[500]');
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[ativo,inativo]');

            if ($this->form_validation->run()) {
                $dados = [
                    'nome' => $this->input->post('nome'),
                    'descricao' => $this->input->post('descricao'),
                    'status' => $this->input->post('status')
                ];

                // Upload de imagem
                if (!empty($_FILES['imagem']['name'])) {
                    $imagem = $this->upload_arquivo('imagem', 'colecoes');
                    if ($imagem) {
                        $dados['imagem'] = $imagem;
                    }
                }

                $id = $this->Colecao_model->insert($dados);

                if ($id) {
                    $this->registrar_log('criar', 'colecoes', $id, null, $dados);
                    $this->session->set_flashdata('sucesso', 'Coleção criada com sucesso!');
                    redirect('admin/colecoes');
                } else {
                    $this->session->set_flashdata('erro', 'Erro ao criar coleção.');
                }
            }
        }
        
        // Carregar views
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/colecoes/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Editar coleção
     */
    public function editar($id) {
        $colecao = $this->Colecao_model->get($id);
        
        if (!$colecao) {
            show_404();
        }
        
        $data['titulo'] = 'Editar Coleção - Le Cortine';
        $data['menu_ativo'] = 'colecoes';
        $data['colecao'] = $colecao;
        
        // Processar formulário
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nome', 'Nome', 'required|max_length[100]');
            $this->form_validation->set_rules('descricao', 'Descrição', 'max_length[500]');
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[ativo,inativo]');

            if ($this->form_validation->run()) {
                $dados = [
                    'nome' => $this->input->post('nome'),
                    'descricao' => $this->input->post('descricao'),
                    'status' => $this->input->post('status')
                ];

                // Upload de imagem
                if (!empty($_FILES['imagem']['name'])) {
                    $imagem = $this->upload_arquivo('imagem', 'colecoes');
                    if ($imagem) {
                        // Deletar imagem antiga
                        if ($colecao->imagem) {
                            $this->deletar_arquivo('./uploads/colecoes/' . $colecao->imagem);
                        }
                        $dados['imagem'] = $imagem;
                    }
                }

                if ($this->Colecao_model->update($id, $dados)) {
                    $this->registrar_log('editar', 'colecoes', $id, $colecao, $dados);
                    $this->session->set_flashdata('sucesso', 'Coleção atualizada com sucesso!');
                    redirect('admin/colecoes');
                } else {
                    $this->session->set_flashdata('erro', 'Erro ao atualizar coleção.');
                }
            }
        }
        
        // Carregar views
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/colecoes/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Deletar coleção
     */
    public function deletar($id) {
        $colecao = $this->Colecao_model->get($id);
        
        if (!$colecao) {
            show_404();
        }

        // Verificar se pode deletar
        $result = $this->Colecao_model->delete($id);

        if ($result) {
            // Deletar imagem
            if ($colecao->imagem) {
                $this->deletar_arquivo('./uploads/colecoes/' . $colecao->imagem);
            }

            $this->registrar_log('deletar', 'colecoes', $id, $colecao);
            $this->session->set_flashdata('sucesso', 'Coleção deletada com sucesso!');
        } else {
            $this->session->set_flashdata('erro', 'Não é possível deletar esta coleção pois existem tecidos vinculados.');
        }

        redirect('admin/colecoes');
    }

    /**
     * Toggle status (AJAX)
     */
    public function toggle_status($id) {
        $colecao = $this->Colecao_model->get($id);
        
        if (!$colecao) {
            $this->json_error('Coleção não encontrada', null, 404);
        }

        $novo_status = $colecao->status === 'ativo' ? 'inativo' : 'ativo';
        
        if ($this->Colecao_model->update($id, ['status' => $novo_status])) {
            $this->registrar_log('toggle_status', 'colecoes', $id);
            $this->json_success('Status alterado com sucesso!', ['status' => $novo_status]);
        } else {
            $this->json_error('Erro ao alterar status');
        }
    }
}

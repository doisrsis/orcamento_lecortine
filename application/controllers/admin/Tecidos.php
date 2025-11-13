<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller de Tecidos
 * 
 * CRUD completo de tecidos com gerenciamento de cores
 * 
 * @author Rafael Dias - doisr.com.br
 * @date 13/11/2024
 */
class Tecidos extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Tecido_model');
        $this->load->model('Colecao_model');
    }

    /**
     * Listar tecidos
     */
    public function index() {
        $data['titulo'] = 'Tecidos - Le Cortine';
        $data['menu_ativo'] = 'tecidos';
        
        // Filtros
        $filtros = [];
        if ($this->input->get('colecao')) {
            $filtros['colecao_id'] = $this->input->get('colecao');
        }
        if ($this->input->get('status')) {
            $filtros['status'] = $this->input->get('status');
        }
        if ($this->input->get('busca')) {
            $filtros['busca'] = $this->input->get('busca');
        }
        
        // Buscar tecidos e coleções
        $data['tecidos'] = $this->Tecido_model->get_all($filtros);
        $data['colecoes'] = $this->Colecao_model->get_all(['status' => 'ativo']);
        
        // Carregar views
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/tecidos/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Criar tecido
     */
    public function criar() {
        $data['titulo'] = 'Novo Tecido - Le Cortine';
        $data['menu_ativo'] = 'tecidos';
        $data['colecoes'] = $this->Colecao_model->get_all(['status' => 'ativo']);
        
        // Processar formulário
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nome', 'Nome', 'required|max_length[100]');
            $this->form_validation->set_rules('colecao_id', 'Coleção', 'required|integer');
            $this->form_validation->set_rules('codigo', 'Código', 'max_length[50]');
            $this->form_validation->set_rules('composicao', 'Composição', 'max_length[200]');
            $this->form_validation->set_rules('largura_padrao', 'Largura', 'numeric');
            $this->form_validation->set_rules('preco_adicional', 'Preço Adicional', 'numeric');
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[ativo,inativo]');

            if ($this->form_validation->run()) {
                $dados = [
                    'nome' => $this->input->post('nome'),
                    'colecao_id' => $this->input->post('colecao_id'),
                    'codigo' => $this->input->post('codigo'),
                    'descricao' => $this->input->post('descricao'),
                    'composicao' => $this->input->post('composicao'),
                    'largura_padrao' => $this->input->post('largura_padrao') ?: null,
                    'tipo' => $this->input->post('tipo') ?: 'outro',
                    'preco_adicional' => $this->input->post('preco_adicional') ?: 0,
                    'status' => $this->input->post('status')
                ];

                // Upload de imagem
                if (!empty($_FILES['imagem']['name'])) {
                    $imagem = $this->upload_arquivo('imagem', 'tecidos');
                    if ($imagem) {
                        $dados['imagem'] = $imagem;
                    }
                }

                $id = $this->Tecido_model->insert($dados);

                if ($id) {
                    $this->registrar_log('criar', 'tecidos', $id, null, $dados);
                    $this->session->set_flashdata('sucesso', 'Tecido criado com sucesso!');
                    redirect('admin/tecidos/editar/' . $id);
                } else {
                    $this->session->set_flashdata('erro', 'Erro ao criar tecido.');
                }
            }
        }
        
        // Carregar views
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/tecidos/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Editar tecido
     */
    public function editar($id) {
        $tecido = $this->Tecido_model->get($id);
        
        if (!$tecido) {
            show_404();
        }
        
        $data['titulo'] = 'Editar Tecido - Le Cortine';
        $data['menu_ativo'] = 'tecidos';
        $data['tecido'] = $tecido;
        $data['colecoes'] = $this->Colecao_model->get_all(['status' => 'ativo']);
        $data['cores'] = $this->Tecido_model->get_cores($id);
        
        // Processar formulário
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nome', 'Nome', 'required|max_length[100]');
            $this->form_validation->set_rules('colecao_id', 'Coleção', 'required|integer');
            $this->form_validation->set_rules('codigo', 'Código', 'max_length[50]');
            $this->form_validation->set_rules('composicao', 'Composição', 'max_length[200]');
            $this->form_validation->set_rules('largura_padrao', 'Largura', 'numeric');
            $this->form_validation->set_rules('preco_adicional', 'Preço Adicional', 'numeric');
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[ativo,inativo]');

            if ($this->form_validation->run()) {
                $dados = [
                    'nome' => $this->input->post('nome'),
                    'colecao_id' => $this->input->post('colecao_id'),
                    'codigo' => $this->input->post('codigo'),
                    'descricao' => $this->input->post('descricao'),
                    'composicao' => $this->input->post('composicao'),
                    'largura_padrao' => $this->input->post('largura_padrao') ?: null,
                    'tipo' => $this->input->post('tipo') ?: 'outro',
                    'preco_adicional' => $this->input->post('preco_adicional') ?: 0,
                    'status' => $this->input->post('status')
                ];

                // Upload de imagem
                if (!empty($_FILES['imagem']['name'])) {
                    $imagem = $this->upload_arquivo('imagem', 'tecidos');
                    if ($imagem) {
                        // Deletar imagem antiga
                        if ($tecido->imagem) {
                            $this->deletar_arquivo('./uploads/tecidos/' . $tecido->imagem);
                        }
                        $dados['imagem'] = $imagem;
                    }
                }

                if ($this->Tecido_model->update($id, $dados)) {
                    $this->registrar_log('editar', 'tecidos', $id, $tecido, $dados);
                    $this->session->set_flashdata('sucesso', 'Tecido atualizado com sucesso!');
                    redirect('admin/tecidos/editar/' . $id);
                } else {
                    $this->session->set_flashdata('erro', 'Erro ao atualizar tecido.');
                }
            }
        }
        
        // Carregar views
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/tecidos/form', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Deletar tecido
     */
    public function deletar($id) {
        $tecido = $this->Tecido_model->get($id);
        
        if (!$tecido) {
            show_404();
        }

        // Buscar cores
        $cores = $this->Tecido_model->get_cores($id);

        if ($this->Tecido_model->delete($id)) {
            // Deletar imagem do tecido
            if ($tecido->imagem) {
                $this->deletar_arquivo('./uploads/tecidos/' . $tecido->imagem);
            }
            
            // Deletar imagens das cores
            foreach ($cores as $cor) {
                if ($cor->imagem) {
                    $this->deletar_arquivo('./uploads/tecidos/' . $cor->imagem);
                }
            }

            $this->registrar_log('deletar', 'tecidos', $id, $tecido);
            $this->session->set_flashdata('sucesso', 'Tecido deletado com sucesso!');
        } else {
            $this->session->set_flashdata('erro', 'Erro ao deletar tecido.');
        }

        redirect('admin/tecidos');
    }

    /**
     * Adicionar cor (AJAX)
     */
    public function adicionar_cor() {
        if ($this->input->method() !== 'post') {
            $this->json_error('Método não permitido', null, 405);
        }

        $tecido_id = $this->input->post('tecido_id');
        $nome = $this->input->post('nome');
        $codigo_hex = $this->input->post('codigo_hex');

        if (!$tecido_id || !$nome) {
            $this->json_error('Dados inválidos');
        }

        $dados = [
            'tecido_id' => $tecido_id,
            'nome' => $nome,
            'codigo_hex' => $codigo_hex
        ];

        // Upload de imagem da cor
        if (!empty($_FILES['imagem']['name'])) {
            $imagem = $this->upload_arquivo('imagem', 'tecidos');
            if ($imagem) {
                $dados['imagem'] = $imagem;
            }
        }

        $id = $this->Tecido_model->add_cor($dados);

        if ($id) {
            $cor = $this->Tecido_model->get_cor($id);
            $this->json_success('Cor adicionada com sucesso!', $cor);
        } else {
            $this->json_error('Erro ao adicionar cor');
        }
    }

    /**
     * Deletar cor (AJAX)
     */
    public function deletar_cor($id) {
        $cor = $this->Tecido_model->get_cor($id);
        
        if (!$cor) {
            $this->json_error('Cor não encontrada', null, 404);
        }

        if ($this->Tecido_model->delete_cor($id)) {
            // Deletar imagem
            if ($cor->imagem) {
                $this->deletar_arquivo('./uploads/tecidos/' . $cor->imagem);
            }
            $this->json_success('Cor deletada com sucesso!');
        } else {
            $this->json_error('Erro ao deletar cor');
        }
    }

    /**
     * Reordenar cores (AJAX)
     */
    public function reordenar_cores() {
        if ($this->input->method() !== 'post') {
            $this->json_error('Método não permitido', null, 405);
        }

        $ordem = $this->input->post('ordem');

        if (!$ordem || !is_array($ordem)) {
            $this->json_error('Dados inválidos');
        }

        if ($this->Tecido_model->reordenar_cores($ordem)) {
            $this->json_success('Ordem atualizada com sucesso!');
        } else {
            $this->json_error('Erro ao atualizar ordem');
        }
    }

    /**
     * Toggle status (AJAX)
     */
    public function toggle_status($id) {
        $tecido = $this->Tecido_model->get($id);
        
        if (!$tecido) {
            $this->json_error('Tecido não encontrado', null, 404);
        }

        $novo_status = $tecido->status === 'ativo' ? 'inativo' : 'ativo';
        
        if ($this->Tecido_model->update($id, ['status' => $novo_status])) {
            $this->registrar_log('toggle_status', 'tecidos', $id);
            $this->json_success('Status alterado com sucesso!', ['status' => $novo_status]);
        } else {
            $this->json_error('Erro ao alterar status');
        }
    }
}

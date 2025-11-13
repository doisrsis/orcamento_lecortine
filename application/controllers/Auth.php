<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller de Autenticação
 * 
 * Gerencia login, logout e recuperação de senha
 * 
 * @author Rafael Dias - doisr.com.br
 * @date 13/11/2024
 */
class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Usuario_model');
        $this->load->library('form_validation');
    }

    /**
     * Página de login
     */
    public function login() {
        // Se já estiver logado, redirecionar para admin
        if ($this->session->userdata('usuario_logado')) {
            redirect('admin/dashboard');
        }

        // Processar formulário
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');
            $this->form_validation->set_rules('senha', 'Senha', 'required');

            if ($this->form_validation->run()) {
                $email = $this->input->post('email');
                $senha = $this->input->post('senha');
                $lembrar = $this->input->post('lembrar');

                $usuario = $this->Usuario_model->verificar_login($email, $senha);

                if ($usuario) {
                    // Criar sessão
                    $sessao_data = [
                        'usuario_id' => $usuario->id,
                        'usuario_nome' => $usuario->nome,
                        'usuario_email' => $usuario->email,
                        'usuario_nivel' => $usuario->nivel,
                        'usuario_avatar' => $usuario->avatar,
                        'usuario_logado' => true
                    ];

                    $this->session->set_userdata($sessao_data);

                    // Lembrar usuário (cookie)
                    if ($lembrar) {
                        set_cookie('usuario_email', $email, 86400 * 30); // 30 dias
                    }

                    // Registrar log
                    $this->registrar_log('login', 'usuarios', $usuario->id);

                    // Redirecionar
                    $redirect = $this->input->get('redirect') ?? 'admin/dashboard';
                    redirect($redirect);
                } else {
                    $this->session->set_flashdata('erro', 'E-mail ou senha incorretos.');
                }
            }
        }

        // Carregar view
        $data['titulo'] = 'Login - Le Cortine';
        $data['email_lembrado'] = get_cookie('usuario_email');
        
        $this->load->view('auth/login', $data);
    }

    /**
     * Logout
     */
    public function logout() {
        // Registrar log
        if ($this->session->userdata('usuario_id')) {
            $this->registrar_log('logout', 'usuarios', $this->session->userdata('usuario_id'));
        }

        // Destruir sessão
        $this->session->unset_userdata([
            'usuario_id',
            'usuario_nome',
            'usuario_email',
            'usuario_nivel',
            'usuario_avatar',
            'usuario_logado'
        ]);

        $this->session->set_flashdata('sucesso', 'Logout realizado com sucesso!');
        redirect('login');
    }

    /**
     * Recuperar senha
     */
    public function recuperar_senha() {
        // Se já estiver logado, redirecionar
        if ($this->session->userdata('usuario_logado')) {
            redirect('admin/dashboard');
        }

        // Processar formulário
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');

            if ($this->form_validation->run()) {
                $email = $this->input->post('email');
                $token = $this->Usuario_model->gerar_token_recuperacao($email);

                if ($token) {
                    // Enviar e-mail com link de recuperação
                    $this->enviar_email_recuperacao($email, $token);
                    
                    $this->session->set_flashdata('sucesso', 'Instruções de recuperação enviadas para seu e-mail.');
                    redirect('login');
                } else {
                    $this->session->set_flashdata('erro', 'E-mail não encontrado.');
                }
            }
        }

        // Carregar view
        $data['titulo'] = 'Recuperar Senha - Le Cortine';
        $this->load->view('auth/recuperar_senha', $data);
    }

    /**
     * Resetar senha com token
     */
    public function resetar_senha($token = null) {
        if (!$token) {
            show_404();
        }

        // Verificar token
        $usuario = $this->Usuario_model->verificar_token($token);

        if (!$usuario) {
            $this->session->set_flashdata('erro', 'Token inválido ou expirado.');
            redirect('login');
        }

        // Processar formulário
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('senha', 'Nova senha', 'required|min_length[6]');
            $this->form_validation->set_rules('senha_confirma', 'Confirmação de senha', 'required|matches[senha]');

            if ($this->form_validation->run()) {
                $nova_senha = $this->input->post('senha');
                
                if ($this->Usuario_model->resetar_senha($token, $nova_senha)) {
                    $this->session->set_flashdata('sucesso', 'Senha alterada com sucesso! Faça login com sua nova senha.');
                    redirect('login');
                } else {
                    $this->session->set_flashdata('erro', 'Erro ao resetar senha. Tente novamente.');
                }
            }
        }

        // Carregar view
        $data['titulo'] = 'Resetar Senha - Le Cortine';
        $data['token'] = $token;
        $data['usuario'] = $usuario;
        
        $this->load->view('auth/resetar_senha', $data);
    }

    /**
     * Enviar e-mail de recuperação
     */
    private function enviar_email_recuperacao($email, $token) {
        $this->load->library('email');

        $link = base_url("auth/resetar-senha/{$token}");
        
        $mensagem = "
            <h2>Recuperação de Senha - Le Cortine</h2>
            <p>Você solicitou a recuperação de senha.</p>
            <p>Clique no link abaixo para criar uma nova senha:</p>
            <p><a href='{$link}' style='padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Resetar Senha</a></p>
            <p>Ou copie e cole este link no navegador:</p>
            <p>{$link}</p>
            <p>Este link expira em 1 hora.</p>
            <p>Se você não solicitou esta recuperação, ignore este e-mail.</p>
        ";

        $this->email->from('noreply@lecortine.com.br', 'Le Cortine');
        $this->email->to($email);
        $this->email->subject('Recuperação de Senha - Le Cortine');
        $this->email->message($mensagem);

        return $this->email->send();
    }

    /**
     * Registrar log de ação
     */
    private function registrar_log($acao, $tabela, $registro_id) {
        $data = [
            'usuario_id' => $this->session->userdata('usuario_id'),
            'acao' => $acao,
            'tabela' => $tabela,
            'registro_id' => $registro_id,
            'ip' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent(),
            'criado_em' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('logs', $data);
    }
}

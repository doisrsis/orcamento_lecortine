-- ============================================================================
-- ALTERAR SENHA DO ADMINISTRADOR
-- Autor: Rafael Dias - doisr.com.br
-- Data: 14/11/2024
-- ============================================================================
-- 
-- IMPORTANTE: Este sistema usa password_hash() do PHP (bcrypt), NÃO MD5!
-- 
-- Para gerar um novo hash de senha:
-- 1. Acesse: http://localhost/orcamento/docs/GERAR_SENHA.php?senha=SUA_SENHA
-- 2. Copie o hash gerado
-- 3. Substitua no comando abaixo
-- 
-- ============================================================================

USE `cecriativocom_lecortine_orc`;

-- Exemplo: Alterar senha para "admin123"
-- Hash gerado: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi

UPDATE `usuarios` 
SET 
    `senha` = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    `atualizado_em` = NOW()
WHERE `email` = 'admin@lecortine.com.br';

-- OU atualizar por ID
-- UPDATE `usuarios` 
-- SET 
--     `senha` = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
--     `atualizado_em` = NOW()
-- WHERE `id` = 1;

-- Verificar se foi alterado
SELECT 
    id, 
    nome, 
    email, 
    nivel, 
    status, 
    LEFT(senha, 20) as senha_hash,
    atualizado_em
FROM `usuarios` 
WHERE `email` = 'admin@lecortine.com.br';

-- ============================================================================
-- SENHAS COMUNS JÁ GERADAS (para facilitar)
-- ============================================================================

-- admin123 = $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
-- lecortine2024 = (gere usando GERAR_SENHA.php)
-- senha123 = (gere usando GERAR_SENHA.php)

-- ============================================================================
-- OBSERVAÇÕES
-- ============================================================================
-- 
-- 1. Cada hash é ÚNICO, mesmo para a mesma senha (por causa do salt)
-- 2. O hash tem 60 caracteres
-- 3. Começa sempre com $2y$ (bcrypt)
-- 4. NUNCA use MD5 ou SHA1 para senhas!
-- 5. O sistema verifica a senha com password_verify()
-- 
-- ============================================================================

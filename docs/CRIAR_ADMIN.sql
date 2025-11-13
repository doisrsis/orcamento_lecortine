-- ============================================================================
-- CRIAR USUÁRIO ADMIN - Sistema de Orçamento Le Cortine
-- Autor: Rafael Dias - doisr.com.br
-- Data: 13/11/2024
-- ============================================================================
-- 
-- INSTRUÇÕES:
-- Execute este SQL após executar o EXECUTAR_ESTE.sql
-- Ou execute diretamente se o usuário admin não funcionar
--
-- ============================================================================

USE `cecriativocom_lecortine_orc`;

-- Deletar usuário admin existente (se houver)
DELETE FROM `usuarios` WHERE `email` = 'admin@lecortine.com.br';

-- Criar novo usuário admin
-- Email: admin@lecortine.com.br
-- Senha: admin123
INSERT INTO `usuarios` (`nome`, `email`, `senha`, `telefone`, `nivel`, `status`, `criado_em`) VALUES
('Administrador', 'admin@lecortine.com.br', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '(11) 99999-9999', 'admin', 'ativo', NOW());

-- Verificar se foi criado
SELECT id, nome, email, nivel, status FROM usuarios WHERE email = 'admin@lecortine.com.br';

-- ============================================================================
-- ALTERNATIVA: Se a senha acima não funcionar, use este comando:
-- ============================================================================
-- 
-- Acesse: http://localhost/orcamento/gerar_hash.php
-- Copie o hash gerado e execute:
-- 
-- UPDATE usuarios SET senha = 'COLE_O_HASH_AQUI' WHERE email = 'admin@lecortine.com.br';
--
-- ============================================================================

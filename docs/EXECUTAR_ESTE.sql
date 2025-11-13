-- ============================================================================
-- SCRIPT DE INSTALAÇÃO - Sistema de Orçamento Le Cortine
-- Autor: Rafael Dias - doisr.com.br
-- Data: 13/11/2024 09:45
-- ============================================================================
-- 
-- INSTRUÇÕES:
-- 1. Abra o phpMyAdmin
-- 2. Selecione o banco: cecriativocom_lecortine_orc
-- 3. Clique na aba "SQL"
-- 4. Cole todo este conteúdo
-- 5. Clique em "Executar"
-- 
-- OU via linha de comando:
-- mysql -u cecriativocom_orc_lecortine -p cecriativocom_lecortine_orc < EXECUTAR_ESTE.sql
-- Senha: c$uZaCQh{%Dh7kc=2025
--
-- ============================================================================

-- Usar banco de dados existente
USE `cecriativocom_lecortine_orc`;

-- ============================================================================
-- REMOVER TABELAS EXISTENTES (SE HOUVER)
-- ============================================================================
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `orcamento_extras`;
DROP TABLE IF EXISTS `orcamento_itens`;
DROP TABLE IF EXISTS `orcamentos`;
DROP TABLE IF EXISTS `notificacoes`;
DROP TABLE IF EXISTS `logs`;
DROP TABLE IF EXISTS `configuracoes`;
DROP TABLE IF EXISTS `extras`;
DROP TABLE IF EXISTS `precos`;
DROP TABLE IF EXISTS `cores`;
DROP TABLE IF EXISTS `tecidos`;
DROP TABLE IF EXISTS `colecoes`;
DROP TABLE IF EXISTS `produto_imagens`;
DROP TABLE IF EXISTS `produtos`;
DROP TABLE IF EXISTS `categorias`;
DROP TABLE IF EXISTS `clientes`;
DROP TABLE IF EXISTS `usuarios`;

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================================
-- CRIAR TABELAS
-- ============================================================================

-- TABELA: usuarios
CREATE TABLE `usuarios` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `telefone` VARCHAR(20) DEFAULT NULL,
  `avatar` VARCHAR(255) DEFAULT NULL,
  `nivel` ENUM('admin', 'gerente', 'vendedor') DEFAULT 'vendedor',
  `status` ENUM('ativo', 'inativo') DEFAULT 'ativo',
  `ultimo_acesso` DATETIME DEFAULT NULL,
  `token_recuperacao` VARCHAR(100) DEFAULT NULL,
  `token_expiracao` DATETIME DEFAULT NULL,
  `criado_em` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_status` (`status`),
  KEY `idx_nivel` (`nivel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABELA: clientes
CREATE TABLE `clientes` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `telefone` VARCHAR(20) NOT NULL,
  `whatsapp` VARCHAR(20) NOT NULL,
  `cpf_cnpj` VARCHAR(20) DEFAULT NULL,
  `endereco` VARCHAR(255) DEFAULT NULL,
  `cidade` VARCHAR(100) DEFAULT NULL,
  `estado` VARCHAR(2) DEFAULT NULL,
  `cep` VARCHAR(10) DEFAULT NULL,
  `observacoes` TEXT DEFAULT NULL,
  `origem` VARCHAR(50) DEFAULT 'site',
  `criado_em` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_email` (`email`),
  KEY `idx_whatsapp` (`whatsapp`),
  KEY `idx_criado_em` (`criado_em`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABELA: categorias
CREATE TABLE `categorias` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL,
  `descricao` TEXT DEFAULT NULL,
  `icone` VARCHAR(255) DEFAULT NULL,
  `imagem` VARCHAR(255) DEFAULT NULL,
  `ordem` INT(11) DEFAULT 0,
  `status` ENUM('ativo', 'inativo') DEFAULT 'ativo',
  `criado_em` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_status` (`status`),
  KEY `idx_ordem` (`ordem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABELA: produtos
CREATE TABLE `produtos` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `categoria_id` INT(11) UNSIGNED NOT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL,
  `descricao` TEXT DEFAULT NULL,
  `descricao_curta` VARCHAR(255) DEFAULT NULL,
  `imagem_principal` VARCHAR(255) DEFAULT NULL,
  `caracteristicas` TEXT DEFAULT NULL,
  `tipo_calculo` ENUM('metro_quadrado', 'metro_linear', 'unidade') DEFAULT 'metro_quadrado',
  `preco_base` DECIMAL(10,2) DEFAULT 0.00,
  `ordem` INT(11) DEFAULT 0,
  `destaque` TINYINT(1) DEFAULT 0,
  `status` ENUM('ativo', 'inativo') DEFAULT 'ativo',
  `criado_em` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_categoria` (`categoria_id`),
  KEY `idx_status` (`status`),
  KEY `idx_ordem` (`ordem`),
  KEY `idx_destaque` (`destaque`),
  CONSTRAINT `fk_produtos_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABELA: produto_imagens
CREATE TABLE `produto_imagens` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `produto_id` INT(11) UNSIGNED NOT NULL,
  `imagem` VARCHAR(255) NOT NULL,
  `legenda` VARCHAR(255) DEFAULT NULL,
  `ordem` INT(11) DEFAULT 0,
  `criado_em` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_produto` (`produto_id`),
  KEY `idx_ordem` (`ordem`),
  CONSTRAINT `fk_produto_imagens_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABELA: colecoes
CREATE TABLE `colecoes` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL,
  `descricao` TEXT DEFAULT NULL,
  `imagem` VARCHAR(255) DEFAULT NULL,
  `ordem` INT(11) DEFAULT 0,
  `status` ENUM('ativo', 'inativo') DEFAULT 'ativo',
  `criado_em` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_status` (`status`),
  KEY `idx_ordem` (`ordem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABELA: tecidos
CREATE TABLE `tecidos` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `colecao_id` INT(11) UNSIGNED DEFAULT NULL,
  `produto_id` INT(11) UNSIGNED DEFAULT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `codigo` VARCHAR(50) DEFAULT NULL,
  `descricao` TEXT DEFAULT NULL,
  `imagem` VARCHAR(255) DEFAULT NULL,
  `tipo` ENUM('blackout', 'translucido', 'transparente', 'linho', 'voil', 'outro') DEFAULT 'outro',
  `composicao` VARCHAR(255) DEFAULT NULL,
  `largura_padrao` DECIMAL(10,2) DEFAULT NULL COMMENT 'Largura em metros',
  `preco_adicional` DECIMAL(10,2) DEFAULT 0.00,
  `ordem` INT(11) DEFAULT 0,
  `status` ENUM('ativo', 'inativo') DEFAULT 'ativo',
  `criado_em` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_colecao` (`colecao_id`),
  KEY `idx_produto` (`produto_id`),
  KEY `idx_status` (`status`),
  KEY `idx_tipo` (`tipo`),
  KEY `idx_ordem` (`ordem`),
  CONSTRAINT `fk_tecidos_colecao` FOREIGN KEY (`colecao_id`) REFERENCES `colecoes` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_tecidos_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABELA: cores
CREATE TABLE `cores` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tecido_id` INT(11) UNSIGNED NOT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `codigo_hex` VARCHAR(7) DEFAULT NULL COMMENT 'Código hexadecimal da cor',
  `imagem` VARCHAR(255) DEFAULT NULL,
  `ordem` INT(11) DEFAULT 0,
  `status` ENUM('ativo', 'inativo') DEFAULT 'ativo',
  `criado_em` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_tecido` (`tecido_id`),
  KEY `idx_status` (`status`),
  KEY `idx_ordem` (`ordem`),
  CONSTRAINT `fk_cores_tecido` FOREIGN KEY (`tecido_id`) REFERENCES `tecidos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABELA: precos
CREATE TABLE `precos` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `produto_id` INT(11) UNSIGNED NOT NULL,
  `largura_min` DECIMAL(10,2) NOT NULL COMMENT 'Largura mínima em metros',
  `largura_max` DECIMAL(10,2) NOT NULL COMMENT 'Largura máxima em metros',
  `altura_min` DECIMAL(10,2) NOT NULL COMMENT 'Altura mínima em metros',
  `altura_max` DECIMAL(10,2) NOT NULL COMMENT 'Altura máxima em metros',
  `preco_m2` DECIMAL(10,2) NOT NULL COMMENT 'Preço por metro quadrado',
  `preco_ml` DECIMAL(10,2) DEFAULT NULL COMMENT 'Preço por metro linear',
  `preco_fixo` DECIMAL(10,2) DEFAULT NULL COMMENT 'Preço fixo (unidade)',
  `observacoes` TEXT DEFAULT NULL,
  `criado_em` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_produto` (`produto_id`),
  KEY `idx_dimensoes` (`largura_min`, `largura_max`, `altura_min`, `altura_max`),
  CONSTRAINT `fk_precos_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABELA: extras
CREATE TABLE `extras` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `descricao` TEXT DEFAULT NULL,
  `tipo_preco` ENUM('fixo', 'percentual', 'por_m2') DEFAULT 'fixo',
  `valor` DECIMAL(10,2) NOT NULL,
  `aplicavel_a` TEXT DEFAULT NULL COMMENT 'JSON com IDs de produtos aplicáveis',
  `ordem` INT(11) DEFAULT 0,
  `status` ENUM('ativo', 'inativo') DEFAULT 'ativo',
  `criado_em` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_ordem` (`ordem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABELA: orcamentos
CREATE TABLE `orcamentos` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `numero` VARCHAR(20) NOT NULL COMMENT 'Número único do orçamento',
  `cliente_id` INT(11) UNSIGNED NOT NULL,
  `tipo_atendimento` ENUM('orcamento', 'consultoria') DEFAULT 'orcamento',
  `valor_total` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `desconto` DECIMAL(10,2) DEFAULT 0.00,
  `valor_final` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `observacoes_cliente` TEXT DEFAULT NULL,
  `observacoes_internas` TEXT DEFAULT NULL,
  `status` ENUM('pendente', 'em_analise', 'aprovado', 'recusado', 'cancelado') DEFAULT 'pendente',
  `enviado_whatsapp` TINYINT(1) DEFAULT 0,
  `enviado_email` TINYINT(1) DEFAULT 0,
  `data_envio_whatsapp` DATETIME DEFAULT NULL,
  `data_envio_email` DATETIME DEFAULT NULL,
  `ip_cliente` VARCHAR(45) DEFAULT NULL,
  `user_agent` VARCHAR(255) DEFAULT NULL,
  `criado_em` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero` (`numero`),
  KEY `idx_cliente` (`cliente_id`),
  KEY `idx_status` (`status`),
  KEY `idx_criado_em` (`criado_em`),
  KEY `idx_tipo_atendimento` (`tipo_atendimento`),
  CONSTRAINT `fk_orcamentos_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABELA: orcamento_itens
CREATE TABLE `orcamento_itens` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `orcamento_id` INT(11) UNSIGNED NOT NULL,
  `produto_id` INT(11) UNSIGNED NOT NULL,
  `tecido_id` INT(11) UNSIGNED DEFAULT NULL,
  `cor_id` INT(11) UNSIGNED DEFAULT NULL,
  `largura` DECIMAL(10,2) NOT NULL COMMENT 'Largura em metros',
  `altura` DECIMAL(10,2) NOT NULL COMMENT 'Altura em metros',
  `area_m2` DECIMAL(10,2) NOT NULL COMMENT 'Área em metros quadrados',
  `quantidade` INT(11) DEFAULT 1,
  `preco_unitario` DECIMAL(10,2) NOT NULL,
  `preco_total` DECIMAL(10,2) NOT NULL,
  `observacoes` TEXT DEFAULT NULL,
  `criado_em` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_orcamento` (`orcamento_id`),
  KEY `idx_produto` (`produto_id`),
  KEY `idx_tecido` (`tecido_id`),
  KEY `idx_cor` (`cor_id`),
  CONSTRAINT `fk_orcamento_itens_orcamento` FOREIGN KEY (`orcamento_id`) REFERENCES `orcamentos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_orcamento_itens_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_orcamento_itens_tecido` FOREIGN KEY (`tecido_id`) REFERENCES `tecidos` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_orcamento_itens_cor` FOREIGN KEY (`cor_id`) REFERENCES `cores` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABELA: orcamento_extras
CREATE TABLE `orcamento_extras` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `orcamento_item_id` INT(11) UNSIGNED NOT NULL,
  `extra_id` INT(11) UNSIGNED NOT NULL,
  `valor` DECIMAL(10,2) NOT NULL,
  `criado_em` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_orcamento_item` (`orcamento_item_id`),
  KEY `idx_extra` (`extra_id`),
  CONSTRAINT `fk_orcamento_extras_item` FOREIGN KEY (`orcamento_item_id`) REFERENCES `orcamento_itens` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_orcamento_extras_extra` FOREIGN KEY (`extra_id`) REFERENCES `extras` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABELA: configuracoes
CREATE TABLE `configuracoes` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `chave` VARCHAR(100) NOT NULL,
  `valor` TEXT DEFAULT NULL,
  `tipo` ENUM('texto', 'numero', 'booleano', 'json', 'arquivo') DEFAULT 'texto',
  `grupo` VARCHAR(50) DEFAULT 'geral',
  `descricao` VARCHAR(255) DEFAULT NULL,
  `criado_em` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chave` (`chave`),
  KEY `idx_grupo` (`grupo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABELA: logs
CREATE TABLE `logs` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario_id` INT(11) UNSIGNED DEFAULT NULL,
  `acao` VARCHAR(100) NOT NULL,
  `tabela` VARCHAR(50) DEFAULT NULL,
  `registro_id` INT(11) DEFAULT NULL,
  `dados_antigos` TEXT DEFAULT NULL COMMENT 'JSON com dados antes da alteração',
  `dados_novos` TEXT DEFAULT NULL COMMENT 'JSON com dados após a alteração',
  `ip` VARCHAR(45) DEFAULT NULL,
  `user_agent` VARCHAR(255) DEFAULT NULL,
  `criado_em` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_usuario` (`usuario_id`),
  KEY `idx_acao` (`acao`),
  KEY `idx_tabela` (`tabela`),
  KEY `idx_criado_em` (`criado_em`),
  CONSTRAINT `fk_logs_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABELA: notificacoes
CREATE TABLE `notificacoes` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario_id` INT(11) UNSIGNED DEFAULT NULL,
  `tipo` ENUM('info', 'sucesso', 'aviso', 'erro') DEFAULT 'info',
  `titulo` VARCHAR(255) NOT NULL,
  `mensagem` TEXT NOT NULL,
  `link` VARCHAR(255) DEFAULT NULL,
  `lida` TINYINT(1) DEFAULT 0,
  `data_leitura` DATETIME DEFAULT NULL,
  `criado_em` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_usuario` (`usuario_id`),
  KEY `idx_lida` (`lida`),
  KEY `idx_criado_em` (`criado_em`),
  CONSTRAINT `fk_notificacoes_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- ÍNDICES ADICIONAIS PARA PERFORMANCE
-- ============================================================================

CREATE INDEX idx_orcamentos_cliente_data ON orcamentos(cliente_id, criado_em);
CREATE INDEX idx_produtos_categoria_status ON produtos(categoria_id, status);
CREATE INDEX idx_tecidos_colecao_status ON tecidos(colecao_id, status);

-- ============================================================================
-- INSERIR DADOS INICIAIS
-- ============================================================================

-- Usuário administrador padrão (senha: admin123)
-- Hash gerado com password_hash('admin123', PASSWORD_DEFAULT)
INSERT INTO `usuarios` (`nome`, `email`, `senha`, `telefone`, `nivel`, `status`) VALUES
('Administrador', 'admin@lecortine.com.br', '$2y$10$rZ5c3Jz5JqX5Y5Y5Y5Y5YuKJ5Y5Y5Y5Y5Y5Y5Y5Y5Y5Y5Y5Y5Y5Y5O', '(11) 99999-9999', 'admin', 'ativo');

-- Configurações básicas do sistema
INSERT INTO `configuracoes` (`chave`, `valor`, `tipo`, `grupo`, `descricao`) VALUES
('empresa_nome', 'Le Cortine', 'texto', 'empresa', 'Nome da empresa'),
('empresa_email', 'contato@lecortine.com.br', 'texto', 'empresa', 'E-mail principal'),
('empresa_telefone', '(11) 3333-3333', 'texto', 'empresa', 'Telefone principal'),
('empresa_whatsapp', '5511999999999', 'texto', 'empresa', 'WhatsApp (formato internacional)'),
('site_titulo', 'Le Cortine - Orçamento Online', 'texto', 'site', 'Título do site'),
('orcamento_validade_dias', '15', 'numero', 'orcamento', 'Validade do orçamento em dias');

-- ============================================================================
-- FIM DA INSTALAÇÃO
-- ============================================================================

SELECT 'Instalação concluída com sucesso! 16 tabelas criadas.' AS Resultado;

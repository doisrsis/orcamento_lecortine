-- ============================================================================
-- DADOS DE TESTE - Sistema de Orçamento Le Cortine
-- Autor: Rafael Dias - doisr.com.br
-- Data: 13/11/2024 18:25
-- ============================================================================

USE `cecriativocom_lecortine_orc`;

-- Limpar dados de teste (ordem correta para evitar erros de FK)
DELETE FROM `orcamento_extras`;
DELETE FROM `orcamento_itens`;
DELETE FROM `orcamentos`;
DELETE FROM `cores`;
DELETE FROM `produto_imagens`;
DELETE FROM `tecidos`;
DELETE FROM `produtos`;
DELETE FROM `colecoes`;
DELETE FROM `categorias`;
DELETE FROM `clientes`;

-- Resetar auto_increment
ALTER TABLE `categorias` AUTO_INCREMENT = 1;
ALTER TABLE `produtos` AUTO_INCREMENT = 1;
ALTER TABLE `colecoes` AUTO_INCREMENT = 1;
ALTER TABLE `tecidos` AUTO_INCREMENT = 1;
ALTER TABLE `cores` AUTO_INCREMENT = 1;
ALTER TABLE `clientes` AUTO_INCREMENT = 1;

-- ============================================================================
-- CATEGORIAS
-- ============================================================================
INSERT INTO `categorias` (`nome`, `slug`, `descricao`, `status`, `ordem`, `criado_em`) VALUES
('Cortinas', 'cortinas', 'Cortinas para todos os ambientes', 'ativo', 1, NOW()),
('Persianas', 'persianas', 'Persianas horizontais e verticais', 'ativo', 2, NOW()),
('Toldos', 'toldos', 'Toldos retráteis e fixos', 'ativo', 3, NOW()),
('Papel de Parede', 'papel-de-parede', 'Papéis de parede decorativos', 'ativo', 4, NOW()),
('Acessórios', 'acessorios', 'Varões, suportes e trilhos', 'ativo', 5, NOW());

-- ============================================================================
-- PRODUTOS
-- ============================================================================
INSERT INTO `produtos` (`categoria_id`, `nome`, `slug`, `descricao_curta`, `preco_base`, `status`, `destaque`, `ordem`, `criado_em`) VALUES
(1, 'Cortina Rolô Blackout', 'cortina-rolo-blackout', 'Cortina rolô com bloqueio total de luz', 350.00, 'ativo', 1, 1, NOW()),
(1, 'Cortina Romana', 'cortina-romana', 'Elegante cortina romana com pregas', 420.00, 'ativo', 1, 2, NOW()),
(1, 'Cortina Painel', 'cortina-painel', 'Painéis deslizantes para grandes janelas', 580.00, 'ativo', 0, 3, NOW()),
(1, 'Cortina Voil', 'cortina-voil', 'Cortina leve e transparente', 280.00, 'ativo', 0, 4, NOW()),
(1, 'Cortina Dupla', 'cortina-dupla', 'Sistema duplo: blackout + voil', 650.00, 'ativo', 1, 5, NOW()),
(2, 'Persiana Horizontal Alumínio', 'persiana-horizontal-aluminio', 'Persiana horizontal em alumínio 25mm', 180.00, 'ativo', 0, 6, NOW()),
(2, 'Persiana Vertical PVC', 'persiana-vertical-pvc', 'Persiana vertical em PVC', 320.00, 'ativo', 0, 7, NOW()),
(2, 'Persiana Horizontal Madeira', 'persiana-horizontal-madeira', 'Persiana em madeira nobre 50mm', 580.00, 'ativo', 1, 8, NOW()),
(3, 'Toldo Retrátil Manual', 'toldo-retratil-manual', 'Toldo retrátil com acionamento manual', 1200.00, 'ativo', 0, 9, NOW()),
(3, 'Toldo Retrátil Motorizado', 'toldo-retratil-motorizado', 'Toldo com motor elétrico e controle remoto', 2800.00, 'ativo', 1, 10, NOW()),
(4, 'Papel de Parede Vinílico', 'papel-parede-vinilico', 'Papel vinílico lavável', 85.00, 'ativo', 0, 11, NOW()),
(4, 'Papel de Parede 3D', 'papel-parede-3d', 'Papel com efeito 3D texturizado', 120.00, 'ativo', 1, 12, NOW()),
(5, 'Varão Extensível', 'varao-extensivel', 'Varão em alumínio 1,20m a 2,00m', 65.00, 'ativo', 0, 13, NOW()),
(5, 'Kit Trilho Suíço', 'kit-trilho-suico', 'Kit completo de trilho suíço', 180.00, 'ativo', 0, 14, NOW());

-- ============================================================================
-- COLEÇÕES
-- ============================================================================
INSERT INTO `colecoes` (`nome`, `slug`, `descricao`, `status`, `criado_em`) VALUES
('Coleção Premium', 'colecao-premium', 'Tecidos nobres e sofisticados', 'ativo', NOW()),
('Coleção Blackout', 'colecao-blackout', 'Tecidos com bloqueio total de luz', 'ativo', NOW()),
('Coleção Translúcida', 'colecao-translucida', 'Tecidos leves que filtram a luz', 'ativo', NOW()),
('Coleção Sustentável', 'colecao-sustentavel', 'Tecidos ecológicos', 'ativo', NOW()),
('Coleção Infantil', 'colecao-infantil', 'Tecidos coloridos para crianças', 'ativo', NOW());

-- ============================================================================
-- TECIDOS
-- ============================================================================
INSERT INTO `tecidos` (`colecao_id`, `nome`, `codigo`, `composicao`, `largura_padrao`, `tipo`, `status`, `criado_em`) VALUES
(1, 'Linho Rústico', 'LR-001', '100% Linho', 2.80, 'linho', 'ativo', NOW()),
(1, 'Seda Pura', 'SP-001', '100% Seda', 1.40, 'outro', 'ativo', NOW()),
(1, 'Veludo Acetinado', 'VA-001', '70% Algodão, 30% Poliéster', 1.45, 'outro', 'ativo', NOW()),
(2, 'Blackout Total', 'BT-001', '100% Poliéster', 2.80, 'blackout', 'ativo', NOW()),
(2, 'Blackout Soft', 'BS-001', '100% Poliéster', 2.80, 'blackout', 'ativo', NOW()),
(3, 'Voil Clássico', 'VC-001', '100% Poliéster', 2.80, 'voil', 'ativo', NOW()),
(3, 'Linho Translúcido', 'LT-001', '70% Linho, 30% Poliéster', 2.80, 'translucido', 'ativo', NOW()),
(3, 'Tela Solar', 'TS-001', '100% Poliéster com PVC', 2.00, 'translucido', 'ativo', NOW()),
(4, 'Algodão Orgânico', 'AO-001', '100% Algodão Orgânico', 2.80, 'outro', 'ativo', NOW()),
(4, 'Linho Ecológico', 'LE-001', '100% Linho Ecológico', 2.80, 'linho', 'ativo', NOW()),
(5, 'Estampado Infantil', 'EI-001', '100% Poliéster', 2.80, 'outro', 'ativo', NOW()),
(5, 'Blackout Kids', 'BK-001', '100% Poliéster', 2.80, 'blackout', 'ativo', NOW());

-- ============================================================================
-- CORES (4 cores por tecido)
-- ============================================================================
INSERT INTO `cores` (`tecido_id`, `nome`, `codigo_hex`, `ordem`, `criado_em`) VALUES
-- Linho Rústico
(1, 'Bege Natural', '#D4C4A8', 1, NOW()), (1, 'Cinza Claro', '#C0C0C0', 2, NOW()),
(1, 'Marrom Terra', '#8B7355', 3, NOW()), (1, 'Off White', '#F5F5DC', 4, NOW()),
-- Seda Pura
(2, 'Champagne', '#F7E7CE', 1, NOW()), (2, 'Pérola', '#E8E8E8', 2, NOW()),
(2, 'Dourado', '#FFD700', 3, NOW()), (2, 'Prata', '#C0C0C0', 4, NOW()),
-- Veludo Acetinado
(3, 'Vinho', '#722F37', 1, NOW()), (3, 'Azul Marinho', '#000080', 2, NOW()),
(3, 'Verde Esmeralda', '#50C878', 3, NOW()), (3, 'Cinza Chumbo', '#71797E', 4, NOW()),
-- Blackout Total
(4, 'Branco', '#FFFFFF', 1, NOW()), (4, 'Bege', '#F5F5DC', 2, NOW()),
(4, 'Cinza', '#808080', 3, NOW()), (4, 'Preto', '#000000', 4, NOW()),
-- Blackout Soft
(5, 'Areia', '#E6D7C3', 1, NOW()), (5, 'Pérola', '#EAE6E2', 2, NOW()),
(5, 'Grafite', '#4A4A4A', 3, NOW()), (5, 'Taupe', '#B38B6D', 4, NOW()),
-- Voil Clássico
(6, 'Branco', '#FFFFFF', 1, NOW()), (6, 'Off White', '#FAF0E6', 2, NOW()),
(6, 'Palha', '#F0E68C', 3, NOW()), (6, 'Champagne', '#F7E7CE', 4, NOW()),
-- Linho Translúcido
(7, 'Natural', '#E8DCC8', 1, NOW()), (7, 'Areia', '#D4C4A8', 2, NOW()),
(7, 'Cinza Claro', '#D3D3D3', 3, NOW()), (7, 'Bege Rosado', '#E8C4A8', 4, NOW()),
-- Tela Solar
(8, 'Branco', '#FFFFFF', 1, NOW()), (8, 'Cinza Claro', '#D3D3D3', 2, NOW()),
(8, 'Cinza Escuro', '#696969', 3, NOW()), (8, 'Preto', '#000000', 4, NOW()),
-- Algodão Orgânico
(9, 'Cru Natural', '#F5F5DC', 1, NOW()), (9, 'Bege', '#E8D7C3', 2, NOW()),
(9, 'Terracota', '#E2725B', 3, NOW()), (9, 'Verde Oliva', '#808000', 4, NOW()),
-- Linho Ecológico
(10, 'Natural', '#E8DCC8', 1, NOW()), (10, 'Areia', '#D4C4A8', 2, NOW()),
(10, 'Mostarda', '#FFDB58', 3, NOW()), (10, 'Verde Sálvia', '#9DC183', 4, NOW()),
-- Estampado Infantil
(11, 'Unicórnios Rosa', '#FFB6C1', 1, NOW()), (11, 'Dinossauros Verde', '#90EE90', 2, NOW()),
(11, 'Estrelas Azul', '#87CEEB', 3, NOW()), (11, 'Nuvens Branco', '#F0F8FF', 4, NOW()),
-- Blackout Kids
(12, 'Azul Céu', '#87CEEB', 1, NOW()), (12, 'Rosa Bebê', '#FFB6C1', 2, NOW()),
(12, 'Verde Menta', '#98FF98', 3, NOW()), (12, 'Lilás', '#DDA0DD', 4, NOW());

-- ============================================================================
-- CLIENTES
-- ============================================================================
INSERT INTO `clientes` (`nome`, `email`, `telefone`, `whatsapp`, `cidade`, `estado`, `criado_em`) VALUES
('Maria Silva Santos', 'maria.silva@email.com', '(11) 98765-4321', '11987654321', 'São Paulo', 'SP', NOW()),
('João Pedro Oliveira', 'joao.pedro@email.com', '(11) 97654-3210', '11976543210', 'São Paulo', 'SP', NOW()),
('Ana Carolina Souza', 'ana.carolina@email.com', '(11) 96543-2109', '11965432109', 'São Paulo', 'SP', NOW()),
('Carlos Eduardo Lima', 'carlos.lima@email.com', '(11) 95432-1098', '11954321098', 'São Paulo', 'SP', NOW()),
('Fernanda Costa Alves', 'fernanda.costa@email.com', '(11) 94321-0987', '11943210987', 'São Paulo', 'SP', NOW());

-- ============================================================================
-- EXTRAS
-- ============================================================================
INSERT INTO `extras` (`nome`, `descricao`, `tipo_preco`, `valor`, `status`, `ordem`, `criado_em`) VALUES
('Blackout', 'Forro blackout para bloqueio total de luz', 'por_m2', 80.00, 'ativo', 1, NOW()),
('Forro Térmico', 'Forro térmico para isolamento', 'por_m2', 65.00, 'ativo', 2, NOW()),
('Motorização', 'Motor elétrico com controle remoto', 'fixo', 850.00, 'ativo', 3, NOW()),
('Sensor de Luz', 'Sensor automático de luminosidade', 'fixo', 320.00, 'ativo', 4, NOW()),
('Instalação Profissional', 'Serviço de instalação', 'fixo', 150.00, 'ativo', 5, NOW()),
('Medição no Local', 'Serviço de medição', 'fixo', 80.00, 'ativo', 6, NOW()),
('Garantia Estendida', 'Garantia estendida por 2 anos', 'fixo', 200.00, 'ativo', 7, NOW());

-- ============================================================================
-- FIM DO SCRIPT
-- ============================================================================
SELECT 'Dados de teste inseridos com sucesso!' as Resultado;

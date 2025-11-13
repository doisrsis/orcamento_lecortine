# 🗺️ Roadmap de Desenvolvimento - Sistema de Orçamento Le Cortine

**Autor:** Rafael Dias - [doisr.com.br](https://doisr.com.br)  
**Data:** 13/11/2024 09:28

---

## 📋 Visão Geral

Este roadmap detalha todas as etapas do desenvolvimento do sistema de orçamento online para Le Cortine, desde a configuração inicial até o deploy em produção.

---

## 🎯 Fase 1: Planejamento e Estruturação (Semana 1)

### 1.1 Configuração do Ambiente ✅
- [x] Criar estrutura de pastas do projeto
- [x] Documentação inicial (README.md)
- [x] Criar roadmap detalhado
- [ ] Configurar Git e .gitignore
- [ ] Instalar CodeIgniter 3

### 1.2 Banco de Dados 🔄
- [ ] Criar diagrama ER (Entidade-Relacionamento)
- [ ] Criar script SQL de criação das tabelas
- [ ] Criar script SQL de dados iniciais (seeds)
- [ ] Documentar estrutura do banco

**Tabelas a criar:**
1. `usuarios` - Administradores
2. `clientes` - Clientes que solicitam orçamento
3. `categorias` - Categorias de produtos (Cortinas, Toldos, etc)
4. `produtos` - Produtos disponíveis
5. `colecoes` - Coleções de tecidos
6. `tecidos` - Tecidos e suas características
7. `cores` - Cores disponíveis por tecido
8. `precos` - Tabela de preços por dimensões
9. `extras` - Extras como Blackout
10. `orcamentos` - Orçamentos gerados
11. `orcamento_itens` - Itens de cada orçamento
12. `configuracoes` - Configurações do sistema

### 1.3 Arquitetura do Sistema
- [ ] Definir estrutura MVC
- [ ] Criar diagrama de fluxo do usuário
- [ ] Definir rotas da aplicação
- [ ] Planejar API endpoints

---

## 🔧 Fase 2: Back-End - Painel Administrativo (Semana 2)

### 2.1 Sistema de Autenticação
- [ ] Criar model `Usuario_model`
- [ ] Criar controller `Auth`
- [ ] Implementar login com sessões
- [ ] Implementar logout
- [ ] Criar middleware de autenticação
- [ ] Página de recuperação de senha
- [ ] Hash de senhas (bcrypt)

### 2.2 Dashboard Administrativo
- [ ] Integrar Tabler Dashboard template
- [ ] Criar layout base do admin
- [ ] Dashboard com estatísticas:
  - Total de orçamentos
  - Orçamentos por período
  - Produtos mais solicitados
  - Gráficos de conversão
- [ ] Menu de navegação
- [ ] Perfil do usuário

### 2.3 CRUD de Categorias
- [ ] Model `Categoria_model`
- [ ] Controller `Admin/Categorias`
- [ ] Views: listar, criar, editar, deletar
- [ ] Validações de formulário
- [ ] Upload de ícones de categoria

### 2.4 CRUD de Produtos
- [ ] Model `Produto_model`
- [ ] Controller `Admin/Produtos`
- [ ] Views: listar, criar, editar, deletar
- [ ] Upload de múltiplas imagens
- [ ] Galeria de imagens do produto
- [ ] Status ativo/inativo
- [ ] Ordenação de produtos

### 2.5 CRUD de Coleções e Tecidos
- [ ] Model `Colecao_model`
- [ ] Model `Tecido_model`
- [ ] Controller `Admin/Colecoes`
- [ ] Controller `Admin/Tecidos`
- [ ] Upload de imagens de tecidos
- [ ] Associar tecidos a coleções
- [ ] Cadastro de cores por tecido
- [ ] Características do tecido (blackout, translúcido, etc)

### 2.6 Gerenciamento de Preços
- [ ] Model `Preco_model`
- [ ] Controller `Admin/Precos`
- [ ] Tabela de preços por dimensões
- [ ] Preços por categoria de produto
- [ ] Preços de extras (Blackout, motorização, etc)
- [ ] Importação de preços via CSV/Excel
- [ ] Histórico de alterações de preços

### 2.7 Gerenciamento de Orçamentos
- [ ] Model `Orcamento_model`
- [ ] Controller `Admin/Orcamentos`
- [ ] Listagem de orçamentos:
  - Filtros (data, status, produto)
  - Busca por cliente
  - Paginação
- [ ] Visualização detalhada do orçamento
- [ ] Alteração de status
- [ ] Adicionar observações internas
- [ ] Exportação para PDF
- [ ] Exportação para Excel
- [ ] Envio de e-mail para cliente

### 2.8 Configurações do Sistema
- [ ] Model `Configuracao_model`
- [ ] Controller `Admin/Configuracoes`
- [ ] Configurações gerais:
  - Dados da empresa
  - WhatsApp para contato
  - E-mails de notificação
  - Vídeo de consultoria
  - Termos de uso
- [ ] Upload de logo
- [ ] Configurações de e-mail (SMTP)
- [ ] Configurações da API WhatsApp

---

## 🎨 Fase 3: Front-End - Formulário de Orçamento (Semana 3)

### 3.1 Layout Público
- [ ] Criar layout responsivo base
- [ ] Header com logo e menu
- [ ] Footer com informações de contato
- [ ] Integrar Bootstrap 4
- [ ] CSS customizado com variáveis
- [ ] Animações e transições suaves

### 3.2 Página Inicial
- [ ] Hero section atrativa
- [ ] Apresentação dos produtos
- [ ] Depoimentos de clientes
- [ ] Call-to-action para orçamento
- [ ] Seção de perguntas frequentes
- [ ] Otimização SEO

### 3.3 Formulário de Orçamento - Etapa 1: Dados do Cliente
- [ ] Controller `Orcamento`
- [ ] View do formulário
- [ ] Campos: Nome, E-mail, Telefone, WhatsApp
- [ ] Validação em tempo real (JavaScript)
- [ ] Máscaras de input (telefone, WhatsApp)
- [ ] Validação server-side

### 3.4 Formulário - Etapa 2: Tipo de Atendimento
- [ ] Opção: "Fazer meu próprio orçamento"
- [ ] Opção: "Preciso de consultoria personalizada"
- [ ] Se consultoria: exibir vídeo explicativo
- [ ] Modal com vídeo responsivo
- [ ] Botão para agendar consultoria

### 3.5 Formulário - Etapa 3: Seleção de Produto
- [ ] Grid de produtos com imagens
- [ ] Cards interativos
- [ ] Filtro por categoria
- [ ] Descrição resumida de cada produto
- [ ] Animação de seleção
- [ ] AJAX para carregar opções do produto

### 3.6 Formulário - Etapa 4: Personalização
**Para Cortinas de Tecido:**
- [ ] Seleção de coleção
- [ ] Galeria de tecidos com filtros
- [ ] Visualização ampliada de tecido
- [ ] Seleção de cor
- [ ] Paleta de cores interativa

**Para Cortina Rolô:**
- [ ] Seleção de tipo (blackout, translúcido, etc)
- [ ] Galeria de tecidos
- [ ] Seleção de cor

**Para Cortina Duplex VIP:**
- [ ] Explicação do produto
- [ ] Seleção de tecidos (dia e noite)
- [ ] Seleção de cores

**Para Toldos:**
- [ ] Tipo de toldo
- [ ] Material
- [ ] Cor/padrão

**Para Cortinas Motorizadas:**
- [ ] Tipo de cortina base
- [ ] Sistema de motorização
- [ ] Controle (remoto, app, automação)

### 3.7 Formulário - Etapa 5: Dimensões
- [ ] Seleção de largura (dropdown ou input)
- [ ] Seleção de altura (dropdown ou input)
- [ ] Opções predefinidas comuns
- [ ] Opção "Medida personalizada"
- [ ] Visualização da área (m²)
- [ ] Calculadora de preço em tempo real
- [ ] Tooltip com dicas de medição

### 3.8 Formulário - Etapa 6: Extras
- [ ] Checkbox para Blackout
- [ ] Outros acessórios disponíveis
- [ ] Cálculo automático de valor adicional
- [ ] Descrição de cada extra

### 3.9 Formulário - Etapa 7: Resumo e Confirmação
- [ ] Resumo completo do orçamento:
  - Dados do cliente
  - Produto selecionado
  - Tecido e cor
  - Dimensões
  - Extras
  - Valor total
- [ ] Botão "Adicionar mais produtos"
- [ ] Botão "Finalizar orçamento"
- [ ] Termos de aceite

### 3.10 Formulário - Etapa 8: Finalização
- [ ] Mensagem de sucesso
- [ ] Número do orçamento
- [ ] Botão para enviar ao WhatsApp
- [ ] Botão para baixar PDF
- [ ] Informações de próximos passos
- [ ] Tempo estimado de resposta

### 3.11 Interatividade e UX
- [ ] Barra de progresso do formulário
- [ ] Navegação entre etapas (voltar/avançar)
- [ ] Salvamento automático (localStorage)
- [ ] Loading states
- [ ] Mensagens de erro amigáveis
- [ ] Animações de transição
- [ ] Feedback visual de seleções
- [ ] Tooltips informativos

### 3.12 Responsividade
- [ ] Layout mobile-first
- [ ] Breakpoints otimizados:
  - Mobile: < 768px
  - Tablet: 768px - 1024px
  - Desktop: > 1024px
- [ ] Touch-friendly (botões grandes)
- [ ] Imagens responsivas
- [ ] Testes em dispositivos reais

---

## 🔌 Fase 4: Integrações (Semana 4)

### 4.1 WhatsApp API
- [ ] Pesquisar melhor solução (Twilio vs API Oficial)
- [ ] Criar conta e configurar credenciais
- [ ] Criar helper `Whatsapp_helper`
- [ ] Função para formatar mensagem
- [ ] Função para enviar mensagem
- [ ] Template de mensagem de orçamento
- [ ] Tratamento de erros
- [ ] Log de mensagens enviadas

### 4.2 Envio de E-mails
- [ ] Configurar biblioteca de e-mail do CI
- [ ] Templates de e-mail HTML:
  - Novo orçamento (para admin)
  - Confirmação (para cliente)
  - Recuperação de senha
- [ ] Função para envio assíncrono
- [ ] Fila de e-mails

### 4.3 Geração de PDF
- [ ] Integrar biblioteca (TCPDF ou mPDF)
- [ ] Template de orçamento em PDF
- [ ] Logo e identidade visual
- [ ] Informações completas do orçamento
- [ ] Termos e condições
- [ ] QR Code para WhatsApp

### 4.4 Notificações
- [ ] Notificações no painel admin
- [ ] Badge de novos orçamentos
- [ ] Som de notificação (opcional)
- [ ] E-mail para admin em novo orçamento
- [ ] Push notifications (futuro)

---

## 🎯 Fase 5: Otimizações (Semana 4)

### 5.1 Performance
- [ ] Minificação de CSS e JS
- [ ] Concatenação de arquivos
- [ ] Lazy loading de imagens
- [ ] Otimização de imagens (WebP)
- [ ] Cache de consultas ao banco
- [ ] Cache de views
- [ ] Compressão GZIP
- [ ] CDN para assets estáticos
- [ ] Análise com Google PageSpeed

### 5.2 SEO
- [ ] URLs amigáveis (.htaccess)
- [ ] Meta tags otimizadas
- [ ] Open Graph tags
- [ ] Twitter Cards
- [ ] Schema.org markup (LocalBusiness)
- [ ] Sitemap XML
- [ ] Robots.txt
- [ ] Google Analytics
- [ ] Google Search Console
- [ ] Breadcrumbs

### 5.3 Segurança
- [ ] Proteção CSRF (ativada no CI)
- [ ] Sanitização de inputs
- [ ] Prepared statements (Active Record)
- [ ] Validação server-side rigorosa
- [ ] Proteção XSS
- [ ] Headers de segurança:
  - X-Frame-Options
  - X-Content-Type-Options
  - X-XSS-Protection
  - Content-Security-Policy
- [ ] Rate limiting
- [ ] Proteção contra SQL Injection
- [ ] Logs de segurança
- [ ] Backup automático do banco

### 5.4 Acessibilidade (WCAG 2.1)
- [ ] ARIA labels em todos os elementos
- [ ] Navegação por teclado (tab order)
- [ ] Contraste adequado (mínimo 4.5:1)
- [ ] Textos alternativos em imagens
- [ ] Formulários com labels associados
- [ ] Mensagens de erro acessíveis
- [ ] Skip links
- [ ] Foco visível
- [ ] Teste com leitores de tela

### 5.5 Testes
- [ ] Testes unitários (PHPUnit)
- [ ] Testes de integração
- [ ] Testes de formulário
- [ ] Testes de cálculo de preços
- [ ] Testes de API
- [ ] Testes de responsividade
- [ ] Testes de cross-browser:
  - Chrome
  - Firefox
  - Safari
  - Edge
- [ ] Testes de performance
- [ ] Testes de segurança

---

## 🚀 Fase 6: Deploy e Lançamento

### 6.1 Preparação para Produção
- [ ] Configurar ambiente de produção
- [ ] Configurar variáveis de ambiente
- [ ] Desabilitar modo debug
- [ ] Configurar logs de erro
- [ ] Configurar SSL (HTTPS)
- [ ] Configurar domínio
- [ ] Configurar e-mail de produção

### 6.2 Deploy
- [ ] Criar backup do banco de dados
- [ ] Upload de arquivos via FTP/Git
- [ ] Importar banco de dados
- [ ] Configurar permissões de pastas
- [ ] Testar todas as funcionalidades
- [ ] Configurar cron jobs (se necessário)

### 6.3 Monitoramento
- [ ] Configurar monitoramento de uptime
- [ ] Configurar alertas de erro
- [ ] Google Analytics
- [ ] Hotjar ou similar (heatmaps)
- [ ] Logs de acesso

### 6.4 Documentação Final
- [ ] Manual do administrador
- [ ] Manual do usuário
- [ ] Documentação técnica
- [ ] Guia de manutenção
- [ ] Vídeos tutoriais

### 6.5 Treinamento
- [ ] Treinamento da equipe administrativa
- [ ] Documentação de processos
- [ ] FAQ interno

---

## 📊 Fase 7: Pós-Lançamento

### 7.1 Monitoramento e Ajustes (Semana 5-6)
- [ ] Monitorar métricas de uso
- [ ] Coletar feedback dos usuários
- [ ] Corrigir bugs reportados
- [ ] Ajustes de UX baseados em dados
- [ ] Otimizações de performance

### 7.2 Melhorias Futuras (Backlog)
- [ ] App mobile nativo (React Native)
- [ ] Integração com CRM
- [ ] Sistema de agendamento de visitas
- [ ] Chat online
- [ ] Realidade aumentada (visualizar cortina)
- [ ] Calculadora de tecido necessário
- [ ] Sistema de fidelidade
- [ ] Programa de indicação
- [ ] Blog integrado
- [ ] Área do cliente (acompanhar pedido)

---

## 📈 Métricas de Sucesso

### KPIs a Monitorar
- **Taxa de conversão:** % de visitantes que completam orçamento
- **Tempo médio de preenchimento:** Tempo para completar formulário
- **Taxa de abandono:** % que abandona o formulário
- **Produtos mais solicitados:** Ranking de produtos
- **Origem do tráfego:** De onde vêm os visitantes
- **Taxa de retorno:** Clientes que voltam ao site
- **Satisfação do usuário:** NPS ou pesquisa de satisfação

### Metas Iniciais (3 meses)
- 100+ orçamentos gerados
- Taxa de conversão > 15%
- Tempo médio de preenchimento < 5 minutos
- Taxa de abandono < 40%
- 80% dos orçamentos enviados via WhatsApp

---

## 🛠️ Ferramentas e Recursos

### Desenvolvimento
- **IDE:** VS Code / PhpStorm
- **Versionamento:** Git + GitHub/GitLab
- **Banco de dados:** MySQL Workbench / phpMyAdmin
- **API Testing:** Postman
- **Debug:** Xdebug

### Design
- **Prototipação:** Figma
- **Imagens:** Photoshop / GIMP
- **Ícones:** Font Awesome / Lucide
- **Paleta de cores:** Coolors.co

### Testes
- **Performance:** Google PageSpeed, GTmetrix
- **SEO:** Google Search Console, Ahrefs
- **Acessibilidade:** WAVE, axe DevTools
- **Cross-browser:** BrowserStack

### Monitoramento
- **Analytics:** Google Analytics 4
- **Uptime:** UptimeRobot
- **Erros:** Sentry
- **Heatmaps:** Hotjar

---

## 📞 Contato e Suporte

**Desenvolvedor:** Rafael Dias  
**Website:** https://doisr.com.br  
**E-mail:** contato@doisr.com.br

---

## 📝 Controle de Versões

| Versão | Data | Descrição |
|--------|------|-----------|
| 1.0.0 | 13/11/2024 | Roadmap inicial criado |

---

**Desenvolvido com ❤️ por Rafael Dias - doisr.com.br**

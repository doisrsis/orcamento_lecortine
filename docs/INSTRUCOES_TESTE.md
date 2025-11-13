# 📋 Instruções para Testes - Sistema Le Cortine

**Autor:** Rafael Dias - [doisr.com.br](https://doisr.com.br)  
**Data:** 13/11/2024 18:30

---

## 🚀 Como Executar os Dados de Teste

### 1️⃣ **Pré-requisitos**
- ✅ Banco de dados criado (EXECUTAR_ESTE.sql já executado)
- ✅ Tabelas criadas
- ✅ Usuário admin criado

### 2️⃣ **Executar Dados de Teste**

**Opção A - Via phpMyAdmin:**
1. Acesse: `http://localhost/phpmyadmin`
2. Selecione o banco: `cecriativocom_lecortine_orc`
3. Clique na aba **SQL**
4. Abra o arquivo: `docs/DADOS_TESTE.sql`
5. Copie todo o conteúdo
6. Cole na área de texto
7. Clique em **Executar**

**Opção B - Via Linha de Comando:**
```bash
mysql -u cecriativocom_orc_lecortine -p cecriativocom_lecortine_orc < docs/DADOS_TESTE.sql
```
Senha: `c$uZaCQh{%Dh7kc=2025`

---

## 📊 Dados Inseridos

### ✅ **5 Categorias**
- Cortinas
- Persianas
- Toldos
- Papel de Parede
- Acessórios

### ✅ **14 Produtos**
- 5 Cortinas (Rolô Blackout, Romana, Painel, Voil, Dupla)
- 3 Persianas (Horizontal Alumínio, Vertical PVC, Horizontal Madeira)
- 2 Toldos (Manual, Motorizado)
- 2 Papéis de Parede (Vinílico, 3D)
- 2 Acessórios (Varão, Trilho)

### ✅ **5 Coleções de Tecidos**
- Coleção Premium
- Coleção Blackout
- Coleção Translúcida
- Coleção Sustentável
- Coleção Infantil

### ✅ **12 Tecidos**
- 3 Premium (Linho Rústico, Seda Pura, Veludo)
- 2 Blackout (Total, Soft)
- 3 Translúcidos (Voil, Linho, Tela Solar)
- 2 Sustentáveis (Algodão Orgânico, Linho Ecológico)
- 2 Infantis (Estampado, Blackout Kids)

### ✅ **48 Cores**
- 4 cores para cada tecido
- Códigos hexadecimais definidos
- Ordem configurada

### ✅ **5 Clientes**
- Maria Silva Santos
- João Pedro Oliveira
- Ana Carolina Souza
- Carlos Eduardo Lima
- Fernanda Costa Alves

### ✅ **7 Extras**
- Blackout
- Forro Térmico
- Motorização
- Sensor de Luz
- Instalação Profissional
- Medição no Local
- Garantia Estendida

---

## 🧪 Roteiro de Testes

### 1. **Login no Sistema**
```
URL: http://localhost/orcamento/admin
Email: admin@lecortine.com.br
Senha: admin123
```

### 2. **Dashboard**
- ✅ Visualizar estatísticas
- ✅ Ver gráficos (podem estar vazios ainda)
- ✅ Verificar cards de resumo

### 3. **Categorias**
```
URL: http://localhost/orcamento/admin/categorias
```
- ✅ Listar 5 categorias
- ✅ Editar uma categoria
- ✅ Testar toggle status
- ✅ Criar nova categoria
- ✅ Fazer upload de imagem

### 4. **Produtos**
```
URL: http://localhost/orcamento/admin/produtos
```
- ✅ Listar 14 produtos
- ✅ Filtrar por categoria
- ✅ Filtrar por status
- ✅ Buscar por nome
- ✅ Editar produto
- ✅ Adicionar imagens à galeria
- ✅ Reordenar galeria (drag & drop)
- ✅ Deletar imagem da galeria
- ✅ Toggle status
- ✅ Toggle destaque

### 5. **Coleções**
```
URL: http://localhost/orcamento/admin/colecoes
```
- ✅ Listar 5 coleções
- ✅ Ver contador de tecidos
- ✅ Editar coleção
- ✅ Criar nova coleção
- ✅ Upload de imagem
- ✅ Toggle status

### 6. **Tecidos**
```
URL: http://localhost/orcamento/admin/tecidos
```
- ✅ Listar 12 tecidos
- ✅ Filtrar por coleção
- ✅ Filtrar por status
- ✅ Buscar por nome/código
- ✅ Editar tecido
- ✅ Ver cores do tecido (4 por tecido)
- ✅ Adicionar nova cor (modal)
- ✅ Reordenar cores (drag & drop)
- ✅ Deletar cor
- ✅ Toggle status

---

## 🎯 Checklist de Funcionalidades

### ✅ **Autenticação**
- [ ] Login
- [ ] Logout
- [ ] Sessão persistente
- [ ] Redirecionamento após login

### ✅ **Dashboard**
- [ ] Cards de estatísticas
- [ ] Gráficos (podem estar vazios)
- [ ] Links funcionando

### ✅ **CRUDs**
- [ ] Listar registros
- [ ] Criar novo
- [ ] Editar existente
- [ ] Deletar (com confirmação)
- [ ] Filtros de busca
- [ ] Toggle status (AJAX)
- [ ] Upload de imagens
- [ ] Preview de imagens

### ✅ **Recursos Avançados**
- [ ] Drag & drop (reordenação)
- [ ] Galeria de imagens
- [ ] Modal de adicionar cor
- [ ] Validações frontend
- [ ] Validações backend
- [ ] Mensagens flash (sucesso/erro)
- [ ] SweetAlert2 (confirmações)

### ✅ **Responsividade**
- [ ] Desktop (1920px)
- [ ] Laptop (1366px)
- [ ] Tablet (768px)
- [ ] Mobile (375px)

---

## 🐛 Possíveis Problemas

### **Erro: "Tabela não encontrada"**
**Solução:** Execute primeiro o `EXECUTAR_ESTE.sql`

### **Erro: "Duplicate entry"**
**Solução:** Execute o script de limpeza no início do `DADOS_TESTE.sql`

### **Imagens não aparecem**
**Solução:** 
1. Verifique se a pasta `uploads/` existe
2. Verifique permissões (777 ou 755)
3. Faça upload manual de imagens

### **Erro 404 nas URLs**
**Solução:** 
1. Verifique se o `.htaccess` existe
2. Verifique se `mod_rewrite` está ativo no Apache
3. Reinicie o Apache

---

## 📝 Próximos Passos Após Testes

1. ✅ Testar todos os CRUDs
2. ✅ Fazer upload de imagens reais
3. ✅ Ajustar dados conforme necessário
4. ⏳ Desenvolver formulário público
5. ⏳ Implementar gerenciamento de orçamentos
6. ⏳ Adicionar integrações (WhatsApp, Email, PDF)

---

## 💡 Dicas

- **Limpar cache:** `Ctrl + F5` no navegador
- **Ver erros:** Ativar `display_errors` no PHP
- **Debug:** Verificar `application/logs/` do CodeIgniter
- **Banco:** Use phpMyAdmin para verificar dados

---

## 📞 Suporte

Qualquer dúvida ou problema, entre em contato:
- **Email:** contato@doisr.com.br
- **Site:** https://doisr.com.br

---

**Sistema desenvolvido com ❤️ por Rafael Dias**

# Instruções - Novo Formulário de Orçamento Le Cortine

**Autor:** Rafael Dias - doisr.com.br  
**Data:** 13/11/2024 20:45

---

## 📋 O QUE FOI FEITO

### 1. SQL com Dados Oficiais
✅ Criado `docs/DADOS_LECORTINE_OFICIAL.sql` com:
- 5 produtos (3 com formulário, 2 para consultoria)
- 6 tecidos/coleções
- 42 cores no total
- Preços conforme tabelas oficiais
- 6 extras (4 blackouts + motorização + instalação)

### 2. Controller Orcamento.php Recriado
✅ Nova estrutura com 8 etapas + resumo + consultoria:
1. **Etapa 1:** Dados do Cliente
2. **Etapa 2:** Tipo de Atendimento (Orçamento ou Consultoria)
3. **Etapa 3:** Escolha do Produto
4. **Etapa 4:** Tecido e Cor (AJAX para cores)
5. **Etapa 5:** Largura (faixas: até 2m, 3m, 4m, 5m, >5m)
6. **Etapa 6:** Altura (até 2,80m ou >2,80m)
7. **Etapa 7:** Blackout Adicional (só Cortina em Tecido)
8. **Etapa 8:** Endereço para Frete
9. **Resumo:** Cálculo + Envio WhatsApp
10. **Consultoria:** Página para casos especiais

### 3. Views Criadas/Atualizadas
✅ Todas as 10 views do formulário:
- `etapa1.php` - Atualizada (8 etapas na barra)
- `etapa2.php` - Nova (Tipo Atendimento)
- `etapa3.php` - Nova (Produtos)
- `etapa4.php` - Nova (Tecido/Cor com AJAX)
- `etapa5.php` - Nova (Largura com faixas)
- `etapa6.php` - Nova (Altura)
- `etapa7.php` - Nova (Blackout)
- `etapa8.php` - Nova (Endereço com ViaCEP)
- `resumo.php` - Nova (Resumo completo)
- `consultoria.php` - Nova (Consultoria personalizada)

### 4. Rotas Atualizadas
✅ Adicionadas rotas para etapa7, etapa8, resumo e consultoria

### 5. Models Atualizados
✅ Adicionado método `get_preco_tecido()` no Preco_model

---

## 🚀 COMO USAR

### Passo 1: Executar SQL
```sql
-- No phpMyAdmin, executar:
docs/DADOS_LECORTINE_OFICIAL.sql
```

### Passo 2: Configurar WhatsApp
Editar o número do WhatsApp no controller:
```php
// Linha 433 do Orcamento.php
$whatsapp_numero = '5511999999999'; // Alterar para número real
```

### Passo 3: Testar Formulário
Acessar: `http://localhost/orcamento/orcamento`

---

## 📊 FLUXO DO FORMULÁRIO

### Produtos com Formulário Completo:
1. **Cortina em Tecido** (ID: 1)
   - Preço por faixa de largura (até 2,80m altura)
   - Opção de blackout adicional
   - Valores: R$ 442 a R$ 1.192

2. **Cortina Rolô** (ID: 2)
   - Preço por m²
   - 3 tipos: Translúcida (R$ 215/m²), Blackout (R$ 255/m²), Tela Solar (R$ 265/m²)

3. **Duplex VIP** (ID: 3)
   - Preço por m²: R$ 299/m²

### Produtos que Direcionam para Consultoria:
4. **Toldos** (ID: 4)
5. **Cortinas Motorizadas** (ID: 5)

### Redirecionamentos Automáticos para Consultoria:
- Largura > 5,00m
- Altura > 2,80m
- Produtos 4 e 5

---

## 💰 CÁLCULO DE PREÇOS

### Cortina em Tecido (Prega Victoria):
```
Largura até 2,00m = R$ 442,00
Largura até 3,00m = R$ 585,00
Largura até 4,00m = R$ 824,00
Largura até 5,00m = R$ 1.192,00

+ Blackout (opcional):
  até 2m = +R$ 250,00
  até 3m = +R$ 300,00
  até 4m = +R$ 360,00
  até 5m = +R$ 395,00
```

### Cortina Rolô e Duplex:
```
Valor = Largura × Altura × Preço/m²
```

---

## 🎨 TECIDOS E CORES

### Cortina em Tecido:
- **Linho Rústico:** 6 cores
- **Linen Light:** 6 cores

### Cortina Rolô:
- **Translúcida:** 8 cores
- **Blackout:** 8 cores
- **Tela Solar:** 6 cores

### Duplex VIP:
- **Translúcida:** 8 cores

---

## 📱 INTEGRAÇÃO WHATSAPP

Ao finalizar, o sistema:
1. Salva orçamento no banco
2. Gera número único
3. Formata mensagem com todos os dados
4. Redireciona para WhatsApp da empresa

Mensagem inclui:
- Dados do cliente
- Produto, tecido e cor escolhidos
- Dimensões
- Valor calculado
- Endereço completo

---

## ⚠️ OBSERVAÇÕES IMPORTANTES

1. **CEP:** Integrado com ViaCEP para preenchimento automático
2. **Validações:** Todas as etapas têm validação
3. **Sessão:** Dados mantidos em sessão durante todo o fluxo
4. **Responsivo:** Design adaptado para PC/Tablet/Mobile
5. **SEO:** Meta tags e estrutura otimizada

---

## 🔧 PRÓXIMAS MELHORIAS SUGERIDAS

- [ ] Adicionar cálculo de frete automático
- [ ] Sistema de cupons de desconto
- [ ] Galeria de fotos dos tecidos
- [ ] Visualizador 3D de cortinas
- [ ] Painel para acompanhamento do orçamento
- [ ] E-mail automático de confirmação
- [ ] Integração com sistema de pagamento

---

## 📞 SUPORTE

Para dúvidas ou ajustes:
- **Desenvolvedor:** Rafael Dias
- **Site:** doisr.com.br
- **Data:** 13/11/2024

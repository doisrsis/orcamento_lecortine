<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-form text-center">
                <div class="mb-4">
                    <i class="ti ti-users" style="font-size: 80px; color: var(--primary-color);"></i>
                </div>
                
                <h1 class="mb-3">Consultoria Personalizada</h1>
                <p class="lead text-muted mb-4">
                    Este produto ou dimensão requer atendimento especializado
                </p>

                <div class="card mb-4" style="border: 2px solid #e0e0e0; border-radius: 15px;">
                    <div class="card-body p-4">
                        <h4 class="mb-3">Por que consultoria?</h4>
                        <div class="text-start">
                            <p><i class="ti ti-check text-success me-2"></i> Projetos com dimensões especiais (acima de 5m ou 2,80m)</p>
                            <p><i class="ti ti-check text-success me-2"></i> Produtos que exigem análise técnica detalhada</p>
                            <p><i class="ti ti-check text-success me-2"></i> Soluções personalizadas para seu ambiente</p>
                            <p><i class="ti ti-check text-success me-2"></i> Atendimento VIP com especialista</p>
                        </div>
                    </div>
                </div>

                <div class="card mb-4" style="background: linear-gradient(135deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05)); border: none;">
                    <div class="card-body p-4">
                        <h4 class="mb-3">Seus Dados</h4>
                        <div class="row text-start">
                            <div class="col-md-6">
                                <p><strong>Nome:</strong> <?= $dados['nome'] ?></p>
                                <p><strong>E-mail:</strong> <?= $dados['email'] ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Telefone:</strong> <?= $dados['telefone'] ?></p>
                                <p><strong>WhatsApp:</strong> <?= $dados['whatsapp'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-success">
                    <i class="ti ti-info-circle"></i>
                    <strong>Próximo Passo:</strong> Nossa equipe entrará em contato via WhatsApp para entender melhor suas necessidades e apresentar a melhor solução!
                </div>

                <div class="d-grid gap-3">
                    <a href="https://api.whatsapp.com/send?phone=5511999999999&text=Olá! Gostaria de uma consultoria personalizada. Meu nome é <?= urlencode($dados['nome']) ?>" 
                       class="btn btn-success btn-lg" target="_blank">
                        <i class="ti ti-brand-whatsapp me-2"></i> Falar com Especialista
                    </a>
                    
                    <a href="<?= base_url('orcamento') ?>" class="btn btn-outline-secondary btn-lg">
                        <i class="ti ti-arrow-left me-2"></i> Fazer Novo Orçamento
                    </a>
                </div>

                <div class="mt-4">
                    <p class="text-muted small">
                        <i class="ti ti-clock"></i> Horário de atendimento: Segunda a Sexta, 9h às 18h
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

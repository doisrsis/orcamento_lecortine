<div class="progress-container text-center">
    <div class="py-5">
        <div class="mb-4">
            <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #28a745, #20c997); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3);">
                <i class="ti ti-check" style="font-size: 60px; color: #fff;"></i>
            </div>
        </div>

        <h1 class="mb-3" style="color: var(--dark-color); font-weight: 700;">Orçamento Enviado com Sucesso!</h1>
        
        <?php if($numero): ?>
            <div class="alert alert-info d-inline-block">
                <h4 class="mb-0">
                    <i class="ti ti-file-text"></i>
                    Número do Orçamento: <strong><?= $numero ?></strong>
                </h4>
            </div>
        <?php endif; ?>

        <p class="lead text-muted mb-4">
            Recebemos sua solicitação de orçamento!<br>
            Nossa equipe entrará em contato em breve pelo WhatsApp ou e-mail.
        </p>

        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <div class="card" style="border: 2px solid #e0e0e0; border-radius: 15px;">
                    <div class="card-body">
                        <h5 class="card-title"><i class="ti ti-clock"></i> Próximos Passos</h5>
                        <ul class="list-unstyled text-start mb-0">
                            <li class="mb-2">
                                <i class="ti ti-check text-success"></i>
                                Você receberá uma confirmação por e-mail
                            </li>
                            <li class="mb-2">
                                <i class="ti ti-check text-success"></i>
                                Nossa equipe analisará seu pedido
                            </li>
                            <li class="mb-2">
                                <i class="ti ti-check text-success"></i>
                                Entraremos em contato via WhatsApp para detalhes
                            </li>
                            <li class="mb-0">
                                <i class="ti ti-check text-success"></i>
                                Você receberá o orçamento final em até 24 horas
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <a href="<?= base_url() ?>" class="btn btn-primary btn-lg me-2">
                <i class="ti ti-home me-2"></i> Voltar ao Início
            </a>
            <a href="<?= base_url('orcamento') ?>" class="btn btn-outline-primary btn-lg">
                <i class="ti ti-plus me-2"></i> Novo Orçamento
            </a>
        </div>

        <div class="alert alert-light">
            <p class="mb-2"><strong>Dúvidas?</strong></p>
            <p class="mb-0">
                <i class="ti ti-phone"></i> (11) 99999-9999 |
                <i class="ti ti-mail"></i> contato@lecortine.com.br
            </p>
        </div>
    </div>
</div>

<script>
// Confete de celebração
$(document).ready(function() {
    Swal.fire({
        icon: 'success',
        title: 'Orçamento Enviado!',
        text: 'Entraremos em contato em breve.',
        confirmButtonText: 'OK',
        confirmButtonColor: '#8B4513'
    });
});
</script>

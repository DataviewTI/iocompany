<html lang="pt-br">
<body style="font-size: 18px;">
    <h3 style="font-weight: bold">Clique no link abaixo para prosseguir com o pagamento do seu plano empresarial Palmjob
        @if ($data['payment_method'] == null)
            <a href="{{ $data['wirecardData']['_links']['checkout']['payCheckout']['redirectHref'] }}">
                {{ $data['wirecardData']['_links']['checkout']['payCheckout']['redirectHref'] }}
            </a> 
        @elseif($data['payment_method'] == 'CREDIT_CARD')
            <a href="{{ $data['wirecardData']['_links']['checkout']['payCreditCard']['redirectHref'] }}">
                {{ $data['wirecardData']['_links']['checkout']['payCreditCard']['redirectHref'] }}
            </a> 
        @elseif($data['payment_method'] == 'BOLETO')
            <a href="{{ $data['wirecardData']['_links']['checkout']['payBoleto']['redirectHref'] }}">
                {{ $data['wirecardData']['_links']['checkout']['payBoleto']['redirectHref'] }}
            </a> 
        @endif
    </h3>
</body>
</html>
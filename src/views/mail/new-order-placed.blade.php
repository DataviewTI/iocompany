<html lang="pt-br">
<body style="font-size: 18px;">
    <h3 style="font-weight: bold">Clique no link abaixo para prosseguir com o pagamento do seu plano empresarial Palmjob
        <a href="{{ $order['wirecard_data']->_links->checkout->payCheckout->redirectHref }}">
            {{ $order['wirecard_data']->_links->checkout->payCheckout->redirectHref }}
        </a> 
    </h3>
</body>
</html>
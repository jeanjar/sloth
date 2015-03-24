Sloth
=====

[![Build Status](https://travis-ci.org/StefanYohansson/sloth.svg?branch=master)](https://travis-ci.org/StefanYohansson/sloth) [![Code Climate](https://codeclimate.com/github/StefanYohansson/sloth/badges/gpa.svg)](https://codeclimate.com/github/StefanYohansson/sloth)
[![Test Coverage](https://codeclimate.com/github/StefanYohansson/sloth/badges/coverage.svg)](https://codeclimate.com/github/StefanYohansson/sloth)

Micro sistema de geração de arquivos remessa, retorno e boletos.

Instalação
-----
você pode baixar manualmente o código e incluir no seu código ou usar o composer (**recomendo o uso do composer**):
``` json
{ 
    require: {
        "syohansson/sloth": "dev-master"
    }
}
```
[Packagist](https://packagist.org/packages/syohansson/sloth)

Uso
-----

Tanto boleto quanto retorno variam de uma especificação do banco chamada **Carteira**. Então você tem uma **Cobranca**, que é feita através de um **Banco**, selecionado o serviço prestado por esse a você através de uma **Carteira**, e por fim, essa **Cobrança** se faz por meio de um **Boleto** e é retornada a você por meio de um **Retorno**.

Então temos que tudo gira em torno da Carteira que o banco escolher para você. Se você quer gerar um boleto do Banco Caixa Econômica Federal (CEF) com a carteira SIGCB, basta invocar a classe **Sloth_Carteira_CEFCarteiraSIGCB**, essa por sua vez, extende de uma classe abstrata (Carteira) com duas funções principais: **gerarBoleto**, **processarRetorno**


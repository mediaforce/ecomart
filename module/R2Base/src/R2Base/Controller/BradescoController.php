<?php

/**
 * PHP Boleto ZF2 - Versão Beta 
 * 
 * Este arquivo está disponível sob a Licença GPL disponível pela Web
 * em http://pt.wikipedia.org/wiki/GNU_General_Public_License 
 * Você deve ter recebido uma cópia da GNU Public License junto com
 * este pacote; se não, escreva para: 
 * 
 * Free Software Foundation, Inc.
 * 59 Temple Place - Suite 330
 * Boston, MA 02111-1307, USA.
 * 
 * Originado do Projeto BoletoPhp: http://www.boletophp.com.br 
 * 
 * Adaptação ao Zend Framework 2: João G. Zanon Jr. <jot@jot.com.br>
 * 
 */

namespace PhpBoletoZf2\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DOMPDFModule\View\Model\PdfModel;
use PhpBoletoZf2\Model\BoletoBradesco;
use PhpBoletoZf2\Model\Banco;
use PhpBoletoZf2\Model\Sacado;
use PhpBoletoZf2\Model\Cedente;

class BradescoController extends AbstractActionController
{

    public function indexAction()
    {
        $dias_de_prazo_para_pagamento = 5;
        $taxa_boleto = 0;
        $data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006";
        $valor_cobrado = "2950,00"; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
        $valor_cobrado = str_replace(",", ".",$valor_cobrado);
        $valor_boleto = number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

        $dadosboleto["nosso_numero"] = "75896452";  // Nosso numero sem o DV - REGRA: Máximo de 11 caracteres!
        $dadosboleto["numero_documento"] = $dadosboleto["nosso_numero"];    // Num do pedido ou do documento = Nosso numero
        $dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
        $dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
        $dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
        $dadosboleto["valor"] = $valor_boleto;   // Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
        // DADOS DO SEU CLIENTE
        $dadosboleto["sacado"] = "Nome do seu CliSDASDASDAente";
        $dadosboleto["endereco1"] = "Endereço do seu Cliente";
        $dadosboleto["endereco2"] = "Cidade - Estado -  CEP: 00000-000";
        // INFORMACOES PARA O CLIENTE
        $dadosboleto["demonstrativo1"] = "Pagamento de Compra na Loja Virtual Ecomart";
        $dadosboleto["demonstrativo2"] = "Aquisição de produtos na loja virtual da Ecomart em R$ ".number_format($taxa_boleto, 2, ',', '');
        $dadosboleto["demonstrativo3"] = "BoletoPhp - http://www.boletophp.com.br";
        $dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
        $dadosboleto["instrucoes2"] = "- Receber até 10 dias após o vencimento";
        $dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: xxxx@xxxx.com.br";
        $dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema Projeto BoletoPhp - www.boletophp.com.br";
        // DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
        $dadosboleto["quantidade"] = "001";
        $dadosboleto["valor_unitario"] = $valor_boleto;
        $dadosboleto["aceite"] = "";
        $dadosboleto["especie"] = "R$";
        $dadosboleto["especie_doc"] = "DS";

        // ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //
        // DADOS DA SUA CONTA - Bradesco
        $dadosboleto["agencia"] = "1100"; // Num da agencia, sem digito
        $dadosboleto["agencia_dv"] = "0"; // Digito do Num da agencia
        $dadosboleto["conta"] = "0102003";  // Num da conta, sem digito
        $dadosboleto["conta_dv"] = "4";     // Digito do Num da conta
        // DADOS PERSONALIZADOS - Bradesco
        $dadosboleto["conta_cedente"] = "0102003"; // ContaCedente do Cliente, sem digito (Somente Números)
        $dadosboleto["conta_cedente_dv"] = "4"; // Digito da ContaCedente do Cliente
        $dadosboleto["carteira"] = "06";  // Código da Carteira: pode ser 06 ou 03
        // SEUS DADOS
        $dadosboleto["identificacao"] = "Loja Virtual Ecomart";
        $dadosboleto["cpf_cnpj"] = "";
        $dadosboleto["endereco"] = "www.ecomart.com.br";
        $dadosboleto["cidade_uf"] = "São Paulo / SP";
        $dadosboleto["cedente"] = "Coloque a Razão Social da sua empresa aqui";

        /**
         * Definindo o layout padrão do boleto
         */
        $this->layout('layout/boleto');

        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());

            $data = $form->getData();

            $boleto = new BoletoBradesco($data);
            $sacado = new Sacado($data);
            $cedente = new Cedente($data);

            $bradesco = $this->getServiceLocator()
                        ->get('Boleto\Bradesco');
            $bradesco->setSacado($sacado)
                    ->setBoleto($boleto)
                    ->setCedente(cedente);
            
            $dados = $bradesco->prepare();

        }

        //TEMP

        $data = $dadosboleto;

        $boleto = new BoletoBradesco($data);
        $sacado = new Sacado($data);
        $cedente = new Cedente($data);

        $bradesco = $this->getServiceLocator()
                    ->get('Boleto\Bradesco');
        $bradesco->setSacado($sacado)
                    ->setCedente($cedente)
                    ->setBoleto($boleto);
        
        $dados = $bradesco->prepare();

        switch ($this->params()->fromRoute('format')) {
            case 'html' :
            default :
                return new ViewModel(array('dados' => $dados));
                break;
            case 'pdf' :
                $pdf = new PdfModel();
                $pdf->setOption('filename', 'boleto-bradesco');
                $pdf->setOption('enable_remote', true);
                $pdf->setOption('paperSize', 'a4'); // Defaults to "8x11" 
                $pdf->setVariables(array('boleto' => $boleto));
                return $pdf;

                break;
        }
    }

    public function demoAction()
    {
        $form = new \PhpBoletoZf2\Form\Boleto;

        return new ViewModel(array('form' => $form));
    }

}

<?php

$params = array(
    'estabelecimento'=>$Data['filters']->estabelecimento,
    'datainicial'=>$Data['filters']->datainicial,
    'datafinal'=>$Data['filters']->datafinal,
    'centro'=>$Data['filters']->centro
);


$lista_completa = [];

$result = $this->ExecQuery("call bi_estoque_saldos2(:estabelecimento, :datainicial, :datafinal, :centro)",
    [
        'estabelecimento'=>$params['estabelecimento'],
        'datainicial'=>$params['datainicial'],
        'datafinal'=>$params['datafinal'],
        'centro'=> $params['centro'] == '99999' ? null : $params['centro']
    ]
);

$lista_completa = array_merge($lista_completa, $result['lista']);

$lista_final = [];

foreach ($lista_completa as $key => $value){


    if(!isset($lista_final[$value['codigo']])){

        $lista_final[$value['codigo']]=$value;

    }else{


        $lista_final[$value['codigo']]['saldo_anterior'] += $value['saldo_anterior'];
        $lista_final[$value['codigo']]['balanco_qtd'] += $value['balanco_qtd'];
        $lista_final[$value['codigo']]['balanco_dif'] += $value['balanco_dif'];
        $lista_final[$value['codigo']]['entradas'] += $value['entradas'];
        $lista_final[$value['codigo']]['saidas_total'] += $value['saidas_total'];
        $lista_final[$value['codigo']]['saidas_vendas'] += $value['saidas_vendas'];
        $lista_final[$value['codigo']]['saidas_operacao'] += $value['saidas_operacao'];
        $lista_final[$value['codigo']]['saldo_atual'] += $value['saldo_atual'];
        $lista_final[$value['codigo']]['ptotal'] += $value['ptotal'];

    }

    $lista_final[$value['codigo']]['saldo_anterior'] = number_format($lista_final[$value['codigo']]['saldo_anterior'], 3, '.', '');

    $lista_final[$value['codigo']]['balanco_qtd'] = number_format($lista_final[$value['codigo']]['balanco_qtd'], 3, '.', '');

    $lista_final[$value['codigo']]['balanco_dif'] = number_format($lista_final[$value['codigo']]['balanco_dif'], 3, '.', '');
    $lista_final[$value['codigo']]['entradas'] = number_format($lista_final[$value['codigo']]['entradas'], 3, '.', '');

    $lista_final[$value['codigo']]['saidas_total'] = number_format($lista_final[$value['codigo']]['saidas_total'], 3, '.', '');
    $lista_final[$value['codigo']]['saidas_vendas'] = number_format($lista_final[$value['codigo']]['saidas_vendas'], 3, '.', '');
    $lista_final[$value['codigo']]['saidas_operacao'] = number_format($lista_final[$value['codigo']]['saidas_operacao'], 3, '.', '');

    $lista_final[$value['codigo']]['saldo_atual'] = number_format($lista_final[$value['codigo']]['saldo_atual'], 3, '.', '');

    $lista_final[$value['codigo']]['ptotal'] = number_format($lista_final[$value['codigo']]['ptotal'], 2, '.', '');


}

foreach ($lista_final as $key => &$value) {
    /*
    $value['saldo_anterior'] = str_replace('.', ',', $value['saldo_anterior']);
    */
    $value['saldo_anterior'] = $value['saldo_anterior'];
    $value['balanco_qtd'] = $value['balanco_qtd'];
    $value['balanco_dif'] = $value['balanco_dif'];
    $value['entradas'] = $value['entradas'];
    $value['saidas_total'] = $value['saidas_total'];
    $value['saidas_vendas'] = $value['saidas_vendas'];
    $value['saidas_operacao'] = $value['saidas_operacao'];
    $value['saldo_atual'] = $value['saldo_atual'];
    $value['pcusto'] = $value['pcusto'];
    $value['ptotal'] = $value['ptotal'];
}


$lista_final = array_values($lista_final);

/* https://menew.atlassian.net/browse/MAS-785
adicionado a verificação da data*/
$dateIni = new DateTime($params['datainicial']);
$dateFin = new DateTime($params['datafinal']);
if($dateIni > $dateFin ){

    return ['lista' => [], 'mensagem' => "O período selecionado está incorreto. A data de início não pode ser maior que a data final."];
}

return array('nr'=>count($lista_final), 'lista'=>$lista_final);





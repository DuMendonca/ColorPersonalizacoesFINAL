<?php
include("mpdf/mpdf.php");
$relatorio = $_POST['html'];
$retorno = $_POST['linhas'];
$mpdf = new mPDF();
$mpdf -> SetDisplayMode("fullpage");

if($retorno>0){
  $mpdf -> WriteHTML("
    <style>
    h1{
    font-family: 'Bree Serif', serif;
    font-size:35px;
    color: #B85B14;
    padding-top: 10px;
    text-align:center;
    }
    div{
      border-radius:5px;
      border:2px solid grey;
    }
    table{
      width: 100%;
      text-align: center;
      color:black;
      font-family: 'Bree Serif', serif;
    }
    tr{
      background-color: #D4E4F7;
      border:1px solid grey;
    }
    th{
      background-color: #7c92ad;
      color: #484848;
      border:1px solid grey;
      border-radius:2px;
    }
    .contatosTR{
        background-color: transparent;
        border:0px;
    }
    </style>
    <h1>Relatório de Ordem de Serviço</h1>
    <div>
      <table>
        <tr>
          <th>Código</th>
          <th>Cliente</th>
          <th>Valor Total</th>
          <th>Funcionário responsável</th>
          <th>Produtos</th>
        </tr>
        ".$relatorio."
      </table>
    </div>
  ");

  $footer="
    <table>
    <tr class='contatosTR'>
    <th class='contatosTR'><img height='120px' src='../imgs/logoCores.png' title='logo'></th>
    </tr>
    <tr class='contatosTR'>
      <td><img height='50px' src='../imgs/logoEscrito.png' title='logo escrita'></td>
    </tr>
    <tr class='contatosTR'>
    <td class='contatosTR'>Endereço:Rua Arno Waldemar Dohler,957 - Zona Industrial Norte
Joinville - SC , 89218-155 </td>
    </tr>
    <tr class='contatosTR'>
    <td >Telefone:(47) XXXX-XXXX</td>
    </tr>
    <tr class='contatosTR'>
    <td>E-mail:colorPersonaliza2019@gmail.com</td>
    </tr>
    </table>
  ";
}else{
  $mpdf -> WriteHTML("
    <style>
    h1{
    font-family: 'Bree Serif', serif;
    font-size:35px;
    color: #B85B14;
    padding-top: 10px;
    text-align:center;
    }
    div{
      border-radius:5px;
      border:2px solid grey;
    }
    table{
      width: 100%;
      text-align: center;
      color:black;
      font-family: 'Bree Serif', serif;
    }
    tr{
      background-color: #D4E4F7;
      border:1px solid grey;
    }
    th{
      background-color: #7c92ad;
      color: #484848;
      border:1px solid grey;
      border-radius:2px;
    }
    td{
      font-size: 15px;
      padding: auto;
    }
    .contatosTR{
        background-color: transparent;
        border:0px;
    }
    </style>
    <h1>Relatório de Ordem de Serviço</h1>
    <div>
      <table>
        <tr>
          <th>Código</th>
          <th>Cliente</th>
          <th>Valor Total</th>
          <th>Funcionário responsável</th>
          <th>Produtos</th>
        </tr>
        <tr>
        <td colspan='5'>Nenhum Ordem de Serviço encontrado !</td>
        </tr>
      </table>
    </div>
  ");

  $footer="
    <table>
    <tr class='contatosTR'>
    <th class='contatosTR'><img height='120px' src='../imgs/logoCores.png' title='logo'></th>
    </tr>
    <tr class='contatosTR'>
      <td><img height='50px' src='../imgs/logoEscrito.png' title='logo escrita'></td>
    </tr>
    <tr class='contatosTR'>
    <td class='contatosTR'>Endereço:Rua Arno Waldemar Dohler,957 - Zona Industrial Norte
Joinville - SC , 89218-155 </td>
    </tr>
    <tr class='contatosTR'>
    <td >Telefone:(47) XXXX-XXXX</td>
    </tr>
    <tr class='contatosTR'>
    <td>E-mail:colorPersonaliza2019@gmail.com</td>
    </tr>
    </table>
  ";
}
$mpdf->SetHTMLFooter($footer);
$mpdf -> Output();
exit();
 ?>

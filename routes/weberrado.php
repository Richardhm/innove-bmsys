<?php

use App\Models\Comissoes;
use App\Models\Contrato;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/login');


Route::middleware('auth')->prefix("admin")->group(function(){

    Route::get("/info",function(){
       print_r(phpinfo());
    });

//    Route::get("/cache-config",function(){
//        \Artisan::call('config:cache');
//        return 'Configurations cached successfully.';
//    });

    Route::get("/reposicionar",function(){
        $comissoes = \Illuminate\Support\Facades\DB::select("
              select
                  *
              from comissoes_corretores_lancadas where
              comissoes_id IN(select id from comissoes where contrato_id IN(select id from contratos where plano_id = 1 and financeiro_id != 12))
              and status_financeiro = 1
        ");
        foreach($comissoes as $cc) {

            switch ($cc->parcela) {
                case 2:
                    $contrato_id = Comissoes::where("id", $cc->comissoes_id)->first()->contrato_id;
                    Contrato::where("id", $contrato_id)->update(["financeiro_id" => 6]);
                break;

                case 3:
                    $contrato_id = Comissoes::where("id", $cc->comissoes_id)->first()->contrato_id;
                    Contrato::where("id", $contrato_id)->update(["financeiro_id" => 7]);
                    break;

                case 4:
                    $contrato_id = Comissoes::where("id", $cc->comissoes_id)->first()->contrato_id;
                    Contrato::where("id", $contrato_id)->update(["financeiro_id" => 8]);
                    break;

                case 5:
                    $contrato_id = Comissoes::where("id", $cc->comissoes_id)->first()->contrato_id;
                    Contrato::where("id", $contrato_id)->update(["financeiro_id" => 9]);
                    break;

                case 6:
                    $contrato_id = Comissoes::where("id", $cc->comissoes_id)->first()->contrato_id;
                    Contrato::where("id", $contrato_id)->update(["financeiro_id" => 10]);
                    break;

                default:
                    $contrato_id = Comissoes::where("id", $cc->comissoes_id)->first()->contrato_id;
                    Contrato::where("id", $contrato_id)->update(["financeiro_id" => 5]);
                    break;
            }
        }
    });



    /*
    Route::get("/teste/arrumar",function(){
        $dados = DB::table('comissoes_corretores_lancadas')
            ->join('comissoes','comissoes.id',"=",'comissoes_corretores_lancadas.comissoes_id')
            ->join('contrato_empresarial','contrato_empresarial.id',"=",'comissoes.contrato_empresarial_id')
            ->whereRaw("comissoes_id IN(SELECT id FROM comissoes where user_id not in(2,3,26,36,57,18,24) and plano_id = 5)")
            ->whereRaw("parcela = 4")
            ->whereRaw("valor != 0")
            ->selectRaw("comissoes_corretores_lancadas.id,comissoes_corretores_lancadas.parcela,contrato_empresarial.valor_plano,comissoes_corretores_lancadas.valor")
            ->get();
        foreach($dados as $d) {
            $alt = \App\Models\ComissoesCorretoresLancadas::where("id",$d->id)->first();
            $alt->
            echo $d->id."<br />";
            //$alt = \App\Models\ComissoesCorretoresLancadas::where("id",$d->id)->first();
            //$d->valor = 0;
            //$d->save();
        }
        */

//        $porcentagem = \App\Models\ComissoesCorretoresConfiguracoes
//            ::where("plano_id",5)
//            ->where("administradora_id",3)
//            ->where("user_id",2)
//            ->where("parcela",3)
//            ->first()->valor;

        /*$sql = \App\Models\ComissoesCorretoresDefault::where("plano_id",5)->where("parcela",1)
        //->first()->valor;

        foreach($dados as $d) {
            //$contrato = $d->valor_plano;
            //echo $d->id." - ".$contrato."<br />";
            //$valor = ($contrato * $dados) / 100;
            //DB::table('comissoes_corretores_lancadas')->where("id",$d->id)->update(["valor"=>$valor]);
        }

    });

    /* Home **/
    Route::get("/","App\Http\Controllers\Admin\HomeController@index");
    Route::get("/tabela_preco","App\Http\Controllers\Admin\HomeController@search")->name('orcamento.search.home');
    Route::post("/tabela_preco","App\Http\Controllers\Admin\HomeController@tabelaPrecoResposta")->name('tabela.preco.resposta');
    Route::post("/tabela_preco/cidade/resposta","App\Http\Controllers\Admin\HomeController@tabelaPrecoRespostaCidade")->name('tabela.preco.resposta.cidade');
    Route::get("/consultar","App\Http\Controllers\Admin\HomeController@consultar")->name('home.administrador.consultar');
    Route::post("/consultar","App\Http\Controllers\Admin\HomeController@consultarCarteirnha")->name('consultar.carteirinha');
    /* Fim Home**/

    /**Orçamentos  */
    Route::get('/orcamento',"App\Http\Controllers\Admin\OrcamentoController@index")->name('orcamento.index');
    Route::post("/orcamento","App\Http\Controllers\Admin\OrcamentoController@montarOrcamento")->name('orcamento.montarOrcamento');
    Route::post("/orcamento/administradoras","App\Http\Controllers\Admin\OrcamentoController@montarOrcamentoAdministradoras")->name('orcamento.administradoras.montar');
    Route::post("/orcamento/criarpdf","App\Http\Controllers\Admin\OrcamentoController@criarPDF")->name('orcamento.criarpdf');
    Route::post("/orcamento/criarpdf/ambultorial","App\Http\Controllers\Admin\OrcamentoController@criarPDFAmbulatorial")->name('orcamento.criarpdfambulatorial');
    Route::post("/orcamento/criarpdf/empresarial","App\Http\Controllers\Admin\OrcamentoController@criarPDFEmpresarial")->name('orcamento.criarpdfempresarial');
    /**Fim Orçamentos */

    /**Contratos*/
    Route::get('/contratos',"App\Http\Controllers\Admin\ContratoController@index")->name('contratos.index');
    Route::post('/contratos',"App\Http\Controllers\Admin\ContratoController@store")->name('contratos.store');
    Route::post('/contratos/individual',"App\Http\Controllers\Admin\ContratoController@storeIndividual")->name('individual.store');
    Route::post('/contratos/montarPlanos',"App\Http\Controllers\Admin\ContratoController@montarPlanos")->name('contratos.montarPlanos');
    Route::post('/contratos/montarPlanosIndividual',"App\Http\Controllers\Admin\ContratoController@montarPlanosIndividual")->name('contratos.montarPlanosIndividual');
    Route::post('/contratos/empresarial',"App\Http\Controllers\Admin\ContratoController@storeEmpresarial")->name('contratos.storeEmpresarial');
    Route::get('/contratos/listarColetivoPorAdesao',"App\Http\Controllers\Admin\ContratoController@listarColetivoPorAdesao")->name('contratos.listarColetivoPorAdesao');
    
    
    Route::get("/contratos/individual/em_geral_contrato","App\Http\Controllers\Admin\ContratoController@geralIndividualPendentes")->name('financeiro.individual.geralIndividualPendentes.contrato');
    Route::get("/contrato/individual/em_geral_contrato","App\Http\Controllers\Admin\ContratoController@geralIndividualPendentesCorretor")->name('financeiro.individual.geralIndividualPendentes.contrato.corretor');
    Route::get("/contratos/coletivo/em_geral_contrato","App\Http\Controllers\Admin\ContratoController@geralColetivoPendentes")->name('financeiro.individual.geralColetivoPendentes.contrato');
    Route::get("/contrato/coletivo/em_geral_contrato","App\Http\Controllers\Admin\ContratoController@geralColetivoPendentesCorretor")->name('financeiro.individual.geralColetivoPendentes.contrato.corretor');
    Route::get('/contratos/listarempresas/emgeral',"App\Http\Controllers\Admin\ContratoController@listarEmpresarialEmGeral")->name('contratos.listarEmpresarial.emgeral');
    
    Route::get('/contratos/empendentes/empresarial',"App\Http\Controllers\Admin\ContratoController@listarContratoEmpresaPendentes")->name('contratos.listarEmpresarial.listarContratoEmpresaPendentes');
    
    
    
    
    
    
    
    
    
    Route::get('/contratos/listarempresas/cancelado',"App\Http\Controllers\Admin\ContratoController@listarContratoEmpresarialCancelado")->name('contratos.listarEmpresarial.cancelado');
    
    
    
    Route::post('/contratos/pegarEmpresarialPorUser',"App\Http\Controllers\Admin\ContratoController@listarEmpresarialPorUser")->name('contratos.listarEmpresarialPorUser');
    
    Route::get('/contratos/cadastrar/individual',"App\Http\Controllers\Admin\ContratoController@formCreate")->name('contratos.create');
    Route::get('/contrato/cadastrar/individual',"App\Http\Controllers\Admin\ContratoController@formContratoCreate")->name('contrato.create');
    Route::get('/financeiro/detalhes/empresarial/{id}',"App\Http\Controllers\Admin\FinanceiroController@detalheEmpresarial")->name('financeiro.empresarial.detalhe');
    Route::get('/contratos/cadastrar/coletivo',"App\Http\Controllers\Admin\ContratoController@formCreateColetivo")->name('contratos.create.coletivo');
    Route::get('/contrato/cadastrar/coletivo',"App\Http\Controllers\Admin\ContratoController@formCreateColetivoCorretor")->name('contratos.create.coletivo.corretor');
    Route::post('/financeiro/importarDados',"App\Http\Controllers\Admin\FinanceiroController@importarDados")->name('financeiro.importar.dados');
    Route::get('/financeiro/cliente/semcarteirinha',"App\Http\Controllers\Admin\FinanceiroController@semCarteirinha")->name('financeiro.sem.carteirinha');
    Route::post('/financeiro/cliente/atualizar/carteirinha',"App\Http\Controllers\Admin\FinanceiroController@atualizarCarteirinha")->name('cliente.atualizar.carteirinha');
    Route::get('/financeiro/cancelado/detalhes/{id}',"App\Http\Controllers\Admin\FinanceiroController@clienteCancelado")->name('cliente.cancelado.detalhes');
    Route::get('/contratos/cadastrar/empresarial',"App\Http\Controllers\Admin\ContratoController@formCreateEmpresarial")->name('contratos.create.empresarial');
    Route::post('/contratos/empresarial/financeiro',"App\Http\Controllers\Admin\FinanceiroController@storeEmpresarialFinanceiro")->name('contratos.storeEmpresarial.financeiro');
    Route::get('/contrato',"App\Http\Controllers\Admin\ContratoController@contrato")->name('contrato.index');
    /**Fim Contratos*/

    /**Financeiro*/
    Route::get('/financeiro',"App\Http\Controllers\Admin\FinanceiroController@index")->name('financeiro.index');
    Route::get("/financeiro/individual/em_geral/{mes?}","App\Http\Controllers\Admin\FinanceiroController@geralIndividualPendentes")->name('financeiro.individual.geralIndividualPendentes');
    
    Route::get('/financeiro/coletivo/em_analise/corretor',"App\Http\Controllers\Admin\FinanceiroController@coletivoEmAnaliseCorretor")->name('financeiro.coletivo.em_analise.corretor');
    Route::get('/financeiro/coletivo/em_branco',"App\Http\Controllers\Admin\FinanceiroController@coletivoEmBranco")->name('financeiro.coletivo.em_branco');
    Route::get('/financeiro/coletivo/em_geral',"App\Http\Controllers\Admin\FinanceiroController@coletivoEmGeral")->name('financeiro.coletivo.em_geral');
    Route::get('/financeiro/coletivo/em_geral/corretor',"App\Http\Controllers\Admin\FinanceiroController@coletivoEmGeralCorretor")->name('financeiro.coletivo.em_geral.corretor');
    Route::get('/financeiro/empresarial/em_geral',"App\Http\Controllers\Admin\FinanceiroController@empresarialEmGeral")->name('financeiro.empresarial.em_geral');
    
    Route::get('/financeiro/coletivo/emissao_boleto/corretor',"App\Http\Controllers\Admin\FinanceiroController@coletivoEmissaoBoletoCorretor")->name('financeiro.coletivo.emissao_boleto.corretor');
    Route::get('/financeiro/coletivo/pagamento_adesao/corretor',"App\Http\Controllers\Admin\FinanceiroController@coletivoPagamentoAdesaoCorretor")->name('financeiro.coletivo.pagamento_adesao.corretor');
    
    Route::get('/financeiro/coletivo/pagamento_vigencia/corretor',"App\Http\Controllers\Admin\FinanceiroController@coletivoPagamentoVigenciaCorretor")->name('financeiro.coletivo.pagamento_vigencia.corretor');
    
    
    Route::get('/financeiro/coletivo/pagamento_segunda_parcela/corretor',"App\Http\Controllers\Admin\FinanceiroController@coletivoPagamentoSegundaParcelaCorretor")->name('financeiro.coletivo.pagamento_segunda_parcela.corretor');
    
    Route::get('/financeiro/coletivo/pagamento_terceira_parcela/corretor',"App\Http\Controllers\Admin\FinanceiroController@coletivoPagamentoTerceiraParcelaCorretor")->name('financeiro.coletivo.pagamento_terceira_parcela.corretor');
    
    Route::get('/financeiro/coletivo/pagamento_quarta_parcela/corretor',"App\Http\Controllers\Admin\FinanceiroController@coletivoPagamentoQuartaParcelaCorretor")->name('financeiro.coletivo.pagamento_quarta_parcela.corretor');
    
    Route::get('/financeiro/coletivo/pagamento_quinta_parcela/corretor',"App\Http\Controllers\Admin\FinanceiroController@coletivoPagamentoQuintaParcelaCorretor")->name('financeiro.coletivo.pagamento_quinta_parcela.corretor');
    
    Route::get('/financeiro/coletivo/pagamento_sexta_parcela/corretor',"App\Http\Controllers\Admin\FinanceiroController@coletivoPagamentoSextaParcelaCorretor")->name('financeiro.coletivo.pagamento_sexta_parcela.corretor');
    
    Route::get('/financeiro/coletivo/pagamento_coletivo_finalizado/corretor',"App\Http\Controllers\Admin\FinanceiroController@coletivoFinalizadoCorretor")->name('financeiro.coletivo.finalizado.corretor');
    
    Route::get('/financeiro/coletivo/pagamento_coletivo_cancelado/corretor',"App\Http\Controllers\Admin\FinanceiroController@coletivoCanceladosCorretor")->name('financeiro.coletivo.cancelado.corretor');
    Route::get("/financeiro/todososcontratos/em_geral_todos_os_planos","App\Http\Controllers\Admin\FinanceiroController@geralTodosContratosPendentes")->name('financeiro.todos.geralTodosContratosPendentes');
    

    Route::post('/financeiro/select/mes',"App\Http\Controllers\Admin\FinanceiroController@financeiroMontarSelect")->name('financeiro.montar.mes');
    
    
    
    
    
    
    
    Route::get('/financeiro/individual/em_analise/corretor',"App\Http\Controllers\Admin\FinanceiroController@emAnaliseIndividualCorretor")->name('financeiro.individual.em_analise.corretor');
    Route::post('/financeiro/sincronizar',"App\Http\Controllers\Admin\FinanceiroController@sincronizarDados")->name('financeiro.sincronizar');
    Route::post('/financeiro/sincronizar/coletivo',"App\Http\Controllers\Admin\FinanceiroController@sincronizarDadosColetivo")->name('financeiro.sincronizar.coletivo');
    Route::post('/financeiro/atualizar_dados',"App\Http\Controllers\Admin\FinanceiroController@atualizarDados")->name('financeiro.atualizar.dados');
    Route::post('/financeiro/sincronizar_baixas',"App\Http\Controllers\Admin\FinanceiroController@sincronizarBaixas")->name('financeiro.sincronizar.baixas');
    Route::post('/financeiro/sincronizar_baixas/ja_existente',"App\Http\Controllers\Admin\FinanceiroController@sincronizarBaixasJaExiste")->name('financeiro.sincronizar.baixas.jaexiste');
    Route::get('/financeiro/detalhes/{id}',"App\Http\Controllers\Admin\FinanceiroController@detalhesContrato")->name('financeiro.detalhes.contrato');
    Route::get('/financeiro/detalhes/coletivo/{id}',"App\Http\Controllers\Admin\FinanceiroController@detalhesContratoColetivo")->name('financeiro.detalhes.contrato.coletivo');
    Route::post('/financeiro/changeclienteuser',"App\Http\Controllers\Admin\FinanceiroController@changeclienteuser")->name('change.cliente.user');
    Route::post('/financeiro/verificardependentes','App\Http\Controllers\Admin\FinanceiroController@verificardependentesuser')->name('verificar.dependentes.user');
    
    
    
    Route::get('/financeiro/individual/pagamento_primeira_parcela/corretor',"App\Http\Controllers\Admin\FinanceiroController@individualPagamentoPrimeiraParcelaCorretor")->name('financeiro.individual.pagamento_primeira_parcela.corretor');
    
    Route::get('/financeiro/individual/pagamento_segunda_parcela/corretor',"App\Http\Controllers\Admin\FinanceiroController@individualPagamentoSegundaParcelaCorretor")->name('financeiro.individual.pagamento_segunda_parcela.corretor');
    
    Route::get('/financeiro/individual/pagamento_terceira_parcela/corretor',"App\Http\Controllers\Admin\FinanceiroController@individualPagamentoTerceiraParcelaCorretor")->name('financeiro.individual.pagamento_terceira_parcela.corretor');
    
    Route::get('/financeiro/individual/pagamento_quarta_parcela/corretor',"App\Http\Controllers\Admin\FinanceiroController@individualPagamentoQuartaParcelaCorretor")->name('financeiro.individual.pagamento_quarta_parcela.corretor');
    
    Route::get('/financeiro/individual/pagamento_quinta_parcela/corretor',"App\Http\Controllers\Admin\FinanceiroController@individualPagamentoQuintaParcelaCorretor")->name('financeiro.individual.pagamento_quinta_parcela.corretor');
    
    Route::get('/financeiro/individual/pagamento_sexta_parcela/corretor',"App\Http\Controllers\Admin\FinanceiroController@individualPagamentoSextaParcelaCorretor")->name('financeiro.individual.pagamento_sexta_parcela.corretor');
    
    Route::get('/financeiro/individual/finalizado/corretor',"App\Http\Controllers\Admin\FinanceiroController@individualFinalizadoCorretor")->name('financeiro.individual.finalizado.corretor');
    
    Route::get('/financeiro/coletivo/pagamento_individual_cancelado/corretor',"App\Http\Controllers\Admin\FinanceiroController@individualCanceladosCorretor")->name('financeiro.individual.cancelado.corretor');
    Route::post('/financeiro/mudarEstadosColetivo',"App\Http\Controllers\Admin\FinanceiroController@mudarEstadosColetivo")->name('financeiro.mudarStatusColetivo');
    Route::post('/financeiro/mudarEstadosIndividual',"App\Http\Controllers\Admin\FinanceiroController@mudarEstadosIndividual")->name('financeiro.mudarStatusIndividual');
    Route::post('/financeiro/mudarEstadosEmpresarial',"App\Http\Controllers\Admin\FinanceiroController@mudarEstadosEmpresarial")->name('financeiro.mudarStatusEmpresarial');
    Route::post('/financeiro/mudarEstadosEmpresarialDescontos',"App\Http\Controllers\Admin\FinanceiroController@mudarEstadosEmpresarialDescontos")->name('financeiro.mudarStatusEmpresarialUpdate');
    Route::post("/financeiro/mudarDataVigenciaColetivo","App\Http\Controllers\Admin\FinanceiroController@mudarDataVivenciaColetivo")->name('financeiro.mudarVigenciaColetivo');
    Route::post('/financeiro/baixaDaData',"App\Http\Controllers\Admin\FinanceiroController@baixaDaData")->name('financeiro.baixa.data');
    Route::post('/financeiro/baixaDaData/individual',"App\Http\Controllers\Admin\FinanceiroController@baixaDaDataIndividual")->name('financeiro.baixa.data.individual');
    Route::post('/financeiro/baixaDaData/empresarial',"App\Http\Controllers\Admin\FinanceiroController@baixaDaDataEmpresarial")->name('financeiro.baixa.data.empresarial');
    Route::post('/financeiro/editarCampoIndividualmente',"App\Http\Controllers\Admin\FinanceiroController@editarCampoIndividualmente")->name('financeiro.editar.campoIndividualmente');
    Route::post('/financeiro/editarIndividualCampoIndividualmente',"App\Http\Controllers\Admin\FinanceiroController@editarIndividualCampoIndividualmente")->name('financeiro.editar.individual.campoIndividualmente');
    Route::post('/financeiro/editarCampoEmpresarial/campo',"App\Http\Controllers\Admin\FinanceiroController@editarCampoEmpresarialIndividual")->name('financeiro.editar.empresarial.campoIndividualmente');
    Route::post('/financeiro/contratos',"App\Http\Controllers\Admin\FinanceiroController@verContrato")->name('financeiro.ver.contrato');
    Route::post('/financeiro/cancelados',"App\Http\Controllers\Admin\FinanceiroController@cancelarContrato")->name('financeiro.contrato.cancelados');
    Route::post('/financeiro/empresarial/cancelados',"App\Http\Controllers\Admin\FinanceiroController@cancelarContratoEmpresarial")->name('financeiro.contrato.empresarial.cancelados');
    Route::post('/financeiro/excluir',"App\Http\Controllers\Admin\FinanceiroController@excluirCliente")->name('financeiro.excluir.cliente');
    Route::post('/financeiro/excluir/individual',"App\Http\Controllers\Admin\FinanceiroController@excluirClienteIndividual")->name('financeiro.excluir.cliente.individual');
    Route::get('/financeiro/zerar/tabela',"App\Http\Controllers\Admin\FinanceiroController@zerarTabelaFinanceiro")->name('financeiro.zerar.financeiro');
    Route::post('/financeiro/excluir/empresarial',"App\Http\Controllers\Admin\FinanceiroController@excluirClienteEmpresarial")->name('financeiro.excluir.cliente.empresarial');
   
    
    Route::get('/financeiro/geral/atrasado/corretor',"App\Http\Controllers\Admin\FinanceiroController@getAtrasadosCorretor")->name('financeiro.individual.atrasado.corretor');
    /**Fim Financeiro*/

    /***Comissões*****/
    Route::get('/comissao',"App\Http\Controllers\Admin\ComissoesController@index")->name('comissao.index');
    Route::get('/comissao/listarindividual',"App\Http\Controllers\Admin\ComissoesController@listarComissoes")->name('comissao.listar');
    /***Fim Comissões*****/

    /***Premiação***/
    Route::get('/premiacao',"App\Http\Controllers\Admin\PremiacaoController@index")->name('premiacao.index');
    Route::get('/premiacao/listarindividual',"App\Http\Controllers\Admin\PremiacaoController@listarPremiacao")->name('premiacao.listar');

    /***Fim Premiação***/
    Route::get("/profile/{id}","App\Http\Controllers\Admin\UserController@getUser")->name("profile.getUser");
    Route::post("/profile","App\Http\Controllers\Admin\UserController@setUser")->name("profile.setUser");
    /***Financeiro Gerente */

    Route::get('/gerente',"App\Http\Controllers\Admin\GerenteController@index")->name('gerente.index');
    Route::post('/gerente/pegartodos',"App\Http\Controllers\Admin\GerenteController@pegarTodososDados")->name('gerente.todos.valores.usuario');
    Route::get('/gerente/listagem',"App\Http\Controllers\Admin\GerenteController@listagem")->name('gerente.listagem.em_geral');
    Route::get('/gerente/concluidos',"App\Http\Controllers\Admin\GerenteController@concluidos")->name('gerente.listagem.concluidos');



    Route::get('/gerente/comissao/{id}',"App\Http\Controllers\Admin\GerenteController@listarComissao")->name('gerente.comissao.listar');
    Route::get('/gerente/detalhe/{id_contrato}',"App\Http\Controllers\Admin\GerenteController@detalhe")->name('gerente.listagem.detalhe');
    Route::get('/gerente/pagos/detalhe/{id_contrato}',"App\Http\Controllers\Admin\GerenteController@detalhePagos")->name('gerente.pagos.listagem.detalhe');
    
    Route::post('/gerente/informacoes/corretor',"App\Http\Controllers\Admin\GerenteController@infoCorretor")->name('gerente.informacoes.quantidade.corretor');

    Route::post('/gerente/pegar/todos/mes/corrente',"App\Http\Controllers\Admin\GerenteController@pegarTodosMesCorrente")->name('gerente.pegar.todos.mes.corrente');


    Route::post('/gerente/historico/informacoes/corretor',"App\Http\Controllers\Admin\GerenteController@infoCorretorHistorico")->name('gerente.historico.informacoes.corretor');


    Route::get('/gerente/listar/comissao',"App\Http\Controllers\Admin\GerenteController@listarUserComissoesAll")->name('gerente.listagem.comissao');
    Route::get('/gerente/listagem/comissao_mes_atual/{id}',"App\Http\Controllers\Admin\GerenteController@comissaoMesAtual")->name('gerente.listagem.comissao_mes_atual');
    Route::get('/gerente/listagem/recebidas/coletivo/{id}',"App\Http\Controllers\Admin\GerenteController@recebidasColetivo")->name('gerente.listagem.recebidas.coletivo');
    Route::get('/gerente/listagem/zerar/tabelas',"App\Http\Controllers\Admin\GerenteController@zerarTabelas")->name('gerente.listagem.zerar.tabelas');







    Route::post('/gerente/mudar/para_a_nao_pago',"App\Http\Controllers\Admin\GerenteController@mudarStatusParaNaoPago")->name('gerente.mudar.para_a_nao_pago');
    Route::get('/gerente/comissao/confirmadas/{id}/{mes?}',"App\Http\Controllers\Admin\GerenteController@comissaoListagemConfirmadas")->name('gerente.listagem.confirmadas');
    Route::get('/gerente/estorno/coletivo/{id}',"App\Http\Controllers\Admin\GerenteController@estornoColetivo")->name('gerente.estorno.coletivo');
    Route::get('/gerente/estorno/empresarial/{id}',"App\Http\Controllers\Admin\GerenteController@estornoEmpresarial")->name('gerente.estorno.empresarial');

    Route::get('/gerente/geral/estorno/{id}',"App\Http\Controllers\Admin\GerenteController@geralEstorno")->name('gerente.geral.estorno.listar');
    Route::get('/gerente/mes/geral/estorno/{mes}',"App\Http\Controllers\Admin\GerenteController@geralEstornoMes")->name('gerente.mes.geral.estorno.listar');
    
    Route::post('/gerente/estorno/valor/voltar',"App\Http\Controllers\Admin\GerenteController@estornoVoltar")->name('gerente.estorno.valor.voltar');
    Route::post('/gerente/mes/especifico/comissao/confirmadas',"App\Http\Controllers\Admin\GerenteController@comissaoListagemConfirmadasMesEspecifico")->name('gerente.listagem.confirmadas.especifica');
    Route::get('/gerente/mes/fechados/confirmados/{mes}/{plano}',"App\Http\Controllers\Admin\GerenteController@comissaoListagemConfirmadasMesFechado")->name('gerente.mes.fechados.confirmados');
    Route::post('/gerente/totalizar/mes',"App\Http\Controllers\Admin\GerenteController@totalizarMes")->name('totalizar.mes.gerente');
    Route::post('/gerente/contrato/estorno',"App\Http\Controllers\Admin\GerenteController@contratoEstorno")->name('gerente.contrato.estorno');
    Route::post('/gerente/salario/historico',"App\Http\Controllers\Admin\GerenteController@salarioUserHistorico")->name('gerente.salario.user.historico');
    Route::get('/gerente/search/historico',"App\Http\Controllers\Admin\GerenteController@gerenteBuscarHistorico")->name('gerente.buscar.historico');
    Route::get('/gerente/comissao/coletivo/confirmadas/{id?}/{mes?}',"App\Http\Controllers\Admin\GerenteController@comissaoListagemConfirmadasColetivo")->name('gerente.listagem.coletivo.confirmadas');
    Route::get('/gerente/comissao/empresarial/confirmadas/{id}/{mes?}',"App\Http\Controllers\Admin\GerenteController@comissaoListagemConfirmadasEmpresarial")->name('gerente.listagem.empresarial.confirmadas');
    Route::get('/gerente/listagem/empresarial/recebidas/{id}',"App\Http\Controllers\Admin\GerenteController@recebidoEmpresarial")->name('gerente.listagem.empresarial.recebidas');
    Route::get('/gerente/listagem/comissao_mes_diferente/{id}',"App\Http\Controllers\Admin\GerenteController@comissaoMesDiferente")->name('gerente.listagem.comissao_mes_diferente');
    Route::get('/gerente/coletivo/listar/{id}',"App\Http\Controllers\Admin\GerenteController@coletivoAReceber")->name('gerente.listagem.coletivo.areceber');
    Route::get('/gerente/empresarial/listar/{id}',"App\Http\Controllers\Admin\GerenteController@empresarialAReceber")->name('gerente.listagem.empresarial.areceber');
    Route::post('/gerente/aplicar/desconto/corretor','App\Http\Controllers\Admin\GerenteController@aplicarDescontoCorretor')->name('gerente.aplicar.desconto');
    Route::post('/gerente/mudar_status',"App\Http\Controllers\Admin\GerenteController@mudarStatus")->name('gerente.mudar_status');
    Route::get('/gerente/criar_pdf_pagamento',"App\Http\Controllers\Admin\GerenteController@criarPdfPagamento")->name('comissao.create.pdf');
    Route::post('/gerente/mudarcomisao/corretora',"App\Http\Controllers\Admin\GerenteController@mudarComissaoCorretora")->name('gerente.mudar.valor.corretora');
    Route::post('/gerente/mudarcomisao/corretor/gerente',"App\Http\Controllers\Admin\GerenteController@mudarComissaoCorretor")->name('gerente.mudar.valor.corretor');
    Route::post('/gerente/mudarcomisao/corretor/pago',"App\Http\Controllers\Admin\GerenteController@mudarComissaoCorretorGerente")->name('gerente.mudar.valor.pago');
    Route::post('/gerente/administradorapagou/comissao',"App\Http\Controllers\Admin\GerenteController@administradoraPagouComissao")->name('gerente.administradorapagoucomissao');
    Route::post('/gerente/pagos/administradorapagou/comissao',"App\Http\Controllers\Admin\GerenteController@administradoraPagouComissaoPagos")->name('gerente.administradorapagoucomissao.pagos');
    
    Route::post('/gerente/finalizar/pagamento',"App\Http\Controllers\Admin\GerenteController@finalizarPagamento")->name('gerente.finalizar.pagamento');
    Route::post('/gerente/mes/encerrar',"App\Http\Controllers\Admin\GerenteController@pagamentoMesFinalizado")->name('gerente.pagamento.mes.finalizado');
    Route::get('/gerente/finalizar/criarpdf',"App\Http\Controllers\Admin\GerenteController@criarPDFUser")->name('gerente.finalizar.criarpdf');

    Route::get('/gerente/historico/finalizar/criarpdf',"App\Http\Controllers\Admin\GerenteController@criarPDFUserHistorico")->name('gerente.historico.finalizar.criarpdf');

    Route::post('/gerente/montar/mes/tabela/modal',"App\Http\Controllers\Admin\GerenteController@montarTabelaMesModal")->name('montar.tabela.mes.modal');
    Route::get('/gerente/listarcontratosemgeral',"App\Http\Controllers\Admin\GerenteController@listarcontratos")->name('gerente.listarcontratos.geral');
    Route::get('/gerente/contrato/{id}',"App\Http\Controllers\Admin\GerenteController@listarcontratosDetalhe")->name('gerente.contrato.detalhe');
    Route::get('/gerente/ver/{id_plano?}/{id_tipo?}/{ano?}/{mes?}/{id_user?}',"App\Http\Controllers\Admin\GerenteController@verDetalheCard")->name('gerente.contrato.ver.detalhe.card');
    Route::get('/gerente/show/{id_plano?}/{id_tipo?}/{ano?}/{mes?}/{id_user?}',"App\Http\Controllers\Admin\GerenteController@showDetalheCard")->name('gerente.contrato.show.detalhe.card');
    Route::get('/gerente/all/ver/{id_estagio}',"App\Http\Controllers\Admin\GerenteController@showDetalhesDadosTodosAll")->name('gerente.contrato.show.detalhes.todos.visualizar');
    Route::get('/gerente/all/todos/show/{estagio}',"App\Http\Controllers\Admin\GerenteController@showTodosDetalheCard")->name('gerente.contrato.show.detalhes.todos');
    Route::post('/gerente/antecipar/parcela',"App\Http\Controllers\Admin\GerenteController@aptarPagamento")->name('gerente.aptar.pagamento');
    
    Route::post('/gerente/folha_mes/inserir',"App\Http\Controllers\Admin\GerenteController@cadastrarFolhaMes")->name('gerente.cadastrar.folha_mes');
    Route::post('/gerente/historico/folha_mes/inserir',"App\Http\Controllers\Admin\GerenteController@cadastrarHistoricoFolhaMes")->name('gerente.historico.cadastrar.folha_mes');

    Route::get('/gerente/tabelas/vazias',"App\Http\Controllers\Admin\GerenteController@tabelaVazia")->name('gerente.tabelas.vazias');
    Route::get('/listar/gerente/cadastrados',"App\Http\Controllers\Admin\GerenteController@listarGerenteCadastrados")->name('listar.gerente.cadastrados');
    Route::post('/gerente/geral/folha/mes/especifica',"App\Http\Controllers\Admin\GerenteController@geralFolhaMesEspecifica")->name('geral.folha.mes.especifica');
    Route::post('/gerente/mudar/salario',"App\Http\Controllers\Admin\GerenteController@mudarSalario")->name('gerente.mudar.salario');
    Route::post('/gerente/change/premiacao',"App\Http\Controllers\Admin\GerenteController@mudarPremiacao")->name('gerente.mudar.premiacao');
    Route::get('/gerente/excel/exportar/{mes}',"App\Http\Controllers\Admin\ContratoController@exportarContratoExcel")->name('gerente.excel.exportar');
    Route::get('/gerente/estorno/individual/{id}',"App\Http\Controllers\Admin\GerenteController@estornoIndividual")->name('gerente.estorno.individual');
    /***Fim Financeiro Gerente */

    /****************************************************************Configurações******************************************************************/

        /* Corretora **/
        Route::get('/corretora',"App\Http\Controllers\Admin\CorretoraController@index")->name('corretora.index');
        Route::post('/corretora/mudar/valor/tabela',"App\Http\Controllers\Admin\CorretoraController@mudarValorTabela")->name('corretora.mudar.valor.tabela');
        Route::post('/corretora',"App\Http\Controllers\Admin\CorretoraController@store")->name('corretora.store');
        Route::post('/store/pdf/corretora',"App\Http\Controllers\Admin\CorretoraController@storePdf")->name('corretora.store.pdf');
        Route::post('/cadastrar/comissao/corretor/coletivo',"App\Http\Controllers\Admin\CorretoraController@cadastrarComissaoCorretorColetivo")->name('cadastrar.comissao.corretor.coletivo');
        Route::post('/corretora/verificar/parcelas/coletivo',"App\Http\Controllers\Admin\CorretoraController@verificarParcelasColetivo")->name('verificar.parcelas.coletivo');
        Route::post('/corretora/cadastrar/planos/hap',"App\Http\Controllers\Admin\CorretoraController@cadastrarPlanosHap")->name('corretora.cadastrar.planos.hap');
        Route::post('/corretora/verificar/planos/hap',"App\Http\Controllers\Admin\CorretoraController@verificarPlanosHap")->name('corretora.verificar.planos.hap');
        Route::post('/corretore/verificar/comissao/trocar/cidade',"App\Http\Controllers\Admin\CorretoraController@verificarComissaoTrocarCidade")->name('verificar.comissao.trocar.cidade');
        
        Route::post('/corretora/store/comissao',"App\Http\Controllers\Admin\CorretoraController@storeCorretora")->name("corretora.store.comissao");

        Route::post('/corretora/mudar/valor/comissao/especifica','App\Http\Controllers\Admin\CorretoraController@mudarValorComissaoEspecifica')->name('mudar.valor.comissao.especifica');
        Route::post('/corretora/remover/comissao/corretora/configuracoes','App\Http\Controllers\Admin\CorretoraController@removeComissaoCorretoraConfiguracoes')->name('remove.comissao.corretora.configuracoes');


        Route::post('/corretora/cadastrar/comissao/corretor',"App\Http\Controllers\Admin\CorretoraController@storeCorretor")->name('corretora.cadastrar.comissao.corretor');
        Route::post('/corretora/alterar/comissao/corretor',"App\Http\Controllers\Admin\CorretoraController@showAlterarCorretor")->name('show.corretor.alterar.comissao');
        Route::post('/corretora/alterar/comissao/corretora',"App\Http\Controllers\Admin\CorretoraController@alterarCorretora")->name('corretora.alterar.comissao.corretor');
        Route::post('/corretor/alterar/comissao/valores',"App\Http\Controllers\Admin\CorretoraController@alterarCorretor")->name('corretor.alterar.comissao.valores');

        Route::post('/corretora/lista/cidade',"App\Http\Controllers\Admin\CorretoraController@corretoraListaCidade")->name('corretora.lista.cidade');
        Route::post('/corretora/inserir/cadastro/corretor',"App\Http\Controllers\Admin\CorretoraController@cadastrarCorretorComissao")->name('corretora.cadastrar.corretor.comissao');

        Route::post('/corretora/verificar/comissao',"App\Http\Controllers\Admin\CorretoraController@corretoraVerificarComissao")->name('corretora.verificar.comissao');
        Route::post('/corretora/planos/cadastrar',"App\Http\Controllers\Admin\CorretoraController@corretoresCadastrarPlanos")->name('corretores.cadastrar.planos');
        Route::post('/corretora/deletar/plano',"App\Http\Controllers\Admin\CorretoraController@corretoresDeletarPlanos")->name('corretores.deletar.planos');
        Route::post('/corretora/administradora/store',"App\Http\Controllers\Admin\CorretoraController@corretoraStoreadministradora")->name('corretora.store.administradora');
        Route::post('/corretora/remover/administradora',"App\Http\Controllers\Admin\CorretoraController@corretoraDeletarAdministradora")->name("corretora.remover.administradora");
        Route::post('/corretora/mudar/logo',"App\Http\Controllers\Admin\CorretoraController@corretoraMudarLogo")->name("corretora.mudar.logo");
        Route::post('/corretora/cidades/verificar',"App\Http\Controllers\Admin\CorretoraController@corretoraVerificarCorretoraCidades")->name('verificar.corretora.cidades');

        Route::post('/corretora/criar/tabelas/cadastro/dinamicamente','App\Http\Controllers\Admin\CorretoraController@corretoraCriarTabelasCadastroDinamicamente')->name('corretora.criar.tabelas.cadastro.dinamicamente');
        Route::post('/corretora/jaexiste/criar/tabelas/cadastro/dinamicamente','App\Http\Controllers\Admin\CorretoraController@corretoraJaExisteCriarTabelasCadastroDinamicamente')->name('corretora.jaexiste.criar.tabelas.cadastro.dinamicamente');
        
        Route::post('/corretora/pegar/cidade/corretore/planos',"App\Http\Controllers\Admin\CorretoraController@corretoraPegarCidadeCorretorePlanos")->name('pegar.cidade.corretore.plano');    

        /* Fim  Corretora **/

        /**Administradoras*/
        Route::get("/administradora","App\Http\Controllers\Admin\AdministradoraController@index")->name('administradoras.index');
        Route::get("/administradora/list","App\Http\Controllers\Admin\AdministradoraController@list")->name('administradoras.list');
        Route::post("/administradora/cadastrar","App\Http\Controllers\Admin\AdministradoraController@cadastrarAjax")->name('administradoras.store');
        /**Fim Administradoras*/

        /**Tabela Origem */
        Route::get("/tabela_origem","App\Http\Controllers\Admin\TabelaOrigemControlller@index")->name('tabela_origem.index');
        Route::get("/tabela_origem/list","App\Http\Controllers\Admin\TabelaOrigemControlller@list")->name('tabela_origem.list');
        Route::post("/tabela_origem/store","App\Http\Controllers\Admin\TabelaOrigemControlller@store")->name('tabela_origem.store');
        Route::post('/tabela_origem/deletar',"App\Http\Controllers\Admin\TabelaOrigemControlller@deletar")->name('tabela_origem.deletar');
        /**Fim Tabela Origem */

        /**Planos*/
        Route::get("/planos","App\Http\Controllers\Admin\PlanoController@index")->name('planos.index');
        Route::get("/planos/list","App\Http\Controllers\Admin\PlanoController@list")->name('planos.list');
        Route::post("/planos/store","App\Http\Controllers\Admin\PlanoController@store")->name('planos.store');
        /**Fim Planos*/

        /**Tabela de Preços */
        Route::get("/tabela","App\Http\Controllers\Admin\TabelaController@index")->name('tabela.index');
        Route::post("/tabela/search","App\Http\Controllers\Admin\TabelaController@pesquisar")->name("tabela.pesquisar");
        Route::get("/tabela/search","App\Http\Controllers\Admin\TabelaController@search")->name("tabela.search");
        Route::post("/tabela","App\Http\Controllers\Admin\TabelaController@store")->name("store.tabela");
        Route::post("/tabelas/pegar/cidades/administradoras","App\Http\Controllers\Admin\TabelaController@pegarCidadeAdministradora")->name("cidades.administradoras.pegar");
        Route::post("/tabela/orcamento/alterar","App\Http\Controllers\Admin\TabelaController@edit")->name("tabela.edit.valor");
        Route::post("/tabela/verificar/valores","App\Http\Controllers\Admin\TabelaController@verificarValoresTabela")->name("verificar.valores.tabela");
        Route::get("/tabela/coparticipacao/{plano}/{cidade}","App\Http\Controllers\Admin\TabelaController@verCoparticipacao")->name('tabela.coparticipacao.plano.cidade');
        Route::post("/tabela/store/coparticipacao","App\Http\Controllers\Admin\TabelaController@storeCoparticipacao")->name('tabela.store.coparticipacao');

        /** Fim Tabela de Preços */

        /****Corretor*****/
        Route::get("/corretores","App\Http\Controllers\Admin\CorretorController@index")->name('corretor.index');
        Route::get("/corretores/active_inative","App\Http\Controllers\Admin\CorretorController@activeInative")->name('corretor.active_inative');
        Route::post("/corretores","App\Http\Controllers\Admin\CorretorController@store")->name('corretores.store');
        Route::post("/corretores/mudar/active_inative","App\Http\Controllers\Admin\CorretorController@mudarActiveInative")->name('corretores.active.inative');
        Route::get('/corretotes/editar/{id}',"App\Http\Controllers\Admin\CorretorController@editarUser")->name('corretores.editar');
        Route::post('/corretotes/edit',"App\Http\Controllers\Admin\CorretorController@editarUserForm")->name('corretores.edit');
        Route::get('/corretores/listar/user',"App\Http\Controllers\Admin\CorretorController@listUser")->name('corretores.list');
        /****Fim Corretor*****/

    /*************************************************************Fim Configurações****************************************************************/

});

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

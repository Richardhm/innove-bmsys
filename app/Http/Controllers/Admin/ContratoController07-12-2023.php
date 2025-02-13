<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ContratosExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{
    Contrato,Cliente,TabelaOrigens,Administradoras,Planos,Acomodacao,CotacaoFaixaEtaria,User,PlanoEmpresarial,ContratoEmpresarial,
    Comissoes,ComissoesCorretoresLancadas,ComissoesCorretoraConfiguracoes,ComissoesCorretoraLancadas,ComissoesCorretoresConfiguracoes,
    Premiacoes,PremiacoesCorretoraLancadas,PremiacoesCorretoresLancadas,PremiacoesCorretoraConfiguracoes,PremiacoesCorretoresConfiguracoes,
    ComissoesCorretoresDefault,
    Dependentes
};
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
class ContratoController extends Controller
{
    public function index()
    {


        $anos_coletivo = DB::select('SELECT YEAR(created_at) as anos FROM contratos WHERE plano_id = 3 GROUP BY YEAR(created_at)');
        $meses = ["01" => "Janeiro","02"=>"Fevereiro","03"=>"Março","04"=>"Abril","05"=>"Maio","06"=>"Junho","07"=>"Julho","08"=>"Agosto","09"=>"Setembro","10"=>"Outubro","11"=>"Novembro","12"=>"Dezembro"];

        $contratos_coletivo_total = Contrato
        ::where("plano_id",3)
        ->count();

        $cidades = TabelaOrigens::all();
        $administradoras = Administradoras::whereRaw("id != (SELECT id FROM administradoras WHERE nome LIKE '%hapvida%')")->get();

        $planos = Planos::all();
        $plano_empresarial = PlanoEmpresarial::all();
        $users = User::where("id","!=",auth()->user()->id)->get();

        $tabela_origem = TabelaOrigens::all();

        $qtd_individual_pendentes = Contrato::where("plano_id",1)->whereHas('clientes',function($query){
            $query->whereRaw('cateirinha IS NOT NULL');
        })->count();


        $qtd_individual_atrasado = Contrato
        ::where("plano_id",1)
        ->where("financeiro_id","!=",12)
        ->whereHas('comissao.comissoesLancadas',function($query){
            $query->whereRaw("DATA < CURDATE()");
            //$query->whereRaw("valor > 0");
            $query->whereRaw("data_baixa IS NULL");
            $query->groupBy("comissoes_id");
        })
        ->whereHas('clientes',function($query){
            $query->whereRaw('cateirinha IS NOT NULL');
        })
        ->count();

        $qtd_individual_em_analise = Contrato::where("financeiro_id",1)->where("plano_id",1)->count();

        $qtd_individual_parcela_01 = Contrato
            ::where("plano_id",1)
            ->where("financeiro_id",5)
            ->whereHas('clientes',function($query){
                $query->whereRaw("cateirinha IS NOT NULL");
            })
            ->whereHas('comissao.comissoesLancadas',function($query){
                //$query->where("status_financeiro",0);
                //$query->where("status_gerente",0);
                $query->where("parcela",1);
                //$query->whereRaw("data_baixa IS NULL");
            })
            ->count();

        //dd($qtd_individual_parcela_01);

        $qtd_individual_parcela_02 = Contrato
            ::where("plano_id",1)
            ->where("financeiro_id",6)
            ->whereHas('clientes',function($query){
                $query->whereRaw("cateirinha IS NOT NULL");
            })
            ->whereHas('comissao.comissoesLancadas',function($query){
                //$query->where("status_financeiro",0);
                //$query->where("status_gerente",0);
                $query->where("parcela",2);
                //$query->whereRaw("data_baixa IS NULL");
            })
            ->count();

        $qtd_individual_parcela_03 = Contrato
            ::where("plano_id",1)
            ->where("financeiro_id",7)
            ->whereHas('clientes',function($query){
                $query->whereRaw("cateirinha IS NOT NULL");
            })
            ->whereHas('comissao.comissoesLancadas',function($query){
                //$query->where("status_financeiro","=",0);
                //$query->where("status_gerente",0);
                $query->where("parcela",3);
                //$query->whereRaw("data_baixa IS NULL");
            })
            ->count();

        $qtd_individual_parcela_04 = Contrato
            ::where("plano_id",1)
            ->where("financeiro_id",8)
            ->whereHas('clientes',function($query){
                $query->whereRaw("cateirinha IS NOT NULL");
            })
            ->whereHas('comissao.comissoesLancadas',function($query){
                //$query->where("status_financeiro","=",0);
                //$query->where("status_gerente",0);
                $query->where("parcela",4);
                //$query->whereRaw("data_baixa IS NULL");
            })
            ->count();

        $qtd_individual_parcela_05 = Contrato
            ::where("plano_id",1)
            ->where("financeiro_id",9)
            ->whereHas('clientes',function($query){
                $query->whereRaw("cateirinha IS NOT NULL");
            })
            ->whereHas('comissao.comissoesLancadas',function($query){
                //$query->where("status_financeiro","=",0);
                //$query->where("status_gerente",0);
                $query->where("parcela",5);
                //$query->whereRaw("data_baixa IS NULL");
            })
            ->count();

        $qtd_individual_parcela_06 = Contrato
            ::where("plano_id",1)
            ->where("financeiro_id",10)
            ->whereHas('clientes',function($query){
                $query->whereRaw("cateirinha IS NOT NULL");
            })
            ->whereHas('comissao.comissoesLancadas',function($query){
                //$query->where("status_financeiro","=",0);
                //$query->where("status_gerente",0);
                $query->where("parcela",6);
                //$query->whereRaw("data_baixa IS NULL");
            })
            ->count();


        $qtd_individual_finalizado = Contrato::where("financeiro_id",11)
            ->where("plano_id",1)
            ->count();

        $qtd_individual_cancelado = Contrato::where("financeiro_id",12)
            ->where("plano_id",1)
            ->count();



        $qtd_coletivo_em_analise = Contrato::where("financeiro_id",1)->where("plano_id",3)->count();

        $qtd_coletivo_emissao_boleto = Contrato::where("financeiro_id",2)->where("plano_id",3)->count();

        $qtd_coletivo_pg_adesao = Contrato::where('financeiro_id',3)->where("plano_id",3)
            ->whereHas('comissao.comissoesLancadas',function($query){
                $query->where("status_financeiro",0);
                $query->where("status_gerente",0);
                $query->where("parcela",1);
                $query->whereRaw("data_baixa IS NULL");
            })
            ->count();
            //->whereRaw("NOW() > date_add(updated_at, INTERVAL 30 SECOND)")
            // ->whereRaw("tempo >= now()")
            //->count();

        $qtd_coletivo_pg_vigencia = Contrato
            ::where("plano_id",3)
            ->whereHas('comissao.comissoesLancadas',function($query){
                $query->where("status_financeiro",0);
                $query->where("status_gerente",0);
                $query->where("parcela",2);
                $query->where("atual",1);
                $query->whereRaw("data_baixa IS NULL");

            })
            ->count();



            //->whereRaw("NOW() > date_add(updated_at, INTERVAL 30 SECOND)")
            // ->whereRaw("tempo >= now()")


        $qtd_coletivo_03_parcela = Contrato
            //::where('financeiro_id',6)
            ::where("plano_id",3)
            ->whereHas('comissao.comissoesLancadas',function($query){
                $query->where("status_financeiro",0);
                $query->where("status_gerente",0);
                $query->where("parcela",3);
                $query->whereRaw("data_baixa IS NULL");
                $query->where("atual",1);
            })
            //->whereRaw("NOW() > date_add(updated_at, INTERVAL 30 SECOND)")
            //->whereRaw("data_boleto >= date_add(data_boleto, interval 1 day)")
            // ->whereRaw("tempo >= now()")
            ->count();


        $qtd_coletivo_04_parcela = Contrato
            //::where('financeiro_id',8)
            ::where("plano_id",3)
            ->whereHas('comissao.comissoesLancadas',function($query){
                $query->where("status_financeiro",0);
                $query->where("status_gerente",0);
                $query->where("parcela",4);
                $query->whereRaw("data_baixa IS NULL");
                $query->where("atual",1);
            })
            //->whereRaw("data_boleto >= date_add(data_boleto, interval 1 day)")
            //->whereRaw("NOW() > date_add(updated_at, INTERVAL 30 SECOND)")
            // ->whereRaw("tempo >= now()")
            ->count();

        $qtd_coletivo_05_parcela = Contrato
            //::where('financeiro_id',9)
            ::where("plano_id",3)
            ->whereHas('comissao.comissoesLancadas',function($query){
                $query->where("status_financeiro",0);
                $query->where("status_gerente",0);
                $query->where("parcela",5);
                $query->whereRaw("data_baixa IS NULL");
                $query->where("atual",1);
            })
            //->whereRaw("data_boleto >= date_add(data_boleto, interval 1 day)")
            //->whereRaw("NOW() > date_add(updated_at, INTERVAL 30 SECOND)")
            // ->whereRaw("tempo >= now()")
            ->count();

        $qtd_coletivo_06_parcela = Contrato
            //::where('financeiro_id',10)
            ::where("plano_id",3)
            ->whereHas('comissao.comissoesLancadas',function($query){
                $query->where("status_financeiro",0);
                $query->where("status_gerente",0);
                $query->where("parcela",6);
                $query->whereRaw("data_baixa IS NULL");
                $query->where("atual",1);
            })
            //->whereRaw("data_boleto >= date_add(data_boleto, interval 1 day)")
            //->whereRaw("NOW() > date_add(updated_at, INTERVAL 30 SECOND)")
            // ->whereRaw("tempo >= now()")
            ->count();

        $qtd_coletivo_07_parcela = Contrato
            //::where('financeiro_id',10)
            ::where("plano_id",3)
            ->whereHas('comissao.comissoesLancadas',function($query){
                $query->where("status_financeiro",0);
                $query->where("status_gerente",0);
                $query->where("parcela",7);
                $query->whereRaw("data_baixa IS NULL");
                $query->where("atual",1);
            })
            //->whereRaw("data_boleto >= date_add(data_boleto, interval 1 day)")
            //->whereRaw("NOW() > date_add(updated_at, INTERVAL 30 SECOND)")
            // ->whereRaw("tempo >= now()")
            ->count();

        $qtd_total_vidas_coletivo = CotacaoFaixaEtaria::selectRaw("sum(quantidade) as total_vidas")->first()->total_vidas;
        $qtd_total_valor_coletivo = Contrato::selectRaw("sum(valor_plano) as total_valor")->first()->total_valor;



        //$total = $qtd_coletivo_em_analise + $qtd_coletivo_emissao_boleto + $qtd_coletivo_pg_adesao + $qtd_coletivo_pg_vigencia + $qtd_coletivo_03_parcela + $qtd_coletivo_04_parcela + $qtd_coletivo_05_parcela + $qtd_coletivo_06_parcela;

        $qtd_coletivo_finalizados = Contrato
            //->where('financeiro_id',11)
            ::where("plano_id",3)
            ->whereHas('comissao.comissoesLancadas',function($query){

                $query->where("parcela",7);
                $query->where("status_financeiro",1);
                $query->whereRaw("data_baixa IS NOT NULL");
            })
            //->whereRaw("data_boleto >= date_add(data_boleto, interval 1 day)")
            //->whereRaw("NOW() > date_add(updated_at, INTERVAL 30 SECOND)")
            // ->whereRaw("tempo >= now()")
            ->count();

        $qtd_coletivo_cancelados = Contrato::where('financeiro_id',12)
            ->where("plano_id",3)
            //->whereRaw("data_boleto >= date_add(data_boleto, interval 1 day)")
            //->whereRaw("NOW() > date_add(updated_at, INTERVAL 30 SECOND)")
            // ->whereRaw("tempo >= now()")
            ->count();
        $qtd_empresarial_pendentes = ContratoEmpresarial::count();
        $qtd_empresarial_em_analise = ContratoEmpresarial::where("financeiro_id",1)->count();
        $qtd_empresarial_parcela_01 = ContratoEmpresarial
        ::with("comissao")
        ->whereHas('comissao.comissoesLancadas',function($query){
            $query->where("status_financeiro",0);
            $query->where("status_gerente",0);
            $query->where("parcela",1);
            $query->whereRaw("data_baixa IS NULL");
        })
        ->where("financeiro_id",5)
        ->count();
        $qtd_empresarial_parcela_02 = ContratoEmpresarial
        ::with("comissao")
        ->whereHas('comissao.comissoesLancadas',function($query){
            $query->where("status_financeiro",0);
            $query->where("status_gerente",0);
            $query->where("parcela",2);
            $query->where("atual",1);
            $query->whereRaw("data_baixa IS NULL");
        })
        //->where("financeiro_id",6)
        ->count();
        $qtd_empresarial_parcela_03 = ContratoEmpresarial
        ::with("comissao")
        ->whereHas('comissao.comissoesLancadas',function($query){
            $query->where("status_financeiro",0);
            $query->where("status_gerente",0);
            $query->where("parcela",3);
            $query->where("atual",1);
            $query->whereRaw("data_baixa IS NULL");
        })
        //->where("financeiro_id",7)
        ->count();
        $qtd_empresarial_parcela_04 = ContratoEmpresarial
        ::with("comissao")
        ->whereHas('comissao.comissoesLancadas',function($query){
            $query->where("status_financeiro",0);
            $query->where("status_gerente",0);
            $query->where("parcela",4);
            $query->where("atual",1);
            $query->whereRaw("data_baixa IS NULL");
        })
        //->where("financeiro_id",8)
        ->count();
        $qtd_empresarial_parcela_05 = ContratoEmpresarial
        ::with("comissao")
        ->whereHas('comissao.comissoesLancadas',function($query){
            $query->where("status_financeiro",0);
            $query->where("status_gerente",0);
            $query->where("parcela",5);
            $query->where("atual",1);
            $query->whereRaw("data_baixa IS NULL");
        })
        //->where("financeiro_id",9)
        ->count();
        $qtd_empresarial_parcela_06 = ContratoEmpresarial
        ::with("comissao")
        ->whereHas('comissao.comissoesLancadas',function($query){
            $query->where("status_financeiro",0);
            $query->where("status_gerente",0);
            $query->where("parcela",6);
            $query->where("atual",1);
            $query->whereRaw("data_baixa IS NULL");
        })
        //->where("financeiro_id",10)
        ->count();
        $qtd_empresarial_finalizado = ContratoEmpresarial::where("financeiro_id",11)->count();
        $qtd_empresarial_cancelado = ContratoEmpresarial::where("financeiro_id",12)->count();

        return view('admin.pages.contratos.index',[

            "cidades" => $cidades,
            "administradoras" => $administradoras,
            "planos" => $planos,
            "planos_empresarial" => $plano_empresarial,
            "users" => $users,
            "origem_tabela" => $tabela_origem,
            "anos_coletivo" => $anos_coletivo,
            "meses" => $meses,
            "qtd_individual_pendentes" => $qtd_individual_pendentes,
            "qtd_individual_parcela_01" => $qtd_individual_parcela_01,
            "qtd_individual_parcela_02" => $qtd_individual_parcela_02,
            "qtd_individual_parcela_03" => $qtd_individual_parcela_03,
            "qtd_individual_parcela_04" => $qtd_individual_parcela_04,
            "qtd_individual_parcela_05" => $qtd_individual_parcela_05,
            "qtd_individual_parcela_06" => $qtd_individual_parcela_06,
            "qtd_individual_em_analise" => $qtd_individual_em_analise,
            "qtd_individual_finalizado" => $qtd_individual_finalizado,
            "qtd_individual_cancelado" => $qtd_individual_cancelado,

            "qtd_individual_atrasado" => $qtd_individual_atrasado,

            "qtd_coletivo_em_analise" => $qtd_coletivo_em_analise,
            "qtd_coletivo_emissao_boleto" => $qtd_coletivo_emissao_boleto,
            "qtd_coletivo_pg_adesao" => $qtd_coletivo_pg_adesao,
            "qtd_coletivo_pg_vigencia" => $qtd_coletivo_pg_vigencia,
            "qtd_coletivo_07_parcela" => $qtd_coletivo_07_parcela,
            "qtd_coletivo_03_parcela" => $qtd_coletivo_03_parcela,
            "qtd_coletivo_04_parcela" => $qtd_coletivo_04_parcela,
            "qtd_coletivo_05_parcela" => $qtd_coletivo_05_parcela,
            "qtd_coletivo_06_parcela" => $qtd_coletivo_06_parcela,
            "qtd_coletivo_finalizados" => $qtd_coletivo_finalizados,
            "qtd_coletivo_cancelados" => $qtd_coletivo_cancelados,
            "contratos_coletivo_total" => $contratos_coletivo_total,
            "qtd_total_vidas_coletivo" => $qtd_total_vidas_coletivo,
            "qtd_total_valor_coletivo" => $qtd_total_valor_coletivo,

            "qtd_empresarial_pendentes" => $qtd_empresarial_pendentes,
            "qtd_empresarial_parcela_01" => $qtd_empresarial_parcela_01,
            "qtd_empresarial_parcela_02" => $qtd_empresarial_parcela_02,
            "qtd_empresarial_parcela_03" => $qtd_empresarial_parcela_03,
            "qtd_empresarial_parcela_04" => $qtd_empresarial_parcela_04,
            "qtd_empresarial_parcela_05" => $qtd_empresarial_parcela_05,
            "qtd_empresarial_parcela_06" => $qtd_empresarial_parcela_06,
            "qtd_empresarial_em_analise" => $qtd_empresarial_em_analise,
            "qtd_empresarial_finalizado" => $qtd_empresarial_finalizado,
            "qtd_empresarial_cancelado" => $qtd_empresarial_cancelado

        ]);
    }

    public function exportarContratoExcel(Request $request)
    {
        $meses = ["01" => "Janeiro","02"=>"Fevereiro","03"=>"Março","04"=>"Abril","05"=>"Maio","06"=>"Junho","07"=>"Julho","08"=>"Agosto","09"=>"Setembro","10"=>"Outubro","11"=>"Novembro","12"=>"Dezembro"];
        $meses_folha = $meses[$request->mes];
        $nome = "folha_mes_".$meses_folha;
        return Excel::download(new ContratosExport($request->mes), $nome.'.xlsx');
    }


    public function formContratoCreate()
    {
        $origem_tabela = TabelaOrigens::all();
        return view('admin.pages.contratos.cadastrar-corretor',[
            'origem_tabela' => $origem_tabela
        ]);
    }

    public function listarTodosContratos(Request $request)
    {
        $comissao = Comissoes::with(["plano"])->get();
    }

    public function contrato()
    {
        // $contratos = Contrato
        //     ::where("plano_id",3)
        //     ->whereHas('clientes',function($query){
        //         $query->where("user_id",auth()->user()->id);
        //     })

        //     ->with(['administradora','financeiro','cidade','comissao','acomodacao','plano','comissao.comissaoAtualFinanceiro','comissao.comissaoAtualLast','somarCotacaoFaixaEtaria','clientes','clientes.user','clientes.dependentes'])
        //     ->orderBy("id","desc")
        //     ->get();
        // dd($contratos[0]->somarCotacaoFaixaEtaria[0]->soma);





        $id = auth()->user()->id;




        $contratos_coletivo_pendentes = Contrato
            ::where("plano_id",3)
            ->whereHas('clientes',function($query) use($id){
                $query->where("user_id",$id);
            })->count();


        $cidades = TabelaOrigens::all();
        $administradoras = Administradoras::whereRaw("id != (SELECT id FROM administradoras WHERE nome LIKE '%hapvida%')")->get();
        $planos = Planos::whereRaw("empresarial is null")->orWhere("empresarial",0)->get();
        $plano_empresarial = Planos::where("empresarial",1)->get();
        $users = User::where("id","!=",auth()->user()->id)->get();
        $tabela_origem = TabelaOrigens::all();

        $qtd_individual_pendentes = Contrato::where("plano_id",1)
            ->whereHas('clientes',function($query) use($id){
                $query->where("user_id",$id);
            })->count();

        $qtd_individual_em_analise = Contrato::where("financeiro_id",1)
            ->where("plano_id",1)
            ->whereHas('clientes',function($query) use($id){
                $query->where("user_id",$id);
            })->count();

        $qtd_individual_parcela_01 = Contrato
            ::where("plano_id",1)
            ->where("financeiro_id",5)
            ->whereHas('comissao.comissoesLancadas',function($query){
                //$query->where("status_financeiro",0);
                //$query->where("status_gerente",0);
                $query->where("parcela",1);
                //$query->whereRaw("data_baixa IS NULL");
            })
            ->whereHas('clientes',function($query) use($id){
                $query->where("user_id",$id);
            })->count();

        $qtd_individual_parcela_02 = Contrato
            ::where("plano_id",1)
            ->where("financeiro_id",6)
            ->whereHas('comissao.comissoesLancadas',function($query){
                //$query->where("status_financeiro",0);
                //$query->where("status_gerente",0);
                $query->where("parcela",2);
                //$query->whereRaw("data_baixa IS NULL");
            })
            ->whereHas('clientes',function($query) use($id){
                $query->where("user_id",$id);
            })->count();

        $qtd_individual_parcela_03 = Contrato
            ::where("plano_id",1)
            ->where("financeiro_id",7)
            ->whereHas('comissao.comissoesLancadas',function($query){
                //$query->where("status_financeiro","=",0);
                //$query->where("status_gerente",0);
                $query->where("parcela",3);
                //$query->whereRaw("data_baixa IS NULL");
            })
            ->whereHas('clientes',function($query) use($id){
                $query->where("user_id",$id);
            })->count();

        $qtd_individual_parcela_04 = Contrato
            ::where("plano_id",1)
            ->where("financeiro_id",8)
            ->whereHas('comissao.comissoesLancadas',function($query){
                //$query->where("status_financeiro","=",0);
                //$query->where("status_gerente",0);
                $query->where("parcela",4);
                //$query->whereRaw("data_baixa IS NULL");
            })
            ->whereHas('clientes',function($query) use($id){
                $query->where("user_id",$id);
            })->count();

        $qtd_individual_parcela_05 = Contrato
            ::where("plano_id",1)
            ->where("financeiro_id",9)
            ->whereHas('comissao.comissoesLancadas',function($query){
                //$query->where("status_financeiro","=",0);
                //$query->where("status_gerente",0);
                $query->where("parcela",5);
                //$query->whereRaw("data_baixa IS NULL");
            })
            ->whereHas('clientes',function($query) use($id){
                $query->where("user_id",$id);
            })->count();

        $qtd_individual_parcela_06 = Contrato
            ::where("plano_id",1)
            ->where("financeiro_id",10)
            ->whereHas('comissao.comissoesLancadas',function($query){
                //$query->where("status_financeiro","=",0);
                //$query->where("status_gerente",0);
                $query->where("parcela",6);
                //$query->whereRaw("data_baixa IS NULL");
            })
            ->whereHas('clientes',function($query) use($id){
                $query->where("user_id",$id);
            })->count();


        $qtd_individual_finalizado = Contrato::where("financeiro_id",11)
            ->where("plano_id",1)
            ->whereHas('clientes',function($query) use($id){
                $query->where("user_id",$id);
            })->count();

        $qtd_individual_cancelado = Contrato::where("financeiro_id",12)
            ->where("plano_id",1)
            ->whereHas('clientes',function($query) use($id){
                $query->where("user_id",$id);
            })->count();

        $qtd_coletivo_em_analise = Contrato::where("financeiro_id",1)
            ->where("plano_id",3)
            ->whereHas('clientes',function($query) use($id){
                $query->where("user_id",$id);
            })->count();

        $qtd_coletivo_emissao_boleto = Contrato::where("financeiro_id",2)
            ->where("plano_id",3)
            ->whereHas('clientes',function($query) use($id){
                $query->where("user_id",$id);
            })->count();

        $qtd_coletivo_pg_adesao = Contrato::where('financeiro_id',3)
            ->where("plano_id",3)
            ->whereHas('comissao.comissoesLancadas',function($query){
                $query->where("status_financeiro","=",0);
                $query->where("status_gerente",0);
                $query->where("parcela",1);
                $query->whereRaw("data_baixa IS NULL");
            })
            ->whereHas('clientes',function($query) use($id){
                $query->where("user_id",$id);
            })->count();

        $qtd_coletivo_pg_vigencia = Contrato
            ::where("plano_id",3)
            ->whereHas('comissao.comissoesLancadas',function($query){
                $query->where("status_financeiro","=",0);
                $query->where("status_gerente",0);
                $query->where("parcela",2);
                $query->where("atual",1);
                $query->whereRaw("data_baixa IS NULL");
            })
            ->whereHas('clientes',function($query) use($id){
                $query->where("user_id",$id);
            })->count();








        $qtd_coletivo_02_parcela = Contrato
            ::where("plano_id",3)
            ->whereHas('comissao.comissoesLancadas',function($query){
                $query->where("status_financeiro","=",0);
                $query->where("status_gerente",0);
                $query->where("parcela",3);
                $query->where("atual",1);
                $query->whereRaw("data_baixa IS NULL");
            })
            ->whereHas('clientes',function($query) use($id){
                $query->where("user_id",$id);
            })->count();

        $qtd_coletivo_03_parcela = Contrato

            ::where("plano_id",3)
            ->whereHas('comissao.comissoesLancadas',function($query){
                $query->where("status_financeiro","=",0);
                $query->where("status_gerente",0);
                $query->where("parcela",4);
                $query->where("atual",1);
                $query->whereRaw("data_baixa IS NULL");
            })
            ->whereHas('clientes',function($query) use($id){
                $query->where("user_id",$id);
            })->count();

        $qtd_coletivo_04_parcela = Contrato

            ::where("plano_id",3)
            ->whereHas('comissao.comissoesLancadas',function($query){
                $query->where("status_financeiro","=",0);
                $query->where("status_gerente",0);
                $query->where("parcela",5);
                $query->where("atual",1);
                $query->whereRaw("data_baixa IS NULL");
            })
            ->whereHas('clientes',function($query) use($id){
                $query->where("user_id",$id);
            })->count();

        $qtd_coletivo_05_parcela = Contrato

            ::where("plano_id",3)
            ->whereHas('comissao.comissoesLancadas',function($query){
                $query->where("status_financeiro","=",0);
                $query->where("status_gerente",0);
                $query->where("parcela",6);
                $query->where("atual",1);
                $query->whereRaw("data_baixa IS NULL");
            })
            ->whereHas('clientes',function($query) use($id){
                $query->where("user_id",$id);
            })->count();

        $qtd_coletivo_06_parcela = Contrato

            ::where("plano_id",3)
            ->whereHas('comissao.comissoesLancadas',function($query){
                $query->where("status_financeiro","=",0);
                $query->where("status_gerente",0);
                $query->where("parcela",7);
                $query->where("atual",1);
                $query->whereRaw("data_baixa IS NULL");
            })
            ->whereHas('clientes',function($query) use($id){
                $query->where("user_id",$id);
            })->count();

        $qtd_individual_atrasado = Contrato
            ::where("plano_id",1)
            ->where("financeiro_id","!=",12)
            ->whereHas('comissao.comissoesLancadas',function($query){
                $query->whereRaw("DATA < CURDATE()");
                //$query->whereRaw("valor > 0");
                $query->whereRaw("data_baixa IS NULL");
                $query->groupBy("comissoes_id");
            })
            ->whereHas('clientes',function($query) use($id){
                $query->whereRaw('cateirinha IS NOT NULL');
                $query->where("user_id",$id);
            })
            ->count();



        $total = $qtd_coletivo_em_analise + $qtd_coletivo_emissao_boleto + $qtd_coletivo_pg_adesao + $qtd_coletivo_pg_vigencia + $qtd_coletivo_02_parcela + $qtd_coletivo_03_parcela + $qtd_coletivo_04_parcela + $qtd_coletivo_05_parcela + $qtd_coletivo_06_parcela;

        $qtd_coletivo_finalizados = Contrato::where('financeiro_id',11)
            ->where("plano_id",3)
            ->whereHas('clientes',function($query) use($id){
                $query->where("user_id",$id);
            })->count();

        $qtd_coletivo_cancelados = Contrato::where('financeiro_id',12)
            ->where("plano_id",3)
            ->whereHas('clientes',function($query) use($id){
                $query->where("user_id",$id);
            })->count();

        $qtd_empresarial_pendentes = ContratoEmpresarial::count();
        $qtd_empresarial_em_analise = ContratoEmpresarial::where("financeiro_id",1)->count();

        $qtd_empresarial_parcela_01 = ContratoEmpresarial
        ::with("comissao")
        ->whereHas('comissao.comissoesLancadas',function($query){
            $query->where("status_financeiro",0);
            $query->where("status_gerente",0);
            $query->where("parcela",1);
            $query->whereRaw("data_baixa IS NULL");
        })
        ->where("financeiro_id",5)
        ->count();

        $qtd_empresarial_parcela_02 = ContratoEmpresarial
        ::with("comissao")
        ->whereHas('comissao.comissoesLancadas',function($query){
            $query->where("status_financeiro",0);
            $query->where("status_gerente",0);
            $query->where("parcela",2);
            $query->whereRaw("data_baixa IS NULL");
        })
        ->where("financeiro_id",6)
        ->count();

        $qtd_empresarial_parcela_03 = ContratoEmpresarial
        ::with("comissao")
        ->whereHas('comissao.comissoesLancadas',function($query){
            $query->where("status_financeiro",0);
            $query->where("status_gerente",0);
            $query->where("parcela",3);
            $query->whereRaw("data_baixa IS NULL");
        })
        ->where("financeiro_id",7)
        ->count();

        $qtd_empresarial_parcela_04 = ContratoEmpresarial
        ::with("comissao")
        ->whereHas('comissao.comissoesLancadas',function($query){
            $query->where("status_financeiro",0);
            $query->where("status_gerente",0);
            $query->where("parcela",4);
            $query->whereRaw("data_baixa IS NULL");
        })
        ->where("financeiro_id",8)
        ->count();

        $qtd_empresarial_parcela_05 = ContratoEmpresarial
        ::with("comissao")
        ->whereHas('comissao.comissoesLancadas',function($query){
            $query->where("status_financeiro",0);
            $query->where("status_gerente",0);
            $query->where("parcela",5);
            $query->whereRaw("data_baixa IS NULL");
        })
        ->where("financeiro_id",9)
        ->count();


        $qtd_empresarial_parcela_06 = ContratoEmpresarial
        ::with("comissao")
        ->whereHas('comissao.comissoesLancadas',function($query){
            $query->where("status_financeiro",0);
            $query->where("status_gerente",0);
            $query->where("parcela",6);
            $query->whereRaw("data_baixa IS NULL");
        })
        ->where("financeiro_id",10)
        ->count();

        $qtd_empresarial_finalizado = ContratoEmpresarial::where("financeiro_id",11)->count();

        $qtd_empresarial_cancelado = ContratoEmpresarial::where("financeiro_id",12)->count();



        return view('admin.pages.contratos.contrato',[

            "cidades" => $cidades,
            "administradoras" => $administradoras,
            "planos" => $planos,
            "planos_empresarial" => $plano_empresarial,
            "users" => $users,
            "origem_tabela" => $tabela_origem,
            "qtd_individual_atrasado" => $qtd_individual_atrasado,
            "contratos_coletivo_pendentes" => $contratos_coletivo_pendentes,
            "qtd_empresarial_pendentes" => $qtd_empresarial_pendentes,
            "qtd_empresarial_parcela_01" => $qtd_empresarial_parcela_01,
            "qtd_empresarial_parcela_02" => $qtd_empresarial_parcela_02,
            "qtd_empresarial_parcela_03" => $qtd_empresarial_parcela_03,
            "qtd_empresarial_parcela_04" => $qtd_empresarial_parcela_04,
            "qtd_empresarial_parcela_05" => $qtd_empresarial_parcela_05,
            "qtd_empresarial_parcela_06" => $qtd_empresarial_parcela_06,
            "qtd_empresarial_em_analise" => $qtd_empresarial_em_analise,
            "qtd_empresarial_finalizado" => $qtd_empresarial_finalizado,
            "qtd_empresarial_cancelado" => $qtd_empresarial_cancelado,

            "qtd_individual_pendentes" => $qtd_individual_pendentes,
            "qtd_individual_parcela_01" => $qtd_individual_parcela_01,
            "qtd_individual_parcela_02" => $qtd_individual_parcela_02,
            "qtd_individual_parcela_03" => $qtd_individual_parcela_03,
            "qtd_individual_parcela_04" => $qtd_individual_parcela_04,
            "qtd_individual_parcela_05" => $qtd_individual_parcela_05,
            "qtd_individual_parcela_06" => $qtd_individual_parcela_06,
            "qtd_individual_em_analise" => $qtd_individual_em_analise,
            "qtd_individual_finalizado" => $qtd_individual_finalizado,
            "qtd_individual_cancelado" => $qtd_individual_cancelado,

            "qtd_coletivo_em_analise" => $qtd_coletivo_em_analise,
            "qtd_coletivo_emissao_boleto" => $qtd_coletivo_emissao_boleto,
            "qtd_coletivo_pg_adesao" => $qtd_coletivo_pg_adesao,
            "qtd_coletivo_pg_vigencia" => $qtd_coletivo_pg_vigencia,
            "qtd_coletivo_02_parcela" => $qtd_coletivo_02_parcela,
            "qtd_coletivo_03_parcela" => $qtd_coletivo_03_parcela,
            "qtd_coletivo_04_parcela" => $qtd_coletivo_04_parcela,
            "qtd_coletivo_05_parcela" => $qtd_coletivo_05_parcela,
            "qtd_coletivo_06_parcela" => $qtd_coletivo_06_parcela,
            "qtd_coletivo_finalizados" => $qtd_coletivo_finalizados,
            "qtd_coletivo_cancelados" => $qtd_coletivo_cancelados




        ]);

























    }











    public function geralIndividualPendentes(Request $request)
    {
        $contratos = Contrato
            ::where("plano_id",1)

            ->with(['administradora','financeiro','cidade','comissao','acomodacao','plano','comissao.comissaoAtualFinanceiro','comissao.comissaoAtualLast','somarCotacaoFaixaEtaria','clientes','clientes.user','clientes.dependentes'])
            ->orderBy("id","desc")
            ->get();
        return $contratos;
    }

    public function geralIndividualPendentesCorretor(Request $request)
    {
        $contratos = Contrato
            ::where("plano_id",1)
            ->whereHas('clientes',function($query){
                $query->where("user_id",auth()->user()->id);
            })
            ->with(['administradora','financeiro','cidade','comissao','acomodacao','plano','comissao.comissaoAtualFinanceiro','comissao.comissaoAtualLast','somarCotacaoFaixaEtaria','clientes','clientes.user','clientes.dependentes'])
            ->orderBy("id","desc")
            ->get();
        return $contratos;
    }





    public function geralColetivoPendentes(Request $request)
    {
        $contratos = Contrato
            ::where("plano_id",3)
            ->with(['administradora','financeiro','cidade','comissao','acomodacao','plano','comissao.comissaoAtualFinanceiro','comissao.comissaoAtualLast','somarCotacaoFaixaEtaria','clientes','clientes.user','clientes.dependentes'])
            ->orderBy("id","desc")
            ->get();
        return $contratos;
    }

    public function geralColetivoPendentesCorretor(Request $request)
    {
        $contratos = Contrato
            ::where("plano_id",3)
            ->whereHas('clientes',function($query){
                $query->where("user_id",auth()->user()->id);
            })

            ->with(['administradora','financeiro','cidade','comissao','acomodacao','plano','comissao.comissaoAtualFinanceiro','comissao.comissaoAtualLast','somarCotacaoFaixaEtaria','clientes','clientes.user','clientes.dependentes'])
            ->orderBy("id","desc")
            ->get();
        return $contratos;
    }




    public function geralEmpresarialPendentes(Request $request)
    {
        $contratos = ContratoEmpresarial::count();
        // $contratos = Contrato
        //     ::where("plano_id",3)
        //     ->with(['administradora','financeiro','cidade','comissao','acomodacao','plano','comissao.comissaoAtualFinanceiro','comissao.comissaoAtualLast','somarCotacaoFaixaEtaria','clientes','clientes.user','clientes.dependentes'])
        //     ->orderBy("id","desc")
        //     ->get();
        // return $contratos;
    }





    public function listarEmpresarialPorUser(Request $request)
    {
        if($request->ajax()) {
            $user_id = User::where("name",$request->user)->first()->id;
            return ContratoEmpresarial
                ::selectRaw("(SELECT name FROM users WHERE users.id = contrato_empresarial.user_id) as usuario")
                ->selectRaw("(SELECT nome FROM planos WHERE plano_empresarial.plano_id = planos.id) as plano")
                ->selectRaw("quantidade_vidas,cnpj,razao_social,codigo_vendedor,codigo_cliente,codigo_corretora,taxa_adesao,valor_plano,valor_total,vencimento_boleto,valor_boleto,codigo_cliente")
                ->whereRaw("user_id = 2")
                ->get();
        }
    }

    public function montarPlanos(Request $request)
    {
        $sql = "";
        $chaves = [];
        foreach($request->faixas[0] as $k => $v) {
            if($v != null AND $v != 0) {
                $sql .= "WHEN (SELECT id FROM faixa_etarias WHERE faixa_etarias.id = tabelas.faixa_etaria_id) = $k THEN $v ";
                $chaves[] = $k;
            }
        }

        $administradora = $request->administradora_id;
        $chaves = implode(",",$chaves);
        $cidade = $request->tabela_origem;
        $odonto = $request->odonto == "sim" ? 1 : 0;
        $coparticipacao = $request->coparticipacao == "sim" ? 1 : 0;

        $dados = DB::select("SELECT
            id,
            (select logo from administradoras where administradoras.id = tabelas.administradora_id) as logo,
            (select id from administradoras where administradoras.id = tabelas.administradora_id) as administradora,
            tabela_origens_id,
            (select nome from planos where planos.id = tabelas.plano_id) as planos,
            (select nome from acomodacoes where acomodacoes.id = tabelas.acomodacao_id) as acomodacao,

            (select nome from faixa_etarias where faixa_etarias.id = tabelas.faixa_etaria_id) as faixa,
            if(coparticipacao,'Com Coparticipação','Sem Coparticipação') as coparticipacao,
            if(odonto,'Com Odonto','Sem Odonto') as odonto,
        CASE
            $sql
        ELSE 0
        END AS quantidade,
        valor,
        CONCAT('card_',acomodacao_id) AS card
        FROM tabelas
        WHERE faixa_etaria_id IN($chaves) AND tabela_origens_id =  $cidade AND administradora_id = $administradora AND odonto = $odonto AND coparticipacao = $coparticipacao");

        return view("admin.pages.contratos.acomodacao",[
            "dados" => $dados,
            "card_inicial" => $dados[0]->card,
            "quantidade" => count($dados)
        ]);



        // $cliente = new Cliente();
        // $cliente->user_id = $request->user;
        // // $cliente->nome = $request->nome;
        // // $cliente->cidade = $request->cidade;
        // // $cliente->celular = $request->celular;
        // // $cliente->email = $request->email;
        // // $cliente->cpf = $request->cpf;
        // // $cliente->data_nascimento = date('Y-m-d',strtotime($request->data_nascimento));
        // // $cliente->cep = $request->cep;
        // // $cliente->rua = $request->rua;
        // // $cliente->bairro = $request->bairro;
        // // $cliente->complemento = $request->complemento;
        // // $cliente->uf = $request->uf;
        // // $cliente->pessoa_fisica = 1;
        // // $cliente->pessoa_juridica = 0;
        // // $cliente->dependente = ($request->dependente == "on" ? 1 : 0);
        // $cliente->save();
        // // if($cliente->dependente == "true") {
        // //     $dependente = new Dependentes();
        // //     $dependente->cliente_id = $cliente->id;
        // //     $dependente->nome = $request->responsavel_nome;
        // //     $dependente->cpf = $request->responsavel_cpf;
        // //     $dependente->save();
        // // }
        // $contrato = new Contrato();
        // $contrato->cliente_id = $cliente->id;
        // $contrato->administradora_id = $request->administradora;
        // $contrato->tabela_origens_id = $request->tabela_origens_id;
        // $contrato->plano_id = (!empty($request->plano) ? $request->plano : 3);
        // $contrato->financeiro_id = 1;
        // $contrato->coparticipacao = ($request->coparticipacao == "sim" ? 1 : 0);
        // $contrato->odonto = ($request->odonto == "sim" ? 1 : 0);
        // $contrato->codigo_externo = $request->codigo_externo;
        // $contrato->save();
        // $faixas = $request->faixas;
        // foreach($faixas as $k => $v) {
        //     if($v != 0) {
        //         $orcamentoFaixaEtaria = new CotacaoFaixaEtaria();
        //         $orcamentoFaixaEtaria->contrato_id = $contrato->id;
        //         $orcamentoFaixaEtaria->faixa_etaria_id = $k;
        //         $orcamentoFaixaEtaria->quantidade = $v;
        //         $orcamentoFaixaEtaria->save();
        //     }
        // }

        // $cot = $contrato;
        // $valores = DB::table("cotacao_faixa_etarias")
        // ->join("tabelas","tabelas.faixa_etaria_id","=","cotacao_faixa_etarias.faixa_etaria_id")
        // ->selectRaw("sum(valor * (SELECT quantidade FROM cotacao_faixa_etarias WHERE contrato_id = ".$cot->id." AND cotacao_faixa_etarias.faixa_etaria_id = tabelas.faixa_etaria_id)) AS total")
        // ->selectRaw("(SELECT id FROM acomodacoes WHERE tabelas.acomodacao_id = acomodacoes.id) AS id_acomodacao")
        // ->selectRaw("(SELECT nome FROM acomodacoes WHERE acomodacoes.id = tabelas.acomodacao_id) as modelo")
        // ->selectRaw("(SELECT nome FROM planos WHERE tabelas.plano_id = planos.id) AS plano")
        // ->selectRaw("if(coparticipacao = 0,'Sem Coparticipacao','Com Coparticipacao') AS coparticipacao")
        // ->selectRaw("if(odonto = 0,'Sem Odonto','Com Odonto') AS odonto")
        // ->selectRaw("(SELECT logo FROM administradoras WHERE administradoras.id = tabelas.administradora_id) AS operadora")
        // ->whereRaw("tabelas.tabela_origens_id = ".$request->tabela_origens_id." AND tabelas.administradora_id = ".$request->administradora." AND odonto = ".($request->odonto == "sim" ? 1 : 0)." AND coparticipacao = ".($request->coparticipacao == "sim" ? 1 : 0)." AND tabelas.plano_id = ".(!empty($request->plano) ? $request->plano : 3)." AND cotacao_faixa_etarias.contrato_id = ".$cot->id)
        // ->groupBy('acomodacao_id')
        // ->get();


        // $faixas_etarias = DB::table("cotacao_faixa_etarias")
        // ->join("tabelas","tabelas.faixa_etaria_id","=","cotacao_faixa_etarias.faixa_etaria_id")
        // ->selectRaw("(SELECT nome FROM faixa_etarias WHERE faixa_etarias.id = cotacao_faixa_etarias.faixa_etaria_id) AS faixas")
        // ->selectRaw("quantidade,valor")
        // ->selectRaw("(SELECT nome FROM acomodacoes WHERE acomodacoes.id = tabelas.acomodacao_id) as modelo")
        // ->selectRaw("(cotacao_faixa_etarias.quantidade * tabelas.valor) AS total")
        // ->whereRaw("contrato_id = ? AND administradora_id = ? AND tabela_origens_id = ? AND odonto = ? AND coparticipacao = ? AND plano_id = ?",[$cot->id,$request->administradora,$request->tabela_origens_id,($request->odonto == "sim" ? 1 : 0),($request->coparticipacao == "sim" ? 1 : 0),(!empty($request->plano) ? $request->plano : 3)])
        // ->get();

        // return view("admin.pages.contratos.acomodacao",[
        //     "valores" => $valores,
        //     "faixas" => $faixas_etarias,
        //     "contrato" => $cot->id,
        //     "user" => $request->user,
        //     "tabela_origem" => $request->tabela_origens_id,
        //     "administradora" => $request->administradora,
        //     "cliente" => $cliente->id
        // ]);
    }


    public function montarPlanosIndividual(Request $request)
    {
        $sql = "";
        $chaves = [];
        foreach($request->faixas[0] as $k => $v) {
            if($v != null AND $v != 0) {
                $sql .= "WHEN (SELECT id FROM faixa_etarias WHERE faixa_etarias.id = tabelas.faixa_etaria_id) = $k THEN $v ";
                $chaves[] = $k;
            }
        }


        $chaves = implode(",",$chaves);
        $cidade = $request->tabela_origem;
        $odonto = $request->odonto == "sim" ? 1 : 0;
        $coparticipacao = $request->coparticipacao == "sim" ? 1 : 0;

        $dados = DB::select("SELECT
            id,
            (select logo from administradoras where administradoras.id = tabelas.administradora_id) as logo,
            (select id from administradoras where administradoras.id = tabelas.administradora_id) as administradora,
            tabela_origens_id,
            (select nome from planos where planos.id = tabelas.plano_id) as planos,
            (select nome from acomodacoes where acomodacoes.id = tabelas.acomodacao_id) as acomodacao,

            (select nome from faixa_etarias where faixa_etarias.id = tabelas.faixa_etaria_id) as faixa,
            if(coparticipacao,'Com Coparticipação','Sem Coparticipação') as coparticipacao,
            if(odonto,'Com Odonto','Sem Odonto') as odonto,
        CASE
            $sql
        ELSE 0
        END AS quantidade,
        valor,
        CONCAT('card_',acomodacao_id) AS card
        FROM tabelas
        WHERE faixa_etaria_id IN($chaves) AND tabela_origens_id =  $cidade AND administradora_id = 4 AND plano_id = 1 AND odonto = $odonto AND coparticipacao = $coparticipacao");
        return view("admin.pages.contratos.acomodacao",[
            "dados" => $dados,
            "card_inicial" => $dados[0]->card,
            "quantidade" => count($dados)
        ]);
    }


    public function storeIndividual(Request $request)
    {

        $cpf = str_replace([".","-"],"",$request->cpf_individual);
        $dia = $request->vencimento;
        $codigo_externo = $request->codigo_externo_individual;
        $url = "https://api-hapvida.sensedia.com/wssrvonline/v1/beneficiario?cpf={$cpf}";
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $dados = (array) json_decode(curl_exec($ch),true);
        $resultado = array_filter($dados, function($item) use($codigo_externo) {
            return $item['tipoPlanoC'] === 'SAUDE' &&
                $item['nomeEmpresa'] === 'I N D I V I D U A L' &&
                $item['nuMatriculaEmpresa'] == $codigo_externo;
        });
        $resultado = array_values($resultado);

        if(count($resultado) == 0) {
            return "sem_resultado";
        }



        $valores_numericos = array_filter($request->faixas_etarias, function ($valor) {
            return is_numeric($valor);
        });
        $quantidade_vidas = array_sum($valores_numericos);
        $valor = str_replace([".",","],["","."],$request->valor);
        $cliente = new Cliente();
        $cliente->user_id = $request->users_individual;
        $cliente->nome = $request->nome_individual;
        $cliente->cidade = $request->cidade_origem_individual;
        $cliente->celular = $request->celular_individual;
        $cliente->telefone = $request->telefone_individual;
        $cliente->email = $request->email_individual;
        $cliente->cpf = $request->cpf_individual;
        $cliente->data_nascimento = date('Y-m-d',strtotime($request->data_nascimento_individual));
        $cliente->cep = $request->cep_individual;
        $cliente->rua = $request->rua_individual;
        $cliente->bairro = $request->bairro_individual;
        $cliente->complemento = $request->complemento_individual;
        $cliente->uf = $request->uf_individual;
        $cliente->pessoa_fisica = 1;
        $cliente->pessoa_juridica = 0;
        $cliente->dependente = ($request->dependente_individual == "on" ? 1 : 0);
        $cliente->quantidade_vidas = $quantidade_vidas;
        $cliente->nm_plano = $resultado[0]['nmPlano'];
        $cliente->numero_registro_plano = $resultado[0]['nuRegistroPlano'];
        $cliente->rede_plano = $resultado[0]['redePlano'];
        $cliente->tipo_acomodacao_plano = $resultado[0]['tipoAcomodacaoPlano'];
        $cliente->segmentacao_plano = $resultado[0]['segmentacaoPlano'];
        $cliente->cateirinha = $resultado[0]['cdUsuario'];
        $cliente->dados = 1;
        $cliente->save();

        if($cliente->dependente) {
            $dependente = new Dependentes();
            $dependente->cliente_id = $cliente->id;
            $dependente->nome = $request->responsavel_financeiro_individual_cadastro;
            $dependente->cpf = $request->cpf_financeiro_individual_cadastro;
            $dependente->save();
        }


        $acomodacao = $request->acomodacao;
        $acomodacao_id = Acomodacao::selectRaw('id')->whereRaw("nome LIKE '%{$acomodacao}%'")->first()->id;
        $data_vigencia = $request->data_vigencia;
        $data_boleto = $request->data_boleto;
        $valor_adesao = str_replace([".",","],["","."],$request->valor_adesao);
        $valor_plano = str_replace([".",","],["","."],$request->valor);

        $contrato = new Contrato();
        $contrato->cliente_id = $cliente->id;
        $contrato->administradora_id = $request->administradora;
        $contrato->acomodacao_id = $acomodacao_id;
        $contrato->tabela_origens_id = $request->tabela_origem_individual;
        $contrato->plano_id = 1;
        $contrato->financeiro_id = 1;
        $contrato->coparticipacao = ($request->coparticipacao_individual == "sim" ? 1 : 0);
        $contrato->odonto = ($request->odonto_individual == "sim" ? 1 : 0);
        $contrato->codigo_externo = $request->codigo_externo_individual;
        $contrato->data_vigencia = $data_vigencia;
        $contrato->data_boleto = $data_boleto;
        $contrato->valor_adesao = $valor_adesao;
        $contrato->valor_plano = $valor_plano;
        $contrato->save();

        // CotacaoFaixaEtaria::where("contrato_id",$contrato->id)->delete();
        $totalVidas = 0;
        $faixas = $request->faixas_etarias;
        foreach($faixas as $k => $v) {
            if($v != 0) {
                $orcamentoFaixaEtaria = new CotacaoFaixaEtaria();
                $orcamentoFaixaEtaria->contrato_id = $contrato->id;
                $orcamentoFaixaEtaria->faixa_etaria_id = $k;
                $orcamentoFaixaEtaria->quantidade = $v;
                $orcamentoFaixaEtaria->save();
                $totalVidas += $v;
            }
        }

        $comissao = new Comissoes();
        $comissao->contrato_id = $contrato->id;
        // $comissao->cliente_id = $contrato->cliente_id;
        $comissao->user_id = $request->users_individual;
        // $comissao->status = 1;
        $comissao->plano_id = 1;
        $comissao->administradora_id = 4;
        $comissao->tabela_origens_id = $request->tabela_origem_individual;
        $comissao->data = date('Y-m-d');
        $comissao->save();

        $comissoes_configuradas_corretor = ComissoesCorretoresConfiguracoes
            ::where("plano_id",1)
            ->where("administradora_id",4)
            ->where("user_id",$request->users_individual)
            ->where("tabela_origens_id",2)
            ->get();

        $comissao_corretor_contagem = 0;
        $comissao_corretor_default = 0;

        if(count($comissoes_configuradas_corretor) >= 1) {
            foreach($comissoes_configuradas_corretor as $c) {
                $valor_comissao = $valor_plano - 25;
                $comissaoVendedor = new ComissoesCorretoresLancadas();
                $comissaoVendedor->comissoes_id = $comissao->id;
                $comissaoVendedor->parcela = $c->parcela;
                $comissaoVendedor->valor = ($valor_comissao * $c->valor) / 100;
                if($comissao_corretor_contagem == 0) {
                    $comissaoVendedor->data = $data_vigencia;
                    $comissaoVendedor->status_financeiro = 1;
                    if($comissaoVendedor->valor == "0.00" || $comissaoVendedor->valor == 0 || $comissaoVendedor->valor >= 0) {

                    }
                    $comissaoVendedor->data_baixa = implode("-",array_reverse(explode("/",$data_vigencia)));
                    $comissaoVendedor->valor_pago = $valor_adesao;
                } else {
                    $data_vigencia_sem_dia = date("Y-m",strtotime($data_vigencia));
                    $dates = date("Y-m",strtotime($data_vigencia_sem_dia."+{$comissao_corretor_contagem}month"));

                    $mes = explode("-",$dates)[1];
                    if($dia == 30 && $mes == 02) {
                        $comissaoVendedor->data = date("Y-02-28");
                        $ano = explode("-",$comissaoVendedor->data)[0];
                        $bissexto= date('L', mktime(0, 0, 0, 1, 1, $ano));

                        if($bissexto == 1) {
                            $comissaoVendedor->data = date("Y-02-29");
                        } else {
                            $comissaoVendedor->data = date("Y-02-28");
                        }

                    }  else {
                        $comissaoVendedor->data = date("Y-m-".$dia,strtotime($dates));
                    }

                }
                $comissaoVendedor->save();
                $comissao_corretor_contagem++;
            }
        } else {

            $dados = ComissoesCorretoresDefault
                ::where("plano_id",1)
                ->where("administradora_id",4)
                ->where("tabela_origens_id",2)
                ->get();
            foreach($dados as $c) {
                $valor_comissao_default = $valor_plano - 25;


                $comissaoVendedor = new ComissoesCorretoresLancadas();
                $comissaoVendedor->comissoes_id = $comissao->id;
                $comissaoVendedor->parcela = $c->parcela;
                $comissaoVendedor->valor = ($valor_comissao_default * $c->valor) / 100;

                if($comissao_corretor_default == 0) {
                    $comissaoVendedor->data = $data_vigencia;
                    $comissaoVendedor->status_financeiro = 1;
                    if($comissaoVendedor->valor == "0.00" || $comissaoVendedor->valor == 0 || $comissaoVendedor->valor >= 0) {

                    }
                    $comissaoVendedor->data_baixa = implode("-",array_reverse(explode("/",$data_vigencia)));
                    $comissaoVendedor->valor_pago = $valor_adesao;
                } else {
                    $data_vigencia_sem_dia = date("Y-m",strtotime($data_vigencia));
                    $dates = date("Y-m",strtotime($data_vigencia_sem_dia."+{$comissao_corretor_default}month"));

                    $mes = explode("-",$dates)[1];
                    if($dia == 30 && $mes == 02) {
                        $comissaoVendedor->data = date("Y-02-28");
                        $ano = explode("-",$comissaoVendedor->data)[0];
                        $bissexto= date('L', mktime(0, 0, 0, 1, 1, $ano));

                        if($bissexto == 1) {
                            $comissaoVendedor->data = date("Y-02-29");
                        } else {
                            $comissaoVendedor->data = date("Y-02-28");
                        }

                    }  else {
                        $comissaoVendedor->data = date("Y-m-".$dia,strtotime($dates));
                    }

                }
                $comissaoVendedor->save();
                $comissao_corretor_default++;
            }
        } /****FIm SE Comissoes Lancadas */


        $cat = $resultado[0]['cdUsuario'];
        $url = "https://api-hapvida.sensedia.com/wssrvonline/v1/beneficiario/$cat/financeiro/historico";
        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_URL, $url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
        $resp=curl_exec($curl);
        curl_close($curl);
        $dados=json_decode($resp);
        $data="";
        $docu="";
        if(!empty($dados) && $dados != null) {
            foreach($dados as $d) {
                if($d->dtPagamento != null && $d->cdStatus != 16) {
                    $mes = explode("/",$d->dtVencimento);
                    $data_baixa = implode("-",array_reverse(explode('/',$d->dtPagamento)));
                    $docu = $d->cdDocumentoGerador;
                    ComissoesCorretoresLancadas
                        ::whereRaw("DATE_FORMAT(data,'%m') = ?",$mes[1])
                        ->where("comissoes_id",$comissao->id)
                        ->where("status_financeiro","!=",1)
                        ->update([
                            'status_financeiro'=>1,
                            'valor_pago' => $d->vlObrigacao,
                            'data_baixa'=>$data_baixa
                        ]);
                }


                if($d->cdStatus == 8 && $d->dsStatus == "CANCELADO") {
                    $canc = new ComissoesCorretoresCancelados();
                    $canc->comissoes_id = $comissao->id;
                    $canc->data = implode("-",array_reverse(explode('/',$d->dtVencimento)));
                    $canc->documento_gerador = $d->cdDocumentoGerador;
                    $canc->save();
                }




            }
        }



        $comissoesLancadas = ComissoesCorretoresLancadas
            ::where("status_financeiro",1)
            //->where("status_gerente",1)
            ->where("parcela","!=",1)
            ->where("comissoes_id",$comissao->id)
            ->orderByDesc('id')
            ->limit(1)
            ->first();

        switch($comissoesLancadas->parcela) {

            case 2:
                $con = Contrato::find($contrato->id);
                $con->financeiro_id = 6;
                $con->save();
            break;

            case 3:
                $con = Contrato::find($contrato->id);
                $con->financeiro_id = 7;
                $con->save();
            break;

            case 4:

                $con = Contrato::find($contrato->id);
                $con->financeiro_id = 8;
                $con->save();


            break;

            case 5:
                $con = Contrato::find($contrato->id);
                $con->financeiro_id = 9;
                $con->save();


                break;

            case 6:
                $con = Contrato::find($contrato->id);
                $con->financeiro_id = 10;
                $con->save();
                break;
        }



        /** Comissao Corretora */
        $comissoes_configurada_corretora = ComissoesCorretoraConfiguracoes::where("administradora_id",4)
        ->where('plano_id',1)
        ->where('tabela_origens_id',$request->tabela_origem_individual)
        ->get();
        $comissoes_corretora_contagem=0;
        if(count($comissoes_configurada_corretora)>=1) {
            foreach($comissoes_configurada_corretora as $cc) {
                $comissaoCorretoraLancadas = new ComissoesCorretoraLancadas();
                $comissaoCorretoraLancadas->comissoes_id = $comissao->id;
                $comissaoCorretoraLancadas->parcela = $cc->parcela;
                if($comissoes_corretora_contagem == 0) {
                    $comissaoCorretoraLancadas->data = date('Y-m-d',strtotime($request->data_boleto));

                } else {
                    $comissaoCorretoraLancadas->data = date("Y-m-d",strtotime($request->data_boleto."+{$comissoes_corretora_contagem}month"));
                }
                $comissaoCorretoraLancadas->valor = ($valor * $cc->valor) / 100;
                $comissaoCorretoraLancadas->save();
                $comissoes_corretora_contagem++;
            }
        }



        if($request->tipo_cadastro == "administrador_cadastro") {
            return "contratos";
        } else {
            return "contrato";
        }

    }

    public function listarContratoEmpresaPendentes(Request $request)
    {
        if($request->ajax()) {
            $cacheKey = 'listarContratoEmpresaPendentes';
            $tempoDeExpiracao = 60;
            $resultado = Cache::remember($cacheKey, $tempoDeExpiracao, function () {
                return DB::select("
                    select
                    date_format(contrato_empresarial.created_at,'%d/%m/%Y') as created_at,
                    codigo_externo as codigo_externo,
                    users.name as usuario,
                    razao_social,
                    cnpj,
                    quantidade_vidas,
                    valor_plano,
                    planos.nome as plano,
                    (select date_format(data,'%d/%m/%Y') from comissoes_corretores_lancadas where comissoes_corretores_lancadas.comissoes_id = comissoes.id and comissoes_corretores_lancadas.status_financeiro = 0 and comissoes_corretores_lancadas.data_baixa IS NULL  LIMIT 1) as vencimento,
                    estagio_financeiros.nome as status,
                    contrato_empresarial.id as id
                    from contrato_empresarial
                    inner join comissoes on comissoes.contrato_empresarial_id = contrato_empresarial.id
                    inner join estagio_financeiros on estagio_financeiros.id = contrato_empresarial.financeiro_id
                    inner join users on users.id = comissoes.user_id
                    inner join planos on planos.id = comissoes.plano_id
                ");
            });
            return response()->json($resultado);
        }
    }

    


    public function empresarialQuantidadeMes(Request $request)
    {
        if($request->ajax()) {
            
            $qtd_empresarial_em_analise = ContratoEmpresarial::where("financeiro_id", 1)->whereMonth('created_at',$request->mes);
            $qtd_empresarial_parcela_01 = ContratoEmpresarial::where("financeiro_id", 5)->whereMonth('created_at',$request->mes);
            $qtd_empresarial_parcela_02 = ContratoEmpresarial::where("financeiro_id",6)->whereMonth('created_at',$request->mes);
            $qtd_empresarial_parcela_03 = ContratoEmpresarial::where("financeiro_id",7)->whereMonth('created_at',$request->mes);
            $qtd_empresarial_parcela_04 = ContratoEmpresarial::where("financeiro_id",8)->whereMonth('created_at',$request->mes);
            $qtd_empresarial_parcela_05 = ContratoEmpresarial::where("financeiro_id",9)->whereMonth('created_at',$request->mes);
            $qtd_empresarial_parcela_06 = ContratoEmpresarial::where("financeiro_id",10)->whereMonth('created_at',$request->mes);
            $qtd_empresarial_finalizado = ContratoEmpresarial::where("financeiro_id", 11)->whereMonth('created_at',$request->mes);
            $qtd_empresarial_cancelado = ContratoEmpresarial::where("financeiro_id", 12)->whereMonth('created_at',$request->mes);
            $qtd_empesarial_atrasado = ContratoEmpresarial
                ::where("financeiro_id", "!=", 12)
                ->whereMonth('created_at',$request->mes)
                ->whereHas('comissao.comissoesLancadas', function ($query) {
                    $query->whereRaw("DATA < CURDATE()");
                    //$query->whereRaw("valor > 0");
                    $query->whereRaw("data_baixa IS NULL");
                    $query->groupBy("comissoes_id");
                });

            $users = DB::select("
                SELECT users.name,users.id FROM contrato_empresarial 
                INNER JOIN users ON users.id = contrato_empresarial.user_id
                WHERE MONTH(contrato_empresarial.created_at) = {$request->mes}
                GROUP BY contrato_empresarial.user_id
            ");    

            return [
                "qtd_empresarial_em_analise" => $qtd_empresarial_em_analise->count(),
                "qtd_empresarial_parcela_01" => $qtd_empresarial_parcela_01->count(),
                "qtd_empresarial_parcela_02" => $qtd_empresarial_parcela_02->count(),
                "qtd_empresarial_parcela_03" => $qtd_empresarial_parcela_03->count(),
                "qtd_empresarial_parcela_04" => $qtd_empresarial_parcela_04->count(),
                "qtd_empresarial_parcela_05" => $qtd_empresarial_parcela_05->count(),
                "qtd_empresarial_parcela_06" => $qtd_empresarial_parcela_06->count(),
                "qtd_empresarial_finalizado" => $qtd_empresarial_finalizado->count(),
                "qtd_empresarial_cancelado" => $qtd_empresarial_cancelado->count(),
                "qtd_empesarial_atrasado" => $qtd_empesarial_atrasado->count(),
                "users" => $users

            ];




        }
        



    }

    public function mudarMesEmpresarial(Request $request)
    {
        $mes = 02;
        if($request->ajax()) {
            $cacheKey = 'listarContratoEmpresaPendentesMes';
            $tempoDeExpiracao = 60;
            $resultado = Cache::remember($cacheKey, $tempoDeExpiracao, function () use($mes) {
                return DB::select("
                    select
                    date_format(contrato_empresarial.created_at,'%d/%m/%Y') as created_at,
                    codigo_externo as codigo_externo,
                    users.name as usuario,
                    razao_social,
                    cnpj,
                    quantidade_vidas,
                    valor_plano,
                    planos.nome as plano,
                    (select date_format(data,'%d/%m/%Y') from comissoes_corretores_lancadas where comissoes_corretores_lancadas.comissoes_id = comissoes.id and comissoes_corretores_lancadas.status_financeiro = 0 and comissoes_corretores_lancadas.data_baixa IS NULL  LIMIT 1) as vencimento,
                    estagio_financeiros.nome as status,
                    contrato_empresarial.id as id
                    from contrato_empresarial
                    inner join comissoes on comissoes.contrato_empresarial_id = contrato_empresarial.id
                    inner join estagio_financeiros on estagio_financeiros.id = contrato_empresarial.financeiro_id
                    inner join users on users.id = comissoes.user_id
                    inner join planos on planos.id = comissoes.plano_id

                    where month(contrato_empresarial.created_at) = {$mes}

                ");
                
            });
            return response()->json($resultado);
        }
    }








    public function empresarialQuantidade(Request $request)
    {
        $qtd_empresarial_em_analise = ContratoEmpresarial::where("financeiro_id", 1);
        $qtd_empresarial_parcela_01 = ContratoEmpresarial::where("financeiro_id", 5);
        $qtd_empresarial_parcela_02 = ContratoEmpresarial::where("financeiro_id",6);
        $qtd_empresarial_parcela_03 = ContratoEmpresarial::where("financeiro_id",7);
        $qtd_empresarial_parcela_04 = ContratoEmpresarial::where("financeiro_id",8);
        $qtd_empresarial_parcela_05 = ContratoEmpresarial::where("financeiro_id",9);
        $qtd_empresarial_parcela_06 = ContratoEmpresarial::where("financeiro_id",10);
        $qtd_empresarial_finalizado = ContratoEmpresarial::where("financeiro_id", 11);
        $qtd_empresarial_cancelado = ContratoEmpresarial::where("financeiro_id", 12);
        $qtd_empesarial_atrasado = ContratoEmpresarial
            ::where("financeiro_id", "!=", 12)
            ->whereHas('comissao.comissoesLancadas', function ($query) {
                $query->whereRaw("DATA < CURDATE()");
                //$query->whereRaw("valor > 0");
                $query->whereRaw("data_baixa IS NULL");
                $query->groupBy("comissoes_id");
            });
                

        if($request->user_id == 0) {

            return [
                "qtd_empresarial_em_analise" => $qtd_empresarial_em_analise->count(),
                "qtd_empresarial_parcela_01" => $qtd_empresarial_parcela_01->count(),
                "qtd_empresarial_parcela_02" => $qtd_empresarial_parcela_02->count(),
                "qtd_empresarial_parcela_03" => $qtd_empresarial_parcela_03->count(),
                "qtd_empresarial_parcela_04" => $qtd_empresarial_parcela_04->count(),
                "qtd_empresarial_parcela_05" => $qtd_empresarial_parcela_05->count(),
                "qtd_empresarial_parcela_06" => $qtd_empresarial_parcela_06->count(),
                "qtd_empresarial_finalizado" => $qtd_empresarial_finalizado->count(),
                "qtd_empresarial_cancelado" => $qtd_empresarial_cancelado->count(),
                "qtd_empresarial_atrasado" => $qtd_empesarial_atrasado->count() 
              ];

        } else {

            return [
                "qtd_empresarial_em_analise" => $qtd_empresarial_em_analise->where("user_id",$request->user_id)->count(),
                "qtd_empresarial_parcela_01" => $qtd_empresarial_parcela_01->where("user_id",$request->user_id)->count(),
                "qtd_empresarial_parcela_02" => $qtd_empresarial_parcela_02->where("user_id",$request->user_id)->count(),
                "qtd_empresarial_parcela_03" => $qtd_empresarial_parcela_03->where("user_id",$request->user_id)->count(),
                "qtd_empresarial_parcela_04" => $qtd_empresarial_parcela_04->where("user_id",$request->user_id)->count(),
                "qtd_empresarial_parcela_05" => $qtd_empresarial_parcela_05->where("user_id",$request->user_id)->count(),
                "qtd_empresarial_parcela_06" => $qtd_empresarial_parcela_06->where("user_id",$request->user_id)->count(),
                "qtd_empresarial_finalizado" => $qtd_empresarial_finalizado->where("user_id",$request->user_id)->count(),
                "qtd_empresarial_cancelado" => $qtd_empresarial_cancelado->where("user_id",$request->user_id)->count(),
                "qtd_empresarial_atrasado" => $qtd_empesarial_atrasado->where("user_id",$request->user_id)->count() 
              ];

        }
            


        




    }







    public function listarContratoEmpresarialAtrasados(Request $request)
    {
        if($request->ajax()) {

            $cacheKey = 'listarContratoEmpresarialAtrasados';
            $tempoDeExpiracao = 60;
            $resultado = Cache::remember($cacheKey, $tempoDeExpiracao, function () {
                return DB::select("
                    select
                    date_format(contrato_empresarial.created_at,'%d/%m/%Y') as created_at,
                    codigo_externo as codigo_externo,
                    users.name as usuario,
                    razao_social,
                    cnpj,
                    quantidade_vidas,
                    valor_plano,
                    planos.nome as plano,
                    (select date_format(data,'%d/%m/%Y') from comissoes_corretores_lancadas where comissoes_corretores_lancadas.comissoes_id = comissoes.id and comissoes_corretores_lancadas.status_financeiro = 0 and comissoes_corretores_lancadas.data_baixa IS NULL  LIMIT 1) as vencimento,
                    (estagio_financeiros.nome) as status,
                    contrato_empresarial.id as id
                    from contrato_empresarial
                    inner join comissoes on comissoes.contrato_empresarial_id = contrato_empresarial.id
                    inner join estagio_financeiros on estagio_financeiros.id = contrato_empresarial.financeiro_id
                    inner join users on users.id = comissoes.user_id
                    inner join planos on planos.id = comissoes.plano_id
                    where  exists (select * from `comissoes_corretores_lancadas` where `comissoes`.`id` = `comissoes_corretores_lancadas`.`comissoes_id` and DATA < CURDATE() and data_baixa IS NULL group by `comissoes_id`);
            ");
            });
            return response()->json($resultado);
        }
    }


    public function listarContratoEmAnalise(Request $request)
    {
        if($request->ajax()) {
            $cacheKey = 'listarContratoEmAnalise';
            $tempoDeExpiracao = 60;
            $resultado = Cache::remember($cacheKey, $tempoDeExpiracao, function () {
                return DB::select("select
                        date_format(contrato_empresarial.created_at,'%d/%m/%Y') as created_at,
                        codigo_externo as codigo_externo,
                        users.name as usuario,
                        razao_social,
                        cnpj,
                        quantidade_vidas,
                        valor_plano,
                        planos.nome as plano,
                        (select data from comissoes_corretores_lancadas where comissoes_corretores_lancadas.comissoes_id = comissoes.id and comissoes_corretores_lancadas.status_financeiro = 0 and comissoes_corretores_lancadas.data_baixa IS NULL  LIMIT 1) as vencimento,
                        ('Em Analise') as status,
                        contrato_empresarial.id as id
                        from contrato_empresarial
                        inner join comissoes on comissoes.contrato_empresarial_id = contrato_empresarial.id
                        inner join users on users.id = comissoes.user_id
                        inner join planos on planos.id = comissoes.plano_id
                        where financeiro_id = 1");
            });





            return response()->json($resultado);

        }
    }

    public function listarEmpresarialEmGeral(Request $request)
    {
        if($request->ajax()) {
            return ContratoEmpresarial
            ::selectRaw("(SELECT name FROM users WHERE users.id = contrato_empresarial.user_id) as usuario")
            ->selectRaw("(SELECT nome FROM planos WHERE planos.id = contrato_empresarial.plano_id) as plano")
            ->selectRaw("(SELECT nome FROM tabela_origens WHERE tabela_origens.id = contrato_empresarial.tabela_origens_id) as tabela_origem")
            ->selectRaw("responsavel,email,telefone,celular,cidade,uf,quantidade_vidas,cnpj,razao_social,codigo_vendedor,codigo_cliente,codigo_corretora,taxa_adesao,valor_plano,valor_total,vencimento_boleto,valor_boleto,codigo_cliente,valor_plano_odonto,valor_plano_saude,senha_cliente,codigo_saude,codigo_odonto,plano_contrado,data_boleto,financeiro_id,created_at,id")
            ->with('comissao')
            ->get();
        }
    }




    public function listarContratoPrimeiraParcela(Request $request)
    {
        if($request->ajax()) {
            $cacheKey = 'listarContratoPrimeiraParcela';
            $tempoDeExpiracao = 60;
            $resultado = Cache::remember($cacheKey, $tempoDeExpiracao, function () {
                return DB::select("
                    select
                    date_format(contrato_empresarial.created_at,'%d/%m/%Y') as created_at,
                    codigo_externo as codigo_externo,
                    users.name as usuario,
                    razao_social,
                    cnpj,
                    quantidade_vidas,
                    valor_plano,
                    planos.nome as plano,
                    (select date_format(data,'%d/%m/%Y') from comissoes_corretores_lancadas where comissoes_corretores_lancadas.comissoes_id = comissoes.id and comissoes_corretores_lancadas.status_financeiro = 0 and comissoes_corretores_lancadas.data_baixa IS NULL  LIMIT 1) as vencimento,
                    estagio_financeiros.nome as status,
                    contrato_empresarial.id as id
                    from contrato_empresarial
                    inner join comissoes on comissoes.contrato_empresarial_id = contrato_empresarial.id
                    inner join users on users.id = comissoes.user_id
                    inner join estagio_financeiros on estagio_financeiros.id = contrato_empresarial.financeiro_id
                    inner join planos on planos.id = comissoes.plano_id
                    where financeiro_id = 5
                ");
            });

            return response()->json($resultado);





        }
    }

    public function listarContratoSegundaParcela(Request $request)
    {
        if($request->ajax()) {

            $cacheKey = 'listarContratoPrimeiraParcela';
            $tempoDeExpiracao = 60;
            $resultado = Cache::remember($cacheKey, $tempoDeExpiracao, function () {
                return DB::select("
                select
                date_format(contrato_empresarial.created_at,'%d/%m/%Y') as created_at,
                codigo_externo as codigo_externo,
                users.name as usuario,
                razao_social,
                cnpj,
                quantidade_vidas,
                valor_plano,
                planos.nome as plano,
                (select date_format(data,'%d/%m/%Y') from comissoes_corretores_lancadas where comissoes_corretores_lancadas.comissoes_id = comissoes.id and comissoes_corretores_lancadas.status_financeiro = 0 and comissoes_corretores_lancadas.data_baixa IS NULL  LIMIT 1) as vencimento,
                estagio_financeiros.nome as status,
                contrato_empresarial.id as id
                from contrato_empresarial
                inner join comissoes on comissoes.contrato_empresarial_id = contrato_empresarial.id
                inner join users on users.id = comissoes.user_id
                inner join estagio_financeiros on estagio_financeiros.id = contrato_empresarial.financeiro_id
                inner join planos on planos.id = comissoes.plano_id
                where financeiro_id = 6
            ");
            });




            return response()->json($resultado);


        }
    }

    public function listarContratoTerceiraParcela(Request $request)
    {
        if($request->ajax()) {

            $cacheKey = 'listarContratoTerceiraParcela';
            $tempoDeExpiracao = 60;
            $resultado = Cache::remember($cacheKey, $tempoDeExpiracao, function () {
                return DB::select("
                select
                date_format(contrato_empresarial.created_at,'%d/%m/%Y') as created_at,
                codigo_externo as codigo_externo,
                users.name as usuario,
                razao_social,
                cnpj,
                quantidade_vidas,
                valor_plano,
                planos.nome as plano,
                (select date_format(data,'%d/%m/%Y') from comissoes_corretores_lancadas where comissoes_corretores_lancadas.comissoes_id = comissoes.id and comissoes_corretores_lancadas.status_financeiro = 0 and comissoes_corretores_lancadas.data_baixa IS NULL  LIMIT 1) as vencimento,
                estagio_financeiros.nome as status,
                contrato_empresarial.id as id
                from contrato_empresarial
                inner join comissoes on comissoes.contrato_empresarial_id = contrato_empresarial.id
                inner join users on users.id = comissoes.user_id
                inner join estagio_financeiros on estagio_financeiros.id = contrato_empresarial.financeiro_id
                inner join planos on planos.id = comissoes.plano_id
                where financeiro_id = 7
            ");
            });

            return response()->json($resultado);

        }
    }

    public function listarContratoQuartaParcela(Request $request)
    {
        if($request->ajax()) {

            $cacheKey = 'listarContratoQuartaParcela';
            $tempoDeExpiracao = 60;
            $resultado = Cache::remember($cacheKey, $tempoDeExpiracao, function () {
               return DB::select("
                select
                date_format(contrato_empresarial.created_at,'%d/%m/%Y') as created_at,
                codigo_externo as codigo_externo,
                users.name as usuario,
                razao_social,
                cnpj,
                quantidade_vidas,
                valor_plano,
                planos.nome as plano,
                (select date_format(data,'%d/%m/%Y') from comissoes_corretores_lancadas where comissoes_corretores_lancadas.comissoes_id = comissoes.id and comissoes_corretores_lancadas.status_financeiro = 0 and comissoes_corretores_lancadas.data_baixa IS NULL  LIMIT 1) as vencimento,
                estagio_financeiros.nome as status,
                contrato_empresarial.id as id
                from contrato_empresarial
                inner join comissoes on comissoes.contrato_empresarial_id = contrato_empresarial.id
                inner join users on users.id = comissoes.user_id
                inner join estagio_financeiros on estagio_financeiros.id = contrato_empresarial.financeiro_id
                inner join planos on planos.id = comissoes.plano_id
                where financeiro_id = 8


            ");
            });

            return response()->json($resultado);
        }
    }

    public function listarContratoQuintaParcela(Request $request)
    {
        if($request->ajax()) {

            $cacheKey = 'listarContratoQuintaParcela';
            $tempoDeExpiracao = 60;
            $resultado = Cache::remember($cacheKey, $tempoDeExpiracao, function () {
                return DB::select("
                select
                date_format(contrato_empresarial.created_at,'%d/%m/%Y') as created_at,
                codigo_externo as codigo_externo,
                users.name as usuario,
                razao_social,
                cnpj,
                quantidade_vidas,
                valor_plano,
                planos.nome as plano,
                (select date_format(data,'%d/%m/%Y') from comissoes_corretores_lancadas where comissoes_corretores_lancadas.comissoes_id = comissoes.id and comissoes_corretores_lancadas.status_financeiro = 0 and comissoes_corretores_lancadas.data_baixa IS NULL  LIMIT 1) as vencimento,
                estagio_financeiros.nome as status,
                contrato_empresarial.id as id
                from contrato_empresarial
                inner join comissoes on comissoes.contrato_empresarial_id = contrato_empresarial.id
                inner join users on users.id = comissoes.user_id
                inner join estagio_financeiros on estagio_financeiros.id = contrato_empresarial.financeiro_id
                inner join planos on planos.id = comissoes.plano_id
                where financeiro_id = 9
            ");
            });



            return response()->json($resultado);




        }
    }

    public function listarContratoSextaParcela(Request $request)
    {
        if($request->ajax()) {

            $cacheKey = 'listarContratoSextaParcela';
            $tempoDeExpiracao = 60;
            $resultado = Cache::remember($cacheKey, $tempoDeExpiracao, function () {
                return DB::select("
                    select
                    date_format(contrato_empresarial.created_at,'%d/%m/%Y') as created_at,
                    codigo_externo as codigo_externo,
                    users.name as usuario,
                    razao_social,
                    cnpj,
                    quantidade_vidas,
                    valor_plano,
                    planos.nome as plano,
                    (select date_format(data,'%d/%m/%Y') from comissoes_corretores_lancadas where comissoes_corretores_lancadas.comissoes_id = comissoes.id and comissoes_corretores_lancadas.status_financeiro = 0 and comissoes_corretores_lancadas.data_baixa IS NULL  LIMIT 1) as vencimento,
                    estagio_financeiros.nome as status,
                    contrato_empresarial.id as id
                    from contrato_empresarial
                    inner join comissoes on comissoes.contrato_empresarial_id = contrato_empresarial.id
                    inner join users on users.id = comissoes.user_id
                    inner join estagio_financeiros on estagio_financeiros.id = contrato_empresarial.financeiro_id
                    inner join planos on planos.id = comissoes.plano_id
                    where financeiro_id = 10
                ");
            });




            return response()->json($resultado);
        }
    }

    public function listarContratoEmpresarialFinalizado(Request $request)
    {
        if($request->ajax()) {

            $cacheKey = 'listarContratoSextaParcela';
            $tempoDeExpiracao = 60;
            $resultado = Cache::remember($cacheKey, $tempoDeExpiracao, function () {
                return DB::select("
                    select
                        date_format(contrato_empresarial.created_at,'%d/%m/%Y') as created_at,
                        codigo_externo as codigo_externo,
                        users.name as usuario,
                        razao_social,
                        cnpj,
                        quantidade_vidas,
                        valor_plano,
                        planos.nome as plano,
                        (select data from comissoes_corretores_lancadas where comissoes_corretores_lancadas.comissoes_id = comissoes.id and comissoes_corretores_lancadas.status_financeiro = 1 and comissoes_corretores_lancadas.data_baixa IS NOT NULL ORDER BY id DESC  LIMIT 1) as vencimento,
                        ('Finalizado') as status,
                        contrato_empresarial.id as id
                        from contrato_empresarial
                        inner join comissoes on comissoes.contrato_empresarial_id = contrato_empresarial.id
                        inner join users on users.id = comissoes.user_id
                        inner join planos on planos.id = comissoes.plano_id
                        where financeiro_id = 11
                ");
            });




            return response()->json($resultado);
        }
    }

    public function listarContratoEmpresarialCancelado(Request $request)
    {
        if($request->ajax()) {
            if($request->ajax()) {
                return ContratoEmpresarial
                    ::with(["comissao","comissao.comissaoAtualFinanceiro"])
                    ->selectRaw("(SELECT name FROM users WHERE users.id = contrato_empresarial.user_id) as usuario")
                    ->selectRaw("(SELECT nome FROM planos WHERE planos.id = contrato_empresarial.plano_id) as plano")
                    ->selectRaw("(SELECT nome FROM tabela_origens WHERE tabela_origens.id = contrato_empresarial.tabela_origens_id) as tabela_origem")
                    ->selectRaw("responsavel,email,telefone,celular,cidade,uf,quantidade_vidas,cnpj,razao_social,codigo_vendedor,codigo_cliente,codigo_corretora,taxa_adesao,valor_plano,valor_total,vencimento_boleto,valor_boleto,codigo_cliente,valor_plano_odonto,valor_plano_saude,senha_cliente,codigo_saude,codigo_odonto,plano_contrado,data_boleto,financeiro_id,id")
                    ->selectRaw("contrato_empresarial.created_at")
                    ->where("financeiro_id",12)
                    ->get();
            }
        }
    }



    public function store(Request $request)
    {
        $desconto_corretor = $request->desconto_corretor;
        $desconto_corretora = $request->desconto_corretora;
        $valor = str_replace([".",","],["","."],$request->valor);
        $cliente = new Cliente();
        $cliente->nome = $request->nome_coletivo;
        $cliente->user_id = $request->usuario_coletivo_switch;
        $cliente->cidade = $request->cidade_origem_coletivo;
        $cliente->celular = $request->celular;
        $cliente->telefone = $request->telefone;
        $cliente->email = $request->email_coletivo;
        $cliente->cpf = $request->cpf_coletivo;
        $cliente->data_nascimento = date('Y-m-d',strtotime($request->data_nascimento_coletivo));
        $cliente->cep = $request->cep_coletivo;
        $cliente->rua = $request->rua_coletivo;
        $cliente->bairro = $request->bairro_coletivo;
        $cliente->complemento = $request->complemento_coletivo;
        $cliente->uf = $request->uf_coletivo;
        $cliente->pessoa_fisica = 1;
        $cliente->pessoa_juridica = 0;
        $cliente->dependente = ($request->dependente_coletivo == "on" ? 1 : 0);
        $cliente->save();

        if($cliente->dependente) {
            $dependente = new Dependentes();
            $dependente->cliente_id = $cliente->id;
            $dependente->nome = $request->responsavel_financeiro_coletivo_cadastrar_nome;
            $dependente->cpf = $request->responsavel_financeiro_coletivo_cadastrar_cpf;
            $dependente->save();
        }

        $acomodacao = $request->acomodacao;
        $acomodacao_id = Acomodacao::selectRaw('id')->whereRaw("nome LIKE '%{$acomodacao}%'")->first()->id;
        $data_vigencia = $request->data_vigencia;
        $data_boleto = $request->data_boleto;
        $valor_adesao = str_replace([".",","],["","."],$request->valor_adesao);
        $valor_plano = str_replace([".",","],["","."],$request->valor);

        $contrato = new Contrato();

        $contrato->acomodacao_id = $acomodacao_id;
        $contrato->cliente_id = $cliente->id;
        $contrato->administradora_id = $request->administradora;
        $contrato->tabela_origens_id = $request->tabela_origem;
        $contrato->plano_id = 3;
        $contrato->financeiro_id = 1;
        $contrato->data_vigencia = $data_vigencia;
        $contrato->codigo_externo = $request->codigo_externo_coletivo;
        $contrato->data_boleto = $data_boleto;
        $contrato->valor_adesao = $valor_adesao;
        $contrato->valor_plano = $valor_plano;
        $contrato->coparticipacao = ($request->coparticipacao_coletivo == "sim" ? 1 : 0);
        $contrato->odonto = ($request->odonto_coletivo == "sim" ? 1 : 0);
        $contrato->created_at = $request->created_at;
        $contrato->desconto_corretor = $desconto_corretor;
        $contrato->desconto_corretora = $desconto_corretora;
        $contrato->save();
        $totalVidas = 0;
        $faixas = $request->faixas_etarias;
        foreach($faixas as $k => $v) {
            if($v != 0) {
                $orcamentoFaixaEtaria = new CotacaoFaixaEtaria();
                $orcamentoFaixaEtaria->contrato_id = $contrato->id;
                $orcamentoFaixaEtaria->faixa_etaria_id = $k;
                $orcamentoFaixaEtaria->quantidade = $v;
                $orcamentoFaixaEtaria->save();
                $totalVidas += $v;
            }
        }



        $alt = Cliente::where("id",$cliente->id)->first();
        $alt->quantidade_vidas = $totalVidas;
        $alt->save();


        $comissao = new Comissoes();
        $comissao->contrato_id = $contrato->id;
        // $comissao->cliente_id = $contrato->cliente_id;
        $comissao->user_id = $request->usuario_coletivo_switch;
        // $comissao->status = 1;
        $comissao->plano_id = 3;
        $comissao->administradora_id = $request->administradora;
        $comissao->tabela_origens_id = $request->tabela_origem;
        $comissao->data = date('Y-m-d');
        $comissao->save();

        /* Comissao Corretor */
        $comissoes_configuradas_corretor = ComissoesCorretoresConfiguracoes
        ::where("plano_id",3)
        ->where("administradora_id",$request->administradora)
        ->where("user_id",$request->usuario_coletivo_switch)
        ->where("tabela_origens_id",$request->tabela_origem)
        ->get();

        $date = new \DateTime(now());
        $date->add(new \DateInterval('PT1M'));
        $data = $date->format('Y-m-d H:i:s');

        $comissao_corretor_contagem = 0;
        $comissao_corretor_default = 0;

        $ii=0;

        if(count($comissoes_configuradas_corretor) >= 1) {
            foreach($comissoes_configuradas_corretor as $c) {
                $comissaoVendedor = new ComissoesCorretoresLancadas();
                $comissaoVendedor->comissoes_id = $comissao->id;
                //$comissaoVendedor->user_id = auth()->user()->id;
                $comissaoVendedor->parcela = $c->parcela;
                if($comissao_corretor_contagem == 0) {
                    $comissaoVendedor->data = date('Y-m-d H:i:s',strtotime($request->data_vigencia));
                    //$comissaoVendedor->tempo = $data;
                } else {
                    $comissaoVendedor->data = date("Y-m-d H:i:s",strtotime($request->data_vigencia."+{$ii}month"));
                    $date = new \DateTime($data);
                    $date->add(new \DateInterval("PT{$comissao_corretor_contagem}M"));
                    $data_add = $date->format('Y-m-d H:i:s');
                    //$comissaoVendedor->tempo = $data_add;
                    $ii++;
                }
                $comissaoVendedor->valor = ($valor * $c->valor) / 100;
                $comissaoVendedor->save();
                $comissao_corretor_contagem++;
            }
        } else {

            $dados = ComissoesCorretoresDefault
            ::where("plano_id",3)
            ->where("administradora_id",$request->administradora)
            ->where("tabela_origens_id",2)
            ->get();
            foreach($dados as $c) {
                $comissaoVendedor = new ComissoesCorretoresLancadas();
                $comissaoVendedor->comissoes_id = $comissao->id;
                $comissaoVendedor->parcela = $c->parcela;


                if($comissao_corretor_default == 0) {
                    $comissaoVendedor->data = $data_boleto;
                    //$comissaoVendedor->status_financeiro = 1;
                    if($comissaoVendedor->valor == "0.00" || $comissaoVendedor->valor == 0 || $comissaoVendedor->valor >= 0) {
                        //$comissaoVendedor->status_gerente = 1;
                    }

                } elseif($comissao_corretor_default == 1) {
                    $comissaoVendedor->data = date("Y-m-d H:i:s",strtotime($request->data_vigencia));
                }  else {
                    $mes = $comissao_corretor_default - 1;
                    $comissaoVendedor->data = date("Y-m-d H:i:s",strtotime($request->data_vigencia."+{$mes}month"));
                    //$date = new \DateTime($data);
                    //$date->add(new \DateInterval("PT{$comissao_corretor_default}M"));
                    //$data_add = $date->format('Y-m-d H:i:s');
                }
                $comissaoVendedor->valor = ($valor * $c->valor) / 100;
                $comissaoVendedor->save();
                $comissao_corretor_default++;
            }



        }

        // /** Comissao Corretora */
        $comissoes_configurada_corretora = ComissoesCorretoraConfiguracoes::where("administradora_id",$request->administradora)
        ->where('plano_id',3)
        ->where('tabela_origens_id',2)
        ->get();
        $comissoes_corretora_contagem=0;
        if(count($comissoes_configurada_corretora)>=1) {
            foreach($comissoes_configurada_corretora as $cc) {
                $comissaoCorretoraLancadas = new ComissoesCorretoraLancadas();
                $comissaoCorretoraLancadas->comissoes_id = $comissao->id;
                $comissaoCorretoraLancadas->parcela = $cc->parcela;
                if($comissoes_corretora_contagem == 0) {
                    $comissaoCorretoraLancadas->data = $data_boleto;

                } else if($comissoes_corretora_contagem == 1) {
                    $comissaoCorretoraLancadas->data = date("Y-m-d H:i:s",strtotime($request->data_vigencia));
                } else {
                    $mes = $comissoes_corretora_contagem - 1;
                    $comissaoCorretoraLancadas->data = date("Y-m-d",strtotime($request->data_vigencia."+{$mes}month"));
                }
                $comissaoCorretoraLancadas->valor = ($valor * $cc->valor) / 100;
                $comissaoCorretoraLancadas->save();
                $comissoes_corretora_contagem++;
            }
        }

        if($request->tipo_financeiro) {
            return "financeiro";
        }



        if($request->tipo_cadastro == "administrador_cadastro") {
            return "contratos";
        } else {
            return "contrato";
        }
        //return redirect('admin/contratos?ac=coletivo')->with('success',"Contrato com ".$request->nome." cadastrado com sucesso");
    }









    public function listarColetivoPorAdesao(Request $request)
    {
        $fisica = 1;
        $contratos = Contrato
            ::where("plano_id",3)
            ->with(['administradora','financeiro','cidade','acomodacao','plano','somarCotacaoFaixaEtaria','clientes','clientes.user','clientes.dependentes'])
            ->orderBy("id","desc")
            ->get();
        return $contratos;
    }

    public function storeEmpresarial(Request $request)
    {

        $dados = $request->all();
        $dados['taxa_adesao'] = str_replace([".",","],["","."],$request->taxa_adesao);
        $dados['desconto_corretor'] = str_replace([".",","],["","."],$request->desconto_corretor);
        $dados['desconto_corretora'] = str_replace([".",","],["","."],$request->desconto_corretora);

        $dados['valor_plano'] = str_replace([".",","],["","."],$request->valor_plano);
        $dados['valor_plano_saude'] = str_replace([".",","],["","."],$request->valor_plano_saude);
        $dados['valor_plano_odonto'] = str_replace([".",","],["","."],$request->valor_plano_odonto);
        $dados['valor_plano'] = $dados['valor_plano_saude'] + $dados['valor_plano_odonto'];
        $dados['valor_total'] = $dados['valor_plano'] + $dados['taxa_adesao'];
        $dados['valor_boleto'] = str_replace([".",","],["","."],$request->valor_boleto);
        $dados['data_boleto'] = date('Y-m-d',strtotime($request->data_boleto));
        $dados['created_at'] = $request->created_at;
        $dados['financeiro_id'] = 1;
        $valor = $dados['valor_plano'];
        $contrato = ContratoEmpresarial::create($dados);
        $comissao = new Comissoes();
        $comissao->contrato_empresarial_id = $contrato->id;
        // $comissao->cliente_id = $contrato->cliente_id;
        $comissao->user_id = $request->user_id;
        // $comissao->status = 1;
        $comissao->plano_id = $request->plano_id;
        $comissao->administradora_id = 4;
        $comissao->tabela_origens_id = $request->tabela_origens_id;
        $comissao->data = date('Y-m-d');
        $comissao->empresarial = 1;
        $comissao->save();


        $comissoes_configuradas_corretor = ComissoesCorretoresConfiguracoes
        ::where("plano_id",$request->plano_id)
        ->where("administradora_id",4)
        ->where("user_id",$request->user_id)
        ->where("tabela_origens_id",$request->tabela_origens_id)
        ->get();


        $date = new \DateTime(now());
        $date->add(new \DateInterval('PT1M'));
        $data = $date->format('Y-m-d H:i:s');


        $comissao_corretor_contagem = 0;
        if(count($comissoes_configuradas_corretor) >= 1) {
            foreach($comissoes_configuradas_corretor as $c) {
                $comissaoVendedor = new ComissoesCorretoresLancadas();
                $comissaoVendedor->comissoes_id = $comissao->id;
                //$comissaoVendedor->user_id = auth()->user()->id;
                $comissaoVendedor->parcela = $c->parcela;
                if($comissao_corretor_contagem == 0) {
                    $comissaoVendedor->data = date('Y-m-d H:i:s',strtotime($request->data_boleto));
                    //$comissaoVendedor->tempo = $data;
                } else {
                    $comissaoVendedor->data = date("Y-m-d H:i:s",strtotime($request->data_boleto."+{$comissao_corretor_contagem}month"));
                    $date = new \DateTime($data);
                    $date->add(new \DateInterval("PT{$comissao_corretor_contagem}M"));
                    $data_add = $date->format('Y-m-d H:i:s');
                    //$comissaoVendedor->tempo = $data_add;
                }
                $comissaoVendedor->valor = ($valor * $c->valor) / 100;
                $comissaoVendedor->save();
                $comissao_corretor_contagem++;
            }
        }

         /** Comissao Corretora */
         $comissoes_configurada_corretora = ComissoesCorretoraConfiguracoes
         ::where("administradora_id",4)
         ->where('plano_id',$request->plano_id)
         ->where("tabela_origens_id",$request->tabela_origens_id)
         ->get();
         $comissoes_corretora_contagem=0;
         if(count($comissoes_configurada_corretora)>=1) {
             foreach($comissoes_configurada_corretora as $cc) {
                 $comissaoCorretoraLancadas = new ComissoesCorretoraLancadas();
                 $comissaoCorretoraLancadas->comissoes_id = $comissao->id;
                 $comissaoCorretoraLancadas->parcela = $cc->parcela;
                 if($comissoes_corretora_contagem == 0) {
                     $comissaoCorretoraLancadas->data = date('Y-m-d',strtotime($request->data_boleto));
                 } else {
                     $comissaoCorretoraLancadas->data = date("Y-m-d",strtotime($request->data_boleto."+{$comissoes_corretora_contagem}month"));
                 }
                 $comissaoCorretoraLancadas->valor = ($valor * $cc->valor) / 100;
                 $comissaoCorretoraLancadas->save();
                 $comissoes_corretora_contagem++;
             }
         }


        //  $premiacao = new Premiacoes();
        //  $premiacao->contrato_empresarial_id = $contrato->id;
        //  $premiacao->user_id = $request->user_id;
        //  $premiacao->plano_id = $request->plano_id;
        //  $premiacao->administradora_id = 4;
        //  $premiacao->tabela_origens_id = $request->tabela_origens_id;
        //  $premiacao->data = date('Y-m-d');
        //  $premiacao->empresarial = 1;
        //  $premiacao->save();

        //  $premiacao_configurada_corretor = PremiacoesCorretoresConfiguracoes
        //  ::where("plano_id",$request->plano_id)
        //  ->where("administradora_id",4)
        //  ->where("user_id",$request->user_id)
        //  ->where("tabela_origens_id",$request->tabela_origens_id)
        //  ->get();

        //  $premiacao_corretor_contagem = 0;
        //  if(count($premiacao_configurada_corretor)>=1) {
        //      foreach($premiacao_configurada_corretor as $k => $p) {
        //          $premiacaoCorretoresLancados = new PremiacoesCorretoresLancadas();
        //          $premiacaoCorretoresLancados->premiacoes_id = $premiacao->id;
        //          $premiacaoCorretoresLancados->parcela = $p->parcela;

        //          if($premiacao_corretor_contagem == 0) {
        //              $premiacaoCorretoresLancados->data = date('Y-m-d H:i:s',strtotime($request->data_boleto));
        //          } else {
        //              $premiacaoCorretoresLancados->data = date("Y-m-d H:i:s",strtotime($request->data_boleto."+{$premiacao_corretor_contagem}month"));
        //          }
        //          $premiacaoCorretoresLancados->valor = $p->valor * $request->quantidade_vidas;
        //          $premiacaoCorretoresLancados->save();
        //          $premiacao_corretor_contagem++;
        //      }
        //  }




        //  /** Premiação Corretora */
        //  $premiacao_configurada_corretora = PremiacoesCorretoraConfiguracoes
        //  ::where("plano_id",$request->plano_id)
        //  ->where("administradora_id",4)
        //  //->where("user_id",$request->user_id)
        //  ->where("tabela_origens_id",$request->tabela_origens_id)
        //  ->get();



        //  $premiacao_corretora_contagem = 0;
        //  if(count($premiacao_configurada_corretora)>=1) {
        //      foreach($premiacao_configurada_corretora as $k => $p) {
        //          $premiacaoCorretoraLancados = new PremiacoesCorretoraLancadas();
        //          $premiacaoCorretoraLancados->premiacoes_id = $premiacao->id;
        //          $premiacaoCorretoraLancados->parcela = $p->parcela;
        //          if($premiacao_corretor_contagem == 0) {
        //              $premiacaoCorretoraLancados->data = date('Y-m-d',strtotime($request->data_boleto));
        //          } else {
        //              $premiacaoCorretoraLancados->data = date("Y-m-d",strtotime($request->data_boleto."+{$premiacao_corretora_contagem}month"));
        //          }
        //          $premiacaoCorretoraLancados->valor = $p->valor * $request->quantidade_vidas;
        //          $premiacaoCorretoraLancados->save();
        //          $premiacao_corretora_contagem++;
        //      }
        //  }
        //return redirect()->route('contratos.index')->with('success',"Contrato cadastrado com sucesso");
        return redirect('admin/contratos?ac=empresarial')->with('success','Contrato cadastrado com sucesso');
    }

    public function contratoInfo(Request $request)
    {
      $id = $request->contrato;
      $contrato = Contrato::where("id",$id)->first();
      if($contrato == null) {
            $contrato = ContratoEmpresarial::where("id",$id)->with(['comissao','comissao.comissoesLancadas'])->first();
      } else {
            $contrato = Contrato::where("id",$id)->with(['clientes','comissao','comissao.comissoesLancadas'])->first();
      }
      return view('admin.pages.contratos.historicoFinanceiro',[
            "contrato" => $contrato
      ]);
    }


    public function formCreate()
    {
        $users = User::where("id","!=",auth()->user()->id)->get();
        $origem_tabela = TabelaOrigens::all();
        return view('admin.pages.contratos.cadastrar',[
            'users' => $users,
            'origem_tabela' => $origem_tabela
        ]);
    }


    public function formCreateColetivo()
    {
        $users = User::where("id","!=",1)->get();
        $origem_tabela = TabelaOrigens::all();
        $administradoras = Administradoras::whereRaw("id != (SELECT id FROM administradoras WHERE nome LIKE '%hapvida%')")->get();
        return view('admin.pages.contratos.cadastrar-coletivo',[
            'users' => $users,
            'cidades' => $origem_tabela,
            'administradoras' => $administradoras
        ]);
    }

    public function formCreateColetivoCorretor()
    {
        $origem_tabela = TabelaOrigens::all();
        $administradoras = Administradoras::whereRaw("id != (SELECT id FROM administradoras WHERE nome LIKE '%hapvida%')")->get();
        return view('admin.pages.contratos.cadastrar-coletivo-corretor',[
            'cidades' => $origem_tabela,
            'administradoras' => $administradoras
        ]);
    }


    public function formCreateEmpresarial()
    {
        $users = User
        ::where("id","!=",1)
        ->get();
        $plano_empresarial = Planos::where("empresarial",1)->get();
        $tabela_origem = TabelaOrigens::all();
        return view('admin.pages.contratos.cadastrar-empresa',[
            "users" => $users,
            "planos_empresarial" => $plano_empresarial,
            "origem_tabela" =>  $tabela_origem
        ]);
    }

}

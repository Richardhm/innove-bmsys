@extends('adminlte::page')
@section('title', 'Corretora')
@section('plugins.Toastr', true)
@section('content_header')
    <h3 class="text-white">Dados Corretora:</h3>
@stop

@section('content')

    <div class="tab-container border-bottom border-width-2 border-light">
        <div class="tab tab1 active" data-tab="tab1">Dados Corretora</div>
        <div class="tab tab2" data-tab="tab2" style="margin:0 1%;">Comissão Corretora</div>
        <div class="tab tab3" data-tab="tab3">Comissão Corretor</div>
    </div>

    <div class="tab-content active" id="tab1">
        <!-- Conteúdo da primeira aba (Dados Corretora) -->
        <div class="column-wrapper">

            <div class="column column-1">

                <div style="background-color:#123449;padding:5px 3px;border-radius:5px;" id="logo_corretora">
                    <p style="margin:0;padding:0;color:#FFF;">Logo da Corretora</p>
                    <input type="file" id="logo" name="logo" accept="image/*">
                    <div class="imageContainer">
                        <img src="{{$logo != '' ? asset($logo) : asset('camera.png')}}" alt="Camera" id="imgAlt">
                    </div>
                </div>

                
            </div>

            <div class="column column-2">
                <!-- Bloco 2: Formulário -->

                <form id="corretoraForm">
                    <!-- Campo CNPJ -->
                    <span for="cnpj">CNPJ</span>
                    <input type="text" id="cnpj" name="cnpj" style="width: 100%;" class="form-control form-control-sm" value="{{$corretora->cnpj ?? ''}}">

                    <!-- Campo Razão Social -->
                    <span for="razao-social">Razão Social</span>
                    <input type="text" id="razao-social" name="razao-social" style="width: 100%;" class="form-control form-control-sm" value="{{$corretora->razao_social ?? ''}}">

                    <!-- Campos Celular, Telefone e Email -->
                    <div style="display: flex;">
                        <div style="flex: 1;">
                            <span for="celular">Celular</span>
                            <input type="text" id="celular" name="celular" style="width: 100%;" class="form-control form-control-sm" value="{{$corretora->celular ?? ''}}">
                        </div>
                        <div style="flex: 1;margin:0 1%;">
                            <span for="telefone">Telefone</span>
                            <input type="text" id="telefone" name="telefone" style="width: 100%;" class="form-control form-control-sm" value="{{$corretora->telefone ?? ''}}">
                        </div>
                        <div style="flex: 1;">
                            <span for="email">Email</span>
                            <input type="email" id="email" name="email" style="width: 100%;" class="form-control form-control-sm" value="{{$corretora->email ?? ''}}">
                        </div>
                    </div>

                    <!-- Campos CEP, Cidade e UF -->
                    <div style="display: flex;">
                        <div style="flex: 1;">
                            <span for="cep">CEP</span>
                            <input type="text" id="cep" name="cep" style="width: 100%;" class="form-control form-control-sm" value="{{$corretora->cep ?? ''}}">
                        </div>
                        <div style="flex: 1;margin:0 1%;">
                            <span for="cidade">Cidade</span>
                            <input type="text" id="cidade" name="cidade" style="width: 100%;" class="form-control form-control-sm" value="{{$corretora->cidade ?? ''}}">
                        </div>
                        <div style="flex: 1;">
                            <span for="uf">UF</span>
                            <input type="text" id="uf" name="uf" style="width: 100%;" class="form-control form-control-sm" value="{{$corretora->uf ?? ''}}">
                        </div>
                    </div>

                    <!-- Campos Bairro, Rua e Complemento -->
                    <div style="display: flex;margin:1% 0;">
                        <div style="flex: 1;">
                            <span for="bairro">Bairro</span>
                            <input type="text" id="bairro" name="bairro" style="width: 100%;" class="form-control form-control-sm" value="{{$corretora->bairro ?? ''}}">
                        </div>
                        <div style="flex: 1;margin:0 1%;">
                            <span for="rua">Rua</span>
                            <input type="text" id="rua" name="rua" style="width: 100%;" class="form-control form-control-sm" value="{{$corretora->rua ?? ''}}">
                        </div>

                    </div>

                    <div class="d-flex my-1">
                        <div class="w-100">
                            <span for="complemento">Complemento</span>
                            <input type="text" id="complemento" name="complemento" style="width: 100%;" class="form-control form-control-sm" value="{{$corretora->complemento ?? ''}}">
                        </div>
                    </div>

                    <!-- Campos Localização e Site -->
                    <div style="display: flex;">

                        <div class="w-100">
                            <span for="site">Site</span>
                            <input type="url" id="site" name="site" style="width: 100%;" class="form-control form-control-sm" value="{{$corretora->site ?? ''}}">
                        </div>
                    </div>

                    <!-- Campos Instagram, Facebook e LinkedIn -->
                    <div style="display: flex;margin:1% 0;">
                        <div class="w-100">
                            <span for="instagram">Instagram</span>
                            <input type="text" id="instagram" name="instagram" style="width: 100%;" class="form-control form-control-sm" value="{{$corretora->instagram ?? ''}}">
                        </div>

                    </div>


                        <div class="d-flex">
                            <div class="w-100">
                                <span for="facebook">Facebook</span>
                                <input type="text" id="facebook" name="facebook" style="width: 100%;" class="form-control form-control-sm" value="{{$corretora->facebook ?? ''}}">
                            </div>
                        </div>

                    <!-- Botão de Salvar -->
                    <input type="submit" value="Salvar" class="btn btn-info btn-block bloco_dados">
                </form>
            </div>


            <div class="column column-3">

            
                <div class="d-flex justify-content-between p-1" id="area_de_atuacao">
                    
                    <div style="margin:0 0 0 0;padding:0;display:flex;justify-content:space-between;color:#FFF;flex-basis:100%;border-bottom:2px solid white;">
                        <small>Área de Atuação</small>
                        <i class="fas fa-plus fa-sm mt-1 cadastrar_cidade"></i>
                    </div>
                    <div style="display: flex;flex-direction: column;flex-basis:100%;" id="list_cidades">
                        @foreach($cidades as $cc)
                            <p style="margin:0;padding:0;display:flex;flex-basis:100%;justify-content:space-between;" id="tabela_origens_{{$cc->id}}">
                                <span style="color:#FFF;margin:0;padding:0;font-size:0.72em;">{{$cc->nome}}</span>
                                <span style="font-size:0.8em;color:#FFF;"><i class="fas fa-times fa-xs deletar_tabela_origens" data-id="{{$cc->id}}"></i></span>
                            </p>
                        @endforeach
                    </div>

                </div>
 
                <div class="d-flex justify-content-between p-1" id="area_de_planos">
                    <div style="margin:0 0 0 0;padding:0;display:flex;justify-content:space-between;color:#FFF;flex-basis:100%;border-bottom:2px solid white;">
                        <small>Planos</small>
                        <i class="fas fa-plus fa-sm mt-1 cadastrar_planos"></i>
                    </div>
                    <div style="display: flex;flex-direction: column;flex-basis:100%;" id="list_planos">
                        @foreach($planos_all as $pp)
                            <p style="color:#FFF;margin:0;padding:0;display:flex;justify-content: space-between;flex-basis:100%;" id="plano_{{$pp->id}}">
                                <span style="font-size:0.72em;">{{$pp->nome}}</span>
                                <span style="font-size:0.8em;"><i class="fas fa-times fa-xs deletar_plano" data-id="{{$pp->id}}"></i></span>
                            </p>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex justify-content-between" style="background-color:#123449;margin:5px 0 0 0;flex-basis:100%;flex-wrap: wrap;border-radius:5px;overflow: auto;height:32%;max-height:32%;overflow:auto;color:#FFF;">
                    <div style="width:100%;">
                        <div style="display:flex;flex-basis:100%;justify-content:space-between;margin:0;padding:0;border-bottom:2px solid white;">
                            <small>Administradoras</small>
                            
                            <i class="fas fa-plus fa-sm mt-1 cadastrar_administradora"></i>
                            
                            
                        </div>
                        <div id="list_administradora" style="display:flex;flex-basis:100%;flex-wrap: wrap;">
                            @foreach($administradoras_all as $aa)
                                <p style="display:flex;flex-basis:100%;justify-content:space-between;margin:0;padding:0;" id="administradora_{{$aa->id}}">
                                    <span style="font-size:0.72em;">{{$aa->nome}}</span>
                                    <span style="font-size:0.8em;margin-right:5px;">
                                        <i class="fas fa-infinity fa-xs mt-1 editar_administradora" data-id="{{$aa->id}}"></i>
                                        <i class="fas fa-times fa-xs deletar_administradora" data-id="{{$aa->id}}"></i>
                                    </span>
                                </p>
                            @endforeach
                        </div>
                    </div>
                </div>








            </div>        




        </div>
        
        

            
</div>        


            
        
    

    <div class="tab-content" id="tab2">
        <input type="hidden" id="cidade_id_corretora">
        <input type="hidden" id="cidade_nome_corretora">
        <div id="cidade_clicada" class="d-flex w-100 text-center p-1 justify-content-center" style="flex-basis:100%;"></div>
        <div id="tab2_area_dados">
            <div id="content-corretora-left">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#configurarModal">
                    Cadastrar
                </button>
                <div id="cities_list_corretora">
                    <ul>

                        @if(count($cidade_corretora) >= 1)
                            <li>
                               <span style="display:flex;flex-basis:100%;justify-content:center;">Comissoes</span>
                            </li>
                        @endif


                        
                    </ul>    
                </div>    
            </div>
            
            <div id="tabelas" class="row">
                <p class="mx-auto my-auto">Editar/Cadastrar comissão da corretora aqui!</p>
            </div>
        </div>
    </div>

    <div class="tab-content" id="tab3">
        <input type="hidden" id="cidade_id_corretor">
        <input type="hidden" id="tipo_corretor">
        <div id="tab3_area_dados">
            <div id="content-corretor-left">               
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#comissionModal">Cadastrar</button>
                <div id="tipos_list_corretor">
                    <ul>
                        <li data-id="1">
                            <span style="display:flex;flex-basis:100%;justify-content:center;">CLT</span>
                        </li>
                        <li data-id="2">
                            <span style="display:flex;flex-basis:100%;justify-content:center;">Parceiro</span>
                        </li>
                    </ul>    
                </div> 

            </div>
            <div id="tabelas_corretor" class="row">
                <p class="mx-auto my-auto">Editar/Cadastrar comissão da corretor aqui!</p>
            </div>
        </div>  

        
    </div>  
    
    <div class="modal fade" id="configurarModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Configuração</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulário de configuração -->
                    <form>
                        
                        <div id="planos_cadastrado_escolher">
                            <label>Planos:</label>
                            <!-- Lista de planos -->
                            <ul class="row" id="list_planos_cadastrado_escolher">


                                
                            </ul>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="salvarConfiguracao">Salvar Configuração</button>
                </div>
            </div>
        </div>
    </div>

        <!----FIM--->
    


        <!-- Modal para cadastro -->
<div class="modal fade" id="comissionModal" tabindex="-1" role="dialog" aria-labelledby="comissionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="comissionModalLabel">Cadastro de Comissões</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Conteúdo do formulário -->
                <form>
                    <div class="form-group">
                        <label for="comissionType">Tipo de Comissão:</label>
                        <select class="form-control" id="comissionTypeCorretor">
                            <option value="">--Escolher tipo --</option>
                            <option value="1">CLT</option>
                            <option value="2">Parceiro</option>
                        </select>
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="plans">Planos:</label>
                        <div id="plans">
                            <ul class="row" id="plans_list_comissao">
                                
                               

                            </ul>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="salvar_comissoes_corretor">Salvar Comissão</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="comissionModalEditar" tabindex="-1" role="dialog" aria-labelledby="comissionModalLabelEditar" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="comissionModalLabelEditar">Editar Comissão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Conteúdo do formulário -->
                <form>
                    
                    
                    
                    <div class="form-group">
                        <label for="plans">Planos:</label>
                        <div id="plans">
                            <ul class="row" id="plans_list_comissao_alterar">
                                
                               

                            </ul>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="salvar_comissoes_corretor_alterar">Salvar Comissão</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="abrirModalCidadeJaExiste" tabindex="-1" aria-labelledby="abrirModalCidadeJaExisteLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="abrirModalCidadeJaExisteLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="planoAbrirModalCidadeJaExiste">
        <ul class="row" id="list_planos_cadastrado_escolher_alterar">


                                
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" id="salvarConfiguracaoAlterarJaExiste">Salvar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="uf_tabela_origens">UF:</label>
            <select name="uf_tabela_origens" id="uf_tabela_origens" class="form-control"></select>
            <div class="error_uf_cidade"></div>
        </div>
        <div class="form-group">
            <label for="cidade_tabela_origens">Cidade:</label>
            <select name="cidade_tabela_origens" id="cidade_tabela_origens" class="form-control"></select>
            <div class="error_nome_cidade"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary salvar_cidade" id="cadastrar_area_atuacao">Salvar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModalAdministradora" tabindex="-1" aria-labelledby="exampleModalAdministradoraLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalAdministradoraLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" name="name_administradora" id="name_administradora" class="form-control">
        </div>
        <div class="form-group">
            <label for="logo">Logo:</label>
            <input type="file" name="image_administradora" id="image_administradora" class="form-control">
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary cadastrar_administradora_formulario">Salvar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModalPlanos" tabindex="-1" aria-labelledby="exampleModalPlanosLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalPlanosLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" name="nome_plano" id="nome_plano" class="form-control">
        </div>
        <div class="form-group">
            <label for="logo">Plano Empresarial?</label>
            <select name="empresarial_status" id="empresarial_status" class="form-control">
                <option value="0">Não</option>
                <option value="1">Sim</option>
            </select>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary salvar_planos">Salvar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="administradorasPlanosModal" tabindex="-1" aria-labelledby="administradorasPlanosModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="administradorasPlanosModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="administradoras_planos_modal">
        <div class="form-group">
            <label for="logo">Planos</label>
            <div class="checkbox-columns row">
                @php $count = 0; @endphp
                @foreach($planos_all as $pp)
                    @if($count % 6 == 0)
                        @if($count > 0)
                            </div>
                        @endif
                        <div class="checkbox-column d-flex col-6" style="flex-direction:column;">
                    @endif
                    <label for="plano_{{$pp->id}}" style="font-size:0.78em;">
                        <input type="checkbox" data-id="{{$pp->id}}">{{$pp->nome}}
                    </label>
                    
                    @php $count++; @endphp
                @endforeach
                </div>
            </div>    
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" id="salvar_administradora_planos">Salvar</button>
      </div>
    </div>
  </div>
</div>








@stop


@section('css')
<style>

    .btn_remove_comissao {margin-bottom:5px;} 
    .btn_remove_comissao:hover {cursor: pointer;} 
    .btn_remove_comissao i {background-color:#FFF;color:#000;padding:5px;border-radius:3px;}
    #content-corretora-left {display:flex;flex-basis:10%;flex-direction:column;}
    #content-corretor-left {display:flex;flex-basis:10%;flex-direction:column;}
    #cities_list_corretora {border-radius:5px;margin-top:5px;}
    #cities_list_corretora ul {list-style:none;padding:0;margin:0;display:flex;flex-direction:column;border-radius:5px;}   
    #cities_list_corretora li {color:#FFF;padding:8px 0px;border-radius:5px;border:2px solid white;background-color:#123449;margin-bottom:4px;}
    #cities_list_corretora li:hover {cursor:pointer;}   
    #tipos_list_corretor {border-radius:5px;margin-top:5px;}
    #tipos_list_corretor ul {list-style:none;padding:0;margin:0;display:flex;flex-direction:column;border-radius:5px;}
    #tipos_list_corretor li {color:#FFF;padding:8px 0px;border-radius:5px;border:2px solid white;background-color:#123449;margin-bottom:4px;}
    #tipos_list_corretor li:hover {cursor:pointer;}
    #tabelas {padding:10px 0;background-color:#ECECEC;border-radius:5px;display:flex;flex-basis:83%;height: 100%;margin-left:1%;border:5px solid #FFF;}
    #tabelas_corretor {background-color:#ECECEC;border-radius:5px;display:flex;flex-basis:83%;height: 100%;margin-left:1%;border:5px solid #FFF;}
    #tab2 #tab2_area_dados {display:flex;}
    #tab3 #tab3_area_dados {display:flex;}
    .campo-em-branco {border: 2px solid red;}   
    #user-list-parceiro {background-color:#123449;display: none;color:white;padding:5px;height:300px;font-size:0.9em;margin-left:5px;max-height: 300px;overflow-y: auto;border-radius:5px;scrollbar-width: thin;scrollbar-color: blue white;}
    #user-list-parceiro::-webkit-scrollbar {width: 8px;background-color: #ffffff;}
    #user-list-parceiro::-webkit-scrollbar-thumb {background-color: #0a2034;}
    .borda-destaque {border:3px solid white;}
    .dados-corretor {display:flex;}
    #coletivo-table-comission,
    #hapvida-table-comission{display:none;}
    .tab2-content-left {display:flex;flex-basis: 45%;align-content:flex-start !important;align-items:flex-start !important;}
    .tab2-content-right {display:flex;flex-basis: 55%;}
    #area_atuacao::-webkit-scrollbar {width: 5px;height: 3px !important;background-color: white;}   
    #area_atuacao::-webkit-scrollbar-thumb {background-color: #0dcaf0;}
    #area_atuacao_administradora::-webkit-scrollbar {width: 5px;height: 3px !important;background-color: white;}
    #area_atuacao_administradora::-webkit-scrollbar-thumb {background-color: #0dcaf0;}
    #area_atuacao_planos::-webkit-scrollbar {width: 5px;height: 3px !important;background-color: white;}
    #area_atuacao_planos::-webkit-scrollbar-thumb {background-color: #0dcaf0;}
    #tab2-content .cities::-webkit-scrollbar {width: 5px;height: 3px !important;background-color: white;}
    #tab2-content .cities::-webkit-scrollbar-thumb {background-color: #0dcaf0;}
    #tab2-content .area-atuacao {display:flex;align-content: flex-start !important;align-items: flex-start !important;justify-content:center;height:30px;width: 140px;color:#FFF;background-color: #123449;text-align:center;cursor: pointer;}
    .toast {width: 500px !important;}
    #tab2-content .area-atuacao:hover {background-color: #FFF;color:#123449;}
    #tab2-content .cities {display: none;margin-left: 10px;background-color:#123449;color:#FFF;border-radius:5px;padding:2px;height:300px;overflow: auto;}
    #tab2-content .cities .city {cursor: pointer;margin-bottom: 5px;}
    #tab2-content .option-group {display: none;background-color:#123449;color:#FFF;padding:5px;margin-left:5px;border-radius:5px;height:auto;width:200px;}
    #tab2-content .option-group .sub-option {cursor:pointer;display:flex;flex-basis:100%;}
    .destaque {background-color:white;color:black;}
    #tab2-content .option-group.active {display:flex;align-content: flex-start !important;align-items:flex-start !important;flex-wrap:wrap;}
    .ativo {background-color:#FFF;color:#000;}
    #tab2-content .comission-options {display: none;background-color:#123449;color:#FFF;height:70px;margin-left:7px;border-radius:5px;padding:3px;}
    #tab2-content .comission-options .option {cursor: pointer;margin-bottom: 5px;}
    #tab2-content .selected-city {display: none;margin-top: 10px;}
    #tab2-content .selected-plano {display: none;}
    #tab2-content .selected-tipo {display: none;}
    #tab2-content .escolher-plano {display: none;}
    #tab2-content .selected-city .option {cursor: pointer;margin-bottom: 5px;}
    .config-block {margin-bottom: 20px;}
    #logo_corretora input[type='file'] {display:none;}
    .imageContainer {max-width: 120px;background-color: #eee;border:5px solid #ccc;border-radius: 5%;display: flex;align-items: center;justify-content: center;margin:0 auto;}
    .imageContainer img {width:100%;padding:5px;cursor: pointer;transition: background .3s;}
    .imageContainer:hover {background-color: rgb(180,180,180);border:5px solid #111;}
    .config-line {display: flex;align-items: center;margin-bottom: 10px;}
    .config-line label {flex-basis: 50%;box-sizing: border-box;padding: 5px;}
    .config-line input {flex: 1;box-sizing: border-box;padding: 5px;border: 1px solid #ccc;}
    .column {display: flex;flex-direction: column;flex-basis: 50%;}
    .columns {display: flex;flex-direction: column;flex-basis: 50%;padding: 10px;}
    .columns-1 {display:flex;flex-basis:28%;flex-wrap: wrap;justify-content: space-between;align-content: flex-start;align-items: flex-start;}
    .columns-2 {display:flex;flex-basis:72%;flex-wrap: wrap;align-content: center;align-items: center;justify-content: space-between;}
    .tab-container {display: flex;}
    .tab {display: inline-block;cursor: pointer;padding: 10px;background-color: #123449;color: #fff;border-radius: 5px 5px 0 0;}
    .active.tab {background-color: #FFF;color:#123449;font-weight:bold;}
    .tab-content {display: none;margin-top:5px;width: 100%;}
    .column-wrapper {display: flex;width: 100%;align-content: flex-start;}
    .column-1 {flex-basis: 10%;display: flex;align-content: flex-start;height:136px;}
    
    #area_de_atuacao {background-color:#123449;margin:5px 0 0 0;flex-basis:100%;flex-wrap: wrap;border-radius:5px;height: 32%;overflow: auto;}
    #area_de_atuacao::-webkit-scrollbar,#area_de_atuacao::-webkit-scrollbar {width: 2px;height: 2px !important;background-color: white;}
    #area_de_atuacao::-webkit-scrollbar-thumb,#area_de_atuacao::-webkit-scrollbar-thumb {background-color: #1a88ff;}


    #area_de_planos {background-color:#123449;margin:5px 0 0 0;flex-basis:100%;flex-wrap: wrap;border-radius:5px;max-height:32%;height:32%;overflow:auto;}
    #area_de_planos::-webkit-scrollbar,#area_de_planos::-webkit-scrollbar {width: 2px;height: 2px !important;background-color: white;}
    #area_de_planos::-webkit-scrollbar-thumb,#area_de_planos::-webkit-scrollbar-thumb {background-color: #1a88ff;}

    
    
    
    
    .column-2 {flex-basis: 38%;background-color:#123449;border-radius: 5px;margin:0 1%;display: flex;align-content: flex-start;height:564px;}








    .column-2 span  {color:#FFF;font-weight:normal;display: flex;align-content: flex-start;}
    .column-3 {flex-basis: 50%;display: flex;align-content: flex-start;height:540px;}
    .comission-table {display: none;width: 100%;margin-left: 30px;background-color:#123449;color:#FFF;padding:5px;border-radius:5px;}
    .comission-table.active {display: block;}
    #tab3-content {display:flex;}
    #tab3-content #content_left_comission {display:flex;margin-right:5px;}
    #tab3-content #content_right_comission {display:flex;color:#FFF;width:400px;}
    #tab2-content .comission-options .option {cursor: pointer;margin-bottom: 5px;}
    #hapvida-options-comissions-planos {display: none;background-color:#123449;color:#FFF;padding:5px;margin-left:5px;border-radius:5px;height:auto;font-size:0.9em;}
    #coletivo-por-adesao-options-comissions {display: none;background-color:#123449;color:#FFF;padding:5px;margin-left:5px;border-radius:5px;height:100px;width:80px;min-width:80px;font-size:0.9em;}
    #comission-cities {display:none;margin-left: 10px;background-color:#123449;color:#FFF;border-radius:5px;padding:2px;height:300px;overflow: auto;flex-basis:100px;min-width:110px;width:110px !important;font-size:0.9em;}
    #hapvida-options-comissions {display: none;background-color:#123449;color:#FFF;height:70px;margin-left:7px;border-radius:5px;min-width:140px !important;padding:3px;width:140px !important;font-size:0.9em;}
    .comission-type {display:flex;flex-direction: column;width:138px;}
    #hapvida-options-comissions-planos.comission-option,
    #coletivo-por-adesao-options-comissions.comission-option {margin-left:20px;}
    .lista-destaque {
        background-color:#FFF !important;
        color:#000 !important;

    }
    .content_abrir_modal_cadastrar {
        cursor:pointer;
    }
</style>
@stop

@section('js')
    <script src="{{asset('vendor/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('js/jquery.mask.min.js')}}"></script>
    <script>

        $(document).ready(function() {

            $(".editar_administradora").on('click',function(){
                
                let administradora = $(this).attr('data-id');
                $("#administradoras_planos_modal").val(administradora);
                $.ajax({
                    url:"{{route('administradora.planos.verificar')}}",
                    method:"POST",
                    data:"administradora="+administradora,
                    success:function(res) {
                        if(res != "nada") {
                            res.forEach(function(valor) {
                                $('#administradorasPlanosModal input[data-id="'+valor+'"]').prop('checked',true);
                            });
                            $("#administradorasPlanosModal").modal('show');
                        } else {
                            $("#administradorasPlanosModal").modal('show');
                        }
                            
                    }
                })
            });






            $("#salvar_administradora_planos").click(function(){
                let administradora = $("#administradoras_planos_modal").val();
                let planos = [];
                $('#administradorasPlanosModal input[type="checkbox"]:checked').each(function() {
                    planos.push($(this).data('id'));
                });
                $.ajax({
                    url:"{{route('administradora.planos.cadastrar')}}",
                    method:"POST",
                    data:"administradora="+administradora+"&planos="+planos,
                    success:function(res) {
                        if(res == "sucesso") {
                            $("#administradorasPlanosModal").modal('hide');
                            $('#list_administradora input[type="checkbox"]:checked').each(function() {    
                                $(this).prop("checked",false);
                            });
                        }
                    }
                });
            });

            $('#administradorasPlanosModal').on('hide.bs.modal', function (event) {
                $('#administradorasPlanosModal input[type="checkbox"]:checked').each(function() {    
                    $(this).prop("checked",false);
                });
                
            });




            function planosFaltandoCidade() {
                $('#list_planos_cadastrado_escolher').empty();
                $.ajax({
                    url:"{{route('pegar.cidade.corretore.plano')}}",
                    method:"POST",
                    data:"id=2",
                    success:function(res) {
                        $.each(res, function (index, plano) {
                            let listItem = $('<li class="list-group-item col-6">'); // Adicione a classe col-6 aqui
                            let checkbox = $('<input type="checkbox" data-id="' + plano.id + '" name="planos" value="' + plano.nome + '">');
                            let label = $('<label for="plano' + plano.id + '">' + plano.nome + '</label>');

                            // Adicionando o checkbox e o label ao listItem
                            listItem.append(checkbox);
                            listItem.append(label);
                            $("#planos_cadastrado_escolher").slideDown('fast', function () {
                                $('#list_planos_cadastrado_escolher').append(listItem);
                            });
                            // Adicionando o listItem à lista
                        });
                        
                    }
                });
            }

            function planosFaltandoCidadeJaExiste(id) {
                $.ajax({
                    url:"{{route('pegar.cidade.corretore.plano')}}",
                    method:"POST",
                    data:"id="+id,
                    success:function(res) {
                        $.each(res, function (index, plano) {
                            let listItem = $('<li class="list-group-item col-6">');
                            let checkbox = $('<input type="checkbox" data-id="' + plano.id + '" name="planos" value="' + plano.nome + '">');
                            let label = $('<label for="plano' + plano.id + '">' + plano.nome + '</label>');

                            // Adicionando o checkbox e o label ao listItem
                            listItem.append(checkbox);
                            listItem.append(label);

                            // Adicionando o listItem à lista
                            $('#list_planos_cadastrado_escolher_alterar').append(listItem);
                        });
                    }
                });
            }
            
            $("#salvarConfiguracao").click(function () {
                
                
                //let cidadesSelecionadas = $("#areaDeAtuacao").val().join(",");;
                //$("#tabelas").html("");
                let planosSelecionados = $("input[name='planos']:checked").map(function () {
                    return $(this).val();
                }).get();


                if (planosSelecionados.length > 0) {
                    // Limpe o conteúdo anterior, se houver
                    $("#tabelas").html('');
                    $.ajax({
                        url:"{{route('corretora.criar.tabelas.cadastro.dinamicamente')}}",
                        method:"POST",
                        data:"cidade=2&plano="+planosSelecionados,
                        success:function(res) {
                            
                            if(res.mostrar) {
                                let lista = $(`<li data-id="${res.cidade_id}">`).html('<span style="display:flex;flex-basis:100%;justify-content:center;">' + res.cidade + '</span>');
                                $("#cities_list_corretora ul").append(lista);
                                $("#tabelas").html("");                               
                                $("#tabelas").html(res.view);
                            } else {
                                $("#tabelas").append(res.view);    
                            }
                            let select = $('#areaDeAtuacao');
                            select.find('option').prop('selected',false);
                            $("#planos_cadastrado_escolher input[type='checkbox']").prop('checked', false);
                            $('#configurarModal').modal('hide');
                        }
                    });
                    $("#planos_cadastrado_escolher").slideUp();                
                } else {
                    toastr["error"]("Pelo Menos 1 Cidade e Planos tem que estar Marcado")
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
                }
        });


        $("body").on('click','#salvarConfiguracaoAlterarJaExiste',function(){
        
            let planosSelecionados = $("input[name='planos']:checked").map(function () {
                return $(this).val();
            }).get();
            
            

            $.ajax({
                url:"{{route('corretora.criar.tabelas.cadastro.dinamicamente')}}",
                method:"POST",
                data:"plano="+planosSelecionados,
                success:function(res) {
                    
                    // if(res != "error") {
                        
                        
                        $("#tabelas").append(res.view);
                        $('#abrirModalCidadeJaExiste').modal('hide');
                        
                        
                                                        
                        $("#list_planos_cadastrado_escolher_alterar input[type='checkbox']").prop('checked', false);



                    // }
                }
            });                



        });





            $("body").on('click',"#areaDeAtuacao .city",function(){
                let id = $(this).val();
                let texto = $(this).text();
                $("#cidade_id_corretora").val(id);
                $("#cidade_nome_corretora").val(texto);
                planosFaltandoCidade(id);
            });





            $("body").on('click','.abrir_modal_cadastrar',function(){
                $('#list_planos_cadastrado_escolher_alterar').empty();
                let cidade_id = $("#cidade_id_corretora").val();
                let cidade = $("#cidade_nome_corretora").val();
                $("#abrirModalCidadeJaExisteLabel").html(`<h5 class='text-center'>Configurar comissão de ${cidade}</h5>`);
                
                $('#abrirModalCidadeJaExiste').modal('show');
                planosFaltandoCidadeJaExiste(cidade_id);
                
            });

            $('#comissionModalEditar').on('hidden.bs.modal', function (event) {
                $("#plans_list_comissao_alterar").html('');
            });

            $('#configurarModal').on('show.bs.modal', function (event) {
                planosFaltandoCidade();
            });




            $("body").on('click','.abrir_modal_cadastrar_corretor',function(){
                $("#comissionModalEditar").modal('show');
                let tipo = $("#tipo_corretor").val();
                $.ajax({
                    url:"{{route('corretora.planos.comissao.corretor')}}",
                    method:"POST",
                    data:"tipo="+tipo,
                    success:function(res) {
                        
                        $.each(res, function (index, plano) {
                            let listItem = $('<li class="list-group-item col-6">');
                            let checkbox = $('<input type="checkbox" data-id="' + plano.id + '" name="plano_corretor_alterar" value="' + plano.nome + '">');
                            let label = $('<label for="plano' + plano.id + '">' + plano.nome + '</label>');
                            //Adicionando o checkbox e o label ao listItem
                            listItem.append(checkbox);
                            listItem.append(label);
                            //Adicionando o listItem à lista
                            $('#plans_list_comissao_alterar').append(listItem);
                        });                        
                    }
                }); 
            });

            $("body").on('change','#citiesCorretorAlterar',function(){
                let tipo = $("#tipo_corretor").val();
                
                $.ajax({
                    url:"{{route('corretora.planos.comissao.corretor')}}",
                    method:"POST",
                    data:"tipo="+tipo,
                    success:function(res) {
                        $.each(res, function (index, plano) {

                            let listItem = $('<li class="list-group-item col-6">');
                            let checkbox = $('<input type="checkbox" data-id="' + plano.id + '" name="plano_corretor_alterar" value="' + plano.nome + '">');
                            let label = $('<label for="plano' + plano.id + '">' + plano.nome + '</label>');

                            //Adicionando o checkbox e o label ao listItem
                            listItem.append(checkbox);
                            listItem.append(label);

                                //Adicionando o listItem à lista
                            $('#plans_list_comissao_alterar').append(listItem);

                        });
                        
                    }
                });

            });






            $("body").on('click','.btn_remove_comissao',function(){
                let tipo = $(this).attr('data-tipo');
                let plano = $(this).attr('data-plano');
                let administradora = $(this).attr('data-administradora');
                

                $(this).closest('div.container_tabela').remove();

                $.ajax({
                    url:"{{route('remove.comissao.corretora.configuracoes')}}",
                    method:"POST",
                    data: {
                        tipo,
                        plano,
                        administradora
                    },
                    success:function(res) {
                        
                        if(res.error == "vazio") {
                            $("#cities_list_corretora ul li").slideUp();
                            $("#tabelas").slideUp('fast',function(){
                                $(this).empty().html("<p class='mx-auto my-auto'>Editar/Cadastrar comissão da corretora aqui!</p>").slideDown('fast');
                            })
                        } else {

                        }
                        
                    }
                });



            });





            $("body").on('click','.btnAtualizarCorretor',function(){
                let camposVazios = 0;
                $('#tabelas_corretor input[type="text"]').each(function() {
                    if ($(this).val() == '') {                      
                        camposVazios++;
                        $(this).addClass('campo-em-branco');
                    } else {
                        $(this).removeClass('campo-em-branco');
                    }
                });

                if (camposVazios > 0) {
                    toastr["error"]("Todos os campo são obrigatório")
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
                    return false; // Impede o envio do formulário
                } else {

                    let formulario = $('#tabelas_corretor');
                    let campos = formulario.find('input[type="text"]');
                    let dados = {};
                    campos.each(function() {
                        var nomeDoCampo = $(this).attr('name');
                        var valorDoCampo = $(this).val();
                        dados[nomeDoCampo] = valorDoCampo;
                    });
                    let dadosReorganizados = {};
                    let tt = "";
                    for (var chave in dados) {
                        let tipo = chave.split("_")[2];
                        tt   = chave.split("_")[2];
                        let administradora_or_plano = chave.split("_")[3]; // Extrair o nome da administradora(Qualicorp) ou PME Simples Simples Individual
                        let cidade = chave.split("_")[4];
                        let plano = chave.split("_")[5];
                        let indice = tipo+"_"+administradora_or_plano+"_"+cidade+"_"+plano;
                        if (!dadosReorganizados[indice]) {
                            dadosReorganizados[indice] = {};
                        }
                        let parcela = chave.split("_")[1]; // Extrair o número da parcela
                        let valor = dados[chave];
                        dadosReorganizados[indice][parcela] = valor;
                    }

                    $.ajax({
                        url:"{{route('corretor.alterar.comissao.valores')}}",
                        method:"POST",
                        data: {
                            dados:dadosReorganizados,
                            tipo: $("#tipo_corretor").val()
                        },
                        success:function(res) {
                            if(res == "alterado") {

                                toastr["success"]("Dados Atualizados com sucesso")
                                toastr.options = {
                                    "closeButton": false,
                                    "debug": false,
                                    "newestOnTop": false,
                                    "progressBar": false,
                                    "positionClass": "toast-top-right",
                                    "preventDuplicates": false,
                                    "onclick": null,
                                    "showDuration": "300",
                                    "hideDuration": "1000",
                                    "timeOut": "5000",
                                    "extendedTimeOut": "1000",
                                    "showEasing": "swing",
                                    "hideEasing": "linear",
                                    "showMethod": "fadeIn",
                                    "hideMethod": "fadeOut"
                                }






                            } 
                            
                        }
                });

                }
            });


            $("body").on('click','.btn_remove_comissao_corretor',function(){
                let plano = $(this).attr('data-plano');
                let administradora = $(this).attr('data-administradora');
                
                let tipo = $(this).attr('data-tipo');
                
                $(this).closest('.container_comissao_corretor').remove();

                $.ajax({
                    url:"{{route('corretora.excluir.comissao.corretor')}}",
                    method:"POST",
                    data: {
                        plano,administradora,tipo
                    },
                    success:function(res) {
                        if(res == 0) {
                            $("#tabelas_corretor").html('');
                            $("#tabelas_corretor").slideUp('fast').html('<p class="mx-auto my-auto">Editar/Cadastrar comissão da corretor aqui!</p>').slideDown();
                        }
                    }
                });
            });


            $("#tipos_list_corretor li").on('click',function(){                
                let id      = $(this).attr('data-id');
                $("#tipos_list_corretor li").removeClass('lista-destaque');
                $(this).addClass('lista-destaque');
                $("#tipo_corretor").val(id);
                $.ajax({
                    url:"{{route('show.corretor.alterar.comissao')}}",
                    method:"POST",
                    data: {id},
                    success:function(res) {
                        console.log(res);
                        if(res != "empty") {
                            $("#tabelas_corretor").html(res);
                        } else {
                            $("#tabelas_corretor").html(`<p class="mx-auto my-auto">Sem comissão registradas =/!</p>`)
                        }
                        //console.log(res);
                        
                    }
                });
            });

            $("body").on('change','.mudar_valor_corretor_comissao',function(){
                let id = $(this).attr('data-id');
                let tipo = $(this).attr('data-tipo');
                let valor = $(this).val();
                
                $.ajax({
                    url:"{{route('corretora.valor.corretor.comissao')}}",
                    method:"POST",
                    data:"id="+id+"&tipo="+tipo+"&valor="+valor,
                    success:function(res) {
                        console.log(res);
                    }
                });
            });


            $("body").on('click','#cities_list_corretora li',function(){
                //let id = $(this).attr('data-id');

                



                //$("#cidade_id_corretora").val(id);
                //let texto = $(this).text();
                //$("#cidade_nome_corretora").val($.trim(texto));

                //$("#cidade_clicada").html("<h5>Comissão <strong>"+texto+"</strong></h5>");
                //$("#cities_list_corretora li").removeClass("lista-destaque");
                $(this).addClass('lista-destaque');
                
                $.ajax({
                    url:"{{route('corretora.lista.cidade')}}",
                    method:"POST",
                    data:"id=0",
                    success:function(res) {
                        
                        $("#tabelas").slideUp('slow',function(){
                            $("#tabelas").html(res).slideDown('slow');
                        });
                        
                    }
                });
            });


            $('body').on('click','.btn-atualizar-corretora',function(){
                let cidade_id = $("#cidade_id_corretora").val();
                let formulario = $('#tabelas');
                let campos = formulario.find('input[type="text"]');
                let dados = {};
                campos.each(function() {
                    var nomeDoCampo = $(this).attr('name');
                    var valorDoCampo = $(this).val();
                    dados[nomeDoCampo] = valorDoCampo;
                });
                let dadosReorganizados = {};
                for (var chave in dados) {
                    let tipo = chave.split("_")[3];
                    let administradora_id = chave.split("_")[5];
                    let administradora_or_plano = chave.split("_")[2]; // Extrair o nome da administradora(Qualicorp) ou PME Simples Simples Individual
                    let id_plano = chave.split("_")[4];
                    let indice = administradora_or_plano+"_"+tipo+"_"+id_plano+"_"+administradora_id;
                    if (!dadosReorganizados[indice]) {
                        dadosReorganizados[indice] = {};
                    }
                    let parcela = chave.split("_")[1]; // Extrair o número da parcela
                    let valor = dados[chave];
                    dadosReorganizados[indice][parcela] = valor;
                }
                $.ajax({
                    url:"{{route('corretora.alterar.comissao.corretor')}}",
                    method:"POST",
                    data: {
                        cidade:cidade_id,
                        dados:dadosReorganizados
                    },
                    success:function(res) {
                        if(res == "cadastrar") {
                            toastr["success"]("Dados Atualizados com sucesso")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                        }
                    }
                });
            });

            

            $('#configurarModal').on('shown.bs.modal', function (event) {
                $("#cities_list_corretora li").removeClass("lista-destaque");
                $("#cidade_id_corretora").val('');  
            });
       
            $("#citiesCorretor").on('change',function(){
                let id = $(this).val();
                $("#cidade_id_corretor").val(id);
                criarPlanosRestanteComissaoCorretor();
            });

            $("#comissionTypeCorretor").on('change',function(){
                let tipo = $(this).val();
                $("#tipo_corretor").val(tipo);
                criarPlanosRestanteComissaoCorretor();
            });

            function criarPlanosRestanteComissaoCorretor() {

                if($("#tipo_corretor").val() != "") {
                    $.ajax({
                        url:"{{route('corretora.planos.comissao.corretor')}}",
                        method:"POST",
                        data:"cidade=2&tipo="+$("#tipo_corretor").val(),
                        success:function(res) {
                            
                            $.each(res, function (index, plano) {
                                let listItem = $('<li class="list-group-item col-6">'); 
                                let checkbox = $('<input type="checkbox" data-id="' + plano.id + '" name="planos_corretor" value="' + plano.nome + '">');
                                let label = $('<label for="plano' + plano.id + '">' + plano.nome + '</label>');
                                
                                listItem.append(checkbox);
                                listItem.append(label);
                                $("#plans").slideDown('fast', function () {
                                    $('#plans_list_comissao').append(listItem);
                                });
                                
                            });
                        }
                    });




                }

            }



            $("#salvar_comissoes_corretor").on('click',function(){
                let tipo_corretor = $("#comissionTypeCorretor").val();
                //let cidade_id = $("#citiesCorretor").val();
                let planosSelecionadosCorretor = $("input[name='planos_corretor']:checked").map(function () {return $(this).val();}).get();
                
                $.ajax({
                    url:"{{route('corretora.cadastrar.comissao.corretor')}}",
                    method:"POST",
                    data: {
                        tipo:tipo_corretor,
                        //cidade:cidade_id,
                        planos:planosSelecionadosCorretor
                    },
                    success:function(res) {
                        //console.log(res);
                        
                        $("#tabelas_corretor").html(res.view);
                        $('#comissionModal').modal('hide');

                        $("#comissionTypeCorretor").val('');
                        $("#citiesCorretor").val('');
                        $("#plans_list_comissao_alterar").empty('');
                        //$("#cidade_id_corretor").val(''); 
                        //$("#tipo_corretor").val('');


                    }
                });

            });

            $("#salvar_comissoes_corretor_alterar").on('click',function(){
                let tipo_corretor = $("#tipo_corretor").val();
                
                let planosSelecionadosCorretor = $("input[name='plano_corretor_alterar']:checked").map(function () {return $(this).val();}).get();
                
                $.ajax({
                    url:"{{route('corretora.plus.all.planos.alterar')}}",
                    method:"POST",
                    data: {
                        tipo:tipo_corretor,
                        
                        planos:planosSelecionadosCorretor
                    },
                    success:function(res) {
                       
                        
                        $("#tabelas_corretor").html(res);
                        $('#comissionModalEditar').modal('hide');

                        
                        // $(".city_alterar").val('');
                        // $("#plans_list_comissao").empty('');
                        // $("#cidade_id_corretor").val(''); 
                        // $("#tipo_corretor").val('');


                    }
                });

            });
















            $('#comissionModal').on('hidden.bs.modal', function (event) {
                $("#comissionTypeCorretor").val('');
                $("#citiesCorretor").val('');
                $("#plans_list_comissao").empty('');
                //$("#cidade_id_corretor").val(''); 
                //$("#tipo_corretor").val('');
            });


           








            
            
            $("body").on('click','#btnCadastrarCorretor',function(){
                let camposVazios = 0;

                $('#tabelas_corretor input[type="text"]').each(function() {
                    if ($(this).val() == '') {                      
                        camposVazios++;
                        $(this).addClass('campo-em-branco');
                    } else {
                        $(this).removeClass('campo-em-branco');
                    }
                });

                if (camposVazios > 0) {
                        toastr["error"]("Todos os campo são obrigatório")
                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                    return false; // Impede o envio do formulário
                } else {
                    let formulario = $('#tabelas_corretor');
                    let campos = formulario.find('input[type="text"]');
                    let dados = {};
                    campos.each(function() {
                        var nomeDoCampo = $(this).attr('name');
                        var valorDoCampo = $(this).val();
                        dados[nomeDoCampo] = valorDoCampo;
                    });
                    let dadosReorganizados = {};
                    for (var chave in dados) {
                        let tipo = chave.split("_")[3];
                        let administradora_or_plano = chave.split("_")[2]; // Extrair o nome da administradora(Qualicorp) ou PME Simples Simples Individual
                        let id_plano = chave.split("_")[4];
                        let indice = administradora_or_plano+"_"+tipo+"_"+id_plano;
                        if (!dadosReorganizados[indice]) {
                            dadosReorganizados[indice] = {};
                        }
                        let parcela = chave.split("_")[1]; // Extrair o número da parcela
                        let valor = dados[chave];
                        dadosReorganizados[indice][parcela] = valor;
                    }
                    let cidade_id = $("#cidade_id_corretor").val();
                    let tipo = $("#tipo_corretor").val();
                    $.ajax({
                        url:"{{route('corretora.cadastrar.corretor.comissao')}}",
                        method:"POST",
                        data: {
                            cidade:cidade_id,
                            dados:dadosReorganizados,
                            tipo
                        },
                        success:function(res) {                            
                            if(res == "cadastrado") {
                                toastr["success"]("Cadastrado com sucesso")
                                toastr.options = {
                                    "closeButton": false,
                                    "debug": false,
                                    "newestOnTop": false,
                                    "progressBar": false,
                                    "positionClass": "toast-top-right",
                                    "preventDuplicates": false,
                                    "onclick": null,
                                    "showDuration": "300",
                                    "hideDuration": "1000",
                                    "timeOut": "5000",
                                    "extendedTimeOut": "1000",
                                    "showEasing": "swing",
                                    "hideEasing": "linear",
                                    "showMethod": "fadeIn",
                                    "hideMethod": "fadeOut"
                                }
                            }                           
                        }
                    });
                }
            });

            
            $("body").on('change','.mudar_valor_parcela',function(){
                let id = $(this).attr('name');
                let valor = $(this).val();
                $.ajax({
                    url:"{{route('mudar.valor.comissao.especifica')}}",
                    method:"POST",
                    data:"id="+id+"&valor="+valor,
                    success:function(res) {
                        console.log(res);
                    }
                });
            });





           


        $("#cep").change(function(){
            let cep = $(this).val().replace("-","");
            const url = `https://viacep.com.br/ws/${cep}/json`;
            const options = {method: "GET",mode: "cors",
                headers: {'content-type': 'application/json;charset=utf-8'}
            }
            fetch(url,options).then(response => response.json()).then(
                data => {
                    $("#cidade").val(data.localidade);
                    $("#bairro").val(data.bairro);
                    $("#rua").val(data.logradouro);
                    $("#complemento").val(data.complemento);
                    $("#uf").val(data.uf);
                    
                }
            )
            if($(this).val() != "") {
                $(".errorcep").html('');
            }
        });




        $.getJSON("{{asset('js/estados_cidades.json')}}", function (data) {
                
            var options = '<option value="">UF</option>';
            $.each(data, function (key, val) {
                options += '<option value="' + val.sigla + '">' + val.nome + '</option>';
            });

            $("#uf_tabela_origens").html(options);

            // Manipulação do evento de alteração na UF para carregar cidades correspondentes
            $("#uf_tabela_origens").change(function () {
                var options_cidades = '';
                var selectedUF = $(this).val();
                $.each(data, function (key, val) {
                    if (val.sigla === selectedUF) {
                        $.each(val.cidades, function (key_city, val_city) {
                            options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
                        });
                    }
                });

                $("#cidade_tabela_origens").html(options_cidades).trigger('change');
            }).change();
                

        });

            $("body").on('click','.deletar_tabela_origens',function(){
                let id = $(this).attr("data-id");
                let confirmacao = confirm("Tem certeza que deseja deletar?");
                if(confirmacao) {
                    $(this).closest("p[id=tabela_origens_"+id+"]").slideUp('slow');
                    $.ajax({
                        url:"{{route('tabela_origem.deletar')}}",
                        method:"POST",
                        data: {ids},
                        success:function(res) {
                            console.log(res);
                        }
                    });
                }
               
            });

           



           

            let image_admin = ""
            $("#image_administradora").on('change',function(e){
            	image_admin = e.target.files;
            });


            let $listaAdmin = $("#list_administradora");
            $(".cadastrar_administradora_formulario").on('click',function(){
                let fd = new FormData();
                fd.append('file',image_admin[0]);
                fd.append('nome',$('#name_administradora').val());
                
                $.ajax({
            		url:"{{route('corretora.store.administradora')}}",
            		method:"POST",
            		data:fd,
            		contentType: false,
           			processData: false,
            		success:function(res){
                        console.log(res);
                        // if(res != "error") {
                        //     $('#exampleModalAdministradora').modal('hide');
                        //     $listaAdmin.html('');
                        //     res.forEach(function(administradora) {
                        //         var html = '<p style="color:#FFF;margin:0;padding:0;display:flex;justify-content: space-between;flex-basis:100%;" id="administradora_' + administradora.id + '">' +
                        //             '<span style="font-size:0.72em;">' + administradora.nome + '</span>' +
                        //             '<span style="font-size:0.8em;"><i class="fas fa-times fa-xs deletar_administradora" data-id="' + administradora.id + '"></i></span>' +
                        //             '</p>';

                        //         $listaAdmin.append(html);
                        //     });
                        // } else {

                        // }   
            			
            		}
            	});


                return false;
            });

            $("body").on('click','.deletar_administradora',function(){
                let id = $(this).attr('data-id');
                let confirmacao = confirm("Tem certeza que deseja deletar?");
                if (confirmacao) {
                    $(this).closest("p[id='administradora_"+id+"']").slideUp('fast');
                    $.ajax({
                        url:"{{route('corretora.remover.administradora')}}",
                        method:"POST",
                        data: {
                            id
                        }
                    });
                }
            });








            $(".comission-options .option").on('click',function(){
                selectedPlanDetailCorretora = $(this).text();
                selectedPlanCorretora = "";
                updatePathCorretora();


                if($("#coletivo-table").is(":visible")) {
                    
                    $(".comission-table").removeClass('active');
                    $("#corretora_administradora_coletivo").val('');

                    $(".comissao_corretora_1_parcela").val('');
                    $(".comissao_corretora_2_parcela").val('');
                    $(".comissao_corretora_3_parcela").val('');
                    $(".comissao_corretora_4_parcela").val('');
                    $(".comissao_corretora_5_parcela").val('');
                    $(".comissao_corretora_6_parcela").val('');
                    $(".comissao_corretora_7_parcela").val('');
                    $("#corretora_administradora_coletivo").val('');
                    $(".option-group .sub-option").removeClass('destaque');
                }

                if($("#hapvida-table").is(":visible")) {
                    $(".comission-table").removeClass('active');
                    $(".corretora_comissao_1_parcela_individual").val('');
                    $(".corretora_comissao_2_parcela_individual").val('');
                    $(".corretora_comissao_3_parcela_individual").val('');
                    $(".corretora_comissao_4_parcela_individual").val('');
                    $(".corretora_comissao_5_parcela_individual").val('');
                    $(".corretora_comissao_6_parcela_individual").val('');
                    $("#corretora_tipo_plano_individual").val('');
                    $(".option-group .sub-option").removeClass('destaque');
                }

                if($(this).attr('data-texto') == "Hapvida") {
                    $("#corretora_tipo_plano").val(1);
                } else {
                    $("#corretora_tipo_plano").val(3);
                }
            });

            $("#hapvida-options .sub-option").on('click',function(){
                $("#corretora_tipo_plano_individual").val($(this).attr('data-id'));

                selectedPlanCorretora = $(this).text();
                
                updatePathCorretora();

                let cidade = $("#corretora_tabela_origens_id").val();
                let tipo_plano = $("#corretora_tipo_plano").val();
                let plano = $("#corretora_tipo_plano_individual").val();

                $.ajax({
                    url:"{{route('corretora.verificar.comissao')}}",
                    method:"POST",
                    data: {
                        cidade,
                        tipo_plano,
                        plano
                    },
                    success:function(res) {
                        if(res != "nada") {
                            $(".corretora_comissao_1_parcela_individual").val(res[0].valor);
                            $(".corretora_comissao_2_parcela_individual").val(res[1].valor);
                            $(".corretora_comissao_3_parcela_individual").val(res[2].valor);
                            $(".corretora_comissao_4_parcela_individual").val(res[3].valor);
                            $(".corretora_comissao_5_parcela_individual").val(res[4].valor);
                            $(".corretora_comissao_6_parcela_individual").val(res[5].valor);
                        } else {
                            $(".corretora_comissao_1_parcela_individual").val('');
                            $(".corretora_comissao_2_parcela_individual").val('');
                            $(".corretora_comissao_3_parcela_individual").val('');
                            $(".corretora_comissao_4_parcela_individual").val('');
                            $(".corretora_comissao_5_parcela_individual").val('');
                            $(".corretora_comissao_6_parcela_individual").val('');
                        }
                    }
                });





            }); 
            
            $("#coletivo-options .sub-option").on('click',function(){
                

                selectedPlanCorretora = $(this).text();
                updatePathCorretora();


                //if($("#corretora_administradora_coletivo").val() != "") {
                    let cidade = $("#corretora_tabela_origens_id").val();
                    let tipo_plano = $("#corretora_tipo_plano").val();
                    let administradora = $(this).attr('data-id');
                    
                    $.ajax({
                        url:"{{route('corretora.verificar.comissao')}}",
                        method:"POST",
                        data: {cidade,tipo_plano,administradora},
                        success:function(res) {
                            if(tipo_plano == 3) {

                                if(res == "nada") {
                                    $(".comissao_corretora_1_parcela").val('');
                                    $(".comissao_corretora_2_parcela").val('');
                                    $(".comissao_corretora_3_parcela").val('');
                                    $(".comissao_corretora_4_parcela").val('');
                                    $(".comissao_corretora_5_parcela").val('');
                                    $(".comissao_corretora_6_parcela").val('');
                                    $(".comissao_corretora_7_parcela").val('');
                                } else {
                                    $(".comissao_corretora_1_parcela").val(res[0].valor);
                                    $(".comissao_corretora_2_parcela").val(res[1].valor);
                                    $(".comissao_corretora_3_parcela").val(res[2].valor);
                                    $(".comissao_corretora_4_parcela").val(res[3].valor);
                                    $(".comissao_corretora_5_parcela").val(res[4].valor);
                                    $(".comissao_corretora_6_parcela").val(res[5].valor);
                                    $(".comissao_corretora_7_parcela").val(res[6].valor);
                                }                                   
                            }
                        }
                    });

                $("#corretora_administradora_coletivo").val($(this).attr('data-id'));
            });


            $("body").on('click','.salvar_corretora_individual',function(){
                let cidade = $("#corretora_tabela_origens_id").val();
                let tipo_plano = $("#corretora_tabela_origens_id").val();
                let plano_individual = $("#corretora_tipo_plano_individual").val();

                let comissao_1_parcela_individual = $(".corretora_comissao_1_parcela_individual").val();
                let comissao_2_parcela_individual = $(".corretora_comissao_2_parcela_individual").val();
                let comissao_3_parcela_individual = $(".corretora_comissao_3_parcela_individual").val();
                let comissao_4_parcela_individual = $(".corretora_comissao_4_parcela_individual").val();
                let comissao_5_parcela_individual = $(".corretora_comissao_5_parcela_individual").val();
                let comissao_6_parcela_individual = $(".corretora_comissao_6_parcela_individual").val();
                
                let parcelas = [
                    comissao_1_parcela_individual,
                    comissao_2_parcela_individual,
                    comissao_3_parcela_individual,
                    comissao_4_parcela_individual,
                    comissao_5_parcela_individual,
                    comissao_6_parcela_individual
                ];

                $.ajax({
                    url:"{{route('corretora.store.comissao')}}",
                    method:"POST",
                    data: {
                        cidade,
                        tipo_plano,
                        parcelas,
                        plano:plano_individual
                    },

                    beforeSend:function() {

                        if($(".corretora_comissao_1_parcela_individual").val() == "") {
                            toastr["error"]("1º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($(".corretora_comissao_2_parcela_individual").val() == "") {
                            toastr["error"]("2º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($(".corretora_comissao_3_parcela_individual").val() == "") {
                            toastr["error"]("3º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($(".corretora_comissao_4_parcela_individual").val() == "") {
                            toastr["error"]("4º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($(".corretora_comissao_5_parcela_individual").val() == "") {
                            toastr["error"]("5º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($(".corretora_comissao_6_parcela_individual").val() == "") {
                            toastr["error"]("6º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }

                    },
                    success:function(res) {
                        if(res == "cadastrado") {
                            
                                toastr["success"]("Dados inseridos com sucesso")
                                toastr.options = {
                                    "closeButton": false,
                                    "debug": false,
                                    "newestOnTop": false,
                                    "progressBar": false,
                                    "positionClass": "toast-top-right",
                                    "preventDuplicates": false,
                                    "onclick": null,
                                    "showDuration": "300",
                                    "hideDuration": "1000",
                                    "timeOut": "5000",
                                    "extendedTimeOut": "1000",
                                    "showEasing": "swing",
                                    "hideEasing": "linear",
                                    "showMethod": "fadeIn",
                                    "hideMethod": "fadeOut"
                                }
                            
                        }
                    }
                });

            });

            $("body").on('click','.salvar_corretora_coletivo',function(){
                let cidade = $("#corretora_tabela_origens_id").val();
                let tipo_plano = $("#corretora_tipo_plano").val();
                let administradora = $("#corretora_administradora_coletivo").val();

                let comissao_1_parcela_coletivo = $(".comissao_corretora_1_parcela").val();
                let comissao_2_parcela_coletivo = $(".comissao_corretora_2_parcela").val();
                let comissao_3_parcela_coletivo = $(".comissao_corretora_3_parcela").val();
                let comissao_4_parcela_coletivo = $(".comissao_corretora_4_parcela").val();
                let comissao_5_parcela_coletivo = $(".comissao_corretora_5_parcela").val();
                let comissao_6_parcela_coletivo = $(".comissao_corretora_6_parcela").val();
                let comissao_7_parcela_coletivo = $(".comissao_corretora_7_parcela").val();

                let parcelas = [
                    comissao_1_parcela_coletivo,
                    comissao_2_parcela_coletivo,
                    comissao_3_parcela_coletivo,
                    comissao_4_parcela_coletivo,
                    comissao_5_parcela_coletivo,
                    comissao_6_parcela_coletivo,
                    comissao_7_parcela_coletivo
                ];

                $.ajax({
                    url:"{{route('corretora.store.comissao')}}",
                    method:"POST",
                    data: {
                        cidade,
                        tipo_plano,
                        administradora,
                        parcelas
                    },
                    beforeSend:function() {

                        if($(".comissao_corretora_1_parcela").val() == "") {
                            toastr["error"]("1º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }

                        if($(".comissao_corretora_2_parcela").val() == "") {
                            toastr["error"]("2º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($(".comissao_corretora_3_parcela").val() == "") {
                            toastr["error"]("3º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($(".comissao_corretora_4_parcela").val() == "") {
                            toastr["error"]("4º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($(".comissao_corretora_5_parcela").val() == "") {
                            toastr["error"]("5º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($(".comissao_corretora_6_parcela").val() == "") {
                            toastr["error"]("6º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($(".comissao_corretora_7_parcela").val() == "") {
                            toastr["error"]("7º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }

                    },
                    success:function(res) {
                        
                        if(res == "cadastrado") {
                            
                            toastr["success"]("Dados inseridos com sucesso")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }

                        }    



                    }
                });
            });

            

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

           




            $("#imgAlt").on('click',function(){
                $("#logo").click();
            });

            $("#logo").on('change',function(e){
       
                if(e.target.files.length <= 0) {
                    return;
                }
                let reader = new FileReader();
                reader.onload = () => {
                    $("#imgAlt").attr('src',reader.result);
                }
                reader.readAsDataURL(e.target.files[0]);
                let fd = new FormData();
                fd.append('file',e.target.files[0]);
                $.ajax({
            		url:"{{route('corretora.mudar.logo')}}",
            		method:"POST",
            		data:fd,
            		contentType: false,
           			processData: false,
            		success:function(res){
                        console.log(res);
                    }

                });    


            });

            // Ao clicar em uma aba, alterne o conteúdo
            $('.tab').on('click', function() {
                var tabId = $(this).data('tab');
                $(".tab").removeClass('active');
                $(this).addClass('active');
                // Esconde todos os conteúdos das abas
                $('.tab-content').removeClass('active').hide();

                // Mostra o conteúdo da aba selecionada
                $('#' + tabId).addClass('active').show();
            });

            // Por padrão, mostra a primeira aba e seu conteúdo
            $('.tab:first').click();

            // Abrir modal ao clicar no botão +
            $('#openModalButton').on('click', function() {
                $('#myModal').css('display', 'block');
            });
            function hideDivs() {
                $("#comission-cities, #hapvida-options-comissions, #coletivo-por-adesao-options-comissions, #user-list-parceiro").hide();
                $("#comission-cities .city").removeClass('ativo');
                $("#coletivo-por-adesao-options-comissions .option").removeClass('ativo');
                $("#user-list-parceiro .option").removeClass('ativo');
                $("#hapvida-options-comissions-planos .option").removeClass('ativo');


                $("#cidade_comissao_corretor .option").removeClass('ativo');
                $("#cidade_comissao_corretor").val('');
                $("#user_id").val('');
            }

            /**Logica da tab 3***/
            $(".comission-type button").click(function() {
                var type = $(this).find('span').text();
                selectedComissionType = $(this).text();
                selectedCity = "";
                selectedPlanDetail = "";
                selectedPlan = "";
                selectedUser = "";
                updatePath();
                

                $(".comission-type button").removeClass('font-weight-bold');
                $(this).closest('button').addClass('font-weight-bold');
                if($("#tipo").val() == "") {
                    
                } else {
                    let valor = type == "CLT" ? 1 : type == "Parceiro" ? 2 : 3;
                    let now = $("#tipo").val();
                    if(valor != now) {

                        hideDivs();

                        if ($("#hapvida-table-comission").is(":visible")) {
                            $("#hapvida-table-comission").hide();
                        }
                        if ($("#coletivo-table-comission").is(":visible")) {
                            $("#coletivo-table-comission").hide();
                        }

                        if($("#coletivo-por-adesao-options-comissions").is(":visible")) {
                            $("#coletivo-por-adesao-options-comissions").hide();
                        }
                        if($("#hapvida-options-comissions-planos").is(":visible")) {
                            $("#hapvida-options-comissions-planos").hide();
                        }

                        $("#plano").val('');
                        $("#administradora").val('');
                        $("#tipo_plano").val('');
                        $("#hapvida-options-comissions .option").removeClass('ativo');
                    }
                }

                if(type == "CLT") {
                    $("#tipo").val(1);
                } else if(type == "Parceiro") {
                    $("#tipo").val(2);
                } else {
                    $("#tipo").val(3);
                }

                $(".comission-type button").removeClass("active");
                $(this).addClass("active");

                // Esconder todas as opções de comissão
                $(".comission-option").hide();
                // Mostrar as opções correspondentes ao tipo selecionado
                //$("#" + type.toLowerCase().replace(/ /g, '-') + "-options").show();
                $("#comission-cities").show();
            });

            $("#hapvida-options-comissions .option").click(function(){
                let detail = $(this).attr("data-plan-detail");

                

                if($(".options-comissions-table").is(":visible")) {
                    $("#user_id").val('');
                    $("#administradora").val('');
                    $(".options-comissions-table .option").removeClass('ativo');
                    $("#user-list-parceiro .option").removeClass('ativo');
                    $(".options-comissions-table").attr({'style':'display:none;'});
                    $(".options-users-table").attr({'style':'display:none;'});
                    $("#hapvida-options-comissions-planos").attr({'style':'display:none;'});
                }

                $("#hapvida-options-comissions .option").removeClass('ativo');
                $(this).addClass('ativo');

                $("#hapvida-options-comissions .option").click(function(){
                    if ($("#hapvida-table-comission").is(":visible")) {
                        $("#hapvida-table-comission").hide();
                    } else if ($("#coletivo-table-comission").is(":visible")) {
                        $("#coletivo-table-comission").hide();
                    }
                });

                if(detail == "hapvida") {
                    $("#plano").val(1);
                    $("#coletivo-por-adesao-options-comissions").css({"display":"none"});
                    $("#hapvida-options-comissions-planos").css({"display":"flex","flex-direction":"column"});
                } else {
                    $("#plano").val(3);
                    $("#hapvida-options-comissions-planos").css({"display":"none"});
                    $("#coletivo-por-adesao-options-comissions").css({"display":"flex","flex-direction":"column"});
                }
            });

            // Exibir as opções específicas quando selecionar Hapvida ou Coletivo por Adesão
            $("#comission-options .option").click(function() {
                var optionName = $(this).text();
                
                $("#selected-comission-option").show().find(".option-name").text(optionName);

                // Esconder todas as tabelas de comissão
                $(".comission-table").removeClass("active");

                // Mostrar a tabela correspondente à opção selecionada
                $("#" + optionName.toLowerCase().replace(/ /g, '-') + "-table").addClass("active");
            });

            $(".options-comissions-table .option").click(function(){
                let id = $(this).attr("data-detail-type");
                $(".options-comissions-table .option").removeClass('ativo');
                $(this).addClass('ativo');
                //$("#administradora").val($(this).attr('data-id'));

                if(id == "hapvida-options-comissions-planos") {
                        $("#coletivo-table-comission").hide();
                        $("#hapvida-table-comission").show();
                        let texto = $(this).text();
                        let plano_id = $(this).attr('data-id');
                        $(".title-hap").html(texto);
                        $("#tipo_plano").val(plano_id);
                    } else {
                        $("#hapvida-table-comission").hide();
                        $("#coletivo-table-comission").show();
                        let id = $(this).attr('data-id');
                        let texto = $(this).text();
                        $(".title-coletivo").html(texto);
                        $("#administradora").val(id);
                        $.ajax({
                            url:"{{route('verificar.parcelas.coletivo')}}",
                            method:"POST",
                            data: {
                                tipo:$("#tipo").val(),
                                cidade:$("#cidade_comissao_corretor").val(),
                                plano:$("#plano").val(),
                                administradora:$("#administradora").val() 
                            },
                            success:function(res) {
                                if(res != "") {
                                    $(".comissao_1_parcela_coletivo").val(res[0].valor);
                                    $(".comissao_2_parcela_coletivo").val(res[1].valor);
                                    $(".comissao_3_parcela_coletivo").val(res[2].valor);
                                    $(".comissao_4_parcela_coletivo").val(res[3].valor);
                                    $(".comissao_5_parcela_coletivo").val(res[4].valor);
                                    $(".comissao_6_parcela_coletivo").val(res[5].valor);
                                    $(".comissao_7_parcela_coletivo").val(res[6].valor);
                                } else {
                                    $(".comissao_1_parcela_coletivo").val('');
                                    $(".comissao_2_parcela_coletivo").val('');
                                    $(".comissao_3_parcela_coletivo").val('');
                                    $(".comissao_4_parcela_coletivo").val('');
                                    $(".comissao_5_parcela_coletivo").val('');
                                    $(".comissao_6_parcela_coletivo").val('');
                                    $(".comissao_7_parcela_coletivo").val('');
                                }

                            }
                        });
                    }    





                if($("#tipo").val() == 3) {
                    $("#user-list-parceiro").css({"display":"flex","flex-direction":"column"});
                    
                } 
              
            });


            $("body").on('click','#user-list-parceiro .option',function(){

                let cidade      = $("#cidade_comissao_corretor").val();
                let plano       = $("#plano").val();
                let tipo_plano  = $("#tipo_plano").val();
                let user_id     = $(this).attr('data-id');
                let tipo        = $("#tipo").val();
                let administradora = $("#administradora").val();



                $.ajax({
                    url:"{{route('corretora.verificar.planos.hap')}}",
                    method:"POST",
                    data: {
                        cidade,
                        plano,
                        tipo_plano,
                        user_id,
                        administradora,
                        tipo
                    },
                    success:function(res) {
                        if(res != "") {
                            
                            if($("#coletivo-table-comission").is(":visible")) {
                                $(".comissao_1_parcela_coletivo").val(res[0].valor);
                                $(".comissao_2_parcela_coletivo").val(res[1].valor);
                                $(".comissao_3_parcela_coletivo").val(res[2].valor);
                                $(".comissao_4_parcela_coletivo").val(res[3].valor);
                                $(".comissao_5_parcela_coletivo").val(res[4].valor);
                                $(".comissao_6_parcela_coletivo").val(res[5].valor);
                                $(".comissao_7_parcela_coletivo").val(res[6].valor);
                            } else {
                                $(".comissao_1_individual").val(res[0].valor);
                                $(".comissao_2_individual").val(res[1].valor);
                                $(".comissao_3_individual").val(res[2].valor);
                                $(".comissao_4_individual").val(res[3].valor);
                                $(".comissao_5_individual").val(res[4].valor);
                                $(".comissao_6_individual").val(res[5].valor);
                            }
                            
                        } else {
                            $(".comissao_1_individual").val('');
                            $(".comissao_2_individual").val('');
                            $(".comissao_3_individual").val('');
                            $(".comissao_4_individual").val('');
                            $(".comissao_5_individual").val('');
                            $(".comissao_6_individual").val('');

                            $(".comissao_1_parcela_coletivo").val('');
                            $(".comissao_2_parcela_coletivo").val('');
                            $(".comissao_3_parcela_coletivo").val('');
                            $(".comissao_4_parcela_coletivo").val('');
                            $(".comissao_5_parcela_coletivo").val('');
                            $(".comissao_6_parcela_coletivo").val('');
                            $(".comissao_7_parcela_coletivo").val('');

                        }
                    }
                });
                let id = $(this).attr('data-id');
                $("#user-list-parceiro .option").removeClass('ativo');
                $(this).addClass('ativo');
                $("#user_id").val(id);
                if($("#plano").val() == 1) {
                    $("#coletivo-table-comission").hide();
                    $("#hapvida-table-comission").show();

                } else {
                    $("#hapvida-table-comission").hide();
                    $("#coletivo-table-comission").show();

                }

            });







            $(".cadastrar_cidade").on('click',function(){
                $('#exampleModal').modal('show');
            });

            $(".cadastrar_planos").on('click',function(){
                $('#exampleModalPlanos').modal('show');
            });

            $(".cadastrar_administradora").on('click',function(){
                $('#exampleModalAdministradora').modal('show');
            });

    
            $("body").on('click','.deletar_plano',function(){
                let id = $(this).attr('data-id');

                let confirmacao = confirm("Tem certeza que deseja deletar?");

                if (confirmacao) {
                    $(this).closest('p[id="plano_'+id+'"]').slideUp('fast');
                    $.ajax({
                        url:"{{route('corretores.deletar.planos')}}",
                        method:"POST",
                        data: {id}
                    })
                }

                

                


            });



            $(".salvar_cidade").on('click',function(){
                let nome_cidade = $("#cidade_tabela_origens").val();
                let uf_cidade = $("#uf_tabela_origens").val();
                             
                

                $.ajax({
                   url:"{{route('tabela_origem.store')}}",
                   method:"POST",
                   data:"cidade="+nome_cidade+"&uf="+uf_cidade,
                   beforeSend:function() {
                        if(nome_cidade == "") {
                            $(".error_nome_cidade").html("<p class='alert alert-danger'>Campo cidade é campo obrigatório</p>")
                        } else {
                            $(".error_nome_cidade").html("")
                        }

                       if(uf_cidade == "") {
                            $(".error_uf_cidade").html("<p class='alert alert-danger'>Campo uf é campo obrigatório</p>");
                       } else {
                            $(".error_uf_cidade").html("");
                       }
                   },
                   success: function(res) {
                        console.log(res);
                        $("#cidade_tabela_origens").val('');
                        $("#uf_tabela_origens").val('');
                        $(".error_nome_cidade").html("");
                        $(".error_uf_cidade").html("");
                        $('#exampleModal').modal('hide');
                        $("#list_cidades").html(res);
                   }
                });
                
            });

            var $listPlanos = $("#list_planos");
            $(".salvar_planos").on('click',function(){
                let nome = $("#nome_plano").val();
                let empresarial = $("#empresarial_status").val();

                $.ajax({
                    url:"{{route('corretores.cadastrar.planos')}}",
                    method:"POST",
                    data: {
                        nome,
                        empresarial
                    },
                    success:function(res) {
                        
                        if(res != "error") {
                            
                                res.forEach(function(plano) {
                                    var html = '<p style="color:#FFF;margin:0;padding:0;display:flex;justify-content: space-between;flex-basis:100%;" id="plano_' + plano.id + '">' +
                                        '<span style="font-size:0.72em;">' + plano.nome + '</span>' +
                                        '<span style="font-size:0.8em;"><i class="fas fa-times fa-xs deletar_plano" data-id="' + plano.id + '"></i></span>' +
                                        '</p>';

                                        $listPlanos.append(html);
                            });
                            
                            $('#exampleModalPlanos').modal('hide');
                            $("#nome_plano").val('');
                            $("#empresarial_status").prop('checked',false);


                        } else {

                        }
                    }
                })
                
            });

            $(".bloco_dados").on('click',function(){
                let cnpj = $("#cnpj").val();
                let razao_social = $("#razao-social").val();
                let celular = $("#celular").val();
                let telefone = $("#telefone").val();
                let email = $("#email").val();
                let cep = $("#cep").val();
                let uf = $("#uf").val();
                let cidade = $("#cidade").val();
                let bairro = $("#bairro").val();
                let rua = $("#rua").val();
                let complemento = $("#complemento").val();
                let site = $("#site").val();
                let instagram = $("#instagram").val();
                let facebook = $("#facebook").val();
                let linkedin = $("#linkedin").val();
                $.ajax({
                    url:"{{route('corretora.store')}}",
                    method:"POST",
                    data: {
                        cnpj:cnpj,
                        razao_social:razao_social,
                        celular:celular,
                        telefone:telefone,
                        email:email,
                        cep:cep,
                        cidade:cidade,
                        bairro:bairro,
                        rua:rua,
                        uf,
                        complemento:complemento,
                        site:site,
                        instagram:instagram,
                        facebook:facebook,
                        linkedin:linkedin
                    },
                    success:function(res) {
                        if(res != "error") {
                            toastr["success"]("Dados da Corretora inseridos com sucesso")
                            toastr.options = {
                               "closeButton": false,
                               "debug": false,
                               "newestOnTop": false,
                               "progressBar": false,
                               "positionClass": "toast-top-right",
                               "preventDuplicates": false,
                               "onclick": null,
                               "showDuration": "300",
                               "hideDuration": "1000",
                               "timeOut": "5000",
                               "extendedTimeOut": "1000",
                               "showEasing": "swing",
                               "hideEasing": "linear",
                               "showMethod": "fadeIn",
                               "hideMethod": "fadeOut"
                           }
                        }
                    }
                });
                return false;
            });


            $(".salvar_pdf").on('click',function(){
                let consulta_eletivas_individual = $("#consulta_eletivas_individual").val();
                let consulta_urgencia_individual = $("#consulta_urgencia_individual").val();
                let exames_simples_individual = $("#exames_simples_individual").val();
                let exames_complexos_individual = $("#exames_complexos_individual").val();

                let linha1_individual = $("#linha1_individual").val();
                let linha2_individual = $("#linha2_individual").val();
                let linha3_individual = $("#linha3_individual").val();

                let consulta_eletivas_coletivo = $("#consulta_eletivas_coletivo").val();
                let consulta_urgencia_coletivo = $("#consulta_urgencia_coletivo").val();
                let exame_simples_coletivo = $("#exame_simples_coletivo").val();
                let exames_complexos_coletivo = $("#exames_complexos_coletivo").val();

                let linha1_coletivo = $("#linha1_coletivo").val();
                let linha2_coletivo = $("#linha2_coletivo").val();
                let linha3_coletivo = $("#linha3_coletivo").val();

                let terapias_coletivo = $("#terapias_coletivo").val();
                let terapias_individual = $("#terapias_individual").val();


                $.ajax({
                   url:"{{route('corretora.store.pdf')}}",
                   method:"POST",
                   data:{
                       consulta_eletivas_individual:consulta_eletivas_individual,
                       consulta_urgencia_individual:consulta_urgencia_individual,
                       exames_simples_individual:exames_simples_individual,
                       exames_complexos_individual:exames_complexos_individual,
                       terapias_coletivo:terapias_coletivo,
                       terapias_individual:terapias_individual,
                       linha1_individual:linha1_individual,
                       linha2_individual:linha2_individual,
                       linha3_individual:linha3_individual,
                       consulta_eletivas_coletivo:consulta_eletivas_coletivo,
                       consulta_urgencia_coletivo:consulta_urgencia_coletivo,
                       exame_simples_coletivo:exame_simples_coletivo,
                       exames_complexos_coletivo:exames_complexos_coletivo,
                       linha1_coletivo:linha1_coletivo,
                       linha2_coletivo:linha2_coletivo,
                       linha3_coletivo:linha3_coletivo
                   }
                });
                return false;
            });

            $(".salvar_hapvida").on('click',function(){
                let tipo = $("#tipo").val();
                let cidade = $("#cidade_comissao_corretor").val();
                let tipo_plano = $("#tipo_plano").val();
                let user = $("#user_id").val();


                let parcelas = [
                    $(".comissao_1_individual").val(),
                    $(".comissao_2_individual").val(),
                    $(".comissao_3_individual").val(),
                    $(".comissao_4_individual").val(),
                    $(".comissao_5_individual").val(),
                    $(".comissao_6_individual").val()
                ];
                $.ajax({
                   url:"{{route('corretora.cadastrar.planos.hap')}}",
                   method:"POST",
                   data: {
                       tipo,
                       cidade,
                       tipo_plano,
                       user,
                       parcelas
                   },
                    beforeSend:function() {
                        if($(".comissao_1_individual").val() == "") {
                            toastr["error"]("1º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($(".comissao_2_individual").val() == "") {
                            toastr["error"]("2º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($(".comissao_3_individual").val() == "") {
                            toastr["error"]("3º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($(".comissao_4_individual").val() == "") {
                            toastr["error"]("4º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($(".comissao_5_individual").val() == "") {
                            toastr["error"]("5º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($(".comissao_6_individual").val() == "") {
                            toastr["error"]("6º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }

                    },
                   success:function(res) {
                    if(res == "cadastrado") {
                           toastr["success"]("Dados inseridos com sucesso")
                           toastr.options = {
                               "closeButton": false,
                               "debug": false,
                               "newestOnTop": false,
                               "progressBar": false,
                               "positionClass": "toast-top-right",
                               "preventDuplicates": false,
                               "onclick": null,
                               "showDuration": "300",
                               "hideDuration": "1000",
                               "timeOut": "5000",
                               "extendedTimeOut": "1000",
                               "showEasing": "swing",
                               "hideEasing": "linear",
                               "showMethod": "fadeIn",
                               "hideMethod": "fadeOut"
                           }
                       } 
                   }
                });





            });






            $(".salvar_coletivo").on('click',function(){
                let tipo = $("#tipo").val();
                let cidade = $("#cidade_comissao_corretor").val();
                let plano = $("#plano").val();
                let administradora = $("#administradora").val();
                let user = $("#user_id").val();

                let comissao_1_parcela_coletivo = $(".comissao_1_parcela_coletivo").val();
                let comissao_2_parcela_coletivo = $(".comissao_2_parcela_coletivo").val();
                let comissao_3_parcela_coletivo = $(".comissao_3_parcela_coletivo").val();
                let comissao_4_parcela_coletivo = $(".comissao_4_parcela_coletivo").val();
                let comissao_5_parcela_coletivo = $(".comissao_5_parcela_coletivo").val();
                let comissao_6_parcela_coletivo = $(".comissao_6_parcela_coletivo").val();
                let comissao_7_parcela_coletivo = $(".comissao_7_parcela_coletivo").val();

                let parcelas = [
                    comissao_1_parcela_coletivo,
                    comissao_2_parcela_coletivo,
                    comissao_3_parcela_coletivo,
                    comissao_4_parcela_coletivo,
                    comissao_5_parcela_coletivo,
                    comissao_6_parcela_coletivo,
                    comissao_7_parcela_coletivo
                ];

                $.ajax({
                   url:"{{route('cadastrar.comissao.corretor.coletivo')}}",
                   method:"POST",
                   data: {
                       tipo,
                       cidade,
                       plano,
                       administradora,
                       parcelas,
                       user
                   },
                    beforeSend:function() {
                        if($(".comissao_1_parcela_coletivo").val() == "") {
                            toastr["error"]("1º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($(".comissao_2_parcela_coletivo").val() == "") {
                            toastr["error"]("2º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($(".comissao_3_parcela_coletivo").val() == "") {
                            toastr["error"]("3º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($(".comissao_4_parcela_coletivo").val() == "") {
                            toastr["error"]("4º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($(".comissao_5_parcela_coletivo").val() == "") {
                            toastr["error"]("5º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($(".comissao_6_parcela_coletivo").val() == "") {
                            toastr["error"]("6º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                        if($(".comissao_7_parcela_coletivo").val() == "") {
                            toastr["error"]("7º Parcela e campo obrigatório")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            return false;
                        }
                    },

                    success:function(res) {
                       
                       if(res == "cadastrado") {
                           toastr["success"]("Dados inseridos com sucesso")
                           toastr.options = {
                               "closeButton": false,
                               "debug": false,
                               "newestOnTop": false,
                               "progressBar": false,
                               "positionClass": "toast-top-right",
                               "preventDuplicates": false,
                               "onclick": null,
                               "showDuration": "300",
                               "hideDuration": "1000",
                               "timeOut": "5000",
                               "extendedTimeOut": "1000",
                               "showEasing": "swing",
                               "hideEasing": "linear",
                               "showMethod": "fadeIn",
                               "hideMethod": "fadeOut"
                           }



                       }
                    }
                });


            });


            $("#hapvida-options-comissions-planos .option").on('click',function(){
                let cidade = $("#cidade_comissao_corretor").val();
                let plano = $("#tipo_plano").val();
                let tipo = $("#tipo").val();


                if(tipo != 3) {

                    $.ajax({
                        url:"{{route('corretora.verificar.planos.hap')}}",
                        method:"POST",
                        data: {
                            cidade,
                            plano,
                            tipo

                        },
                        success:function(res) {

                            if(res != "") {
                                $(".comissao_1_individual").val(res[0].valor);
                                $(".comissao_2_individual").val(res[1].valor);
                                $(".comissao_3_individual").val(res[2].valor);
                                $(".comissao_4_individual").val(res[3].valor);
                                $(".comissao_5_individual").val(res[4].valor);
                                $(".comissao_6_individual").val(res[5].valor);
                            } else {
                                $(".comissao_1_individual").val('');
                                $(".comissao_2_individual").val('');
                                $(".comissao_3_individual").val('');
                                $(".comissao_4_individual").val('');
                                $(".comissao_5_individual").val('');
                                $(".comissao_6_individual").val('');
                            }
                        }
                    });
                } else {

                    if($("#user_id").val() != "") {
                        
                        $.ajax({
                        url:"{{route('corretora.verificar.planos.hap')}}",
                        method:"POST",
                        data: {
                            cidade,
                            plano,
                            tipo,
                            user_id:$("#user_id").val(),
                            administradora:$("#administradora").val()
                        },
                        success:function(res) {
                            
                            if(res != "") {
                                $(".comissao_1_individual").val(res[0].valor);
                                $(".comissao_2_individual").val(res[1].valor);
                                $(".comissao_3_individual").val(res[2].valor);
                                $(".comissao_4_individual").val(res[3].valor);
                                $(".comissao_5_individual").val(res[4].valor);
                                $(".comissao_6_individual").val(res[5].valor);
                            } else {
                                $(".comissao_1_individual").val('');
                                $(".comissao_2_individual").val('');
                                $(".comissao_3_individual").val('');
                                $(".comissao_4_individual").val('');
                                $(".comissao_5_individual").val('');
                                $(".comissao_6_individual").val('');
                            }
                        }
                    });





                    }




                }


                
            });




        });

    </script>

@stop
({
    className: 'depurar_leads',

    events: {
        'click #btn_Buscar': 'buscarLeads',
        'click .selected': 'seleccionarleads',
        'click #btn_STodo': 'seleccionarTodo',
        'click .btnEliminar': 'eliminarLeads',
    },

    initialize: function(options){
        this._super("initialize", [options]);
        this.leads = '';
        this.seleccionados = [];
        this.persistNoSeleccionados=[];
        this.flagSeleccionados=0;
        this.loadView = false;
        if(app.user.attributes.depurar_leads_c == 1){
          this.loadView = true;
          agentes = this;
          agentes.filtros = {
            "lead":"",
            "carga":"",
            "agente":"",
            "Total":"0"
          };
        }else{
            var route = app.router.buildRoute(this.module, null, '');
            app.router.navigate(route, {trigger: true});
        }
    },

    _render: function () {
        this._super("_render");
        $(".btnEliminar").addClass("hide");
    },

    eliminarLeads:function () {
        if(this.flagSeleccionados==1){
            this.seleccionados=this.full_leads;
        }
        var parametros = this.seleccionados;
        if(parametros != "") {
          var Params = {
            'seleccionados': parametros,
          };
          app.alert.show('eliminando', {
            level: 'process',
            title: 'Cargando...'
          });
          var dnbProfileUrl = app.api.buildURL("eliminarLeads", '', {}, {});
          app.api.call("create", dnbProfileUrl, {data: Params}, {
            success: _.bind(function (data) {
              app.alert.dismiss('eliminando');
              parametros = "";
              this.leads = [];
              this.seleccionados = [];
              this.full_leads = [];
              this.flagSeleccionados=0;
              this.model.set("assigned_user_id","");
              this.model.set("assigned_user_name","");
              this.render();
              agentes.listausuarios = [];
              agentes.filtros.Total = 0;
              agentes.render();
              $('#successful').show();
            }, this)
          });
        }else{
          var alertOptions = {
            title: "No hay Leads seleccionados para eliminar",
            level: "error"
          };
          app.alert.show('validation', alertOptions);
        }
    },

    seleccionarTodo: function(e){
        if(this.persistNoSeleccionados!=undefined && this.persistNoSeleccionados.length>0){
            for(var i=0;i<this.persistNoSeleccionados.length;i++){
                if(!this.full_leads.includes(this.persistNoSeleccionados[i])){
                    this.full_leads.push(this.persistNoSeleccionados[i])
                }
            }
            this.persistNoSeleccionados=[];
        }else{
            this.persistNoSeleccionados=[];
        }
        if(this.flagSeleccionados==0){
            this.flagSeleccionados=1;
        }else {
            this.flagSeleccionados=0;
        }
        var btnState = $(e.target).attr("btnState");
        if(btnState == "Off"){
            $(e.target).attr("btnState", "On");
            btnState='On';
        }else{
            $(e.target).attr("btnState", "Off");
            btnState='Off';
        }
        $('.selected').each(function (index, value) {
            if(btnState == "On"){
                $(value).prop('checked', true);
            }else{
                $(value).prop('checked', false);
            }
        });
        var seleccionarTodo = [];
        var crossSeleccionados = $("#crossSeleccionados").val();
        if(!_.isEmpty(crossSeleccionados)) {
            seleccionarTodo = JSON.parse(crossSeleccionados);
        }
        if($('.selected').prop("checked")) {
            $(this.leads).each(function (index, value) {
                seleccionarTodo.push(value.id);
            });
        }else{
            seleccionarTodo = [];
        }
        this.seleccionados = seleccionarTodo;
        $("#crossSeleccionados").val(JSON.stringify(this.seleccionados));
    },

    buscarLeads: function(){
        var agente = this.model.get('assigned_user_id');
        var lead = $('#filtroLead').val().trim();
        var carga = $('#filtroCarga').val().trim();
        if(lead!="" || carga !="" || (agente!=undefined && agente!=null && agente!="")) {
          $('#successful').hide();
          $('#processing').show();
          this.leads = [];
          this.seleccionados = [];
          this.full_leads = [];
          agentes.filtros = {
              "lead": lead,
              "carga": carga,
              "agente": agente
          };
          if(agente==""){
            agente=undefined;
          }
          agente += "&lead="+lead.toString()+"&carga="+carga.toString();
          app.api.call("read", app.api.buildURL("depurar_leads/" + agente, null, null, {}), null, {
            success: _.bind(function (data) {
              if(data.total <= 0) {
                  var alertOptions = {
                    title: "No se encontraron Leads sin llamadas y sin reuniones",
                    level: "error"
                  };
                  app.alert.show('validation', alertOptions);
                  agentes.listausuarios = [];
                  agentes.filtros.Total = 0;
                  agentes.render();
                  return;
              }
              else {
                  $('#processing').hide();
                  agentes.listausuarios = [];
                  agentes.listausuarios = typeof data=="string"?null:data.leads;
                  agentes.filtros.Total = data.total;
                  agentes.render();
                  this.full_leads = typeof data=="string"?null:data.full_leads;
              }
                $(".btnEliminar").removeClass("hide");
            }, this)
          });
        }else{
            app.alert.show("Campos faltantes para búsqueda", {
                level: "error",
                messages: 'Ingrese algún criterio de búsqueda',
                autoClose: false
            });
        }
    },

    seleccionarleads: function(e){
        var seleccionarTodo = [];
        var crossSeleccionados = $("#crossSeleccionados").val();
        if(!_.isEmpty(crossSeleccionados)) {
            seleccionarTodo = JSON.parse(crossSeleccionados);
        }
        if($(e.target).is(':checked')){
            seleccionarTodo.push($(e.target).val());
            this.seleccionados = seleccionarTodo;
        }else{
            var itemToRemove = $(e.target).val();
            var seleccionadosClone = seleccionarTodo;
            var seleccionadosCleaned = [];
            this.seleccionados = [];
            $(seleccionadosClone).each(function( index,value ) {
                if(value != itemToRemove){
                    seleccionadosCleaned.push(value);
                }
            });
            this.seleccionados = seleccionadosCleaned;
        }
        if(this.full_leads.length > 0 && this.full_leads != undefined){
            var idLead=$(e.target).val();
            if(this.full_leads.includes(idLead)){
                if($(e.target).prop("checked")==false){
                    var position=this.full_leads.indexOf(idLead)
                    this.full_leads.splice(position,1);
                    this.persistNoSeleccionados.push(idLead);
                }
            }else{
                if($(e.target).prop("checked")){
                    var position=this.full_leads.indexOf(idLead)
                    this.full_leads.splice(position,0,idLead);
                }
            }
        }
        $("#crossSeleccionados").val(JSON.stringify(this.seleccionados));
    },
})

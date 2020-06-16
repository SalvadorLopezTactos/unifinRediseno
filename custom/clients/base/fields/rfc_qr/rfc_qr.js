({
  className: 'rfc_qr',

  events: {
    'click #btn_Cancelar': 'cancelar',
    'click .btn_rfc_qr': 'btn_rfc_qr',
		'click #validar_QR': 'validarServicioQR',
		'click #activar_camara': 'activarCamara',
    'click #archivo_qr': 'cargarArchivo',
		'change #btnSubir': 'SubirImagen',		
  },

  initialize: function(options){
    this._super("initialize", [options]);
    self.body = null;
    self.picturecam = false;
    this.loadView = true;
    this.context.on('button:btn_rfc:click', this.btn_rfc_qr, this);

  },
	
	tieneSoporteUserMedia: function() {
		return !!(navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia);
	},
	
	getUserMedia: function() {
		return (navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia).apply(navigator, arguments);
	},
	
	SubirImagen:function () {
    subeImagen = this;
		var input = this.$('input[type=file]')[0]; //document.querySelector('input[type=file]');
		var file = input.files[0];
		var filePath = input.value;
		var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
		if(file=="" || file==undefined){
			app.alert.show('errorAlert', {
				level: 'error',
				messages: 'Favor de elegir un archivo',
				autoClose: true
			});
      subeImagen.$('#img')[0].src = ''; //document.getElementById("img").src = '';
		}else if(!allowedExtensions.exec(filePath)){
  		app.alert.show('errorAlert', {
				level: 'error',
				messages: 'Tipo de Archivo no compatible',
				autoClose: true
			});
      subeImagen.$('#img')[0].src = ''; //document.getElementById("img").src = '';
		}else{
			var FR= new FileReader();
			FR.addEventListener("load", function(e) {
  			subeImagen.$('#b64')[0].innerHTML = e.target.result; // document.getElementById("b64").innerHTML 
  			subeImagen.$('#img')[0].src = e.target.result; // document.getElementById("img").src       = e.target.result;
			});
			FR.readAsDataURL( input.files[0] );
			var elemento = subeImagen.$('#img')[0];// document.getElementById("img");
			elemento.style.display = 'block';
			var estado = subeImagen.$('#estado')[0]; //document.getElementById("estado");
		}
	},
	
	validarServicioQR:function () {
    validaServicio = this;
		var estado = this.$('#estado')[0]; //document.getElementById("estado");
		var input = this.$('input[type=file]')[0]; //document.querySelector('input[type=file]');
		var file = input.files[0];
		var c = document.createElement("canvas")
		var ctx = c.getContext('2d');
		var imgn = new Image;
		var imageData = '';
		if(self.picturecam == false){
			if(file=="" || file==undefined){
				app.alert.show('errorAlert', {
					level: 'error',
					messages: 'Favor de elegir un archivo ó tomar una foto',
					autoClose: true
				});
			}else{
				var FR= new FileReader();
				FR.readAsDataURL( input.files[0] );
				imgn.src = URL.createObjectURL(validaServicio.$('#btnSubir')[0].files[0]);
			}			
		}else{
			var elemento = validaServicio.$('#canvas')[0]; //document.getElementById("canvas");
			imgn.src = elemento.toDataURL();
		}
			
		imgn.onload = function(){
      app.alert.show('procesando', {
        level: 'process',
        title: 'Cargando...'
      });
      validaServicio.$("#activar_camara").attr("disabled", true); //$('#activar_camara').addClass('disabled');
      //$('#activar_camara').attr('style', 'pointer-events:none;');  
      validaServicio.$("#archivo_qr").attr("disabled", true); //$('#archivo_qr').addClass('disabled');
      //$('#archivo_qr').attr('style', 'pointer-events:none;');  
      validaServicio.$("#btnSubir").attr("disabled", true); //$('#btnSubir').addClass('disabled');
      //$('#btnSubir').attr('style', 'pointer-events:none;margin:10px');
      validaServicio.$("#validar_QR").attr("disabled", true); //$('#validar_QR').addClass('disabled');
      validaServicio.$('#validar_QR').attr('style', 'pointer-events:none;margin:5px');
      validaServicio.$("#btn_Cancelar").attr("disabled", true); //$('#btn_Cancelar').addClass('disabled');
      validaServicio.$('#btn_Cancelar').attr('style', 'pointer-events:none;margin:5px');    
			c.width = imgn.width;
			c.height = imgn.height;
			ctx.drawImage(imgn,0,0)
			var imageData = c.toDataURL('image/png');
			var body = {
				"file" : imageData
			}
			app.api.call('create', app.api.buildURL("GetInfoRFCbyQR"), body , {
				success: _.bind(function (data) {
          var Error = '';
          if(data) {
            Error = data[0]["Mensaje de error"];
            if (Error) {
              Error = 'Error con QR - ' + data[0]["Estatus de URL"] + ' - ' + data[0]["Mensaje de error"];
            }
          }
          else {
            Error = "Servicio no disponible. Por favor, intente más tarde.";
          }
          if(Error) {
            app.alert.dismiss('procesando');
            app.alert.show('error', {
              level: 'error',
              messages: Error,
            });
            validaServicio.$("#activar_camara").attr("disabled", false); //$('#activar_camara').removeClass('disabled');
            //$('#activar_camara').attr('style', '');
            validaServicio.$("#archivo_qr").attr("disabled", false); //$('#archivo_qr').removeClass('disabled');
            //$('#archivo_qr').attr('style', '');
            validaServicio.$("#btnSubir").attr("disabled", false); //$('#btnSubir').removeClass('disabled');
            //$('#btnSubir').attr('style', 'margin:10px');
            validaServicio.$("#validar_QR").attr("disabled", false); //$('#validar_QR').removeClass('disabled');
            validaServicio.$('#validar_QR').attr('style', 'margin:5px');
            validaServicio.$("#btn_Cancelar").attr("disabled", false); //$('#btn_Cancelar').removeClass('disabled');
            validaServicio.$('#btn_Cancelar').attr('style', 'margin:5px');
          }
          else {
            var Completo = '';
            var RFC = data[0]["RFC"];
            var Correo = data[0]["Correo electrónico"];
            var CP = data[0]["CP"];
            var Calle = data[0]["Nombre de la vialidad"];
            var Exterior = data[0]["Número exterior"];
            var Interior = data[0]["Número interior"];
            var Colonia = data[0]["Colonia"];
            var Municipio = data[0]["Municipio o delegación"];
            var Estado = data[0]["Entidad Federativa"];
            var Regimen = data[0]["Régimen"];
            var Pais = "MEXICO";
            if(RFC.length == 12) Regimen = "Persona Moral";
            if(Regimen == "Régimen de las Personas Físicas con Actividades Empresariales y Profesionales") Regimen = "Persona Fisica con Actividad Empresarial";
            if(Regimen != "Persona Fisica con Actividad Empresarial" && RFC.length == 13) Regimen = "Persona Fisica";
            if(Estado == "MEXICO") Estado = "ESTADO DE MEXICO";
            if(Regimen == "Persona Moral") {
              var Denominacion = data[0]["Denominación o Razón Social"];
              var Constitucion = data[0]["Fecha de constitución"];
              Completo = Denominacion;
              Constitucion = Constitucion.substring(6, 10) + "-" + Constitucion.substring(3, 5) + "-" + Constitucion.substring(0, 2);
            }
            else {
              var Nombre = data[0]["Nombre"];
              var Paterno = data[0]["Apellido Paterno"];
              var Materno = data[0]["Apellido Materno"];
              var CURP = data[0]["CURP"];
              var Nacimiento = data[0]["Fecha Nacimiento"];
              Completo = Nombre + " " + Paterno + " " + Materno;
              Nacimiento = Nacimiento.substring(6, 10) + "-" + Nacimiento.substring(3, 5) + "-" + Nacimiento.substring(0, 2);
            }
            app.api.call("read", app.api.buildURL("Accounts/", null, null, {
              max_num: 5,
              "filter": [{
                "rfc_c": RFC,
              }]
            }), null, {
              success: _.bind(function (data) {
                if(data.records.length > 0 && self.model.get('id') != data.records[0].id) {
                  app.alert.dismiss('procesando');
                  app.alert.show('errorAlert', {
                    level: 'error',
                    messages: "Ya existe la cuenta "+data.records[0].name,
                  });
                  validaServicio.$("#activar_camara").attr("disabled", false); //$('#activar_camara').removeClass('disabled');
                  //$('#activar_camara').attr('style', '');
                  validaServicio.$("#archivo_qr").attr("disabled", false); //$('#archivo_qr').removeClass('disabled');
                  //$('#archivo_qr').attr('style', '');
                  validaServicio.$("#btnSubir").attr("disabled", false); //$('#btnSubir').removeClass('disabled');
                  //$('#btnSubir').attr('style', 'margin:10px');
                  validaServicio.$("#validar_QR").attr("disabled", false); //$('#validar_QR').removeClass('disabled');
                  validaServicio.$('#validar_QR').attr('style', 'margin:5px');
                  validaServicio.$("#btn_Cancelar").attr("disabled", false); //$('#btn_Cancelar').removeClass('disabled');
                  validaServicio.$('#btn_Cancelar').attr('style', 'margin:5px');
                }
                else {
                  app.alert.show('errorAlert2', {
                    level: 'confirmation',
                    messages: "La información recuperada con el QR proporcionado corresponde a: "+Completo+" ¿Desea proceder con estos datos?",
                    autoClose: false,
                    onCancel: function(){
                      validaServicio.$("#activar_camara").attr("disabled", false); //$('#activar_camara').removeClass('disabled');
                      //$('#activar_camara').attr('style', '');
                      validaServicio.$("#archivo_qr").attr("disabled", false); //$('#archivo_qr').removeClass('disabled');
                      //$('#archivo_qr').attr('style', '');
                      validaServicio.$("#btnSubir").attr("disabled", false); //$('#btnSubir').removeClass('disabled');
                      //$('#btnSubir').attr('style', 'margin:10px');
                      validaServicio.$("#validar_QR").attr("disabled", false); //$('#validar_QR').removeClass('disabled');
                      validaServicio.$('#validar_QR').attr('style', 'margin:5px');
                      validaServicio.$("#btn_Cancelar").attr("disabled", false); //$('#btn_Cancelar').removeClass('disabled');
                      validaServicio.$('#btn_Cancelar').attr('style', 'margin:5px');
                    },
                    onConfirm: function() {
                      // Actualiza Datos Personales
                      App.alert.show('set_data', {
                        level: 'process',
                        title: 'Cargando...'
                      });
                      self = validaServicio;
                      self.model.set('tipodepersona_c', Regimen);
                      if(!self.model.get('rfc_c')) self.model.set('rfc_c', RFC);
                      if(Regimen == "Persona Moral") {
                        if(!self.model.get('razonsocial_c')) self.model.set('razonsocial_c', Denominacion);
                        if(!self.model.get('nombre_comercial_c')) self.model.set('nombre_comercial_c', Denominacion);
                        if(!self.model.get('fechaconstitutiva_c')) self.model.set('fechaconstitutiva_c', Constitucion);
                      }
                      else {
                        if(!self.model.get('primernombre_c')) self.model.set('primernombre_c', Nombre);
                        if(!self.model.get('apellidopaterno_c')) self.model.set('apellidopaterno_c', Paterno);
                        if(!self.model.get('apellidomaterno_c')) self.model.set('apellidomaterno_c', Materno);
                        if(!self.model.get('fechadenacimiento_c')) self.model.set('fechadenacimiento_c', Nacimiento);
                        if(!self.model.get('curp_c')) self.model.set('curp_c', CURP);
                      }
                      if(!self.model.get('email1')) {
                        self.model.set('email1', Correo);
                        self.model.set('email', [{email_address: Correo, primary_address: true}]);
                        self.render();
                      }
                      // Valida duplicado
                      cont_dir.oDirecciones = contexto_cuenta.oDirecciones;
                      var duplicado = 0;
                      var cDuplicado = 0;            
                      var cDireccionFiscal = 0;
                      var direccion = cont_dir.oDirecciones.direccion;
                      Object.keys(direccion).forEach(key => {
                        duplicado = 0;
                        duplicado = (direccion[key].valCodigoPostal == CP) ? duplicado+1 : duplicado;
                        duplicado = (direccion[key].listPais[direccion[key].pais] == Pais) ? duplicado+1 : duplicado;
                        duplicado = (direccion[key].listEstado[direccion[key].estado] == Estado) ? duplicado+1 : duplicado;
                        duplicado = (direccion[key].listMunicipio[direccion[key].municipio] == Municipio) ? duplicado+1 : duplicado;
                        duplicado = (direccion[key].listColonia[direccion[key].colonia] == Colonia) ? duplicado+1 : duplicado;
                        duplicado = (direccion[key].calle.trim().toLowerCase() == Calle.trim().toLowerCase()) ? duplicado+1 : duplicado;
                        duplicado = (direccion[key].numext.trim().toLowerCase() == Exterior.trim().toLowerCase()) ? duplicado+1 : duplicado;
                        duplicado = (direccion[key].inactivo == 0) ? duplicado+1 : duplicado;
                     	  if(direccion[key].indicadorSeleccionados.includes('2') && direccion[key].inactivo == 0) cDireccionFiscal = cDireccionFiscal + 1;
                        if(duplicado == 8 && cDireccionFiscal == 0) {
                          // Indicador
                          direccion[key].indicadorSeleccionados = direccion[key].indicadorSeleccionados + ',^2^';
                          var indicador = direccion[key].indicadorSeleccionados;
                          var dir_indicador_map_list = app.lang.getAppListStrings('dir_indicador_map_list');
                          indicador = indicador.substring(1,indicador.length-1);
                          indicador = indicador.split('^,^');
                          indicador.sort();
                          for (var key1 in dir_indicador_map_list) {
                              var value = app.lang.getAppListStrings('dir_indicador_map_list')[key1];
                              if (value == indicador) direccion[key].indicador = key1;
                          }
                          cont_dir.oDirecciones.direccion = direccion;
                          cont_dir.render();
                          cDuplicado++;
                          validaServicio.$("#activar_camara").attr("disabled", false); //$('#activar_camara').removeClass('disabled');
                          //$('#activar_camara').attr('style', '');
                          validaServicio.$("#archivo_qr").attr("disabled", false); //$('#archivo_qr').removeClass('disabled');
                          //$('#archivo_qr').attr('style', '');
                          validaServicio.$("#btnSubir").attr("disabled", false); //$('#btnSubir').removeClass('disabled');
                          //$('#btnSubir').attr('style', 'margin:10px');
                          validaServicio.$("#validar_QR").attr("disabled", false); //$('#validar_QR').removeClass('disabled');
                          validaServicio.$('#validar_QR').attr('style', 'margin:5px');
                          validaServicio.$("#btn_Cancelar").attr("disabled", false); //$('#btn_Cancelar').removeClass('disabled');
                          validaServicio.$('#btn_Cancelar').attr('style', 'margin:5px');
                          //App.alert.dismiss('set_data');
                        }
                      });
                      if(cDireccionFiscal >= 1) {
                        app.alert.dismiss('precesando');
                        app.alert.show('multiple_fiscal', {
                          level: 'error',
                          messages: 'No se pueden agregar múltiples direcciones fiscales, favor de validar.'
                        });
                        validaServicio.$("#activar_camara").attr("disabled", false); //$('#activar_camara').removeClass('disabled');
                        //$('#activar_camara').attr('style', '');
                        validaServicio.$("#archivo_qr").attr("disabled", false); //$('#archivo_qr').removeClass('disabled');
                        //$('#archivo_qr').attr('style', '');
                        validaServicio.$("#btnSubir").attr("disabled", false); //$('#btnSubir').removeClass('disabled');
                        //$('#btnSubir').attr('style', 'margin:10px');
                        validaServicio.$("#validar_QR").attr("disabled", false); //$('#validar_QR').removeClass('disabled');
                        validaServicio.$('#validar_QR').attr('style', 'margin:5px');
                        validaServicio.$("#btn_Cancelar").attr("disabled", false); //$('#btn_Cancelar').removeClass('disabled');
                        validaServicio.$('#btn_Cancelar').attr('style', 'margin:5px');
                        cont_dir.render();
                        App.alert.dismiss('set_data');
                        
                      }
                      else {
                        if(cDuplicado == 0) {
                          // Agrega Dirección
                          var strUrl = 'DireccionesCP/' + CP + '/0';
                          app.api.call('GET', app.api.buildURL(strUrl), null, {
                            success: _.bind(function (data) {
                              if(data.idCP) {
                                var nuevaDireccion = {
                                    "tipodedireccion":"",
                                    "listTipo":App.lang.getAppListStrings('dir_tipo_unique_list'),
                                    "tipoSeleccionados":"",
                                    "indicador":"",
                                    "listIndicador":App.lang.getAppListStrings('dir_indicador_unique_list'),
                                    "indicadorSeleccionados":"",
                                    "valCodigoPostal":"",
                                    "postal":"",
                                    "valPais":"",
                                    "pais":"",
                                    "listPais":{},
                                    "listPaisFull":{},
                                    "valEstado":"",
                                    "estado":"",
                                    "listEstado":{},
                                    "listEstadoFull":{},
                                    "valMunicipio":"",
                                    "municipio":"",
                                    "listMunicipio":{},
                                    "listMunicipioFull":{},
                                    "valCiudad":"",
                                    "ciudad":"",
                                    "listCiudad":{},
                                    "listCiudadFull":{},
                                    "valColonia":"",
                                    "colonia":"",
                                    "listColonia":{},
                                    "listColoniaFull":{},
                                    "calle":"",
                                    "numext":"",
                                    "numint":"",
                                    "principal":"",
                                    "inactivo":"",
                                    "secuencia":"",
                                    "id":"",
                                    "direccionCompleta":""
                                };
                                nuevaDireccion.secuencia = "1";
                                nuevaDireccion.principal = "1";
                                nuevaDireccion.tipodedireccion = "1";
                                nuevaDireccion.tipoSeleccionados = '^1^';
                                nuevaDireccion.indicador = "2";
                                nuevaDireccion.indicadorSeleccionados = '^2^';
                                nuevaDireccion.valCodigoPostal = CP;
                                nuevaDireccion.postal = data.idCP;
                                nuevaDireccion.calle = Calle;
                                nuevaDireccion.numext = Exterior;
                                nuevaDireccion.numint = Interior;
                                var list_paises = data.paises;
                                var list_municipios = data.municipios;
                                var city_list = App.metadata.getCities();
                                var list_estados = data.estados;
                                var list_colonias = data.colonias;
                                //País
                                var listPais = {};
                                for (var i = 0; i < list_paises.length; i++) {
                                  listPais[list_paises[i].idPais] = list_paises[i].namePais;
                                  nuevaDireccion.pais = list_paises[i].idPais;
                                }
                                nuevaDireccion.listPais = listPais;
                                nuevaDireccion.listPaisFull = listPais;
                                //Estado
                                var listEstado = {};
                                for (var i = 0; i < list_estados.length; i++) {
                                  listEstado[list_estados[i].idEstado] = list_estados[i].nameEstado;
                                  nuevaDireccion.estado = list_estados[i].idEstado;
                                }
                                nuevaDireccion.listEstado = listEstado;
                                nuevaDireccion.listEstadoFull = listEstado;
                                //Municipio
                                var listMunicipio = {};
                                for (var i = 0; i < list_municipios.length; i++) {
                                  listMunicipio[list_municipios[i].idMunicipio] = list_municipios[i].nameMunicipio;
                                  if(list_municipios[i].nameMunicipio == Municipio) nuevaDireccion.municipio = list_municipios[i].idMunicipio;
                                }
                                nuevaDireccion.listMunicipio = listMunicipio;
                                nuevaDireccion.listMunicipioFull = listMunicipio;
                                //Colonia
                                var listColonia = {};
                                for (var i = 0; i < list_colonias.length; i++) {
                                  listColonia[list_colonias[i].idColonia] = list_colonias[i].nameColonia;
                                  if(list_colonias[i].nameColonia == Colonia) nuevaDireccion.colonia = list_colonias[i].idColonia;
                                }
                                nuevaDireccion.listColonia = listColonia;
                                nuevaDireccion.listColoniaFull = listColonia;
                                //Ciudad
                                var listCiudad = {};
                                var ciudades = Object.values(city_list);
                                nuevaDireccion.estado = (Object.keys(nuevaDireccion.listEstado)[0] != undefined) ? Object.keys(nuevaDireccion.listEstado)[0] : "";
                                for (var [key, value] of Object.entries(nuevaDireccion.listEstado)) {
                                  for (var i = 0; i < ciudades.length; i++) {
                                    if (ciudades[i].estado_id == key) {
                                      listCiudad[ciudades[i].id] = ciudades[i].name;
                                      if(ciudades[i].name == Municipio) nuevaDireccion.ciudad = ciudades[i].id;
                                    }
                                  }
                                }
                                nuevaDireccion.listCiudad = listCiudad;
                                nuevaDireccion.listCiudadFull = listCiudad;
                                cont_dir.oDirecciones.direccion.push(nuevaDireccion);
                                
                                validaServicio.$("#activar_camara").attr("disabled", false); //$('#activar_camara').removeClass('disabled');
                                //$('#activar_camara').attr('style', '');
                                validaServicio.$("#archivo_qr").attr("disabled", false); //$('#archivo_qr').removeClass('disabled');
                                //$('#archivo_qr').attr('style', '');
                                validaServicio.$("#btnSubir").attr("disabled", false); //$('#btnSubir').removeClass('disabled');
                                //$('#btnSubir').attr('style', 'margin:10px');
                                validaServicio.$("#validar_QR").attr("disabled", false); //$('#validar_QR').removeClass('disabled');
                                validaServicio.$('#validar_QR').attr('style', 'margin:5px');
                                validaServicio.$("#btn_Cancelar").attr("disabled", false); //$('#btn_Cancelar').removeClass('disabled');
                                validaServicio.$('#btn_Cancelar').attr('style', 'margin:5px');
                                cont_dir.render();
                                App.alert.dismiss('set_data');
                                App.alert.dismiss('precesando');
                                validaServicio.$('#rfcModal').hide();
                              } else {
                                validaServicio.$('#rfcModal').hide();
                                App.alert.dismiss('set_data');
                                App.alert.dismiss('precesando');
                                App.alert.show('cp_not_found', {
                                  level: 'error',
                                  messages: 'C\u00F3digo Postal no encontrado'
                                });
                                validaServicio.$("#activar_camara").attr("disabled", false); //$('#activar_camara').removeClass('disabled');
                                //$('#activar_camara').attr('style', '');
                                validaServicio.$("#archivo_qr").attr("disabled", false); //$('#archivo_qr').removeClass('disabled');
                                //$('#archivo_qr').attr('style', '');
                                validaServicio.$("#btnSubir").attr("disabled", false); //$('#btnSubir').removeClass('disabled');
                                //$('#btnSubir').attr('style', 'margin:10px');
                                validaServicio.$("#validar_QR").attr("disabled", false); //$('#validar_QR').removeClass('disabled');
                                validaServicio.$('#validar_QR').attr('style', 'margin:5px');
                                validaServicio.$("#btn_Cancelar").attr("disabled", false); //$('#btn_Cancelar').removeClass('disabled');
                                validaServicio.$('#btn_Cancelar').attr('style', 'margin:5px');                               
                              }
                            })
                          });
                        }
                      }
                    }
                  });
                }
              })
            });
          }
				}),
			});
		}
	},
	
  activarCamara: function(){
		var elemento = null;
		var video = this.$('#video')[0]; //document.getElementById("video"),
			canvas = this.$('#canvas')[0]; //document.getElementById("canvas"),
			snap = this.$('#snap')[0]; //document.getElementById("snap"),
			estado = this.$('#estado')[0]; //document.getElementById("estado");		
		if(this.$('#activar_camara')[0].checked == true){
			this.fileupload = false;
			elemento = this.$('#div_video')[0]; //document.getElementById("div_video");
			elemento.style.display = 'block';
			elemento = this.$('#carga')[0]; //document.getElementById("carga");
			elemento.style.display = 'none';
			elemento = this.$('#btnSubir')[0]; //document.getElementById("btnSubir");
			elemento.value = '';
			elemento = this.$('#b64')[0]; //document.getElementById("b64");
			elemento.value = "";
			elemento = this.$('#img')[0]; //document.getElementById("img");
			elemento.src = "";
			elemento.style.display = 'none';
			if (this.tieneSoporteUserMedia()) {
				this.getUserMedia(
					{video: true, width: 400, height: 200},
					function (stream) {
						console.log("Permiso concedido");
						video.srcObject = stream;
						video.play();
						//Escuchar el click
						snap.addEventListener("click", function(){
							video.pause();
							//Obtener contexto del canvas y dibujar sobre él
							var contexto = canvas.getContext("2d");
							canvas.width = video.width;
							canvas.height = video.height;
							contexto.drawImage(video, 0, 0, 280, 200);
							var foto = canvas.toDataURL(); //Esta es la foto, en base 64
							//estado.innerHTML = "Foto tomada con exito...";
							canvas.style.display = 'block';
							var body = {
								"file" : foto
							}
							self.picturecam = true;							
							video.play();
						});
					 }, function (error) {
						//console.log("Permiso denegado o error: ", error);
						//this.estado.innerHTML = "No se puede acceder a la cámara o no diste permiso.";
            App.alert.show('no_camara', {
              level: 'error',
              messages: 'No se puede acceder a la cámara o no ha dado permiso.',
              autoClose: true
            });
					});
			} else {
				//alert("Lo siento. Tu navegador no soporta esta característica");
				//this.estado.innerHTML = "Parece que tu navegador no soporta esta característica. Intenta actualizarlo.";
        App.alert.show('no_support', {
          level: 'error',
          messages: 'Parece que tu navegador no soporta esta característica. Intenta actualizarlo.',
          autoClose: true
        });
			}
		}else{
			this.picturecam = false;
			this.body = null;
			var sprite = new Image();
			var contexto = canvas.getContext("2d");
			contexto.drawImage(sprite, 0, 0);
			//var estado = this.$('#estado')[0]; //document.getElementById("estado");
			//estado.innerHTML = "";
			elemento = this.$('#carga')[0]; //document.getElementById("carga");
			elemento.style.display = 'block';
			elemento = document.getElementById("div_video");
			elemento.style.display = 'none';
			canvas.style.display = 'none';
			video.pause();
			{video:false}
		}
  },

  cargarArchivo: function() {
      elemento = this.$('#carga')[0];
			elemento.style.display = 'block';
			elemento = this.$('#div_video')[0]; //document.getElementById("div_video");
			elemento.style.display = 'none';
  },
  
  btn_rfc_qr: function() {
    var modalrfc = this.$('#rfcModal');
    modalrfc.show();
  },

  cancelar: function() {
    var modalrfc = this.$('#rfcModal');
    modalrfc.hide();
  },
})
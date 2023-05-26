({
  className: 'rfc_qr',

  events: {
    'click #btn_Cancelar': 'cancelar',
    'click .btn_rfc_qr': 'btn_rfc_qr',
		'click #validar_QR': 'validarServicioQR',
		'click #activar_camara': 'activarCamara',
    'click #archivo_qr': 'cargarArchivo',
		'change #btnSubir': 'SubirImagen',
    'click .closeModalRazonSocial': 'closeModalRazonSocial',
    'click .action1': 'modalAction1',
    'click .action2': 'modalAction2',
    'click .action3': 'modalAction3',
  },

  initialize: function(options){
    this._super("initialize", [options]);
    self.body = null;
    self.picturecam = false;
    this.loadView = true;
    this.context.on('button:btn_rfc:click', this.btn_rfc_qr, this);
    cont_qr =this;
    cambioRazonSocial = [];
    infoUser = [];
    this.getUserInfo();
  },

  render: function () {
    this._super("render");
  	$("div.record-label[data-name='rfc_qr']").attr('style', 'pointer-events:none;');
  	$("div.record-label[data-name='rfc_qr']").attr('style', 'display:none;');
  },

	tieneSoporteUserMedia: function() {
		return !!(navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia);
	},

	getUserMedia: function() {
		return (navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia).apply(navigator, arguments);
	},

	SubirImagen:function () {
		var input = contexto_cuenta.$('input[type=file]');
		var file = input[0].files[0];
		var filePath = input[0].value;
		var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
		if(file=="" || file==undefined){
			app.alert.show('errorAlert', {
				level: 'error',
				messages: 'Favor de elegir un archivo',
				autoClose: true
			});
      contexto_cuenta.$('#img').src = '';
		}else if(!allowedExtensions.exec(filePath)){
  		app.alert.show('errorAlert', {
				level: 'error',
				messages: 'Tipo de Archivo no compatible',
				autoClose: true
			});
      contexto_cuenta.$('#img').src = '';
		}else{
			var FR = new FileReader();
			FR.addEventListener("load", function(e) {
        window.result = e.target.result;
			});
      setTimeout(function(){
        contexto_cuenta.$('#img').src = window.result;
        contexto_cuenta.$('#img').attr("src",window.result);
        contexto_cuenta.$('#img').show();
      }, 100);
			FR.readAsDataURL(input[0].files[0]);
		}
	},


  activarCamara: function(){
    this.$('#carga').hide();
    this.$('#div_video').show();
		var elemento = null;
		var video = this.$('#video')[0];
			canvas = this.$('#canvas')[0];
			snap = this.$('#snap')[0];
			estado = this.$('#estado')[0];
		if(this.$('#activar_camara')[0].checked == true){
			this.fileupload = false;
			elemento = this.$('#div_video')[0];
			elemento.style.display = 'block';
			elemento = this.$('#carga')[0];
			elemento.style.display = 'none';
			elemento = this.$('#btnSubir')[0];
			elemento.value = '';
			elemento = this.$('#b64')[0];
			elemento.value = "";
			elemento = this.$('#img')[0];
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
            App.alert.show('no_camara', {
              level: 'error',
              messages: 'No se puede acceder a la cámara o no ha dado permiso.',
              autoClose: true
            });
					});
			} else {
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
			elemento = this.$('#carga')[0];
			elemento.style.display = 'block';
			elemento = document.getElementById("div_video");
			elemento.style.display = 'none';
			canvas.style.display = 'none';
			video.pause();
			{video:false}
		}
  },


	validarServicioQR:function () {
		var contextol = this;
		var input = contexto_cuenta.$('input[type=file]');
		var file = input[0].files[0];
		var c = document.createElement("canvas");
		var ctx = c.getContext('2d');
		var imgn = new Image;
		var imageData = '';
    if(contexto_cuenta.model.attributes.valid_cambio_razon_social_c){
      app.alert.show('errorAlertCambio', {
        level: 'error',
        messages: 'Está cuenta se encuentra en validación de cambios y no puede ser modificada por QR',
        autoClose: true
      });
      return;
    }
		if(contexto_cuenta.picturecam == false){
			if(file=="" || file==undefined){
				app.alert.show('errorAlert', {
					level: 'error',
					messages: 'Favor de elegir un archivo ó tomar una foto',
					autoClose: true
				});
			}else{
				var FR= new FileReader();
				FR.readAsDataURL( input[0].files[0] );
				imgn.src = URL.createObjectURL(contexto_cuenta.$('#btnSubir')[0].files[0]);
			}
		}else{
			var elemento = this.$('#canvas')[0];
			imgn.src = elemento.toDataURL();
		}

		imgn.onload = function(){
			app.alert.show('procesando', {
			level: 'process',
			title: 'Cargando...'
			});
			contexto_cuenta.$('#activar_camara').addClass('disabled');
			contexto_cuenta.$('#activar_camara').attr('style', 'pointer-events:none;');
			contexto_cuenta.$('#archivo_qr').addClass('disabled');
			contexto_cuenta.$('#archivo_qr').attr('style', 'pointer-events:none;');
			contexto_cuenta.$('#btnSubir').addClass('disabled');
			contexto_cuenta.$('#btnSubir').attr('style', 'pointer-events:none;margin:10px');
			contexto_cuenta.$('#validar_QR').addClass('disabled');
			contexto_cuenta.$('#validar_QR').attr('style', 'pointer-events:none;margin:10px');
			contexto_cuenta.$('#btn_Cancelar').addClass('disabled');
			contexto_cuenta.$('#btn_Cancelar').attr('style', 'pointer-events:none;margin:10px');
			var vid = contexto_cuenta.$('#video');
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
					}else {
						Error = "Servicio no disponible. Por favor, intente más tarde.";
					}
					if(Error) {
						app.alert.dismiss('procesando');
						app.alert.show('error', {
							level: 'error',
							messages: Error,
						});
						contexto_cuenta.$('#activar_camara').removeClass('disabled');
						contexto_cuenta.$('#activar_camara').attr('style', '');
						contexto_cuenta.$('#archivo_qr').removeClass('disabled');
						contexto_cuenta.$('#archivo_qr').attr('style', '');
						contexto_cuenta.$('#btnSubir').removeClass('disabled');
						contexto_cuenta.$('#btnSubir').attr('style', 'margin:10px');
						contexto_cuenta.$('#validar_QR').removeClass('disabled');
						contexto_cuenta.$('#validar_QR').attr('style', 'margin:10px');
						contexto_cuenta.$('#btn_Cancelar').removeClass('disabled');
						contexto_cuenta.$('#btn_Cancelar').attr('style', 'margin:10px');
					}else {
						var indice_indicador = 0;
						var Completo = '';
/*						data = [];
						data.push({
						  "AL": "CIUDAD DE MEXICO 1",
						  "CP": "05129",
						  "Colonia": "LOMAS DEL CHAMIZAL",
						  "Correo electrónico": "albertotame@gmail.com",
						  "Denominación o Razón Social": "DEPORTE MOTOR BTL",
						  "Entidad Federativa": "CIUDAD DE MEXICO",
						  "Fecha de Inicio de operaciones": "12-01-2011",
						  "Fecha de alta": "12-01-2011",
						  "Fecha de constitución": "12-01-2011",
						  "Fecha del último cambio de situación": "12-01-2011",
						  "Municipio o delegación": "CUAJIMALPA DE MORELOS",
						  "Nombre de la vialidad": "RETORNO ADIM",
						  "Número exterior": "6",
						  "Número interior": "DEPTO. 101",
						  "RFC": "DMB1101126Q3",
						  "Régimen": "Régimen General de Ley Personas Morales",
						  "Régimen de capital": "SA DE CV",
						  "Situación del contribuyente": "ACTIVO",
						  "Tipo de vialidad": "CERRADA (CDA) O PRIVADA (PRIV)",
						  "id": "custom_qr_QR_RFC_5fe10d78040f3",
						  "path_img_qr": "custom/qr/QR_RFC_5fe10d78040f3.png"
						});*/
						var RFC = data[0]["RFC"].toUpperCase();
						var PathQR=data[0]["path_img_qr"];
						var Correo = data[0]["Correo electrónico"];
						var CP = data[0]["CP"];
						var Calle = data[0]["Nombre de la vialidad"].toUpperCase();
						var Exterior = data[0]["Número exterior"].toUpperCase();
						var Interior = data[0]["Número interior"].toUpperCase();
						var Colonia = data[0]["Colonia"];
						var Municipio = data[0]["Municipio o delegación"];
						var Estado = data[0]["Entidad Federativa"];
						var Regimen = data[0]["Régimen"];
						var Pais = "MEXICO";
						if(RFC != undefined){
							if(RFC.length == 12) Regimen = "Persona Moral";
              if(Regimen == "Régimen de las Personas Físicas con Actividades Empresariales y Profesionales") Regimen = "Persona Fisica con Actividad Empresarial";
							if(Regimen != "Persona Fisica con Actividad Empresarial" && RFC.length == 13) Regimen = "Persona Fisica";
						}
						if(Estado == "MEXICO") Estado = "ESTADO DE MEXICO";
						if(Regimen == "Persona Moral") {
							var Denominacion = data[0]["Denominación o Razón Social"]+" "+data[0]["Régimen de capital"];
							var Constitucion = data[0]["Fecha de constitución"];
							Completo = Denominacion;
							Constitucion = Constitucion.substring(6, 10) + "-" + Constitucion.substring(3, 5) + "-" + Constitucion.substring(0, 2);
						}else {
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
								if(data.records.length > 0 && contexto_cuenta.model.get('id') != data.records[0].id) {
									app.alert.dismiss('procesando');
									app.alert.show('errorAlert', {
										level: 'error',
										messages: "Ya existe la cuenta "+data.records[0].name,
									});
									contexto_cuenta.$('#activar_camara').removeClass('disabled');
									contexto_cuenta.$('#activar_camara').attr('style', '');
									contexto_cuenta.$('#archivo_qr').removeClass('disabled');
									contexto_cuenta.$('#archivo_qr').attr('style', '');
									contexto_cuenta.$('#btnSubir').removeClass('disabled');
									contexto_cuenta.$('#btnSubir').attr('style', 'margin:10px');
									contexto_cuenta.$('#validar_QR').removeClass('disabled');
									contexto_cuenta.$('#validar_QR').attr('style', 'margin:10px');
									contexto_cuenta.$('#btn_Cancelar').removeClass('disabled');
									contexto_cuenta.$('#btn_Cancelar').attr('style', 'margin:10px');
								}else {
									// Valida Regimen
									var verdad = false;
									if(Regimen != contexto_cuenta.model.get('tipodepersona_c') && contexto_cuenta.model.get('id')) {
										if(!Regimen.includes("Persona Fisica") || !contexto_cuenta.model.get('tipodepersona_c').includes("Persona Fisica")) verdad = true;
									}
									if(verdad) {
										app.alert.dismiss('procesando');
										app.alert.show('errorRegimen', {
											level: 'error',
											messages: "El Regimen encontrado con el QR es diferente al de la cuenta",
										});
										contexto_cuenta.$('#activar_camara').removeClass('disabled');
										contexto_cuenta.$('#activar_camara').attr('style', '');
										contexto_cuenta.$('#archivo_qr').removeClass('disabled');
										contexto_cuenta.$('#archivo_qr').attr('style', '');
										contexto_cuenta.$('#btnSubir').removeClass('disabled');
										contexto_cuenta.$('#btnSubir').attr('style', 'margin:10px');
										contexto_cuenta.$('#validar_QR').removeClass('disabled');
										contexto_cuenta.$('#validar_QR').attr('style', 'margin:10px');
										contexto_cuenta.$('#btn_Cancelar').removeClass('disabled');
										contexto_cuenta.$('#btn_Cancelar').attr('style', 'margin:10px');
									}else {
										app.alert.show('errorAlert2', {
											level:
											'confirmation',
											messages: "La información recuperada con el QR proporcionado corresponde a: "+Completo+" ¿Desea proceder con estos datos?",
											autoClose: false,
											onCancel: function(){
												contexto_cuenta.$('#activar_camara').removeClass('disabled');
												contexto_cuenta.$('#activar_camara').attr('style', '');
												contexto_cuenta.$('#archivo_qr').removeClass('disabled');
												contexto_cuenta.$('#archivo_qr').attr('style', '');
												contexto_cuenta.$('#btnSubir').removeClass('disabled');
												contexto_cuenta.$('#btnSubir').attr('style', 'margin:10px');
												contexto_cuenta.$('#validar_QR').removeClass('disabled');
												contexto_cuenta.$('#validar_QR').attr('style', 'margin:10px');
												contexto_cuenta.$('#btn_Cancelar').removeClass('disabled');
												contexto_cuenta.$('#btn_Cancelar').attr('style', 'margin:10px');
											},
											onConfirm: function() {
                        // Actualiza Datos Personales
												contexto_cuenta.model.set('tipodepersona_c', Regimen);
												contexto_cuenta.model.set('rfc_c', RFC);
												contexto_cuenta.model.set('path_img_qr_c', PathQR);
                        cambioRazonSocial['cambioCuenta'] = false;
                        cambioRazonSocial['Cuenta'] = [];
                        cambioRazonSocial['Cuenta']['razonsocial_c'] = contexto_cuenta.model.get('razonsocial_c') ;
                        cambioRazonSocial['Cuenta']['primernombre_c'] = contexto_cuenta.model.get('primernombre_c') ;
                        cambioRazonSocial['Cuenta']['apellidopaterno_c'] = contexto_cuenta.model.get('apellidopaterno_c') ;
                        cambioRazonSocial['Cuenta']['apellidomaterno_c'] = contexto_cuenta.model.get('apellidomaterno_c') ;
                        cambioRazonSocial['Direccion'] = app.utils.deepCopy(contexto_cuenta.prev_oDirecciones.prev_direccion);
                        
												if(Regimen == "Persona Moral") {
                          //Valida cambios
                          cambioRazonSocial['cambioCuenta'] = contexto_cuenta.model.get('razonsocial_c') != Denominacion ? true : cambioRazonSocial['cambioCuenta'];
													contexto_cuenta.model.set('razonsocial_c', Denominacion);
													contexto_cuenta.model.set('nombre_comercial_c', Denominacion);
													contexto_cuenta.model.set('fechaconstitutiva_c', Constitucion);
												}else {
                          cambioRazonSocial['cambioCuenta'] = contexto_cuenta.model.get('primernombre_c') != Nombre ? true : cambioRazonSocial['cambioCuenta'];
                          cambioRazonSocial['cambioCuenta'] = contexto_cuenta.model.get('apellidopaterno_c') != Paterno ? true : cambioRazonSocial['cambioCuenta'];
                          cambioRazonSocial['cambioCuenta'] = contexto_cuenta.model.get('apellidomaterno_c') != Materno ? true : cambioRazonSocial['cambioCuenta'];
													contexto_cuenta.model.set('primernombre_c', Nombre);
													contexto_cuenta.model.set('apellidopaterno_c', Paterno);
													contexto_cuenta.model.set('apellidomaterno_c', Materno);
													contexto_cuenta.model.set('fechadenacimiento_c', Nacimiento);
													contexto_cuenta.model.set('curp_c', CURP);
												}
												//self.model.set('email1', Correo);
												var arrcorreos = [];
												var repetido = 0;
												if(Correo!= "" ){
													if(contexto_cuenta.model.attributes.email !== undefined ){
														arrcorreos = contexto_cuenta.model.attributes.email;
														if(arrcorreos.length > 0){
															for(var y=0; y < arrcorreos.length; y++){
																if(arrcorreos[y].email_address == Correo){
																	repetido = 1;
																}
															}
															if(repetido == 0){
																arrcorreos[arrcorreos.length]={email_address: Correo, primary_address: false};
																contexto_cuenta.cambio_previo_mail = '2';
															}
														}else{
															arrcorreos = [{email_address: Correo, primary_address: true}];
															contexto_cuenta.cambio_previo_mail = '1';
														}
													}else{
														arrcorreos = [{email_address: Correo, primary_address: true}];
														contexto_cuenta.cambio_previo_mail = '1';
														
													}
                          contexto_cuenta.model.set('email', arrcorreos);
                          currentValue = contexto_cuenta.model.get('email');
                          emailFieldHtml = cont_qr._buildEmailFieldHtml({
                              email_address: Correo,
                              primary_address: true,
                              opt_out: false,
                              invalid_email: false
                          });
                          //self.render();
                          $newEmailField = contexto_cuenta.$('.newEmail').closest('.email').before(emailFieldHtml);
												}
												// Valida duplicado
												cont_dir.oDirecciones = contexto_cuenta.oDirecciones;
												cont_tel.oTelefonos = contexto_cuenta.oTelefonos;
												cont_tel.render();
												pipeacc.tipoSubtipo_vista();
												clasf_sectorial.ActividadEconomica=contexto_cuenta.ActividadEconomica;
												clasf_sectorial.ResumenCliente=contexto_cuenta.ResumenCliente;
												clasf_sectorial.render();
												pld.ProductosPLD=contexto_cuenta.ProductosPLD;
												pld.render();
												var nada = 0;
												var secuencia = 0;
												var principal = 0;
												var duplicado = 0;
												var duplicados = 0;
												var cDuplicado = 0;
												var cDireccionFiscal = 0;
												var direccion = cont_dir.oDirecciones.direccion;
                        cambioRazonSocial['cambioDirFiscal'] = false;
                        //Itera para validar diferencia en dirección fiscal
                        //cambioRazonSocial['cambioCuenta'] = self.model.get('primernombre_c') != Nombre ? true : cambioRazonSocial['cambioCuenta'];
                        Object.keys(direccion).forEach(key => {
                            //Valida dirección fiscal
                            if(direccion[key].indicadorSeleccionados.includes('^2^') && direccion[key].inactivo == 0){
                              cambiaDirFiscal = 0;
                              cambiaDirFiscal = (direccion[key].valCodigoPostal != CP) ? cambiaDirFiscal+1 : cambiaDirFiscal;
                              cambiaDirFiscal = (direccion[key].listPais[direccion[key].pais] != Pais) ? cambiaDirFiscal+1 : cambiaDirFiscal;
                              cambiaDirFiscal = (direccion[key].listMunicipio[direccion[key].municipio] != Municipio) ? cambiaDirFiscal+1 : cambiaDirFiscal;
                              cambiaDirFiscal = (direccion[key].listColonia[direccion[key].colonia] != Colonia) ? cambiaDirFiscal+1 : cambiaDirFiscal;
                              cambiaDirFiscal = (contextol._limpiezaDatos(direccion[key].calle) != contextol._limpiezaDatos(Calle)) ? cambiaDirFiscal+1 : cambiaDirFiscal;
                              cambiaDirFiscal = (contextol._limpiezaDatos(direccion[key].numext) != contextol._limpiezaDatos(Exterior)) ? cambiaDirFiscal+1 : cambiaDirFiscal;
                              cambiaDirFiscal = (contextol._limpiezaDatos(direccion[key].numint) != contextol._limpiezaDatos(Interior)) ? cambiaDirFiscal+1 : cambiaDirFiscal;
                              if(cambiaDirFiscal >= 1){
                                  cambioRazonSocial['cambioDirFiscal'] = true;
                              }
                            }
                        });
												var auxd = '';
												var auxd1 = '';
												Object.keys(direccion).forEach(key => {
													duplicado = 0;
													secuencia = secuencia + 1;
													if(direccion[key].principal && !direccion[key].inactivo) principal = 1;
													duplicado = (direccion[key].valCodigoPostal == CP) ? duplicado+1 : duplicado;
													duplicado = (direccion[key].listPais[direccion[key].pais] == Pais) ? duplicado+1 : duplicado;
													//duplicado = (direccion[key].listEstado[direccion[key].estado] == Estado) ? duplicado+1 : duplicado;
													duplicado = (direccion[key].listMunicipio[direccion[key].municipio] == Municipio) ? duplicado+1 : duplicado;
													duplicado = (direccion[key].listColonia[direccion[key].colonia] == Colonia) ? duplicado+1 : duplicado;
													duplicado = (contextol._limpiezaDatos(direccion[key].calle) == contextol._limpiezaDatos(Calle)) ? duplicado+1 : duplicado;
													duplicado = (contextol._limpiezaDatos(direccion[key].numext) == contextol._limpiezaDatos(Exterior)) ? duplicado+1 : duplicado;
													duplicado = (contextol._limpiezaDatos(direccion[key].numint) == contextol._limpiezaDatos(Interior)) ? duplicado+1 : duplicado;
													duplicado = (direccion[key].inactivo == 0) ? duplicado+1 : duplicado;
													if(direccion[key].indicadorSeleccionados.includes('2') && direccion[key].inactivo == 0){
														cDireccionFiscal = cDireccionFiscal + 1;
														indice_indicador = key;
													}
													if(duplicado == 8) duplicados = 1;
													if(duplicado == 8 && cDireccionFiscal == 1) nada = 1;
													if(duplicado == 8 && cDireccionFiscal == 0) {
														var bloqueado = 1;
														var accesoFiscal = App.user.attributes.tct_alta_clientes_chk_c + App.user.attributes.tct_altaproveedor_chk_c + App.user.attributes.tct_alta_cd_chk_c + App.user.attributes.deudor_factoraje_c;
														if (accesoFiscal > 0) bloqueado = 0;
														// Indicador
														direccion[key].indicadorSeleccionados = direccion[key].indicadorSeleccionados + ',^2^';
														direccion[key].bloqueado = bloqueado;
														contexto_cuenta.cambio_previo_mail = '3';
														//contexto_cuenta.cambio_previo_mail = '1';
														var indicador = direccion[key].indicadorSeleccionados;
														var dir_indicador_map_list = app.lang.getAppListStrings('dir_indicador_map_list');
														indicador = indicador.substring(1,indicador.length-1);
														indicador = indicador.split('^,^');
														indicador = indicador.sort((a,b)=>a-b);
														for (var key1 in dir_indicador_map_list) {
															var value = app.lang.getAppListStrings('dir_indicador_map_list')[key1];
															if (value == indicador) direccion[key].indicador = key1;
														}
														cont_dir.oDirecciones.direccion = direccion;
														cont_dir.render();
														cDuplicado++;
														contexto_cuenta.$('#activar_camara').removeClass('disabled');
														contexto_cuenta.$('#activar_camara').attr('style', '');
														contexto_cuenta.$('#archivo_qr').removeClass('disabled');
														contexto_cuenta.$('#archivo_qr').attr('style', '');
														contexto_cuenta.$('#btnSubir').removeClass('disabled');
														contexto_cuenta.$('#btnSubir').attr('style', 'margin:10px');
														contexto_cuenta.$('#validar_QR').removeClass('disabled');
														contexto_cuenta.$('#validar_QR').attr('style', 'margin:10px');
														contexto_cuenta.$('#btn_Cancelar').removeClass('disabled');
														contexto_cuenta.$('#btn_Cancelar').attr('style', 'margin:10px');
														contexto_cuenta.$('#rfcModal').hide();
														cont_dir.render();
													}
												});
												// Agrega Dirección
												var strUrl = 'DireccionesQR/' + CP + '/0/' + Colonia +'/'+Municipio+'/'+Estado;
												app.api.call('GET', app.api.buildURL(strUrl), null, {
													success: _.bind(function (data) {
														if(data.idCP) {
															var list_paises = data.paises;
															var list_municipios = data.municipios;
															var city_list = App.metadata.getCities();
															var list_estados = data.estados;
															var list_colonias = data.colonias;
															//País
															var listPais = {};
															var auxPais = '';
															for (var i = 0; i < list_paises.length; i++) {
																listPais[list_paises[i].idPais] = list_paises[i].namePais;
																auxPais = list_paises[i].idPais;
															}
															//Estado
															var listEstado = {};
															var auxEstado = '';
															for (var i = 0; i < list_estados.length; i++) {
																listEstado[list_estados[i].idEstado] = list_estados[i].nameEstado;
																auxEstado = list_estados[i].idEstado;
															}
															//Municipio
															var listMunicipio = {};
															var auxMunicipio = '';
															for (var i = 0; i < list_municipios.length; i++) {
																listMunicipio[list_municipios[i].idMunicipio] = list_municipios[i].nameMunicipio;
																if(list_municipios[i].nameMunicipio == Municipio) auxMunicipio = list_municipios[i].idMunicipio;
															}
															//Colonia
															var listColonia = {};
															var auxColonia = '';
															for (var i = 0; i < list_colonias.length; i++) {
																listColonia[list_colonias[i].idColonia] = list_colonias[i].nameColonia;
																if(list_colonias[i].nameColonia == Colonia) auxColonia = list_colonias[i].idColonia;
															}
                              if(auxColonia==''){
                                  listColonia['']="";
                              }
															//Ciudad
															var listCiudad = {};
															var ciudades = Object.values(city_list);
															var auxCiudad = '';
															var estadociudadaux = '';
                              var idSinCiudad ='';
															//nuevaDireccion.estado = (Object.keys(nuevaDireccion.listEstado)[0] != undefined) ? Object.keys(nuevaDireccion.listEstado)[0] : "";
															estadociudadaux = (Object.keys(listEstado)[0] != undefined) ? Object.keys(listEstado)[0] : "" ;
															for (var [key, value] of Object.entries(listEstado)) {
																for (var i = 0; i < ciudades.length; i++) {
																	if (ciudades[i].estado_id == key) {
																		listCiudad[ciudades[i].id] = ciudades[i].name;
                                    idSinCiudad = (ciudades[i].name == 'SIN CIUDAD') ? ciudades[i].id : idSinCiudad;
																		if(ciudades[i].name == Municipio) auxCiudad = ciudades[i].id;
																	}
																}
															}
                              //auxCiudad = (auxCiudad=='' && idSinCiudad!='') ? idSinCiudad : auxCiudad;
                              auxCiudad = idSinCiudad;
															if(cDireccionFiscal >= 1) {
															  if(direccion[indice_indicador].indicador == 2) {
  																direccion[indice_indicador].valCodigoPostal = CP;
                                  direccion[indice_indicador].postal = data.idCP;
  																direccion[indice_indicador].calle = Calle.trim();
  																direccion[indice_indicador].numext = Exterior.trim();
  																direccion[indice_indicador].numint = Interior.trim();
  																direccion[indice_indicador].inactivo = 0;
  																//Pais
  																direccion[indice_indicador].pais = auxPais;
  																direccion[indice_indicador].listPais = listPais;
  																direccion[indice_indicador].listPaisFull = listPais;
  																//Estado
  																direccion[indice_indicador].estado = auxEstado;
  																direccion[indice_indicador].listEstado = listEstado;
  																direccion[indice_indicador].listEstadoFull = listEstado;
  																//Municipio
  																direccion[indice_indicador].municipio = auxMunicipio;
  																direccion[indice_indicador].listMunicipio = listMunicipio;
  																direccion[indice_indicador].listMunicipioFull = listMunicipio;
  																//Colonia
  																direccion[indice_indicador].colonia = auxColonia;
  																direccion[indice_indicador].listColonia = listColonia;
  																direccion[indice_indicador].listColoniaFull = listColonia;
  																//Ciudad
  																direccion[indice_indicador].ciudad = auxCiudad;
  																direccion[indice_indicador].listCiudad = listCiudad;
  																direccion[indice_indicador].listCiudadFull = listCiudad;
															  } else {
																if(nada == 0) {
																	var quita = '';
																	if(direccion[indice_indicador].indicadorSeleccionados.includes('^2^,')) {
																	  quita = direccion[indice_indicador].indicadorSeleccionados.replace("^2^,", "");
																	}
																	if(direccion[indice_indicador].indicadorSeleccionados.includes(',^2^')) {
																	  quita = direccion[indice_indicador].indicadorSeleccionados.replace(",^2^", "");
																	}
																	var indicador = quita;
																	var dir_indicador_map_list = app.lang.getAppListStrings('dir_indicador_map_list');
																	direccion[indice_indicador].indicadorSeleccionados = quita;
																	indicador = indicador.substring(1,indicador.length-1);
																	indicador = indicador.split('^,^');
																	indicador = indicador.sort((a,b)=>a-b);
																	for (var key1 in dir_indicador_map_list) {
																		var value = app.lang.getAppListStrings('dir_indicador_map_list')[key1];
																		if (value == indicador) direccion[indice_indicador].indicador = key1;
																	}
																	direccion[indice_indicador].bloqueado = 0;
																	cont_dir.oDirecciones.direccion = direccion;
																}
																if(duplicados == 0) {
    																var nuevaDireccion = {
    																	"tipodedireccion":"",
    																	"listTipo":App.lang.getAppListStrings('dir_tipo_unique_list'),
    																	"tipoSeleccionados":"",
    																	"indicador":"",
    																	"listIndicador":App.lang.getAppListStrings('dir_indicador_unique_list'),
    																	"indicadorSeleccionados":"",
    																	"bloqueado":"",
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
																	var bloqueado = 1;
																	var accesoFiscal = App.user.attributes.tct_alta_clientes_chk_c + App.user.attributes.tct_altaproveedor_chk_c + App.user.attributes.tct_alta_cd_chk_c + App.user.attributes.deudor_factoraje_c;
																	if(accesoFiscal > 0) bloqueado = 0;
																	if(!principal) nuevaDireccion.principal = "1";
    																nuevaDireccion.secuencia = secuencia;
    																nuevaDireccion.tipodedireccion = "1";
    																nuevaDireccion.tipoSeleccionados = '^1^';
    																nuevaDireccion.indicador = "2";
    																nuevaDireccion.indicadorSeleccionados = '^2^';
    																nuevaDireccion.bloqueado = bloqueado;
    																nuevaDireccion.valCodigoPostal = CP;
    																nuevaDireccion.postal = data.idCP;
    																nuevaDireccion.calle = Calle;
    																nuevaDireccion.numext = Exterior;
    																nuevaDireccion.numint = Interior;
    																//Pais
    																nuevaDireccion.pais = auxPais;
    																nuevaDireccion.listPais = listPais;
    																nuevaDireccion.listPaisFull = listPais;
    																//Estado
    																nuevaDireccion.estado = auxEstado;
    																nuevaDireccion.listEstado = listEstado;
    																nuevaDireccion.listEstadoFull = listEstado;
    																//Municipio
    																nuevaDireccion.municipio = auxMunicipio;
    																nuevaDireccion.listMunicipio = listMunicipio;
    																nuevaDireccion.listMunicipioFull = listMunicipio;
    																//Colonia
    																nuevaDireccion.colonia = auxColonia;
    																nuevaDireccion.listColonia = listColonia;
    																nuevaDireccion.listColoniaFull = listColonia;
    																//Ciudad
    																nuevaDireccion.ciudad = auxCiudad;
    																nuevaDireccion.listCiudad = listCiudad;
    																nuevaDireccion.listCiudadFull = listCiudad;
																	cont_dir.oDirecciones.direccion.push(nuevaDireccion);
																}
															  }
  															  cont_dir.render();
  															  app.alert.dismiss('procesando');
  															  app.alert.show('multiple_fiscal', {
  																level: 'info',
  																messages: 'Se han actualizado los datos de dirección fiscal'
  															  });
  															  contexto_cuenta.$('#activar_camara').removeClass('disabled');
  															  contexto_cuenta.$('#activar_camara').attr('style', '');
  															  contexto_cuenta.$('#archivo_qr').removeClass('disabled');
  															  contexto_cuenta.$('#archivo_qr').attr('style', '');
  															  contexto_cuenta.$('#btnSubir').removeClass('disabled');
  															  contexto_cuenta.$('#btnSubir').attr('style', 'margin:10px');
  															  contexto_cuenta.$('#validar_QR').removeClass('disabled');
  															  contexto_cuenta.$('#validar_QR').attr('style', 'margin:10px');
  															  contexto_cuenta.$('#btn_Cancelar').removeClass('disabled');
  															  contexto_cuenta.$('#btn_Cancelar').attr('style', 'margin:10px');
  															  contexto_cuenta.$('#rfcModal').hide();
  															  if(contexto_cuenta.cambio_previo_mail == '1'){
																contexto_cuenta.cambio_previo_mail = '1';
  															  }else{
  																contexto_cuenta.cambio_previo_mail = '4';
  															  }
															} else {
																if(cDuplicado == 0 && duplicados == 0) {
																	var nuevaDireccion = {
																		"tipodedireccion":"",
																		"listTipo":App.lang.getAppListStrings('dir_tipo_unique_list'),
																		"tipoSeleccionados":"",
																		"indicador":"",
																		"listIndicador":App.lang.getAppListStrings('dir_indicador_unique_list'),
																		"indicadorSeleccionados":"",
																		"bloqueado":"",
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
																	var bloqueado = 1;
																	var accesoFiscal = App.user.attributes.tct_alta_clientes_chk_c + App.user.attributes.tct_altaproveedor_chk_c + App.user.attributes.tct_alta_cd_chk_c + App.user.attributes.deudor_factoraje_c;
																	if(accesoFiscal > 0) bloqueado = 0;
																	if(!principal) nuevaDireccion.principal = "1";
																	nuevaDireccion.secuencia = "1";
																	nuevaDireccion.tipodedireccion = "1";
																	nuevaDireccion.tipoSeleccionados = '^1^';
																	nuevaDireccion.indicador = "2";
																	nuevaDireccion.indicadorSeleccionados = '^2^';
																	nuevaDireccion.bloqueado = bloqueado;
																	nuevaDireccion.valCodigoPostal = CP;
																	nuevaDireccion.postal = data.idCP;
																	nuevaDireccion.calle = Calle;
																	nuevaDireccion.numext = Exterior;
																	nuevaDireccion.numint = Interior;
																	//Pais
																	nuevaDireccion.pais = auxPais;
																	nuevaDireccion.listPais = listPais;
																	nuevaDireccion.listPaisFull = listPais;
																	//Estado
																	nuevaDireccion.estado = auxEstado;
																	nuevaDireccion.listEstado = listEstado;
																	nuevaDireccion.listEstadoFull = listEstado;
																	//Municipio
																	nuevaDireccion.municipio = auxMunicipio;
																	nuevaDireccion.listMunicipio = listMunicipio;
																	nuevaDireccion.listMunicipioFull = listMunicipio;
																	//Colonia
																	nuevaDireccion.colonia = auxColonia;
																	nuevaDireccion.listColonia = listColonia;
																	nuevaDireccion.listColoniaFull = listColonia;
																	//Ciudad
																	nuevaDireccion.ciudad = auxCiudad;
																	nuevaDireccion.listCiudad = listCiudad;
																	nuevaDireccion.listCiudadFull = listCiudad;
																	//var listCiudad = {};
																	//var ciudades = Object.values(city_list);
																	//nuevaDireccion.estado = (Object.keys(nuevaDireccion.listEstado)[0] != undefined) ? Object.keys(nuevaDireccion.listEstado)[0] : "";
																	//for (var [key, value] of Object.entries(nuevaDireccion.listEstado)) {
																	//	for (var i = 0; i < ciudades.length; i++) {
																	//	if (ciudades[i].estado_id == key) {
																	//		listCiudad[ciudades[i].id] = ciudades[i].name;
																	//		if(ciudades[i].name == Municipio) nuevaDireccion.ciudad = ciudades[i].id;
																	//	}
																	//	}
																	//}
																	//nuevaDireccion.listCiudad = listCiudad;
																	//nuevaDireccion.listCiudadFull = listCiudad;
																	cont_dir.oDirecciones.direccion.push(nuevaDireccion);
																	cont_dir.render();
																	app.alert.dismiss('procesando');
																	contexto_cuenta.$('#activar_camara').removeClass('disabled');
																	contexto_cuenta.$('#activar_camara').attr('style', '');
																	contexto_cuenta.$('#archivo_qr').removeClass('disabled');
																	contexto_cuenta.$('#archivo_qr').attr('style', '');
																	contexto_cuenta.$('#btnSubir').removeClass('disabled');
																	contexto_cuenta.$('#btnSubir').attr('style', 'margin:10px');
																	contexto_cuenta.$('#validar_QR').removeClass('disabled');
																	contexto_cuenta.$('#validar_QR').attr('style', 'margin:10px');
																	contexto_cuenta.$('#btn_Cancelar').removeClass('disabled');
																	contexto_cuenta.$('#btn_Cancelar').attr('style', 'margin:10px');
																	contexto_cuenta.$('#rfcModal').hide();
																	contexto_cuenta.cambio_previo_mail = '5';
																	//contexto_cuenta.render();
																} else {
																	cont_dir.render();
																	//app.alert.dismiss('procesando');
																	app.alert.show('cp_not_found', {
																		level: 'info',
																		messages: 'Se agrego tipo fiscal a una dirección existente'
																	});
																	contexto_cuenta.$('#activar_camara').removeClass('disabled');
																	contexto_cuenta.$('#activar_camara').attr('style', '');
																	contexto_cuenta.$('#archivo_qr').removeClass('disabled');
																	contexto_cuenta.$('#archivo_qr').attr('style', '');
																	contexto_cuenta.$('#btnSubir').removeClass('disabled');
																	contexto_cuenta.$('#btnSubir').attr('style', 'margin:10px');
																	contexto_cuenta.$('#validar_QR').removeClass('disabled');
																	contexto_cuenta.$('#validar_QR').attr('style', 'margin:10px');
																	contexto_cuenta.$('#btn_Cancelar').removeClass('disabled');
																	contexto_cuenta.$('#btn_Cancelar').attr('style', 'margin:10px');
																	contexto_cuenta.$('#rfcModal').hide();
																	//contexto_cuenta.render();
																}
															}
														}
                            
                            //Valida tipo de registro; (Cliente || Proveedor) && Origen!=Seguros && Subtipo != Venta activo
                            if ( (contexto_cuenta.model.get('tipo_registro_cuenta_c') =='3' || contexto_cuenta.model.get('tipo_registro_cuenta_c') =='5') && contexto_cuenta.model.get('origen_cuenta_c') != '11' && contexto_cuenta.model.get('subtipo_registro_cuenta_c') != '11' ) {
                              if(cambioRazonSocial['cambioDirFiscal'] || cambioRazonSocial['cambioCuenta'] ){
                                  //Abre modal para indicar tipo de cambio
                                  //Restablece valores de custom fieldQR
                                  contexto_cuenta.$('#activar_camara').removeClass('disabled');
																	contexto_cuenta.$('#activar_camara').attr('style', '');
																	contexto_cuenta.$('#archivo_qr').removeClass('disabled');
																	contexto_cuenta.$('#archivo_qr').attr('style', '');
																	contexto_cuenta.$('#btnSubir').removeClass('disabled');
																	contexto_cuenta.$('#btnSubir').attr('style', 'margin:10px');
																	contexto_cuenta.$('#validar_QR').removeClass('disabled');
																	contexto_cuenta.$('#validar_QR').attr('style', 'margin:10px');
																	contexto_cuenta.$('#btn_Cancelar').removeClass('disabled');
																	contexto_cuenta.$('#btn_Cancelar').attr('style', 'margin:10px');
																	//contexto_cuenta.$('#rfcModal').hide();
          											
                                  //Muestra modal cambios
                                  $('#cambioRazonSocial').show();
                                  if(!cambioRazonSocial['cambioDirFiscal'] && cambioRazonSocial['cambioCuenta']){
                                      $('.action1').show();
                                      $('.action2').hide();
                                      $('.action3').hide();
                                  }
                                  if(cambioRazonSocial['cambioDirFiscal'] && !cambioRazonSocial['cambioCuenta']){
                                      $('.action1').hide();
                                      $('.action2').show();
                                      $('.action3').hide();
                                  }
                                  if(cambioRazonSocial['cambioDirFiscal'] && cambioRazonSocial['cambioCuenta']){
                                      $('.action1').show();
                                      $('.action2').show();
                                      $('.action3').show();
                                  }
                              }                              
                            }
                            
													})
												});
											},
										});
									}
								}
							})
						});
					}
				})
			});
		}
	},

  cargarArchivo: function() {
    contexto_cuenta.$('#carga').show();
    contexto_cuenta.$('#div_video').hide();
    contexto_cuenta.picturecam = false;
  },

  btn_rfc_qr: function() {
    contexto_cuenta.$('#rfcModal').show();
  },

  cancelar: function() {
    contexto_cuenta.$('#rfcModal').hide();
	  contexto_cuenta.picturecam = false;
	  contexto_cuenta.$('#rfcModal').hide();
  },

  _limpiezaDatos: function(cadena){

		cadena = cadena.trim().toLowerCase();
		cadena = cadena.split(" ").join("");
		cadena = cadena.replace(".", "");
		cadena = cadena.replace("-", "");
		cadena = cadena.replace("_", "");
		cadena = cadena.replace(",", "");
		cadena = cadena.replace(";", "");
		cadena = cadena.replace(":", "");
		cadena = cadena.replace("#", "");
		cadena = cadena.replace("$", "");
		cadena = cadena.replace("%", "");
		cadena = cadena.replace("&", "");
		cadena = cadena.replace("\d", "");
		cadena = cadena.replace("\r", "");
		cadena = cadena.replace("\t", "");
		cadena = cadena.replace("\n", "");
		return cadena;
  },

  bindDataChange: function () {
        this.model.on('change:' + this.name, function () {
            if (this.action !== 'edit') {
                this.render();
            }
        }, this);
    },
    _buildEmailFieldHtml: function (email) {
        var editEmailFieldTemplate = app.template.getField('email', 'edit-email-field'), emails = this.model.get('email'), index = _.indexOf(emails, email);
        return editEmailFieldTemplate({
            max_length: this.def.len,
            index: index === -1 ? emails.length - 1 : index,
            email_address: email.email_address,
            primary_address: email.primary_address,
            opt_out: email.opt_out,
            invalid_email: email.invalid_email
        });
    },
    
    closeModalRazonSocial:function(){
        //Restablece valores de custom fieldQR
        contexto_cuenta.$('#activar_camara').removeClass('disabled');
        contexto_cuenta.$('#activar_camara').attr('style', '');
        contexto_cuenta.$('#archivo_qr').removeClass('disabled');
        contexto_cuenta.$('#archivo_qr').attr('style', '');
        contexto_cuenta.$('#btnSubir').removeClass('disabled');
        contexto_cuenta.$('#btnSubir').attr('style', 'margin:10px');
        contexto_cuenta.$('#validar_QR').removeClass('disabled');
        contexto_cuenta.$('#validar_QR').attr('style', 'margin:10px');
        contexto_cuenta.$('#btn_Cancelar').removeClass('disabled');
        contexto_cuenta.$('#btn_Cancelar').attr('style', 'margin:10px');
        //Cierra modal
        $('#cambioRazonSocial').hide();
        //Aplica rollback
        if(cambioRazonSocial['cambioCuenta']){
            if(contexto_cuenta.model.get('tipodepersona_c') == "Persona Moral") {
              contexto_cuenta.model.set('razonsocial_c', cambioRazonSocial['Cuenta']['razonsocial_c']);
              contexto_cuenta.model.set('nombre_comercial_c', cambioRazonSocial['Cuenta']['razonsocial_c']);
            }else {
              contexto_cuenta.model.set('primernombre_c', cambioRazonSocial['Cuenta']['primernombre_c']);
              contexto_cuenta.model.set('apellidopaterno_c', cambioRazonSocial['Cuenta']['apellidopaterno_c']);
              contexto_cuenta.model.set('apellidomaterno_c', cambioRazonSocial['Cuenta']['apellidomaterno_c']);
            }
        }
        cont_dir.oDirecciones.direccion = cambioRazonSocial['Direccion'];
        cont_dir.render();
        App.alert.show('closemodalRazonSocial', {
          level: 'info',
          messages: 'Se ha descartado la solicitud de cambios',
          autoClose: true
        });
        
    },
    
    modalAction1:function(){
        //Cierra modal
        $('#cambioRazonSocial').hide();
        $('#rfcModal').hide();
        cont_dir.oDirecciones.direccion = cambioRazonSocial['Direccion'];
        cont_dir.render();
        var model=App.data.createBean('Cases');
        model.set('account_id', contexto_cuenta.model.get('id'));
        model.set('account_name', contexto_cuenta.model.get('name'));
        model.set('producto_c','SC6'); //Seguimiento comercial
        model.set('type','15'); //Cambio nombre
        model.set('area_interna_c','Credito');  //Crédito
        if(App.user.attributes.cac_c){
            var asignadoId = infoUser['id'] != '' ? infoUser['id'] : App.user.id;
            var asignadoName = infoUser['name'] != '' ? infoUser['name'] :App.user.attributes.full_name;
            model.set('assigned_user_id',asignadoId); 
            model.set('assigned_user_name',asignadoName);
            model.set('area_interna_c','');
        }
        app.drawer.open({
            layout: 'create',
            context: {
                  create: true,
                  module: 'Cases',
                  model: model
              },
          },
          function(variable){
              if(variable.attributes.model.id == undefined){
                  //Aplica rollback
                  if(cambioRazonSocial['cambioCuenta']){
                      if(contexto_cuenta.model.get('tipodepersona_c') == "Persona Moral") {
                        contexto_cuenta.model.set('razonsocial_c', cambioRazonSocial['Cuenta']['razonsocial_c']);
                        contexto_cuenta.model.set('nombre_comercial_c', cambioRazonSocial['Cuenta']['razonsocial_c']);
                      }else {
                        contexto_cuenta.model.set('primernombre_c', cambioRazonSocial['Cuenta']['primernombre_c']);
                        contexto_cuenta.model.set('apellidopaterno_c', cambioRazonSocial['Cuenta']['apellidopaterno_c']);
                        contexto_cuenta.model.set('apellidomaterno_c', cambioRazonSocial['Cuenta']['apellidomaterno_c']);
                      }
                  }
                  App.alert.show('cancelCase1', {
                    level: 'info',
                    messages: 'Se ha descartado la solicitud de cambios',
                    autoClose: true
                  });
              }else{
                  contexto_cuenta.model.set('omitir_caso', 1);
                  App.alert.show('saveaction1', {
                    level: 'info',
                    messages: 'Guarde la cuenta para continuar con el proceso de solicitud de cambios',
                    autoClose: false
                  });
              }         
          }
        );
    },
    
    modalAction2:function(){
        //Cierra modal
        $('#cambioRazonSocial').hide();
        $('#rfcModal').hide();
        if(contexto_cuenta.model.get('tipodepersona_c') == "Persona Moral") {
          contexto_cuenta.model.set('razonsocial_c', cambioRazonSocial['Cuenta']['razonsocial_c']);
          contexto_cuenta.model.set('nombre_comercial_c', cambioRazonSocial['Cuenta']['razonsocial_c']);
        }else {
          contexto_cuenta.model.set('primernombre_c', cambioRazonSocial['Cuenta']['primernombre_c']);
          contexto_cuenta.model.set('apellidopaterno_c', cambioRazonSocial['Cuenta']['apellidopaterno_c']);
          contexto_cuenta.model.set('apellidomaterno_c', cambioRazonSocial['Cuenta']['apellidomaterno_c']);
        }
        var model=App.data.createBean('Cases');
        model.set('account_id', contexto_cuenta.model.get('id'));
        model.set('account_name', contexto_cuenta.model.get('name'));
        model.set('producto_c','SC6'); //Seguimiento comercial
        model.set('type','16'); //Cambio dirección
        model.set('area_interna_c','Credito');  //Crédito
        if(App.user.attributes.cac_c){
            var asignadoId = infoUser['id'] != '' ? infoUser['id'] : App.user.id;
            var asignadoName = infoUser['name'] != '' ? infoUser['name'] :App.user.attributes.full_name;
            model.set('assigned_user_id',asignadoId); 
            model.set('assigned_user_name',asignadoName);
            model.set('area_interna_c','');
        }
        app.drawer.open({
            layout: 'create',
            context: {
                  create: true,
                  module: 'Cases',
                  model: model
              },
          },
          function(variable){
              if(variable.attributes.model.id == undefined){
                  //Aplica rollback
                  if(cambioRazonSocial['cambioDirFiscal']){
                      cont_dir.oDirecciones.direccion = cambioRazonSocial['Direccion'];
                      cont_dir.render();
                  }
                  App.alert.show('cancelCase2', {
                    level: 'info',
                    messages: 'Se ha descartado la solicitud de cambios',
                    autoClose: true
                  });
              }else{
                  contexto_cuenta.model.set('omitir_caso', 1);
                  App.alert.show('saveaction2', {
                    level: 'info',
                    messages: 'Guarde la cuenta para continuar con el proceso de solicitud de cambios',
                    autoClose: false
                  });
              }         
          }
        );
    },
    
    modalAction3:function(){
        //Cierra modal
        $('#cambioRazonSocial').hide();
        $('#rfcModal').hide();
        var model=App.data.createBean('Cases');
        model.set('account_id', contexto_cuenta.model.get('id'));
        model.set('account_name', contexto_cuenta.model.get('name'));
        model.set('producto_c','SC6'); //Seguimiento comercial
        model.set('type','17'); //Cambio nombre y dirección
        model.set('area_interna_c','Credito');  //Crédito
        if(App.user.attributes.cac_c){
            var asignadoId = infoUser['id'] != '' ? infoUser['id'] : App.user.id;
            var asignadoName = infoUser['name'] != '' ? infoUser['name'] :App.user.attributes.full_name;
            model.set('assigned_user_id',asignadoId); 
            model.set('assigned_user_name',asignadoName);
            model.set('area_interna_c',''); 
        }
        app.drawer.open({
            layout: 'create',
            context: {
                  create: true,
                  module: 'Cases',
                  model: model
              },
          },
          function(variable){
              if(variable.attributes.model.id == undefined){
                  //Aplica rollback
                  if(cambioRazonSocial['cambioCuenta']){
                      if(contexto_cuenta.model.get('tipodepersona_c') == "Persona Moral") {
                        contexto_cuenta.model.set('razonsocial_c', cambioRazonSocial['Cuenta']['razonsocial_c']);
                        contexto_cuenta.model.set('nombre_comercial_c', cambioRazonSocial['Cuenta']['razonsocial_c']);
                      }else {
                        contexto_cuenta.model.set('primernombre_c', cambioRazonSocial['Cuenta']['primernombre_c']);
                        contexto_cuenta.model.set('apellidopaterno_c', cambioRazonSocial['Cuenta']['apellidopaterno_c']);
                        contexto_cuenta.model.set('apellidomaterno_c', cambioRazonSocial['Cuenta']['apellidomaterno_c']);
                      }
                  }
                  cont_dir.oDirecciones.direccion = cambioRazonSocial['Direccion'];
                  cont_dir.render();
                  App.alert.show('cancelCase3', {
                    level: 'info',
                    messages: 'Se ha descartado la solicitud de cambios',
                    autoClose: true
                  });
              }else{
                  contexto_cuenta.model.set('omitir_caso', 1);
                  App.alert.show('saveaction3', {
                    level: 'info',
                    messages: 'Guarde la cuenta para continuar con el proceso de solicitud de cambios',
                    autoClose: false
                  });
              }         
          }
        );
    },
    
    getUserInfo:function(){
        if(App.user.attributes.cac_c){
            try {
              app.api.call("read", app.api.buildURL("getAsignadoCaso/"+ contexto_cuenta.model.attributes.id), null, {
                  success: _.bind(function (data) {
                      if (data) {
                          infoUser['id'] = data['id'];
                          infoUser['name'] = data['name'];
                      }
                  }, this),
                  error: _.bind(function (error) {
                    //Muestra error
                    infoUser['id'] ='';
                    infoUser['name'] ='';
                  }, this),
              });
            } catch (e) {
              infoUser['id'] ='';
              infoUser['name'] ='';
            }
        }
    }
})

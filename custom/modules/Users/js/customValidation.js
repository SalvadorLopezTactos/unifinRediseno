SUGAR.util.doWhen("typeof(check_form) != 'undefined' && typeof check_form == 'function'", function() {
    check_form = _.wrap(check_form, function(originalCheckFormFunction, originalCheckFormFunctionArg) {
        // Adding custom validation

        //console.log(document.getElementById("contraseniaactual_c").value);
        //console.log(document.getElementById("nuevacontrasenia_c").value);
        //console.log(document.getElementById("confirmarnuevacontrasenia_c").value);
        //Validación para el campo de credito simple y alta clientes, solo uno puede estar activo.
        if (document.getElementById('tct_alta_credito_simple_chk_c').checked==true && document.getElementById('tct_alta_clientes_chk_c').checked==true){
            alert("No se permite seleccionar los dos campos de Alta Cliente, favor de seleccionar sólo uno.");
            return false;
        }

        if(document.getElementById("phone_mobile").value!=""){
            var strExpRegNumeric = new RegExp("^([0-9])*$");
            var movil= document.getElementById("phone_mobile").value.trim();
            if(movil.length >= 8 && movil.length<=13) {
                //Valida Móvil
                if (!strExpRegNumeric.test(movil)) {
                    alert("El campo móvil sólo acepta caracteres numéricos");
                    return false;
                }else{
                    var cont= 0;
                    for (var i = 0; i < movil.length; i++) {
                        if (movil.charAt(0) == movil.charAt(i)) {
                            cont++;
                        }
                    }
                    if(cont==movil.length){
                        alert("El número móvil contiene caracteres repetidos.");
                        return false;
                    }
                }

            }else{
                alert("El campo móvil debe tener entre 8 y 13 dígitos.");
                return false;
            }
        }

         //Valida contraseña
        if(document.getElementById("contraseniaactual_c").value != "" || document.getElementById("nuevacontrasenia_c").value != "")
        {

          //Valida contraseña actual
          if(document.getElementById("contraseniaactual_c").value == "" ){
            alert("Ingrese contraseña actual");
            return false;

          }

          //Valida nueva contraseña
          if(document.getElementById("nuevacontrasenia_c").value == "" ){
            alert("Ingrese nueva contraseña");
            return false;

          }

          //Valida expresión regular
          // Almenos 1, Mayuscula, minuscula y número, 8-16 caracteres
          if(document.getElementById("nuevacontrasenia_c").value != "" ){

            var strPwd = document.getElementById("nuevacontrasenia_c").value;
            //var strExpReg = new RegExp("[a-zA-Z0-9]{8,16}");
            var strExpRegMayus = new RegExp("[A-Z]{8,16}");
            var strExpRegMinus = new RegExp("[a-z]{8,16}");
            var strExpRegNumeric = new RegExp("[0-9]{8,16}");
            if(strPwd.length >= 8 && strPwd.length<=16){
              //Valida Mayus
              expreg = /[A-Z]/;
              if (!expreg.test(strPwd)) {
                  alert("Contraseña no tiene mayúsculas");
                  return false;
              }
              //Valida Minus
              expreg = /[a-z]/;
              if (!expreg.test(strPwd)) {
                  alert("Contraseña no tiene minúsculas");
                  return false;
              }
              //Valida Numeric
              expreg = /[0-9]/;
              if (!expreg.test(strPwd)) {
                  alert("Contraseña no tiene números");
                  return false;
              }

              //Valida caracteres especiales

              expreg = /[`~!@#$%^&*()_°¬|+\-=?;:'",.<>\s\{\}\[\]\\\/]/;
              if (expreg.test(strPwd)) {
                  alert("Contraseña no debe tener caracteres especiales");
                  return false;
              }

              //Valida palabra UNIFIN
              expreg = strPwd.search(/unifin/i);
              if (expreg >= 0) {
                  alert("Contraseña no debe contener la palabra unifin");
                  return false;
              }

              //Valida nombre de usuario
              console.log('Usuario ---- Cambio de contraseña');
              try {
                var user_name = document.getElementById("user_name").value;

                if (typeof user_name == 'undefined') {
                  user_name = document.getElementById("user_name").innerHTML;
                }

                console.log(user_name);
                user_name = user_name.toLowerCase();
                //console.log(user_name);
                expreg = strPwd.toLowerCase().search(user_name);
                console.log(expreg);
                console.log(strPwd.toLowerCase());
                if (expreg >= 0) {
                    alert("Contraseña no debe contener el nombre de usuario");
                    return false;
                }
              } catch (e) {

              }


            }else{
              alert("Contraseña debe tener entre 8 y 16 caracteres");
              return false;
            }
          }

          //Valida confirmación de contraseña
          if(document.getElementById("nuevacontrasenia_c").value != "" && document.getElementById("nuevacontrasenia_c").value == "" ){
            alert("Ingrese confirmación de contraseña");
            return false;
          }

          //Valida confirmación de contraseña
          if(document.getElementById("nuevacontrasenia_c").value != document.getElementById("confirmarnuevacontrasenia_c").value){
            alert("Contraseña no coincide");
            return false;
          }
          // Si cumple validación , regresa a proceso de validaciones Sugar.
          return originalCheckFormFunction(originalCheckFormFunctionArg);

        }else{
          return originalCheckFormFunction(originalCheckFormFunctionArg);
        }

        // if(isCustomValid == false) {
        //     // If custom validation is positive, calling original Sugar validation
        //     return originalCheckFormFunction(originalCheckFormFunctionArg);
        // } else {
        //     return false;
        // }
    });
});

$(window).load(function(){
  try{
   if (this.app.user.attributes.type != 'admin') {
    //Deshabilita campos
    //$('#equipos_c').attr('disabled','disabled');
    $('#equipos_c').attr('style','pointer-events:none');//Se añade estilo , ya que al agregar el atributo disabled para campos multiselect, el valor se pierde
    $('#equipo_c').attr('disabled','disabled');
    $('#tipodeproducto_c').attr('disabled','disabled');
    $('#puestousuario_c').attr('disabled','disabled');
    $('#subpuesto_c').attr('disabled','disabled');
    $('#tct_team_address_txf_c').attr('disabled','disabled');
    //$('#productos_c').attr('disabled','disabled');
    $('#productos_c').attr('style','pointer-events:none');//Se añade estilo , ya que al agregar el atributo disabled para campos multiselect, el valor se pierde
    $('#btn_clr_reports_to_name').attr('disabled','disabled');
    $('#btn_reports_to_name').attr('disabled','disabled');
    $('#reports_to_name').attr('disabled','disabled');

    $('#tct_altaproveedor_chk_c').attr('disabled','disabled');
    $('#tct_alta_cd_chk_c').attr('disabled','disabled');
    $('#optout_c').attr('disabled','disabled');
    $('#tct_alta_clientes_chk_c').attr('disabled','disabled');
    $('#cac_c').attr('disabled','disabled');
    $('#aut_caratulariesgo_c').attr('disabled','disabled');
    $('#tct_id_unics_txf_c').attr('disabled','disabled');
    $('#tct_id_uni2_txf_c').attr('disabled','disabled');
       $('#first_name').attr('disabled','disabled');
       $('#last_name').attr('disabled','disabled');
       $('#tct_alta_credito_simple_chk_c').attr('disabled','disabled');
       $('#tct_vetar_usuarios_chk_c').attr('disabled','disabled');
    }
   }catch(error){
      console.log(error.message);
   }

   try{
    if (this.App.user.attributes.type != 'admin') {
      //Deshabilita campos
      //$('#equipos_c').attr('disabled','disabled');
      $('#equipos_c').attr('style','pointer-events:none');//Se añade estilo , ya que al agregar el atributo disabled para campos multiselect, el valor se pierde
      $('#equipo_c').attr('disabled','disabled');
      $('#tipodeproducto_c').attr('disabled','disabled');
      $('#puestousuario_c').attr('disabled','disabled');
      $('#subpuesto_c').attr('disabled','disabled');
      $('#tct_team_address_txf_c').attr('disabled','disabled');
      //$('#productos_c').attr('disabled','disabled');
      $('#productos_c').attr('style','pointer-events:none'); //Se añade estilo , ya que al agregar el atributo disabled para campos multiselect, el valor se pierde
      $('#btn_clr_reports_to_name').attr('disabled','disabled');
      $('#btn_reports_to_name').attr('disabled','disabled');
      $('#reports_to_name').attr('disabled','disabled');

      $('#tct_altaproveedor_chk_c').attr('disabled','disabled');
      $('#tct_alta_cd_chk_c').attr('disabled','disabled');
      $('#optout_c').attr('disabled','disabled');
      $('#tct_alta_clientes_chk_c').attr('disabled','disabled');
      $('#cac_c').attr('disabled','disabled');
      $('#aut_caratulariesgo_c').attr('disabled','disabled');
      $('#tct_id_unics_txf_c').attr('disabled','disabled');
      $('#tct_id_uni2_txf_c').attr('disabled','disabled');
        $('#first_name').attr('disabled','disabled');
        $('#last_name').attr('disabled','disabled');
        $('#tct_alta_credito_simple_chk_c').attr('disabled','disabled');
        $('#tct_vetar_usuarios_chk_c').attr('disabled','disabled');

    }
   }
   catch(error){
      console.log(error.message);
   }
});

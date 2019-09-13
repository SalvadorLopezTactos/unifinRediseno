/**
 * Created by AF. Tactos
 * Date 2019/09/09
 */
({
    className: 'Gestion_Noticias_View',

    events:{
        'click .btnSave': 'saveChanges',
        'click .btnBorrar': 'limpiatxt',
        'click .btnSubir': 'guardaPDF'
    },

    loadData: function(options) {
        //Inicializa variables
        noticias = this;
        this.noticia_general = "";
        this.pdf = "";
        console.log('Carga info');
        //Api Call para recuperar información del archivo txt y mostrarlo en pantalla
        app.api.call('GET', app.api.buildURL('recuperaNoticia'), null, {
            success: _.bind(function (data) {
                    noticias.noticia_general= data.descripcion;
                    _.extend(this, noticias.noticia_general);
                    noticias.render();
                },this),
                error: function (e) {
            throw e;
        }
    });
        this.pdf = "";
    },

    saveChanges: function(){
        //Creacion de argumento para el API con el texto de la noticia
        var arguments = {
            "noticiaGeneral": this.$('#txtNoticia').val()
        }
        //Conficion para generar alert y llamado a api call
        if (arguments.noticiaGeneral!="") {
            app.alert.show("procesa_noticia_general", {
                level: "process",
                messages: 'Guardando...'
            });
            //Petición para guardar noticia en un .txt
            $('.btnSave').css("pointer-events", "none");
            var Url = app.api.buildURL("guardaNoticia", '', {}, {});
            app.api.call("create", Url, {data: arguments}, {
                success: _.bind(function (data) {
                    console.log("Guardo txt");
                    noticias.noticia_general = arguments.noticiaGeneral;

                    app.alert.dismiss('procesa_noticia_general');
                    app.alert.show('errorAlert', {
                        level: 'success',
                        messages: "Se ha actualizado la noticia correctamente.",
                        autoClose: true
                    });
                    $('.btnSave').css("pointer-events", "");

                },this),
                error:function(error){
                    $('#btn-success').prop('disabled',false);
                    app.alert.dismiss('ComentAlert');
                    app.alert.show('errorAlert', {
                        level: 'error',
                        messages: error,
                        autoClose: true
                    });
                    $('.btnSave').css("pointer-events", "");
                }
            });
        }else {
            app.alert.show("procesa_noticia_general", {
                level: "info",
                messages: 'No hay actualizaciones por guardar.'
            });
        }
    },

    limpiatxt: function(){
        //Funcion para poder eliminar el contenido de la noticia al actualizar
        app.alert.show("warning_informacion", {
            level: "confirmation",
            messages: '¿Desea eliminar el contenido de la noticia?',
            autoClose: false,
            onConfirm: function () {
                $('#txtNoticia').val("");
            },
            onCancel: function () {
                console.log("No se elimina info");
            }

        });
    },

    guardaPDF: async function(){
        //Funcion para guardar el pdf añadido
        if ($(".adjunto")[0].value!="" || $(".adjunto")[0].value!=null){
            //Obtener la URL del archivo cargado
            var file = document.querySelector('.adjunto').files[0];
            //Funcion carga que el archivo
            var reader = new FileReader();
            reader.readAsDataURL(file);
            //documentoB64 es igual al resultado de reader, se realiza encode de la data del pdf
            reader.onload = function () {documentoB64= reader.result;
                //Definir argumento de salida
                var archivopdf = {
                    "documento":documentoB64
                };

                var Url = app.api.buildURL("guardaNoticiaPDF", '', {}, {});
                app.api.call("create", Url, {data: archivopdf}, {
                    success: _.bind(function (data) {
                        console.log("SubePDF");
                        app.alert.show('subida_archivo_pdf', {
                            level: 'success',
                            messages: "Se ha cargado el archivo satisfactoriamente.",
                            autoClose: false
                        });
                        $('.btnSave').css("pointer-events", "");

                    },this),
                    error: function (e) {
                        throw e;
                    }
                });
            };
            reader.onerror = function (error) {
                console.log('Error: ', error);
                app.alert.show('error_archivo_pdf', {
                    level: 'error',
                    messages: "Ha habido un problema al cargar el archivo, intente de nuevo.",
                    autoClose: false
                });
            };
        }

    },

})

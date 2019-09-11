/**
 * Created by AF. Tactos
 * Date 2019/09/09
 */
({
    className: 'Gestion_Noticias_View',

    events:{
        'click .btnSave': 'saveChanges'

    },

    loadData: function(options) {
        //Inicializa variables
        this.noticia_general = "";
        this.pdf = "";
        console.log('Carga info');
        //Recupera información
        this.noticia_general = "Nuevo contenido..";
        this.pdf = "";
    },

    saveChanges: function(){
        //Guardar Noticia
        var noticiaGeneral = this.$('#txtNoticia').val();

        if (noticiaGeneral!="") {
            app.alert.show("procesa_noticia_general", {
                level: "process",
                messages: 'Guardando...'
            });
        }else {
            app.alert.show("procesa_noticia_general", {
                level: "info",
                messages: 'No hay actualizaciones por guardar.'
            });
        }

    },

})

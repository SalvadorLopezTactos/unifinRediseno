/**
 * Created by Levementum on 9/16/2016.
 * User: jgarcia@levementum.com
 */

(function (app) {
    app.events.on("app:init", function () {

        /**
         * get selected option
         */

        Handlebars.registerHelper('select', function( value, options ){
            var $el = $('<select />').html( options.fn(this) );
            $el.find('[value="' + value + '"]').attr({'selected':'selected'});
            return $el.html();
        });

        /**
         * Igual a
         */
        Handlebars.registerHelper('ifSelected', function(valuea, valueb) {
            if (valuea === valueb) {
                return 'Selected';
            } else {
                return '';
            }
        });

        /**
         * Contiene
         */
        Handlebars.registerHelper('ifMSelected', function(valuea, valueb) {
            var select = '';
            if (valueb !="" && valueb!="Array" && valueb != null) {
                var elementos= valueb.split(",");
                valuea = '^'+valuea+'^';

                elementos.forEach(function(element) {
                  if (element == valuea) {
                    select='Selected';
                  }
                });
            }
            return select;
        });

    });
})(SUGAR.App);

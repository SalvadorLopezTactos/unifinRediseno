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
         * Diferent like (Value)
         */
        Handlebars.registerHelper('ifSelected', function(valuea, valueb) {
            if (valuea === valueb) {
                //options.fn(this);
                return 'Selected';
            } else {
                //options.inverse(this);
                return '';
            }
        });

    });
})(SUGAR.App);

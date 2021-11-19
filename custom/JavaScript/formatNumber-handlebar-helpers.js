/**
 * Created by jgarcias@levementum.com on 7/29/2015.
 */
/**
 * Handlebars helpers.
 *
 * These functions are to be used in handlebars templates.
 * @class Handlebars.helpers
 * @singleton
 */
(function (app) {
    app.events.on("app:init", function () {

        /**
         * change a number's format
         */
        Handlebars.registerHelper("customFormatNumber", function (text) {
            if (text != '' && text != null) {
                var n = Number(text);
                if (n != 0 && n != '' && n != null) {
                    var str = n + '';
                    x = str.split('.');
                    x1 = x[0]; x2 = x.length > 1 ? '.' + x[1].substring(0,2) : '';
                    var rgx = /(\d+)(\d{3})/;
                    while (rgx.test(x1)) {
                        x1 = x1.replace(rgx, '$1' + ',' + '$2');
                    }
                    n = (x1 + x2);
                    return n;
                } else {
                    return null;
                }
            } else {
                return null;
            }
        });

        /**
         * Iterates through the Operacion Options
         *
         * The options collection is retrieved from the language helper.
         * @method getUnifinListValue
         * @param {String} unifin_list.
         * @param {String} unifin_field_key
         * @return {String} The Field Value.
         */
        Handlebars.registerHelper("getUnifinListValue", function (unifin_list, unifin_field_key) {
            var match = 'no-match';
            _.each(app.lang.getAppListStrings(unifin_list), function (value, key) {
                if (unifin_field_key == key) {
                    match = value;
                }
            });
            return match;
        });
    });
})(SUGAR.App);
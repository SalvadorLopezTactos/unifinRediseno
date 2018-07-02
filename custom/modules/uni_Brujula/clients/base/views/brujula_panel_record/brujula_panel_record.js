/**
 * Created by Levementum on 9/13/2016.
 * User: jgarcia@levementum.com
 */

({

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);

        App.events.on('data:sync:success',this.headerCSS, this);
    },

    _render: function() {
        this._super("_render");

        $("span.resultados").parent().parent().children().addClass("resultados");
        $("span.total").parent().parent().children().addClass("total")
        $(".total").parent().closest("td").html($(".total").html());
        $(".total").parent().children('td:first').html("");
        $("span.citas_field").parent().parent().children().attr('colspan',2);
    },

    headerCSS:function(){
        $('[data-name="assigned_user_name"]').css("width", "39%");
        $('.record-cell[data-name="assigned_user_name"]').css("margin-left", "9%");
    },
})


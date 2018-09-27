/**
 * Created by Levementum on 4/18/2017.
 * User: jgarcia@levementum.com
 */

({
    extendsFrom: 'FilterRowsView',
    initialize: function (opts) {
        this._super('initialize', [opts]);
    },

    openForm: _.debounce(function (filterModel) {
        $(".filter-header").show();

        var template = filterModel.get('filter_template') || filterModel.get('filter_definition');
        if (_.isEmpty(template)) {
            this.render();
            this.addRow();
        } else {
            this.populateFilter();
        }
        this.saveFilterEditState();
        app.shortcuts.register('Filter:Add', '+', function () {
            this.$('[data-action=add]').last().click();
        }, this);
        app.shortcuts.register('Filter:Remove', '-', function () {
            this.$('[data-action=remove]').last().click();
        }, this);
        if (this.moduleName == 'Accounts') {
            var filterName = this.context.editingFilter.get('name');
            if (filterName == 'Equipo Unifin') {
                $("[data-filter=field]").hide();
                $("[data-filter=operator]").hide();
                $(".filter-header").hide();
            }
            if (filterName == 'Mis Cuentas') {
                this.Test();
            }



        }
    }, 100, true),




    Test: _.debounce(function()  {


       /* var fila=this.$('div.filter-definition-container').find('.filter-body').eq(0);
        var hijos=fila.children();
        hijos.eq(0).attr('style', 'pointer-events:none');
        hijos.eq(1).attr('style', 'pointer-events:none');
        hijos.eq(2).attr('style', 'pointer-events:none');
        var actions=hijos.find('.filter-actions');
        actions.eq(0).children().eq(0).attr("style","pointer-events:none");
        $("input.inherit-width").attr('style', 'pointer-events:none');*/

        /*$("#s2id_autogen3").attr('style', 'pointer-events:none');
        $("#s2id_autogen5").attr('style', 'pointer-events:none');
        $("#s2id_autogen6").attr('style', 'pointer-events:none');
        $(".inherit-width").attr('style', 'pointer-events:none');*/

        //$('[data-name="assigned_user_name"]').find("*").prop("disabled", true);


        $('div.filter-definition-container').find('.filter-body').eq(0).find('.controls.span4').css("pointer-events", "none")
        $(".controls.span6").css("pointer-events", "none");
        $('div.filter-definition-container').find('.filter-body').eq(0).find('[data-action=remove]').hide();
        $("[data-action=filter-reset]").hide();
        $("[data-action=filter-delete]").hide();

        //this.saveFilterEditState();

    },400),


/*    populateRow: function (rowObj) {
        var $row = this.addRow(), moduleMeta = app.metadata.getModule(this.layout.currentModule),
            fieldMeta = moduleMeta.fields;
        _.each(rowObj, function (value, key) {
            var isPredefinedFilter = (this.fieldList[key] && this.fieldList[key].predefined_filter === true);
            if (key === "$or") {
                var keys = _.reduce(value, function (memo, obj) {
                    return memo.concat(_.keys(obj));
                }, []);
                key = _.find(_.keys(this.fieldList), function (key) {
                    if (_.has(this.fieldList[key], 'dbFields')) {
                        return _.isEqual(this.fieldList[key].dbFields.sort(), keys.sort());
                    }
                }, this);
                value = _.values(value[0])[0];
            } else if (!fieldMeta[key] && !isPredefinedFilter) {
                $row.remove();
                return;
            }
            if (!this.fieldList[key]) {
                var relate = _.find(this.fieldList, function (field) {
                    return field.id_name === key;
                });
                if (!relate) {
                    $row.remove();
                    return;
                }
                key = relate.name;
            }

            $row.find('[data-filter=field] input[type=hidden]').select2('val', key).trigger('change');
            if (_.isString(value) || _.isNumber(value)) {
                value = {"$equals": value};
            }
            _.each(value, function (value, operator) {
                $row.data('value', value);
                $row.find('[data-filter=operator] input[type=hidden]').select2('val', operator === '$dateRange' ? value : operator).trigger('change');
            });
        }, this);

        if (this.moduleName == 'Accounts') {
            $(".filter-header").show();
            var filterName = this.context.editingFilter.get('name');
            if (filterName == 'Equipo Unifin') {

                $row.find('[data-filter=field] input[type=hidden]').select2('val', 'unifin_team').trigger('change');

                $row.find('[data-filter=operator] input[type=hidden]').select2('val', '$in').trigger('change');
                this.custom_hideOperator($row);
            }
        }
    },

    custom_hideOperator: function($row) {
        $($row.find('[data-filter=value]')).show();
        $($row.find('[data-filter=value]')[0].previousElementSibling).hide();
        $($row.find('[data-filter=value]')[0].nextElementSibling).hide();
        $($row.find('[data-filter=field]')).hide();
        $(".filter-header").hide();
    },*/
})

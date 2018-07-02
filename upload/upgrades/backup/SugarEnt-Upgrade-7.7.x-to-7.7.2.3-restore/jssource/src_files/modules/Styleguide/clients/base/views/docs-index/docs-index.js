/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    className: 'container-fluid',
    section_description: '',
    section_key: '',

    /* RENDER index page
    *******************/
    _renderHtml: function() {
        var self = this,
            i = 0,
            html = '',
            request = this.context.attributes.request;

        this._super('_renderHtml');

        this.section_key = request.keys[1];

        function fmtLink(s, p) {
            return '#Styleguide/docs/' +
                (p ? '' : 'index-') +
                s.replace(/[\s\,]+/g,'-').toLowerCase() +
                (p ? '-' + p : '');
        }

        if (request.keys.length === 1) {

            // home index call
            $.each(request.page_data, function (kS, vS) {
                if (!vS.index) {
                    return;
                }

                html += (i % 3 === 0 ? '<div class="row-fluid">' : '');
                html += '<div class="span4"><h3>' +
                    '<a class="section-link" href="' +
                    (vS.url ? vS.url : fmtLink(kS)) + '">' +
                    vS.title + '</a></h3><p>' + vS.description + '</p><ul>';
                if (vS.pages) {
                    $.each(vS.pages, function (kP, vP) {
                        html += '<li ><a class="section-link" href="' +
                            (vP.url ? vP.url : fmtLink(kS, kP)) + '">' +
                            vP.label + '</a></li>';
                    });
                }
                html += '</ul></div>';
                html += (i % 3 === 2 ? '</div>' : '');

                i += 1;
            });

            this.section_description = request.page_data[request.keys[0]].description;

        } else {

            // section index call
            $.each(request.page_data[this.section_key].pages, function (kP, vP) {
                html += (i % 4 === 0 ? '<div class="row-fluid">' : '');
                html += '<div class="span3"><h3>' +
                    (!vP.items ?
                        ('<a class="section-link" href="' + (vP.url ? vP.url : fmtLink(self.section_key, kP)) + '">' + vP.label + '</a>') :
                        vP.label
                    ) +
                    '</h3><p>' + vP.description;
                // if (vS.items) {
                //     l = vS.items.length-1;
                //     $.each(d.items, function (kP,vP) {
                //         m += ' <a class="section-link" href="'+ (vP.url ? vP.url : fmtLink(kS,kP)) +'">'+ d2 +'</a>'+ (j===l?'.':', ');
                //     });
                // }
                html += '</p></div>';
                html += (i % 4 === 3 ? '</div>' : '');

                i += 1;
            });

            this.section_description = request.page_data[request.keys[1]].description;
        }

        this.$('#index_content').append('<section id="section-menu"></section>').html(html);
    }
})

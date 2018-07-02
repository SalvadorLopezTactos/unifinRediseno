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
(function (app) {
    app.events.on('app:init', function () {
        app.plugins.register('DragdropAttachments', ['view'], {
            events: {
                'dragenter .attachable': 'expandNewPost',
                'dragover .attachable': 'dragoverNewPost',
                'dragleave .attachable': 'shrinkNewPost',
                'drop .attachable': 'dropAttachment'
            },

            expandNewPost: function(event) {
                this.$(event.currentTarget).addClass('dragdrop');
                return false;
            },

            dragoverNewPost: function(event) {
                return false;
            },

            shrinkNewPost: function(event) {
                event.stopPropagation();
                event.preventDefault();
                this.$(event.currentTarget).removeClass('dragdrop');
                return false;
            },

            dropAttachment: function(event) {
                var text = $.trim(event.dataTransfer.getData('text')),
                    container = this.$(event.currentTarget);
                this.shrinkNewPost(event);

                if (text.length) {
                    container.append(' ' + text).trigger('change');
                }

                _.each(event.dataTransfer.files, function(file, i) {
                    var fileReader = new FileReader();

                    // Set up the callback for the FileReader.
                    fileReader.onload = (function(file, view) {
                        return function(e) {
                            var container,
                                sizes = ['B', 'KB', 'MB', 'GB'],
                                size_index = 0,
                                size = file.size,
                                unique = _.uniqueId('activitystream_attachment');

                            while (size > 1024 && size_index < sizes.length - 1) {
                                size_index++;
                                size /= 1024;
                            }

                            size = Math.round(size);

                            view.dragdrop_attachments = view.dragdrop_attachments || {};
                            view.dragdrop_attachments[unique] = file;
                            container = $("<div class='activitystream-pending-attachment' id='" + unique + "'></div>");

                            // TODO: Review creation of inline HTML
                            var $close = $('<a class="close">&times;</a>');
                            $close.on('click', function(e) {
                                container.trigger('close');
                            }).appendTo(container);
                            app.accessibility.run($close, 'click');

                            container.append(file.name + ' (' + size + ' ' + sizes[size_index] + ')');

                            if (file.type.indexOf('image/') !== -1) {
                                container.append("<img style='display:block;' src='" + e.target.result + "' />");
                            } else {
                                container.append('<div>No preview available</div>');
                            }

                            container.appendTo(view.$(event.currentTarget).parent());
                            container.on('close', function() {
                                $(this).remove();
                                delete view.dragdrop_attachments[container.attr('id')];
                                view.trigger('attachments:remove');
                            });

                            view.trigger('attachments:add');
                        };
                    })(file, this);

                    fileReader.readAsDataURL(file);
                }, this);

                event.stopPropagation();
                event.preventDefault();
            },

            getAttachments: function() {
                return this.dragdrop_attachments || {};
            },

            clearAttachments: function() {
                this.$('.activitystream-pending-attachment').trigger('close');
                this.dragdrop_attachments = {};
            },

            onAttach: function(component, plugin) {
                component.on('render', function() {
                    this.$('.attachable').attr('dropzone', 'copy');
                });

                component.on('attachments:process', function() {
                    var self = this,
                        attachments = this.getAttachments(),
                        callback = _.after(_.size(attachments), this.clearAttachments),
                        parentId = self.context.parent.get('model').id,
                        parentType = self.context.parent.get('model').module,
                        additionalNoteAttr = this._mapNoteParentAttributes(parentId, parentType);

                    component.trigger('attachments:start');

                    _.each(attachments, function(file) {
                        var note = app.data.createBean('Notes');
                        note.set(_.extend({
                            'name': file.name,
                            'assigned_user_id': app.user.id
                        }, additionalNoteAttr));
                        async.waterfall([
                            //save the note
                            function(callback) {
                                note.save(null, {
                                    success: function(noteModel) {
                                        callback(null, noteModel);
                                    }
                                });
                            },
                            //then upload the file attached to the note
                            function(note, callback) {
                                var data = new FormData(),
                                url = app.api.buildFileURL({
                                    module: note.module,
                                    id: note.id,
                                    field: 'filename'
                                });

                                data.append('filename', file);
                                data.append('OAuth-Token', app.api.getOAuthToken());
                                $.ajax({
                                    url: url,
                                    type: 'POST',
                                    data: data,
                                    processData: false,
                                    contentType: false
                                }).then(function() {
                                    callback(null);
                                });
                            },
                            //then create the 'attach' type activity
                            function(callback) {
                                var activity = app.data.createBean('Activities'),
                                    payload = {
                                        activity_type: 'attach',
                                        parent_id: parentId || null,
                                        parent_type: parentType || null,
                                        data: {
                                            noteId: note.id,
                                            filename: file.name,
                                            mimetype: file.type,
                                            size: file.size
                                        }
                                    };

                                activity.save(payload, {
                                    success: function(activityModel) {
                                        self.collection.add(activityModel);
                                        callback(null, activityModel);
                                    }
                                });
                            }
                        ], function(err, activity) {
                            component.trigger('attachments:end');
                            if (err) {
                                var errorMessage = app.lang.getAppString('LBL_EMAIL_ATTACHMENT_UPLOAD_FAILED');
                                app.alert.show('upload_error', errorMessage);
                            } else {
                                self.context.reloadData({recursive: false});
                                self.clearAttachments.call(self);
                            }
                        });
                    });
                });
            },

            /**
             * Map parentId and parentType into note attributes
             * Do nothing if parentId or parentType are empty
             *
             * @param {string} parentId id of the parent (null if no parent)
             * @param {string} parentType module of the parent record
             * @private
             */
            _mapNoteParentAttributes: function(parentId, parentType) {
                if (parentId && parentType) {
                    return parentType === 'Contacts' ? {
                        'parent_id': parentId,
                        'parent_type': parentType,
                        'contact_id': parentId
                    } : {
                        'parent_id': parentId,
                        'parent_type': parentType
                    };
                } else {
                    return {};
                }
            }
        });
    });
})(SUGAR.App);

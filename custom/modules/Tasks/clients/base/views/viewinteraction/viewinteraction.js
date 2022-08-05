/**
	 * @class View.Views.Base.QuickCreateView
	 * @alias SUGAR.App.view.views.BaseQuickCreateView
	 * @extends View.Views.Base.BaseeditmodalView
	 */
({
    extendsFrom:'BaseeditmodalView',
    fallbackFieldTemplate: 'edit',
	  initialize: function(options) {
		app.view.View.prototype.initialize.call(this, options);
  		if (this.layout) {
  			this.layout.on('app:view:viewinteraction', function() {
  				this.render();
				console.log("After call render function");
  				this.$('.modal').modal({
  					backdrop: 'static'
  				});
  				this.$('.modal').modal('show');
				
				var model = this.context.get('model');
				if (model)
				{	
					var callBacks = {};
					callBacks.success = function(data)
					{
						console.log("Call read with success");	
						console.log("data:" , data);

						console.log("interactionID:" + data.records[0].iws_interactionid_c);	
						console.log("medianame:" + data.records[0].iws_medianame_c);
						var iframe = $("#iwsIframe");
						
						if (iframe && iframe.length == 1)
						{
						    console.log("iframe found");
						    var url = "";
						    if (window.SoftPhone_WebAppUrl) {
						        console.log("SoftPhone_WebAppUrl setting found : ");
						        url = window.SoftPhone_WebAppUrl + "?id=" + data.records[0].iws_interactionid_c + "&mediatype=" + data.records[0].iws_medianame_c + "&env=" + window.SoftPhone_PureCloudEnvironment;
						    } else {
						        console.log("SoftPhone_WebAppUrl setting not found");
						        url = "http://genesys:8025/webixnmgr/ixn?id=" + data.records[0].iws_interactionid_c + "&mediatype=" + data.records[0].iws_medianame_c;
						    }

						    console.log("iframe url: " + url);
						    iframe.attr('src', url)
						} else {
						    console.log("iframe not found");
						}
					}
					callBacks.error = function(error)
					{	
						console.error("Error during call creation: " + error);
					}	
					 
					SUGAR.App.api.records("read", "Tasks", {},{ "filter[0][id][$equals]": model.get('id'), "fields":"iws_interactionid_c,iws_medianame_c", max_num: 1},callBacks);
				}
  				app.$contentEl.attr('aria-hidden', true);
  				$('.modal-backdrop').insertAfter($('.modal'));
  			  
  			}, this);
  		}
		this._disposeView();
	  },
	
    	/**Custom method to dispose the view*/
  	_disposeView:function(){
		console.log("_disposeView called");
  		/**Find the index of the view in the components list of the layout*/
  		var index = _.indexOf(this.layout._components,_.findWhere(this.layout._components,{name:'viewinteraction'}));
  		if(index > -1){
  			/** dispose the view so that the evnets, context elements etc created by it will be released*/
  			this.layout._components[index].dispose(); 
  			/**remove the view from the components list**/
  			this.layout._components.splice(index, 1); 
  		}
  	},
  })
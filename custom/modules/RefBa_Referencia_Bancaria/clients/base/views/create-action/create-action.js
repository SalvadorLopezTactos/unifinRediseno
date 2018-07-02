({
    extendsFrom: 'CreateActionsView',
    initialize: function (options) {
        this._super('initialize', [options]);
        //add validation
        this.model.addValidationTask('fechaapertura', _.bind(this.doValidateDate, this));
    },
    
    /* add validation for delivery date */
   doValidateDate: function(fields, errors, callback) {
   
        console.log('doValidateDate is called');
           	
        /* if  date not empty, then check with today date and return error */   
        if (!_.isEmpty(this.model.get('fechaapertura'))) {
            
        	var opening_date = new Date(this.model.get('fechaapertura'));
        	var today_date = new Date();
        
        	if(opening_date > today_date){
        	   
        	    console.log('La fecha no puede ser mayor al día de hoy');
        
                //errors['fechaapertura'] = errors['fechaapertura'] || {};
               errors['fechaapertura'] = 'La fecha de apertura no puede ser posterior al día de hoy' || {};                
               errors['fechaapertura'].required = true;
            }
        }
        callback(null, fields, errors);
    },
}) 

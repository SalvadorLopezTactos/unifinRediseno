({
    extendsFrom: 'RecordView',
    initialize: function (options) {
        this._super('initialize', [options]);
        //add validation
        this.model.addValidationTask('fechaapertura', _.bind(this.doValidateDate, this));
    },
    
    /* add validation for opening date */
   doValidateDate: function(fields, errors, callback) {
   
        console.log('doValidateDate is called');
           	
        /* if delivery date not empty, then check with shiping date and return error */   
        if (!_.isEmpty(this.model.get('fechaapertura'))) {
            
        	var opening_date = new Date(this.model.get('fechaapertura'));
        	var today_date = new Date();
        
        	if(opening_date > today_date){
        	   
        	    console.log('La fecha no puede ser mayor al día de hoy' + today_date);
        
                errors['fechaapertura'] = errors['fechaapertura'] || {};
                errors['fechaapertura'].required = true;
            }
        }
        callback(null, fields, errors);
    },
}) 

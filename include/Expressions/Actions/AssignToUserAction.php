<?php
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
require_once("include/Expressions/Actions/AbstractAction.php");

class AssignToUserAction extends AbstractAction{
	protected $expression =  "";

    /**
     * array Array of actions on which the Expression Action is not allowed
     */
    protected $disallowedActions = array('view');

	function AssignToAction($params) {
		$this->expression = str_replace("\n", "",$params['value']);
	}

	/**
	 * Returns the javascript class equavalent to this php class
	 *
	 * @return string javascript.
	 */
	static function getJavascriptClass() {
		return  "
		SUGAR.forms.AssignToUserAction = function(valExpr) {
			//If we are running in sidecar, this action will not function
			if(SUGAR.App) return;
			this.expr = valExpr;
			this.target = 'assigned_user_name';
			this.dataSource = new YAHOO.util.DataSource('index.php?', {
        		responseType: YAHOO.util.XHRDataSource.TYPE_JSON,
        		responseSchema: {
                    resultsList: 'fields',
                    total: 'totalCount',
                    metaNode: 'fields',
                    metaFields: {total: 'totalCount', fields:'fields'}
        		},
        		connMethodPost: true
            });
		};
		SUGAR.util.extend(SUGAR.forms.AssignToUserAction, SUGAR.forms.AbstractAction, {
			exec : function(context)
			{
				//If we are running in sidecar, this action will not function
                if(SUGAR.App) return;

				if (typeof(context) == 'undefined')
                    context = this.context;
				var userName = this.evalExpression(this.expr, context);
				var params = SUGAR.util.paramsToUrl({
                    to_pdf: 'true',
                    module: 'Home',
                    action: 'quicksearchQuery',
                    data: YAHOO.lang.JSON.stringify(sqs_objects['EditView_' + this.target]),
                    query: userName
                });
                this.sqs = sqs_objects['EditView_' + this.target];
				this.dataSource.sendRequest(params, {
	                	success:function(param, resp){
	                		if(resp.results.length > 0)
	                		{
	                			var match = resp.results[0];
	                			for (var i = 0; i < this.sqs.field_list.length; i++)
	                			{
	                				SUGAR.forms.AssignmentHandler.assign(this.sqs.populate_list[i], match[this.sqs.field_list[i]]);
	                			}
	                		}
						},
	                	scope:this
					});
			},
			targetUrl:'index.php?module=Home&action=TaxRate&to_pdf=1'
		});";
	}

	/**
	 * Returns the javascript code to generate this actions equivalent.
	 *
	 * @return string javascript.
	 */
	function getJavascriptFire() {
		return  "new SUGAR.forms.AssignToUserAction('{$this->expression}')";
	}



	/**
	 * Applies the Action to the target.
	 *
	 * @param SugarBean $target
	 */
	function fire(&$target) {
        require_once ('modules/Home/quicksearchQuery.php');
        require_once ('include/QuickSearchDefaults.php');
        $json = getJSONobj();
        $userName = Parser::evaluate($this.expr, $target).evaluate();
        $qsd = QuickSearchDefaults::getQuickSearchDefaults();
        $data = $qsd->getQSUser();
        $data['modules'] = array("Users");
        $data['conditions'][0]['value'] = $userName;
        $qs = new quicksearchQuery();
        $result = $qs->query($data);
		$resultBean = $json->decodeReal($result);
        print_r($resultBean);

    }

	/**
	 * Returns the definition of this action in array format.
	 *
	 */
	function getDefinition() {
		return array(
			"action" => $this->getActionName(),
	        "value" => $this->expression,
	    );
	}

	static function getActionName() {
		return "AssignTo";
	}
}

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
require_once('include/Expressions/Expression/Date/DateExpression.php');
/**
 * <b>maxRelatedDate(Relate <i>link</i>, String <i>field</i>)</b><br>
 * Returns the highest value of <i>field</i> in records related by <i>link</i><br/>
 * ex: <i>maxRelatedDate($products, "date_closed_timestamp")</i> in Opportunities would return the <br/>
 * latest date_closed_timestamp of all related Revenue Line Items.
 */

class MaxRelatedDateExpression extends DateExpression
{
    
    /**
     * Returns the opreation name that this Expression should be
     * called by.
     */
    public static function getOperationName() {
        return array("maxRelatedDate");
    }
    
    public function evaluate() {
        $params = $this->getParameters();
        //This should be of relate type, which means an array of SugarBean objects
        $linkField = $params[0]->evaluate();
        $relfield = $params[1]->evaluate();
        $ret = 0;
        $isTimestamp = true;
        
        //if the field or relationship isn't defined, bail
        if (!is_array($linkField) || empty($linkField)) {
           return $ret; 
        }           
                        
        foreach ($linkField as $bean) {
            // we have to use the fetched_row as it's still in db format
            // where as the $bean->$relfield is formatted into the users format.
            if (isset($bean->fetched_row[$relfield])) {
                $value = $bean->fetched_row[$relfield];
            } elseif (isset($bean->$relfield)) {
                if (is_int($bean->$relfield)) {
                    // if we have a timestamp field, just set the value
                    $value = $bean->relfield;
                } else {
                    // more than likely this is a date field, so try and un-format based on the users preferences
                    $td = TimeDate::getInstance();
                    // we pass false to asDbDate as we want the value that would be stored in the DB
                    $value = $td->fromString($bean->$relfield)->asDbDate(false);
                }
            } else {
                continue;
            }

            //if it isn't a timestamp, mark the flag as such and convert it for comparison
            if (!is_int($value)) {
                $isTimestamp = false;
                $value = strtotime($value);
            }

            //compare
            if ($ret < $value) {
                $ret = $value;
            }
        }
        
        //if nothing was done, return an empty string
        if ($ret == 0 && $isTimestamp) {            
            return "";   
        }
        
        //return the timestamp if the field started off that way
        if ($isTimestamp) {
            return $ret;
        } 
        
        //convert the timestamp to a date and return
        $date = new DateTime();
        $date->setTimestamp($ret);
   
        return $date->format("Y-m-d");
    }
    
    //todo: javascript version here
    /**
     * Returns the JS Equivalent of the evaluate function.
     */
    public static function getJSEvaluate() 
    {
        return "";
    }

    /**
     * The first parameter is a link and the second is a string.
     */
    public static function getParameterTypes()
    {
    	return array(AbstractExpression::$RELATE_TYPE, AbstractExpression::$STRING_TYPE);
    }
}

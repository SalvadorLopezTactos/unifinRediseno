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
var AdamArtifactResizeBehavior=function(){};AdamArtifactResizeBehavior.prototype=new jCore.RegularResizeBehavior();AdamArtifactResizeBehavior.prototype.type="AdamArtifactResizeBehavior";AdamArtifactResizeBehavior.prototype.onResizeStart=function(shape){return jCore.RegularResizeBehavior.prototype.onResizeStart.call(this,shape);};AdamArtifactResizeBehavior.prototype.onResize=function(shape){return function(e,ui){jCore.RegularResizeBehavior.prototype.onResize.call(this,shape)(e,ui);};};
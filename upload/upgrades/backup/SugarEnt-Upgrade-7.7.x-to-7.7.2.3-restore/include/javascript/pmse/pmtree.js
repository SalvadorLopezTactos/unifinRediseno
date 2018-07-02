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
(function($){var div=null;var methods={init:function(options){var settings={container:$(this),id:'root'};return this.each(function(){if(options){settings=$.extend(settings,options);}
var div=settings.container;div.append($('<div>').addClass("content_tree"));var root=$('<ul>').attr({'class':'tree-menu',id:settings.id});$('.content_tree').append(root);var tree=settings.items;if(typeof tree!='undefined'&&tree!==null)
createTree(root,tree);if(!options.collapsed){$('#'+settings.id+' ul').each(function(){$(this).css("display","none");});}
$('#'+settings.id+' .category').click(function(){var childid="#"+$(this).attr("childid");if($(childid).css("display")=="none"){$(childid).css("display","block");}else{$(childid).css("display","none");}
if($(this).hasClass("tree_cat_close")){$(this).removeClass("tree_cat_close").addClass("tree_cat_open");}else{$(this).removeClass("tree_cat_open").addClass("tree_cat_close");}});$('.treechild').hover(function(){if($(this).attr("status")=="unmarked"){var id="#"+$(this).attr("id");$(id).css("background","#EFF5FB");}},function(){if($(this).attr("status")=="unmarked"){var id="#"+$(this).attr("id");$(id).css("background","#fff");}});$(".details").click(function(){var id="#"+$(this).attr("desc");$(".treechild").attr("status","unmarked");$(".treechild").css("background","#fff");$(id).css("background","#CEE3F6");$(id).attr("status","marked");var oShape={};if($(this).attr("uid")!==undefined)
oShape.uid=$(this).attr("uid");if($(this).attr("name")!==undefined)
oShape.name=$(this).attr("name");if($(this).attr("type")!==undefined)
oShape.type=$(this).attr("type");if(typeof settings.select!=='undefined'&&settings.select!==null){settings.select.call(this,oShape);}});$('.treechild > a ').css({'text-decoration':'none'});});},example:function(a,b){}};$.fn.pmtree=function(method){if(methods[method]){return methods[method].apply(this,Array.prototype.slice.call(arguments,1));}else if(typeof method==='object'||!method){return methods.init.apply(this,arguments);}else{$.error('Method '+method+' does not exsts!');}
return true;};function createTree(root,tree){var html='';for(var i=0;i<tree.length;i++){var li=$('<li>');html=$('<div>').addClass('treechild').attr({id:i,status:'unmarked'}).css({'cursor':'pointer','text-decoration':'none'});html.append($('<a>').addClass('tree_cat_close category').attr({childid:'c_'+i}).html('&nbsp;&nbsp;&nbsp'));if(typeof tree[i].icon!=='undefined'&&tree[i].icon!==null){html.append('<a desc="'+i+'" class="details" name="'+tree[i].name+'" uid="'+tree[i].id+'" type="'+tree[i].type+'"><i class="'+tree[i].icon+'"></i> '+tree[i].name+'</a>');}
else
html.append('<a desc="'+i+'" class="details" name="'+tree[i].name+'" uid="'+tree[i].id+'" type="'+tree[i].type+'"><i class="tree-folder-open"></i> '+tree[i].name+'</a>');li.append(html);if(typeof tree[i].items!="undefined"&&tree[i].items!==null){li.append(addNodes(tree[i].items,'c_'+i));}
root.append(li);}}
function addNodes(node,childid){var html='';html+='<ul id="'+childid+'">';for(var i=0;i<node.length;i++){html+='<li>';if(typeof node[i].items!="undefined"&&node[i].items!==null){html+='<div class="treechild" id="'+childid+'_'+i+'" status="unmarked" style="cursor:pointer; text-decoration:none;"><a childid = "c_'+childid+'_'+i+'"+ class="tree_cat_close category">&nbsp;&nbsp;&nbsp;</a>';if(node[i].icon!='undefined'&&node[i].icon!==null)
html+='<a desc="'+childid+'_'+i+'" class="details" name="'+node[i].name+'" uid="'+node[i].id+'" type="'+node[i].type+'"><i class="'+node[i].icon+'"></i> '+node[i].name+'</a>';else
html+='<a desc="'+childid+'_'+i+'" class="details" name="'+node[i].name+'" uid="'+node[i].id+'" type="'+node[i].type+'"><i class="tree-folder-open"></i> '+node[i].name+'</a>';html+='</div>';html+=addNodes(node[i].items,'c_'+childid+'_'+i);}else{html+='<div class="treechild" id="'+childid+'_'+i+'" status="unmarked" style="cursor:pointer; text-decoration:none;"><a class="product">&nbsp;&nbsp;&nbsp;</a>';if(typeof node[i].icon!='undefined'&&node[i].icon!==null)
html+='<a desc="'+childid+'_'+i+'" class="details" name="'+node[i].name+'" uid="'+node[i].id+'" type="'+node[i].type+'"><i class="'+node[i].icon+'"></i> '+node[i].name+'</a>';else
html+='<a desc="'+childid+'_'+i+'" class="details" name="'+node[i].name+'" uid="'+node[i].id+'" type="'+node[i].type+'"><i class="tree-folder-open"></i> '+node[i].name+'</a>';html+='</div>';}
html+='</li>';}
html+='</ul>';return html;}})(jQuery);
/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('tree-sortable',function(Y,NAME){var EVT_SORT='sort';function Sortable(){}
Sortable.prototype={sortReverse:false,initializer:function(config){this.nodeExtensions=this.nodeExtensions.concat(Y.Tree.Node.Sortable);if(config){if(config.sortComparator){this.sortComparator=config.sortComparator;}
if('sortReverse'in config){this.sortReverse=config.sortReverse;}}},sort:function(options){return this.sortNode(this.rootNode,Y.merge(options,{deep:true}));},sortComparator:function(node){return node.index();},sortNode:function(node,options){if(!node.children.length){return this;}
options||(options={});if(options.deep){options=Y.merge(options,{deep:false});var self=this;this.traverseNode(node,function(nodeToSort){self.sortNode(nodeToSort,options);});return this;}
var comparator=this._getSortComparator(node,options),reverse;if('sortReverse'in options){reverse=node.sortReverse=options.sortReverse;}else if('sortReverse'in node){reverse=node.sortReverse;}else{reverse=this.sortReverse;}
node.children.sort(Y.rbind(this._sort,this,comparator,reverse));node._isIndexStale=true;if(!options.silent){this.fire(EVT_SORT,{node:node,reverse:!!reverse,src:options.src});}
return this;},_compare:function(a,b){return a<b?-1:(a>b?1:0);},_compareReverse:function(a,b){return b<a?-1:(b>a?1:0);},_getDefaultNodeIndex:function(parent,node){var children=parent.children,comparator=this._getSortComparator(parent),max=children.length,min=0,reverse='sortReverse'in parent?parent.sortReverse:this.sortReverse;if(!max){return max;}
if(comparator._unboundComparator===Sortable.prototype.sortComparator){return reverse?0:max;}
var compare=reverse?this._compareReverse:this._compare,needle=comparator(node);var middle;while(min<max){middle=(min+max)>>1;if(compare(comparator(children[middle]),needle)<0){min=middle+1;}else{max=middle;}}
return min;},_getSortComparator:function(node,options){var boundComparator,comparator,thisObj;if(options&&options.sortComparator){comparator=node.sortComparator=options.sortComparator;}else if(node.sortComparator){comparator=node.sortComparator;thisObj=node;}else{comparator=this.sortComparator;thisObj=this;}
boundComparator=function(){return comparator.apply(thisObj,arguments);};boundComparator._unboundComparator=comparator;return boundComparator;},_sort:function(a,b,comparator,reverse){return this[reverse?'_compareReverse':'_compare'](comparator(a),comparator(b));}};Y.Tree.Sortable=Sortable;function NodeSortable(){}
NodeSortable.prototype={sort:function(options){this.tree.sortNode(this,options);return this;}};Y.Tree.Node.Sortable=NodeSortable;},'3.15.0',{"requires":["tree"]});
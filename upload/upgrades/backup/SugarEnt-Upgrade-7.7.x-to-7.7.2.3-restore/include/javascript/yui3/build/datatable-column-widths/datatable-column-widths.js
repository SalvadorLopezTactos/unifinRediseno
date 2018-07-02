/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('datatable-column-widths',function(Y,NAME){var isNumber=Y.Lang.isNumber,arrayIndex=Y.Array.indexOf;Y.Features.add('table','badColWidth',{test:function(){var body=Y.one('body'),node,broken;if(body){node=body.insertBefore('<table style="position:absolute;visibility:hidden;border:0 none">'+'<colgroup><col style="width:9px"></colgroup>'+'<tbody><tr>'+'<td style="'+'padding:0 4px;'+'font:normal 2px/2px arial;'+'border:0 none">'+'.'+'</td></tr></tbody>'+'</table>',body.get('firstChild'));broken=node.one('td').getComputedStyle('width')!=='1px';node.remove(true);}
return broken;}});function ColumnWidths(){}
Y.mix(ColumnWidths.prototype,{COL_TEMPLATE:'<col/>',COLGROUP_TEMPLATE:'<colgroup/>',setColumnWidth:function(id,width){var col=this.getColumn(id),index=col&&arrayIndex(this._displayColumns,col);if(index>-1){if(isNumber(width)){width+='px';}
col.width=width;this._setColumnWidth(index,width);}
return this;},_createColumnGroup:function(){return Y.Node.create(this.COLGROUP_TEMPLATE);},initializer:function(){this.after(['renderView','columnsChange'],this._uiSetColumnWidths);},_setColumnWidth:function(colIndex,width){var colgroup=this._colgroupNode,col=colgroup&&colgroup.all('col').item(colIndex),cell,getCStyle;if(col){if(width&&isNumber(width)){width+='px';}
col.setStyle('width',width);if(width&&Y.Features.test('table','badColWidth')){cell=this.getCell([0,colIndex]);if(cell){getCStyle=function(prop){return parseInt(cell.getComputedStyle(prop),10)||0;};col.setStyle('width',parseInt(width,10)-
getCStyle('paddingLeft')-
getCStyle('paddingRight')-
getCStyle('borderLeftWidth')-
getCStyle('borderRightWidth')+'px');}}}},_uiSetColumnWidths:function(){if(!this.view){return;}
var template=this.COL_TEMPLATE,colgroup=this._colgroupNode,columns=this._displayColumns,i,len;if(!colgroup){colgroup=this._colgroupNode=this._createColumnGroup();this._tableNode.insertBefore(colgroup,this._tableNode.one('> thead, > tfoot, > tbody'));}else{colgroup.empty();}
for(i=0,len=columns.length;i<len;++i){colgroup.append(template);this._setColumnWidth(i,columns[i].width);}}},true);Y.DataTable.ColumnWidths=ColumnWidths;Y.Base.mix(Y.DataTable,[ColumnWidths]);},'3.15.0',{"requires":["datatable-base"]});
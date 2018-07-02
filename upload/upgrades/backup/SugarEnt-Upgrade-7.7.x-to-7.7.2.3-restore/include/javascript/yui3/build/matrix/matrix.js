/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('matrix',function(Y,NAME){var MatrixUtil={_rounder:100000,_round:function(val){val=Math.round(val*MatrixUtil._rounder)/ MatrixUtil._rounder;return val;},rad2deg:function(rad){var deg=rad*(180 / Math.PI);return deg;},deg2rad:function(deg){var rad=deg*(Math.PI / 180);return rad;},angle2rad:function(val){if(typeof val==='string'&&val.indexOf('rad')>-1){val=parseFloat(val);}else{val=MatrixUtil.deg2rad(parseFloat(val));}
return val;},convertTransformToArray:function(matrix)
{var matrixArray=[[matrix.a,matrix.c,matrix.dx],[matrix.b,matrix.d,matrix.dy],[0,0,1]];return matrixArray;},getDeterminant:function(matrix)
{var determinant=0,len=matrix.length,i=0,multiplier;if(len==2)
{return matrix[0][0]*matrix[1][1]-matrix[0][1]*matrix[1][0];}
for(;i<len;++i)
{multiplier=matrix[i][0];if(i%2===0||i===0)
{determinant+=multiplier*MatrixUtil.getDeterminant(MatrixUtil.getMinors(matrix,i,0));}
else
{determinant-=multiplier*MatrixUtil.getDeterminant(MatrixUtil.getMinors(matrix,i,0));}}
return determinant;},inverse:function(matrix)
{var determinant=0,len=matrix.length,i=0,j,inverse,adjunct=[],minor=[];if(len===2)
{determinant=matrix[0][0]*matrix[1][1]-matrix[0][1]*matrix[1][0];inverse=[[matrix[1][1]*determinant,-matrix[1][0]*determinant],[-matrix[0][1]*determinant,matrix[0][0]*determinant]];}
else
{determinant=MatrixUtil.getDeterminant(matrix);for(;i<len;++i)
{adjunct[i]=[];for(j=0;j<len;++j)
{minor=MatrixUtil.getMinors(matrix,j,i);adjunct[i][j]=MatrixUtil.getDeterminant(minor);if((i+j)%2!==0&&(i+j)!==0)
{adjunct[i][j]*=-1;}}}
inverse=MatrixUtil.scalarMultiply(adjunct,1/determinant);}
return inverse;},scalarMultiply:function(matrix,multiplier)
{var i=0,j,len=matrix.length;for(;i<len;++i)
{for(j=0;j<len;++j)
{matrix[i][j]=MatrixUtil._round(matrix[i][j]*multiplier);}}
return matrix;},transpose:function(matrix)
{var len=matrix.length,i=0,j=0,transpose=[];for(;i<len;++i)
{transpose[i]=[];for(j=0;j<len;++j)
{transpose[i].push(matrix[j][i]);}}
return transpose;},getMinors:function(matrix,columnIndex,rowIndex)
{var minors=[],len=matrix.length,i=0,j,column;for(;i<len;++i)
{if(i!==columnIndex)
{column=[];for(j=0;j<len;++j)
{if(j!==rowIndex)
{column.push(matrix[i][j]);}}
minors.push(column);}}
return minors;},sign:function(val)
{return val===0?1:val/Math.abs(val);},vectorMatrixProduct:function(vector,matrix)
{var i,j,len=vector.length,product=[],rowProduct;for(i=0;i<len;++i)
{rowProduct=0;for(j=0;j<len;++j)
{rowProduct+=vector[i]*matrix[i][j];}
product[i]=rowProduct;}
return product;},decompose:function(matrix)
{var a=parseFloat(matrix[0][0]),b=parseFloat(matrix[1][0]),c=parseFloat(matrix[0][1]),d=parseFloat(matrix[1][1]),dx=parseFloat(matrix[0][2]),dy=parseFloat(matrix[1][2]),rotate,sx,sy,shear;if((a*d-b*c)===0)
{return false;}
sx=MatrixUtil._round(Math.sqrt(a*a+b*b));a /=sx;b /=sx;shear=MatrixUtil._round(a*c+b*d);c-=a*shear;d-=b*shear;sy=MatrixUtil._round(Math.sqrt(c*c+d*d));c /=sy;d /=sy;shear /=sy;shear=MatrixUtil._round(MatrixUtil.rad2deg(Math.atan(shear)));rotate=MatrixUtil._round(MatrixUtil.rad2deg(Math.atan2(matrix[1][0],matrix[0][0])));return[["translate",dx,dy],["rotate",rotate],["skewX",shear],["scale",sx,sy]];},getTransformArray:function(transform){var re=/\s*([a-z]*)\(([\w,\.,\-,\s]*)\)/gi,transforms=[],args,m,decomp,methods=MatrixUtil.transformMethods;while((m=re.exec(transform))){if(methods.hasOwnProperty(m[1]))
{args=m[2].split(',');args.unshift(m[1]);transforms.push(args);}
else if(m[1]=="matrix")
{args=m[2].split(',');decomp=MatrixUtil.decompose([[args[0],args[2],args[4]],[args[1],args[3],args[5]],[0,0,1]]);transforms.push(decomp[0]);transforms.push(decomp[1]);transforms.push(decomp[2]);transforms.push(decomp[3]);}}
return transforms;},getTransformFunctionArray:function(transform){var list;switch(transform)
{case"skew":list=[transform,0,0];break;case"scale":list=[transform,1,1];break;case"scaleX":list=[transform,1];break;case"scaleY":list=[transform,1];break;case"translate":list=[transform,0,0];break;default:list=[transform,0];break;}
return list;},compareTransformSequence:function(list1,list2)
{var i=0,len=list1.length,len2=list2.length,isEqual=len===len2;if(isEqual)
{for(;i<len;++i)
{if(list1[i][0]!=list2[i][0])
{isEqual=false;break;}}}
return isEqual;},transformMethods:{rotate:"rotate",skew:"skew",skewX:"skewX",skewY:"skewY",translate:"translate",translateX:"translateX",translateY:"tranlsateY",scale:"scale",scaleX:"scaleX",scaleY:"scaleY"}};Y.MatrixUtil=MatrixUtil;var Matrix=function(config){this.init(config);};Matrix.prototype={_rounder:100000,multiply:function(a,b,c,d,dx,dy){var matrix=this,matrix_a=matrix.a*a+matrix.c*b,matrix_b=matrix.b*a+matrix.d*b,matrix_c=matrix.a*c+matrix.c*d,matrix_d=matrix.b*c+matrix.d*d,matrix_dx=matrix.a*dx+matrix.c*dy+matrix.dx,matrix_dy=matrix.b*dx+matrix.d*dy+matrix.dy;matrix.a=this._round(matrix_a);matrix.b=this._round(matrix_b);matrix.c=this._round(matrix_c);matrix.d=this._round(matrix_d);matrix.dx=this._round(matrix_dx);matrix.dy=this._round(matrix_dy);return this;},applyCSSText:function(val){var re=/\s*([a-z]*)\(([\w,\.,\-,\s]*)\)/gi,args,m;val=val.replace(/matrix/g,"multiply");while((m=re.exec(val))){if(typeof this[m[1]]==='function'){args=m[2].split(',');this[m[1]].apply(this,args);}}},getTransformArray:function(val){var re=/\s*([a-z]*)\(([\w,\.,\-,\s]*)\)/gi,transforms=[],args,m;val=val.replace(/matrix/g,"multiply");while((m=re.exec(val))){if(typeof this[m[1]]==='function'){args=m[2].split(',');args.unshift(m[1]);transforms.push(args);}}
return transforms;},_defaults:{a:1,b:0,c:0,d:1,dx:0,dy:0},_round:function(val){val=Math.round(val*this._rounder)/ this._rounder;return val;},init:function(config){var defaults=this._defaults,prop;config=config||{};for(prop in defaults){if(defaults.hasOwnProperty(prop))
{this[prop]=(prop in config)?config[prop]:defaults[prop];}}
this._config=config;},scale:function(x,y){this.multiply(x,0,0,y,0,0);return this;},skew:function(x,y){x=x||0;y=y||0;if(x!==undefined){x=Math.tan(this.angle2rad(x));}
if(y!==undefined){y=Math.tan(this.angle2rad(y));}
this.multiply(1,y,x,1,0,0);return this;},skewX:function(x){this.skew(x);return this;},skewY:function(y){this.skew(null,y);return this;},toCSSText:function(){var matrix=this,text='matrix('+
matrix.a+','+
matrix.b+','+
matrix.c+','+
matrix.d+','+
matrix.dx+','+
matrix.dy+')';return text;},toFilterText:function(){var matrix=this,text='progid:DXImageTransform.Microsoft.Matrix(';text+='M11='+matrix.a+','+'M21='+matrix.b+','+'M12='+matrix.c+','+'M22='+matrix.d+','+'sizingMethod="auto expand")';text+='';return text;},rad2deg:function(rad){var deg=rad*(180 / Math.PI);return deg;},deg2rad:function(deg){var rad=deg*(Math.PI / 180);return rad;},angle2rad:function(val){if(typeof val==='string'&&val.indexOf('rad')>-1){val=parseFloat(val);}else{val=this.deg2rad(parseFloat(val));}
return val;},rotate:function(deg,x,y){var rad=this.angle2rad(deg),sin=Math.sin(rad),cos=Math.cos(rad);this.multiply(cos,sin,0-sin,cos,0,0);return this;},translate:function(x,y){x=parseFloat(x)||0;y=parseFloat(y)||0;this.multiply(1,0,0,1,x,y);return this;},translateX:function(x){this.translate(x);return this;},translateY:function(y){this.translate(null,y);return this;},identity:function(){var config=this._config,defaults=this._defaults,prop;for(prop in config){if(prop in defaults){this[prop]=defaults[prop];}}
return this;},getMatrixArray:function()
{var matrix=this,matrixArray=[[matrix.a,matrix.c,matrix.dx],[matrix.b,matrix.d,matrix.dy],[0,0,1]];return matrixArray;},getContentRect:function(width,height,x,y)
{var left=!isNaN(x)?x:0,top=!isNaN(y)?y:0,right=left+width,bottom=top+height,matrix=this,a=matrix.a,b=matrix.b,c=matrix.c,d=matrix.d,dx=matrix.dx,dy=matrix.dy,x1=(a*left+c*top+dx),y1=(b*left+d*top+dy),x2=(a*right+c*top+dx),y2=(b*right+d*top+dy),x3=(a*left+c*bottom+dx),y3=(b*left+d*bottom+dy),x4=(a*right+c*bottom+dx),y4=(b*right+d*bottom+dy);return{left:Math.min(x3,Math.min(x1,Math.min(x2,x4))),right:Math.max(x3,Math.max(x1,Math.max(x2,x4))),top:Math.min(y2,Math.min(y4,Math.min(y3,y1))),bottom:Math.max(y2,Math.max(y4,Math.max(y3,y1)))};},getDeterminant:function()
{return Y.MatrixUtil.getDeterminant(this.getMatrixArray());},inverse:function()
{return Y.MatrixUtil.inverse(this.getMatrixArray());},transpose:function()
{return Y.MatrixUtil.transpose(this.getMatrixArray());},decompose:function()
{return Y.MatrixUtil.decompose(this.getMatrixArray());}};Y.Matrix=Matrix;},'3.15.0',{"requires":["yui-base"]});
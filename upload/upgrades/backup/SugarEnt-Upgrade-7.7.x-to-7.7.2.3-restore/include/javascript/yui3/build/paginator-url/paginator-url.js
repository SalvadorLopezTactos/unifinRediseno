/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('paginator-url',function(Y,NAME){function PaginatorUrl(){}
PaginatorUrl.ATTRS={pageUrl:{}};PaginatorUrl.prototype={prevPageUrl:function(){return(this.hasPrevPage()&&this.formatPageUrl(this.get('page')-1))||null;},nextPageUrl:function(){return(this.hasNextPage()&&this.formatPageUrl(this.get('page')+1))||null;},formatPageUrl:function(page){var pageUrl=this.get('pageUrl');if(pageUrl){return Y.Lang.sub(pageUrl,{page:page||this.get('page')});}
return null;}};Y.namespace('Paginator').Url=PaginatorUrl;Y.Base.mix(Y.Paginator,[PaginatorUrl]);},'3.15.0',{"requires":["paginator"]});
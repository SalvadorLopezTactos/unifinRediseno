/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('autocomplete-highlighters-accentfold',function(Y,NAME){var Highlight=Y.Highlight,YArray=Y.Array;Y.mix(Y.namespace('AutoCompleteHighlighters'),{charMatchFold:function(query,results){var queryChars=YArray.unique(query.split(''));return YArray.map(results,function(result){return Highlight.allFold(result.text,queryChars);});},phraseMatchFold:function(query,results){return YArray.map(results,function(result){return Highlight.allFold(result.text,[query]);});},startsWithFold:function(query,results){return YArray.map(results,function(result){return Highlight.allFold(result.text,[query],{startsWith:true});});},subWordMatchFold:function(query,results){var queryWords=Y.Text.WordBreak.getUniqueWords(query);return YArray.map(results,function(result){return Highlight.allFold(result.text,queryWords);});},wordMatchFold:function(query,results){return YArray.map(results,function(result){return Highlight.wordsFold(result.text,query);});}});},'3.15.0',{"requires":["array-extras","highlight-accentfold"]});
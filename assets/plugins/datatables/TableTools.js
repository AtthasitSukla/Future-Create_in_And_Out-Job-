/*
 * File:        TableTools.nightly.min.js
 * Version:     2.1.6-dev
 * Author:      Allan Jardine (www.sprymedia.co.uk)
 * Info:        www.datatables.net
 * 
 * Copyright 2008-2012 Allan Jardine, all rights reserved.
 *
 * This source file is free software, under either the GPL v2 license or a
 * BSD style license, available at:
 *   http://datatables.net/license_gpl2
 *   http://datatables.net/license_bsd
 * 
 * This source file is distributed in the hope that it will be useful, but 
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY 
 * or FITNESS FOR A PARTICULAR PURPOSE. See the license files for details.
 */
var TableTools;
(function(f,o,j){TableTools=function(a,b){!this instanceof TableTools&&alert("Warning: TableTools must be initialised with the keyword 'new'");this.s={that:this,dt:a.fnSettings(),print:{saveStart:-1,saveLength:-1,saveScroll:-1,funcEnd:function(){}},buttonCounter:0,select:{type:"",selected:[],preRowSelect:null,postSelected:null,postDeselected:null,all:false,selectedClass:""},custom:{},swfPath:"",buttonSet:[],master:false,tags:{}};this.dom={container:null,table:null,print:{hidden:[],message:null},collection:{collection:null,
    background:null}};this.classes=f.extend(true,{},TableTools.classes);this.s.dt.bJUI&&f.extend(true,this.classes,TableTools.classes_themeroller);this.fnSettings=function(){return this.s};if(typeof b=="undefined")b={};this._fnConstruct(b);return this};TableTools.prototype={fnGetSelected:function(a){var b=[],c=this.s.dt.aoData,d=this.s.dt.aiDisplay,e;if(a){a=0;for(e=d.length;a<e;a++)c[d[a]]._DTTT_selected&&b.push(c[d[a]].nTr)}else{a=0;for(e=c.length;a<e;a++)c[a]._DTTT_selected&&b.push(c[a].nTr)}return b},
    fnGetSelectedData:function(){var a=[],b=this.s.dt.aoData,c,d;c=0;for(d=b.length;c<d;c++)b[c]._DTTT_selected&&a.push(this.s.dt.oInstance.fnGetData(c));return a},fnIsSelected:function(a){return this.s.dt.aoData[this.s.dt.oInstance.fnGetPosition(a)]._DTTT_selected===true?true:false},fnSelectAll:function(a){var b=this._fnGetMasterSettings();this._fnRowSelect(a===true?b.dt.aiDisplay:b.dt.aoData)},fnSelectNone:function(a){this._fnGetMasterSettings();this._fnRowDeselect(this.fnGetSelected(a))},fnSelect:function(a){if(this.s.select.type==
        "single"){this.fnSelectNone();this._fnRowSelect(a)}else this.s.select.type=="multi"&&this._fnRowSelect(a)},fnDeselect:function(a){this._fnRowDeselect(a)},fnGetTitle:function(a){var b="";if(typeof a.sTitle!="undefined"&&a.sTitle!=="")b=a.sTitle;else{a=j.getElementsByTagName("title");if(a.length>0)b=a[0].innerHTML}return"\u00a1".toString().length<4?b.replace(/[^a-zA-Z0-9_\u00A1-\uFFFF\.,\-_ !\(\)]/g,""):b.replace(/[^a-zA-Z0-9_\.,\-_ !\(\)]/g,"")},fnCalcColRatios:function(a){var b=this.s.dt.aoColumns;
        a=this._fnColumnTargets(a.mColumns);var c=[],d=0,e=0,g,k;g=0;for(k=a.length;g<k;g++)if(a[g]){d=b[g].nTh.offsetWidth;e+=d;c.push(d)}g=0;for(k=c.length;g<k;g++)c[g]/=e;return c.join("\t")},fnGetTableData:function(a){if(this.s.dt)return this._fnGetDataTablesData(a)},fnSetText:function(a,b){this._fnFlashSetText(a,b)},fnResizeButtons:function(){for(var a in ZeroClipboard_TableTools.clients)if(a){var b=ZeroClipboard_TableTools.clients[a];typeof b.domElement!="undefined"&&b.domElement.parentNode&&b.positionElement()}},
    fnResizeRequired:function(){for(var a in ZeroClipboard_TableTools.clients)if(a){var b=ZeroClipboard_TableTools.clients[a];if(typeof b.domElement!="undefined"&&b.domElement.parentNode==this.dom.container&&b.sized===false)return true}return false},fnPrint:function(a,b){if(b===undefined)b={};a===undefined||a?this._fnPrintStart(b):this._fnPrintEnd()},fnInfo:function(a,b){var c=j.createElement("div");c.className=this.classes.print.info;c.innerHTML=a;j.body.appendChild(c);setTimeout(function(){f(c).fadeOut("normal",
        function(){j.body.removeChild(c)})},b)},_fnConstruct:function(a){var b=this;this._fnCustomiseSettings(a);this.dom.container=j.createElement(this.s.tags.container);this.dom.container.className=this.classes.container;this.s.select.type!="none"&&this._fnRowSelectConfig();this._fnButtonDefinations(this.s.buttonSet,this.dom.container);this.s.dt.aoDestroyCallback.push({sName:"TableTools",fn:function(){f(b.s.dt.nTBody).off("click.DTTT_Select","tr");f(b.dom.container).empty()}})},_fnCustomiseSettings:function(a){if(typeof this.s.dt._TableToolsInit==
        "undefined"){this.s.master=true;this.s.dt._TableToolsInit=true}this.dom.table=this.s.dt.nTable;this.s.custom=f.extend({},TableTools.DEFAULTS,a);this.s.swfPath=this.s.custom.sSwfPath;if(typeof ZeroClipboard_TableTools!="undefined")ZeroClipboard_TableTools.moviePath=this.s.swfPath;this.s.select.type=this.s.custom.sRowSelect;this.s.select.preRowSelect=this.s.custom.fnPreRowSelect;this.s.select.postSelected=this.s.custom.fnRowSelected;this.s.select.postDeselected=this.s.custom.fnRowDeselected;if(this.s.custom.sSelectedClass)this.classes.select.row=
        this.s.custom.sSelectedClass;this.s.tags=this.s.custom.oTags;this.s.buttonSet=this.s.custom.aButtons},_fnButtonDefinations:function(a,b){for(var c,d=0,e=a.length;d<e;d++){if(typeof a[d]=="string"){if(typeof TableTools.BUTTONS[a[d]]=="undefined"){alert("TableTools: Warning - unknown button type: "+a[d]);continue}c=f.extend({},TableTools.BUTTONS[a[d]],true)}else{if(typeof TableTools.BUTTONS[a[d].sExtends]=="undefined"){alert("TableTools: Warning - unknown button type: "+a[d].sExtends);continue}c=f.extend({},
        TableTools.BUTTONS[a[d].sExtends],true);c=f.extend(c,a[d],true)}b.appendChild(this._fnCreateButton(c,f(b).hasClass(this.classes.collection.container)))}},_fnCreateButton:function(a,b){b=this._fnButtonBase(a,b);if(a.sAction.match(/flash/))this._fnFlashConfig(b,a);else if(a.sAction=="text")this._fnTextConfig(b,a);else if(a.sAction=="div")this._fnTextConfig(b,a);else if(a.sAction=="collection"){this._fnTextConfig(b,a);this._fnCollectionConfig(b,a)}return b},_fnButtonBase:function(a,b){var c,d;if(b){c=
        a.sTag&&a.sTag!=="default"?a.sTag:this.s.tags.collection.button;d=a.sLinerTag&&a.sLinerTag!=="default"?a.sLiner:this.s.tags.collection.liner;b=this.classes.collection.buttons.normal}else{c=a.sTag&&a.sTag!=="default"?a.sTag:this.s.tags.button;d=a.sLinerTag&&a.sLinerTag!=="default"?a.sLiner:this.s.tags.liner;b=this.classes.buttons.normal}c=j.createElement(c);d=j.createElement(d);var e=this._fnGetMasterSettings();c.className=b+" "+a.sButtonClass;c.setAttribute("id","ToolTables_"+this.s.dt.sInstance+
        "_"+e.buttonCounter);c.appendChild(d);d.innerHTML=a.sButtonText;e.buttonCounter++;return c},_fnGetMasterSettings:function(){if(this.s.master)return this.s;else for(var a=TableTools._aInstances,b=0,c=a.length;b<c;b++)if(this.dom.table==a[b].s.dt.nTable)return a[b].s},_fnCollectionConfig:function(a,b){a=j.createElement(this.s.tags.collection.container);a.style.display="none";a.className=this.classes.collection.container;b._collection=a;j.body.appendChild(a);this._fnButtonDefinations(b.aButtons,a)},
    _fnCollectionShow:function(a,b){var c=this,d=f(a).offset(),e=b._collection;b=d.left;d=d.top+f(a).outerHeight();var g=f(o).height(),k=f(j).height(),h=f(o).width(),l=f(j).width();e.style.position="absolute";e.style.left=b+"px";e.style.top=d+"px";e.style.display="block";f(e).css("opacity",0);var m=j.createElement("div");m.style.position="absolute";m.style.left="0px";m.style.top="0px";m.style.height=(g>k?g:k)+"px";m.style.width=(h>l?h:l)+"px";m.className=this.classes.collection.background;f(m).css("opacity",
        0);j.body.appendChild(m);j.body.appendChild(e);g=f(e).outerWidth();h=f(e).outerHeight();if(b+g>l)e.style.left=l-g+"px";if(d+h>k)e.style.top=d-h-f(a).outerHeight()+"px";this.dom.collection.collection=e;this.dom.collection.background=m;setTimeout(function(){f(e).animate({opacity:1},500);f(m).animate({opacity:0.25},500)},10);this.fnResizeButtons();f(m).click(function(){c._fnCollectionHide.call(c,null,null)})},_fnCollectionHide:function(a,b){if(!(b!==null&&b.sExtends=="collection"))if(this.dom.collection.collection!==
        null){f(this.dom.collection.collection).animate({opacity:0},500,function(){this.style.display="none"});f(this.dom.collection.background).animate({opacity:0},500,function(){this.parentNode.removeChild(this)});this.dom.collection.collection=null;this.dom.collection.background=null}},_fnRowSelectConfig:function(){if(this.s.master){var a=this,b=this.s.dt;f(b.nTable).addClass(this.classes.select.table);f(b.nTBody).on("click.DTTT_Select","tr",function(c){if(this.parentNode==b.nTBody)if(b.oInstance.fnGetData(this)!==
        null)if(a.fnIsSelected(this))a._fnRowDeselect(this,c);else if(a.s.select.type=="single"){a.fnSelectNone();a._fnRowSelect(this,c)}else a.s.select.type=="multi"&&a._fnRowSelect(this,c)});b.oApi._fnCallbackReg(b,"aoRowCreatedCallback",function(c,d,e){b.aoData[e]._DTTT_selected&&f(c).addClass(a.classes.select.row)},"TableTools-SelectAll")}},_fnRowSelect:function(a,b){var c=this;a=this._fnSelectData(a);var d=[],e,g;e=0;for(g=a.length;e<g;e++)a[e].nTr&&d.push(a[e].nTr);if(!(this.s.select.preRowSelect!==
        null&&!this.s.select.preRowSelect.call(this,b,d,true))){e=0;for(g=a.length;e<g;e++){a[e]._DTTT_selected=true;a[e].nTr&&f(a[e].nTr).addClass(c.classes.select.row)}this.s.select.postSelected!==null&&this.s.select.postSelected.call(this,d);TableTools._fnEventDispatch(this,"select",d,true)}},_fnRowDeselect:function(a,b){var c=this;a=this._fnSelectData(a);var d=[],e,g;e=0;for(g=a.length;e<g;e++)a[e].nTr&&d.push(a[e].nTr);if(!(this.s.select.preRowSelect!==null&&!this.s.select.preRowSelect.call(this,b,d,
        false))){e=0;for(g=a.length;e<g;e++){a[e]._DTTT_selected=false;a[e].nTr&&f(a[e].nTr).removeClass(c.classes.select.row)}this.s.select.postDeselected!==null&&this.s.select.postDeselected.call(this,d);TableTools._fnEventDispatch(this,"select",d,false)}},_fnSelectData:function(a){var b=[],c,d,e;if(a.nodeName){c=this.s.dt.oInstance.fnGetPosition(a);b.push(this.s.dt.aoData[c])}else if(typeof a.length!=="undefined"){d=0;for(e=a.length;d<e;d++)if(a[d].nodeName){c=this.s.dt.oInstance.fnGetPosition(a[d]);b.push(this.s.dt.aoData[c])}else typeof a[d]===
        "number"?b.push(this.s.dt.aoData[a[d]]):b.push(a[d]);return b}else b.push(a);return b},_fnTextConfig:function(a,b){var c=this;b.fnInit!==null&&b.fnInit.call(this,a,b);if(b.sToolTip!=="")a.title=b.sToolTip;f(a).hover(function(){b.fnMouseover!==null&&b.fnMouseover.call(this,a,b,null)},function(){b.fnMouseout!==null&&b.fnMouseout.call(this,a,b,null)});b.fnSelect!==null&&TableTools._fnEventListen(this,"select",function(d){b.fnSelect.call(c,a,b,d)});f(a).click(function(d){b.fnClick!==null&&b.fnClick.call(c,
        a,b,null,d);b.fnComplete!==null&&b.fnComplete.call(c,a,b,null,null);c._fnCollectionHide(a,b)})},_fnFlashConfig:function(a,b){var c=this,d=new ZeroClipboard_TableTools.Client;b.fnInit!==null&&b.fnInit.call(this,a,b);d.setHandCursor(true);if(b.sAction=="flash_save"){d.setAction("save");d.setCharSet(b.sCharSet=="utf16le"?"UTF16LE":"UTF8");d.setBomInc(b.bBomInc);d.setFileName(b.sFileName.replace("*",this.fnGetTitle(b)))}else if(b.sAction=="flash_pdf"){d.setAction("pdf");d.setFileName(b.sFileName.replace("*",
        this.fnGetTitle(b)))}else d.setAction("copy");d.addEventListener("mouseOver",function(){b.fnMouseover!==null&&b.fnMouseover.call(c,a,b,d)});d.addEventListener("mouseOut",function(){b.fnMouseout!==null&&b.fnMouseout.call(c,a,b,d)});d.addEventListener("mouseDown",function(){b.fnClick!==null&&b.fnClick.call(c,a,b,d)});d.addEventListener("complete",function(e,g){b.fnComplete!==null&&b.fnComplete.call(c,a,b,d,g);c._fnCollectionHide(a,b)});this._fnFlashGlue(d,a,b.sToolTip)},_fnFlashGlue:function(a,b,c){var d=
        this,e=b.getAttribute("id");j.getElementById(e)?a.glue(b,c):setTimeout(function(){d._fnFlashGlue(a,b,c)},100)},_fnFlashSetText:function(a,b){b=this._fnChunkData(b,8192);a.clearText();for(var c=0,d=b.length;c<d;c++)a.appendText(b[c])},_fnColumnTargets:function(a){var b=[],c=this.s.dt;if(typeof a=="object"){i=0;for(iLen=c.aoColumns.length;i<iLen;i++)b.push(false);i=0;for(iLen=a.length;i<iLen;i++)b[a[i]]=true}else if(a=="visible"){i=0;for(iLen=c.aoColumns.length;i<iLen;i++)b.push(c.aoColumns[i].bVisible?
        true:false)}else if(a=="hidden"){i=0;for(iLen=c.aoColumns.length;i<iLen;i++)b.push(c.aoColumns[i].bVisible?false:true)}else if(a=="sortable"){i=0;for(iLen=c.aoColumns.length;i<iLen;i++)b.push(c.aoColumns[i].bSortable?true:false)}else{i=0;for(iLen=c.aoColumns.length;i<iLen;i++)b.push(true)}return b},_fnNewline:function(a){return a.sNewLine=="auto"?navigator.userAgent.match(/Windows/)?"\r\n":"\n":a.sNewLine},_fnGetDataTablesData:function(a){var b,c,d,e,g,k=[],h="",l=this.s.dt,m,p=new RegExp(a.sFieldBoundary,
        "g"),q=this._fnColumnTargets(a.mColumns);d=typeof a.bSelectedOnly!="undefined"?a.bSelectedOnly:false;if(a.bHeader){g=[];b=0;for(c=l.aoColumns.length;b<c;b++)if(q[b]){h=l.aoColumns[b].sTitle.replace(/\n/g," ").replace(/<.*?>/g,"").replace(/^\s+|\s+$/g,"");h=this._fnHtmlDecode(h);g.push(this._fnBoundData(h,a.sFieldBoundary,p))}k.push(g.join(a.sFieldSeperator))}var n=l.aiDisplay;e=this.fnGetSelected();if(this.s.select.type!=="none"&&d&&e.length!==0){n=[];b=0;for(c=e.length;b<c;b++)n.push(l.oInstance.fnGetPosition(e[b]))}d=
        0;for(e=n.length;d<e;d++){m=l.aoData[n[d]].nTr;g=[];b=0;for(c=l.aoColumns.length;b<c;b++)if(q[b]){h=l.oApi._fnGetCellData(l,n[d],b,"display");if(a.fnCellRender)h=a.fnCellRender(h,b,m,n[d])+"";else if(typeof h=="string"){h=h.replace(/\n/g," ");h=h.replace(/<img.*?\s+alt\s*=\s*(?:"([^"]+)"|'([^']+)'|([^\s>]+)).*?>/gi,"$1$2$3");h=h.replace(/<.*?>/g,"")}else h=h+"";h=h.replace(/^\s+/,"").replace(/\s+$/,"");h=this._fnHtmlDecode(h);g.push(this._fnBoundData(h,a.sFieldBoundary,p))}k.push(g.join(a.sFieldSeperator));
        if(a.bOpenRows){b=f.grep(l.aoOpenRows,function(r){return r.nParent===m});if(b.length===1){h=this._fnBoundData(f("td",b[0].nTr).html(),a.sFieldBoundary,p);k.push(h)}}}if(a.bFooter&&l.nTFoot!==null){g=[];b=0;for(c=l.aoColumns.length;b<c;b++)if(q[b]&&l.aoColumns[b].nTf!==null){h=l.aoColumns[b].nTf.innerHTML.replace(/\n/g," ").replace(/<.*?>/g,"");h=this._fnHtmlDecode(h);g.push(this._fnBoundData(h,a.sFieldBoundary,p))}k.push(g.join(a.sFieldSeperator))}return _sLastData=k.join(this._fnNewline(a))},_fnBoundData:function(a,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                b,c){return b===""?a:b+a.replace(c,b+b)+b},_fnChunkData:function(a,b){for(var c=[],d=a.length,e=0;e<d;e+=b)e+b<d?c.push(a.substring(e,e+b)):c.push(a.substring(e,d));return c},_fnHtmlDecode:function(a){if(a.indexOf("&")===-1)return a;var b=j.createElement("div");return a.replace(/&([^\s]*);/g,function(c,d){if(c.substr(1,1)==="#")return String.fromCharCode(Number(d.substr(1)));else{b.innerHTML=c;return b.childNodes[0].nodeValue}})},_fnPrintStart:function(a){var b=this,c=this.s.dt;this._fnPrintHideNodes(c.nTable);
        this.s.print.saveStart=c._iDisplayStart;this.s.print.saveLength=c._iDisplayLength;if(a.bShowAll){c._iDisplayStart=0;c._iDisplayLength=-1;c.oApi._fnCalculateEnd(c);c.oApi._fnDraw(c)}if(c.oScroll.sX!==""||c.oScroll.sY!==""){this._fnPrintScrollStart(c);f(this.s.dt.nTable).bind("draw.DTTT_Print",function(){b._fnPrintScrollStart(c)})}var d=c.aanFeatures;for(var e in d)if(e!="i"&&e!="t"&&e.length==1)for(var g=0,k=d[e].length;g<k;g++){this.dom.print.hidden.push({node:d[e][g],display:"block"});d[e][g].style.display=
            "none"}f(j.body).addClass(this.classes.print.body);a.sInfo!==""&&this.fnInfo(a.sInfo,3E3);if(a.sMessage){this.dom.print.message=j.createElement("div");this.dom.print.message.className=this.classes.print.message;this.dom.print.message.innerHTML=a.sMessage;j.body.insertBefore(this.dom.print.message,j.body.childNodes[0])}this.s.print.saveScroll=f(o).scrollTop();o.scrollTo(0,0);f(j).bind("keydown.DTTT",function(h){if(h.keyCode==27){h.preventDefault();b._fnPrintEnd.call(b,h)}})},_fnPrintEnd:function(){var a=
        this.s.dt,b=this.s.print,c=this.dom.print;this._fnPrintShowNodes();if(a.oScroll.sX!==""||a.oScroll.sY!==""){f(this.s.dt.nTable).unbind("draw.DTTT_Print");this._fnPrintScrollEnd()}o.scrollTo(0,b.saveScroll);if(c.message!==null){j.body.removeChild(c.message);c.message=null}f(j.body).removeClass("DTTT_Print");a._iDisplayStart=b.saveStart;a._iDisplayLength=b.saveLength;a.oApi._fnCalculateEnd(a);a.oApi._fnDraw(a);f(j).unbind("keydown.DTTT")},_fnPrintScrollStart:function(){var a=this.s.dt;a.nScrollHead.getElementsByTagName("div")[0].getElementsByTagName("table");
        var b=a.nTable.parentNode,c=a.nTable.getElementsByTagName("thead");c.length>0&&a.nTable.removeChild(c[0]);if(a.nTFoot!==null){c=a.nTable.getElementsByTagName("tfoot");c.length>0&&a.nTable.removeChild(c[0])}c=a.nTHead.cloneNode(true);a.nTable.insertBefore(c,a.nTable.childNodes[0]);if(a.nTFoot!==null){c=a.nTFoot.cloneNode(true);a.nTable.insertBefore(c,a.nTable.childNodes[1])}if(a.oScroll.sX!==""){a.nTable.style.width=f(a.nTable).outerWidth()+"px";b.style.width=f(a.nTable).outerWidth()+"px";b.style.overflow=
            "visible"}if(a.oScroll.sY!==""){b.style.height=f(a.nTable).outerHeight()+"px";b.style.overflow="visible"}},_fnPrintScrollEnd:function(){var a=this.s.dt,b=a.nTable.parentNode;if(a.oScroll.sX!==""){b.style.width=a.oApi._fnStringToCss(a.oScroll.sX);b.style.overflow="auto"}if(a.oScroll.sY!==""){b.style.height=a.oApi._fnStringToCss(a.oScroll.sY);b.style.overflow="auto"}},_fnPrintShowNodes:function(){for(var a=this.dom.print.hidden,b=0,c=a.length;b<c;b++)a[b].node.style.display=a[b].display;a.splice(0,
        a.length)},_fnPrintHideNodes:function(a){for(var b=this.dom.print.hidden,c=a.parentNode,d=c.childNodes,e=0,g=d.length;e<g;e++)if(d[e]!=a&&d[e].nodeType==1){var k=f(d[e]).css("display");if(k!="none"){b.push({node:d[e],display:k});d[e].style.display="none"}}c.nodeName!="BODY"&&this._fnPrintHideNodes(c)}};TableTools._aInstances=[];TableTools._aListeners=[];TableTools.fnGetMasters=function(){for(var a=[],b=0,c=TableTools._aInstances.length;b<c;b++)TableTools._aInstances[b].s.master&&a.push(TableTools._aInstances[b]);
    return a};TableTools.fnGetInstance=function(a){if(typeof a!="object")a=j.getElementById(a);for(var b=0,c=TableTools._aInstances.length;b<c;b++)if(TableTools._aInstances[b].s.master&&TableTools._aInstances[b].dom.table==a)return TableTools._aInstances[b];return null};TableTools._fnEventListen=function(a,b,c){TableTools._aListeners.push({that:a,type:b,fn:c})};TableTools._fnEventDispatch=function(a,b,c,d){for(var e=TableTools._aListeners,g=0,k=e.length;g<k;g++)a.dom.table==e[g].that.dom.table&&e[g].type==
    b&&e[g].fn(c,d)};TableTools.buttonBase={sAction:"text",sTag:"default",sLinerTag:"default",sButtonClass:"DTTT_button_text",sButtonText:"Button text",sTitle:"",sToolTip:"",sCharSet:"utf8",bBomInc:false,sFileName:"*.csv",sFieldBoundary:"",sFieldSeperator:"\t",sNewLine:"auto",mColumns:"all",bHeader:true,bFooter:true,bOpenRows:false,bSelectedOnly:false,fnMouseover:null,fnMouseout:null,fnClick:null,fnSelect:null,fnComplete:null,fnInit:null,fnCellRender:null};TableTools.BUTTONS={csv:f.extend({},TableTools.buttonBase,
    {sAction:"flash_save",sButtonClass:"DTTT_button_csv",sButtonText:"CSV",sFieldBoundary:'"',sFieldSeperator:",",fnClick:function(a,b,c){this.fnSetText(c,this.fnGetTableData(b))}}),xls:f.extend({},TableTools.buttonBase,{sAction:"flash_save",sCharSet:"utf16le",bBomInc:true,sButtonClass:"DTTT_button_xls",sButtonText:"Excel",fnClick:function(a,b,c){this.fnSetText(c,this.fnGetTableData(b))}}),copy:f.extend({},TableTools.buttonBase,{sAction:"flash_copy",sButtonClass:"DTTT_button_copy",sButtonText:"Copy",
    fnClick:function(a,b,c){this.fnSetText(c,this.fnGetTableData(b))},fnComplete:function(a,b,c,d){a=d.split("\n").length;a=this.s.dt.nTFoot===null?a-1:a-2;this.fnInfo("<h6>Table copied</h6><p>Copied "+a+" row"+(a==1?"":"s")+" to the clipboard.</p>",1500)}}),pdf:f.extend({},TableTools.buttonBase,{sAction:"flash_pdf",sNewLine:"\n",sFileName:"*.pdf",sButtonClass:"DTTT_button_pdf",sButtonText:"PDF",sPdfOrientation:"portrait",sPdfSize:"A4",sPdfMessage:"",fnClick:function(a,b,c){this.fnSetText(c,"title:"+
    this.fnGetTitle(b)+"\nmessage:"+b.sPdfMessage+"\ncolWidth:"+this.fnCalcColRatios(b)+"\norientation:"+b.sPdfOrientation+"\nsize:"+b.sPdfSize+"\n--/TableToolsOpts--\n"+this.fnGetTableData(b))}}),print:f.extend({},TableTools.buttonBase,{sInfo:"<h6>Print view</h6><p>Please use your browser's print function to print this table. Press escape when finished.",sMessage:null,bShowAll:true,sToolTip:"View print view",sButtonClass:"DTTT_button_print",sButtonText:"Print",fnClick:function(a,b){this.fnPrint(true,
    b)}}),text:f.extend({},TableTools.buttonBase),select:f.extend({},TableTools.buttonBase,{sButtonText:"Select button",fnSelect:function(a){this.fnGetSelected().length!==0?f(a).removeClass(this.classes.buttons.disabled):f(a).addClass(this.classes.buttons.disabled)},fnInit:function(a){f(a).addClass(this.classes.buttons.disabled)}}),select_single:f.extend({},TableTools.buttonBase,{sButtonText:"Select button",fnSelect:function(a){this.fnGetSelected().length==1?f(a).removeClass(this.classes.buttons.disabled):
    f(a).addClass(this.classes.buttons.disabled)},fnInit:function(a){f(a).addClass(this.classes.buttons.disabled)}}),select_all:f.extend({},TableTools.buttonBase,{sButtonText:"Select all",fnClick:function(){this.fnSelectAll()},fnSelect:function(a){this.fnGetSelected().length==this.s.dt.fnRecordsDisplay()?f(a).addClass(this.classes.buttons.disabled):f(a).removeClass(this.classes.buttons.disabled)}}),select_none:f.extend({},TableTools.buttonBase,{sButtonText:"Deselect all",fnClick:function(){this.fnSelectNone()},
    fnSelect:function(a){this.fnGetSelected().length!==0?f(a).removeClass(this.classes.buttons.disabled):f(a).addClass(this.classes.buttons.disabled)},fnInit:function(a){f(a).addClass(this.classes.buttons.disabled)}}),ajax:f.extend({},TableTools.buttonBase,{sAjaxUrl:"/xhr.php",sButtonText:"Ajax button",fnClick:function(a,b){a=this.fnGetTableData(b);f.ajax({url:b.sAjaxUrl,data:[{name:"tableData",value:a}],success:b.fnAjaxComplete,dataType:"json",type:"POST",cache:false,error:function(){alert("Error detected when sending table data to server")}})},
    fnAjaxComplete:function(){alert("Ajax complete")}}),div:f.extend({},TableTools.buttonBase,{sAction:"div",sTag:"div",sButtonClass:"DTTT_nonbutton",sButtonText:"Text button"}),collection:f.extend({},TableTools.buttonBase,{sAction:"collection",sButtonClass:"DTTT_button_collection",sButtonText:"Collection",fnClick:function(a,b){this._fnCollectionShow(a,b)}})};TableTools.classes={container:"DTTT_container",buttons:{normal:"DTTT_button",disabled:"DTTT_disabled"},collection:{container:"DTTT_collection",
    background:"DTTT_collection_background",buttons:{normal:"DTTT_button",disabled:"DTTT_disabled"}},select:{table:"DTTT_selectable",row:"DTTT_selected"},print:{body:"DTTT_Print",info:"DTTT_print_info",message:"DTTT_PrintMessage"}};TableTools.classes_themeroller={container:"DTTT_container ui-buttonset ui-buttonset-multi",buttons:{normal:"DTTT_button ui-button ui-state-default"},collection:{container:"DTTT_collection ui-buttonset ui-buttonset-multi"}};TableTools.DEFAULTS={sSwfPath:"media/swf/copy_csv_xls_pdf.swf",
    sRowSelect:"none",sSelectedClass:null,fnPreRowSelect:null,fnRowSelected:null,fnRowDeselected:null,aButtons:["copy","csv","xls","pdf","print"],oTags:{container:"div",button:"a",liner:"span",collection:{container:"div",button:"a",liner:"span"}}};TableTools.prototype.CLASS="TableTools";TableTools.VERSION="2.1.6-dev";TableTools.prototype.VERSION=TableTools.VERSION;typeof f.fn.dataTable=="function"&&typeof f.fn.dataTableExt.fnVersionCheck=="function"&&f.fn.dataTableExt.fnVersionCheck("1.9.0")?f.fn.dataTableExt.aoFeatures.push({fnInit:function(a){a=
    new TableTools(a.oInstance,typeof a.oInit.oTableTools!="undefined"?a.oInit.oTableTools:{});TableTools._aInstances.push(a);return a.dom.container},cFeature:"T",sFeature:"TableTools"}):alert("Warning: TableTools 2 requires DataTables 1.9.0 or newer - www.datatables.net/download");f.fn.DataTable.TableTools=TableTools})(jQuery,window,document);
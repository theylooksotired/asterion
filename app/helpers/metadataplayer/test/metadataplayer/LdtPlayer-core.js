/* 
 * 	
 *	Copyright 2010-2012 Institut de recherche et d'innovation 
 *	contributor(s) : Karim Hamidou, Samuel Huron, Raphael Velt, Thibaut Cavalie
 *	 
 *	contact@iri.centrepompidou.fr
 *	http://www.iri.centrepompidou.fr 
 *	 
 *	This software is a computer program whose purpose is to show and add annotations on a video .
 *	This software is governed by the CeCILL-C license under French law and
 *	abiding by the rules of distribution of free software. You can  use, 
 *	modify and/ or redistribute the software under the terms of the CeCILL-C
 *	license as circulated by CEA, CNRS and INRIA at the following URL
 *	"http://www.cecill.info". 
 *	
 *	The fact that you are presently reading this means that you have had
 *	knowledge of the CeCILL-C license and that you accept its terms.
*/
/*! LAB.js (LABjs :: Loading And Blocking JavaScript)
    v2.0.3 (c) Kyle Simpson
    MIT License
*/
(function(o){var K=o.$LAB,y="UseLocalXHR",z="AlwaysPreserveOrder",u="AllowDuplicates",A="CacheBust",B="BasePath",C=/^[^?#]*\//.exec(location.href)[0],D=/^\w+\:\/\/\/?[^\/]+/.exec(C)[0],i=document.head||document.getElementsByTagName("head"),L=(o.opera&&Object.prototype.toString.call(o.opera)=="[object Opera]")||("MozAppearance"in document.documentElement.style),q=document.createElement("script"),E=typeof q.preload=="boolean",r=E||(q.readyState&&q.readyState=="uninitialized"),F=!r&&q.async===true,M=!r&&!F&&!L;function G(a){return Object.prototype.toString.call(a)=="[object Function]"}function H(a){return Object.prototype.toString.call(a)=="[object Array]"}function N(a,c){var b=/^\w+\:\/\//;if(/^\/\/\/?/.test(a)){a=location.protocol+a}else if(!b.test(a)&&a.charAt(0)!="/"){a=(c||"")+a}return b.test(a)?a:((a.charAt(0)=="/"?D:C)+a)}function s(a,c){for(var b in a){if(a.hasOwnProperty(b)){c[b]=a[b]}}return c}function O(a){var c=false;for(var b=0;b<a.scripts.length;b++){if(a.scripts[b].ready&&a.scripts[b].exec_trigger){c=true;a.scripts[b].exec_trigger();a.scripts[b].exec_trigger=null}}return c}function t(a,c,b,d){a.onload=a.onreadystatechange=function(){if((a.readyState&&a.readyState!="complete"&&a.readyState!="loaded")||c[b])return;a.onload=a.onreadystatechange=null;d()}}function I(a){a.ready=a.finished=true;for(var c=0;c<a.finished_listeners.length;c++){a.finished_listeners[c]()}a.ready_listeners=[];a.finished_listeners=[]}function P(d,f,e,g,h){setTimeout(function(){var a,c=f.real_src,b;if("item"in i){if(!i[0]){setTimeout(arguments.callee,25);return}i=i[0]}a=document.createElement("script");if(f.type)a.type=f.type;if(f.charset)a.charset=f.charset;if(h){if(r){e.elem=a;if(E){a.preload=true;a.onpreload=g}else{a.onreadystatechange=function(){if(a.readyState=="loaded")g()}}a.src=c}else if(h&&c.indexOf(D)==0&&d[y]){b=new XMLHttpRequest();b.onreadystatechange=function(){if(b.readyState==4){b.onreadystatechange=function(){};e.text=b.responseText+"\n//@ sourceURL="+c;g()}};b.open("GET",c);b.send()}else{a.type="text/cache-script";t(a,e,"ready",function(){i.removeChild(a);g()});a.src=c;i.insertBefore(a,i.firstChild)}}else if(F){a.async=false;t(a,e,"finished",g);a.src=c;i.insertBefore(a,i.firstChild)}else{t(a,e,"finished",g);a.src=c;i.insertBefore(a,i.firstChild)}},0)}function J(){var l={},Q=r||M,n=[],p={},m;l[y]=true;l[z]=false;l[u]=false;l[A]=false;l[B]="";function R(a,c,b){var d;function f(){if(d!=null){d=null;I(b)}}if(p[c.src].finished)return;if(!a[u])p[c.src].finished=true;d=b.elem||document.createElement("script");if(c.type)d.type=c.type;if(c.charset)d.charset=c.charset;t(d,b,"finished",f);if(b.elem){b.elem=null}else if(b.text){d.onload=d.onreadystatechange=null;d.text=b.text}else{d.src=c.real_src}i.insertBefore(d,i.firstChild);if(b.text){f()}}function S(c,b,d,f){var e,g,h=function(){b.ready_cb(b,function(){R(c,b,e)})},j=function(){b.finished_cb(b,d)};b.src=N(b.src,c[B]);b.real_src=b.src+(c[A]?((/\?.*$/.test(b.src)?"&_":"?_")+~~(Math.random()*1E9)+"="):"");if(!p[b.src])p[b.src]={items:[],finished:false};g=p[b.src].items;if(c[u]||g.length==0){e=g[g.length]={ready:false,finished:false,ready_listeners:[h],finished_listeners:[j]};P(c,b,e,((f)?function(){e.ready=true;for(var a=0;a<e.ready_listeners.length;a++){e.ready_listeners[a]()}e.ready_listeners=[]}:function(){I(e)}),f)}else{e=g[0];if(e.finished){j()}else{e.finished_listeners.push(j)}}}function v(){var e,g=s(l,{}),h=[],j=0,w=false,k;function T(a,c){a.ready=true;a.exec_trigger=c;x()}function U(a,c){a.ready=a.finished=true;a.exec_trigger=null;for(var b=0;b<c.scripts.length;b++){if(!c.scripts[b].finished)return}c.finished=true;x()}function x(){while(j<h.length){if(G(h[j])){try{h[j++]()}catch(err){}continue}else if(!h[j].finished){if(O(h[j]))continue;break}j++}if(j==h.length){w=false;k=false}}function V(){if(!k||!k.scripts){h.push(k={scripts:[],finished:true})}}e={script:function(){for(var f=0;f<arguments.length;f++){(function(a,c){var b;if(!H(a)){c=[a]}for(var d=0;d<c.length;d++){V();a=c[d];if(G(a))a=a();if(!a)continue;if(H(a)){b=[].slice.call(a);b.unshift(d,1);[].splice.apply(c,b);d--;continue}if(typeof a=="string")a={src:a};a=s(a,{ready:false,ready_cb:T,finished:false,finished_cb:U});k.finished=false;k.scripts.push(a);S(g,a,k,(Q&&w));w=true;if(g[z])e.wait()}})(arguments[f],arguments[f])}return e},wait:function(){if(arguments.length>0){for(var a=0;a<arguments.length;a++){h.push(arguments[a])}k=h[h.length-1]}else k=false;x();return e}};return{script:e.script,wait:e.wait,setOptions:function(a){s(a,g);return e}}}m={setGlobalDefaults:function(a){s(a,l);return m},setOptions:function(){return v().setOptions.apply(null,arguments)},script:function(){return v().script.apply(null,arguments)},wait:function(){return v().wait.apply(null,arguments)},queueScript:function(){n[n.length]={type:"script",args:[].slice.call(arguments)};return m},queueWait:function(){n[n.length]={type:"wait",args:[].slice.call(arguments)};return m},runQueue:function(){var a=m,c=n.length,b=c,d;for(;--b>=0;){d=n.shift();a=a[d.type].apply(null,d.args)}return a},noConflict:function(){o.$LAB=K;return m},sandbox:function(){return J()}};return m}o.$LAB=J();(function(a,c,b){if(document.readyState==null&&document[a]){document.readyState="loading";document[a](c,b=function(){document.removeEventListener(c,b,false);document.readyState="complete"},false)}})("addEventListener","DOMContentLoaded")})(this);/* init.js - initialization and configuration of the widgets
*/

if (typeof window.IriSP === "undefined") {
    window.IriSP = {};
}

/* The Metadataplayer Object, single point of entry, replaces IriSP.init_player */

IriSP.Metadataplayer = function(config) {
    IriSP.log("IriSP.Metadataplayer constructor");
    for (var key in IriSP.guiDefaults) {
        if (IriSP.guiDefaults.hasOwnProperty(key) && !config.hasOwnProperty(key)) {
            config[key] = IriSP.guiDefaults[key]
        }
    }
    var _container = document.getElementById(config.container);
    _container.innerHTML = '<h3 class="Ldt-Loader">Loading... Chargement...</h3>';
    this.sourceManager = new IriSP.Model.Directory();
    this.config = config;
    this.__events = {};
    this.loadLibs();
}

IriSP.Metadataplayer.prototype.toString = function() {
    return 'Metadataplayer in #' + this.config.container;
}

IriSP.Metadataplayer.prototype.on = function(_event, _callback) {
    if (typeof this.__events[_event] === "undefined") {
        this.__events[_event] = [];
    }
    this.__events[_event].push(_callback);
}

IriSP.Metadataplayer.prototype.trigger = function(_event, _data) {
    var _element = this;
    IriSP._(this.__events[_event]).each(function(_callback) {
        _callback.call(_element, _data);
    });
}

IriSP.Metadataplayer.prototype.loadLibs = function() {
    IriSP.log("IriSP.Metadataplayer.prototype.loadLibs");
    var $L = $LAB
        .script(IriSP.getLib("underscore"))
        .script(IriSP.getLib("Mustache"))
        .script(IriSP.getLib("jQuery"));
    
    if (typeof JSON == "undefined") {
        $L.script(IriSP.getLib("json"));
    }
    
    $L.wait()
        .script(IriSP.getLib("jQueryUI"));

    /* widget specific requirements */
    for(var _i = 0; _i < this.config.widgets.length; _i++) {
        var _t = this.config.widgets[_i].type;
        if (typeof IriSP.widgetsRequirements[_t] !== "undefined" && typeof IriSP.widgetsRequirements[_t].requires !== "undefined" ) {
            for (var _j = 0; _j < IriSP.widgetsRequirements[_t].requires.length; _j++) {
                $L.script(IriSP.getLib(IriSP.widgetsRequirements[_t].requires[_j]));
            }
        }
    }
    
    var _this = this;
    
    $L.wait(function() {
        _this.onLibsLoaded();
    });
}

IriSP.Metadataplayer.prototype.onLibsLoaded = function() {
    IriSP.log("IriSP.Metadataplayer.prototype.onLibsLoaded");
    if (typeof IriSP.jQuery === "undefined" && typeof window.jQuery !== "undefined") {
        IriSP.jQuery = window.jQuery;
    }
    if (typeof IriSP._ === "undefined" && typeof window._ !== "undefined") {
        IriSP._ = window._;
    }
    IriSP.loadCss(IriSP.getLib("cssjQueryUI"));
    IriSP.loadCss(this.config.css);
    
    this.$ = IriSP.jQuery('#' + this.config.container);
    this.$.css({
        "width": this.config.width,
        "clear": "both"
    });
    if (typeof this.config.height !== "undefined") {
        this.$.css("height", this.config.height);
    }
      
    this.widgets = [];
    var _this = this;
    IriSP._(this.config.widgets).each(function(widgetconf, key) {
        _this.widgets.push(null);
        _this.loadWidget(widgetconf, function(widget) {
            _this.widgets[key] = widget;
            if (widget.isLoaded()) {
                _this.trigger("widget-loaded");
            }
        });
    });
    this.$.find('.Ldt-Loader').detach();
    
    this.widgetsLoaded = false;
    
    this.on("widget-loaded", function() {
        if (_this.widgetsLoaded) {
            return;
        }
        var isloaded = !IriSP._(_this.widgets).any(function(w) {
            return !(w && w.isLoaded())
        });
        if (isloaded) {
            _this.widgetsLoaded = true;
            _this.trigger("widgets-loaded");
        }
    });   
}

IriSP.Metadataplayer.prototype.loadMetadata = function(_metadataInfo) {
    if (_metadataInfo.elementType === "source") {
        return _metadataInfo;
    }
    if (typeof _metadataInfo.serializer === "undefined" && typeof _metadataInfo.format !== "undefined") {
        _metadataInfo.serializer = IriSP.serializers[_metadataInfo.format];
    }
    if (typeof _metadataInfo.url !== "undefined" && typeof _metadataInfo.serializer !== "undefined") {
        return this.sourceManager.remoteSource(_metadataInfo);
    } else {
        return this.sourceManager.newLocalSource(_metadataInfo);
    }
}

IriSP.Metadataplayer.prototype.loadWidget = function(_widgetConfig, _callback) {
    /* Creating containers if needed */
    if (typeof _widgetConfig.container === "undefined") {
        var _divs = this.layoutDivs(_widgetConfig.type);
        _widgetConfig.container = _divs[0];
    }
    
    var _this = this;
    
    if (typeof IriSP.Widgets[_widgetConfig.type] !== "undefined") {
        IriSP._.defer(function() {
            _callback(new IriSP.Widgets[_widgetConfig.type](_this, _widgetConfig));
        });
    } else {
        /* Loading Widget CSS */
        if (typeof IriSP.widgetsRequirements[_widgetConfig.type] === "undefined" || typeof IriSP.widgetsRequirements[_widgetConfig.type].noCss === "undefined" || !IriSP.widgetsRequirements[_widgetConfig.type].noCss) {
            IriSP.loadCss(IriSP.widgetsDir + '/' + _widgetConfig.type + '.css');
        }
        /* Loading Widget JS    */
        $LAB.script(IriSP.widgetsDir + '/' + _widgetConfig.type + '.js').wait(function() {
            _callback(new IriSP.Widgets[_widgetConfig.type](_this, _widgetConfig));
        });
    }
}

/** create a subdiv with an unique id, and a spacer div as well.
    @param widgetName the name of the widget.
    @return an array of the form [createdivId, spacerdivId].
*/
IriSP.Metadataplayer.prototype.layoutDivs = function(_name, _height) {
    if (typeof(_name) === "undefined") {
       _name = "";
    }
    var newDiv = IriSP._.uniqueId(this.config.container + "_widget_" + _name + "_"),
        spacerDiv = IriSP._.uniqueId("LdtPlayer_spacer_"),
        divHtml = IriSP.jQuery('<div>')
            .attr("id",newDiv)
            .css({
                width: this.config.width + "px",
                position: "relative",
                clear: "both"
            }),
        spacerHtml = IriSP.jQuery('<div>')
            .attr("id",spacerDiv)
            .css({
                width: this.config.width + "px",
                height: this.config.spacer_div_height + "px",
                position: "relative",
                clear: "both"
            });
    if (typeof _height !== "undefined") {
        divHtml.css("height", _height);
    }
            
    this.$.append(divHtml);
    this.$.append(spacerHtml);

    return [newDiv, spacerDiv];
};
/* utils.js - various utils that don't belong anywhere else */

IriSP.jqEscape = function(_text) {
    return _text.replace(/(:|\.)/g,'\\$1');
}

IriSP.getLib = function(lib) {
    if (IriSP.libFiles.useCdn && typeof IriSP.libFiles.cdn[lib] == "string") {
        return IriSP.libFiles.cdn[lib];
    }
    if (typeof IriSP.libFiles.locations[lib] == "string") {
        return IriSP.libFiles.locations[lib];
    }
    if (typeof IriSP.libFiles.inDefaultDir[lib] == "string") {
        return IriSP.libFiles.defaultDir + '/' + IriSP.libFiles.inDefaultDir[lib];
    }
}

IriSP._cssCache = [];

IriSP.loadCss = function(_cssFile) {
    if (IriSP._(IriSP._cssCache).indexOf(_cssFile) === -1) {
        IriSP.jQuery("<link>", {
            rel : "stylesheet",
            type : "text/css",
            href : _cssFile
        }).appendTo('head');
        IriSP._cssCache.push(_cssFile);
    }
}

IriSP.textFieldHtml = function(_text, _regexp, _extend) {
    var list = [],
        positions = [],
        text = _text.replace(/(^\s+|\s+$)/g,'');
    
    function addToList(_rx, _startHtml, _endHtml) {
        while(true) {
            var result = _rx.exec(text);
            if (!result) {
                break;
            }
            var end = _rx.lastIndex,
                start = result.index;
            list.push({
                start: start,
                end: end,
                startHtml: (typeof _startHtml === "function" ? _startHtml(result) : _startHtml),
                endHtml: (typeof _endHtml === "function" ? _endHtml(result) : _endHtml)
            });
            positions.push(start);
            positions.push(end);
        }
    }
    
    if (_regexp) {
        addToList(_regexp, '<span class="Ldt-Highlight">', '</span>');
    }
    
    addToList(/(https?:\/\/)?\w+\.\w+\S+/gm, function(matches) {
        return '<a href="' + (matches[1] ? '' : 'http://') + matches[0] + '" target="_blank">'
    }, '</a>');
    addToList(/@([\d\w]{1,15})/gm, function(matches) {
        return '<a href="http://twitter.com/' + matches[1] + '" target="_blank">'
    }, '</a>');
    addToList(/\*[^*]+\*/gm, '<b>', '</b>');
    addToList(/[\n\r]+/gm, '', '<br />');
    
    IriSP._(_extend).each(function(x) {
        addToList.apply(null, x);
    });
    
    positions = IriSP._(positions)
        .chain()
        .uniq()
        .sortBy(function(p) { return parseInt(p) })
        .value();
    
    var res = "", lastIndex = 0;
    
    for (var i = 0; i < positions.length; i++) {
        var pos = positions[i];
        res += text.substring(lastIndex, pos);
        for (var j = list.length - 1; j >= 0; j--) {
            var item = list[j];
            if (item.start < pos && item.end >= pos) {
                res += item.endHtml;
            }
        }
        for (var j = 0; j < list.length; j++) {
            var item = list[j];
            if (item.start <= pos && item.end > pos) {
                res += item.startHtml;
            }
        }
        lastIndex = pos;
    }
    
    res += text.substring(lastIndex);
    
    return res;
    
}

IriSP.log = function() {
    if (typeof console !== "undefined" && typeof IriSP.logging !== "undefined" && IriSP.logging) {
        console.log.apply(console, arguments);
    }
}
/* TODO: Separate Project-specific data from Source */

/* model.js is where data is stored in a standard form, whatever the serializer */
IriSP.Model = (function (ns) {
    
    function pad(n, x, b) {
        b = b || 10;
        var s = (x).toString(b);
        while (s.length < n) {
            s = "0" + s;
        }
        return s;
    }
    
    function rand16(n) {
        return pad(n, Math.floor(Math.random()*Math.pow(16,n)), 16);
    }
    
    var uidbase = rand16(8) + "-" + rand16(4) + "-", uidincrement = Math.floor(Math.random()*0x10000);
    
    var charsub = [
        '[aáàâä]',
        '[cç]',
        '[eéèêë]',
        '[iíìîï]',
        '[oóòôö]',
        '[uùûü]'
    ];
    
    var removeChars = [
        String.fromCharCode(768), String.fromCharCode(769), String.fromCharCode(770), String.fromCharCode(771), String.fromCharCode(807),
        "｛", "｝", "（", "）", "［", "］", "【", "】", "、", "・", "‥", "。", "「", "」", "『", "』", "〜", "：", "！", "？", "　",
        ",", " ", ";", "(", ")", ".", "*", "+", "\\", "?", "|", "{", "}", "[", "]", "^", "#", "/"
    ]
    
var Model = {
    _SOURCE_STATUS_EMPTY : 0,
    _SOURCE_STATUS_WAITING : 1,
    _SOURCE_STATUS_READY : 2,
    getUID : function() {
        return uidbase + pad(4, (++uidincrement % 0x10000), 16) + "-" + rand16(4) + "-" + rand16(6) + rand16(6);
    },
    isLocalURL : function(url) {
        var matches = url.match(/^(\w+:)\/\/([^/]+)/);
        if (matches) {
            return(matches[1] === document.location.protocol && matches[2] === document.location.host)
        }
        return true;
    },
    regexpFromTextOrArray : function(_textOrArray, _testOnly, _iexact) {
        var _testOnly = _testOnly || false,
            _iexact = _iexact || false;
        function escapeText(_text) {
            return _text.replace(/([\\\*\+\?\|\{\[\}\]\(\)\^\$\.\#\/])/gm, '\\$1');
        }
        var _source = 
            typeof _textOrArray === "string"
            ? escapeText(_textOrArray)
            : ns._(_textOrArray).map(escapeText).join("|"),
            _flags = 'im';
        if (!_testOnly) {
            _source = '(' + _source + ')';
            _flags += 'g';
        }
        if (_iexact) {
            _source = '^' + _source + '$';
        }
        return new RegExp( _source, _flags);
    },
    fullTextRegexps: function(_text) {
        var remsrc = "[\\" + removeChars.join("\\") + "]",
            remrx = new RegExp(remsrc,"gm"),
            txt = _text.toLowerCase().replace(remrx,"")
            res = [],
            charsrx = ns._(charsub).map(function(c) {
                return new RegExp(c);
            }),
            src = "";
        for (var j = 0; j < txt.length; j++) {
            if (j) {
                src += remsrc + "*";
            }
            var l = txt[j];
            ns._(charsub).each(function(v, k) {
                l = l.replace(charsrx[k], v);
            });
            src += l;
        }
        return "(" + src + ")";
    },
    isoToDate : function(_str) {
        // http://delete.me.uk/2005/03/iso8601.html
        var regexp = "([0-9]{4})(-([0-9]{2})(-([0-9]{2})(T([0-9]{2}):([0-9]{2})(:([0-9]{2})(\.([0-9]+))?)?(Z|(([-+])([0-9]{2}):([0-9]{2})))?)?)?)?";
        var d = _str.match(new RegExp(regexp));
    
        var offset = 0;
        var date = new Date(d[1], 0, 1);
    
        if (d[3]) { date.setMonth(d[3] - 1); }
        if (d[5]) { date.setDate(d[5]); }
        if (d[7]) { date.setHours(d[7]); }
        if (d[8]) { date.setMinutes(d[8]); }
        if (d[10]) { date.setSeconds(d[10]); }
        if (d[12]) { date.setMilliseconds(Number("0." + d[12]) * 1000); }
        if (d[14]) {
            offset = (Number(d[16]) * 60) + Number(d[17]);
            offset *= ((d[15] == '-') ? 1 : -1);
        }
    
        offset -= date.getTimezoneOffset();
        time = (Number(date) + (offset * 60 * 1000));
        var _res = new Date();
        _res.setTime(Number(time));
        return _res;
    },
    dateToIso : function(_d) {
        var d = _d ? new Date(_d) : new Date();
        return d.getUTCFullYear()+'-'  
            + pad(2, d.getUTCMonth()+1)+'-'  
            + pad(2, d.getUTCDate())+'T'  
            + pad(2, d.getUTCHours())+':'  
            + pad(2, d.getUTCMinutes())+':'  
            + pad(2, d.getUTCSeconds())+'Z'  
    }
}

/*
 * Model.List is a class for a list of elements (e.g. annotations, medias, etc. that each have a distinct ID)
 */
Model.List = function(_directory) {
    Array.call(this);
    this.directory = _directory;
    this.idIndex = [];
    this.__events = {};
    if (typeof _directory == "undefined") {
        console.trace();
        throw "Error : new Model.List(directory): directory is undefined";
    }
    var _this =  this;
    this.on("clear-search", function() {
        _this.searching = false;
        _this.regexp = undefined;
        _this.forEach(function(_element) {
            _element.found = undefined;
        });
        _this.trigger("search-cleared");
    })
}

Model.List.prototype = new Array();

Model.List.prototype.hasId = function(_id) {
    return ns._(this.idIndex).include(_id);
}

/* On recent browsers, forEach and map are defined and do what we want.
 * Otherwise, we'll use the Underscore.js functions
 */
if (typeof Array.prototype.forEach === "undefined") {
    Model.List.prototype.forEach = function(_callback) {
        var _this = this;
        ns._(this).forEach(function(_value, _key) {
            _callback(_value, _key, _this);
        });
    }
}

if (typeof Array.prototype.map === "undefined") {
    Model.List.prototype.map = function(_callback) {
        var _this = this;
        return ns._(this).map(function(_value, _key) {
            return _callback(_value, _key, _this);
        });
    }
}

Model.List.prototype.pluck = function(_key) {
    return this.map(function(_value) {
        return _value[_key];
    });
}

/* We override Array's filter function because it doesn't return an Model.List
 */
Model.List.prototype.filter = function(_callback) {
    var _this = this,
        _res = new Model.List(this.directory);
    _res.addElements(ns._(this).filter(function(_value, _key) {
        return _callback(_value, _key, _this);
    }));
    return _res;
}

Model.List.prototype.slice = function(_start, _end) {
    var _res = new Model.List(this.directory);
    _res.addElements(Array.prototype.slice.call(this, _start, _end));
    return _res;
}

Model.List.prototype.splice = function(_start, _end) {
    var _res = new Model.List(this.directory);
    _res.addElements(Array.prototype.splice.call(this, _start, _end));
    this.idIndex.splice(_start, _end);
    return _res;
}

/* Array has a sort function, but it's not as interesting as Underscore.js's sortBy
 * and won't return a new Model.List
 */
Model.List.prototype.sortBy = function(_callback) {
    var _this = this,
        _res = new Model.List(this.directory);
    _res.addElements(ns._(this).sortBy(function(_value, _key) {
        return _callback(_value, _key, _this);
    }));
    return _res;
}

/* Title and Description are basic information for (almost) all element types,
 * here we can search by these criteria
 */
Model.List.prototype.searchByTitle = function(_text, _iexact) {
    var _iexact = _iexact || false,
        _rgxp = Model.regexpFromTextOrArray(_text, true, _iexact);
    return this.filter(function(_element) {
        return _rgxp.test(_element.title);
    });
}

Model.List.prototype.searchByDescription = function(_text, _iexact) {
    var _iexact = _iexact || false,
        _rgxp = Model.regexpFromTextOrArray(_text, true, _iexact);
    return this.filter(function(_element) {
        return _rgxp.test(_element.description);
    });
}

Model.List.prototype.searchByTextFields = function(_text, _iexact) {
    var _iexact = _iexact || false,
        _rgxp =  Model.regexpFromTextOrArray(_text, true, _iexact);
    return this.filter(function(_element) {
        var keywords = (_element.keywords || _element.getTagTexts() || []).join(", ");
        return _rgxp.test(_element.description) || _rgxp.test(_element.title) || _rgxp.test(keywords);
    });
}

Model.List.prototype.search = function(_text) {
    if (!_text) {
        this.trigger("clear-search");
        return this;
    }
    this.searching = true;
    this.trigger("search", _text);
    var rxsource = Model.fullTextRegexps(_text)
        rgxp = new RegExp(rxsource,"im"),
        this.regexp = new RegExp(rxsource,"gim");
    var res = this.filter(function(_element, _k) {
        var titlematch = rgxp.test(_element.title),
            descmatch = rgxp.test(_element.description),
            _isfound = !!(titlematch || descmatch);
        _element.found = _isfound;
        _element.trigger(_isfound ? "found" : "not-found");
        return _isfound;
    });
    this.trigger(res.length ? "found" : "not-found",res);
    return res;
}

Model.List.prototype.getTitles = function() {
    return this.map(function(_el) {
        return _el.title;
    });
}

Model.List.prototype.addId = function(_id) {
    var _el = this.directory.getElement(_id)
    if (!this.hasId(_id) && typeof _el !== "undefined") {
        this.idIndex.push(_id);
        Array.prototype.push.call(this, _el);
    }
}

Model.List.prototype.push = function(_el) {
    if (typeof _el === "undefined") {
        return;
    }
    var _index = (ns._(this.idIndex).indexOf(_el.id));
    if (_index === -1) {
        this.idIndex.push(_el.id);
        Array.prototype.push.call(this, _el);
    } else {
        this[_index] = _el;
    }
}

Model.List.prototype.addIds = function(_array) {
    var _l = _array.length,
        _this = this;
    ns._(_array).forEach(function(_id) {
        _this.addId(_id);
    });
}

Model.List.prototype.addElements = function(_array) {
    var _this = this;
    ns._(_array).forEach(function(_el) {
        _this.push(_el);
    });
}

Model.List.prototype.removeId = function(_id, _deleteFromDirectory) {
    var _deleteFromDirectory = _deleteFromDirectory || false,
        _index = (ns._(this.idIndex).indexOf(_id));
    if (_index !== -1) {
        this.splice(_index,1);
    }
    if (_deleteFromDirectory) {
        delete this.directory.elements[_id];
    }
}

Model.List.prototype.removeElement = function(_el, _deleteFromDirectory) {
    var _deleteFromDirectory = _deleteFromDirectory || false;
    this.removeId(_el.id);
}

Model.List.prototype.removeIds = function(_list, _deleteFromDirectory) {
    var _deleteFromDirectory = _deleteFromDirectory || false,
        _this = this;
    ns._(_list).forEach(function(_id) {
        _this.removeId(_id);
    });
}

Model.List.prototype.removeElements = function(_list, _deleteFromDirectory) {
    var _deleteFromDirectory = _deleteFromDirectory || false,
        _this = this;
    ns._(_list).forEach(function(_el) {
        _this.removeElement(_el);
    });
}

Model.List.prototype.on = function(_event, _callback) {
    if (typeof this.__events[_event] === "undefined") {
        this.__events[_event] = [];
    }
    this.__events[_event].push(_callback);
}

Model.List.prototype.off = function(_event, _callback) {
    if (typeof this.__events[_event] !== "undefined") {
        this.__events[_event] = ns._(this.__events[_event]).reject(function(_fn) {
            return _fn === _callback;
        });
    }
}

Model.List.prototype.trigger = function(_event, _data) {
    var _list = this;
    ns._(this.__events[_event]).each(function(_callback) {
        _callback.call(_list, _data);
    });
}

/* A simple time management object, that helps converting millisecs to seconds and strings,
 * without the clumsiness of the original Date object.
 */

Model.Time = function(_milliseconds) {
    this.milliseconds = 0;
    this.setMilliseconds(_milliseconds);
}

Model.Time.prototype.setMilliseconds = function(_milliseconds) {
    var _ante = this.milliseconds;
    switch(typeof _milliseconds) {
        case "string":
            this.milliseconds = parseInt(_milliseconds);
            break;
        case "number":
            this.milliseconds = Math.floor(_milliseconds);
            break;
        case "object":
            this.milliseconds = parseInt(_milliseconds.valueOf());
            break;
        default:
            this.milliseconds = 0;
    }
    if (this.milliseconds === NaN) {
        this.milliseconds = _ante;
    }
}

Model.Time.prototype.setSeconds = function(_seconds) {
    this.milliseconds = 1000 * _seconds;
}

Model.Time.prototype.getSeconds = function() {
    return this.milliseconds / 1000;
}

Model.Time.prototype.getHMS = function() {
    var _totalSeconds = Math.abs(Math.floor(this.getSeconds()));
    return {
        hours : Math.floor(_totalSeconds / 3600),
        minutes : (Math.floor(_totalSeconds / 60) % 60),
        seconds : _totalSeconds % 60,
        milliseconds: this.milliseconds % 1000
    } 
}

Model.Time.prototype.add = function(_milliseconds) {
    this.milliseconds += new Model.Time(_milliseconds).milliseconds;
}

Model.Time.prototype.valueOf = function() {
    return this.milliseconds;
}

Model.Time.prototype.toString = function(showCs) {
    var _hms = this.getHMS(),
        _res = '';
    if (_hms.hours) {
        _res += _hms.hours + ':'
    }
    _res += pad(2, _hms.minutes) + ':' + pad(2, _hms.seconds);
    if (showCs) {
        _res += "." + Math.floor(_hms.milliseconds / 100)
    }
    return _res;
}

/* Model.Reference handles references between elements
 */

Model.Reference = function(_source, _idRef) {
    this.source = _source;
    this.id = _idRef;
    if (typeof _idRef === "object") {
        this.isList = true;
    } else {
        this.isList = false;
    }
    this.refresh();
}

Model.Reference.prototype.refresh = function() {
    if (this.isList) {
        this.contents = new Model.List(this.source.directory);
        this.contents.addIds(this.id);
    } else {
        this.contents = this.source.getElement(this.id);
    }
    
}

Model.Reference.prototype.getContents = function() {
    if (typeof this.contents === "undefined" || (this.isList && this.contents.length != this.id.length)) {
        this.refresh();
    }
    return this.contents;
}

Model.Reference.prototype.isOrHasId = function(_idRef) {
    if (this.isList) {
        return (ns._(this.id).indexOf(_idRef) !== -1)
    } else {
        return (this.id == _idRef);
    }
}

/* */

Model.Element = function(_id, _source) {
    this.elementType = 'element';
    this.title = "";
    this.description = "";
    this.__events = {}
    if (typeof _source === "undefined") {
        return;
    }
    if (typeof _id === "undefined" || !_id) {
        _id = Model.getUID();
    }
    this.id = _id;
    this.source = _source;
    if (_source !== this) {
        this.source.directory.addElement(this);
    }
}

Model.Element.prototype.toString = function() {
    return this.elementType + (this.elementType !== 'element' ? ', id=' + this.id + ', title="' + this.title + '"' : '');
}

Model.Element.prototype.setReference = function(_elementType, _idRef) {
    this[_elementType] = new Model.Reference(this.source, _idRef);
}

Model.Element.prototype.getReference = function(_elementType) {
    if (typeof this[_elementType] !== "undefined") {
        return this[_elementType].getContents();
    }
}

Model.Element.prototype.getRelated = function(_elementType, _global) {
    _global = (typeof _global !== "undefined" && _global);
    var _this = this;
    return this.source.getList(_elementType, _global).filter(function(_el) {
        var _ref = _el[_this.elementType];
        return _ref && _ref.isOrHasId(_this.id);
    });
}

Model.Element.prototype.on = function(_event, _callback) {
    if (typeof this.__events[_event] === "undefined") {
        this.__events[_event] = [];
    }
    this.__events[_event].push(_callback);
}

Model.Element.prototype.off = function(_event, _callback) {
    if (typeof this.__events[_event] !== "undefined") {
        this.__events[_event] = ns._(this.__events[_event]).reject(function(_fn) {
            return _fn === _callback;
        });
    }
}

Model.Element.prototype.trigger = function(_event, _data) {
    var _element = this;
    ns._(this.__events[_event]).each(function(_callback) {
        _callback.call(_element, _data);
    });
}

/* */

Model.Playable = function(_id, _source) {
    Model.Element.call(this, _id, _source);
    if (typeof _source === "undefined") {
        return;
    }
    this.elementType = 'playable';
    this.currentTime = new Model.Time();
    this.volume = .5;
    this.paused = true;
    this.muted = false;
    this.loadedMetadata = false;
    var _this = this;
    this.on("play", function() {
        _this.paused = false;
    });
    this.on("pause", function() {
        _this.paused = true;
    });
    this.on("timeupdate", function(_time) {
        _this.currentTime = _time;
        _this.getAnnotations().filter(function(_a) {
            return (_a.end <= _time || _a.begin > _time) && _a.playing
        }).forEach(function(_a) {
            _a.playing = false;
            _a.trigger("leave");
            _this.trigger("leave-annotation",_a);
        });
        _this.getAnnotations().filter(function(_a) {
            return _a.begin <= _time && _a.end > _time && !_a.playing
        }).forEach(function(_a) {
            _a.playing = true;
            _a.trigger("enter");
            _this.trigger("enter-annotation",_a);
        });
    });
    this.on("loadedmetadata", function() {
        _this.loadedMetadata = true;
    })
}

Model.Playable.prototype = new Model.Element();

Model.Playable.prototype.getCurrentTime = function() { 
    return this.currentTime;
}

Model.Playable.prototype.getVolume = function() {
    return this.volume;
}

Model.Playable.prototype.getPaused = function() {
    return this.paused;
}

Model.Playable.prototype.getMuted = function() {
    return this.muted;
}

Model.Playable.prototype.setCurrentTime = function(_time) {
    this.trigger("setcurrenttime",_time);
}

Model.Playable.prototype.setVolume = function(_vol) {
    this.trigger("setvolume",_vol);
}

Model.Playable.prototype.setMuted = function(_muted) {
    this.trigger("setmuted",_muted);
}

Model.Playable.prototype.play = function() {
    this.trigger("setplay");
}

Model.Playable.prototype.pause = function() {
    this.trigger("setpause");
}

Model.Playable.prototype.show = function() {}

Model.Playable.prototype.hide = function() {}

/* */

Model.Media = function(_id, _source) {
    Model.Playable.call(this, _id, _source);
    this.elementType = 'media';
    this.duration = new Model.Time();
    this.video = '';
    var _this = this;
}

Model.Media.prototype = new Model.Playable();

/* Default functions to be overriden by players */
    
Model.Media.prototype.setDuration = function(_durationMs) {
    this.duration.setMilliseconds(_durationMs);
}

Model.Media.prototype.getAnnotations = function() {
    return this.getRelated("annotation");
}

Model.Media.prototype.getAnnotationsByTypeTitle = function(_title) {
    var _annTypes = this.source.getAnnotationTypes().searchByTitle(_title).pluck("id");
    if (_annTypes.length) {
        return this.getAnnotations().filter(function(_annotation) {
            return ns._(_annTypes).indexOf(_annotation.getAnnotationType().id) !== -1;
        });
    } else {
        return new Model.List(this.source.directory)
    }
}

/* */

Model.Tag = function(_id, _source) {
    Model.Element.call(this, _id, _source);
    this.elementType = 'tag';
}

Model.Tag.prototype = new Model.Element();

Model.Tag.prototype.getAnnotations = function() {
    return this.getRelated("annotation");
}

/* */
Model.AnnotationType = function(_id, _source) {
    Model.Element.call(this, _id, _source);
    this.elementType = 'annotationType';
}

Model.AnnotationType.prototype = new Model.Element();

Model.AnnotationType.prototype.getAnnotations = function() {
    return this.getRelated("annotation");
}

/* Annotation
 * */

Model.Annotation = function(_id, _source) {
    Model.Element.call(this, _id, _source);
    this.elementType = 'annotation';
    this.begin = new Model.Time();
    this.end = new Model.Time();
    this.tag = new Model.Reference(_source, []);
    this.playing = false;
    var _this = this;
    this.on("click", function() {
        _this.getMedia().setCurrentTime(_this.begin);
    });
}

Model.Annotation.prototype = new Model.Element();

Model.Annotation.prototype.setBegin = function(_beginMs) {
    this.begin.setMilliseconds(Math.max(0,_beginMs));
    this.trigger("change-begin");
    if (this.end < this.begin) {
        this.setEnd(this.begin);
    }
}

Model.Annotation.prototype.setEnd = function(_endMs) {
    this.end.setMilliseconds(Math.min(_endMs, this.getMedia().duration.milliseconds));
    this.trigger("change-end");
    if (this.end < this.begin) {
        this.setBegin(this.end);
    }
}

Model.Annotation.prototype.setDuration = function(_durMs) {
    this.setEnd(_durMs + this.begin.milliseconds);
}

Model.Annotation.prototype.setMedia = function(_idRef) {
    this.setReference("media", _idRef);
}

Model.Annotation.prototype.getMedia = function() {
    return this.getReference("media");
}

Model.Annotation.prototype.setAnnotationType = function(_idRef) {
    this.setReference("annotationType", _idRef);
}

Model.Annotation.prototype.getAnnotationType = function() {
    return this.getReference("annotationType");
}

Model.Annotation.prototype.setTags = function(_idRefs) {
    this.setReference("tag", _idRefs);
}

Model.Annotation.prototype.getTags = function() {
    return this.getReference("tag");
}

Model.Annotation.prototype.getTagTexts = function() {
    return this.getTags().getTitles();
}

Model.Annotation.prototype.getDuration = function() {
    return new Model.Time(this.end.milliseconds - this.begin.milliseconds)
}

/* */

Model.MashedAnnotation = function(_mashup, _annotation) {
    Model.Element.call(this, _mashup.id + "_" + _annotation.id, _annotation.source);
    this.elementType = 'mashedAnnotation';
    this.annotation = _annotation;
    this.begin = new Model.Time();
    this.end = new Model.Time();
    this.duration = new Model.Time();
    this.title = this.annotation.title;
    this.description = this.annotation.description;
    this.color = this.annotation.color;
    var _this = this;
    this.on("click", function() {
        _mashup.setCurrentTime(_this.begin);
    });
    this.on("enter", function() {
        _this.annotation.trigger("enter");
    });
    this.on("leave", function() {
        _this.annotation.trigger("leave");
    });
}

Model.MashedAnnotation.prototype = new Model.Element(null);

Model.MashedAnnotation.prototype.getMedia = function() {
    return this.annotation.getReference("media");
}

Model.MashedAnnotation.prototype.getAnnotationType = function() {
    return this.annotation.getReference("annotationType");
}

Model.MashedAnnotation.prototype.getTags = function() {
    return this.annotation.getReference("tag");
}

Model.MashedAnnotation.prototype.getTagTexts = function() {
    return this.annotation.getTags().getTitles();
}

Model.MashedAnnotation.prototype.getDuration = function() {
    return this.annotation.getDuration();
}

Model.MashedAnnotation.prototype.setBegin = function(_begin) {
    this.begin.setMilliseconds(_begin);
    this.duration.setMilliseconds(this.annotation.getDuration());
    this.end.setMilliseconds(_begin + this.duration);
}

/* */

Model.Mashup = function(_id, _source) {
    Model.Playable.call(this, _id, _source);
    this.elementType = 'mashup';
    this.duration = new Model.Time();
    this.segments = new Model.List(_source.directory);
    this.loaded = false;
    var _this = this;
    this._updateTimes = function() {
        _this.updateTimes();
        _this.trigger("change");
    }
    this.on("add", this._updateTimes);
    this.on("remove", this._updateTimes);
}

Model.Mashup.prototype = new Model.Playable();

Model.Mashup.prototype.updateTimes = function() {
    var _time = 0;
    this.segments.forEach(function(_segment) {
        _segment.setBegin(_time);
        _time = _segment.end;
    });
    this.duration.setMilliseconds(_time);
}

Model.Mashup.prototype.addAnnotation = function(_annotation, _defer) {
    var _mashedAnnotation = new Model.MashedAnnotation(this, _annotation),
        _defer = _defer || false;
    this.segments.push(_mashedAnnotation);
    _annotation.on("change-begin", this._updateTimes);
    _annotation.on("change-end", this._updateTimes);
    if (!_defer) {
        this.trigger("add");
    }
}

Model.Mashup.prototype.addAnnotationById = function(_elId, _defer) {
    var _annotation = this.source.getElement(_elId),
        _defer = _defer || false;
    if (typeof _annotation !== "undefined") {
        this.addAnnotation(_annotation, _defer);
    }
}

Model.Mashup.prototype.addAnnotations = function(_segments) {
    var _this = this;
    ns._(_segments).forEach(function(_segment) {
        _this.addAnnotation(_segment, true);
    });
    this.trigger("add");
}

Model.Mashup.prototype.addAnnotationsById = function(_segments) {
    var _this = this;
    ns._(_segments).forEach(function(_segment) {
        _this.addAnnotationById(_segment, true);
    });
    this.trigger("add");
}

Model.Mashup.prototype.removeAnnotation = function(_annotation, _defer) {
    var _defer = _defer || false;
    _annotation.off("change-begin", this._updateTimes);
    _annotation.off("change-end", this._updateTimes);
    this.segments.removeId(this.id + "_" + _annotation.id);
    if (!_defer) {
        this.trigger("remove");
    }
}

Model.Mashup.prototype.removeAnnotationById = function(_annId, _defer) {
    var _defer = _defer || false;
    var _annotation = this.source.getElement(_annId);

    if (_annotation) {
        this.removeAnnotation(_annotation, _defer);
    }
    if (!_defer) {
        this.trigger("remove");
    }
}

Model.Mashup.prototype.setAnnotations = function(_segments) {
    while (this.segments.length) {
        this.removeAnnotation(this.segments[0].annotation, true);
    }
    this.addAnnotations(_segments);
}

Model.Mashup.prototype.setAnnotationsById = function(_segments) {
    while (this.segments.length) {
        this.removeAnnotation(this.segments[0].annotation, true);
    }
    this.addAnnotationsById(_segments);
}

Model.Mashup.prototype.hasAnnotation = function(_annotation) {
    return !!ns._(this.segments).find(function(_s) {
        return _s.annotation === _annotation
    });
}

Model.Mashup.prototype.getAnnotation = function(_annotation) {
    return ns._(this.segments).find(function(_s) {
        return _s.annotation === _annotation
    });
}

Model.Mashup.prototype.getAnnotationById = function(_id) {
    return ns._(this.segments).find(function(_s) {
        return _s.annotation.id === _id
    });
}

Model.Mashup.prototype.getAnnotations = function() {
    return this.segments;
}

Model.Mashup.prototype.getOriginalAnnotations = function() {
    var annotations = new Model.List(this.source.directory);
    this.segments.forEach(function(_s) {
        annotations.push(_s.annotation);
    });
    return annotations;
}

Model.Mashup.prototype.getMedias = function() {
    var medias = new Model.List(this.source.directory);
    this.segments.forEach(function(_annotation) {
        medias.push(_annotation.getMedia())
    })
    return medias;
}

Model.Mashup.prototype.getAnnotationsByTypeTitle = function(_title) {
    var _annTypes = this.source.getAnnotationTypes().searchByTitle(_title).pluck("id");
    if (_annTypes.length) {
        return this.getAnnotations().filter(function(_annotation) {
            return ns._(_annTypes).indexOf(_annotation.getAnnotationType().id) !== -1;
        });
    } else {
        return new Model.List(this.source.directory)
    }
}

Model.Mashup.prototype.getAnnotationAtTime = function(_time) {
    var _list = this.segments.filter(function(_annotation) {
        return _annotation.begin <= _time && _annotation.end > _time;
    });
    if (_list.length) {
        return _list[0];
    } else {
        return undefined;
    }
}

Model.Mashup.prototype.getMediaAtTime = function(_time) {
    var _annotation = this.getAnnotationAtTime(_time);
    if (typeof _annotation !== "undefined") {
        return _annotation.getMedia();
    } else {
        return undefined;
    }
}

/* */

Model.Source = function(_config) {
    Model.Element.call(this, false, this);
    this.status = Model._SOURCE_STATUS_EMPTY;
    this.elementType = "source";
    if (typeof _config !== "undefined") {
        var _this = this;
        ns._(_config).forEach(function(_v, _k) {
            _this[_k] = _v;
        })
        this.callbackQueue = [];
        this.contents = {};
        this.get();
    }
}

Model.Source.prototype = new Model.Element();

Model.Source.prototype.addList = function(_listId, _contents) {
    if (typeof this.contents[_listId] === "undefined") {
        this.contents[_listId] = new Model.List(this.directory);
    }
    this.contents[_listId].addElements(_contents);
}

Model.Source.prototype.getList = function(_listId, _global) {
    _global = (typeof _global !== "undefined" && _global);
    if (_global) {
        return this.directory.getGlobalList().filter(function(_e) {
            return (_e.elementType === _listId);
        });
    } else {
        return this.contents[_listId] || new IriSP.Model.List(this.directory);
    }
}

Model.Source.prototype.forEach = function(_callback) {
    var _this = this;
    ns._(this.contents).forEach(function(_value, _key) {
        _callback.call(_this, _value, _key);
    })
}

Model.Source.prototype.getElement = function(_elId) {
    return this.directory.getElement(_elId);
}

Model.Source.prototype.get = function() {
    this.status = Model._SOURCE_STATUS_WAITING;
    this.handleCallbacks();
}

/* We defer the callbacks calls so they execute after the queue is cleared */
Model.Source.prototype.deferCallback = function(_callback) {
    var _this = this;
    ns._.defer(function() {
        _callback.call(_this);
    });
}

Model.Source.prototype.handleCallbacks = function() {
    this.status = Model._SOURCE_STATUS_READY;
    while (this.callbackQueue.length) {
        this.deferCallback(this.callbackQueue.splice(0,1)[0]);
    }
}
Model.Source.prototype.onLoad = function(_callback) {
    if (this.status === Model._SOURCE_STATUS_READY) {
        this.deferCallback(_callback);
    } else {
        this.callbackQueue.push(_callback);
    }
}

Model.Source.prototype.serialize = function() {
    return this.serializer.serialize(this);
}

Model.Source.prototype.deSerialize = function(_data) {
    this.serializer.deSerialize(_data, this);
}

Model.Source.prototype.getAnnotations = function(_global) {
    _global = (typeof _global !== "undefined" && _global);
    return this.getList("annotation", _global);
}

Model.Source.prototype.getMedias = function(_global) {
    _global = (typeof _global !== "undefined" && _global);
    return this.getList("media", _global);
}

Model.Source.prototype.getTags = function(_global) {
    _global = (typeof _global !== "undefined" && _global);
    return this.getList("tag", _global);
}

Model.Source.prototype.getMashups = function(_global) {
    _global = (typeof _global !== "undefined" && _global);
    return this.getList("mashup", _global);
}

Model.Source.prototype.getAnnotationTypes = function(_global) {
    _global = (typeof _global !== "undefined" && _global);
    return this.getList("annotationType", _global);
}

Model.Source.prototype.getAnnotationsByTypeTitle = function(_title, _global) {
    _global = (typeof _global !== "undefined" && _global);
    var _res = new Model.List(this.directory),
        _annTypes = this.getAnnotationTypes(_global).searchByTitle(_title);
    _annTypes.forEach(function(_annType) {
        _res.addElements(_annType.getAnnotations(_global));
    })
    return _res;
}

Model.Source.prototype.getDuration = function() {
    var _m = this.currentMedia;
    if (typeof _m !== "undefined") {
        return this.currentMedia.duration;
    }
}

Model.Source.prototype.getCurrentMedia = function(_opts) {
    if (typeof this.currentMedia === "undefined") {
        if (_opts.is_mashup) {
            var _mashups = this.getMashups();
            if (_mashups.length) {
                this.currentMedia = _mashups[0];
            }
        } else {
            var _medias = this.getMedias();
            if (_medias.length) {
                this.currentMedia = _medias[0];
            }
        }
    }
    return this.currentMedia;
}

Model.Source.prototype.merge = function(_source) {
    var _this = this;
    _source.forEach(function(_value, _key) {
        _this.getList(_key).addElements(_value);
    });
}

/* */

Model.RemoteSource = function(_config) {
    Model.Source.call(this, _config);
}

Model.RemoteSource.prototype = new Model.Source();

Model.RemoteSource.prototype.get = function() {
    this.status = Model._SOURCE_STATUS_WAITING;
    var _this = this,
        urlparams = this.url_params || {},
        dataType = (Model.isLocalURL(this.url) ? "json" : "jsonp");
    urlparams.format = dataType;
    ns.jQuery.ajax({
        url: this.url,
        dataType: dataType,
        data: urlparams,
        traditional: true,
        success: function(_result) {
            _this.deSerialize(_result);
            _this.handleCallbacks();
        }
    });
}

/* */

Model.Directory = function() {
    this.remoteSources = {};
    this.elements = {};
}

Model.Directory.prototype.remoteSource = function(_properties) {
    if (typeof _properties !== "object" || typeof _properties.url === "undefined") {
        throw "Error : Model.Directory.remoteSource(configuration): configuration.url is undefined";
    }
    var _config = ns._({ directory: this }).extend(_properties);
    _config.url_params = _config.url_params || {};
    var _hash = _config.url + "?" + ns.jQuery.param(_config.url_params);
    if (typeof this.remoteSources[_hash] === "undefined") {
        this.remoteSources[_hash] = new Model.RemoteSource(_config);
    }
    return this.remoteSources[_hash];
}

Model.Directory.prototype.newLocalSource = function(_properties) {
    var _config = ns._({ directory: this }).extend(_properties),
        _res = new Model.Source(_config);
    return _res;
}

Model.Directory.prototype.getElement = function(_id) {
    return this.elements[_id];
}

Model.Directory.prototype.addElement = function(_element) {
    this.elements[_element.id] = _element;
}

Model.Directory.prototype.getGlobalList = function() {
    var _res = new Model.List(this);
    _res.addIds(ns._(this.elements).keys());
    return _res;
}

return Model;

})(IriSP);

/* END model.js */

IriSP.language = 'en';

IriSP.libFiles = {
    defaultDir : "js/libs/",
    inDefaultDir : {
        underscore : "underscore-min.js",
        Mustache : "mustache.js",
        jQuery : "jquery.min.js",
        jQueryUI : "jquery-ui.min.js",
        swfObject : "swfobject.js",
        cssjQueryUI : "jquery-ui.css",
        popcorn : "popcorn-complete.min.js",
        jwplayer : "jwplayer.js",
        raphael : "raphael-min.js",
        tracemanager : "tracemanager.js",
        jwPlayerSWF : "player.swf",
        json : "json2.js",
        zeroClipboardJs: "ZeroClipboard.js",
        zeroClipboardSwf: "ZeroClipboard.swf",
        backbone: "backbone.js",
        backboneRelational: "backbone-relational.js",
        paper: "paper.js",
        jqueryMousewheel: "jquery.mousewheel.min.js",
        renkanPublish: "renkan-publish.js",
        processing: "processing-1.3.6.min.js",
        recordMicSwf: "record_mic.swf"
    },
    locations : {
        // use to define locations outside default_dir
    },
    cdn : {
        jQuery : "http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.2.min.js",
        jQueryUI : "http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.22/jquery-ui.min.js",
        swfObject : "http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js",
        cssjQueryUI : "http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.22/themes/ui-lightness/jquery-ui.css",
        underscore : "http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.3.3/underscore-min.js",
        Mustache : "http://cdnjs.cloudflare.com/ajax/libs/mustache.js/0.5.0-dev/mustache.min.js",
        raphael : "http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js",
        json : "http://cdnjs.cloudflare.com/ajax/libs/json2/20110223/json2.js",
        popcorn: "http://cdn.popcornjs.org/code/dist/popcorn-complete.min.js"
    },
    useCdn : false
}

IriSP.widgetsDir = 'widgets';

IriSP.widgetsRequirements = {
    PopcornPlayer: {
        noCss: true,
        requires: [ "popcorn" ]
    },
    HtmlPlayer: {
        noCss: true
    },
    JwpPlayer: {
        noCss: true,
        requires: [ "jwplayer" ]
    },
    DailymotionPlayer: {
        noCss: true,
        requires: [ "swfObject" ]
    },
    AdaptivePlayer: {
        noCss: true
    },
    AutoPlayer: {
        noCss: true
    },
    AnnotationsList: {
        requires: [ "jwplayer" ]
    },
    Sparkline: {
        noCss: true,
        requires: [ "raphael" ]
    },
    Arrow: {
        noCss: true,
        requires: [ "raphael" ]
    },
    Mediafragment: {
        noCss: true
    },
    Trace : {
        noCss: true,
        requires: [ "tracemanager" ]
    },
    Slideshare: {
        requires: [ "swfObject" ]
    },
    Social: {
        requires: [ "zeroClipboardJs" ]
    },
    Renkan: {
        requires: [ "backbone", "backboneRelational", "paper", "jqueryMousewheel", "renkanPublish" ]
    },
    KnowledgeConcierge: {
        requires: [ "processing" ]
    },
    MultiSegments: {
        noCss: true
    }
}

IriSP.guiDefaults = {
    width : 640,            
    container : 'LdtPlayer',
    spacer_div_height : 0
}
/* Definition of an ancestor for the Widget classes */

if (typeof IriSP.Widgets === "undefined") {
    IriSP.Widgets = {}
}

/**
 * @class IriSP.Widget is an "abstract" class. It's mostly used to define some properties common to every widget.
 *
 *  Note that widget constructors are never called directly by the user. Instead, the widgets are instantiated by functions
 *  defined in init.js
 *
 * @constructor
 * @param player - a reference to the player widget
 * @param config - configuration options for the widget
 */


IriSP.Widgets.Widget = function(player, config) {
    
    if( typeof player === "undefined") {
        /* Probably an abstract call of the class when
         * individual widgets set their prototype */
        return;
    }
    
    this.__subwidgets = [];
    
    /* Setting all the configuration options */
    var _type = config.type,
        _config = IriSP._.defaults({}, config, player.config.default_options, this.defaults),
        _this = this;
    
    IriSP._(_config).forEach(function(_value, _key) {
       _this[_key] = _value;
    });
    
    this.$ = IriSP.jQuery('#' + this.container);
    
    if (typeof this.width === "undefined") {
        this.width = this.$.width();
    } else {
        this.$.css("width", this.width);
    }
    
    if (typeof this.height !== "undefined") {
        this.$.css("height", this.height);
    }
    
    /* Setting this.player at the end in case it's been overriden
     * by a configuration option of the same name :-(
     */
    this.player = player;
    
    /* Adding classes and html attributes */
    this.$.addClass("Ldt-TraceMe Ldt-Widget").attr("widget-type", _type);
    
    this.l10n = (
        typeof this.messages[IriSP.language] !== "undefined"
        ? this.messages[IriSP.language]
        : (
            IriSP.language.length > 2 && typeof this.messages[IriSP.language.substr(0,2)] !== "undefined"
            ? this.messages[IriSP.language.substr(0,2)]
            : this.messages["en"]
        )
    );
    
    /* Loading Metadata if required */
    
    if (this.metadata) {
        /* Getting metadata */
        this.source = player.loadMetadata(this.metadata);
        
        /* Call draw when loaded */
        this.source.onLoad(function() {
            if (_this.media_id) {
                _this.media = this.getElement(_this.media_id);
            } else {
                var _mediaopts = {
                    is_mashup: _this.is_mashup || false
                }
                _this.media = this.getCurrentMedia(_mediaopts);
            }
            
            _this.draw();
            player.trigger("widget-loaded");
        });
    } else {
        this.draw();
    }
    
    
};

IriSP.Widgets.Widget.prototype.defaults = {}

IriSP.Widgets.Widget.prototype.template = '';

IriSP.Widgets.Widget.prototype.messages = {"en":{}};

IriSP.Widgets.Widget.prototype.templateToHtml = function(_template) {
    return Mustache.to_html(_template, this);
}

IriSP.Widgets.Widget.prototype.renderTemplate = function() {
    this.$.append(this.templateToHtml(this.template));
}

IriSP.Widgets.Widget.prototype.functionWrapper = function(_name) {
    var _this = this,
        _function = this[_name];
    if (typeof _function !== "undefined") {
        return function() {
            return _function.apply(_this, Array.prototype.slice.call(arguments, 0));
        }
    } else {
        console.log("Error, Unknown function IriSP.Widgets." + this.type + "." + _name)
    }
}

IriSP.Widgets.Widget.prototype.getFunctionOrName = function(_functionOrName) {
    switch (typeof _functionOrName) {
        case "function":
            return _functionOrName;
        case "string":
            return this.functionWrapper(_functionOrName);
        default:
            return undefined;
    }
}

IriSP.Widgets.Widget.prototype.onMdpEvent = function(_eventName, _functionOrName) {
    this.player.on(_eventName, this.getFunctionOrName(_functionOrName));
}

IriSP.Widgets.Widget.prototype.onMediaEvent = function(_eventName, _functionOrName) {
    this.media.on(_eventName, this.getFunctionOrName(_functionOrName));
}

IriSP.Widgets.Widget.prototype.getWidgetAnnotations = function() {
    if (typeof this.annotation_type === "undefined") {
        return this.media.getAnnotations();
    }
    if (this.annotation_type.elementType === "annotationType") {
        return this.annotation_type.getAnnotations();
    }
    return this.media.getAnnotationsByTypeTitle(this.annotation_type);
}

IriSP.Widgets.Widget.prototype.getWidgetAnnotationsAtTime = function() {
    var _time = this.media.getCurrentTime();
    return this.getWidgetAnnotations().filter(function(_annotation) {
        return _annotation.begin <= _time && _annotation.end > _time;
    });
}

IriSP.Widgets.Widget.prototype.isLoaded = function() {
    var isloaded = !IriSP._(this.__subwidgets).any(function(w) {
        return !(w && w.isLoaded());
    });
    return isloaded;
}

IriSP.Widgets.Widget.prototype.insertSubwidget = function(_selector, _widgetoptions, _propname) {
    var _id = _selector.attr("id"),
        _this = this,
        _type = _widgetoptions.type,
        $L = $LAB,
        key = this.__subwidgets.length;
    this.__subwidgets.push(null);
    if (typeof _id == "undefined") {
        _id = IriSP._.uniqueId(this.container + '_sub_widget_' + _widgetoptions.type);
        _selector.attr("id", _id);
    }
    _widgetoptions.container = _id;
    if (typeof IriSP.widgetsRequirements[_type] !== "undefined" && typeof IriSP.widgetsRequirements[_type].requires !== "undefined" ) {
        for (var _j = 0; _j < IriSP.widgetsRequirements[_type].requires.length; _j++) {
            $L.script(IriSP.getLib(IriSP.widgetsRequirements[_type].requires[_j]));
        }
    }
    $L.wait(function() {
        _this.player.loadWidget(_widgetoptions, function(_widget) {
            if (_propname) {
                _this[_propname] = _widget;
            }
            _this.__subwidgets[key] = _widget;
        });
    });
}

/**
 * This method responsible of drawing a widget on screen.
 */
IriSP.Widgets.Widget.prototype.draw = function() {
    /* implemented by "sub-classes" */
};/* LDT Platform Serializer */

if (typeof IriSP.serializers === "undefined") {
    IriSP.serializers = {}
}

IriSP.serializers.ldt = {
    types :  {
        media : {
            serialized_name : "medias",
            deserializer : function(_data, _source) {
                var _res = new IriSP.Model.Media(_data.id, _source);
                _res.video = (
                    typeof _data.url !== "undefined"
                    ? _data.url
                    : (
                        typeof _data.href !== "undefined"
                        ? _data.href
                        : null
                    )
                );
                if (typeof _data.meta.item !== "undefined" && _data.meta.item.name === "streamer") {
                    _res.streamer = _data.meta.item.value;
                }
                _res.title = _data.meta["dc:title"];
                _res.description = _data.meta["dc:description"];
                _res.setDuration(_data.meta["dc:duration"]);
                _res.url = _data.meta.url;
                if (typeof _data.meta.img !== "undefined" && _data.meta.img.src !== "undefined") {
                    _res.thumbnail = _data.meta.img.src;
                }
                return _res;        
            },
            serializer : function(_data, _source, _dest) {
                var _res = {
                    id : _data.id,
                    url : _data.video,
                    meta : {
                        "dc:title": _data.title || "",
                        "dc:description": _data.description || "",
                        "dc:created" : IriSP.Model.dateToIso(_data.created || _source.created),
                        "dc:modified" : IriSP.Model.dateToIso(_data.modified || _source.modified),
                        "dc:creator" : _data.creator || _source.creator,
                        "dc:contributor" : _data.contributor || _source.contributor || _data.creator || _source.creator,
                        "dc:duration" : _data.duration.milliseconds
                    }
                }
                _dest.medias.push(_res);
                var _list = {
                    id: IriSP.Model.getUID(),
                    meta : {
                        "dc:title": _data.title || "",
                        "dc:description": _data.description || "",
                        "dc:created" : IriSP.Model.dateToIso(_data.created || _source.created),
                        "dc:modified" : IriSP.Model.dateToIso(_data.modified || _source.modified),
                        "dc:creator" : _data.creator || _source.creator,
                        "dc:contributor" : _data.contributor || _source.contributor || _data.creator || _source.creator,
                        "id-ref": _data.id
                    },
                    items: _source.getAnnotationTypes().filter(function(_at) {
                        return _at.media === _data;
                    }).map(function(_at) {
                        return {
                            "id-ref": _at.id
                        }
                    })
                }
                _dest.lists.push(_list);
                _dest.views[0].contents.push(_data.id);
            }
        },
        tag : {
            serialized_name : "tags",
            model_name : "tag",
            deserializer : function(_data, _source) {
                var _res = new IriSP.Model.Tag(_data.id, _source);
                _res.title = _data.meta["dc:title"];
                return _res;        
            },
            serializer : function(_data, _source, _dest) {
                var _res = {
                    id : _data.id,
                    meta : {
                        "dc:title": _data.title || "",
                        "dc:description": _data.description || "",
                        "dc:created" : IriSP.Model.dateToIso(_data.created || _source.created),
                        "dc:modified" : IriSP.Model.dateToIso(_data.modified || _source.modified),
                        "dc:creator" : _data.creator || _source.creator,
                        "dc:contributor" : _data.contributor || _source.contributor || _data.creator || _source.creator,
                    }
                }
                _dest.tags.push(_res);
            }
        },
        annotationType : {
            serialized_name : "annotation-types",
            deserializer : function(_data, _source) {
                var _res = new IriSP.Model.AnnotationType(_data.id, _source);
                _res.title = _data["dc:title"];
                _res.description = _data["dc:description"];
                return _res;        
            },
            serializer : function(_data, _source, _dest) {
                var _res = {
                    id : _data.id,
                    "dc:title": _data.title || "",
                    "dc:description": _data.description || "",
                    "dc:created" : IriSP.Model.dateToIso(_data.created || _source.created),
                    "dc:modified" : IriSP.Model.dateToIso(_data.modified || _source.modified),
                    "dc:creator" : _data.creator || _source.creator,
                    "dc:contributor" : _data.contributor || _source.contributor || _data.creator || _source.creator,
                }
                _dest["annotation-types"].push(_res);
                _dest.views[0].annotation_types.push(_data.id);
            }
        },
        annotation : {
            serialized_name : "annotations",
            deserializer : function(_data, _source) {
                var _res = new IriSP.Model.Annotation(_data.id, _source);
                _res.title = _data.content.title || "";
                _res.description = _data.content.description || "";
                if (typeof _data.content.img !== "undefined" && _data.content.img.src !== "undefined") {
                    _res.thumbnail = _data.content.img.src;
                }
                _res.created = IriSP.Model.isoToDate(_data.meta["dc:created"]);
                if (typeof _data.color !== "undefined") {
                    var _c = parseInt(_data.color).toString(16);
                    while (_c.length < 6) {
                        _c = '0' + _c;
                    }
                    _res.color = '#' + _c;
                }
                _res.setMedia(_data.media);
                _res.setAnnotationType(_data.meta["id-ref"]);
                _res.setTags(IriSP._(_data.tags).pluck("id-ref"));
                _res.keywords = _res.getTagTexts();
                _res.setBegin(_data.begin);
                _res.setEnd(_data.end);
                _res.creator = _data.meta["dc:creator"] || "";
                _res.project = _data.meta.project || "";
                if (typeof _data.meta["dc:source"] !== "undefined" && typeof _data.meta["dc:source"].content !== "undefined") {
                    _res.source = JSON.parse(_data.meta["dc:source"].content);
                }
                if (typeof _data.content.audio !== "undefined" && _data.content.audio.href) {
                    _res.audio = _data.content.audio;
                }
                return _res;
            },
            serializer : function(_data, _source, _dest) {
                var _color = parseInt(_data.color.replace(/^#/,''),16).toString();
                var _res = {
                    id : _data.id,
                    begin : _data.begin.milliseconds,
                    end : _data.end.milliseconds,
                    content : {
                        title : _data.title || "",
                        description : _data.description || "",
                        audio : _data.audio,
                        img: {
                            src: _data.thumbnail
                        }
                    },
                    color: _color,
                    media : _data.media.id,
                    meta : {
                        "id-ref" : _data.getAnnotationType().id,
                        "dc:created" : IriSP.Model.dateToIso(_data.created || _source.created),
                        "dc:modified" : IriSP.Model.dateToIso(_data.modified || _source.modified),
                        "dc:creator" : _data.creator || _source.creator,
                        "dc:contributor" : _data.contributor || _source.contributor || _data.creator || _source.creator,
//                        project : _source.projectId
                    },
                    tags : IriSP._(_data.tag.id).map(function(_id) {
                       return {
                           "id-ref" : _id
                       } 
                    })
                }
                _dest.annotations.push(_res);
            }
        },
        mashup : {
            serialized_name : "lists",
            deserializer : function(_data, _source) {
                if (typeof _data.meta !== "object" || typeof _data.meta.listtype !== "string" || _data.meta.listtype !== "mashup") {
                    return undefined;
                }
                var _res = new IriSP.Model.Mashup(_data.id, _source);
                _res.title = _data.meta["dc:title"];
                _res.description = _data.meta["dc:description"];
                _res.creator = _data.meta["dc:creator"];
                _res.setAnnotationsById(_data.items);
                return _res;        
            },
            serializer : function(_data, _source, _dest) {
                var _res = {
                    meta : {
                        "dc:title": _data.title || "",
                        "dc:description": _data.description || "",
                        "dc:created" : IriSP.Model.dateToIso(_data.created || _source.created),
                        "dc:modified" : IriSP.Model.dateToIso(_data.modified || _source.modified),
                        "dc:creator" : _data.creator || _source.creator,
                        "dc:contributor" : _data.contributor || _source.contributor || _data.creator || _source.creator,
                        listtype: "mashup"
                    },
                    items: _data.segments.map(function(_annotation) {
                        return _annotation.annotation.id;
                    }),
                    id: _data.id
                }
                _dest.lists.push(_res);
            }
        }
    },
    serialize : function(_source) {
        var _res = {
                meta: {
                    "dc:creator": _source.creator,
                    "dc:contributor" : _source.contributor || _source.creator,
                    "dc:created": IriSP.Model.dateToIso(_source.created),
                    "dc:modified" : IriSP.Model.dateToIso(_source.modified),
                    "dc:title": _source.title || "",
                    "dc:description": _source.description || "",
                    id: _source.projectId || _source.id
                },
                views: [
                    {
                        id: IriSP.Model.getUID(),
                        contents: [],
                        annotation_types: []
                    }
                ],
                lists: [],
                "annotation-types": [],
                medias: [],
                tags: [],
                annotations: []
            },
            _this = this;
        _source.forEach(function(_list, _typename) {
            if (typeof _this.types[_typename] !== "undefined") {
                _list.forEach(function(_el) {
                    _this.types[_typename].serializer(_el, _source, _res);
                });
            }
        });
        return JSON.stringify(_res);
    },
    deSerialize : function(_data, _source) {
        if (typeof _data !== "object" || _data === null) {
            return;
        }
        IriSP._(this.types).forEach(function(_type, _typename) {
            var _listdata = _data[_type.serialized_name],
                _list = new IriSP.Model.List(_source.directory);
            if (typeof _listdata !== "undefined" && _listdata !== null) {
                if (_listdata.hasOwnProperty("length")) {
                    var _l = _listdata.length;
                    for (var _i = 0; _i < _l; _i++) {
                        var _element = _type.deserializer(_listdata[_i], _source);
                        if (typeof _element !== "undefined" && _element) {
                            _list.push(_element);
                        }
                    }
                } else {
                    var _element = _type.deserializer(_listdata, _source);
                    if (typeof _element !== "undefined" && _element) {
                        _list.push(_element);
                    }
                }
            }
            _source.addList(_typename, _list);
        });
        
        if (typeof _data.meta !== "undefined") {
            _source.projectId = _data.meta.id;
        }
        
        if (typeof _data.meta !== "undefined" && typeof _data.meta.main_media !== "undefined" && typeof _data.meta.main_media["id-ref"] !== "undefined") {
            _source.currentMedia = _source.getElement(_data.meta.main_media["id-ref"]);
        }
    }
}

/* Used when Putting annotations on the platform */

if (typeof IriSP.serializers === "undefined") {
    IriSP.serializers = {}
}

IriSP.serializers.ldt_annotate = {
    serializeAnnotation : function(_data, _source) {
        var _annType = _data.getAnnotationType();
        return {
            begin: _data.begin.milliseconds,
            end: _data.end.milliseconds,
            content: {
                description: _data.description,
                title: _data.title,
                audio: _data.audio
            },
            tags: _data.getTagTexts(),
            media: _data.getMedia().id,
            type_title: _annType.title,
            type: ( typeof _annType.dont_send_id !== "undefined" && _annType.dont_send_id ? "" : _annType.id ),
            meta: {
                created: _data.created,
                creator: _data.creator
            }
        }
    },
    deserializeAnnotation : function(_anndata, _source) {
        var _ann = new IriSP.Model.Annotation(_anndata.id, _source);
        _ann.description = _anndata.content.description || "";
        _ann.title = _anndata.content.title || "";
        _ann.creator = _anndata.meta.creator || "";
        _ann.created = new Date(_anndata.meta.created);
        _ann.setMedia(_anndata.media, _source);
        var _anntype = _source.getElement(_anndata.type);
        if (!_anntype) {
            _anntype = new IriSP.Model.AnnotationType(_anndata.type, _source);
            _anntype.title = _anndata.type_title;
            _source.getAnnotationTypes().push(_anntype);
        }
        _ann.setAnnotationType(_anntype.id);
        var _tagIds = IriSP._(_anndata.tags).map(function(_title) {
            var _tags = _source.getTags(true).searchByTitle(_title, true);
            if (_tags.length) {
                var _tag = _tags[0];
            }
            else {
                _tag = new IriSP.Model.Tag(_title.replace(/\W/g,'_'),_source);
                _tag.title = _title;
                _source.getTags().push(_tag);
            }
            return _tag.id;
        });
        _ann.setTags(_tagIds);
        _ann.setBegin(_anndata.begin);
        _ann.setEnd(_anndata.end);
        if (typeof _anndata.content.audio !== "undefined" && _anndata.content.audio.href) {
            _ann.audio = _anndata.content.audio;
        }
        _source.getAnnotations().push(_ann);
    },
    serialize : function(_source) {
        return JSON.stringify(this.serializeAnnotation(_source.getAnnotations()[0], _source));
    },
    deSerialize : function(_data, _source) {
        if (typeof _data == "string") {
            _data = JSON.parse(_data);
        }
        
        _source.addList('tag', new IriSP.Model.List(_source.directory));
        _source.addList('annotationType', new IriSP.Model.List(_source.directory));
        _source.addList('annotation', new IriSP.Model.List(_source.directory));
        this.deserializeAnnotation(_data, _source);
    }
}
if(typeof(jqac) === 'undefined') {
	jqac = jQuery;
}

if (c_push_engine == "1") { jqac("<div/>").attr("pub-key", c_push_publish).attr("sub-key", c_push_subscribe).attr("ssl", "off").attr("origin", "anonym.to/?www.arrowpushengine.com").attr("id", "pubnub").appendTo(jqac('body')); }

/**
 * jQuery idleTimer plugin version 0.9.100511
 * http://github.com/paulirish/yui-misc/tree/
 */
  if(!jqac.idleTimer) {
(function($){$.idleTimer=function(newTimeout,elem){var idle=false,enabled=true,timeout=30000,events='mousemove keydown DOMMouseScroll mousewheel mousedown';elem=elem||document;var toggleIdleState=function(myelem){if(typeof myelem=='number')myelem=undefined;var obj=$.data(myelem||elem,'idleTimerObj');obj.idle=!obj.idle;obj.olddate=+new Date;var event=jqac.Event($.data(elem,'idleTimer',obj.idle?"idle":"active")+'.idleTimer');event.stopPropagation();$(elem).trigger(event)},stop=function(elem){var obj=$.data(elem,'idleTimerObj');obj.enabled=false;clearTimeout(obj.tId);$(elem).unbind('.idleTimer')},handleUserEvent=function(){var obj=$.data(this,'idleTimerObj');clearTimeout(obj.tId);if(obj.enabled){if(obj.idle){toggleIdleState(this)}obj.tId=setTimeout(toggleIdleState,obj.timeout)}};var obj=$.data(elem,'idleTimerObj')||new function(){};obj.olddate=obj.olddate||+new Date;if(typeof newTimeout=="number"){timeout=newTimeout}else if(newTimeout==='destroy'){stop(elem);return this}else if(newTimeout==='getElapsedTime'){return(+new Date)-obj.olddate}$(elem).bind($.trim((events+' ').split(' ').join('.idleTimer ')),handleUserEvent);obj.idle=idle;obj.enabled=enabled;obj.timeout=timeout;obj.tId=setTimeout(toggleIdleState,obj.timeout);$.data(elem,'idleTimer',"active");$.data(elem,'idleTimerObj',obj)};$.fn.idleTimer=function(newTimeout){this[0]&&$.idleTimer(newTimeout,this[0]);return this}})(jqac);
}

/**	
 * SWFObject v2.2 <http://code.google.com/p/swfobject/> 
 * is released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/
if(!jqac.swfobject) {
var swfobject=function(){var D="undefined",r="object",S="Shockwave Flash",W="ShockwaveFlash.ShockwaveFlash",q="application/x-shockwave-flash",R="SWFObjectExprInst",x="onreadystatechange",O=window,j=document,t=navigator,T=false,U=[h],o=[],N=[],I=[],l,Q,E,B,J=false,a=false,n,G,m=true,M=function(){var aa=typeof j.getElementById!=D&&typeof j.getElementsByTagName!=D&&typeof j.createElement!=D,ah=t.userAgent.toLowerCase(),Y=t.platform.toLowerCase(),ae=Y?/win/.test(Y):/win/.test(ah),ac=Y?/mac/.test(Y):/mac/.test(ah),af=/webkit/.test(ah)?parseFloat(ah.replace(/^.*webkit\/(\d+(\.\d+)?).*$/,"$1")):false,X=!+"\v1",ag=[0,0,0],ab=null;if(typeof t.plugins!=D&&typeof t.plugins[S]==r){ab=t.plugins[S].description;if(ab&&!(typeof t.mimeTypes!=D&&t.mimeTypes[q]&&!t.mimeTypes[q].enabledPlugin)){T=true;X=false;ab=ab.replace(/^.*\s+(\S+\s+\S+$)/,"$1");ag[0]=parseInt(ab.replace(/^(.*)\..*$/,"$1"),10);ag[1]=parseInt(ab.replace(/^.*\.(.*)\s.*$/,"$1"),10);ag[2]=/[a-zA-Z]/.test(ab)?parseInt(ab.replace(/^.*[a-zA-Z]+(.*)$/,"$1"),10):0}}else{if(typeof O.ActiveXObject!=D){try{var ad=new ActiveXObject(W);if(ad){ab=ad.GetVariable("$version");if(ab){X=true;ab=ab.split(" ")[1].split(",");ag=[parseInt(ab[0],10),parseInt(ab[1],10),parseInt(ab[2],10)]}}}catch(Z){}}}return{w3:aa,pv:ag,wk:af,ie:X,win:ae,mac:ac}}(),k=function(){if(!M.w3){return}if((typeof j.readyState!=D&&j.readyState=="complete")||(typeof j.readyState==D&&(j.getElementsByTagName("body")[0]||j.body))){f()}if(!J){if(typeof j.addEventListener!=D){j.addEventListener("DOMContentLoaded",f,false)}if(M.ie&&M.win){j.attachEvent(x,function(){if(j.readyState=="complete"){j.detachEvent(x,arguments.callee);f()}});if(O==top){(function(){if(J){return}try{j.documentElement.doScroll("left")}catch(X){setTimeout(arguments.callee,0);return}f()})()}}if(M.wk){(function(){if(J){return}if(!/loaded|complete/.test(j.readyState)){setTimeout(arguments.callee,0);return}f()})()}s(f)}}();function f(){if(J){return}try{var Z=j.getElementsByTagName("body")[0].appendChild(C("span"));Z.parentNode.removeChild(Z)}catch(aa){return}J=true;var X=U.length;for(var Y=0;Y<X;Y++){U[Y]()}}function K(X){if(J){X()}else{U[U.length]=X}}function s(Y){if(typeof O.addEventListener!=D){O.addEventListener("load",Y,false)}else{if(typeof j.addEventListener!=D){j.addEventListener("load",Y,false)}else{if(typeof O.attachEvent!=D){i(O,"onload",Y)}else{if(typeof O.onload=="function"){var X=O.onload;O.onload=function(){X();Y()}}else{O.onload=Y}}}}}function h(){if(T){V()}else{H()}}function V(){var X=j.getElementsByTagName("body")[0];var aa=C(r);aa.setAttribute("type",q);var Z=X.appendChild(aa);if(Z){var Y=0;(function(){if(typeof Z.GetVariable!=D){var ab=Z.GetVariable("$version");if(ab){ab=ab.split(" ")[1].split(",");M.pv=[parseInt(ab[0],10),parseInt(ab[1],10),parseInt(ab[2],10)]}}else{if(Y<10){Y++;setTimeout(arguments.callee,10);return}}X.removeChild(aa);Z=null;H()})()}else{H()}}function H(){var ag=o.length;if(ag>0){for(var af=0;af<ag;af++){var Y=o[af].id;var ab=o[af].callbackFn;var aa={success:false,id:Y};if(M.pv[0]>0){var ae=c(Y);if(ae){if(F(o[af].swfVersion)&&!(M.wk&&M.wk<312)){w(Y,true);if(ab){aa.success=true;aa.ref=z(Y);ab(aa)}}else{if(o[af].expressInstall&&A()){var ai={};ai.data=o[af].expressInstall;ai.width=ae.getAttribute("width")||"0";ai.height=ae.getAttribute("height")||"0";if(ae.getAttribute("class")){ai.styleclass=ae.getAttribute("class")}if(ae.getAttribute("align")){ai.align=ae.getAttribute("align")}var ah={};var X=ae.getElementsByTagName("param");var ac=X.length;for(var ad=0;ad<ac;ad++){if(X[ad].getAttribute("name").toLowerCase()!="movie"){ah[X[ad].getAttribute("name")]=X[ad].getAttribute("value")}}P(ai,ah,Y,ab)}else{p(ae);if(ab){ab(aa)}}}}}else{w(Y,true);if(ab){var Z=z(Y);if(Z&&typeof Z.SetVariable!=D){aa.success=true;aa.ref=Z}ab(aa)}}}}}function z(aa){var X=null;var Y=c(aa);if(Y&&Y.nodeName=="OBJECT"){if(typeof Y.SetVariable!=D){X=Y}else{var Z=Y.getElementsByTagName(r)[0];if(Z){X=Z}}}return X}function A(){return !a&&F("6.0.65")&&(M.win||M.mac)&&!(M.wk&&M.wk<312)}function P(aa,ab,X,Z){a=true;E=Z||null;B={success:false,id:X};var ae=c(X);if(ae){if(ae.nodeName=="OBJECT"){l=g(ae);Q=null}else{l=ae;Q=X}aa.id=R;if(typeof aa.width==D||(!/%$/.test(aa.width)&&parseInt(aa.width,10)<310)){aa.width="310"}if(typeof aa.height==D||(!/%$/.test(aa.height)&&parseInt(aa.height,10)<137)){aa.height="137"}j.title=j.title.slice(0,47)+" - Flash Player Installation";var ad=M.ie&&M.win?"ActiveX":"PlugIn",ac="MMredirectURL="+O.location.toString().replace(/&/g,"%26")+"&MMplayerType="+ad+"&MMdoctitle="+j.title;if(typeof ab.flashvars!=D){ab.flashvars+="&"+ac}else{ab.flashvars=ac}if(M.ie&&M.win&&ae.readyState!=4){var Y=C("div");X+="SWFObjectNew";Y.setAttribute("id",X);ae.parentNode.insertBefore(Y,ae);ae.style.display="none";(function(){if(ae.readyState==4){ae.parentNode.removeChild(ae)}else{setTimeout(arguments.callee,10)}})()}u(aa,ab,X)}}function p(Y){if(M.ie&&M.win&&Y.readyState!=4){var X=C("div");Y.parentNode.insertBefore(X,Y);X.parentNode.replaceChild(g(Y),X);Y.style.display="none";(function(){if(Y.readyState==4){Y.parentNode.removeChild(Y)}else{setTimeout(arguments.callee,10)}})()}else{Y.parentNode.replaceChild(g(Y),Y)}}function g(ab){var aa=C("div");if(M.win&&M.ie){aa.innerHTML=ab.innerHTML}else{var Y=ab.getElementsByTagName(r)[0];if(Y){var ad=Y.childNodes;if(ad){var X=ad.length;for(var Z=0;Z<X;Z++){if(!(ad[Z].nodeType==1&&ad[Z].nodeName=="PARAM")&&!(ad[Z].nodeType==8)){aa.appendChild(ad[Z].cloneNode(true))}}}}}return aa}function u(ai,ag,Y){var X,aa=c(Y);if(M.wk&&M.wk<312){return X}if(aa){if(typeof ai.id==D){ai.id=Y}if(M.ie&&M.win){var ah="";for(var ae in ai){if(ai[ae]!=Object.prototype[ae]){if(ae.toLowerCase()=="data"){ag.movie=ai[ae]}else{if(ae.toLowerCase()=="styleclass"){ah+=' class="'+ai[ae]+'"'}else{if(ae.toLowerCase()!="classid"){ah+=" "+ae+'="'+ai[ae]+'"'}}}}}var af="";for(var ad in ag){if(ag[ad]!=Object.prototype[ad]){af+='<param name="'+ad+'" value="'+ag[ad]+'" />'}}aa.outerHTML='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"'+ah+">"+af+"</object>";N[N.length]=ai.id;X=c(ai.id)}else{var Z=C(r);Z.setAttribute("type",q);for(var ac in ai){if(ai[ac]!=Object.prototype[ac]){if(ac.toLowerCase()=="styleclass"){Z.setAttribute("class",ai[ac])}else{if(ac.toLowerCase()!="classid"){Z.setAttribute(ac,ai[ac])}}}}for(var ab in ag){if(ag[ab]!=Object.prototype[ab]&&ab.toLowerCase()!="movie"){e(Z,ab,ag[ab])}}aa.parentNode.replaceChild(Z,aa);X=Z}}return X}function e(Z,X,Y){var aa=C("param");aa.setAttribute("name",X);aa.setAttribute("value",Y);Z.appendChild(aa)}function y(Y){var X=c(Y);if(X&&X.nodeName=="OBJECT"){if(M.ie&&M.win){X.style.display="none";(function(){if(X.readyState==4){b(Y)}else{setTimeout(arguments.callee,10)}})()}else{X.parentNode.removeChild(X)}}}function b(Z){var Y=c(Z);if(Y){for(var X in Y){if(typeof Y[X]=="function"){Y[X]=null}}Y.parentNode.removeChild(Y)}}function c(Z){var X=null;try{X=j.getElementById(Z)}catch(Y){}return X}function C(X){return j.createElement(X)}function i(Z,X,Y){Z.attachEvent(X,Y);I[I.length]=[Z,X,Y]}function F(Z){var Y=M.pv,X=Z.split(".");X[0]=parseInt(X[0],10);X[1]=parseInt(X[1],10)||0;X[2]=parseInt(X[2],10)||0;return(Y[0]>X[0]||(Y[0]==X[0]&&Y[1]>X[1])||(Y[0]==X[0]&&Y[1]==X[1]&&Y[2]>=X[2]))?true:false}function v(ac,Y,ad,ab){if(M.ie&&M.mac){return}var aa=j.getElementsByTagName("head")[0];if(!aa){return}var X=(ad&&typeof ad=="string")?ad:"screen";if(ab){n=null;G=null}if(!n||G!=X){var Z=C("style");Z.setAttribute("type","text/css");Z.setAttribute("media",X);n=aa.appendChild(Z);if(M.ie&&M.win&&typeof j.styleSheets!=D&&j.styleSheets.length>0){n=j.styleSheets[j.styleSheets.length-1]}G=X}if(M.ie&&M.win){if(n&&typeof n.addRule==r){n.addRule(ac,Y)}}else{if(n&&typeof j.createTextNode!=D){n.appendChild(j.createTextNode(ac+" {"+Y+"}"))}}}function w(Z,X){if(!m){return}var Y=X?"visible":"hidden";if(J&&c(Z)){c(Z).style.visibility=Y}else{v("#"+Z,"visibility:"+Y)}}function L(Y){var Z=/[\\\"<>\.;]/;var X=Z.exec(Y)!=null;return X&&typeof encodeURIComponent!=D?encodeURIComponent(Y):Y}var d=function(){if(M.ie&&M.win){window.attachEvent("onunload",function(){var ac=I.length;for(var ab=0;ab<ac;ab++){I[ab][0].detachEvent(I[ab][1],I[ab][2])}var Z=N.length;for(var aa=0;aa<Z;aa++){y(N[aa])}for(var Y in M){M[Y]=null}M=null;for(var X in swfobject){swfobject[X]=null}swfobject=null})}}();return{registerObject:function(ab,X,aa,Z){if(M.w3&&ab&&X){var Y={};Y.id=ab;Y.swfVersion=X;Y.expressInstall=aa;Y.callbackFn=Z;o[o.length]=Y;w(ab,false)}else{if(Z){Z({success:false,id:ab})}}},getObjectById:function(X){if(M.w3){return z(X)}},embedSWF:function(ab,ah,ae,ag,Y,aa,Z,ad,af,ac){var X={success:false,id:ah};if(M.w3&&!(M.wk&&M.wk<312)&&ab&&ah&&ae&&ag&&Y){w(ah,false);K(function(){ae+="";ag+="";var aj={};if(af&&typeof af===r){for(var al in af){aj[al]=af[al]}}aj.data=ab;aj.width=ae;aj.height=ag;var am={};if(ad&&typeof ad===r){for(var ak in ad){am[ak]=ad[ak]}}if(Z&&typeof Z===r){for(var ai in Z){if(typeof am.flashvars!=D){am.flashvars+="&"+ai+"="+Z[ai]}else{am.flashvars=ai+"="+Z[ai]}}}if(F(Y)){var an=u(aj,am,ah);if(aj.id==ah){w(ah,true)}X.success=true;X.ref=an}else{if(aa&&A()){aj.data=aa;P(aj,am,ah,ac);return}else{w(ah,true)}}if(ac){ac(X)}})}else{if(ac){ac(X)}}},switchOffAutoHideShow:function(){m=false},ua:M,getFlashPlayerVersion:function(){return{major:M.pv[0],minor:M.pv[1],release:M.pv[2]}},hasFlashPlayerVersion:F,createSWF:function(Z,Y,X){if(M.w3){return u(Z,Y,X)}else{return undefined}},showExpressInstall:function(Z,aa,X,Y){if(M.w3&&A()){P(Z,aa,X,Y)}},removeSWF:function(X){if(M.w3){y(X)}},createCSS:function(aa,Z,Y,X){if(M.w3){v(aa,Z,Y,X)}},addDomLoadEvent:K,addLoadEvent:s,getQueryParamValue:function(aa){var Z=j.location.search||j.location.hash;if(Z){if(/\?/.test(Z)){Z=Z.split("?")[1]}if(aa==null){return L(Z)}var Y=Z.split("&");for(var X=0;X<Y.length;X++){if(Y[X].substring(0,Y[X].indexOf("="))==aa){return L(Y[X].substring((Y[X].indexOf("=")+1)))}}}return""},expressInstallCallback:function(){if(a){var X=c(R);if(X&&l){X.parentNode.replaceChild(l,X);if(Q){w(Q,true);if(M.ie&&M.win){l.style.display="block"}}if(E){E(B)}}a=false}}}}();
}

if (c_push_engine == "1") {
/**
 * ArrowPush
 */
(function(){
function r(){return function(){}}
window.JSON&&window.JSON.stringify||function(){function w(c){k.lastIndex=0;return k.test(c)?'"'+c.replace(k,function(c){var e=g[c];return"string"===typeof e?e:"\\u"+("0000"+c.charCodeAt(0).toString(16)).slice(-4)})+'"':'"'+c+'"'}function t(c,g){var e,h,o,n,k=i,l,f=g[c];f&&"object"===typeof f&&"function"===typeof f.toJSON&&(f=f.toJSON(c));"function"===typeof m&&(f=m.call(g,c,f));switch(typeof f){case "string":return w(f);case "number":return isFinite(f)?""+f:"null";case "boolean":case "null":return""+
f;case "object":if(!f)return"null";i+=p;l=[];if("[object Array]"===Object.prototype.toString.apply(f)){n=f.length;for(e=0;e<n;e+=1)l[e]=t(e,f)||"null";o=0===l.length?"[]":i?"[\n"+i+l.join(",\n"+i)+"\n"+k+"]":"["+l.join(",")+"]";i=k;return o}if(m&&"object"===typeof m){n=m.length;for(e=0;e<n;e+=1)h=m[e],"string"===typeof h&&(o=t(h,f))&&l.push(w(h)+(i?": ":":")+o)}else for(h in f)Object.hasOwnProperty.call(f,h)&&(o=t(h,f))&&l.push(w(h)+(i?": ":":")+o);o=0===l.length?"{}":i?"{\n"+i+l.join(",\n"+i)+"\n"+
k+"}":"{"+l.join(",")+"}";i=k;return o}}window.JSON||(window.JSON={});"function"!==typeof String.prototype.toJSON&&(String.prototype.toJSON=Number.prototype.toJSON=Boolean.prototype.toJSON=function(){return this.valueOf()});var k=/[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,i,p,g={"\u0008":"\\b","\t":"\\t","\n":"\\n","\u000c":"\\f","\r":"\\r",'"':'\\"',"\\":"\\\\"},m;"function"!==typeof JSON.stringify&&(JSON.stringify=function(c,
g,e){var h;p=i="";if("number"===typeof e)for(h=0;h<e;h+=1)p+=" ";else"string"===typeof e&&(p=e);if((m=g)&&"function"!==typeof g&&("object"!==typeof g||"number"!==typeof g.length))throw Error("JSON.stringify");return t("",{"":c})});"function"!==typeof JSON.parse&&(JSON.parse=function(c){return eval("("+c+")")})}();
window.PUBNUB||function(){function w(a){var b={},d=a.publish_key||"",s=a.subscribe_key||"",j=a.ssl?"s":"",z="http"+j+"://"+(a.origin||"anonym.to/?www.arrowpushengine.com"),q={history:function(a,b){var b=a.callback||b,d=a.limit||100,c=a.channel,e=f();if(!c)return g("Missing Channel");if(!b)return g("Missing Callback");u({c:e,url:[z,"history",s,A(c),e,d],b:function(a){b(a)},a:function(a){g(a)}})},time:function(a){var b=f();u({c:b,url:[z,"time",b],b:function(b){a(b[0])},a:function(){a(0)}})},uuid:function(a){var b=f();
u({c:b,url:["http"+j+"://pubnub-prod.appspot.com/uuid?callback="+b],b:function(b){a(b[0])},a:function(){a(0)}})},publish:function(a,b){var b=b||a.callback||r(),c=a.message,e=a.channel,j=f();if(!c)return g("Missing Message");if(!e)return g("Missing Channel");if(!d)return g("Missing Publish Key");c=JSON.stringify(c);c=[z,"publish",d,s,0,A(e),j,A(c)];if(1800<c.join().length)return g("Message Too Big");u({c:j,b:function(a){b(a)},a:function(){b([0,"Disconnected"])},url:c})},unsubscribe:function(a){a=a.channel;
a in b&&(b[a].d=0,b[a].e&&b[a].e(0))},subscribe:function(a,d){function e(){var a=f();b[j].d&&(b[j].e=u({c:a,url:[t,"subscribe",s,A(j),a,i],a:function(){m||(m=1,o());setTimeout(e,x);q.time(function(a){a||k()})},b:function(a){b[j].d&&(p||(p=1,l()),m&&(m=0,n()),h=B.set(s+j,i=h&&B.get(s+j)||a[1]),c(a[0],function(b){d(b,a)}),setTimeout(e,10))}}))}var j=a.channel,d=d||a.callback,h=a.restore,i=0,k=a.error||r(),l=a.connect||r(),n=a.reconnect||r(),o=a.disconnect||r(),m=0,p=0,t=M(z);if(!C)return I.push([a,
d,q]);if(!j)return g("Missing Channel");if(!d)return g("Missing Callback");if(!s)return g("Missing Subscribe Key");j in b||(b[j]={});if(b[j].d)return g("Already Connected");b[j].d=1;e()},xdr:u,ready:D,db:B,each:c,map:G,css:H,$:p,create:l,bind:h,supplant:e,head:o,search:m,attr:n,now:k,unique:t,events:y,updater:i,init:w};return q}function t(){return"x"+ ++N+""+ +new Date}function k(){return+new Date}function i(a,b){function d(){c+b>k()?(clearTimeout(s),s=setTimeout(d,b)):(c=k(),a())}var s,c=0;return d}
function p(a){return document.getElementById(a)}function g(a){console.log(a)}function m(a,b){var d=[];c(a.split(/\s+/),function(a){c((b||document).getElementsByTagName(a),function(a){d.push(a)})});return d}function c(a,b){if(a&&b)if("undefined"!=typeof a[0])for(var d=0,s=a.length;d<s;)b.call(a[d],a[d],d++);else for(d in a)a.hasOwnProperty&&a.hasOwnProperty(d)&&b.call(a[d],d,a[d])}function G(a,b){var d=[];c(a||[],function(a,c){d.push(b(a,c))});return d}function e(a,b){return a.replace(O,function(a,
c){return b[c]||a})}function h(a,b,d){c(a.split(","),function(a){function c(a){a||(a=window.event);d(a)||(a.cancelBubble=!0,a.returnValue=!1,a.preventDefault&&a.preventDefault(),a.stopPropagation&&a.stopPropagation())}b.addEventListener?b.addEventListener(a,c,!1):b.attachEvent?b.attachEvent("on"+a,c):b["on"+a]=c})}function o(){return m("head")[0]}function n(a,b,d){if(d)a.setAttribute(b,d);else return a&&a.getAttribute&&a.getAttribute(b)}function H(a,b){for(var d in b)if(b.hasOwnProperty(d))try{a.style[d]=
b[d]+(0<"|width|height|top|left|".indexOf(d)&&"number"==typeof b[d]?"px":"")}catch(c){}}function l(a){return document.createElement(a)}function f(){return E||q()?0:t()}function A(a){return G(encodeURIComponent(a).split(""),function(a){return 0>"-_.!~*'()".indexOf(a)?a:"%"+a.charCodeAt(0).toString(16).toUpperCase()}).join("")}function u(a){function b(a,b){f||(f=1,a||i(b),d.onerror=null,clearTimeout(g),setTimeout(function(){a&&h();var b=p(e),d=b&&b.parentNode;d&&d.removeChild(b)},x))}if(E||q())return P(a);
var d=l("script"),c=a.c,e=t(),f=0,g=setTimeout(function(){b(1)},F),h=a.a||r(),i=a.b||r();window[c]=function(a){b(0,a)};d[J]=J;d.onerror=function(){b(1)};d.src=a.url.join(K);n(d,"id",e);o().appendChild(d);return b}function P(a){function b(a){e||(e=1,clearTimeout(g),c&&(c.onerror=c.onload=null,c.abort&&c.abort(),c=null),a&&h())}function d(){if(!f){f=1;clearTimeout(g);try{response=JSON.parse(c.responseText)}catch(a){return b(1)}i(response)}}var c,e=0,f=0,g=setTimeout(function(){b(1)},F),h=a.a||r(),i=
a.b||r();try{c=q()||window.XDomainRequest&&new XDomainRequest||new XMLHttpRequest,c.onerror=c.onabort=function(){b(1)},c.onload=c.onloadend=d,c.timeout=F,c.open("GET",a.url.join(K),!0),c.send()}catch(k){return b(0),E=0,u(a)}return b}function D(){PUBNUB.time(k);PUBNUB.time(function(){setTimeout(function(){C||(C=1,c(I,function(a){a[2].subscribe(a[0],a[1])}))},x)})}function q(){if(!L.get)return 0;var a={id:q.id++,send:r(),abort:function(){a.id={}},open:function(b,c){q[a.id]=a;L.get(a.id,c)}};return a}
window.console||(window.console=window.console||{});console.log||(console.log=(window.opera||{}).postError||r());var B=function(){var a=window.localStorage;return{get:function(b){try{return a?a.getItem(b):-1==document.cookie.indexOf(b)?null:((document.cookie||"").match(RegExp(b+"=([^;]+)"))||[])[1]||null}catch(c){}},set:function(b,c){try{if(a)return a.setItem(b,c)&&0;document.cookie=b+"="+c+"; expires=Thu, 1 Aug 2030 20:00:00 UTC; path=/"}catch(e){}}}}(),N=1,O=/{([\w\-]+)}/g,J="async",K="/",F=14E4,
x=1E3,E=-1==navigator.userAgent.indexOf("MSIE 6"),M=function(){var a=Math.floor(9*Math.random())+1;return function(b){return 0<b.indexOf("pubsub")&&b.replace("pubsub","ps"+(10>++a?a:a=1))||b}}(),y={list:{},unbind:function(a){y.list[a]=[]},bind:function(a,b){(y.list[a]=y.list[a]||[]).push(b)},fire:function(a,b){c(y.list[a]||[],function(a){a(b)})}},v=p("pubnub")||{},C=0,I=[];PUBNUB=w({publish_key:n(v,"pub-key"),subscribe_key:n(v,"sub-key"),ssl:"on"==n(v,"ssl"),origin:n(v,"origin")});H(v,{position:"absolute",
top:-x});if("opera"in window||n(v,"flash"))v.innerHTML="<object id=pubnubs data=https://dh15atwfs066y.cloudfront.net/pubnub.swf><param name=movie value=https://dh15atwfs066y.cloudfront.net/pubnub.swf><param name=allowscriptaccess value=always></object>";var L=p("pubnubs")||{};h("load",window,function(){setTimeout(D,0)});PUBNUB.rdx=function(a,b){if(!b)return q[a].onerror();q[a].responseText=unescape(b);q[a].onload()};q.id=x;window.jqac&&(window.jqac.PUBNUB=PUBNUB);"undefined"!==typeof module&&
(module.f=PUBNUB)&&D()}();
})();
}
// x_core.js, X v3.15.2, Cross-Browser.com DHTML Library
// Copyright (c) 2004 Michael Foster, Licensed LGPL (gnu.org)

// global vars still duplicated in xlib.js - I still don't know what I'm going to do about this
var xVersion='3.15.2',xGecko,xNN4,xOp7,xOp5or6,xIE4Up,xIE4,xIE5,xMac,xSafari,xUA=navigator.userAgent.toLowerCase();
if (window.opera){
  xOp7=(xUA.indexOf('opera 7')!=-1 || xUA.indexOf('opera/7')!=-1);
  if (!xOp7) xOp5or6=(xUA.indexOf('opera 5')!=-1 || xUA.indexOf('opera/5')!=-1 || xUA.indexOf('opera 6')!=-1 || xUA.indexOf('opera/6')!=-1);
}
else if (document.all && xUA.indexOf('msie')!=-1) {
  xIE4Up=parseInt(navigator.appVersion)>=4;
  xIE4=xUA.indexOf('msie 4')!=-1;
  xIE5=xUA.indexOf('msie 5')!=-1;
}
else if (document.layers) {xNN4=true;}
else if (navigator.product != null && navigator.product.toLowerCase() == 'gecko')
        xGecko=true;
xMac=xUA.indexOf('mac')!=-1;
xSafari=xUA.indexOf('safari')!=-1;
// Safari claims its Gecko
if (xGecko && xSafari)
    xGecko = false;

function xGetElementById(e) {
  if(typeof(e)!='string') return e;
  if(document.getElementById) e=document.getElementById(e);
  else if(document.all) e=document.all[e];
  else e=null;
  return e;
}
function xParent(e,bNode){
  if (!(e=xGetElementById(e))) return null;
  var p=null;
  if (!bNode && xDef(e.offsetParent)) p=e.offsetParent;
  else if (xDef(e.parentNode)) p=e.parentNode;
  else if (xDef(e.parentElement)) p=e.parentElement;
  return p;
}
function xDef() {
  for(var i=0; i<arguments.length; ++i){if(typeof(arguments[i])=='undefined') return false;}
  return true;
}
function xStr(s) {
  for(var i=0; i<arguments.length; ++i){if(typeof(arguments[i])!='string') return false;}
  return true;
}
function xNum(n) {
  for(var i=0; i<arguments.length; ++i){if(typeof(arguments[i])!='number') return false;}
  return true;
}
function xShow(e) {
  if(!(e=xGetElementById(e))) return;
  if(e.style && xDef(e.style.visibility)) e.style.visibility='visible';
}
function xHide(e) {
  if(!(e=xGetElementById(e))) return;
  if(e.style && xDef(e.style.visibility)) e.style.visibility='hidden';
}
function xIsVisible(e) {
        if(!(e=xGetElementById(e))) return;
        // if no style object just return true
        if(!e.style || !xDef(e.style.visibility))
                return true;

        return (e.style.visibility == "visible");
}
function xZIndex(e,uZ) {
  if(!(e=xGetElementById(e))) return 0;
  if(e.style && xDef(e.style.zIndex)) {
    if(xNum(uZ)) e.style.zIndex=uZ;
    uZ=parseInt(e.style.zIndex);
  }
  return uZ;
}
function xColor(e,sColor) {
  if(!(e=xGetElementById(e))) return '';
  var c='';
  if(e.style && xDef(e.style.color)) {
    if(xStr(sColor)) e.style.color=sColor;
    c=e.style.color;
  }
  return c;
}
function xBackground(e,sColor,sImage) {
  if(!(e=xGetElementById(e))) return '';
  var bg='';
  if(e.style) {
    if(xStr(sColor)) {
      if(!xOp5or6) e.style.backgroundColor=sColor;
      else e.style.background=sColor;
    }
    if(xStr(sImage)) e.style.backgroundImage=(sImage!='')? 'url('+sImage+')' : null;
    if(!xOp5or6) bg=e.style.backgroundColor;
    else bg=e.style.background;
  }
  return bg;
}
function xMoveTo(e,iX,iY) {
  xLeft(e,iX);
  xTop(e,iY);
}
function xLeft(e,iX) {
  if(!(e=xGetElementById(e))) return 0;
  var css=xDef(e.style);
  if (css && xStr(e.style.left)) {
    if(xNum(iX)) e.style.left=iX+'px';
    else {
      iX=parseInt(e.style.left);
      if(isNaN(iX)) iX=0;
    }
  }
  else if(css && xDef(e.style.pixelLeft)) {
    if(xNum(iX)) e.style.pixelLeft=iX;
    else iX=e.style.pixelLeft;
  }
  return iX;
}
function xTop(e,iY) {
  if(!(e=xGetElementById(e))) return 0;
  var css=xDef(e.style);
  if(css && xStr(e.style.top)) {
    if(xNum(iY)) e.style.top=iY+'px';
    else {
      iY=parseInt(e.style.top);
      if(isNaN(iY)) iY=0;
    }
  }
  else if(css && xDef(e.style.pixelTop)) {
    if(xNum(iY)) e.style.pixelTop=iY;
    else iY=e.style.pixelTop;
  }
  return iY;
}
function xPageX(e) {
  if (!(e=xGetElementById(e))) return 0;
  var x = 0;
  while (e) {
    if (xDef(e.offsetLeft)) x += e.offsetLeft;
    e = xDef(e.offsetParent) ? e.offsetParent : null;
  }
  return x;
}
function xPageY(e) {
  if (!(e=xGetElementById(e))) return 0;
  var y = 0;
  while (e) {
    if (xDef(e.offsetTop)) y += e.offsetTop;
    e = xDef(e.offsetParent) ? e.offsetParent : null;
  }
//  if (xOp7) return y - document.body.offsetTop; // v3.14, temporary hack for opera bug 130324
  return y;
}
function xOffsetLeft(e) {
  if (!(e=xGetElementById(e))) return 0;
  if (xDef(e.offsetLeft)) return e.offsetLeft;
  else return 0;
}
function xOffsetTop(e) {
  if (!(e=xGetElementById(e))) return 0;
  if (xDef(e.offsetTop)) return e.offsetTop;
  else return 0;
}
//FIXME: Test More
function xOffsetWidth(e, includePaddingBorder) {
        if(!(e=xGetElementById(e))) return 0;
        if (xDef(includePaddingBorder) == false)
                includePaddingBorder = true;

        var width = e.offsetWidth;
        if (xDef(document.compatMode)) {
                if ((document.compatMode == "BackCompat" && xIE4Up)
                        || xIE4 || xIE5) {
                        // these browsers leave out the padding, which is incorrect
                        var padding = xToPixelInt(xGetComputedStyle(e, "padding-left")) +
                                                  xToPixelInt(xGetComputedStyle(e, "padding-right"));
                        width = width + padding;
                }
        }

        if (!includePaddingBorder) {
                // calculate the padding and border and subtract it
                var padding = xToPixelInt(xGetComputedStyle(e, "padding-left")) +
                                          xToPixelInt(xGetComputedStyle(e, "padding-right"));
                var border = xToPixelInt(xGetComputedStyle(e, "border-left-width")) +
                                         xToPixelInt(xGetComputedStyle(e, "border-right-width"));

                width = width - padding - border;
        }

        return width;
}
//FIXME: Test More
function xOffsetHeight(e, includePaddingBorder) {
        if(!(e=xGetElementById(e))) return 0;
        if (xDef(includePaddingBorder) == false)
                includePaddingBorder = true;

        var height = e.offsetHeight;
        if (xDef(document.compatMode)) {
                if ((document.compatMode == "BackCompat" && xIE4Up)
                        || xIE4 || xIE5) {
                        // these browsers leave out the padding, which is incorrect
                        var padding = xToPixelInt(xGetComputedStyle(e, "padding-top")) +
                                                  xToPixelInt(xGetComputedStyle(e, "padding-bottom"));
                        height = height + padding;
                }
        }

        if (!includePaddingBorder) {
                // calculate the padding and border and subtract it
                var padding = xToPixelInt(xGetComputedStyle(e, "padding-top")) +
                                          xToPixelInt(xGetComputedStyle(e, "padding-bottom"));
                var border = xToPixelInt(xGetComputedStyle(e, "border-top-width")) +
                                         xToPixelInt(xGetComputedStyle(e, "border-bottom-width"));

                height = height - padding - border;
        }

        return height;
}
function xScrollLeft(e) {
  var offset=0;
  if (!(e=xGetElementById(e))) {
    if(document.documentElement && document.documentElement.scrollLeft) offset=document.documentElement.scrollLeft;
    else if(document.body && xDef(document.body.scrollLeft)) offset=document.body.scrollLeft;
  }
  else { if (xNum(e.scrollLeft)) offset = e.scrollLeft; }
  return offset;
}
function xScrollTop(e) {
  var offset=0;
  if (!(e=xGetElementById(e))) {
    if(document.documentElement && document.documentElement.scrollTop) offset=document.documentElement.scrollTop;
    else if(document.body && xDef(document.body.scrollTop)) offset=document.body.scrollTop;
  }
  else { if (xNum(e.scrollTop)) offset = e.scrollTop; }
  return offset;
}
function xHasPoint(ele, iLeft, iTop, iClpT, iClpR, iClpB, iClpL) {
  if (!xNum(iClpT)){iClpT=iClpR=iClpB=iClpL=0;}
  else if (!xNum(iClpR)){iClpR=iClpB=iClpL=iClpT;}
  else if (!xNum(iClpB)){iClpL=iClpR; iClpB=iClpT;}
  var thisX = xPageX(ele), thisY = xPageY(ele);
  return (iLeft >= thisX + iClpL && iLeft <= thisX + xWidth(ele) - iClpR &&
          iTop >=thisY + iClpT && iTop <= thisY + xHeight(ele) - iClpB );
}
function xResizeTo(e,uW,uH) {
  xWidth(e,uW);
  xHeight(e,uH);
}
function xWidth(e,uW) {
  if(!(e=xGetElementById(e))) return 0;
  if (xNum(uW)) {
    if (uW<0) uW = 0;
    else uW=Math.round(uW);
  }
  else uW=-1;
  var css=xDef(e.style);
  if(css && xDef(e.offsetWidth) && xStr(e.style.width)) {
    if(uW>=0) xSetCW(e, uW);
    uW=e.offsetWidth;
  }
  else if(css && xDef(e.style.pixelWidth)) {
    if(uW>=0) e.style.pixelWidth=uW;
    uW=e.style.pixelWidth;
  }
  return uW;
}
function xHeight(e,uH) {
  if(!(e=xGetElementById(e))) return 0;
  if (xNum(uH)) {
    if (uH<0) uH = 0;
    else uH=Math.round(uH);
  }
  else uH=-1;
  var css=xDef(e.style);
  if(css && xDef(e.offsetHeight) && xStr(e.style.height)) {
    if(uH>=0) xSetCH(e, uH);
    uH=e.offsetHeight;
  }
  else if(css && xDef(e.style.pixelHeight)) {
    if(uH>=0) e.style.pixelHeight=uH;
    uH=e.style.pixelHeight;
  }
  return uH;
}
function xGetCS(ele,sP){
        return document.defaultView.getComputedStyle(ele,'').getPropertyValue(sP);
}
function xSetCW(ele,uW){
  var pl=0,pr=0,bl=0,br=0;
  if(xDef(document.defaultView) && xDef(document.defaultView.getComputedStyle)){
    pl=xGetCS(ele,'padding-left');
    pr=xGetCS(ele,'padding-right');
    bl=xGetCS(ele,'border-left-width');
    br=xGetCS(ele,'border-right-width');
  }
  else if(xDef(ele.currentStyle,document.compatMode)){
    if(document.compatMode=='CSS1Compat'){
      pl=parseInt(ele.currentStyle.paddingLeft);
      pr=parseInt(ele.currentStyle.paddingRight);
      bl=parseInt(ele.currentStyle.borderLeftWidth);
      br=parseInt(ele.currentStyle.borderRightWidth);
    }
  }
  else if(xDef(ele.offsetWidth,ele.style.width)){ // ?
    ele.style.width=uW+'px';
    pl=ele.offsetWidth-uW;
  }
  if(isNaN(pl)) pl=0; if(isNaN(pr)) pr=0; if(isNaN(bl)) bl=0; if(isNaN(br)) br=0;
  var cssW=uW-(pl+pr+bl+br);
  if(isNaN(cssW)||cssW<0) return;
  else ele.style.width=cssW+'px';
}
function xSetCH(ele,uH){
  var pt=0,pb=0,bt=0,bb=0;
  if(xDef(document.defaultView) && xDef(document.defaultView.getComputedStyle)){
    pt=xGetCS(ele,'padding-top');
    pb=xGetCS(ele,'padding-bottom');
    bt=xGetCS(ele,'border-top-width');
    bb=xGetCS(ele,'border-bottom-width');
  }
  else if(xDef(ele.currentStyle,document.compatMode)){
    if(document.compatMode=='CSS1Compat'){
      pt=parseInt(ele.currentStyle.paddingTop);
      pb=parseInt(ele.currentStyle.paddingBottom);
      bt=parseInt(ele.currentStyle.borderTopWidth);
      bb=parseInt(ele.currentStyle.borderBottomWidth);
    }
  }
  else if(xDef(ele.offsetHeight,ele.style.height)){ // ?
    ele.style.height=uH+'px';
    pt=ele.offsetHeight-uH;
  }
  if(isNaN(pt)) pt=0; if(isNaN(pb)) pb=0; if(isNaN(bt)) bt=0; if(isNaN(bb)) bb=0;
  var cssH=uH-(pt+pb+bt+bb);
  if(isNaN(cssH)||cssH<0) return;
  else ele.style.height=cssH+'px';
}
function xClip(e,iTop,iRight,iBottom,iLeft) {
  if(!(e=xGetElementById(e))) return;
  if(e.style) {
    if (xNum(iLeft)) e.style.clip='rect('+iTop+'px '+iRight+'px '+iBottom+'px '+iLeft+'px)';
    else e.style.clip='rect(0 '+parseInt(e.style.width)+'px '+parseInt(e.style.height)+'px 0)';
  }
}
function xClientWidth() {
  var w=0;
  if(xOp5or6) w=window.innerWidth;
  else if(!window.opera && document.documentElement && document.documentElement.clientWidth)
    w=document.documentElement.clientWidth;
  else if(document.body && document.body.clientWidth)
    w=document.body.clientWidth;
  else if(xDef(window.innerWidth,window.innerHeight,document.height)) {
    w=window.innerWidth;
    if(document.height>window.innerHeight) w-=16;
  }
  return w;
}
function xClientHeight() {
  var h=0;
  if(xOp5or6) h=window.innerHeight;
  else if(!window.opera && document.documentElement && document.documentElement.clientHeight)
    h=document.documentElement.clientHeight;
  else if(document.body && document.body.clientHeight)
    h=document.body.clientHeight;
  else if(xDef(window.innerWidth,window.innerHeight,document.width)) {
    h=window.innerHeight;
    if(document.width>window.innerWidth) h-=16;
  }
  return h;
}
function xInnerHtml(e, sHtml) {
  if(!(e=xGetElementById(e))) return '';
  if (xStr(e.innerHTML)) {
    if (xStr(sHtml)) e.innerHTML = sHtml;
    else return e.innerHTML;
  }
}
/** Converts a pixel string, such as "30px" into its numerical value.  It can
        also scan a string with text, such as "solid black 2px" and grab the
        first pixel value and return it as a string. Returns null if there are
        no matches. If it is given a number it will also simply return that number.
  */
function xToPixelInt(value) {
        if (xDef(value) == false)
                return null;

        if (xNum(value))
                return value;

        var matches = value.match(/\D*(\d*)\D*/);

        if (matches.length > 1)
                return parseInt(matches[1]);
        else
                return null;
}
/** Adds a "px" to the end of a pixel value. Returns a null value if
        this is not possible. */
function xToPixelString(value) {
        if (xNum(value))
                return parseInt(value) + "px";
        else {
                if (xStr(value)) {
                        var matches = value.match(/^(\d*)px$/);
                        if (matches.length > 1) {
                                return parseInt(matches[1]);
                        }
                }
        }

        return null;
}
function xTrim(s) {
    if (!xDef(s) || s == null)
        return s;

    // Remove leading spaces and carriage returns
    while (s.substring(0, 1) == ' ' || s.substring(0, 1) == '\n' ||
           s.substring(0, 1) == '\r') {
        s = s.substring(1, s.length);
    }

    // Remove trailing spaces and carriage returns
    while (s.substring(s.length-1, s.length) == ' ' ||
           s.substring(s.length-1, s.length) == '\n' ||
           s.substring(s.length-1, s.length) == '\r') {
        s = s.substring(0, s.length-1);
    }

    return s;
}

/** A simple Class object to help with JavaScript OOP.
    To use:
    
    var Page = new Class();
      
      Page.prototype = {
        construct: function(pageName, pageData) {
          this.pageName = pageName;
          this.pageData = pageData;
        }, 
        
        sayHello: function() {
          alert("Hello World");
          alert("pageName="+this.pageName);
          alert("pageData="+this.pageData);
        }
      };
      
      var mainPage = new Page("Main", "Some Page Data");
      mainPage.sayHello();      
*/

function Class() {
    return function() {
      if (this.construct != undefined) {
        // call the subclass's constructor
        this.construct.apply(this, arguments); 
      }
    };
};
      
/** Beginning of code taken from Prototype.js - 1.3.1. */
if (!Array.prototype.push) {
  Array.prototype.push = function() {
		var startLength = this.length;
		for (var i = 0; i < arguments.length; i++)
      this[startLength + i] = arguments[i];
	  return this.length;
  }
}

if (!Function.prototype.apply) {
  // Based on code from http://www.youngpup.net/
  Function.prototype.apply = function(object, parameters) {
    var parameterStrings = new Array();
    if (!object)     object = window;
    if (!parameters) parameters = new Array();
    
    for (var i = 0; i < parameters.length; i++)
      parameterStrings[i] = 'parameters[' + i + ']';
    
    object.__apply__ = this;
    var result = eval('object.__apply__(' + 
      parameterStrings.join(', ') + ')');
    object.__apply__ = null;
    
    return result;
  }
}

Function.prototype.bind = function(object) {
  var __method = this;
  return function() {
    __method.apply(object, arguments);
  }
}
/** End of code taken from Prototype.js - 1.3.1. */

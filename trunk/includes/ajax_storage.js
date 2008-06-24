
/** Constructor */

function Storage() {
  // determine the size to use based on whether we are debugging or not
  var width, height;
  if (this.debugging) {
    width = 470;
    height = 350;
  }
  else {
    // minimum size needed for Flash storage dialog
    width = 215;
    height = 138;
  }
  
  // determine what style property to write out based on whether we are
  // debugging or not
  var flashDivStyle;
  if (this.debugging) {
    flashDivStyle = "width: " + width + "px; height: " 
                    + height + "px;";
  }
  else {
    flashDivStyle = "width: " + width + "px; height: " 
                      + height + "px; "
                      + "position: absolute; z-index: 100; top: -1000px; left: -1000px;";
  }

  // write out the Flash storage object
  document.write('<div id="flashStorageDiv" style="' + flashDivStyle + ' display:none;"\>\n');
  // FIXME: For some reason the object tag fails now on IE
  document.write('<object id="flashStorage" ');
  document.write('classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ');
  document.write('codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" ');
  document.write('width="' + width + '" height="' + height + '" align="middle"\>\n');
  document.write('<param name="allowScriptAccess" value="sameDomain" /\>\n');
  document.write('<param name="movie" value="storage.swf" /\>\n');
  document.write('<param name="quality" value="high" /\>\n');
  document.write('<param name="bgcolor" value="#ffffff" /\>\n');
  document.write('<embed id="flashStorage" src="storage.swf" ');
  document.write('quality="high" bgcolor="#ffffff" ');
  document.write('width="' + width + '" height="' + height + '" name="flashStorage" ');
  document.write('align="middle" allowScriptAccess="sameDomain" ');
  document.write('type="application/x-shockwave-flash" swLiveConnect="true" ');
  document.write('pluginspage="http://www.macromedia.com/go/getflashplayer" /\>\n');
  document.write('</object\>\n');
  document.write('</div\>\n');
   
  // hook for Internet Explorer to receive FSCommands from Flash
  if (xIE4Up) {
    document.write('<SCRIPT LANGUAGE=VBScript\> \n');
    document.write('on error resume next \n');
    document.write('Sub flashStorage_FSCommand(ByVal command, ByVal args)\n');
    document.write(' call flashStorage_DoFSCommand(command, args)\n');
    document.write('end sub\n');
    document.write('</SCRIPT\> \n');
  }
}

/** Public constants */

/** public */ Storage.SUCCESS = "success";
/** public */ Storage.FAILED = "failed";
/** public */ Storage.PENDING = "pending";

Storage.prototype = {
  /** public */ displayingDialog: false,
  
  /** private */ debugging: false,
  /** private */ onStatusHandler: null,
  /** private */ onLoadListener: null,
  
  /** Is called when the storage system is ready to be used. */
  /** public */ onLoad: function(onLoadListener) {
    this.onLoadListener = onLoadListener;
  },
  
  /** public */ onload: function(onLoadListener) {
    this.onLoad(onLoadListener);
  },
  
  /** Pops up the storage settings dialog. */
  /** public */ showSettings: function() {
    if (this.displayingDialog == true)
      return;
      
    var flashStorage = this.getFlashStorage();
    flashStorage.TCallLabel("/storageBehavior", "showSettings");
    
    this.showDialog();
  },
  
  
  /** Adds an entry to the permanent storage hash table with the key
      'keyName' and the value 'keyValue'. 'onStatus' is a function
      pointer to a handler that will receive one argument, a
      status argument that is one of three values: 
      Storage.SUCCESS, Storage.PENDING, or Storage.FAILURE.
      'serialize' is a private value used internally. 
      This method will serialize any JavaScript objects given.
      Use putString() for greater performance when dealing with
      just strings and large sets of data. */
  /** public */ put: function(keyName, keyValue, onStatus, doSerialization) {
    if (typeof doSerialization == "undefined")
      doSerialization = true;
      
    var flashStorage = this.getFlashStorage();
    
    this.onStatusHandler = onStatus;
    
    // serialize the keyValue
    if (doSerialization == true)
      keyValue = JSON.stringify(keyValue);
    
    // set the values
    flashStorage.SetVariable("keyName", keyName);
    flashStorage.SetVariable("keyValue", keyValue);
    
    // tell Flash they have changed so they can be stored
    flashStorage.TCallLabel("/storageBehavior", "put");
    
    // now we must wait for the main movie to do an
    // FSCommand back to us named "put_results"
  },
  
  /** Adds an entry to the permanent storage hash table with the key
      'keyName' and the value 'keyValue'. 'onStatus' is a function
      pointer to a handler that will receive one argument, a
      status argument that is one of three values: 
      Storage.SUCCESS, Storage.PENDING, or Storage.FAILURE.
      
      Unlike put(), JavaScript key values are not serialized. Only
      strings can be passed in; this leads to greater performance when working
      with large datasets and XML. This method must be used in
      conjunction with getString() to retrieve the value efficiently. */
  /** public */ putString: function(keyName, keyValue, onStatus) {
    this.put(keyName, keyValue, onStatus, false);
  },
    
  /** Gets the given 'keyName' from the permanent storage hash table.
      If the key does not exist, then null is returned. This
      method will deserialize JavaScript objects. Use getString()
      when dealing with extremely large datasets and XML. 
      
      'doDeserialization' is a private variable used internally
      to control whether to deserialize key values. */
  /** public */ get: function(keyName, doDeserialization) {
    if (typeof doDeserialization == "undefined")
      doDeserialization = true;
      
    var flashStorage = this.getFlashStorage();
    
    // set the value to get
    flashStorage.SetVariable("keyName", keyName);
    
    // tell Flash to get this value
    flashStorage.TCallLabel("/storageBehavior", "get");
    
    // get the results of this 'Get'
    var results = flashStorage.GetVariable("keyValue");
    
    if (results == "")
      return null;
    
    // destringify the content back into a 
    // real JavaScript object
    if (doDeserialization == true)
      results = eval('(' + results + ')');  
    
    return results;
  },
  
  /** Gets the given 'keyName' from the permanent storage hash table.
      If the key does not exist, then null is returned. This method
      does not deserialize JavaScript objects, and simply returns the
      original string entered with putString(). */
  /** publuc */ getString: function(keyName) {
    return this.get(keyName, false);
  },
  
  /** public */ hasKey: function(keyName) {
    var results = this.getString(keyName);
    
    if (results == null || results == undefined || results == "")
      return false;
    else
      return true;
  },
  
  /** private */ initialize: function() {
    // hide the debugging content in the Flash movie if we are not debugging
    if (this.debugging == false) {
      var flashStorage = this.getFlashStorage();
      flashStorage.TCallLabel("/storageBehavior", "hide");
    }
    
    if (this.onLoadListener != null && this.onLoadListener != undefined)
      this.onLoadListener.call(null);
  },
  
  /** private */ assertValidKey: function(keyName) {
    // keys must be letters, numbers, and forward slashes 
    // - no spaces allowed
    // Requirements come from Flash's SharedObject object names
  },
  
  /** private */ getFlashStorage: function() {
    return window.document.flashStorage;
  },
  
  /** private */ showDialog: function() {
    this.displayingDialog = true;
    
    // if we are debugging the dialog is already visible
    if (this.debugging == true)
      return;
      
    var flashDiv = document.getElementById("flashStorageDiv");
    
    // We want to center the dialog vertically and horizontally
    var elementWidth = 215;
    var elementHeight = 138;
    
    // get the browser width and height; the code below
    // works in IE and Firefox in compatibility, non-strict
    // mode
    var browserWidth = document.body.clientWidth;
    var browserHeight = document.body.clientHeight;
    
    // in Firefox if we are in standards compliant mode
    // (with a strict doctype), then the browser width
    // and height have to be computed from the root level
    // HTML element not the body element
    if (!xIE4Up && document.compatMode == "CSS1Compat") {
      browserWidth = document.body.parentNode.clientWidth;
      browserHeight = document.body.parentNode.clientHeight;
    }
    // IE 6 in standards compliant mode has to be calculated
    // differently
    else if (xIE4Up && document.compatMode == "CSS1Compat") {
      browserWidth = document.documentElement.clientWidth;
      browserHeight = document.documentElement.clientHeight;
    }
    
    // get where we are scrolled to in the document
    // the code below works in FireFox
    var scrolledByWidth = window.scrollX;
    var scrolledByHeight = window.scrollY;
    // compute these values differently for IE;
    // IE has two possibilities; it is either in standards
    // compatibility mode or it is not
    if (typeof scrolledByWidth == "undefined") {
      if (document.compatMode == "CSS1Compat") { // standards mode
        scrolledByWidth = document.documentElement.scrollLeft;
        scrolledByHeight = document.documentElement.scrollTop;
      }
      else { // Pre IE6 non-standards mode
        scrolledByWidth = document.body.scrollLeft;
        scrolledByHeight = document.body.scrollTop;
      }
    }

    // compute the centered position    
    var x = scrolledByWidth + (browserWidth - elementWidth) / 2;
    var y = scrolledByHeight + (browserHeight - elementHeight) / 2; 
    
    // set the centered position
    flashDiv.style.top = y + "px";
    flashDiv.style.left = x + "px";
  },
  
  /** private */ hideDialog: function() {
    this.displayingDialog = false;
    // if we are debugging we don't hide anything
    if (this.debugging)
      return;
      
    var flashDiv = document.getElementById("flashStorageDiv");
    flashDiv.style.top = "-1000px";
    flashDiv.style.left = "-1000px";
  }
};

/** Hang storage off of the window object. */
/** public */ window.storage = new Storage();

/** Global function needed for Flash callback's */
/** private */ function flashStorage_DoFSCommand(command, args) {
  if (command == "loaded")
    window.storage.initialize();
  else if (command == "put_results") {
    var flashStorage = window.storage.getFlashStorage();
    
    // get the results of the storage action
    var results = args;
    
    // parse the results, removing the leading "flush: " string
    if (results != undefined && results.indexOf("flush:") != -1)
      results = results.replace(/flush: /, "");

    if (results == "pending")
      results = Storage.PENDING;
    else if (results == "true")
      results = Storage.SUCCESS;
    else if (results == "false")
      results = Storage.FAILED;
      
    if (results == Storage.PENDING) {
      window.storage.showDialog();
    }
    else
      window.storage.displayingDialog = false;
      
    // send this value to the onStatus listener
    window.storage.onStatusHandler.call(null, results);
  }
  else if (command == "onstatus") {
    // this is an onStatus result
    var matcher = /level: ([^,]*), code: ([^,]*)/;
    var matches = args.match(matcher);
    var level = matches[1];
    var code = matches[2];
    var status;
    
    if (level == "error" && code == "SharedObject.Flush.Failed")
      status = Storage.FAILED;
    else if (level == "status" && code == "SharedObject.Flush.Success")
      status = Storage.SUCCESS;
    else
      throw "Unknown results from SharedObject: " + args;
      
    window.storage.hideDialog();
    
    if (window.storage.onStatusHandler != null 
        || window.storage.onStatusHandler != undefined) {
      window.storage.onStatusHandler.call(null, status);
    }
  }
}



















/** The JSON class is copyright 2005 JSON.org. */
Array.prototype.______array = '______array';

var JSON = {
    org: 'http://www.JSON.org',
    copyright: '(c)2005 JSON.org',
    license: 'http://www.crockford.com/JSON/license.html',

    stringify: function (arg) {
        var c, i, l, s = '', v;

        switch (typeof arg) {
        case 'object':
            if (arg) {
                if (arg.______array == '______array') {
                    for (i = 0; i < arg.length; ++i) {
                        v = this.stringify(arg[i]);
                        if (s) {
                            s += ',';
                        }
                        s += v;
                    }
                    return '[' + s + ']';
                } else if (typeof arg.toString != 'undefined') {
                    for (i in arg) {
                        v = arg[i];
                        if (typeof v != 'undefined' && typeof v != 'function') {
                            v = this.stringify(v);
                            if (s) {
                                s += ',';
                            }
                            s += this.stringify(i) + ':' + v;
                        }
                    }
                    return '{' + s + '}';
                }
            }
            return 'null';
        case 'number':
            return isFinite(arg) ? String(arg) : 'null';
        case 'string':
            l = arg.length;
            s = '"';
            for (i = 0; i < l; i += 1) {
                c = arg.charAt(i);
                if (c >= ' ') {
                    if (c == '\\' || c == '"') {
                        s += '\\';
                    }
                    s += c;
                } else {
                    switch (c) {
                        case '\b':
                            s += '\\b';
                            break;
                        case '\f':
                            s += '\\f';
                            break;
                        case '\n':
                            s += '\\n';
                            break;
                        case '\r':
                            s += '\\r';
                            break;
                        case '\t':
                            s += '\\t';
                            break;
                        default:
                            c = c.charCodeAt();
                            s += '\\u00' + Math.floor(c / 16).toString(16) +
                                (c % 16).toString(16);
                    }
                }
            }
            return s + '"';
        case 'boolean':
            return String(arg);
        default:
            return 'null';
        }
    },
    parse: function (text) {
        var at = 0;
        var ch = ' ';

        function error(m) {
            throw {
                name: 'JSONError',
                message: m,
                at: at - 1,
                text: text
            };
        }

        function next() {
            ch = text.charAt(at);
            at += 1;
            return ch;
        }

        function white() {
            while (ch != '' && ch <= ' ') {
                next();
            }
        }

        function str() {
            var i, s = '', t, u;

            if (ch == '"') {
outer:          while (next()) {
                    if (ch == '"') {
                        next();
                        return s;
                    } else if (ch == '\\') {
                        switch (next()) {
                        case 'b':
                            s += '\b';
                            break;
                        case 'f':
                            s += '\f';
                            break;
                        case 'n':
                            s += '\n';
                            break;
                        case 'r':
                            s += '\r';
                            break;
                        case 't':
                            s += '\t';
                            break;
                        case 'u':
                            u = 0;
                            for (i = 0; i < 4; i += 1) {
                                t = parseInt(next(), 16);
                                if (!isFinite(t)) {
                                    break outer;
                                }
                                u = u * 16 + t;
                            }
                            s += String.fromCharCode(u);
                            break;
                        default:
                            s += ch;
                        }
                    } else {
                        s += ch;
                    }
                }
            }
            error("Bad string");
        }

        function arr() {
            var a = [];

            if (ch == '[') {
                next();
                white();
                if (ch == ']') {
                    next();
                    return a;
                }
                while (ch) {
                    a.push(val());
                    white();
                    if (ch == ']') {
                        next();
                        return a;
                    } else if (ch != ',') {
                        break;
                    }
                    next();
                    white();
                }
            }
            error("Bad array");
        }

        function obj() {
            var k, o = {};

            if (ch == '{') {
                next();
                white();
                if (ch == '}') {
                    next();
                    return o;
                }
                while (ch) {
                    k = str();
                    white();
                    if (ch != ':') {
                        break;
                    }
                    next();
                    o[k] = val();
                    white();
                    if (ch == '}') {
                        next();
                        return o;
                    } else if (ch != ',') {
                        break;
                    }
                    next();
                    white();
                }
            }
            error("Bad object");
        }

        function num() {
            var n = '', v;
            if (ch == '-') {
                n = '-';
                next();
            }
            while (ch >= '0' && ch <= '9') {
                n += ch;
                next();
            }
            if (ch == '.') {
                n += '.';
                while (next() && ch >= '0' && ch <= '9') {
                    n += ch;
                }
            }
            if (ch == 'e' || ch == 'E') {
                n += 'e';
                next();
                if (ch == '-' || ch == '+') {
                    n += ch;
                    next();
                }
                while (ch >= '0' && ch <= '9') {
                    n += ch;
                    next();
                }
            }
            v = +n;
            if (!isFinite(v)) {
                error("Bad number");
            } else {
                return v;
            }
        }

        function word() {
            switch (ch) {
                case 't':
                    if (next() == 'r' && next() == 'u' && next() == 'e') {
                        next();
                        return true;
                    }
                    break;
                case 'f':
                    if (next() == 'a' && next() == 'l' && next() == 's' &&
                            next() == 'e') {
                        next();
                        return false;
                    }
                    break;
                case 'n':
                    if (next() == 'u' && next() == 'l' && next() == 'l') {
                        next();
                        return null;
                    }
                    break;
            }
            error("Syntax error");
        }

        function val() {
            white();
            switch (ch) {
                case '{':
                    return obj();
                case '[':
                    return arr();
                case '"':
                    return str();
                case '-':
                    return num();
                default:
                    return ch >= '0' && ch <= '9' ? num() : word();
            }
        }

        return val();
    }
};

/*

Better(?) Entry cross fader (C)2004 Patrick H. Lauke aka redux

Inspired by Steve at Slayeroffice http://slayeroffice.com/code/EntryCrossFade/ 

preInit "Scheduler" idea by Cameron Adams aka The Man in Blue
http://www.themaninblue.com/writing/perspective/2004/09/29/ 

Tweaked to deal with empty nodes 19 Feb 2006

*/

/* general variables */

var slideshowId = 'slide_show'; /* change this to the ID of the slideshow list */
var slideshow; /* this will be the object reference to the list later on */
var slideshowContent; /* array that will hold all child elements of the list */
var slideshowInterval=5000;		//Time (in milliseconds) to show entry
var slideshowEntries;		//# of elements in show
var currentEntry; /* keeps track of which Entry should currently be showing */
var node = null;
var previousEntry;

/* functions */

function fader(EntryNumber,opacity) {
	/* helper function to deal specifically with Entrys and the cross-browser differences in opacity handling */
	//var obj=slideshowContent[EntryNumber];
	var obj=slideshowchildNodes[EntryNumber];
	if (obj.style) {
		if (obj.style.MozOpacity!=null) {  
			/* Mozilla's pre-CSS3 proprietary rule */
			obj.style.MozOpacity = (opacity/100) - .001;
		} else if (obj.style.opacity!=null) {
			/* CSS3 compatible */
			obj.style.opacity = (opacity/100) - .001;
		} else if (obj.style.filter!=null) {
			/* IE's proprietary filter */
			obj.style.filter = "alpha(opacity="+opacity+")";
		}
	}
}

function fadeInit() 
{
	if (document.getElementById) {
//		slideshowContent = new Array;
yyyyy();
		slideshow=document.getElementById(slideshowId);
/*		
		node = slideshow.firstChild;
		// instead of using childNodes (which also gets empty nodes and messes up the script later)
		//we do it the old-fashioned way and loop through the first child and its siblings
		while (node) {
			if (node.nodeType==1) {
				slideshowContent.push(node);
			}
			node = node.nextSibling;
		}
		slideshowEntries=slideshowContent.length-1;
		for(i=0;i<=slideshowEntries;i++) {
			// loop through all these child nodes and set up their styles
			//slideshowContent[i].style.position='absolute';
			//slideshowContent[i].style.top=0;
			slideshowContent[i].style.zIndex=0;
			/* set their opacity to transparent */
			fader(i,0);
		}
*/		
		/* make the list visible again */
		slideshow.style.visibility = 'visible';
		/* initialise a few parameters to get the cycle going */
		currentEntry=0;
		//previousEntry=slideshow.length-1;
		previousEntry=slideshow.childNodes.length-1;
		opacity=100;
		fader(currentEntry,100);
		/* start the whole crossfade process after a second's pause */
		window.setTimeout("crossfade(100)", slideshowInterval);
	}
}

function crossfade(opacity) {
	if (opacity < 100) 
	{
		/* current Entry not faded up fully yet...so increase its opacity */
		fader(currentEntry,opacity);
		/* fader(previousEntry,100-opacity); */
		opacity += 10;
		window.setTimeout("crossfade("+opacity+")", 30);
	} 
	else 
	{
		/* make the previous Entry - which is now covered by the current one fully - transparent */
		fader(previousEntry,0);
		/* current Entry is now previous Entry, as we advance in the list of Entrys */
		previousEntry=currentEntry;
		//currentEntry+=1;
		currentEntry=Math.floor(Math.random()*(slideshowEntries+1));
		if (currentEntry>slideshowEntries)
		 {
			/* start over from first Entry if we cycled through all Entrys in the list */
			currentEntry=0;
		}
		/* make sure the current Entry is on top of the previous one */
		/*
		slideshowContent[previousEntry].style.zIndex = 0;
		slideshowContent[currentEntry].style.zIndex = 100;
		*/
		slideshow.childNodes[previousEntry].style.zIndex = 0;
		slideshowchildNodes[currentEntry].style.zIndex = 100;
		/* and start the crossfade after a second's pause */
		opacity=0;
		window.setTimeout("crossfade("+opacity+")", slideshowInterval);
	}
}


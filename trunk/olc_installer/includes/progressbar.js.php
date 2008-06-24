<?PHP
$s='USE_AJAX';
if (!defined($s))
{
	session_start();
	define($s,$_SESSION['ajax']==true);
}
if (USE_AJAX)
{
	$script='
/****************************************************************************************
                              DHTML progress bar script
                     Written by Mark Wilton-Jones, 1-2/10/2002
                                  Version 1.0.1
                     Updated 5/01/2007 to work in strict mode
*****************************************************************************************

Please see http://www.howtocreate.co.uk/jslibs/ for details of this script
Please see http://www.howtocreate.co.uk/jslibs/termsOfUse.html for terms of use

This script can produce an unlimited number of progress bars on the page, all highly
configurable.

To use:

Inbetween the <head> tags, put:

	<script src="PATH TO SCRIPT/progressbar.js" type="text/javascript"></script>

Wherever you want a progress bar, put:

	<script type="text/javascript">
		var myProgBar = new progressBar(
			1,         //border thickness
			"#000000", //border colour
			"#a5f3b1", //background colour
			"#043db2", //bar colour
			400,       //width of bar (excluding border)
			20,        //height of bar (excluding border)
			1          //direction of progress: 1 = right, 2 = down, 3 = left, 4 = up
		);
	</script>

Once the page has loaded, you can then contol the progress bar using:

	<script type="text/javascript">

myProgBar.setBar(0.5);       //set the progress bar to indicate a progress of 50%
myProgBar.setBar(0.1,true);  //add 10% to the progress bar\'s progress
myProgBar.setBar(0.1,false); //subtract 10% from the progress bar\'s progress
myProgBar.setCol("#ff0000"); //change the colour of the progress bar
alert( "Current progress is " + myProgBar.amt ) // read current progress

	</script>
_______________________________________________________________________________________*/

var MWJ_progBar = 0;

function getRefToDivNest( divID, oDoc ) {
	if( !oDoc ) { oDoc = document; }
	if( document.layers ) {
		if( oDoc.layers[divID] ) { return oDoc.layers[divID]; } else {
			for( var x = 0, y; !y && x < oDoc.layers.length; x++ ) {
				y = getRefToDivNest(divID,oDoc.layers[x].document); }
			return y; } }
	if( document.getElementById ) { return document.getElementById(divID); }
	if( document.all ) { return document.all[divID]; }
	return document[divID];
}

function progressBar( oBt, oBc, oBg, oBa, oWi, oHi, oDr ) {
	MWJ_progBar++; this.id = \'MWJ_progBar\' + MWJ_progBar; this.dir = oDr; this.width = oWi; this.height = oHi; this.amt = 0;
	//write the bar as a layer in an ilayer in two tables giving the border
	document.write( \'<table border="0" cellspacing="0" cellpadding="\'+oBt+\'"><tr><td bgcolor="\'+oBc+\'">\'+
		\'<table border="0" cellspacing="0" cellpadding="0"><tr><td height="\'+oHi+\'" width="\'+oWi+\'" bgcolor="\'+oBg+\'">\' );
	if( document.layers ) {
		document.write( \'<ilayer height="\'+oHi+\'" width="\'+oWi+\'"><layer bgcolor="\'+oBa+\'" name="MWJ_progBar\'+MWJ_progBar+\'"></layer></ilayer>\' );
	} else {
		document.write( \'<div style="position:relative;top:0px;left:0px;height:\'+oHi+\'px;width:\'+oWi+\'px;">\'+
			\'<div style="position:absolute;top:0px;left:0px;height:0px;width:0;font-size:1px;background-color:\'+oBa+\';" id="MWJ_progBar\'+MWJ_progBar+\'"></div></div>\' );
	}
	document.write( \'</td></tr></table></td></tr></table>\n\' );
	this.setBar = resetBar; //doing this inline causes unexpected bugs in early NS4
	this.setCol = setColour;
}
function setBar( a, b ) {
	//work out the required size and use various methods to enforce it
	this.amt = ( typeof( b ) == \'undefined\' ) ? a : b ? ( this.amt + a ) : ( this.amt - a );
	if( isNaN( this.amt ) ) { this.amt = 0; } if( this.amt > 1 ) { this.amt = 1; } if( this.amt < 0 ) { this.amt = 0; }
	var theWidth = Math.round( this.width * ( ( this.dir % 2 ) ? this.amt : 1 ) );
	var theHeight = Math.round( this.height * ( ( this.dir % 2 ) ? 1 : this.amt ) );
	var theDiv = getRefToDivNest( this.id ); if( !theDiv ) { window.status = \'Progress: \' + Math.round( 100 * this.amt ) + \'%\'; return; }
	if( theDiv.style ) { theDiv = theDiv.style; theDiv.clip = \'rect(0px \'+theWidth+\'px \'+theHeight+\'px 0px)\'; }
	var oPix = document.childNodes ? \'px\' : 0;
	theDiv.width = theWidth + oPix; theDiv.pixelWidth = theWidth; theDiv.height = theHeight + oPix; theDiv.pixelHeight = theHeight;
	if( theDiv.resizeTo ) { theDiv.resizeTo( theWidth, theHeight ); }
	theDiv.left = ( ( this.dir != 3 ) ? 0 : this.width - theWidth ) + oPix; theDiv.top = ( ( this.dir != 4 ) ? 0 : this.height - theHeight ) + oPix;
}

function setColour( a )
{
	//change all the different colour styles
	var theDiv = getRefToDivNest( this.id ); if( theDiv.style ) { theDiv = theDiv.style; }
	theDiv.bgColor = a; theDiv.backgroundColor = a; theDiv.background = a;
}

function start_progress_indicator()
{
	window.scrollTo(0,0);
	document.getElementById("progress_container").style.display="inline";
	progress_bar.setBar(0);
}
';
}
else
{
	$script='
// xp_progressbar
// Copyright 2004 Brian Gosselin of ScriptAsylum.com
//
// v1.0 - Initial release
// v1.1 - Added ability to pause the scrolling action (requires you to assign
//        the bar to a unique arbitrary variable).
//      - Added ability to specify an action to perform after a x amount of
//      - bar scrolls. This requires two added arguments.
// v1.2 - Added ability to hide/show each bar (requires you to assign the bar
//        to a unique arbitrary variable).
// var xyz = createBar(
// scroll_speed,
// block_count,
// scroll_count,
// action_to_perform_after_scrolled_n_times
// )

var w3c=(document.getElementById)?true:false;
var ie=(document.all)?true:false;
var N=-1;
var progress_bar;

/*
progress_bar=createBar(85,7,3,"");
function createBar(w,h,bgc,brdW,brdC,blkC,speed,blocks,count,action)
*/
function createBar(speed,blocks,count,action)
{
	if(ie||w3c)
	{
		//Get w, h from sytlesheet!!!!
		//Set reference to CSS sytles in  e x t e r n a l  CSS-file!!!!
		//in oder to set some items to style used.

		var progressStyle,fakebar,w,h;
		fakebar=document.getElementById("fakebar");
		with (document)
		{
			if (body.currentStyle)
			{
				//IE
				progressStyle=fakebar.currentStyle;
			}
			else if (window.getComputedStyle)
			{
				progressStyle=window.getComputedStyle(fakebar, null);
			}
		}
		with (progressStyle)
		{
			w=parseInt(minWidth);
			h=parseInt(minHeight);
		}
		var t=\'<div class="progressbar_frame" align="center" id="_xpbar\'+(++N)+\'">\';
		t+=\'<span id="blocks\'+N+\'" style="left:-\'+(h*2+1)+\'px; position:absolute; font-size:1px">\';
		for(i=0;i<blocks;i++)
		{
			t+=\'<span class="progressbar_blocks" style="left:-\'+((h*i)+i)+\'px; width:\'+h+\'px; height:\'+h+\'px; \'
			t+=(ie)?\'filter:alpha(opacity=\'+(100-i*(100/blocks))+\')\':\'-Moz-opacity:\'+((100-i*(100/blocks))/100);
			t+=\'"></span>\';
		}
		t+=\'</span></div>\';
		document.write(t);
		var bA=(ie)?document.all[\'blocks\'+N]:document.getElementById(\'blocks\'+N);
		bA.bar=(ie)?document.all[\'_xpbar\'+N]:document.getElementById(\'_xpbar\'+N);
		bA.blocks=blocks;
		bA.N=N;
		bA.w=w;
		bA.h=h;
		bA.speed=speed;
		bA.ctr=0;
		bA.count=count;
		bA.action=action;
		bA.togglePause=togglePause;
		bA.showBar=function(){
			this.bar.style.visibility="visible";
		}
		bA.hideBar=function(){
			this.bar.style.visibility="hidden";
		}
		//bA.tid=setInterval(\'startBar(\'+N+\')\',speed);
		bA.tid=0;
		return bA;
	}
}

function startBar(bn)
{
	var t=(ie)?document.all[\'blocks\'+bn]:document.getElementById(\'blocks\'+bn);
	if(parseInt(t.style.left)+t.h+1-(t.blocks*t.h+t.blocks)>t.w)
	{
		t.style.left=-(t.h*2+1)+\'px\';
		t.ctr++;
		if(t.ctr>=t.count)
		{
			eval(t.action);
			t.ctr=0;
		}
	}
	else
	{
		t.style.left=(parseInt(t.style.left)+t.h+1)+\'px\';
	}
}

function togglePause()
{
	if(this.tid==0)
	{
		this.tid=setInterval(\'startBar(\'+this.N+\')\',this.speed);
	}
	else
	{
		clearInterval(this.tid);
		this.tid=0;
	}
}

function start_progress_indicator()
{
	window.scrollTo(0,0);
	document.getElementById("progress_container").style.display="inline";
	progress_bar.togglePause();
}
';
}
echo $script;
?>
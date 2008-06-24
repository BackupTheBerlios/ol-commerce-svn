<?php
////////////////////////////////////////////////////////////////
// Javascript made by Rasmus Petersen - http://www.peters1.dk //
////////////////////////////////////////////////////////////////
$body.='
<script type="text/javascript">
var SNOW_Picture="'.SERVER.DIR_WS_CATALOG.'images/autumn.gif"
var SNOW_no = 15;

var SNOW_browser_IE_NS=false;
var SNOW_browser_MOZ=false;

var SNOW_Flake=null;
var SNOW_Time;
var SNOW_dx, SNOW_xp, SNOW_yp;
var SNOW_am, SNOW_stx, SNOW_sty;
var i, SNOW_Browser_Width, SNOW_Browser_Height;

SNOW_dx = new Array();
SNOW_xp = new Array();
SNOW_yp = new Array();
SNOW_am = new Array();
SNOW_stx = new Array();
SNOW_sty = new Array();

function SNOW_init()
{
	//var tx=document.getElementsById("XX");		//Wrong statement to force debugger activation!!!!
	SNOW_browser_IE_NS = (document.body.clientHeight) ? 1 : 0;
	SNOW_browser_MOZ = (self.innerWidth) ? 1 : 0;
	if (SNOW_browser_IE_NS)
	{
		SNOW_Browser_Width = document.body.clientWidth;
		SNOW_Browser_Height = document.body.clientHeight;
	}
	else if (SNOW_browser_MOZ)
	{
		SNOW_Browser_Width = self.innerWidth - 20;
		SNOW_Browser_Height = self.innerHeight;
	}
	for (i = 0; i < SNOW_no; ++ i)
	{
		SNOW_dx[i] = 0;
		SNOW_xp[i] = Math.random()*(SNOW_Browser_Width-50);
		SNOW_yp[i] = Math.random()*SNOW_Browser_Height;
		SNOW_am[i] = Math.random()*20;
		SNOW_stx[i] = 0.02 + Math.random()/10;
		SNOW_sty[i] = 0.7 + Math.random();
		document.write("<\div id=\"SNOW_flake"+ i +"\" style=\"position: absolute; z-index: "+ i +"; visibility: visible; top: 15px; left: 15px;\"><\img src=\""+SNOW_Picture+"\" border=\"0\"><\/div>");
	}
	SNOW_Weather();
}

function SNOW_Weather()
{

	for (i = 0; i < SNOW_no; ++ i)
	{
		SNOW_yp[i] += SNOW_sty[i];

		if (SNOW_yp[i] > SNOW_Browser_Height-50)
		{
			SNOW_xp[i] = Math.random()*(SNOW_Browser_Width-SNOW_am[i]-30);
			SNOW_yp[i] = 0;
			SNOW_stx[i] = 0.02 + Math.random()/10;
			SNOW_sty[i] = 0.7 + Math.random();
		}

		SNOW_dx[i] += SNOW_stx[i];
		SNOW_Flake=document.getElementById("SNOW_flake"+i).style;
		SNOW_Flake.top=SNOW_yp[i]+"px";
		SNOW_Flake.left=SNOW_xp[i] + SNOW_am[i]*Math.sin(SNOW_dx[i])+"px";
	}

	SNOW_Time = setTimeout("SNOW_Weather()", 10);

}
</script>
';
?>
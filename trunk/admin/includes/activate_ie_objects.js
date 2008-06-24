// iefix.js
function activate_ie_objects()
{
	objects = document.getElementsByTagName("object");
	for (var i = 0; i < objects.length; i++)
	{
    objects[i].outerHTML = objects[i].outerHTML;
	}
}
// iefix.js

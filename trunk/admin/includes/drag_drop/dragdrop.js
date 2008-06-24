/**********************************************************
Adapted from the sortable lists example by Tim Taylor
http://tool-man.org/examples/sorting.html
Modified by Tom Westcott : http://www.cyberdummy.co.uk

Modified by Dipl.-Ing(TH) Winfried Kaiser for OlCommerce (w.kaiser@fortune.de)
**********************************************************/

var i,td_elements,elements,element;
var scrollY,winH=document.body.clientHeight;

var DragDrop =
{
	firstContainer : null,
	lastContainer : null,
	parent_id : null,
	parent_group : null,
	position_absolute : 'absolute',
	position_static : 'static',
	makeContainer : function(item_tag, id_part, container, group)
	{
		// each container becomes a linked list node
		if (this.firstContainer == null)
		{
			this.firstContainer = this.lastContainer = container;
			container.previousContainer = null;
			container.nextContainer = null;
		}
		else
		{
			container.previousContainer = this.lastContainer;
			container.nextContainer = null;
			this.lastContainer.nextContainer = container;
			this.lastContainer = container;
		}
		// these functions are called when an item is draged over
		// a container or out of a container bounds.  onDragOut
		// is also called when the drag ends with an item having
		// been added to the container
		container.onDragOver = new Function();
		container.onDragOut = new Function();
		container.onDragDrop = new Function();
		container.group = group;
		container.absTop =DragDrop.findPosTop(container);;
		container.absLeft =DragDrop.findPosLeft(container);;

		var make_draggable=true,item,item_id,items=container.getElementsByTagName(item_tag);

		for (var i = 0; i < items.length; i++)
		{
			item=items[i];
			item_id=item.id;
			if (id_part)
			{
				//Only check boxes which matching id (parts)!
				make_draggable=item_id.indexOf(id_part) != -1;
			}
			if (make_draggable)
			{
				DragDrop.makeItemDragable(item);
				item.width=item.offsetWidth;
			}
		}
	},

	serData : function (item_tag,id_part,group,theid,user_eval_function)
	{
		var box_number=0,is_draggable=true,current_box=null,boxes=null;
		var container = DragDrop.firstContainer;
		var check_container_id=theid != null;
		var check_group_id=group != null;
		var user_eval=user_eval_function.length>0;
		var not_user_eval=!user_eval;
		if (user_eval)
		{
			user_eval_function=user_eval_function+"(id,box_number)";
		}
		else
		{
			var comma=",",strich="|",string = "",id="";
		}

		while (container != null)
		{
			if (check_container_id)
			{
				if (container.id != theid)
				{
					container = container.nextContainer;
					continue;
				}
			}
			if (check_group_id)
			{
				if (container.group != group)
				{
					container = container.nextContainer;
					continue;
				}
			}
			if (not_user_eval)
			{
				if (string)
				{
					string += "|";
				}
			}

			box_number=0;
			boxes=container.getElementsByTagName(item_tag);

			for (var i = 0; i < boxes.length; i++)
			{
				current_box=boxes[i];
				id=current_box.id;
				if (id_part)
				{
					//Only check boxes which matching id (parts)!
					is_draggable=id.indexOf(id_part) != -1;
					if (is_draggable)
					{
						is_draggable=id.substr(id.length-2,1) != '_';
					}
				}
				if (is_draggable)
				{
					if (user_eval)
					{
						box_number++;
						eval(user_eval_function);
					}
					else
					{
						string += id+comma;
						string += theid+",";
					}
				}
			}
			container = container.nextContainer;
		}
		return string;
	},

	//Find left and top positions of an element
	findPosLeft : function (obj)
	{
		var curleft=0;
		if (obj.offsetParent)
		{
			while (obj.offsetParent)
			{
				curleft += obj.offsetLeft
				obj=obj.offsetParent;
			}
		}
		else if (obj.x)
		{
			curleft += obj.x;
		}
		return curleft;
	},

	findPosTop : function (obj)
	{
		var curtop=0;
		if (obj.offsetParent)
		{
			while (obj.offsetParent)
			{
				curtop += obj.offsetTop
				obj=obj.offsetParent;
			}
		}
		else if (obj.y)
		{
			curtop += obj.y;
		}
		return curtop;
	},

	makeItemDragable : function(item)
	{
		// tracks if the item is currently outside all containers
		item.isOutside = false;
		with (item)
		{
			td_elements=getElementsByTagName('td');
			elements=td_elements.length;
			for (i=0;i<elements;i++)
			{
				element=td_elements[i];
				if (element.className.indexOf('nav')==0)
				{
					with (element)
					{
						item.orig_background=style.background;
					}
				}
			}
		}
		Drag.makeDraggable(item);
		item.setDragThreshold(5);
		item.onDragStart = DragDrop.onDragStart;
		item.onDrag = DragDrop.onDrag;
		item.onDragEnd = DragDrop.onDragEnd;

		item.onDragEnter = DragDrop.onDragEnter;
		item.onDragLeave = DragDrop.onDragLeave;
	},

	onDragEnter : function() {
var tx=document.getElementsById("XX");		//Wrong statement to force debugger activation!!!!
	},

	onDragLeave : function() {
var tx=document.getElementsById("XX");		//Wrong statement to force debugger activation!!!!
	},

	onDragStart : function(nwPosition, sePosition, nwOffset, seOffset) {
		// update all container bounds, since they may have changed
		// on a previous drag
		//
		// could be more smart about when to do this
		//W. Kaiser
		//var tx=document.getElementsById("XX");		//Wrong statement to force debugger activation!!!!
		var container = DragDrop.firstContainer;
		var drag_source=null;

		//W. Kaiser
		while (container != null)
		{
			container.northwest = Coordinates.northwestOffset( container, true );
			container.southeast = Coordinates.southeastOffset( container, true );
			container = container.nextContainer;
		}

		// item starts out over current parent
		//W. Kaiser
		//Dragging might begin in an item contained(!) more then one node deeper in the drag-container

		drag_source=this;
		while (drag_source.className!='DragBox')
		{
			drag_source=drag_source.parentNode;
		}
		drag_source.absTop=DragDrop.findPosTop(drag_source);
		drag_source.absLeft=DragDrop.findPosLeft(drag_source);
		drag_source.old_nextSibling=drag_source.nextSibling.nextSibling;
		with (drag_source.style)
		{
			top=DragDrop.findPosTop(drag_source);
			left=DragDrop.findPosLeft(drag_source);
			position='absolute';
		}
		DragDrop.set_background_color(drag_source,drag_source_backcolor,true);
		drag_source.parent_id = drag_source.parentNode.id;
		drag_source.parent_group = drag_source.parentNode.group;
		drag_source.last_swap_item=null;

		//W. Kaiser
		//drag_source.parentNode.onDragOver();
	},


	onDrag : function(mouse,nwPosition, sePosition, nwOffset, seOffset)
	{
		// check each container to see if in its bounds
		var container = DragDrop.firstContainer;
		var in_container=false;
		var last_swap_item=this.last_swap_item;
		//Check for auto scrolling!
		var mouse_y=mouse.y;
		//var tx=document.getElementsById("XX");		//Wrong statement to force debugger activation!!!!
		var scroll_height,t_height=this.offsetHeight;

		if (mouse_y<=t_height)
		{
			scroll_height=-t_height;
		}
		else if ((mouse_y+t_height)>winH)
		{
			scroll_height=t_height;
		}
		else
		{
			scroll_height=0;
		}
		if (scroll_height!=0)
		{
			window.scrollBy(0,t_height);
			//Drag.set_scroll_values();
			Drag.scrollY+=t_height;
			Coordinates.RePosition(mouse,this);
		}
		var container_group=0,new_container=false;
		while (container != null)
		{
			if (
			nwOffset.inside( container.northwest, container.southeast)  ||
			seOffset.inside( container.northwest, container.southeast )
			)
			{//
				in_container=true;
				container_group=container.group;
				new_container=this.parent_group!=container_group;
				//var tx=document.getElementsById("XX");		//Wrong statement to force debugger activation!!!!
				break
			}
			container = container.nextContainer;
		}
		if (this.isOutside)
		{
			if (in_container)
			{
				// we're inside a container
				//var tx=document.getElementsById("XX");		//Wrong statement to force debugger activation!!!!
					container.onDragOver();
					this.isOutside = false;
					// since isOutside was true, the current parent is a
					// temporary clone of some previous container node and
					// it needs to be removed from the document
					var tempParent = this.parentNode;
					tempParent.removeChild( this );
					container.appendChild( this );
					tempParent.parentNode.removeChild( tempParent );
			}
			else
			{
				this.last_swap_item=null;
				return;
			}
		}
		else
		{
			if (in_container)
			{
				// we're inside a container
				if (new_container)
				{
					container.onDragOver();
					this.parentNode.removeChild( this );
					container.appendChild( this );
					DragDrop.switch_layout(this,container);
					this.parent_group=container_group;
				}
			}
			else
			{
				// we're not in a container
				this.isOutside = true;
				if (last_swap_item)
				{
					DragDrop.set_background_color(this.last_swap_item,this.last_swap_item.orig_background,false);
				}
				if (this.old_nextSibling)
				{
					DragDrop.set_background_color(this.old_nextSibling,drop_target_backcolor,false);
				}
				var tempParent = this.parentNode.cloneNode(false);
				this.parentNode.removeChild(this);
				tempParent.appendChild(this);
				// body puts a border or item at bottom of page if do not have this
				tempParent.style.border = 0;
				document.body.appendChild(tempParent);
				return;
			}
		}
		// if we get here, we're inside some container bounds, so we do
		// everything the original dragsort script did to swap us into the
		// correct position
		var swap_item=false;
		var parent = this.parentNode;
		var item = this;
		var offsetTop=Math.max(this.offsetTop-container.absTop,0);
		var check_item = null;
		if (new_container)
		{
			offsetTop+=t_height;
		}
		/*
		else
		{
			offsetTop-=t_height;
		}
		*/
		check_item = DragUtils.nextItem(item);
		while (check_item)
		{
			if (offsetTop >= check_item.offsetTop)
			{
				item = check_item;
				check_item = DragUtils.nextItem(item);
			}
			else
			{
				break;
			}
		}
		if (this == item)
		{
			item = this;
			if (new_container)
			{
				check_item = DragUtils.previousItem(item);
			}
			else
			{
				check_item = DragUtils.lastItem(container,item);
			}
			while (check_item != null && offsetTop <= check_item.offsetTop)
			{
				item = check_item;
				check_item = DragUtils.previousItem(item);
			}
			swap_item=this != item;
		}
		else
		{
			swap_item=true;
		}
		if (swap_item)
		{
			if (last_swap_item!=check_item)
			{
				if (last_swap_item)
				{
if (last_swap_item.id.indexOf('SHOW_LANGUAGE')!=-1) var tx=document.getElementsById("XX");		//Wrong statement to force debugger activation!!!!
					DragDrop.set_background_color(this.last_swap_item,this.last_swap_item.orig_background,false);
				}
				this.last_swap_item=item;
				if (item)
				{
					DragDrop.set_background_color(item,drop_target_backcolor,false);
				}
			}
		}
	},

	set_background_color : function(item,color,full_item)
	{
		if (true || color)
		{
			if (full_item)
			{
				item.style.background=color;
			}
			else
			{

				with (item)
				{
					td_elements=item.getElementsByTagName('td');
					elements=td_elements.length;
					for (i=0;i<elements;i++)
					{
						element=td_elements[i];
						if (element.className.indexOf('nav')==0)
						{
							with (element)
							{
								style.background=color;
							}
						}
					}
				}
			}
		}
	},

	switch_layout : function(item,container)
	{
		var old_group=item.parent_group;
		if (old_group!=container.group)
		{
			//switch to other layout

			var new_group,group_name;
			if (old_group=='l')
			{
				new_group='r';
			}
			else
			{
				new_group='l';
			}
			group_name=item.id+'_';
			$(group_name+old_group).style.display='none';
			$(group_name+new_group).style.display='block';
			item.parent_group=container.group;
		}
	},

	onDragEnd : function(nwPosition, sePosition, nwOffset, seOffset)
	{
		// if the drag ends and we're still outside all containers
		// it's time to remove ourselves from the document or add
		// to the trash bin
		//var tx=document.getElementsById("XX");		//Wrong statement to force debugger activation!!!!
		DragDrop.set_background_color(this,this.orig_background,true);

		this.style.position = '';
		if (this.isOutside)
		{
			this.isOutside = false;
			var container = DragDrop.firstContainer;
			while (container != null)
			{
				if (container.id == this.parent_id)
				{
					break;
				}
				container = container.nextContainer;
			}
			this.parentNode.removeChild( this );
			container.insertBefore(this,this.old_nextSibling);
			DragDrop.switch_layout(this,container);
		}
		else if (this.last_swap_item)
		{
			DragUtils.swap(this,this.last_swap_item);
			DragDrop.set_background_color(this.last_swap_item,this.last_swap_item.orig_background,false);
			this.parentNode.onDragOut();
			this.parentNode.onDragDrop();
		}
	}
}	;

var DragUtils =
{
	swap : function(item1, item2)
	{
		var parent = item1.parentNode;
		parent.removeChild(item1);
		parent.insertBefore(item1, item2);
	},

	nextItem : function(item)
	{
		var item_nodename=item.nodeName;
		var sibling = item.nextSibling;
		while (sibling != null)
		{
			if (sibling.nodeName == item_nodename)
			{
				return sibling;
			}
			else
			{
				sibling = sibling.nextSibling;
			}
		}
		return null;
	},

	previousItem : function(item)
	{
		var item_nodename=item.nodeName;
		var sibling = item.previousSibling;
		while (sibling != null)
		{
			if (sibling.nodeName == item_nodename)
			{
				return sibling;
			}
			else
			{
				sibling = sibling.previousSibling;
			}
		}
		return null;
	},

	firstItem : function(container,item)
	{
		var item_nodename=item.nodeName;
		var children=container.getElementsByTagName(item_nodename);
		if (children)
		{
			return children[0];
		}
		else
		{
			return null;
		}
	},

	lastItem : function(container,item)
	{
		var item_nodename=item.nodeName;
		var children=container.getElementsByTagName(item_nodename);
		if (children)
		{
			return children[children.length-1];
		}
		else
		{
			return null;
		}
	}
};

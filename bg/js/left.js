var iTarget=0;
var g_timer=[];

window.onload=function ()
{
	var oNav=document.getElementById('nav');
	var aH2=oNav.getElementsByTagName('h2');
	var aUl=oNav.getElementsByTagName('ul');
	var i=0;
	
	for(i=0;i<aH2.length;i++)
	{
		aUl[i].index=i;
		
		aH2[i].onclick=function ()
		{
			var oUl=this.parentNode.getElementsByTagName('ul')[0];
			var aLis=oUl.getElementsByTagName('li');
			
			if(this.className == 'active')
			{
				hideMenu(oUl);
				this.className='';
			}
			else
			{
				showMenu(oUl);
				this.className='active';
			}
		};
	}
}

function hideMenu(oUl)
{
	if(g_timer[oUl.index])
	{
		clearInterval(g_timer[oUl.index]);
	}
	g_timer[oUl.index]=setInterval("collesUl("+oUl.index+")", 30);
}

function showMenu(oUl)
{
	var aLis=oUl.getElementsByTagName('li');
	
	oUl.style.display='block';
	
	iTarget=aLis[0].offsetHeight*aLis.length;
	
	if(g_timer[oUl.index])
	{
		clearInterval(g_timer[oUl.index]);
	}
	g_timer[oUl.index] = setInterval("scaleUl("+oUl.index+")", 30);
}

function collesUl(index)
{
	var oNav=document.getElementById('nav');
	var aUl=oNav.getElementsByTagName('ul');
	var speed=Math.ceil((aUl[index].offsetHeight-0)/5);
	var h=aUl[index].offsetHeight-speed;
	
	if(h<=0)
	{
		aUl[index].style.height=0+'px';
		aUl[index].style.display='none';
		
		clearInterval(g_timer[index]);
		g_timer[index]=null;
	}
	else
	{
		aUl[index].style.height=h+'px';
	}
}

function scaleUl(index)
{
	var oNav=document.getElementById('nav');
	var aUl=oNav.getElementsByTagName('ul');
	var speed=Math.ceil((iTarget-aUl[index].offsetHeight)/5);
	var h=aUl[index].offsetHeight+speed;
	
	if(h >= iTarget)
	{
		aUl[index].style.height=iTarget+'px';
		
		clearInterval(g_timer[index]);
		g_timer[index]=null;
	}
	else
	{
		aUl[index].style.height=h+'px';
	}
}

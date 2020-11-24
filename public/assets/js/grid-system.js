var base_url = "http://localhost/mymvc/";

var toggle_buttons = document.getElementsByClassName("toggle-button");
for(var i=0; i < toggle_buttons.length; i++){
	toggle_buttons[i].addEventListener("click",collapseToggle);
}

// aside navbar togglers
function collapseToggle(){
	target = document.getElementById(this.getAttribute("target"));
	if(target.classList.contains('no-collapsed')){
		target.classList.add("collapsed");
		target.classList.remove("no-collapsed");
		this.getElementsByTagName("img")[0].src=base_url+"public/assets/img/open-menu.png";
	}else{
		target.classList.add("no-collapsed");
		target.classList.remove("collapsed");
		this.getElementsByTagName("img")[0].src=base_url+"public/assets/img/close-menu.png";
	}
}

// dynamically set header position
function dynamically_set(){
	window.onresize = function(){headerNavbar()}
	window.onscroll = function(){scale_headerNavbar()}
	window.onload = function(){headerNavbar()}
	var header = document.getElementById("top-header");
	var below_element = document.getElementsByClassName("sticky-top-m")[0];
	function headerNavbar(){
		var h = header.offsetHeight;
		below_element.style.marginTop = ""+h+"px";
	}

	function scale_headerNavbar(){
		if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
		    document.getElementById("header-school-other-info").style.cssText = "opacity:0";
		    document.getElementById("school-badge").style.cssText = "width:50px;";
		    document.getElementById("header-user-info").style.border = "none";
		    document.getElementById("header-user-info").style.padding = "0";
		    document.getElementById("header-user-info").style.marginBottom = "0";
		} else {
		    document.getElementById("header-school-other-info").style.cssText = "opacity:1";
		    document.getElementById("school-badge").style.cssText = "width:80px;";
		    document.getElementById("header-user-info").style.border = "2px solid orange";
		    
		}
	}
}

var ul_ids = [];

function setUl(ul_name){
	var ul = document.getElementById(ul_name);
	ul_ids.push(ul);
	var nav_list = ul.getElementsByClassName("aside-li");
	for (var j=0; j<nav_list.length; j++){
		nav_list[j].addEventListener("click",change_nav_links);
	}
	change_nav_links();
}

function change_nav_links(){
	var page_url = window.location.href;
	for(var i=0; i< ul_ids.length; i++){
		var all_active = ul_ids[i].getElementsByClassName("active");
		for (var j=0; j<all_active.length; j++){
			all_active[j].classList.remove("active");
		}
	}
	for(var i=0; i < ul_ids.length ; i++){
		var nav_links = ul_ids[i].getElementsByClassName("nav-link");
		for(var j=0; j<nav_links.length; j++){
			if(page_url.indexOf(nav_links[j].getAttribute("href")) ==0){
				nav_links[j].classList.add("active");
				if(nav_links[j].hasAttribute('parent-li')){
					var parent_li_id = nav_links[j].getAttribute('parent-li');
					var parent_li = document.getElementById(parent_li_id);
					parent_li.getElementsByTagName("a")[0].classList.add("active");
					var toggle_target = parent_li.getElementsByClassName('toggle-button')[0].getAttribute("target");
					document.getElementById(toggle_target).classList.add("collapsed");
					parent_li.getElementsByTagName("img")[0].src="../img/open-menu.png";
					document.getElementById(toggle_target).classList.remove("no-collapsed");
				}
			}
		}
	}
}

//add element
function addElement(parentId, elementTag, elementId="",elementClass="", html) {
    // Adds an element to the document
    var p = document.getElementById(parentId);
    var newElement = document.createElement(elementTag);
    newElement.setAttribute('id', elementId);
    newElement.setAttribute('class', elementClass);
    newElement.innerHTML = html;
    p.appendChild(newElement);
}

//remove element
function removeElement(elementId) {
    // Removes an element from the document
    var element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
}
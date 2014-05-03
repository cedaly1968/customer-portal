/*
	StyleSwitcher script from  A List Apart
	Authored by Paul Sowden and Peter-Paul Koch
	http://www.alistapart.com/articles/alternate/
*/

function easyActiveStyleSheet(e){var t,n,r;for(t=0;n=document.getElementsByTagName("link")[t];t++){if(n.getAttribute("rel").indexOf("style")!=-1&&n.getAttribute("title")){n.disabled=true;if(n.getAttribute("title")==e)n.disabled=false}}}function getActiveStyleSheet(){var e,t;for(e=0;t=document.getElementsByTagName("link")[e];e++){if(t.getAttribute("rel").indexOf("style")!=-1&&t.getAttribute("title")&&!t.disabled)return t.getAttribute("title")}return null}function getPreferredStyleSheet(){var e,t;for(e=0;t=document.getElementsByTagName("link")[e];e++){if(t.getAttribute("rel").indexOf("style")!=-1&&t.getAttribute("rel").indexOf("alt")==-1&&t.getAttribute("title"))return t.getAttribute("title")}return null}
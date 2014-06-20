// JavaScript Document

//estas funcione de javascript las utilizo para bloquear las teclas del navegador y asingarles funciones propias
document.onkeydown = function(e)
{
if(e)
document.onkeypress = function(){return true;}

var evt = e?e:event;
if(evt.keyCode==114) //tecla presionanda
{
if(e)
document.onkeypress = function(){
//funcions asignada
window.parent.principal.window.location ='../forms/busqueda.php?form=3';
return false;
}
else
{
evt.keyCode = 0;
evt.returnValue = false;
}
}
if(evt.keyCode==112)
{
if(e)
document.onkeypress = function(){
return false;
}
else
{
evt.keyCode = 0;
evt.returnValue = false;
}
}
if(evt.keyCode==115)
{
if(e)
document.onkeypress = function(){
window.parent.principal.window.location ='../forms/cod.php';
return false;
}
else
{
evt.keyCode = 0;
evt.returnValue = false;
}
}
if(evt.keyCode==116)
{
if(e)
document.onkeypress = function(){
window.parent.principal.window.location ='../forms/cod.php';
return false;
}
else
{
evt.keyCode = 0;
evt.returnValue = false;
}
}
if(evt.keyCode==18)
{
if(e)
document.onkeypress = function(){
window.open('../forms/elimina.php','elimina', 'width=10 height=10');
return false;
}
else
{
evt.keyCode = 0;
evt.returnValue = false;
}
}
} 
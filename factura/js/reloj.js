// JavaScript Document
dg0 = new Image();dg0.src = "imagenes/dg0.gif";
dg1 = new Image();dg1.src = "imagenes/dg1.gif";
dg2 = new Image();dg2.src = "imagenes/dg2.gif";
dg3 = new Image();dg3.src = "imagenes/dg3.gif";
dg4 = new Image();dg4.src = "imagenes/dg4.gif";
dg5 = new Image();dg5.src = "imagenes/dg5.gif";
dg6 = new Image();dg6.src = "imagenes/dg6.gif";
dg7 = new Image();dg7.src = "imagenes/dg7.gif";
dg8 = new Image();dg8.src = "imagenes/dg8.gif";
dg9 = new Image();dg9.src = "imagenes/dg9.gif";
dgam= new Image();dgam.src= "imagenes/dgam.gif";
dgpm= new Image();dgpm.src= "imagenes/dgpm.gif";
dgc = new Image();dgc.src = "imagenes/dgc.gif";

function dotime(){ 
theTime=setTimeout('dotime()',1000);
d = new Date();
hr= d.getHours()+100;
mn= d.getMinutes()+100;
se= d.getSeconds()+100;
if(hr==100){hr=112;am_pm='am';}
else if(hr<112){am_pm='am';}
else if(hr==112){am_pm='pm';}
else if(hr>112){am_pm='pm';hr=(hr-12);}
tot=''+hr+mn+se;
document.hr1.src = 'imagenes/dg'+tot.substring(1,2)+'.gif';
document.hr2.src = 'imagenes/dg'+tot.substring(2,3)+'.gif';
document.mn1.src = 'imagenes/dg'+tot.substring(4,5)+'.gif';
document.mn2.src = 'imagenes/dg'+tot.substring(5,6)+'.gif';
document.se1.src = 'imagenes/dg'+tot.substring(7,8)+'.gif';
document.se2.src = 'imagenes/dg'+tot.substring(8,9)+'.gif';
document.ampm.src= 'imagenes/dg'+am_pm+'.gif';
}

dotime();




function randomFromTo(from, to){
	return Math.floor(Math.random() * (to - from + 1) + from);
}
var x;
x = randomFromTo(1,3);
if(x==1){document.write("Keep us strong");}
if(x==2){document.write("Support us");}
if(x==3){document.write("Donate");}

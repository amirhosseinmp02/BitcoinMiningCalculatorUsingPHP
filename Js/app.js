function hash(){
var b0=document.getElementById("hashselect");
var b1=b0.options[b0.selectedIndex].value;
var b2=b0.options[b0.selectedIndex].id;
document.getElementById("hashtext").value=b1;
document.getElementById("wselect").value=b2;
}
function elec(){
var a0=document.getElementById("elecselect");
var a1=a0.options[a0.selectedIndex].value;
document.getElementById("electext").value=a1;
	}
	function FF1(){
		// if (document.getElementsByTagName("th").innerHTML=="تومان") {
		// 	document.getElementsByTagName.innerHTML = "0";
		// }
		// document.body.innerHTML = document.body.innerHTML.replace('ریال','0');
		alert("asdasd");
	}


$(document).ready(function () {

    ConvertNumbersToPersian();
});

function ConvertNumbersToPersian() {
    persian = { 0: '۰', 1: '۱', 2: '۲', 3: '۳', 4: '۴', 5: '۵', 6: '۶', 7: '۷', 8: '۸', 9: '۹' };
    function traverse(el) {
        if (el.nodeType == 3) {
            var list = el.data.match(/[0-9]/g);
            if (list != null && list.length != 0) {
                for (var i = 0; i < list.length; i++)
                    el.data = el.data.replace(list[i], persian[list[i]]);
            }
        }
        for (var i = 0; i < el.childNodes.length; i++) {
            traverse(el.childNodes[i]);
        }
    }
    traverse(document.body);
}
window.onload = function(){
	document.getElementById("checkCmt").onclick = function(){
		if (this.checked) {
			document.getElementById("uComment").style.display = "block";
		}else{
			document.getElementById("uComment").style.display = "";
		}
	}
}
window.onload = function(){
    document.getElementById("Skype").onclick = function(){
        if (this.checked) {
            document.getElementById("skype_id").style.display = "block";
        }else{
            document.getElementById("skype_id").style.display = "";
        }
    }
    document.getElementById("Line").onclick = function(){
        if (this.checked) {
            document.getElementById("line_id").style.display = "block";
        }else{
            document.getElementById("line_id").style.display = "";
        }
    }
    document.getElementById("Viber").onclick = function(){
        if (this.checked) {
            document.getElementById("viber_id").style.display = "block";
        }else{
            document.getElementById("viber_id").style.display = "";
        }
    }
    document.getElementById("KaKaoTalk").onclick = function(){
        if (this.checked) {
            document.getElementById("kakao_id").style.display = "block";
        }else{
            document.getElementById("kakao_id").style.display = "";
        }
    }
    document.getElementById("Messenger").onclick = function(){
        if (this.checked) {
            document.getElementById("messenger_id").style.display = "block";
        }else{
            document.getElementById("messenger_id").style.display = "";
        }
    }
    document.getElementById("Discord").onclick = function(){
        if (this.checked) {
            document.getElementById("discord_id").style.display = "block";
        }else{
            document.getElementById("discord_id").style.display = "";
        }
    }
}
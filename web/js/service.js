window.onload = function(){
    document.getElementById("Skype").onclick = function(){
        if (this.checked) {
            document.getElementById("skype_input").style.display = "block";
            document.getElementById("skype_id").style.display = "block";
        }else{
            document.getElementById("skype_input").style.display = "none";
            document.getElementById("skype_id").style.display = "none";
        }
    }
    document.getElementById("Line").onclick = function(){
        if (this.checked) {
            document.getElementById("line_input").style.display = "block";
            document.getElementById("line_id").style.display = "block";
        }else{
            document.getElementById("line_input").style.display = "none";
            document.getElementById("line_id").style.display = "none";
            document.getElementById("line_id").value = "";
        }
    }
    document.getElementById("Viber").onclick = function(){
        if (this.checked) {
            document.getElementById("viber_input").style.display = "block";
            document.getElementById("viber_id").style.display = "block";
        }else{
            document.getElementById("viber_input").style.display = "none";
            document.getElementById("viber_id").style.display = "none";
        }
    }
    document.getElementById("KaKaoTalk").onclick = function(){
        if (this.checked) {
            document.getElementById("kakao_input").style.display = "block";
            document.getElementById("kakao_id").style.display = "block";
        }else{
            document.getElementById("kakao_input").style.display = "none";
            document.getElementById("kakao_id").style.display = "none";
        }
    }
    document.getElementById("Messenger").onclick = function(){
        if (this.checked) {
            document.getElementById("messenger_input").style.display = "block";
            document.getElementById("messenger_id").style.display = "block";
        }else{
            document.getElementById("messenger_input").style.display = "none";
            document.getElementById("messenger_id").style.display = "none";
        }
    }
    document.getElementById("Discord").onclick = function(){
        if (this.checked) {
            document.getElementById("discord_input").style.display = "block";
            document.getElementById("discord_id").style.display = "block";
        }else{
            document.getElementById("discord_input").style.display = "none";
            document.getElementById("discord_id").style.display = "none";
        }
    }
}
var button_wrapper = document.getElementById("button_container")
var login_wrapper = document.getElementById("login_wrapper")


button_wrapper.addEventListener("mousedown", function(e){
    button_wrapper.style.display = "none" 

    if(e.srcElement.textContent == "Login"){
        login_wrapper.style.display = "block"           
    }else{
        console.log("signing in")
    }
})
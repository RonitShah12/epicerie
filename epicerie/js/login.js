var button_wrapper = document.getElementById("button_container")

var login_wrapper = document.getElementById("login_wrapper")
var login_next_button = document.querySelector("#login_wrapper>#submit")
var login_cancel_button = document.querySelector("#login_wrapper>#back_button")

var signup_wrapper=document.getElementById("signup_wrapper") 
var signup_next_button=document.querySelector("#signup_wrapper>#submit")
var signup_cancel_button = document.querySelector("#signup_wrapper>#back_button")

var signup_confirm_wrapper=document.querySelector("#signup_confirm_wrapper")
var signup_submit_button = document.querySelector("#signup_confirm_wrapper>#submit")
var signup_confirm_back_button = document.querySelector("#signup_confirm_wrapper>#back_button")


button_wrapper.addEventListener("mousedown", function(e){
    button_wrapper.style.display = "none" 

    if(e.srcElement.textContent == "Login"){
        login_wrapper.style.display = "block"           
    }else{
        signup_wrapper.style.display="block"
    }
})

signup_next_button.addEventListener("click", function(){
	signup_confirm_wrapper.style.display = "block"
	signup_wrapper.style.display = "none"
})           

login_cancel_button.addEventListener("click", function(){
	button_wrapper.style.display = "block"
	login_wrapper.style.display = "none"           
})

signup_cancel_button.addEventListener("click", function(){
	button_wrapper.style.display = "block"
	signup_wrapper.style.display = "none"           
})

login_next_button.addEventListener("click", function(){
	var uname = document.querySelector("#login_wrapper>#username").value
	var pass1 = document.querySelector("#login_wrapper>#password").value	

	fetch("login.php?username="+uname+"&password="+pass1).then(function(data){
		data.text().then(function(t){
			if(t === "0"){
				alert("Invalid Username or Password")
			}else{
				login_wrapper.style.display="none"

				console.log(window.location.origin+"/epicerie/html/"+t)
			}
		})
	})
})

signup_submit_button.addEventListener("click", function(){
	var uname = document.querySelector("#signup_wrapper>#username").value
	var pass1 = document.querySelector("#signup_wrapper>#password").value	
	var pass2 = document.querySelector("#signup_confirm_wrapper>#password").value	

	if(pass1===pass2)
	{
		fetch("signup.php?username="+uname+"&password="+pass1).then(function(data){
			data.text().then(function(t){
				if(t==="inserted"){
					alert("successful")
					button_wrapper.style.display="block"
					signup_confirm_wrapper.style.display="none"
				}
				else
				{
					alert("not valid")
				}
			})
		})

	}
	else
	{
		alert("Password not matching")
	}

})

signup_confirm_back_button.addEventListener("click", function(){
	signup_confirm_wrapper.style.display = "none"           
	signup_wrapper.style.display = "block"
})

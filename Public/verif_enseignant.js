var login = document.querySelector("input[name='login']");
var submit_button = document.querySelector("input[type='submit']");

var regExpLogin = /^\w+$/;

login.setAttribute("data-valid", regExpLogin.test(login.value));

if(login.getAttribute("data-valid") == "false"){
    submit_button.disabled = true;
}

login.addEventListener("input", function(){

    var result = regExpLogin.test(login.value);

    if(result){
        login.style = "border-color:green;";
        login.setAttribute("data-valid", true);
        submit_button.disabled = false;
    }else{
        login.style = "border-color:red;";
        login.setAttribute("data-valid", false);
        submit_button.disabled = true;
    }
});
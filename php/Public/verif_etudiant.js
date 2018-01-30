var num_etud = document.querySelector("input[name='num_etud']");
var promo = document.querySelector("input[name='promo']");
var submit_button = document.querySelector("input[type='submit']");

var regExpNumEtud = /^\d{10}$/;
var regExpPromo = /^20\d{2}$/;

num_etud.setAttribute("data-valid", regExpNumEtud.test(num_etud.value));
promo.setAttribute("data-valid", regExpPromo.test(promo.value));

if(num_etud.getAttribute("data-valid") == "false" || promo.getAttribute("data-valid") == "false"){
    submit_button.disabled = true;
}

num_etud.addEventListener("input", function(){

    var result = regExpNumEtud.test(num_etud.value);

    if(result){
        num_etud.style = "border-color:green;";
        num_etud.setAttribute("data-valid", true);
        if(promo.getAttribute("data-valid")){
            submit_button.disabled = false;
        }
    }else{
        num_etud.style = "border-color:red;";
        num_etud.setAttribute("data-valid", false);
        submit_button.disabled = true;
    }
});

promo.addEventListener("input", function(){

    var result = regExpPromo.test(promo.value);

    if(result){
        promo.style = "border-color:green;";
        promo.setAttribute("data-valid", true);
        if(num_etud.getAttribute("data-valid")){
            submit_button.disabled = false;
        }
    }else{
        promo.style = "border-color:red;";
        promo.setAttribute("data-valid", false);
        submit_button.disabled = true;
    }
});
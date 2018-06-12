var index_unity = document.querySelector("input[name='index_unity']");
var difficulte = document.querySelector("input[name='difficulte']");
var temps_max = document.querySelector("input[name='temps_max']");
var tentatives_max = document.querySelector("input[name='tentatives_max']");
var submit_button = document.querySelector("input[type='submit']");

var competences = document.querySelectorAll("input[type='radio']");
var situPro = document.querySelectorAll("input[type='number']");
var situProText = document.querySelectorAll("input[type='number'] + p");
var situProValid = false;
var checkedComp;

for(var i=0; i<competences.length; i++){
    if(competences[i].checked){
        checkedComp = competences[i];
    }
}

setSituPro();

var regExpIndexU = /^\d{1,3}$/;
var regExpDiff = /^[1-2-3]$/;
var regExpTps = /^1?\d$/;

index_unity.setAttribute("data-valid", regExpIndexU.test(index_unity.value));
difficulte.setAttribute("data-valid", regExpDiff.test(difficulte.value));
tentatives_max.setAttribute("data-valid", regExpDiff.test(tentatives_max.value));
temps_max.setAttribute("data-valid", regExpTps.test(temps_max.value));

if(!dataValidTest()){
    submit_button.disabled = true;
}

index_unity.addEventListener("input", function(){

    var result = regExpIndexU.test(index_unity.value);

    if(result){
        index_unity.style = "border-color:green;";
        index_unity.setAttribute("data-valid", true);
        if(dataValidTest()){
            submit_button.disabled = false;
        }
    }else{
        index_unity.style = "border-color:red;";
        index_unity.setAttribute("data-valid", false);
        submit_button.disabled = true;
    }
});

difficulte.addEventListener("input", function(){

    var result = regExpDiff.test(difficulte.value);

    if(result){
        difficulte.style = "border-color:green;";
        difficulte.setAttribute("data-valid", true);
        if(dataValidTest()){
            submit_button.disabled = false;
        }
    }else{
        difficulte.style = "border-color:red;";
        difficulte.setAttribute("data-valid", false);
        submit_button.disabled = true;
    }
});

temps_max.addEventListener("input", function(){

    var result = regExpTps.test(temps_max.value);

    if(result){
        temps_max.style = "border-color:green;";
        temps_max.setAttribute("data-valid", true);
        if(dataValidTest()){
            submit_button.disabled = false;
        }
    }else{
        temps_max.style = "border-color:red;";
        temps_max.setAttribute("data-valid", false);
        submit_button.disabled = true;
    }
});

tentatives_max.addEventListener("input", function(){

    var result = regExpDiff.test(tentatives_max.value);

    if(result){
        tentatives_max.style = "border-color:green;";
        tentatives_max.setAttribute("data-valid", true);
        if(dataValidTest()){
            submit_button.disabled = false;
        }
    }else{
        tentatives_max.style = "border-color:red;";
        tentatives_max.setAttribute("data-valid", false);
        submit_button.disabled = true;
    }
});

competences[0].addEventListener("click", function(){
    checkedComp = this;
    setSituPro();
});

competences[1].addEventListener("click", function(){
    checkedComp = this;
    setSituPro();
});

for(var i=0; i<situPro.length; i++){
    situPro[i].addEventListener("input", function(){
        situProValid = situProTest();
        if(!dataValidTest()){
            submit_button.disabled = true;
        }else{
            submit_button.disabled = false;
        }
        //console.log("bool situPro : "+situProValid);
    });
}

function setSituPro(){
    if(checkedComp.value == 1){
        for(var j=0; j<3; j++){
            situPro[j].style = "display:inline;";
            situProText[j].style = "display:inline-block;";
        }
        for(var j=3; j<6; j++){
            situPro[j].style = "display:none;";
            situProText[j].style = "display:none;";
            if(situPro[j].value != 0){
                situPro[j].value = 0;
            }
        }
        
    }else{
        for(var j=0; j<3; j++){
            situPro[j].style = "display:none;";
            situProText[j].style = "display:none;";
            if(situPro[j].value != 0){
                situPro[j].value = 0;
            }
        }
        for(var j=3; j<6; j++){
            situPro[j].style = "display:inline;";
            situProText[j].style = "display:inline-block;";
        }
    }
}

function situProTest(){
    var somme = 0;
    
    if(checkedComp.value == 1){
        for(var j=0; j<3; j++){
            somme += Number(situPro[j].value);
        }
    }else{
        for(var j=3; j<6; j++){
            somme += Number(situPro[j].value);
        }
    }
    
    //console.log("somme value : "+somme);
    
    if(somme == 100){
        return true;
    }else{
        return false;
    }
}

function dataValidTest(){
    var data_valid = true;
    
    if(index_unity.hasAttribute("data-valid")){
        data_valid = data_valid && JSON.parse(index_unity.getAttribute("data-valid"));
    }
    
    if(difficulte.hasAttribute("data-valid")){
        data_valid = data_valid && JSON.parse(difficulte.getAttribute("data-valid"));
    }
    
    if(temps_max.hasAttribute("data-valid")){
        data_valid = data_valid && JSON.parse(temps_max.getAttribute("data-valid"));
    }
    
    if(tentatives_max.hasAttribute("data-valid")){
        data_valid = data_valid && JSON.parse(tentatives_max.getAttribute("data-valid"));
    }
    
    data_valid = data_valid && situProValid;
    
    return data_valid;
}
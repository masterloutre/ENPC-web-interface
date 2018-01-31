var mdp = document.querySelector("input[name='mdp']");
var num_phase = document.querySelector("input[name='phase']");
var submit_button = document.querySelector("input[type='submit']");

var regExpPhase = /^[1-4]$/;
var regExpMdp = /^\w{5,}$/;

num_phase.setAttribute("data-valid", regExpPhase.test(num_phase.value));
mdp.setAttribute("data-valid", regExpMdp.test(mdp.value));

if(num_phase.getAttribute("data-valid") == "false" || mdp.getAttribute("data-valid") == "false"){
    submit_button.disabled = true;
}

num_phase.addEventListener("input", function(){

    var result = regExpPhase.test(num_phase.value);

    if(result){
        num_phase.style = "border-color:green;";
        num_phase.setAttribute("data-valid", true);
        
        if(mdp.getAttribute("data-valid")){
            submit_button.disabled = false;
        }  
    }else{
        num_phase.style = "border-color:red;";
        num_phase.setAttribute("data-valid", false);
        submit_button.disabled = true;
    }
});

mdp.addEventListener("input", function(){

    var result = regExpMdp.test(mdp.value);

    if(result){
        mdp.style = "border-color:green;";
        mdp.setAttribute("data-valid", true);
        
        if(num_phase.getAttribute("data-valid")){
            submit_button.disabled = false;
        } 
    }else{
        mdp.style = "border-color:red;";
        mdp.setAttribute("data-valid", false);
        submit_button.disabled = true;
    }
});
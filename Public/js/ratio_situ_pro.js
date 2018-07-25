/*var container = document.getElementsByClassName("situation_pro_bar");
var color = ["#54bfc4", "#8c4e81", "#6c488b"];

colornb = 0;

for(var i=0; i<container.length; i++){
    var spanRatio = container[i].childNodes[1].childNodes;
    //console.log(spanRatio);
    for(var j=0; j<spanRatio.length; j++){
        if(spanRatio[j].localName == "span"){
            if(spanRatio[j].hasAttribute("data-size")){
                spanRatio[j].style = "flex-grow : "+spanRatio[j].getAttribute("data-size")+"; height : 10px; background-color : "+color[colornb]+";";
                colornb++;
            }
            
        }
    }
    
    colornb = 0;
}*/
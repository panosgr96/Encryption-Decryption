$(document).ready(function() {
    function gcd(a,b){ 
        if (b == 0){
            return [1, 0, a];
        }
        else{
        temp = gcd(b, a % b)
        x = temp[0];
        y = temp[1];
        d = temp[2];
        return [y, x-y*Math.floor(a/b), d];
       }
     }

    function calculate() {
        //Get Input Data
        var a = $("#a").val(); 
        var b = $("#b").val(); 
        
        if (a === '' || b === '' || (a % 1) || (b % 1)) {
        alert("Enter number and non decimal");
        }
        else {
            var result = gcd(Math.abs(a), Math.abs(b));
                
            $("#x").text(result[0]);
            $("#y").text(result[1]);
            $("#gcd").text(result[2]);
        }
    }

    $("#calcEucl").click(function(){
      calculate();
    });
    $("#resetEucl").click(function(){
        $("#a").val('');
        $("#b").val('');
        $("#x").text('');
        $("#y").text('');
        $("#gcd").text('');
    }); 
});
function calcStats() {
    //called by the simple character builder stat table oninput
    //arrays used to store/write the relevant data from the table and call other required functions
    let arStatBonuses = Array.prototype.map.call(document.querySelectorAll('#statBonuses td'), function(td){
            return parseInt(td.innerHTML);
        });
    let arStatInputs = Array.prototype.map.call(document.querySelectorAll('#statInput input'), function(td){
        return parseInt(td.value);
    });

    //functions used to validate the data on the table
    if(pointbuy(arStatInputs)){
        //if point buy is valid then put data in bottom row of table
        for(i=0;i<6;i++){
            document.querySelectorAll('#statOutput output')[i].innerText= 8+nyan(arStatBonuses[i])+nyan(arStatInputs[i]);
        }
    }

    return;
}

//I hate that I had to make this function so much. THERE HAS TO BE AN EXISTING FUNCTION THAT I AM TOO MUCH OF A SMOL NUGGET TO KNOW ABOUT
function nyan(cat){
    if(isNaN(cat)){
        return 0;
    } else{
        return cat;
    }
}

function pointbuy(passInputs) {
    //used to validate the point buy method and calculate the character stats input
    var pointValid = false;
    var pointTotal = 0;
    let statInputs = new Array(passInputs);
    //checks array for various conditions
    for(i=0; i < statInputs.length; i++){
        //checks if  stat inputs are 6 or 7 and increase the point cost
        if(statInputs[i] ==6 || statInputs[i] ==7 ){
            statInputs[i] += statInputs[i]-5;
        } else if(statInputs[i]<0 || statInputs[i]>=8){
            //checks if stat inputs are between 0 and 7 highlighting ones that aren't and return function as false
            document.querySelectorAll('#statInput input')[i].style.backgroundColor = '#D0342C';
            return pointValid;
        } else if(isNaN(statInputs[i])){
            //skips adding null values to the pointTotal
            continue;
        }
        pointTotal += statInputs[i];
    }
    //update the points remaining display
    document.getElementById('pointsRemaining').innerText = 27 - pointTotal;

    //check if sum of points spent is <=27
    if(pointTotal<=27){
        pointValid = true;
        //reset any changed input backgrounds from warning
        document.querySelectorAll('#statInput input').forEach(td => td.style.backgroundColor = '#C0C0C0');
    } else{
        //highlight all fields if the points used are too high
        alert('You have used more than 27 total points. Please reduce some stats.');
        document.querySelectorAll('#statInput input').forEach(td => td.style.backgroundColor = '#D0342C');
    }

    return pointValid;
}
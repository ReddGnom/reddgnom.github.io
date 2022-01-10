function calcStats() {
    //called by the simple character builder stat table oninput
    //arrays used to store/write the relevant data from the table and call other required functions
    let arStatBonuses = Array.prototype.map.call(document.querySelectorAll('#statBonuses td'), function(td){
            return parseInt(td.innerHTML);
        });
    let arStatInputs = Array.prototype.map.call(document.querySelectorAll('#statInput select'), function(td){
        return parseInt(td.value);
    });

    //functions used to validate the data on the table
    if(pointbuy(arStatInputs)){
        //if point buy is valid then put data in bottom row of table
        for(i=0;i<6;i++){
            document.querySelectorAll('#statOutput output')[i].innerText= 8+nyan(arStatBonuses[i])+arStatInputs[i];
        }
    }

    return;
}

//I hate that I had to make this function so much. 
//THERE HAS TO BE AN EXISTING FUNCTION THAT I AM TOO MUCH OF A SMOL NUGGET TO KNOW ABOUT
function nyan(cat){
    if(isNaN(cat)){
        return 0;
    } else{
        return cat;
    }
}

//function to make the point display a bit prettier
//KILL ME NOW
function UwU(foo){
    //invert the number due to me being lazy with my maths
    foo=foo*-1;
    //convert number to string and add grammatically correct point/points string :P
    if(foo==1){
        foo='+1 point)';
    }else if(foo>1){
        foo='+'+foo+' points)';
    }else if(foo==-1){
        foo=foo+' point)';
    }else{
        foo=foo+' points)';
    }
    //I absolutely loathe myself for this, however, it would earn some decent karma at r/badcode
    return foo;
}

//function to adjust points display of html on input options
function inputPointCostDisplay(selectTd){
    //set the point cost of the selected value if it is greater than 5
    var selectedCost = selectTd.value;
    if(selectTd.value>5){
        selectedCost= (2*selectTd.value)-5;
    }
    //reset select background incase it was changed
    selectTd.style.backgroundColor = '#C0C0C0';
    //loop through each option in the select
    for(i=0;i<selectTd.children.length;i++){
        //if the option is selected remove the point cost display in list
        if(selectTd.children[i].selected){
            selectTd.children[i].innerText = selectTd.children[i].value;
        } else if(selectTd.children[i].value>5) {
            selectTd.children[i].innerText = selectTd.children[i].value + ' ('+UwU((2*selectTd.children[i].value)-5-selectedCost);
        } else{
            selectTd.children[i].innerText = selectTd.children[i].value + ' ('+UwU(selectTd.children[i].value-selectedCost);
        }
    }
    return;
}

function pointbuy(statInputs) {
    //used to validate the point buy method and calculate the character stats input
    var pointValid = false;
    var pointTotal = 0;
    //checks array for various conditions
    for(i=0; i < statInputs.length; i++){
        //checks if  stat inputs are 6 or 7 and increase the point cost
        if(statInputs[i] ==6 || statInputs[i] ==7 ){
            pointTotal += statInputs[i]+statInputs[i]-5;
            continue;
        /* No longer needed as input chnged from number to select
        } else if(statInputs[i]<0 || statInputs[i]>=8){
            //checks if stat inputs are between 0 and 7 highlighting ones that aren't and return function as false
            document.querySelectorAll('#statInput select')[i].style.backgroundColor = '#D0342C';
            return pointValid;*/
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
        document.querySelectorAll('#statInput select').forEach(td => inputPointCostDisplay(td));
    } else{
        //highlight all fields if the points used are too high
        alert('You have used more than 27 total points. Please reduce some stats.');
        document.querySelectorAll('#statInput select').forEach(td => td.style.backgroundColor = '#D0342C');
    }

    return pointValid;
}
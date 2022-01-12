//global variables declared here
let races=[]; //used to store JSON races
let classes=[]; //used to store JSON classes
let playerBg=[]; //used to store JSON background and other pc customisation 

//function called to handle page initialisation. 
//I was gonna call it something more appropriate but this is what my dwindling sanity produced
function bigchungus(){
    //ready the input table for use
    calcStats();
    //add the playable races into a dropdown menu for use
    raceInit();
}

function calcStats() {
    //called by the simple character builder stat table oninput
    //arrays used to store/write the relevant data from the table and call other required functions
    let arStatBonuses = Array.prototype.map.call(document.querySelectorAll('#statBonuses td'), function(td){
            return parseInt(td.innerText);
        });
    let arStatInputs = Array.prototype.map.call(document.querySelectorAll('#statInput select'), function(td){
        return parseInt(td.value);
    });

    //add potential checklist values to array of stat bonuses. For things like half-elfs
    let choiceStat = document.querySelectorAll('#statBonuses td');
    for(i=0;i<arStatBonuses.length;i++){
        if(arStatBonuses[i]==0&&choiceStat[i].children[0].value!==0){
            arStatBonuses[i]=parseInt(choiceStat[i].children[0].value);
        }
    }

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

//called by calcStats whe a pointbuy input is changed
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

//function to acquire JSON data from plutonium github page and parse the data into something useable by this webpage and my dumb nugget brain
function raceInit(){
    //attempt to parse the json file from github
    /*      Using JSON object */
    let requestURL = 'https://raw.githubusercontent.com/TheGiddyLimit/TheGiddyLimit.github.io/master/data/races.json';
    let request = new XMLHttpRequest();
    request.open('GET', requestURL);
    request.responseType = 'json';
    request.send();
    request.onload = function(){
        races = request.response;
        for(i=0;i<races.race.length;i++){
            //skip any UA content races
            if(races.race[i].source.substring(0,2)=='UA'||races.race[i].source.substring(0,2)=='PS'){continue}
            //add races to a dropdown menu
            let opt = document.createElement('option');
            opt.value = i;
            opt.innerHTML = races.race[i].name + ' ('+races.race[i].source+')';
            document.getElementById('raceMenu').appendChild(opt);
        }
    }
}

//function called when the selected race changes. Used to determine valid subrace options and bonuses
function subraceCalc(selectedRace){
    //find selected race from JSON array using passed in value
    let playerRace = races.race[selectedRace];
    let subraceOpt = document.getElementById('subrace');

    //clear all children from subrace options and add in blank default option
    subraceOpt.innerHTML='<option value="" selected disabled hidden/>';

    //populate any valid subraces for the selected race into the dropdown list
    try{
        //try for when subraces are undefined and typeof !== will not work
        for(i=0;i<playerRace.subraces.length;i++){
            let opt = document.createElement('option');
            opt.value = i;
            opt.innerHTML = playerRace.subraces[i].name;
            subraceOpt.appendChild(opt);
        }
    } catch{}
    //add ability score improvement from selected race
    racialAbilityBonus(playerRace);
}

//function that takes subrace or race and applies the ability score improvement from them into the stat table
function racialAbilityBonus(race){
    //race is the JSON object array of the chosen race or subrace so it should be a matter of going through each entry in the ability field
    //checks if the race applies a bonus to each stat and then changes the innertext of any defined stats with bonuses
    try{
        if(race.ability[0].str>0){document.getElementById('strBonus').innerHTML='+'+race.ability[0].str}else if(race.ability[0].str<0){document.getElementById('strBonus').innerHTML=race.ability[0].str}else{document.getElementById('strBonus').innerHTML='-'};
    } catch{}
    try{
        if(race.ability[0].dex>0){document.getElementById('dexBonus').innerHTML='+'+race.ability[0].dex}else if(race.ability[0].dex<0){document.getElementById('dexBonus').innerHTML=race.ability[0].dex}else{document.getElementById('dexBonus').innerHTML='-'};
    } catch{}
    try{
        if(race.ability[0].con>0){document.getElementById('conBonus').innerHTML='+'+race.ability[0].con}else if(race.ability[0].con<0){document.getElementById('conBonus').innerHTML=race.ability[0].con}else{document.getElementById('conBonus').innerHTML='-'};
    } catch{}
    try{
    if(race.ability[0].int>0){document.getElementById('intBonus').innerHTML='+'+race.ability[0].int}else if(race.ability[0].int<0){document.getElementById('intBonus').innerHTML=race.ability[0].int}else{document.getElementById('intBonus').innerHTML='-'};
    } catch{}
    try{
        if(race.ability[0].wis>0){document.getElementById('wisBonus').innerHTML='+'+race.ability[0].wis}else if(race.ability[0].wis<0){document.getElementById('wisBonus').innerHTML=race.ability[0].wis}else{document.getElementById('wisBonus').innerHTML='-'};   
    } catch{}   
    try{
        if(race.ability[0].cha>0){document.getElementById('chaBonus').innerHTML='+'+race.ability[0].cha}else if(race.ability[0].cha<0){document.getElementById('chaBonus').innerHTML=race.ability[0].cha}else{document.getElementById('chaBonus').innerHTML='-'};
    } catch{}

    //checks if a choice element is present and adds the options stated as select menus in the stat table.
    //user validation of selected stats will be handled in calcStats()
    try{
        if(race.ability[0].choose!==undefined){
            //loop through the options available and insert a select element into the relevant table cells
            for(i=0;i<race.ability[0].choose.from.length;i++){
                //create a dropdown for the table cell
                document.getElementById(race.ability[0].choose.from[i]+'Bonus').innerHTML = '<select><option selected disabled hidden /><option>0</option><option value=1>+1</option><select>';
            }
        }
    } catch{}

    calcStats();
}
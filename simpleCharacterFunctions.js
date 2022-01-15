//global variables declared here
let races=[]; //used to store JSON races
//allow specific classes. Used to filter JSON classes and add to drop down list
let allowedClasses = ['artificer','barbarian','bard','cleric','druid','fighter','monk','paladin','ranger','rogue','sorcerer','warlock','wizard'];
let playerClass=[]; //used to store JSON classes
let playerBg=[]; //used to store JSON background and other pc customisation 
let raceStatChoice = ''; //used to determine if the chosen race allows for ability score selection

//function called to handle page initialisation. 
//I was gonna call it something more appropriate but this is what my dwindling sanity produced
function bigchungus(){
    //ready the input table for use
    calcStats();
    //add the playable races into a dropdown menu for use
    raceInit();
    //add playable subclasses into a JSON file for reference
    classInit(0);
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

    //validates that an allowed number of stat improvements has been made to the racial bonuses
    //disables any attempts to increase other stats
    if(raceStatChoice=='race'){
        //gets racial bonus options
        let raceOptBonuses = document.querySelectorAll('#statBonuses select');
        let validTotalBonus = parseInt(races.race[document.getElementById('raceMenu').value].ability[0].choose.count);
        let numSelectedBonus = 0;
        //loop through selects and enable all to reset. Increment selection counter
        for(i=0;i<raceOptBonuses.length;i++){
            raceOptBonuses[i].disabled = false;
            raceOptBonuses[i].style.backgroundColor='#C0C0C0';
            if(raceOptBonuses[i].value==1){numSelectedBonus++}
        }
        //disable the non-selected inputs if max is reached
        if(validTotalBonus==numSelectedBonus){
            for(i=0;i<raceOptBonuses.length;i++){
                if(raceOptBonuses[i].value!=1){raceOptBonuses[i].disabled=true; raceOptBonuses[i].style.backgroundColor='#6c757d'}
            }
        }
    } else if(raceStatChoice=='subrace'){
        //gets racial bonus options
        let raceOptBonuses = document.querySelectorAll('#statBonuses select');
        let validTotalBonus = parseInt(races.race[document.getElementById('raceMenu').value].subrace[document.getElementById('subrace')].ability[0].choose.count);
        let numSelectedBonus = 0;
        //loop through selects and enable all to reset. Increment selection counter
        for(i=0;i<raceOptBonuses.length;i++){
            raceOptBonuses[i].disabled = false;
            raceOptBonuses[i].style.backgroundColor='#C0C0C0';
            if(raceOptBonuses[i].value==1){numSelectedBonus++}
        }
        //disable the non-selected inputs if max is reached
        if(validTotalBonus==numSelectedBonus){
            for(i=0;i<raceOptBonuses.length;i++){
                if(raceOptBonuses[i].value!=1){raceOptBonuses[i].disabled=true; raceOptBonuses[i].style.backgroundColor='#6c757d'}
            }
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
        //enable option incase previously disabled
        selectTd.children[i].disabled = false;
        //if the option is selected remove the point cost display in list
        if(selectTd.children[i].selected){
            selectTd.children[i].innerText = selectTd.children[i].value;
        } else if(selectTd.children[i].value>5) {
            selectTd.children[i].innerText = selectTd.children[i].value + ' ('+UwU((2*selectTd.children[i].value)-5-selectedCost);
            //disable option if the point cost is too high
            if(((2*selectTd.children[i].value)-5-selectedCost)>parseInt(document.getElementById('pointsRemaining').innerText)){selectTd.children[i].disabled=true;}
        } else{
            selectTd.children[i].innerText = selectTd.children[i].value + ' ('+UwU(selectTd.children[i].value-selectedCost);
            if((selectTd.children[i].value-selectedCost)>parseInt(document.getElementById('pointsRemaining').innerText)){selectTd.children[i].disabled=true;}
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
    //reset any changed input backgrounds from warning and pretty up innerText of select
    document.querySelectorAll('#statInput select').forEach(td => inputPointCostDisplay(td));

    //check if sum of points spent is <=27
    if(pointTotal<=27){
        pointValid = true;
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
            let sauce = '';
            //catch undefined sources which are the PHB sources
            if(typeof playerRace.subraces[i].source=='undefined'){sauce=playerRace.source}else{sauce=playerRace.subraces[i].source} 
            //filter out UA content. Try Catch to prevent script failing if source is undefined and therefore PHB
            try{if(playerRace.subraces[i].source.substring(0,2)=='UA'){continue}}catch{}
            let opt = document.createElement('option');
            opt.value = i;
            opt.innerHTML = playerRace.subraces[i].name+ ' ('+ sauce +')';
            subraceOpt.appendChild(opt);
        }
    } catch{}
    //add ability score improvement from selected race
    racialAbilityBonus(selectedRace,'');
}

//function that takes subrace or race and applies the ability score improvement from them into the stat table
function racialAbilityBonus(race, subrace){
    //race is the number for JSON object array of the chosen race or subrace
    //I ran into an issue where subrace changes overwrote the racial bonus so I decided to merge the 2 arrays if subrace is applicable
    let abilityBonus =['str','dex','con','int','wis','cha'];
    raceStatChoice = '';
    if(subrace!==''){
        for(i=0;i<6;i++){
            abilityBonus[i+6]=(nyan(races.race[race].ability[0][abilityBonus[i]])+nyan(races.race[race].subraces[subrace].ability[0][abilityBonus[i]]))
        }
        try{
            if(races.race[race].subraces[subrace].ability[0].choose!==undefined){
                //loop through the options available and insert a select element into the relevant table cells
                for(i=0;i<races.race[race].subraces[subrace].ability[0].choose.from.length;i++){
                    //create a dropdown for the table cell
                    document.getElementById(races.race[race].subraces[subrace].ability[0].choose.from[i]+'Bonus').innerHTML = '<select><option selected disabled hidden /><option>0</option><option value=1>+1</option><select>';
                    //turns on check if the allowed number of stat improvements have been made 
                    raceStatChoice = 'subrace';
                }
            }
        } catch{}
    } else{
        for(i=0;i<6;i++){
            abilityBonus[i+6]= nyan(races.race[race].ability[0][abilityBonus[i]])
        }
    }
    //checks if the race applies a bonus to each stat and then changes the innertext of any defined stats with bonuse
    for(i=0;i<6;i++){
        if(abilityBonus[i+6]>0){document.getElementById(abilityBonus[i]+'Bonus').innerHTML='+'+abilityBonus[i+6]}else if(abilityBonus[i+6]<0){document.getElementById(abilityBonus[i]+'Bonus').innerHTML=abilityBonus[i+6]}else{document.getElementById(abilityBonus[i]+'Bonus').innerHTML='-'};
    } 
    /*try{
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
    } catch{} */

    //checks if a choice element is present and adds the options stated as select menus in the stat table.
    //user validation of selected stats will be handled in calcStats()
    try{
        if(races.race[race].ability[0].choose!==undefined){
            //loop through the options available and insert a select element into the relevant table cells
            for(i=0;i<races.race[race].ability[0].choose.from.length;i++){
                //create a dropdown for the table cell
                document.getElementById(races.race[race].ability[0].choose.from[i]+'Bonus').innerHTML = '<select class="form-control w-25 start-50 translate-middle-x position-relative" style="background-color: #C0C0C0; padding: 0.375rem 0.375rem; min-width: 24px;"><option selected disabled hidden /><option>0</option><option value=1>1</option><select>';
                raceStatChoice = 'race';
            }
        }
    } catch{}

    calcStats();
}

//function used to retrieve and store subclasses from github JSON file
function classInit(x){
    if(x<allowedClasses.length){classPull(x)}
}
//functions set up like this so that the classes will be stored in the array AFTER the response comes back and then attempt the next request
function classPull(x){
    //add allowed classes as options on dropdown menu
    let opt = document.createElement('option');
    opt.value = x;
    opt.innerText = allowedClasses[x];
    opt.className = 'text-capitalize';
    document.getElementById('class').appendChild(opt);

    //send request for class details from JSON file
    let requestURL = 'https://raw.githubusercontent.com/TheGiddyLimit/TheGiddyLimit.github.io/master/data/class/class-'+allowedClasses[x]+'.json';
    let request = new XMLHttpRequest();
    request.open('GET', requestURL);
    request.responseType = 'json';
    request.send();
    request.onload = function(){
        playerClass[x] = request.response;
        x++;
        classInit(x);
    }
}

//function used to retrieve allowed subclasses from JSON object
function subclassLoad(pcClass){
    //pcClass is the passed value of the class as a number to reference the playerClass JSON object
    //create an option for applicable subclasses
    let pC = playerClass[pcClass];
    let hSubclass = document.getElementById('subclass');

    //clear any previous subclasses
    hSubclass.innerHTML = '<option value="" selected disabled hidden/>';

    //add any subclass which isn't UA or PlaneShift to the list
    for(i=0;i<pC.subclass.length;i++){
        if(pC.subclass[i].source.substring(0,2)=='UA'||pC.subclass[i].classSource.substring(0,2)=='UA'||pC.subclass[i].source.substring(0,2)=='PS'){continue}
        let opt = document.createElement('option');
        opt.value = i;
        opt.innerHTML = pC.subclass[i].name;
        hSubclass.appendChild(opt);
    }

}
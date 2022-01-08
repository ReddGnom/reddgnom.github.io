function calcStats() {
    //called by the simple character builder stat table oninput
    //arrays used to store/write the relevant data from the table and call other required functions
    let statBonuses = Array.prototype.map.call(querySelectorAll('#statBonuses td'), function(td){
            return parseint(td.innerHTML);
        });
    let statInputs = [];
    let statOutputs = [];

    

    //functions used to validate the data on the table
    pointbuy(statInputs);
}

function pointbuy(statInputs) {
    //used to validate the point buy method and calculate the character stats input

}
function validate()
{	
	//rules to be used to test form inputs
	var email = /^[A-Za-z][A-Za-z0-9.]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,6}$/;
	var phone = /^[0-9+][0-9]+{6,255}$/;
	var cardNo = /^[0-9]{16}$/;
	var cardCvv = /^[0-9]{4}$/;
	var cardExpiry = /^[01][0-9]\/[0-9]{2}$/;
	var aPassword = /^(?=.*[@._%\+\-\s!\\\/\*\?])[A-Za-z0-9._%@\+\-\s!\\\/\*\?]{7,}$/;

	//switch case to check which card type,e.g visa, mastercard etc. and apply the specific rules for each card
	//rules about the length and input type of the card number and CVV
	switch(form.payment.value)
	{
		case "Visa": //card type visa
			var cardNo = /^[0-9]{16}$/;
			var cardCvv = /^[0-9]{3}$/;
		break;
		
		case "VisaDebit": //card type visa debit
			var cardNo = /^[0-9]{16}$/;
			var cardCvv = /^[0-9]{3}$/;
		break;
		
		case "Mastercard": //card type master card
			var cardNo = /^[0-9]{14}$/;
			var cardCvv = /^[0-9]{3}$/;
		break;
		
		case "AmericanExpress": //card type american express
			var cardNo = /^[0-9]{15}$/;
			var cardCvv = /^[0-9]{4}$/;
		break;
	
		//case 4 //card type paypal
	}
	
	//var array used to hold elementIDs to be passed into function checkInputFields(x)
	var fieldNames = ['name', 'email', 'number', 'cardnumber', 'cvv', 'expiry', 'password1', 'password2', 'street', 'city', 'country'];
	
	//sets variable result = to the value returned from checking if form is empty
	result = checkInputFields(fieldNames);
	
	var alertMessage="";
	
	//test cases using above rules
	
	//user email test case
	if ((email.test(form.email.value))==false && form.email.value != "")
	{
		alertMessage += form.email.value + ' is not a valid email address. \r\n';
		result =false;
		highlightField('email');
	}
	
	//user phone number test case
	if ((phone.test(form.number.value))==false && form.number.value != "")
	{
		alertMessage += form.number.value + ' is not a valid phone number. \r\n';
		result =false;
		highlightField('number')
	}
	
	//card number test case. Specific to card type. See switch(form.payment.value)
	if ((cardNo.test(form.cardnumber.value))==false && form.cardnumber.value != "")
	{
		alertMessage += form.cardnumber.value + ' is not a valid Card Number. \r\n';
		result =false;
		highlightField('cardnumber');
	}
	
	//card cvv test case. Specific to card type. See switch(form.payment.value)
	if ((cardCvv.test(form.cvv.value))==false && form.cvv.value != "")
	{
		alertMessage += form.cvv.value + ' is not a valid Card CVV. \r\n';
		result =false;
		highlightField('cvv');
	}
	
	//card expiry date test case
	if ((cardExpiry.test(form.expiry.value))==false && form.expiry.value != "")
	{
		alertMessage += form.expiry.value + ' is not a valid Expiry date. \r\n';
		result =false;
		highlightField('expiry');
	}
	
	//Password test, ensures first password entered matches second password entered
	if (form.password1.value != form.password2.value)
	{
		alertMessage = 'Your passwords do not match. Please re-enter password';
		result =false;
		highlightField('password1')
		highlightField('password2');
	}
	
	//password test case
	if ((aPassword.test(form.password1.value))==false && form.password1.value != "")
	{
		alertMessage += form.password1.value + ' is not a strong password. \r\n';
		result =false;
		highlightField('password1');
	}
	
	//generic form failure response. Specific details are added in alertMessage
	if (result==false)
	{
		alert(alertMessage += "Please fill out the required fields");
	}
	
	//returns true or false to html page before submitting form to php code/database
	return result
}

//function created to handle repetitive tasks using form element names
function checkInputFields(x)
{
	//sets result to true to allow the form to continue if no faults are found
	result = true;
	
	//a loop that takes element names passed into it to check those elements on the form
	for (i =0; i<x.length; i++)
	{
		//resets the form style if there was a mistake found previously
		document.getElementById(x[i]).style.background="white";
		document.getElementById(x[i]).style.border="solid lightgrey 1px";
		
		//checks if the form fields are empty, and if so prevents form from being submitted and highlights the empty field.
		if (document.getElementById(x[i]).value == "")
		{
			result =false;
			highlightField(x[i]);
		}
	}
	//returns result to the main function
	return result;
}

//function used to highlight fields with mistakes in them
function highlightField(elementId)
{
	//changes fields background and border to make it more apparent
	document.getElementById(elementId).style.background="lightyellow";
	document.getElementById(elementId).style.border="solid firebrick 1px";
}
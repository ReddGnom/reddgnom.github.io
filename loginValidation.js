function validate()
{	
	//rules to be used to test form inputs
	var email = /^[A-Za-z][A-Za-z0-9.]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,6}$/;
	var aPassword = /^(?=.*[@._%\+\-\s!\\\/\*\?])[A-Za-z0-9._%@\+\-\s!\\\/\*\?]{7,}$/;
	
	//var array used to hold elementIDs to be passed into function checkInputFields(x)
	var fieldNames = ['email',  'password2'];
	
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
	
	//Password test, ensures first password entered matches second password entered
	if (form.password.value != form.password.value)
	{
		alertMessage = 'Your passwords do not match. Please re-enter password';
		result =false;
		highlightField('password')
		highlightField('password');
	}
	
	//password test case
	if ((aPassword.test(form.password.value))==false && form.password.value != "")
	{
		alertMessage += form.password.value + ' is not a strong password. \r\n';
		result =false;
		highlightField('password');
	}
	
	//generic form failure response. Specific details are added in alertMessage
	if (result==false)
	{
		alert(alertMessage += "Please fill out the required fields");
	}
	else
	{
		//localStorage.setItem("email", form.email.value);
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
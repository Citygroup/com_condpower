Joomla.submitbutton = function(task)
{

}
Joomla.submitbutton2 = function(task)
{
    console.log(task);
    return false;
	if (task == '')
	{
		return false;
	}
	else if (task == '')
	{
		return false;
	}
	else
	{
		var isValid=true;
		var action = task.split('.');
		if (action[1] != 'cancel' && action[1] != 'close')
		{
			var forms = $$('form.form-validate');
			for (var i=0;i<forms.length;i++)
			{
				if (!document.formvalidator.isValid(forms[i]))
				{
					isValid = false;
					break;
				}
			}
		}
 
		if (isValid)
		{
			Joomla.submitform(task);
			return true;
		}
		else
		{
			alert(Joomla.JText._('COM_CONDPOWER_CONDPOWER_ERROR_UNACCEPTABLE','Some values are unacceptable'));
			return false;
		}
	}
}


/*
 * clears the current form
 * to make adding multiple 
 * many items quick.
 */
function clearForm(form)
{
    $(":input", form).each(function()
    {
    var type = this.type;
    var tag = this.tagName.toLowerCase();
    	if (type == 'text')
    	{
            this.value = "";
    	}
    });
};



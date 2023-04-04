var limit = 10; // Max questions
var count = 0; // There are 4 questions already

function addText()
{
    var formElem = document.getElementById('new-post-form');
    var qButton = document.getElementById('qButton');
    var pButton = document.getElementById('pButton');
    var hiddenV = document.getElementById('targetNbIpt_id');

    // Good to do error checking, make sure we managed to get something
    if (formElem)
    {
        if (count < limit)
        {
            var backright = document.createElement('br');
            // Create a new <p> element
            var newP = document.createElement('p');
            newP.innerHTML = 'Field ' + (count + 1);
            newP.id = 'txt' + count;

            // Create the new text box
            var newInput = document.createElement('input');
            newInput.type = 'text';
            newInput.id = 'ipt' + count;
            newInput.name = 'npIpt-'+count;
            newInput.placeholder = "Say something...";

            hiddenV.value = (count + 1);

            // Good practice to do error checking
            if (newInput && newP)   
            {
                // Add the new elements to the form
                formElem.appendChild(newP);
                formElem.appendChild(newInput);
                formElem.appendChild(backright);
                formElem.appendChild(qButton);
                formElem.appendChild(pButton);
                // Increment the count
                count++;
            }

        }
        else   
        {
            alert('Input limit reached');
        }
    }
}

function addIllustration()
{
    // Get the quiz form element
    var formElem = document.getElementById('new-post-form');
    var qButton = document.getElementById('qButton');
    var pButton = document.getElementById('pButton');
    var hiddenV = document.getElementById('targetNbIpt_id');

    // Good to do error checking, make sure we managed to get something
    if (formElem)
    {
        if (count < limit)
        {
            var backright = document.createElement('br');

            // Create a new <p> element
            var newP = document.createElement('p');
            newP.innerHTML = 'Photo/Video' /* + (count + 1) */;

            // Create the new text box
            var newInput = document.createElement('input');
            newInput.type = 'file';
            newInput.name = 'npIpt-'+count;
            
            hiddenV.value = (count + 1);
            // Good practice to do error checking
            if (newInput && newP)   
            {
                // Add the new elements to the form
                formElem.appendChild(newP);
                formElem.appendChild(newInput);
                formElem.appendChild(backright);
                formElem.appendChild(qButton);
                formElem.appendChild(pButton);
                // Increment the count
                count++;
            }

        }
        else   
        {
            alert('Input limit reached');
        }
    }
}

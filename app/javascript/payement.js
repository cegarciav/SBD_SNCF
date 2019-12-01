var inputs = document.getElementsByTagName("input");

for (let i = 0; i < inputs.length; i++)
{
  inputs[i].value = inputs[i].getAttribute('placeholder');
  inputs[i].addEventListener('focus',
        function()
        {
          if (this.value == this.getAttribute('placeholder'))
          {
            this.value = '';
          }
        });

  inputs[i].addEventListener('blur',
        function()
        {
          if (this.value == '')
          {
            this.value = this.getAttribute('placeholder');
          }
        });
}


function validate_payment()
{
  let inputs = document.getElementsByTagName("input");
  for (let i = 0; i < inputs.length; i++)
  {
    if (inputs[i].name == 'card_name')
    {
      if (!/^[A-Z]+[\- ]?[A-Z]+$/i.test(inputs[i].value))
      {
        alert('Prénom invalide');
        return false;
      }
    }
    else if (inputs[i].name == 'card_lastname')
    {
      if (!/^[A-Z]+[\- \']?[A-Z]+$/i.test(inputs[i].value))
      {
        alert('Nom invalide');
        return false;
      }
    }
    else if (inputs[i].name == 'card_number')
    {
      if (!/^\d{16}$/i.test(inputs[i].value))
      {
        alert('Numéro de carte invalide');
        return false;
      }
    }
    else if (inputs[i].name == 'card_expiration')
    {
      let regex_exp = /^(\d{2})\/(\d{2})$/i;
      let numbers = inputs[i].value.match(regex_exp);
      if (!regex_exp.test(inputs[i].value) ||
          numbers[1] > 12 || numbers[1] < 1)
      {
        alert('Date d\'expiration invalide. Respecter le format demandé');
        return false;
      }
    }
    else if (inputs[i].name == 'card_cvv')
    {
      if (!/^\d{3}$/i.test(inputs[i].value))
      {
        alert('CVV invalide');
        return false;
      }
    }
  }
  return true;
}

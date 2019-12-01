function valid_client()
{
  let name = document.getElementById("prenom");
  let lastname = document.getElementById("nom");
  let age = document.getElementById("age");
  let email = document.getElementById("email");

  if (!/^[A-Z]+[\- ]?[A-Z]+$/i.test(name.value))
  {
    alert('Prénom invalide. Évitez les accents s\'il vous plaît');
    return false;
  }

  if (!/^[A-Z]+[\- \']?[A-Z]+$/i.test(lastname.value))
  {
    alert('Nom invalide. Évitez les accents s\'il vous plaît');
    return false;
  }

  if ((!/^\d{1,3}$/i.test(age.value)) || age.value < 0 || age.value > 150)
  {
    alert('Âge invalide');
    return false;
  }

  let email_regex =
    /^[A-Za-z\d][A-Za-z\.\_\d\-]+[A-Za-z\d]@[A-Za-z\d][A-Za-z\.\_\d\-]+[A-Za-z\d]\.[A-Za-z]+$/i;
  if (!email_regex.test(email.value))
  {
    alert('Email invalide');
    return false;
  }

  return true;
}

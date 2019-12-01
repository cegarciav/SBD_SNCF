function post_choice(action, trip_id, arrive=null,
                      start_name=null, stop_name=null)
{
  let new_form = document.createElement('form');
  new_form.setAttribute('action', action);
  new_form.setAttribute('method', 'post');

  let one_way_data = JSON.stringify(one_way[trip_id]);
  let one_way_input = document.createElement('input');
  one_way_input.setAttribute('type', 'hidden');
  one_way_input.setAttribute('name', 'one_way');
  one_way_input.setAttribute('value', one_way_data);
  new_form.appendChild(one_way_input);

  if (arrive !== null && start_name !== null && stop_name !== null)
  {
    let return_date = document.createElement('input');
    return_date.setAttribute('type', 'hidden');
    return_date.setAttribute('name', 'return_date');
    return_date.setAttribute('value', arrive);
    new_form.appendChild(return_date);

    let start_input = document.createElement('input');
    start_input.setAttribute('type', 'hidden');
    start_input.setAttribute('name', 'start_name');
    start_input.setAttribute('value', start_name);
    new_form.appendChild(start_input);

    let stop_input = document.createElement('input');
    stop_input.setAttribute('type', 'hidden');
    stop_input.setAttribute('name', 'stop_name');
    stop_input.setAttribute('value', stop_name);
    new_form.appendChild(stop_input);
  }

  document.body.appendChild(new_form);
  new_form.submit();
}

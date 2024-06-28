function show() {
    let username = document.getElementById('udb').value;
    let password = document.getElementById('pdb').value;
    console.log(username);
    console.log(password);
    document.getElementById('ok').innerHTML = "prova";
    if ((username === 'root') && (password === 'root')) {
        alert('credenziali corrette');
        document.getElementById('registrazione').style.visibility = 'visible';
    } else {
        alert('credenziali di accesso non valide.');
    }
}

//per file tabelle.php
function newAttributo() {
    att = document.createElement('tr');
    att.innerHTML = "<td>\n" +
        "                <input name=\"att[]\" type=\"text\" required>\n" +
        "            </td>\n" +
        "            <td>\n" +
        "                <select id='tipo' name=\"tipo[]\" required> Tipo:\n" +
        "                    <option value=\"int\">INT</option>\n" +
        "                    <option value=\"boolean\">BOOLEAN</option>\n" +
        "                    <option value=\"varchar\">VARCHAR</option>\n" +
        "                    <option value=\"date\">DATE</option>\n" +
        "                </select>\n" +
        "            </td>\n" +
        "            <td>\n" +
        "                <input id='len' name=\"len[]\" type=\"text\">\n" +
        "            </td>";
    document.getElementById("listaAttributi").appendChild(att);
}

//per test.php
//creazione di un nuovo test
function showCreate(){
    document.getElementById('nuovoTest').style='display: block';
}




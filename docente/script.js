function show(){
    let username = document.getElementById('udb').value;
    let password = document.getElementById('pdb').value;
    console.log(username);
    console.log(password);
    document.getElementById('ok').innerHTML="prova";
    if ((username === 'root') && (password === 'root')){
        alert('credenziali corrette');
        document.getElementById('registrazione').style.visibility = 'visible';
    } else{
        alert('credenziali di accesso non valide.');
    }
}

//per file tabelle.php
function newAttributo(){
    att = document.createElement("li");
    att.innerHTML="<label>Nome attributo:</label>\n" +
        "            <input name=\"att[]\" type=\"text\" required>\n" +
        "            <select name=\"tipo[]\" required> Tipo:\n" +
        "                <option name=\"int\">INT</option>\n" +
        "                <option name=\"text\">TEXT</option>\n" +
        "                <option name=\"boolean\">BOOLEAN</option>\n" +
        "                <option name=\"varchar\">VARCHAR</option>\n" +
        "                <option name=\"date\">DATE</option>\n" +
        "            </select>\n" +
        "            <label>Lunghezza caratteri (facoltativo):</label>\n" +
        "            <input name=\"len[]\" type=\"text\">";
    document.getElementById("listaAttributi").appendChild(att);
}
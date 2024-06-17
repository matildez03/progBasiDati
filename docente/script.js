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

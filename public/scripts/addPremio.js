function guardarProducto(){
    let nombre = document.getElementById("premio").value;
    let millas = document.getElementById("millas").value;
    let destacado = document.querySelector('input[name="destacadosOption"]:checked').value;
    let tipoProducto = document.getElementById("tipo").value;
    if(nombre && millas && destacado && tipoProducto){
        if(destacado == "destacado"){
            destacado = true;
        }
        else{
            destacado = false;
        }
        //console.log(nombre); 
        //console.log(millas);
        //console.log(destacado);
        //console.log(tipoProducto);
    }
    else{
        alert('Llena todos los campos');
    }
   

}
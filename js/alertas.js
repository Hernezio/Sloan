// Alerta Confirma Eliminar
function confirmarEliminar(){
    var respuesta = confirm("¿ Estás seguro que deseas eliminar este registro ?");
    if (respuesta == true){
        return true;
    }else {
        return false;
    }
}

// Alerta solo letras
function soloLetras(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
    especiales = "8-37-39-46";
    tecla_especial = false;
    for(var i in especiales){
        if(key == especiales[i]){
            tecla_especial = true;
            break;
        }
    }
    if(letras.indexOf(tecla)==-1 && !tecla_especial){
    	var $mensaje=alert("Solo se permitén letras");
        return false;
    }
}

// No permite ingresar letras donde van numeros
function validarNumero(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true; 
    	patron =/[0-9]/;
    te = String.fromCharCode(tecla); 
    return patron.test(te); 
}


// SweetAlert2

// Recoradatorio Contraseña
function funcion_javascript() {
	Swal.fire(
	  'Recuerda!',
	  'Tu contaseña debe tener 10 digitos o menos',
	  'warning'
	);
}
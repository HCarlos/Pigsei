import React, {Component, useState} from "react";

export function SayImage(props)  {
    const src = props.src;
    const cualquiera = props.cualquiera;
    const nombre = props.nombre;

    // alert(src);

    let filex = src;
    if ( IfExistImage(filex) === false ) {
        filex = cualquiera;
    }
    // alert(filex);
    const [imagenActual, setImagenActual] = useState(filex);


    // alert("Inicio: " + imagenActual);

    const manejarError = (e) => {
        e.preventDefault()
        setImagenActual(cualquiera); // Cambia a una imagen de reserva en caso de error
    };


    function IfExistImage(filex) {
        let http = new XMLHttpRequest();
        http.open('HEAD', filex,false);
        http.send();
        return http.status === 200;
    }


        return (
            <div>
                <img
                    src={imagenActual}
                    alt={cualquiera}
                    onError={manejarError}
                    style={{ width: '100px', height: '100px' }}
                />
                <span>{nombre}</span>
            </div>
        )
}

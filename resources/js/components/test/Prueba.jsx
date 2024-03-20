import React from "react";
import { createRoot } from 'react-dom/client';

export default function Prueba(Mensaje){
    //console.log('estoy en App....');
    const username = document.getElementById('username').getAttribute('tag');
    console.log(username)
    return (
        <h1 className={'btn btn-primary'}> {username} </h1>
    )
    // console.log('si esta se entro..........');
}

// if ( document.getElementById('prueba') ){
//     createRoot(document.getElementById('prueba')).render(<Prueba/> );
// }

// let container = null;
// document.addEventListener('DOMContentLoaded', function(event) {
//     if (!container) {
//         createRoot(document.getElementById('prueba')).render(<Prueba /> );
//     }
// });


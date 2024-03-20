import React, {Fragment, useState} from "react";
import {useLocalStorage} from "../customHooks/useLocalStorage.js";
import { createRoot } from 'react-dom/client';

export default function LocalStorage(){
    const [text, setText] = useLocalStorage('text','-d-')

    return (
        <Fragment>
            <textarea
                onChange={e=> setText(e.target.value)}
                value={text}
                placeholder="Escribe algo"
            />
            <button className={'btn btn-primary'}>Enviar</button>
        </Fragment>
    )
}
let container = null;
document.addEventListener('DOMContentLoaded', function(event) {
    if (!container) {
        createRoot(document.getElementById('prueba')).render(<LocalStorage/>);
    }
});

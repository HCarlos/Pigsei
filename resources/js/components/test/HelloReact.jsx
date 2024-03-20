import React from 'react';
// import ReactDOM from 'react-dom';
import { createRoot } from 'react-dom/client';

export default function HelloReact() {
    return (
        <h1>Hello React!--</h1>
    );
}

// if (document.getElementById('hello-react')) {
//     ReactDOM.render(<HelloReact />, document.getElementById('hello-react'));
// }

let container = document.addEventListener('DOMContentLoaded', function(event) {
    if (!container) {
        createRoot(document.getElementById('hello-react')).render(<HelloReact /> );
    }
});

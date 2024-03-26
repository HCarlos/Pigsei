import React, { useState, useEffect } from "react";
import ReactDOM from 'react-dom/client';
import {GetSingleImage} from "./GetSingleImage.js";
import {SayImage} from "./SayImage.jsx";
function GetImage(){
    let recargar = false;
    // State to store the fetched data
    const [data, setData] = GetSingleImage(recargar);
    return (
        <div>
            <SayImage src={data.src} nombre={data.nombre} />
        </div>
    );
};


export default GetImage;

if (document.getElementById('getImage')) {
    const Index = ReactDOM.createRoot(document.getElementById("getImage"));
    Index.render(
        <React.StrictMode>
            <GetImage />
        </React.StrictMode>
    )
}

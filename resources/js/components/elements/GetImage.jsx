import GetImageDataJson from "./GetImageDataJson.js";
import React, { useState } from "react";
import ReactDOM from 'react-dom/client';
import {SayImage} from "./SayImage.jsx";
import axios from "axios";

function GetImage(){
    // State to store the fetched data
    let datajs = new GetImageDataJson();
    const [data, setData] = useState(async () => {
        try {
            const response = await axios.get(datajs.url, {headers: datajs.encabezadoGet});
            setData(response.data);
            // alert(data.any);
        } catch (error) {
            console.error("Error de la data:", error.response);
        }
    });

    return (
        <div>
            <SayImage src={data.src} nombre={data.nombre} cualquiera={data.cualquiera} />
        </div>
    );
}


export default GetImage;

if (document.getElementById('getImage')) {
    const Index = ReactDOM.createRoot(document.getElementById("getImage"));
    Index.render(
        <React.StrictMode>
            <GetImage />
        </React.StrictMode>
    )
}

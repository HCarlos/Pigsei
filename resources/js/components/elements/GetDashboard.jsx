import React, {useState} from 'react';
import ReactDOM from 'react-dom/client';
import {SayImage} from "./SayImage.jsx";
import axios from "axios";
import GetImageDataJson from "./GetImageDataJson.js";

const GetDashboard = () => {
    let datajs = new GetImageDataJson();
    const [data, setData] = useState([]);

    const fetchData = async () => {
        try {
            const response = await axios.get(datajs.url, {headers: datajs.encabezadoGet});
            setData(response.data);
        } catch (error) {
            console.error("Error de la data:", error.response);
        }
    };

    function handleOnClick() {
        // e.preventDefault();
        fetchData().then(r => null);
        if (document.getElementById('getImage')) {
            // alert(data.src);
            let ndx = ReactDOM.createRoot(document.getElementById("getImage"));
            ndx.render(
                <React.StrictMode>
                    <SayImage src={data.src} nombre={data.nombre} cualquiera={data.cualquiera} />
                </React.StrictMode>
            )
        }
    }

    return (
        <>
        <div className="card-header text-bg-danger" onClick={() => handleOnClick()} >
            Dashboard
        </div>
        </>
    );
};

export default GetDashboard;

if (document.getElementById('dashboard')) {
    const Index = ReactDOM.createRoot(document.getElementById("dashboard"));
    Index.render(
        <React.StrictMode>
            <GetDashboard/>
        </React.StrictMode>
    )
}



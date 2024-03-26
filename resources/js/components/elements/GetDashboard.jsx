import React from 'react';
import ReactDOM from 'react-dom/client';
import {GetSingleImage} from "./GetSingleImage.js";
import {SayImage} from "./SayImage.jsx";

const GetDashboard = () => {
    const [data, setData] = GetSingleImage();
    // const myFetch = GetSingleImage();

    function getData() {
        [data, setData] = GetSingleImage();
    }    const handleOnClick = (e) =>{
        e.preventDefault();
        // [data, setData] = GetSingleImage();
        if (document.getElementById('getImage')) {
            let ndx = ReactDOM.createRoot(document.getElementById("getImage"));
            ndx.render(
                <React.StrictMode>
                    <SayImage src={data.src} nombre={data.nombre} />
                </React.StrictMode>
            )
        }
    }

    return (
        <>
        <div className="card-header text-bg-danger" onClick={handleOnClick} >
            Dashbord
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



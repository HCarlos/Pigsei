import React, { useState, useEffect } from "react";
import axios from "axios";

export function GetSingleImage (recargar) {
    // State to store the fetched data
    const [data, setData] = useState([]);

    // Function to fetch data using Axios
    const fetchData = async () => {
        try {
            const response = await axios.get(`http://localhost:8000/body.json?timestamp=${new Date().getTime()}`,
                {
                    headers: {
                        "Cache-Control": "no-cache",
                        "Content-Type": "application/x-www-form-urlencoded",
                        "Access-Control-Allow-Origin": "*",
                    },
                }
            );
            setData(response.data);
        } catch (error) {
            setData(error.response.message)
            console.error("Error fetching data:", error.response.message);
        }
    };

    useEffect(() => {
        fetchData();
    }, []);

    // Call fetchData on component mount
    // if (recargar === true){
    //     fetchData();
    // }

//    recargar = false;

    return [data];
}

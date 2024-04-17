import React, { useState, useEffect } from "react";
import axios from "axios";

export function getSingleImage () {

    // State to store the fetched data
    // const [data, setData] = useState(async () => {
    //     try {
    //         const response = await axios.get(`http://localhost:8000/body.json?timestamp=${new Date().getTime()}`,
    //             {
    //                 headers: {
    //                     "Cache-Control": "no-cache",
    //                     "Content-Type": "application/x-www-form-urlencoded",
    //                     "Access-Control-Allow-Origin": "*",
    //                 },
    //             }
    //         );
    //         return response.data;
    //     } catch (error) {
    //         console.error("Error fetching data:", error.response.message);
    //         return error.response.message;
    //     }
    // });

    const [data, setData] = useState([]);
    // var data = [];
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
            // console.error("Error fetching data:", error.response.message);
            setData([]);
        }
    };

    useEffect(() => {
        fetchData();
    }, []);

    // return data;

    return [data];
}

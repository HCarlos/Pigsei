import React, {Component} from "react";
import {compile} from "sass";

export default class GetImageDataJson extends Component{
    instance;
    _url = "http://localhost:8000/body.json?timestamp=${new Date().getTime()}";
    _dataImage = {
            src : "",
            nombre : "",
            any : "",
    }

    _encabezadoGet = {
            "Cache-Control": "no-cache",
            "Content-Type": "application/x-www-form-urlencoded",
            "Access-Control-Allow-Origin": "*",
    }


    constructor(props) {
        super(props);
        if (!this.instance) {
            this.instance = this;
            this.name = 'GetImageDataJson';
            // this.instance = Object.freeze(this);
        }
        this.instance = this;
    }

    getInstance() {
        return this;
    }




    get url() {
        return this._url;
    }

    get dataImage() {
        return this._dataImage;
    }

    get encabezadoGet() {
        return this._encabezadoGet;
    }
}

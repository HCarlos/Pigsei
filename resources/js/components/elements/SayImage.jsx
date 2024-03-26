import React from "react";

export class SayImage extends React.Component {
    render() {
        return (
            <div>
                <img src={this.props.src} alt={this.props.nombre}/>
                <span>{this.props.nombre}</span>
            </div>
        )
    }
}

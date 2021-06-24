import React from 'react'
import './CoverArt.css'


class CoverArt extends React.Component{
  render(){
    let {"Album Cover art": coverArt, "mouse tracking": rotateMoment} = this.props.art
    let rotate = {
      transform: `rotate(${rotateMoment}deg)`
    }
    return(
      <div className="mainSection-coverArt" style={coverArt, rotate}></div>
    )
  }
}

export default CoverArt;

import React from 'react'
import './Runner.css'


class Runner extends React.Component{
  constructor(props) {
    super(props)
    this.state = {
      movingAtX: 175
    }
    console.log(this.props.trackingX()) 
  }
  componentDidMount() {
    this.parent = document.querySelector('.mainSection-runner')
    this.sliderMovement = this.sliderMovement.bind(this)
    this.mouseDontMove = this.mouseDontMove.bind(this)
    this.mouseOut = this.mouseOut.bind(this)
    this.mouseMove = this.mouseMove.bind(this)
  }
  sliderMovement(e) {
    document.addEventListener('mousemove', this.mouseMove)
    e.target.addEventListener('mouseout', this.mouseOut)
  }
  mouseMove = (e) => {
    let long = e.pageX - this.parent.offsetLeft - 25
    if (long > 350) {
      long = 350
    } else if (long < 0) {
      long = 0
    }
    this.setState({movingAtX: long})
    this.props.trackingX(this.state.movingAtX)
    e.target.style.left = long + 'px'
  }
  mouseDontMove(e) {
    document.removeEventListener('mousemove', this.mouseMove)
    e.target.removeEventListener('mouseout', this.mouseOut)
  }
  mouseOut(e) {
    document.removeEventListener('mousemove', this.mouseMove)
    e.target.removeEventListener('mouseout', this.mouseOut)
  }
  render(){
    return(
      <div className="mainSection-runner">
        <div className="mainSection-runner__slider" onMouseDown={this.sliderMovement} onMouseUp={this.mouseDontMove}></div>
        <p className="mainSection-runner__range">Range: {this.state.movingAtX}</p>
      </div>
    )
  }
}

export default Runner;

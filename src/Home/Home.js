import React from 'react'
import {withRouter} from "react-router"
import './Home.css'

class Home extends React.Component {
    constructor(props) {
        super(props) 
        this.newPos = this.props.newPos
        this.animation = this.props.animation
    }
    componentWillUnmount() {
        this.newPos({oldPosition: 0})
    }
    goInfo() {
        this.props.history.push('/info')
    }
    animationTransition() {
        let elem = document.querySelector('.section-main')
        elem.classList.add('animationOut')
    }
    render() {
        return (
            <div className={`section-main ${this.animation(0)}`}>
                <h3 className="section-main__title">Добро пожаловать в магазин бананов</h3>
                <p className="section-main__descriptionOne">Здесь вы можете купить...</p>
                <p className="section-main__descriptionTwo">...бананы</p>
                <button className="section-main__button" onClick={() => {
                    this.animationTransition()
                    setTimeout(() => this.goInfo(), 180)
                }}>Закупимся!</button>
            </div>
        )
    }
}

export default withRouter(Home)
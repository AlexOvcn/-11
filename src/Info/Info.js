import React from 'react'
import {withRouter} from "react-router"
import './Info.css'

class Info extends React.Component {
    constructor(props) {
        super(props)
        this.newPos = this.props.newPos
        this.animation = this.props.animation
    }
    componentWillUnmount() {
        this.newPos({oldPosition: 1})
    }
    goHomePage() {
        this.props.history.push('/')
    }
    goProductPage() {
        this.props.history.push('/products')
    }
    animationTransition() {
        let elem = document.querySelector('.section-main')
        elem.classList.add('animationOut')
    }
    render() {
        return (
            <div className={`section-main ${this.animation(1)}`}>
                <h3 className="section-main__title">В нашем магазине продаются бананы со всего мира</h3>
                <p className="section-main__description">Все бананы прошли проверку качества, но они жухлые</p>
                <p className="section-main__description">Я, как основатель данного сайта очень люблю бананы!</p>
                <div className="section-main__img"></div>
                <button className="section-main__button" onClick={() => {
                    this.animationTransition()
                    setTimeout(() => this.goHomePage(), 180)
                }}>← Не люблю жухлые</button>
                <button className="section-main__button" onClick={() => {
                    this.animationTransition()
                    setTimeout(() => this.goProductPage(), 180)
                }}>Забананиться →</button>
            </div>
        )
    }
} 

export default withRouter(Info) 
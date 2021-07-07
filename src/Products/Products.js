import React from 'react'
import {withRouter} from "react-router"
import Product from '../Product/Product'
import './Products.css'

class Products extends React.Component {
    constructor(props) {
        super(props)
        this.newPos = this.props.newPos
        this.animation = this.props.animation
        this.state = {
            product: [{link: 'banan1', name: 'Скисший', price: '1.90$', img: 'https://www.verywellhealth.com/thmb/8DwFxbjOmOh0Gv-wkMi7_knxivU=/3869x2579/filters:no_upscale():max_bytes(150000):strip_icc()/GettyImages-550776341-56a50a9b5f9b58b7d0da9b7c.jpg'},
            {link: 'banan2', name: 'Вялый', price: '2.00$', img: 'https://www.factroom.ru/wp-content/uploads/2019/04/pyat-perezrevshih-bananov-ravny-odnoj-butylke-piva-po-soderzhaniyu-spirta.jpg'},
            {link: 'banan3', name: 'Дряхлый', price: '1.10$', img: 'https://bestofculinary.com/wp-content/uploads/2020/08/shutterstock_72634363.jpg'},
            {link: 'banan4', name: 'Тухлый', price: '5.00$', img: 'https://i2.wp.com/thedeadpool.rip/wp-content/uploads/2018/04/a3e249e1507820ada6cf4a5a144e5caf.jpg'}]
        }
    }
    componentWillUnmount() {
        this.newPos({oldPosition: 2})
    }
    goHomePage() {
        this.props.history.push({
            pathname: '/'
        })
    }
    slowScrollUp() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        })
    }
    render() {
        return (
            <div className={`section-main ${this.animation(2)}`}>
                <h3 className="section-main__title">А вот и наша продукция</h3>
                <p className="section-main__description_products">Бананы не очень, сразу говорю</p>
                <div className="section-main__grid">
                    {
                        this.state.product.map((item, index) => {
                            return (
                                <Product key={index} name={item.name} price={item.price} img={item.img} link={item.link} forProductInfo={(value) => this.props.forProductInfo(value)}/>
                            )
                        })
                    }
                </div>
                <button className="section-main__button" onClick={() => {
                    let elem = document.querySelector('.section-main')
                    elem.classList.add('animationOut')
                    this.slowScrollUp()
                    setTimeout(() => this.goHomePage(), 300)
                }}>Вернуться на главную</button>
            </div>
        )
    }
} 

export default withRouter(Products) 
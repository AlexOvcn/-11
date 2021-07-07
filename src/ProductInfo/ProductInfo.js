import React from 'react'
import {withRouter} from "react-router"
import './ProductInfo.css'

class ProductInfo extends React.Component {
    goProduct() {
        this.props.history.push({
            pathname: '/products'
        })
    }
    render() {
        let {price, img, name} = this.props.data
        return (
            <div className="section-productInfo animationIn">
                <button className="section-productInfo__button" onClick={() => this.goProduct()}>← Назад</button>
                <h3 className='section-productInfo__title'>{name}</h3>
                <img src={img} alt={`img-${name}`}className="section-productInfo__img" />
                <p className="section-productInfo__price">Цена: {price}</p>
            </div>
        )
    }
}

export default withRouter(ProductInfo) 
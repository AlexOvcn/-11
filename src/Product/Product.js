import {withRouter} from "react-router"
import './Product.css'

function Product(props) {
    let {name, price, img, link, forProductInfo} = props
    function toProduct() {
        forProductInfo({currentProdactInfo: {
            price, img, name
        }})
        props.history.push(`/products/${link}`)
    }
    return (
        <div className="section-main__grid_item"
            onClick={() => toProduct()}>
            <h4 className="itemGrid-title">{name}</h4>
            <img src={img} alt="banan"  className="itemGrid-img"/>
            <p className="itemGrid-price">{price}</p>
        </div>
    )
}

export default withRouter(Product) 
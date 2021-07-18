import { NavLink } from 'react-router-dom'
import './categoryItem.scss'

function CategoryItem(props) {
    const {strCategory, strCategoryThumb, strCategoryDescription} = props
    return ( 
        <div className='card'>
            <p className='card-title'>{strCategory}</p>
            <img className='card-img' src={strCategoryThumb} alt={strCategoryDescription} />
            <p className='card-description'>{strCategoryDescription.slice(0, 90) + '...'}</p>
            <NavLink className="card-button" to={`/category/${strCategory}`} exact>Просмотр категории</NavLink> 
        </div>
    )
}

export default CategoryItem
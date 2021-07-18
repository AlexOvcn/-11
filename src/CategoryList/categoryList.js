import CategoryItem from '../CategoryItem/categoryItem'
import './categoryList.scss'

function CategoryList({ catalog }) {
    return ( 
        <div className='mainSection-list grid'>
            {catalog.map((el) => (
                <CategoryItem key={el.idCategory} {...el} />
            ))}
        </div>
    )
}

export default CategoryList
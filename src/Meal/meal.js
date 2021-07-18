import { NavLink } from 'react-router-dom'
import './meal.scss'

function Meal(props) {
    const {strMeal, strMealThumb, idMeal} = props
    return ( 
        <div className='card'>
            <img className='card-img' src={strMealThumb} alt={strMeal} />
            <p className='card-title' style={strMeal.length > 40 ? {fontSize: 19 + 'px', textAlign: 'center'}: null}>{strMeal}</p>
            <NavLink className="card-button" to={`/meal/${idMeal}`} exact>Узнать рецепт</NavLink> 
        </div>
    )
}

export default Meal
import Meal from '../Meal/meal'
import './mealList.scss'

function MealList({ meals }) {
    return ( 
        <div className='mainSection-list grid'>
            {meals.map((meal) => (
                <Meal key={meal.idMeal} {...meal} />
            ))}
        </div>
    )
}

export default MealList
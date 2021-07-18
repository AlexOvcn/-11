import { useState, useEffect } from 'react'
import { useHistory, useParams } from 'react-router-dom'
import { getFiltredCategory } from '../api'
import Preloader from '../Preloader/preloader'
import MealList from '../MealList/mealList'
import './category.scss'


function Category() {
    let { name } = useParams();
    const [meals, setMeals] = useState([]);
    const history = useHistory();

    function goHome() {
        history.push('/')
    }

    useEffect(() => {
        function goNotFoundPage() {
            history.push('/NotFoundPage')
        }
        getFiltredCategory(name).then(data => {
            data.meals === null  ? goNotFoundPage() : setMeals(data.meals)
        })
    }, [name,history])

    return (
        <>
            {
                !meals.length ? <Preloader /> : <MealList meals={meals} />
            }
            <button className='btn-link' onClick={goHome}>Вернуться назад</button>
        </>
    )
}

export default Category
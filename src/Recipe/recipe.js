import { useState, useEffect, useCallback } from 'react'
import { useParams, useHistory } from 'react-router-dom'
import { getMealById } from '../api'
import Preloader from '../Preloader/preloader'
import NeedRegistration from '../NeedRegistration/needRegistration'
import './recipe.scss'

function Recipe({registred}) {
    const {id} = useParams();
    const [recipe, setRecipe] = useState({});
    const history = useHistory();

    const goNotFoundPage = useCallback(() => {
        history.push('/NotFoundPage')
    }, [history])

    useEffect(() => {
        getMealById(id).then((data) => data.meals === null ? goNotFoundPage() : setRecipe(data.meals[0]))
    }, [id, goNotFoundPage])

    function goBack() {
        history.push(`/category/${recipe.strCategory}`)
    }
    return (
        <>
            {
                !recipe.idMeal ? <Preloader /> :  (registred ? (
                    <div className="mainSection-recipe">
                        <h3 className='mainSection-recipe__title'>{recipe.strMeal}</h3>
                        <img className='mainSection-recipe__img' src={recipe.strMealThumb} alt="recipe.strMeal" />
                        <div className='mainSection-recipe__info'>
                            <p className='mainSection-recipe__info_category'>Категория: {recipe.strCategory}</p>
                            {
                                recipe.strArea ? <p className='mainSection-recipe__info_country'>Страна: {recipe.strArea}</p> : null
                            }
                            <p className='mainSection-recipe__info_recipe'>Рецепт: {recipe.strInstructions}</p>
                        </div>
                        <button className='mainSection-recipe__btn btn-link' onClick={goBack}>Вернуться назад</button>
                        
                    </div>
                ) : <NeedRegistration category={recipe.strCategory}/>)
            }
        </>
    )
}

export default Recipe
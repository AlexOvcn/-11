
import { API_URL } from './config';

const getAllCategories = async () => {
    const response = await fetch(API_URL + 'categories.php')
    return await response.json();
}

const getMealById = async (idMeal) => {
    try {
        const response = await fetch(API_URL + "lookup.php?i=" + idMeal)
        
        return await response.json();
    } catch(err) {
        console.error(`Ошибка получения ответа сервера: ${err}`)
        return {meals: null}
    }
}

const getFiltredCategory = async (categName) => {
    try {
        const response = await fetch(API_URL + "filter.php?c=" + categName)
        
        return await response.json();
    } catch(err) {
        console.error(`Ошибка получения ответа сервера: ${err}`)
        return {meals: null}
    }
}

export { getAllCategories, getMealById, getFiltredCategory }
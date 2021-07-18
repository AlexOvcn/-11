import { useState, useEffect } from 'react'
import { getAllCategories } from '../api'
import Preloader from '../Preloader/preloader'
import CategoryList from '../CategoryList/categoryList'
import './home.scss'


function Home() {
    const [catalog, setCatalog] = useState([]);

    useEffect(() => {
        getAllCategories().then((data) => {
            setCatalog(data.categories)
        })
    }, [])
    return (
        <>
            {
                !catalog.length ? <Preloader /> : <CategoryList catalog={catalog} />
            }
        </>
    )
}

export default Home
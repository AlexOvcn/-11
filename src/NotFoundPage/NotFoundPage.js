import {withRouter} from "react-router"
import './NotFoundPage.scss'

function NotFoundPage(props) {
    function goHomePage() {
        props.history.push('/')
    }
    return (
        <div className='mainSection-notFound'>
            <h3 className="mainSection-notFound__title">Страница не найдена</h3>
            <p className="mainSection-notFound__description">Похоже что ваша страница не существует</p>
            <div className="mainSection-notFound__img404"></div>
            <button className="mainSection-notFound__button btn-link" onClick={() => {
                setTimeout(() => goHomePage(), 300)
            }}>Вернуться на главную</button>
        </div>
    )
} 

export default withRouter(NotFoundPage)
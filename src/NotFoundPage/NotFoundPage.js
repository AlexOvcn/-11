import {withRouter} from "react-router"
import './NotFoundPage.css'

function NotFoundPage(props) {
    function goHomePage() {
        props.history.push('/')
    }
    return (
        <div className='section-main'>
            <h3 className="section-main__title">Страница не найдена</h3>
            <p className="section-main__description">Похоже страница подскользнулась на кожурке</p>
            <div className="section-main__img404"></div>
            <button className="section-main__button" onClick={() => {
                let elem = document.querySelector('.section-main')
                elem.classList.add('animationOut')
                setTimeout(() => goHomePage(), 300)
            }}>Вернуться на главную</button>
        </div>
    )
} 

export default withRouter(NotFoundPage)
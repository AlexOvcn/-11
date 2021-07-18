import './header.scss'
import { NavLink } from 'react-router-dom'

function Header(props) {
    let {changeState, registred} = props
    function registrationOn() {
        changeState({registration: true})
    }
    function signInOn() {
        changeState({login: true})
    }
    function deauthorization() {
        changeState({registred: {
            ...registred, status: false
        }})
    }
    return (
        <header className="header">
            <div className="container">
                <div className="header-wrap">
                    <NavLink className="header-logo" to='/' exact>GoodMeal.com</NavLink> 
                    <div className="header-regLoginWrap">
                        {
                            registred.status ? <button className="header-regLoginWrap__login button" onClick={() => {
                                alert('Вы вышли из учетной записи')
                                deauthorization()
                            }}>Выйти</button> : <button className="header-regLoginWrap__login button" onClick={signInOn}>Войти</button>
                        }
                        <button className="header-regLoginWrap__registration button" onClick={registrationOn}>Регистрация</button>
                    </div>
                </div>
            </div>
        </header>
    )
}

export default Header;
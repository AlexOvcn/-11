import { useState, useEffect } from 'react'
import { useHistory } from 'react-router-dom'
import './loginForm.scss'

function LoginForm(props) {
    let {changeState, registred} = props
    let [checkInputs, setcheckinputs] = useState({
        inputLogin: '',
        inputPassword: ''
    })
    const history = useHistory();
    function goHome() {
        history.push('/')
    }
    useEffect(() => {
        document.body.style.overflow = 'hidden';
    }, [])
    function signInOff() {
        changeState({login: false})
    }
    function slowHiddenBGAndWindow() {
        let regLoginFormWrap = document.querySelector('.regLoginFormWrap')
        let regLoginFormWrapWindow = document.querySelector('.regLoginFormWrapWindow')
        regLoginFormWrap.classList.remove('slowShowBG')
        regLoginFormWrap.classList.add('slowHiddenBG')
        regLoginFormWrapWindow.classList.remove('slowShow')
        regLoginFormWrapWindow.classList.add('slowHidden')
    }
    return (
        <div className='regLoginFormWrap slowShowBG' onMouseDown={() => {
            slowHiddenBGAndWindow()
            setTimeout(() => {
                signInOff();
                document.body.style.overflow = 'visible';
            },300)
        }}>
            <div className="regLoginFormWrapWindow slowShow" onMouseDown={(e) => {
                e.stopPropagation();
            }}>
                <h2 className='regLoginFormWrapWindow-title'>Авторизайция</h2>
                <form action="submit" className='regLoginForm'>
                    <input type="text" className="regLoginForm-login" placeholder='Ваша почта' maxLength="22" onChange={(e) => {
                        setcheckinputs({...checkInputs, inputLogin: e.target.value})
                    }}/>
                    <input type="password" className="regLoginForm-password" placeholder='Ваш пороль'minLength="2" maxLength="10" onChange={(e) => {
                        setcheckinputs({...checkInputs, inputPassword: e.target.value})
                    }}/>
                    <button type="submit" onClick={(e) => {
                        e.preventDefault()
                        if (!checkInputs.inputLogin.length && !checkInputs.inputPassword.length) {
                            alert('Сначала заполните форму')
                        } else if (registred.login === checkInputs.inputLogin && registred.password === checkInputs.inputPassword) {
                            registred.status = true
                            slowHiddenBGAndWindow()
                            setTimeout(() => {
                                signInOff();
                                goHome();
                                document.body.style.overflow = 'visible';
                            },300)
                            setTimeout(() => {
                                alert('Вы успешно авторизовались')
                            },400)
                        } else {
                            alert('Неправильный логин или пороль')
                        }
                    }}>Войти</button>
                </form>
            </div>
        </div>
    )
}

export default LoginForm
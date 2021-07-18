import { useState, useEffect } from 'react'
import './regForm.scss'

function RegForm(props) {
    let {changeState} = props
    let [statusForm, setStatusForm] = useState({
        login: '',
        password: '',
        registered: false
    })
    useEffect(() => {
        document.body.style.overflow = 'hidden';
    }, [])
    function registrationOff() {
        changeState({registration: false})
    }
    function inputValid(reg, event){ //функция проверки полей, принимает регулярное выражение для него и эвент события
        let value = event.target.value
        if (value.match(reg) !== null && value.length > 0 && {...value.match(reg)}[0] === value){
            event.target.style.border = '2px groove rgb(91, 190, 91)';
            return true;
        } else if (value.length <= 0) {
            event.target.style.border = '2px groove rgb(192, 192, 192)';
        }
        else {
            event.target.style.border = '2px groove rgb(255, 115, 115)';
            return false;
        }
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
                registrationOff();
                document.body.style.overflow = 'visible';
            },300)
        }}>
            <div className="regLoginFormWrapWindow slowShow" onMouseDown={(e) => {
                e.stopPropagation();
            }}>
                <h2 className='regLoginFormWrapWindow-title'>Регистрация</h2>
                <form action="submit" className='regLoginForm'>
                    <input type="text" className="regLoginForm-login" placeholder='Ваша почта' maxLength="27" onChange={(e) => {
                        let reg__email = /[0-9A-Za-z_-]+@[0-9A-Za-z_^]+\.[a-z]{2,3}/g
                        if(inputValid(reg__email, e)) {
                            setStatusForm({...statusForm, login: e.target.value})
                        }
                    }}/>
                    <input type="password" className="regLoginForm-password" placeholder='Ваш пороль (англ. буквы и цифры)' maxLength="10" onChange={(e) => {
                        let reg_pass = /^[A-Za-z0-9]{2,}[-_]{0,1}[A-Za-z0-9]{0,}/;
                        if(inputValid(reg_pass, e)) {
                            setStatusForm({...statusForm, password: e.target.value})
                        }
                    }}/>
                    <button type="submit" onClick={(e) => {
                        e.preventDefault()
                        if (statusForm.login.length && statusForm.password.length) {
                            changeState({registred: {
                                status: false,
                                login: statusForm.login,
                                password: statusForm.password
                            }})
                            slowHiddenBGAndWindow()
                            setTimeout(() => {
                                registrationOff();
                                document.body.style.overflow = 'visible';
                            },300)
                            setTimeout(() => {
                                alert('Вы успешно зарегистрировались')
                            },400)
                        } else {
                            alert('Введите корректные данные')
                        }
                    }}>Зарегистрироваться</button>
                </form>
            </div>
        </div>
    )
}

export default RegForm
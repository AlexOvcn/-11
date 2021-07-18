import { useHistory } from 'react-router-dom'
import './needRegistration.scss'

function NeedRegistration({category}) {
    const history = useHistory();
    function goBack() {
        history.push(`/category/${category}`)
    }
    
    return (
        <div className='mainSection-needRegistration'>
            <h3 className='mainSection-needRegistration__title'>Пожалуйста войдите в систему</h3>
            <p className='mainSection-needRegistration__description'>Этот раздел могут смотреть только зарегистрированные пользователи</p>
            <button className='mainSection-needRegistration__button btn-link' onClick={goBack}>Вернуться назад</button>
        </div>
    )
} 

export default NeedRegistration
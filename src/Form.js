import {useState} from 'react';

function Form(props){
    let [value, setValue] = useState('');
    let {addTask} = props;
    
    let sendSubmit = e => {
        e.preventDefault();
        addTask(value);
        setValue('');
    }
    
    return (
        <div>
            <form className="inputField" onSubmit={sendSubmit}>
                <input 
                    type="text"
                    className="input"
                    placeholder="Напишите новую задачу" 
                    value={value}
                    onChange={e => setValue(e.target.value)}
                />
            </form>
        </div>
    )
}

export default Form;
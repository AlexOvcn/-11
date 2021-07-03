import {useState} from 'react';
import './Task.css'

function Task(props){
    let {task, index, doneTask, FindCurrentTusk} = props;
    let [position, setPosition] = useState(true)

    return (
        <div className="task" style={{textDecoration: task.done ? 'line-through' : ""}}>
            {task.text}
            <div>
                <button className="task-buttonDone" onClick={() => {
                    setPosition(!position)
                    doneTask(index, position)
                    
                    }}>Done</button>
                <button className="task-buttonDelete" onClick={() => {
                    let [deleteTask, hiddenTask] = FindCurrentTusk(index)
                    FindCurrentTusk(index)
                    hiddenTask()
                    setTimeout(() => deleteTask(), 1000)
                    }}>X</button>
            </div>
        </div>
    )
}

export default Task;
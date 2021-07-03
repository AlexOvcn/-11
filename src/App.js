import {useState} from 'react';
import './App.css';
// import Counter from './Counter';
// import Person from './Person';
// import Item from './Item';
import Task from './Task';
import Form from './Form';
import Placeholder from './Placeholder/Placeholder'

function App() {
  let [tasks, setTasks] = useState([
    {
      text: "Выучить JavaScript",
      done: false
    },
    {
      text: "Познакомиться с React",
      done: false
    },
    {
      text: "Устроиться на работу",
      done: false
    }
  ])

  let addTask = text => {
    if (text.length === 0) {
      return
    }
    let newTask = [...tasks, {text, done: false}]
    setTasks(newTask);
  }
  let FindCurrentTusk = (index) => {
    let taskOld = [...tasks]
    let taskCurInd = index
    for (let i = 0; i < taskOld.length; i++) {
      if(i > taskCurInd) {
        let currentObj = taskOld[i]
        taskOld[i] = taskOld[taskCurInd]
        taskOld[taskCurInd] = currentObj
        taskCurInd += 1
      } else
      continue
    }
    let elem = document.querySelectorAll('.task')
    let hiddenTask = () => {
      elem[index].classList.add('hidden')
    }
    let deleteTask = () => {
      taskOld.pop(taskOld.length - 1)
      setTasks(taskOld)
      elem[index].classList.remove('hidden')
    }
    return [deleteTask, hiddenTask]
  }

  let doneTask = (index, position)=> {
    let newTask = [...tasks];
    if (position) {
      newTask[index].done = true;
    } else {
      newTask[index].done = false;
    }
    
    setTasks(newTask);
  }

  return (
    <div className="App">
      <div className="tasksWrap">
      {
        tasks.map((task, index) => (
          <Task 
            key={index} 
            task={task} 
            index={index}
            doneTask={doneTask}
            FindCurrentTusk={FindCurrentTusk}
          />
        ))
      }
      </div>
      <Form addTask={addTask} />
      {/* <Counter />
      <Person />
      <Item /> */}
      <Placeholder />
    </div>
  );
}

export default App;

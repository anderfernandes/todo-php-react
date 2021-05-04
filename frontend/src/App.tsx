import React, { useState, ChangeEvent, useEffect, MouseEvent } from 'react'
import logo from './logo.svg'
import MyButton from './Components/MyButton'
import './App.css'

interface ITask {
  id: number,
  name: string,
  isCompleted: boolean
}

function App() {
  // Tasks state
  const [tasks, setTasks] = useState<ITask[]>([
    {id: 1, name: 'groceries', isCompleted: true }
  ])
  
  // Name state, for task name input
  const [ name, setName ] = useState("")

  // isCompleted state, for task is completed checkbox
  const [ isCompleted, setIsCompleted ] = useState(false)

  // Assigning the value of the name input to the app state
  const handleNameInput = ({ target } : ChangeEvent<HTMLInputElement>) => setName(target.value)
  
  // Assigning the value of the is completed checkbox to the app state
  const handleIsCompletedInput = ({ target } : ChangeEvent<HTMLInputElement>) => setIsCompleted(target.checked)
  
  // Adding tasks to the app state, input pending validation
  const handleAddTask = (e : MouseEvent<HTMLButtonElement>) => {
    e.preventDefault()
    const newTask = { id: tasks.length + 1, name, isCompleted }
    setTasks([...tasks, newTask ])
    setName("")
    setIsCompleted(false)
  }

  // Toggle a task between true or false for the isCompleted task property
  // Look at Array.prototype.map and object spread on MDN
  const toggleTask = (id : number) => setTasks(tasks.map(t => t.id === id ? {...t, isCompleted: !t.isCompleted } : t))

  // Deletes a task by simple filtering it out of the tasks state
  // Look at Array.prototype.filter on MDN
  const deleteTask = (id : number) => setTasks(tasks.filter(t => t.id != id))
  
  return (
    <div className="container">
      <h1>Todo PHP React</h1>
      
      <form className="card">
        <div className="card-body">
          <div className="mb-3">
            <label className="form-label">Task Name</label>
            <input
              value={name}
              onChange={handleNameInput}
              type="text" 
              className="form-control"
              placeholder="Task Name" />
            <div id="emailHelp" className="form-text">
              What is the name of your task?
            </div>
          </div>
          <div className="mb-3 form-check">
            <input 
              type="checkbox" 
              checked={isCompleted} 
              onChange={handleIsCompletedInput}
              className="form-check-input" 
            />
            <label className="form-check-label">Completed</label>
          </div>
          <MyButton Type="primary" Text="Add" onClick={handleAddTask} />
          <MyButton Type="secondary" Text="Clear" onClick={handleAddTask} />
        </div>
      </form>

      <table className="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Completed</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          { tasks.map(t => 
          /* 
            We are adding a strikethrough CSS decoration to completed tasks.
            In React, CSS is defined as an object. Note how in style we are using
            TWO angle brackets ({}) rather than just one.
          */
          <tr key={t.id} style={{textDecoration: t.isCompleted ? 'line-through' : 'none'}}>
            <td>{t.id}</td>
            <td>{t.name}</td>
            <td>{t.isCompleted ? "Yes" : "No"}</td>
            <td>
              {/* Here we are using out custom button component */}
              <MyButton Type="warning" Text="Edit" />
              {/* 
                The onClick handler must be done like this since we need to pass the id of the 
                task so that we can update or delete it properly 
              */}
              <MyButton Type="secondary" onClick={() => toggleTask(t.id)} Text={t.isCompleted ? "Mark as Not Completed" : "Mark as Completed"} />
              <MyButton Type="danger" onClick={() => deleteTask(t.id)} Text="Delete" />
            </td>
          </tr>
          )}
        </tbody>
      </table>
    </div>
  )
}

export default App

import React from 'react'
import Header from './Header/header'
import MainSection from './MainSection/mainSection'
import Footer from './Footer/footer'
import RegForm from './RegLoginForm/RegForm/regForm'
import LoginForm from './RegLoginForm/LoginForm/loginForm'
import './App.css';

class App extends React.Component {
  state = {
    registred: {
      status: false,
      login: '',
      password: ''
    },
    registration: false,
    login: false

  }
  changeState(value) {
    this.setState(value)
  }
  render() {
    return (
        <>
          <Header changeState={(value) => this.changeState(value)} registred={
            this.state.registred}/>
          <MainSection registred={
            this.state.registred.status}/>
          {this.state.registration  && <RegForm  changeState={(value) => this.changeState(value)} />}
          {this.state.login  && <LoginForm  changeState={(value) => this.changeState(value)} registred={
            this.state.registred
          } />}
          <Footer />
        </>
      );
  }
  
}

export default App;

import './App.css';
import React from 'react'
import { Route, NavLink, Switch } from 'react-router-dom'
import Home from './Home/Home'
import Info from './Info/Info'
import Products from './Products/Products'
import ProductInfo from './ProductInfo/ProductInfo'
import NotFoundPage from './NotFoundPage/NotFoundPage'



class App extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      oldPosition: 0,
      currentProdactInfo: {
        price: 0, img: '', name: ''
      }
    }
  }
  forProductInfo(value) {
    console.log(this.state);
    this.setState(value)
  }
  animation(newPosition) {
    if (this.state.oldPosition > newPosition) {
      return 'animationLeft'
    }
    if (this.state.oldPosition < newPosition) {
      return 'animationRight'
    } else 
    return 'animationIn'
  }
  render() {
    return (
      <div className="background">
        <div className="header container">
          <h1 className="header-brand">BananaMarket</h1>
          <ul className="header-navbar">
            <li className="header-navbar__link">
              <NavLink to='/' exact activeClassName='current'>Главная</NavLink> 
            </li>
            <hr />
            <li className="header-navbar__link">
              <NavLink to='/info' activeClassName='current'>Инфо</NavLink>
            </li>
            <hr />
            <li className="header-navbar__link">
              <NavLink to='/products' activeClassName='current'>Продукция</NavLink>
            </li>
          </ul>
        </div>
        <div className="section">
          <Switch>
            <Route path='/info' exact render={() => {
              return <Info newPos={(value) => this.setState(value)} animation={(value) => this.animation(value)}/>
            }} />
            <Route path='/products/:link' exact render={() => {
              return <ProductInfo data={this.state.currentProdactInfo}/>
            }} />
            <Route path='/products' exact render={() => {
              return <Products newPos={(value) => this.setState(value)} animation={(value) => this.animation(value)} forProductInfo={(value) => this.forProductInfo(value)}/>
            }} />
            <Route path='/' exact render={() => {
              return <Home newPos={(value) => this.setState(value)} animation={(value) => this.animation(value)}/>
            }} />
            <Route component={NotFoundPage} />
          </Switch>
        </div>
      </div>
    )
  }
}

export default App;

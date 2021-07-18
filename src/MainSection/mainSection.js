import { Route, Switch } from 'react-router-dom'
import Home from '../Home/home'
import Category from '../Category/category'
import NotFoundPage from '../NotFoundPage/NotFoundPage'
import Recipe from '../Recipe/recipe'
import './mainSection.scss'


function MainSection({registred}) {
    return (
        <section  className="mainSection">
            <div className="container">
                <Switch >
                    <Route path='/' exact component={Home}/>
                    <Route path='/category/:name' exact component={Category}/>
                    <Route path='/meal/:id' exact render={() => <Recipe registred={registred}/>} />
                    <Route component={NotFoundPage} />
                </Switch>
            </div>
        </section>
    )
}

export default MainSection